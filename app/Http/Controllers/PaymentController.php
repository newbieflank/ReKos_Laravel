<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function create($id)
    {
        $kos = Room::with('boardingHouse')->findOrFail($id);

        $bookedDates = Tenant::where('room_id', $kos->id)
            ->select('start_date', 'end_date')
            ->get()
            ->map(function ($tenant) {
                return [
                    'start' => $tenant->start_date,
                    'end' => $tenant->end_date
                ];
            });

        return view('payments.informasi', compact('kos', 'bookedDates'));
    }

    public function save1(Request $request)
    {
        $validated = $request->validate([
            'boarding_house_id' => 'required|exists:boarding_houses,id',
            'room_id'           => 'required|exists:rooms,id',
            'start_date'        => 'required|date|after_or_equal:today',
            'end_date'          => 'required|date|after:start_date',
            'duration_type'     => 'required|in:harian,mingguan,bulanan',
            'total_price'       => 'required|numeric',
        ]);

        session(['booking_data' => $validated]);

        return redirect()->route('payments.pembayaran');
    }

    public function payment(Request $request)
    {
        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'Sesi habis, silakan isi data kembali.');
        }

        $kos = Room::with('boardingHouse')->findOrFail($bookingData['room_id']);

        return view('payments.pembayaran', compact('bookingData', 'kos'));
    }

    public function save2(Request $request, MidtransService $midtransService)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);

        $session = session('booking_data', []);

        $orderData = [
            'order_id' => 'REKOST-' . time(),
            'gross_amount' => $session['total_price'],
            'customer' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]
        ];
        $method = $request->payment_method;

        $paymentType = (
            str_contains($method, 'Virtual') ||
            str_contains($method, 'VA') ||
            str_contains($method, 'Transfer')
        ) ? 'bank_transfer' : 'gopay';
        $bankName = ($paymentType === 'bank_transfer') ? strtolower(explode(' ', $request->payment_method)[0]) : null;

        try {
            $response = $midtransService->createCharge($orderData, $paymentType, $bankName);
            $midtransData = json_decode(json_encode($response), true);

            $final_booking_data = array_merge($session, [
                'payment_method' => $request->payment_method,
                'midtrans_response' => $midtransData,
                'order_id' => $orderData['order_id']
            ]);
            session(['booking_data' => $final_booking_data]);

            return redirect()->route('payments.konfirmasi');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi Midtrans Gagal: ' . $e->getMessage());
        }
    }


    public function confirmation()
    {
        $detail = session('booking_data');
        $kos = Room::with('boardingHouse')->findOrFail($detail['room_id']);
        $user = User::with('userDetail')->findOrFail(Auth::user()->id);

        if (!$detail) {
            return redirect()->route('home')->with('error', 'Sesi habis, silakan isi data kembali.');
        }

        return view('payments.konfirmasi', compact('detail', 'kos', 'user'));
    }

    public function store(Request $request, MidtransService $midtransService)
    {
        $session = session('booking_data');

        if (!$session || !isset($session['order_id'])) {
            return redirect()->route('home')->with('error', 'Sesi pembayaran tidak ditemukan.');
        }

        try {
            $statusMidtrans = Transaction::status($session['order_id']);

            $transactionStatus = $statusMidtrans->transaction_status;

            $dbStatus = 'waiting';
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $dbStatus = 'successful';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $dbStatus = 'canceled';
            }

            $rentalTypeMap = [
                'harian'   => 'daily',
                'mingguan' => 'weekly',
                'bulanan'  => 'monthly'
            ];

            $rentalType = $rentalTypeMap[$session['duration_type']] ?? 'daily';
            $startDate = Carbon::parse($session['start_date']);
            $endDate = Carbon::parse($session['end_date']);

            $totalDays = $startDate->diffInDays($endDate);

            $tenant = Tenant::create([
                'tenant_id'   => auth()->id(),
                'room_id'     => $session['room_id'],
                'start_date'  => $session['start_date'],
                'end_date'    => $session['end_date'],
                'duration'    => $totalDays,
                'rental_type' => $rentalType,
            ]);

            $paymentMethod = str_contains($session['payment_method'], 'Virtual') ? 'va' : 'e-wallet';

            Payment::create([
                'payment_id' => $tenant->id,
                'order_id' => $session['order_id'],
                'payment_method' => $paymentMethod,
                'amount' => $session['total_price'],
                'status' => $dbStatus,
                'payment_date' => now(),
            ]);

            if ($dbStatus == 'successful') {
                session()->forget('booking_data');
                return redirect()->route('payments.success')->with('message', 'Pembayaran Berhasil!');
            }

            return redirect()->route('payments.success')->with('message', 'Status: ' . $dbStatus);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memverifikasi ke Midtrans: ' . $e->getMessage());
        }
    }
    public function success()
    {
        return view('payments.success');
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $signatureKeyReceived = $request->signature_key;

        $grossRound = (int) $request->gross_amount;
        $hashRound = hash("sha512", $orderId . $statusCode . $grossRound . $serverKey);

        $hashRaw = hash("sha512", $orderId . $statusCode . $request->gross_amount . $serverKey);

        $isMockTest = str_starts_with($orderId, 'payment_notif_test_');

        if ($signatureKeyReceived !== $hashRound && $signatureKeyReceived !== $hashRaw && !$isMockTest) {
            return response()->json([
                'message' => 'Invalid signature',
                'debug_server_key_exists' => !empty($serverKey),
            ], 403);
        }

        $transaction = $request->transaction_status;
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            if ($isMockTest) {
                return response()->json(['message' => 'Notification simulated successfully (Mock Data)'], 200);
            }
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($transaction == 'settlement' || $transaction == 'capture') {
            $payment->update(['status' => 'successful']);

            if ($payment->tenant && $payment->tenant->room) {
                $payment->tenant->room->update(['available' => 0]);
            }
        } elseif ($transaction == 'pending') {
            $payment->update(['status' => 'waiting']);
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $payment->update(['status' => 'failed']);

            if ($payment->tenant && $payment->tenant->room) {
                $payment->tenant->room->update(['available' => 1]);
            }
        }

        return response()->json(['message' => 'Notification handled successfully'], 200);
    }
}
