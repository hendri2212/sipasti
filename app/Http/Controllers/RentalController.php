<?php

namespace App\Http\Controllers;

use App\Models\RentalAsset;
use App\Models\Institution;
use App\Models\Asset;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRentalRequest;

class RentalController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $rentalAssets = RentalAsset::with(['institution', 'asset', 'member'])->orderBy('created_at', 'desc')->get();
        return view('rent.data', ['rentalAssets' => $rentalAssets]);
    }

    public function create() {
        $institutions = Institution::orderBy('name')->get(['id','name']);
        $assets       = Asset::orderBy('name')->get(['id','name']);

        return view('rent.form', compact('institutions','assets'));
    }

    public function store(StoreRentalRequest $request) {
        $path = $request->file('photo')->store('rent-photos','public');

        $member = Member::create([
            'name'           => $request->name,
            'phone'          => $request->phone,
            'address'        => $request->address,
        ]);

        RentalAsset::create([
            'institution_id'    => $request->institution_id,
            'member_id'         => $member->id,
            'asset_id'          => $request->asset_id,
            'photo' => $path,
        ]);

        return redirect()->route('rent.create')->with('success', 'Pengajuan peminjaman terkirim!');
    }

    public function show(RentalAsset $rentalAsset) {
        return view('rent.detail', ['rental' => $rentalAsset]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalAsset $rentalAsset)
    {
        //
    }

    public function update(Request $request, RentalAsset $rentalAsset) {
        $validated = $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'asset_id' => 'required|exists:assets,id',
            // 'status' => 'required|string', // Optionally remove or ignore this line
            // add other fields as needed
        ]);
        // Set status to process regardless of input
        $validated['status'] = 'process';
        $rentalAsset->update($validated);
        return redirect()->route('rent.show', $rentalAsset)->with('success', 'Rental updated and status set to process.');
    }

    public function approve(RentalAsset $rentalAsset) {
        $rentalAsset->update(['status'=>'process']);
        return redirect()->route('rent.show', $rentalAsset)
                        ->with('success','Peminjaman berhasil disetujui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalAsset $rentalAsset)
    {
        //
    }
}
