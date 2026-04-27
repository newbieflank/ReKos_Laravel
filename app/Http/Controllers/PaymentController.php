<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create()
    {
        return view('payments.create');
    }

    // Menyimpan Data
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

        return back()->with('success', 'Pembayaran berhasil dikirim!');
    }
}
