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

        $boardingHouseIds = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $roomIds = Room::whereIn('boarding_house_id', $boardingHouseIds)->pluck('id');

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
        
        $availableYears = array_slice($availableYears, 0, 2);
        sort($availableYears);

        $currentYear = $request->query('year', date('Y'));
        $chartIncome = array_fill(0, 12, 0);
        $chartExpense = array_fill(0, 12, 0);

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = \Carbon\Carbon::create($currentYear, $month, 1)->startOfMonth();
            $months[] = $startOfMonth->translatedFormat('M');
        }

        $tenantsIncomeThisYear = Tenant::whereIn('room_id', $roomIds)
            ->whereYear('start_date', $currentYear)
            ->withSum('payments', 'amount')
            ->get(['id', 'room_id', 'start_date']);

        foreach ($tenantsIncomeThisYear as $tenant) {
            $monthIndex = (int) \Carbon\Carbon::parse($tenant->start_date)->format('n') - 1;
            $chartIncome[$monthIndex] += $tenant->payments_sum_amount ?: 0;
        }

        $expenseTenantsThisYear = Tenant::whereIn('room_id', $roomIds)
            ->whereYear('start_date', $currentYear)
            ->whereHas('payments', function ($query) {
                $query->whereIn('status', ['successful', 'waiting']);
            })
            ->get(['id', 'room_id', 'start_date']);

        $monthlyOccupiedRooms = array_fill(0, 12, []);
        foreach ($expenseTenantsThisYear as $tenant) {
            $monthIndex = (int) \Carbon\Carbon::parse($tenant->start_date)->format('n') - 1;
            $monthlyOccupiedRooms[$monthIndex][] = $tenant->room_id;
        }

        $roomExpenses = \App\Models\Room::whereIn('id', $roomIds)->pluck('monthly_expense', 'id');

        for ($i = 0; $i < 12; $i++) {
            $uniqueRoomIds = array_unique($monthlyOccupiedRooms[$i]);
            $expense = 0;
            foreach ($uniqueRoomIds as $rId) {
                $expense += $roomExpenses[$rId] ?? 0;
            }
            $chartExpense[$i] = $expense;
        }

        $totalIncome = array_sum($chartIncome);
        $totalExpense = array_sum($chartExpense);

        $reviewsQuery = \App\Models\BoardingHouseReview::whereIn('boarding_house_id', $boardingHouseIds);
        $totalReviews = $reviewsQuery->count();
        $avgRating = $totalReviews > 0 ? $reviewsQuery->avg('rating') : 0;

        $totalRooms = \App\Models\Room::whereIn('id', $roomIds)->count();
        $availableRooms = \App\Models\Room::whereIn('id', $roomIds)->where('available', true)->count();
        $occupiedRooms = $totalRooms - $availableRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $bestSellingRoom = \App\Models\Room::whereIn('id', $roomIds)
            ->withCount('tenants')
            ->orderBy('tenants_count', 'desc')
            ->first();

        $topRooms = \App\Models\Room::whereIn('id', $roomIds)
            ->with(['boardingHouse'])
            ->withCount('tenants')
            ->orderBy('tenants_count', 'desc')
            ->take(5)
            ->get();

        $chartRoomNames = $topRooms->map(function ($room) {
            $kostName = $room->boardingHouse ? $room->boardingHouse->name : 'Kost';
            return $kostName . ' - ' . $room->room_name;
        })->toArray();
        $chartRoomCounts = $topRooms->pluck('tenants_count')->toArray();

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
            'occupancyRate',
            'bestSellingRoom',
            'chartRoomNames',
            'chartRoomCounts'
        ));
    }

    public function kamar(Request $request, $id)
    {
        $kost = \App\Models\BoardingHouse::findOrFail($id);
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $query = \App\Models\Room::with(['tenants' => function($q) {
            $q->latest();
        }, 'tenants.user'])->where('boarding_house_id', $id);

        if ($search) {
            $query->where('room_name', 'LIKE', '%' . $search . '%');
        }

        if ($statusFilter === 'tersedia') {
            $query->where('available', true);
        } elseif ($statusFilter === 'terisi') {
            $query->where('available', false);
        }

        $rooms = $query->orderByRaw('LENGTH(room_name) ASC')
            ->orderBy('room_name', 'asc')
            ->paginate(8)
            ->withQueryString();

        $totalRooms = \App\Models\Room::where('boarding_house_id', $id)->count();
        $availableRooms = \App\Models\Room::where('boarding_house_id', $id)->where('available', true)->count();
        $occupiedRooms = $totalRooms - $availableRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        return view('pemilik.kamar', compact('kost', 'rooms', 'totalRooms', 'availableRooms', 'occupiedRooms', 'occupancyRate', 'statusFilter', 'search'));
    }

    public function penyewa(Request $request)
    {
        $ownerId = auth()->id();
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        $boardingHouseIds = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $roomIds = Room::whereIn('boarding_house_id', $boardingHouseIds)->pluck('id');

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
        $rooms = \App\Models\Room::whereIn('boarding_house_id', $kosts)->where('available', true)->get(['id', 'room_name', 'room_type', 'daily_price', 'weekly_price', 'monthly_price']);

        $users = \App\Models\User::where('role', 'tenant')
            ->with('userDetail:user_id,gender,birth_date,occupation,institution')
            ->get(['id', 'name', 'email']);

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
            ->whereHas('room', fn($q) => $q->whereIn('boarding_house_id', $kosts))
            ->findOrFail($id);

        $rooms = \App\Models\Room::whereIn('boarding_house_id', $kosts)->get();
        $users = \App\Models\User::where('role', 'tenant')->with('userDetail:user_id,gender,birth_date,occupation,institution')->get(['id', 'name', 'email']);

        return view('pemilik.edit-penyewa', compact('tenant', 'rooms', 'users'));
    }

    public function updatePenyewa(Request $request, $id)
    {
        $ownerId = auth()->id();
        $kostIds = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $tenant = \App\Models\Tenant::whereHas('room', fn($q) => $q->whereIn('boarding_house_id', $kostIds))
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
        $kostIds = \App\Models\BoardingHouse::where('owner_id', $ownerId)->pluck('id');
        $tenant = \App\Models\Tenant::whereHas('room', fn($q) => $q->whereIn('boarding_house_id', $kostIds))
            ->findOrFail($id);

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
        $request->validate([
            'room_name'       => 'required|string|max:255',
            'room_type'       => 'required|string|max:255',
            'room_size'       => 'required|string|max:50',
            'facilities'      => 'required|array|min:1',
            'monthly_price'   => 'required',
            'monthly_expense' => 'nullable',
            'daily_price'     => 'nullable',
            'weekly_price'    => 'nullable',
            'main_image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'other_image_1'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'room_name.required'     => 'Nama kamar wajib diisi.',
            'room_type.required'     => 'Tipe kamar wajib diisi.',
            'room_size.required'     => 'Ukuran kamar wajib diisi.',
            'facilities.required'    => 'Fasilitas wajib di isi.',
            'monthly_price.required' => 'Harga bulanan wajib diisi.',
            'main_image.required'    => 'Foto utama kamar wajib diunggah.',
            'main_image.image'       => 'Foto utama harus berupa file gambar.',
        ]);

        $sanitizePrice = fn($val) => (int) preg_replace('/[^\d]/', '', $val ?? '0');

        $data = [
            'boarding_house_id' => $id,
            'room_name'         => $request->room_name,
            'room_type'         => $request->room_type,
            'room_size'         => $request->room_size,
            'facilities'        => $request->facilities,
            'daily_price'       => $sanitizePrice($request->daily_price),
            'weekly_price'      => $sanitizePrice($request->weekly_price),
            'monthly_price'     => $sanitizePrice($request->monthly_price),
            'monthly_expense'   => $sanitizePrice($request->monthly_expense),
            'available'         => $request->has('available') ? true : false,
        ];

        $room = \App\Models\Room::create($data);

        $storageDir = 'boarding_house_' . $id;

        if ($request->hasFile('main_image')) {
            $file     = $request->file('main_image');
            $filename = 'foto_kamar_utama_' . $room->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $room->main_image = 'storage/' . $storageDir . '/' . $filename;
            $room->save();
        }

        $otherImages = [];
        if ($request->hasFile('other_image_1')) {
            $file     = $request->file('other_image_1');
            $filename = 'foto_kamar_tambahan_1_' . $room->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $otherImages[0] = 'storage/' . $storageDir . '/' . $filename;
        } else {
            $otherImages[0] = null;
        }

        if ($request->hasFile('other_image_2')) {
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename      = 'foto_kamar_tambahan_2_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other2Paths[] = 'storage/' . $storageDir . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        } else {
            $otherImages[1] = null;
        }

        if ($request->hasFile('other_image_3')) {
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename      = 'foto_kamar_tambahan_3_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other3Paths[] = 'storage/' . $storageDir . '/' . $filename;
            }
            $otherImages[2] = $other3Paths;
        } else {
            $otherImages[2] = null;
        }

        $room->other_images = json_encode($otherImages);
        $room->save();

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
        $request->validate([
            'room_name'       => 'required|string|max:255',
            'room_type'       => 'required|string|max:255',
            'room_size'       => 'required|string|max:50',
            'facilities'      => 'required|array|min:1',
            'monthly_price'   => 'required',
            'monthly_expense' => 'nullable',
            'daily_price'     => 'nullable',
            'weekly_price'    => 'nullable',
            'main_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'other_image_1'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'room_name.required'     => 'Nama kamar wajib diisi.',
            'room_type.required'     => 'Tipe kamar wajib diisi.',
            'room_size.required'     => 'Ukuran kamar wajib diisi.',
            'facilities.required'    => 'Fasilitas wajib di isi.',
            'monthly_price.required' => 'Harga bulanan wajib diisi.',
        ]);

        $kost           = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);
        $room           = \App\Models\Room::where('boarding_house_id', $id)->findOrFail($roomId);
        $boardingHouseId = $id;

        $sanitizePrice = fn($val) => (int) preg_replace('/[^\d]/', '', $val ?? '0');

        $data = [
            'room_name'       => $request->room_name,
            'room_type'       => $request->room_type,
            'room_size'       => $request->room_size,
            'facilities'      => $request->facilities,
            'daily_price'     => $sanitizePrice($request->daily_price),
            'weekly_price'    => $sanitizePrice($request->weekly_price),
            'monthly_price'   => $sanitizePrice($request->monthly_price),
            'monthly_expense' => $sanitizePrice($request->monthly_expense),
            'available'       => $request->has('available') ? true : false,
        ];

        $storageDir   = 'boarding_house_' . $id;
        $deleteStorage = function($path) {
            if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }
        };
        $toStoragePath = fn($dbPath) => $dbPath ? preg_replace('#^storage/#', '', $dbPath) : null;

        if ($request->has('remove_main_image')) {
            if (!$this->isImageUsedByOtherRooms($room->main_image, $room->id)) {
                $deleteStorage($toStoragePath($room->main_image));
            }
            $data['main_image'] = null;
        }

        if ($request->hasFile('main_image')) {
            if (!$this->isImageUsedByOtherRooms($room->main_image, $room->id)) {
                $deleteStorage($toStoragePath($room->main_image));
            }
            $file              = $request->file('main_image');
            $filename          = 'foto_kamar_utama_' . $room->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $data['main_image'] = 'storage/' . $storageDir . '/' . $filename;
        }

        $oldImages   = $room->other_images ? json_decode($room->other_images, true) : [];
        $otherImages = [
            $oldImages[0] ?? null,
            $oldImages[1] ?? null,
            $oldImages[2] ?? null,
        ];

        if ($request->has('remove_other_image_1')) {
            if (!empty($otherImages[0]) && is_string($otherImages[0])) {
                if (!$this->isImageUsedByOtherRooms($otherImages[0], $room->id)) {
                    $deleteStorage($toStoragePath($otherImages[0]));
                }
            }
            $otherImages[0] = null;
        }

        if ($request->hasFile('other_image_1')) {
            if (!empty($otherImages[0]) && is_string($otherImages[0])) {
                if (!$this->isImageUsedByOtherRooms($otherImages[0], $room->id)) {
                    $deleteStorage($toStoragePath($otherImages[0]));
                }
            }
            $file           = $request->file('other_image_1');
            $filename       = 'foto_kamar_tambahan_1_' . $room->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $otherImages[0] = 'storage/' . $storageDir . '/' . $filename;
        }

        if ($request->has('remove_other_image_2')) {
            if (!empty($otherImages[1])) {
                $imgs = is_array($otherImages[1]) ? $otherImages[1] : [$otherImages[1]];
                foreach ($imgs as $oldImg) {
                    if (!$this->isImageUsedByOtherRooms($oldImg, $room->id)) {
                        $deleteStorage($toStoragePath($oldImg));
                    }
                }
            }
            $otherImages[1] = null;
        }

        if ($request->hasFile('other_image_2')) {
            if (!empty($otherImages[1])) {
                $imgs = is_array($otherImages[1]) ? $otherImages[1] : [$otherImages[1]];
                foreach ($imgs as $oldImg) {
                    if (!$this->isImageUsedByOtherRooms($oldImg, $room->id)) {
                        $deleteStorage($toStoragePath($oldImg));
                    }
                }
            }
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename      = 'foto_kamar_tambahan_2_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other2Paths[] = 'storage/' . $storageDir . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        }

        if ($request->has('remove_other_image_3')) {
            if (!empty($otherImages[2])) {
                $imgs = is_array($otherImages[2]) ? $otherImages[2] : [$otherImages[2]];
                foreach ($imgs as $oldImg) {
                    if (!$this->isImageUsedByOtherRooms($oldImg, $room->id)) {
                        $deleteStorage($toStoragePath($oldImg));
                    }
                }
            }
            $otherImages[2] = null;
        }

        if ($request->hasFile('other_image_3')) {
            if (!empty($otherImages[2])) {
                $imgs = is_array($otherImages[2]) ? $otherImages[2] : [$otherImages[2]];
                foreach ($imgs as $oldImg) {
                    if (!$this->isImageUsedByOtherRooms($oldImg, $room->id)) {
                        $deleteStorage($toStoragePath($oldImg));
                    }
                }
            }
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename      = 'foto_kamar_tambahan_3_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other3Paths[] = 'storage/' . $storageDir . '/' . $filename;
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

        $deleteStorage = function($dbPath) {
            if (!$dbPath) return;
            $storagePath = preg_replace('#^storage/#', '', $dbPath);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($storagePath);
            }
        };

        if ($room->main_image && !$this->isImageUsedByOtherRooms($room->main_image, $room->id)) {
            $deleteStorage($room->main_image);
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
                if ($img && !$this->isImageUsedByOtherRooms($img, $room->id)) {
                    $deleteStorage($img);
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

        $kosts = $query->paginate(8)->withQueryString();

        $boardingHouseIds = \App\Models\BoardingHouse::where('owner_id', auth()->id())->pluck('id');
        $totalRooms = \App\Models\Room::whereIn('boarding_house_id', $boardingHouseIds)->count();
        $availableRooms = \App\Models\Room::whereIn('boarding_house_id', $boardingHouseIds)->where('available', true)->count();
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
        $request->validate([
            'boarding_house_name' => 'required|string|max:255',
            'area'                => 'required|string',
            'alamat'              => 'required|string',
            'facilities'          => 'required|array|min:1',
            'description'         => 'nullable|string',
            'house_rule'          => 'nullable|string',
            'main_image'          => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'other_image_1'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'facilities.required' => 'Fasilitas wajib di isi.',
            'main_image.required' => 'Foto utama kost wajib diunggah.',
            'main_image.image'    => 'Foto utama harus berupa file gambar.',
        ]);

        $type = strtolower($request->boarding_house_type ?? '');
        if (in_array($type, ['putra', 'male'])) {
            $boardingHouseType = 'male';
        } elseif (in_array($type, ['putri', 'female'])) {
            $boardingHouseType = 'female';
        } else {
            $boardingHouseType = 'mixed';
        }

        $data = [
            'owner_id'            => auth()->id(),
            'boarding_house_name' => $request->boarding_house_name,
            'boarding_house_type' => $boardingHouseType,
            'alamat'              => $request->area . ', ' . $request->alamat,
            'latitude'            => $request->latitude ?? 0.0,
            'longitude'           => $request->longitude ?? 0.0,
            'facilities'          => $request->facilities,
            'description'         => $request->description,
            'house_rule'          => $request->house_rule,
        ];

        $kost = \App\Models\BoardingHouse::create($data);

        // Upload files menggunakan Storage disk 'public'
        $storageDir = 'boarding_house_' . $kost->id;

        if ($request->hasFile('main_image')) {
            $file     = $request->file('main_image');
            $filename = 'foto_kost_utama_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $kost->main_image = 'storage/' . $storageDir . '/' . $filename;
            $kost->save();
        }

        $otherImages = [];
        if ($request->hasFile('other_image_1')) {
            $file     = $request->file('other_image_1');
            $filename = 'foto_kost_tambahan_1_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $otherImages[0] = 'storage/' . $storageDir . '/' . $filename;
        } else {
            $otherImages[0] = null;
        }

        if ($request->hasFile('other_image_2')) {
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename      = 'foto_kost_tambahan_2_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other2Paths[] = 'storage/' . $storageDir . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        } else {
            $otherImages[1] = null;
        }

        if ($request->hasFile('other_image_3')) {
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename      = 'foto_kost_tambahan_3_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other3Paths[] = 'storage/' . $storageDir . '/' . $filename;
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
        $request->validate([
            'boarding_house_name' => 'required|string|max:255',
            'area'                => 'required|string',
            'alamat'              => 'required|string',
            'facilities'          => 'required|array|min:1',
            'description'         => 'nullable|string',
            'house_rule'          => 'nullable|string',
            'main_image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'other_image_1'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'facilities.required' => 'Fasilitas wajib di isi.',
        ]);

        $kost = \App\Models\BoardingHouse::where('owner_id', auth()->id())->findOrFail($id);

        $type = strtolower($request->boarding_house_type ?? '');
        if (in_array($type, ['putra', 'male'])) {
            $boardingHouseType = 'male';
        } elseif (in_array($type, ['putri', 'female'])) {
            $boardingHouseType = 'female';
        } else {
            $boardingHouseType = 'mixed';
        }

        $data = [
            'boarding_house_name' => $request->boarding_house_name,
            'boarding_house_type' => $boardingHouseType,
            'alamat'              => $request->area . ', ' . $request->alamat,
            'latitude'            => $request->latitude ?? 0.0,
            'longitude'           => $request->longitude ?? 0.0,
            'facilities'          => $request->facilities,
            'description'         => $request->description,
            'house_rule'          => $request->house_rule,
        ];

        // Upload files menggunakan Storage disk 'public'
        $storageDir   = 'boarding_house_' . $kost->id;
        $deleteStorage = function($path) {
            if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }
        };
        // Helper: ubah path DB (storage/dir/file) → path relatif storage disk (dir/file)
        $toStoragePath = fn($dbPath) => $dbPath ? preg_replace('#^storage/#', '', $dbPath) : null;

        if ($request->has('remove_main_image')) {
            $deleteStorage($toStoragePath($kost->main_image));
            $data['main_image'] = null;
        }

        if ($request->hasFile('main_image')) {
            $deleteStorage($toStoragePath($kost->main_image));
            $file              = $request->file('main_image');
            $filename          = 'foto_kost_utama_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $data['main_image'] = 'storage/' . $storageDir . '/' . $filename;
        }

        $oldImages   = $kost->other_images ? json_decode($kost->other_images, true) : [];
        $otherImages = [
            $oldImages[0] ?? null,
            $oldImages[1] ?? null,
            $oldImages[2] ?? null,
        ];

        if ($request->has('remove_other_image_1')) {
            if (!empty($otherImages[0]) && is_string($otherImages[0])) {
                $deleteStorage($toStoragePath($otherImages[0]));
            }
            $otherImages[0] = null;
        }

        if ($request->hasFile('other_image_1')) {
            if (!empty($otherImages[0]) && is_string($otherImages[0])) {
                $deleteStorage($toStoragePath($otherImages[0]));
            }
            $file           = $request->file('other_image_1');
            $filename       = 'foto_kost_tambahan_1_' . time() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
            $otherImages[0] = 'storage/' . $storageDir . '/' . $filename;
        }

        if ($request->has('remove_other_image_2')) {
            if (!empty($otherImages[1])) {
                $imgs = is_array($otherImages[1]) ? $otherImages[1] : [$otherImages[1]];
                foreach ($imgs as $oldImg) {
                    $deleteStorage($toStoragePath($oldImg));
                }
            }
            $otherImages[1] = null;
        }

        if ($request->hasFile('other_image_2')) {
            if (!empty($otherImages[1])) {
                $imgs = is_array($otherImages[1]) ? $otherImages[1] : [$otherImages[1]];
                foreach ($imgs as $oldImg) {
                    $deleteStorage($toStoragePath($oldImg));
                }
            }
            $other2Paths = [];
            foreach ($request->file('other_image_2') as $idx => $file) {
                $filename      = 'foto_kost_tambahan_2_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other2Paths[] = 'storage/' . $storageDir . '/' . $filename;
            }
            $otherImages[1] = $other2Paths;
        }

        if ($request->has('remove_other_image_3')) {
            if (!empty($otherImages[2])) {
                $imgs = is_array($otherImages[2]) ? $otherImages[2] : [$otherImages[2]];
                foreach ($imgs as $oldImg) {
                    $deleteStorage($toStoragePath($oldImg));
                }
            }
            $otherImages[2] = null;
        }

        if ($request->hasFile('other_image_3')) {
            if (!empty($otherImages[2])) {
                $imgs = is_array($otherImages[2]) ? $otherImages[2] : [$otherImages[2]];
                foreach ($imgs as $oldImg) {
                    $deleteStorage($toStoragePath($oldImg));
                }
            }
            $other3Paths = [];
            foreach ($request->file('other_image_3') as $idx => $file) {
                $filename      = 'foto_kost_tambahan_3_' . $idx . '_' . time() . '.' . $file->getClientOriginalExtension();
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($storageDir, $file, $filename);
                $other3Paths[] = 'storage/' . $storageDir . '/' . $filename;
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
        
        $storageDir = 'boarding_house_' . $kost->id;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storageDir)) {
            \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory($storageDir);
        }
        
        $kost->delete();
        return redirect()->route('pemilik.kost')->with('success', 'Data Properti Kost berhasil dihapus!');
    }

    private function isImageUsedByOtherRooms($imagePath, $rId)
    {
        if (!$imagePath) return false;
        return \App\Models\Room::where('id', '!=', $rId)->where(function($q) use ($imagePath) {
            $q->where('main_image', $imagePath)
              ->orWhere('other_images', 'LIKE', '%"'. $imagePath .'"%');
        })->exists();
    }
}
