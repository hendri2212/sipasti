<?php

namespace App\Http\Controllers;

use App\Models\RentalAsset;
use App\Models\Institution;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRentalRequest;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutions = Institution::orderBy('name')->get(['id','name']);
        $assets       = Asset::orderBy('name')->get(['id','name']);

        return view('rent.form', compact('institutions','assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    public function store(StoreRentalRequest $request)
    {
        $path = $request->file('photo')->store('rent-photos','public');

        // Simpan ke tabel members
        $member = Member::create([
            'name'           => $request->name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'institution_id' => $request->institution_id,
        ]);

        // Simpan ke tabel rental_assets
        RentalAsset::create([
            'member_id'   => $member->id,
            'asset_id'    => $request->asset_id,
            'start_at'    => now(),   // sesuaikan input tanggal jika ada
            'end_at'      => now()->addHours(2),
            // 'status'      => 'waiting',
            // simpan path photo jika ingin: 'photo' => $path,
        ]);

        return redirect()->route('rent.create')->with('success', 'Pengajuan peminjaman terkirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalAsset $rentalAsset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalAsset $rentalAsset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentalAsset $rentalAsset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalAsset $rentalAsset)
    {
        //
    }
}
