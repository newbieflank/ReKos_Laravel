<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class PemilikKosController extends Controller
{
    public function dashboard(Request $request)
    {
        $ownerId = auth()->id();

        $roomIds = Room::whereHas('boardingHouse', function ($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        })->pluck('id');

        $months = [];
        $chartIncome = [];
        $chartExpense = [];

        $availableYears = Tenant::whereIn('room_id', $roomIds)
            ->whereNotNull('start_date')
            ->selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
            
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }
        
        // Ensure max 2 years are shown
        $availableYears = array_slice($availableYears, 0, 2);
        sort($availableYears);

        $currentYear = $request->query('year', date('Y'));
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = \Carbon\Carbon::create($currentYear, $month, 1)->startOfMonth();
            $endOfMonth = \Carbon\Carbon::create($currentYear, $month, 1)->endOfMonth();

            $months[] = $startOfMonth->translatedFormat('M');

            $income = Tenant::whereIn('room_id', $roomIds)
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $month)
                ->withSum('payments', 'amount')
                ->get()
                ->sum('payments_sum_amount');

            $chartIncome[] = $income ?: 0;

            $occupiedRoomIdsThisMonth = Tenant::whereIn('room_id', $roomIds)
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $month)
                ->whereHas('payments', function ($query) {
                    $query->whereIn('status', ['successful', 'waiting']);
                })
                ->pluck('room_id')
                ->unique()
                ->values();

            $expense = \App\Models\Room::whereIn('id', $occupiedRoomIdsThisMonth)->sum('monthly_expense');
            $chartExpense[] = $expense ?: 0;
        }

        $totalIncome = array_sum($chartIncome);
        $totalExpense = array_sum($chartExpense);

        $boardingHouseIds = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $reviewsQuery = \App\Models\BoardingHouseReview::whereIn('boarding_house_id', $boardingHouseIds);
        $totalReviews = $reviewsQuery->count();
        $avgRating = $totalReviews > 0 ? $reviewsQuery->avg('rating') : 0;

        // Okupansi Keseluruhan
        $totalRooms = \App\Models\Room::whereIn('id', $roomIds)->count();
        $availableRooms = \App\Models\Room::whereIn('id', $roomIds)->where('available', true)->count();
        $occupiedRooms = $totalRooms - $availableRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        return view('pemilik.dashboard', compact(
            'months',
            'chartIncome',
            'chartExpense',
            'totalIncome',
            'totalExpense',
            'currentYear',
            'availableYears',
            'avgRating',
            'totalReviews',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'occupancyRate'
        ));
    }

    public function kamar($id)
    {
        $kost = \App\Models\BoardingHouse::findOrFail($id);
        $rooms = \App\Models\Room::where('boarding_house_id', $id)->get();

        // Statistik Okupansi Properti Ini
        $totalRooms = $rooms->count();
        $availableRooms = $rooms->where('available', true)->count();
        $occupiedRooms = $totalRooms - $availableRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        return view('pemilik.kamar', compact('kost', 'rooms', 'totalRooms', 'availableRooms', 'occupiedRooms', 'occupancyRate'));
    }

    public function penyewa(Request $request)
    {
        $ownerId = auth()->id();
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $roomIds = Room::whereHas('boardingHouse', function ($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        })->pluck('id');

        $query = Tenant::whereIn('room_id', $roomIds)
            ->with(['user', 'user.userDetail', 'room', 'room.boardingHouse'])->withCount(['payments as has_paid' => function ($q) {
                $q->where('status', 'successful');
            }])
            ->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'LIKE', '%' . $search . '%');
                })->orWhereHas('room', function($q3) use ($search) {
                    $q3->where('room_name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        if ($statusFilter && in_array($statusFilter, ['active', 'pending', 'complete', 'cancelled'])) {
            $query->where('status', $statusFilter);
        }

        $tenants = $query->paginate(15)->withQueryString();

        return view('pemilik.penyewa', compact('tenants', 'statusFilter', 'search'));
    }

    public function tambahPenyewa(Request $request)
    {
        $ownerId = auth()->id();
        $kosts = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $rooms = \App\Models\Room::whereIn('boarding_house_id', $kosts)->where('available', true)->get();

        // Ambil semua user dengan role tenant beserta data detail
        $users = \App\Models\User::where('role', 'tenant')
            ->with('userDetail')
            ->get();

        $selectedRoomId = $request->query('room_id');

        return view('pemilik.tambah-penyewa', compact('rooms', 'users', 'selectedRoomId'));
    }

    public function simpanPenyewa(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rental_type' => 'required|in:daily,weekly,monthly',
            'status_sewa' => 'required|in:active,pending',
            'total_price' => 'nullable|numeric',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'occupation' => 'nullable|string',
            'institution' => 'nullable|string',
        ]);

        $userDetail = \App\Models\UserDetail::firstOrCreate(['user_id' => $data['tenant_id']]);
        $userDetail->update([
            'gender' => $data['gender'] ?? 'unknown',
            'birth_date' => $data['birth_date'] ?? null,
            'occupation' => $data['occupation'] ?? null,
            'institution' => $data['institution'] ?? null,
        ]);

        $durationMap = ['daily' => 1, 'weekly' => 7, 'monthly' => 30];
        $duration = $durationMap[$data['rental_type']] ?? 1;

        \App\Models\Tenant::create([
            'tenant_id' => $data['tenant_id'],
            'room_id' => $data['room_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'duration' => $duration,
            'rental_type' => $data['rental_type'],
            'total_price' => $data['total_price'] ?? 0,
            'status' => $data['status_sewa'],
        ]);

        if ($data['status_sewa'] === 'active') {
            $room = \App\Models\Room::find($data['room_id']);
            if ($room) {
                $room->update(['available' => false]);
            }
        }

        return redirect()->route('pemilik.penyewa')->with('success', 'Data penyewa berhasil disimpan!');
    }

    public function editPenyewa($id)
    {
        $ownerId = auth()->id();
        $kosts = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $tenant = \App\Models\Tenant::with(['user', 'user.userDetail', 'room'])
            ->whereHas('room.boardingHouse', fn($q) => $q->where('owner_id', $ownerId))
            ->findOrFail($id);

        $rooms = \App\Models\Room::whereIn('boarding_house_id', $kosts)->get();
        $users = \App\Models\User::where('role', 'tenant')->with('userDetail')->get();

        return view('pemilik.edit-penyewa', compact('tenant', 'rooms', 'users'));
    }

    public function updatePenyewa(Request $request, $id)
    {
        $ownerId = auth()->id();
        $tenant = \App\Models\Tenant::whereHas('room.boardingHouse', fn($q) => $q->where('owner_id', $ownerId))
            ->findOrFail($id);

        $data = $request->validate([
            'room_id'      => 'required|exists:rooms,id',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date',
            'rental_type'  => 'required|in:daily,weekly,monthly',
            'status'       => 'required|in:active,pending,complete,cancelled',
            'total_price'  => 'nullable|numeric',
        ]);

        $oldRoomId = $tenant->room_id;
        $newStatus = $data['status'];

        $tenant->update($data);

        if ($oldRoomId != $data['room_id']) {
            \App\Models\Room::find($oldRoomId)?->update(['available' => true]);
        }
        if (in_array($newStatus, ['active'])) {
            \App\Models\Room::find($data['room_id'])?->update(['available' => false]);
        } elseif (in_array($newStatus, ['complete', 'cancelled'])) {
            \App\Models\Room::find($data['room_id'])?->update(['available' => true]);
        }

        return redirect()->route('pemilik.penyewa')->with('success', 'Data penyewa berhasil diperbarui!');
    }

    public function hapusPenyewa($id)
    {
        $ownerId = auth()->id();
        $tenant = \App\Models\Tenant::whereHas('room.boardingHouse', fn($q) => $q->where('owner_id', $ownerId))
            ->findOrFail($id);

        // Kembalikan kamar jadi available
        $tenant->room?->update(['available' => true]);
        $tenant->delete();

        return redirect()->route('pemilik.penyewa')->with('success', 'Data penyewa berhasil dihapus!');
    }

    public function tambahKamar($id)
    {
        $kost = \App\Models\BoardingHouse::findOrFail($id);
        return view('pemilik.tambah-kamar', compact('kost'));
    }

    public function simpanKamar(Request $request, $id)
    {
        $data = $request->all();
        $data['boarding_house_id'] = $id;
        // Asumsi form tidak mengirimkan checkbox jika false
        if (!$request->has('available')) {
            $data['available'] = false;
        } else {
            $data['available'] = true;
        }

        $room = \App\Models\Room::create($data);

        // Upload files
        $path = public_path('image/boarding_house_' . $id);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'foto_kamar_utama_' . $room->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $room->main_image = 'image/boarding_house_' . $id . '/' . $filename;
            $room->save();
        }

        $otherImages = [];
        if ($request->hasFile("other_image_1")) {
            $file = $request->file("other_image_1");
            $filename = "foto_kamar_tambahan_1_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $otherImages[0] = 'image/boarding_house_' . $id . '/' . $filename;
        } else {
            $otherImages[0] = null;
        }

        if ($request->hasFile("other_image_2")) {
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename = "foto_kamar_tambahan_2_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other2Paths[] = 'image/boarding_house_' . $id . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        } else {
            $otherImages[1] = null;
        }
        
        if ($request->hasFile("other_image_3")) {
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename = "foto_kamar_tambahan_3_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other3Paths[] = 'image/boarding_house_' . $id . '/' . $filename;
            }
            $otherImages[2] = $other3Paths;
        } else {
            $otherImages[2] = null;
        }
        $room->other_images = json_encode($otherImages);    $room->save();

        return redirect()->route('pemilik.kamar', $id)->with('success', 'Data kamar baru berhasil ditambahkan!');
    }

    public function editKamar($id, $roomId)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        $room = \App\Models\Room::where('boarding_house_id', $id)->findOrFail($roomId);
        return view('pemilik.edit-kamar', compact('kost', 'room'));
    }

    public function updateKamar(Request $request, $id, $roomId)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        $room = \App\Models\Room::where('boarding_house_id', $id)->findOrFail($roomId);
        $boardingHouseId = $id;

        $checkImageUsed = function($imagePath, $rId) {
            if (!$imagePath) return false;
            return \App\Models\Room::where('id', '!=', $rId)->where(function($q) use ($imagePath) {
                $q->where('main_image', $imagePath)
                  ->orWhere('other_images', 'LIKE', '%"'. $imagePath .'"%');
            })->exists();
        };

        $data = $request->all();
        if (!$request->has('available')) {
            $data['available'] = false;
        } else {
            $data['available'] = true;
        }

        // Upload files
        $path = public_path('image/boarding_house_' . $id);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->has('remove_main_image')) {
            if ($room->main_image && file_exists(public_path($room->main_image))) {
                if (!$checkImageUsed($room->main_image, $room->id)) {
                    @unlink(public_path($room->main_image));
                }
            }
            $data['main_image'] = null;
        }

        if ($request->hasFile('main_image')) {
            if ($room->main_image && file_exists(public_path($room->main_image))) {
                if (!$checkImageUsed($room->main_image, $room->id)) {
                    @unlink(public_path($room->main_image));
                }
            }
            $file = $request->file('main_image');
            $filename = 'foto_kamar_utama_' . $room->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $data['main_image'] = 'image/boarding_house_' . $id . '/' . $filename;
        }

        $oldImages = $room->other_images ? json_decode($room->other_images, true) : [];
        $otherImages = [
            $oldImages[0] ?? null,
            $oldImages[1] ?? null,
            $oldImages[2] ?? null,
        ];

        if ($request->has("remove_other_image_1")) {
            if (!empty($otherImages[0]) && is_string($otherImages[0]) && file_exists(public_path($otherImages[0]))) {
                if (!$checkImageUsed($otherImages[0], $room->id)) {
                    @unlink(public_path($otherImages[0]));
                }
            }
            $otherImages[0] = null;
        }

        if ($request->hasFile("other_image_1")) {
            if (!empty($otherImages[0]) && is_string($otherImages[0]) && file_exists(public_path($otherImages[0]))) {
                if (!$checkImageUsed($otherImages[0], $room->id)) {
                    @unlink(public_path($otherImages[0]));
                }
            }
            $file = $request->file("other_image_1");
            $filename = "foto_kamar_tambahan_1_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $otherImages[0] = 'image/boarding_house_' . $boardingHouseId . '/' . $filename;
        }

        if ($request->has("remove_other_image_2")) {
            if (!empty($otherImages[1])) {
                if (is_array($otherImages[1])) {
                    foreach ($otherImages[1] as $oldImg) {
                        if (file_exists(public_path($oldImg))) {
                            if (!$checkImageUsed($oldImg, $room->id)) @unlink(public_path($oldImg));
                        }
                    }
                } else {
                    if (file_exists(public_path($otherImages[1]))) {
                        if (!$checkImageUsed($otherImages[1], $room->id)) @unlink(public_path($otherImages[1]));
                    }
                }
            }
            $otherImages[1] = null;
        }
        
        if ($request->hasFile("other_image_2")) {
            if (!empty($otherImages[1])) {
                if (is_array($otherImages[1])) {
                    foreach ($otherImages[1] as $oldImg) {
                        if (file_exists(public_path($oldImg))) {
                            if (!$checkImageUsed($oldImg, $room->id)) @unlink(public_path($oldImg));
                        }
                    }
                } else {
                    if (file_exists(public_path($otherImages[1]))) {
                        if (!$checkImageUsed($otherImages[1], $room->id)) @unlink(public_path($otherImages[1]));
                    }
                }
            }
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename = "foto_kamar_tambahan_2_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other2Paths[] = 'image/boarding_house_' . $boardingHouseId . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        }
        
        if ($request->hasFile("other_image_3")) {
            if (!empty($otherImages[2])) {
                if (is_array($otherImages[2])) {
                    foreach ($otherImages[2] as $oldImg) {
                        if (file_exists(public_path($oldImg))) {
                            if (!$checkImageUsed($oldImg, $room->id)) @unlink(public_path($oldImg));
                        }
                    }
                } else {
                    if (file_exists(public_path($otherImages[2]))) {
                        if (!$checkImageUsed($otherImages[2], $room->id)) @unlink(public_path($otherImages[2]));
                    }
                }
            }
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename = "foto_kamar_tambahan_3_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other3Paths[] = 'image/boarding_house_' . $boardingHouseId . '/' . $filename;
            }
            $otherImages[2] = $other3Paths;
        }
        $data['other_images'] = json_encode($otherImages);

        $room->update($data);
        return redirect()->route('pemilik.kamar', $id)->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function hapusKamar($id, $roomId)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        $room = \App\Models\Room::where('boarding_house_id', $id)->findOrFail($roomId);
        
        $checkImageUsed = function($imagePath, $rId) {
            if (!$imagePath) return false;
            return \App\Models\Room::where('id', '!=', $rId)->where(function($q) use ($imagePath) {
                $q->where('main_image', $imagePath)
                  ->orWhere('other_images', 'LIKE', '%"'. $imagePath .'"%');
            })->exists();
        };

        if ($room->main_image && file_exists(public_path($room->main_image))) {
            if (!$checkImageUsed($room->main_image, $room->id)) {
                @unlink(public_path($room->main_image));
            }
        }
        
        if ($room->other_images) {
            $otherImages = json_decode($room->other_images, true) ?? [];
            
            $collectImages = function($items) use (&$collectImages) {
                $result = [];
                foreach ($items as $item) {
                    if (is_array($item)) {
                        $result = array_merge($result, $collectImages($item));
                    } elseif (is_string($item) && $item) {
                        $result[] = $item;
                    }
                }
                return $result;
            };
            
            $flatImages = $collectImages($otherImages);
            foreach ($flatImages as $img) {
                if ($img && file_exists(public_path($img))) {
                    if (!$checkImageUsed($img, $room->id)) {
                        @unlink(public_path($img));
                    }
                }
            }
        }
        
        $room->delete();
        return redirect()->route('pemilik.kamar', $id)->with('success', 'Data kamar berhasil dihapus!');
    }

    public function duplicateKamar(Request $request, $id, $roomId)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        $room = \App\Models\Room::where('boarding_house_id', $id)->findOrFail($roomId);

        $quantity = max(1, (int) $request->input('quantity', 1));

        for ($i = 0; $i < $quantity; $i++) {
            $newRoom = $room->replicate();

            if (preg_match('/(.*?)\s*(\d+)$/', $room->room_name, $matches)) {
                $baseName = rtrim($matches[1]);
                $number = intval($matches[2]) + 1;
                $checkName = $baseName . ' ' . $number;
                while (\App\Models\Room::where('boarding_house_id', $id)->where('room_name', $checkName)->exists()) {
                    $number++;
                    $checkName = $baseName . ' ' . $number;
                }
                $newRoom->room_name = $checkName;
                $room->room_name = $checkName;
            } else {
                $baseName = trim($room->room_name);
                $number = 2;
                $checkName = $baseName . ' ' . $number;
                while (\App\Models\Room::where('boarding_house_id', $id)->where('room_name', $checkName)->exists()) {
                    $number++;
                    $checkName = $baseName . ' ' . $number;
                }
                $newRoom->room_name = $checkName;
                $room->room_name = $checkName;
            }

            $newRoom->available = true; 
            $newRoom->save();
        }

        return redirect()->route('pemilik.kamar', $id)->with('success', 'Data kamar berhasil diduplikasi sebanyak ' . $quantity . ' kali.');
    }

    public function kost(Request $request)
    {
        $filter = $request->query('filter'); 

        $query = \App\Models\BoardingHouse::withCount([
            'rooms',
            'rooms as occupied_rooms_count' => fn($q) => $q->where('available', false),
            'rooms as available_rooms_count' => fn($q) => $q->where('available', true),
        ])->where('owner_id', auth()->id());

        if ($filter === 'tersedia') {
            $query->whereHas('rooms', fn($q) => $q->where('available', true));
        } elseif ($filter === 'penuh') {
            $query->whereDoesntHave('rooms', fn($q) => $q->where('available', true));
        }

        $kosts = $query->get();

        $totalRooms = \App\Models\Room::whereHas('boardingHouse', function ($q) {
            $q->where('owner_id', auth()->id());
        })->count();
        $availableRooms = \App\Models\Room::whereHas('boardingHouse', function ($q) {
            $q->where('owner_id', auth()->id());
        })->where('available', true)->count();
        $occupiedRooms = $totalRooms - $availableRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
        $totalKosts = $kosts->count();

        return view('pemilik.kost', compact('kosts', 'filter', 'totalRooms', 'availableRooms', 'occupiedRooms', 'occupancyRate', 'totalKosts'));
    }

    public function tambahKost()
    {
        return view('pemilik.tambah-kost');
    }

    public function simpanKost(Request $request)
    {
        $data = $request->all();
        $data['owner_id'] = auth()->id();
        $data['latitude'] = $request->latitude ?? 0.0;
        $data['longitude'] = $request->longitude ?? 0.0;

        $type = strtolower($request->boarding_house_type ?? '');
        if (in_array($type, ['putra', 'male'])) {
            $data['boarding_house_type'] = 'male';
        } elseif (in_array($type, ['putri', 'female'])) {
            $data['boarding_house_type'] = 'female';
        } else {
            $data['boarding_house_type'] = 'mixed';
        }

        $kost = \App\Models\BoardingHouse::create($data);

        // Upload files
        $path = public_path('image/boarding_house_' . $kost->id);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'foto_kost_utama_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $kost->main_image = 'image/boarding_house_' . $kost->id . '/' . $filename;
            $kost->save();
        }

        $otherImages = [];
        if ($request->hasFile("other_image_1")) {
            $file = $request->file("other_image_1");
            $filename = "foto_kost_tambahan_1_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $otherImages[0] = 'image/boarding_house_' . $kost->id . '/' . $filename;
        } else {
            $otherImages[0] = null;
        }

        if ($request->hasFile("other_image_2")) {
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename = "foto_kost_tambahan_2_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other2Paths[] = 'image/boarding_house_' . $kost->id . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        } else {
            $otherImages[1] = null;
        }
        
        if ($request->hasFile("other_image_3")) {
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename = "foto_kost_tambahan_3_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other3Paths[] = 'image/boarding_house_' . $kost->id . '/' . $filename;
            }
            $otherImages[2] = $other3Paths;
        } else {
            $otherImages[2] = null;
        }
        $kost->other_images = json_encode($otherImages);
        $kost->save();

        return redirect()->route('pemilik.kost')->with('success', 'Data Properti Kost berhasil ditambahkan!');
    }

    public function editKost($id)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        return view('pemilik.edit-kost', compact('kost'));
    }

    public function updateKost(Request $request, $id)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        $data = $request->all();

        $type = strtolower($request->boarding_house_type ?? '');
        if (in_array($type, ['putra', 'male'])) {
            $data['boarding_house_type'] = 'male';
        } elseif (in_array($type, ['putri', 'female'])) {
            $data['boarding_house_type'] = 'female';
        } elseif ($type !== '') {
            $data['boarding_house_type'] = 'mixed';
        }

        // Upload files
        $path = public_path('image/boarding_house_' . $kost->id);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->has('remove_main_image')) {
            if ($kost->main_image && file_exists(public_path($kost->main_image))) {
                @unlink(public_path($kost->main_image));
            }
            $data['main_image'] = null;
        }

        if ($request->hasFile('main_image')) {
            if ($kost->main_image && file_exists(public_path($kost->main_image))) {
                @unlink(public_path($kost->main_image));
            }
            $file = $request->file('main_image');
            $filename = 'foto_kost_utama_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $data['main_image'] = 'image/boarding_house_' . $kost->id . '/' . $filename;
        }

        $oldImages = $kost->other_images ? json_decode($kost->other_images, true) : [];
        $otherImages = [
            $oldImages[0] ?? null,
            $oldImages[1] ?? null,
            $oldImages[2] ?? null,
        ];

        if ($request->has("remove_other_image_1")) {
            if (!empty($otherImages[0]) && is_string($otherImages[0]) && file_exists(public_path($otherImages[0]))) {
                @unlink(public_path($otherImages[0]));
            }
            $otherImages[0] = null;
        }

        if ($request->hasFile("other_image_1")) {
            if (!empty($otherImages[0]) && is_string($otherImages[0]) && file_exists(public_path($otherImages[0]))) {
                @unlink(public_path($otherImages[0]));
            }
            $file = $request->file("other_image_1");
            $filename = "foto_kost_tambahan_1_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $otherImages[0] = 'image/boarding_house_' . $kost->id . '/' . $filename;
        }

        if ($request->has("remove_other_image_2")) {
            if (!empty($otherImages[1])) {
                if (is_array($otherImages[1])) {
                    foreach ($otherImages[1] as $oldImg) {
                        if (file_exists(public_path($oldImg))) @unlink(public_path($oldImg));
                    }
                } else {
                    if (file_exists(public_path($otherImages[1]))) @unlink(public_path($otherImages[1]));
                }
            }
            $otherImages[1] = null;
        }
        
        if ($request->hasFile("other_image_2")) {
            if (!empty($otherImages[1])) {
                if (is_array($otherImages[1])) {
                    foreach ($otherImages[1] as $oldImg) {
                        if (file_exists(public_path($oldImg))) @unlink(public_path($oldImg));
                    }
                } else {
                    if (file_exists(public_path($otherImages[1]))) @unlink(public_path($otherImages[1]));
                }
            }
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename = "foto_kost_tambahan_2_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other2Paths[] = 'image/boarding_house_' . $kost->id . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        }
        
        if ($request->hasFile("other_image_3")) {
            if (!empty($otherImages[2])) {
                if (is_array($otherImages[2])) {
                    foreach ($otherImages[2] as $oldImg) {
                        if (file_exists(public_path($oldImg))) @unlink(public_path($oldImg));
                    }
                } else {
                    if (file_exists(public_path($otherImages[2]))) @unlink(public_path($otherImages[2]));
                }
            }
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename = "foto_kost_tambahan_3_" . $idx . "_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                $other3Paths[] = 'image/boarding_house_' . $kost->id . '/' . $filename;
            }
            $otherImages[2] = $other3Paths;
        }
        $data['other_images'] = json_encode($otherImages);

        $kost->update($data);
        return redirect()->route('pemilik.kost')->with('success', 'Data Properti Kost berhasil diperbarui!');
    }

    public function hapusKost($id)
    {
        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        
        $path = public_path('image/boarding_house_' . $kost->id);
        if (file_exists($path)) {
            \Illuminate\Support\Facades\File::deleteDirectory($path);
        }
        
        $kost->delete();
        return redirect()->route('pemilik.kost')->with('success', 'Data Properti Kost berhasil dihapus!');
    }

    public function simpanPengeluaran(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'expense_date' => 'required|date'
        ]);

        $room = \App\Models\Room::whereHas('boardingHouse', function ($q) {
            $q->where('owner_id', auth()->id());
        })->findOrFail($request->room_id);

        \App\Models\Expense::create([
            'room_id' => $room->id,
            'amount' => $request->amount,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran kamar berhasil dicatat.');
    }
}
