<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class allKosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Room::with('boardingHouse')->where('available', true);

        if ($request->filled('harga')) {
            $harga = $request->harga;
            if ($harga == '1000001') {
                $query->where('monthly_price', '>', 1000000);
            } else {
                $lower = $harga == '100000' ? 0 : $harga - 100000;
                $query->whereBetween('monthly_price', [$lower, $harga]);
            }
        }

        if ($request->filled('area')) {
            $area = $request->area;
            $query->whereHas('boardingHouse', function($q) use ($area) {
                $q->where('alamat', 'like', '%' . $area . '%');
            });
        }

        if ($request->filled('tipe')) {
            $tipe = $request->tipe;
            $query->whereHas('boardingHouse', function($q) use ($tipe) {
                $q->where('boarding_house_type', $tipe);
            });
        }

        $rooms = $query->latest()->get();

        return view('landing.index_all_kos', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
