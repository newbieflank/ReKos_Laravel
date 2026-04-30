<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create()
    {
        return view('payments.informasi');
    }

    public function payment()
    {
        return view('payments.pembayaran');
    }

    public function confirmation()
    {
        return view('payments.konfirmasi');
    }

    // Simpan data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id'      => 'required|integer',
            'payment_method' => 'required',
            'amount'         => 'required|numeric|min:0',
            'status'         => 'required',
            'payment_date'   => 'required|date',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.success');
    }
    public function success()
    {
        return view('payments.success');
    }
}
