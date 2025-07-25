<?php

namespace App\Http\Controllers;

use App\Models\RentalAsset;
use App\Models\Institution;
use App\Models\Asset;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StoreRentalRequest;

class RentalController extends Controller {
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

        $rental = RentalAsset::create([
            'institution_id'    => $request->institution_id,
            'member_id'         => $member->id,
            'asset_id'          => $request->asset_id,
            'photo' => $path,
        ]);

        // Send WhatsApp message to all super admins
        $superAdmins = User::where('role', 'super_admin')->get(['name','phone']);
        foreach ($superAdmins as $admin) {
            Http::post(
                config('services.whatsapp.endpoint') ?? 'https://wabot.tukarjual.com/send',
                [
                    'to'      => preg_replace('/^0/', '62', $admin->phone),
                    'message' => "Aplikasi *SIPASTI* (Sistem Informasi Peminjaman Aset)\n\n"
                        . "Yth. Bapak/Ibu *{$admin->name}*,\n\n"
                        . "Terdapat *Surat Permohonan dari {$member->name}* yang memerlukan *disposisi* Anda.\n"
                        . "Silakan cek detailnya di \n" . route('rent.show', $rental->id) . "\n\n"
                        . "Terima kasih.\n\n_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren."
                ]
            );
        }

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
        // 1. Update status
        $rentalAsset->update(['status' => 'process']);

        // 2. Load related asset owner and member
        $rentalAsset->load('asset.user', 'member');

        $admin  = $rentalAsset->asset->user;
        $member = $rentalAsset->member;

        // 3. Prepare and send WhatsApp notification if admin exists
        if ($admin && $admin->role === 'admin') {
            $to      = preg_replace('/^0/', '62', $admin->phone);
            $message = $this->buildApprovalMessage(
                $admin->name,
                $member->name,
                $rentalAsset->id
            );

            Http::post(
                config('services.whatsapp.endpoint') ?? 'https://wabot.tukarjual.com/send',
                ['to' => $to, 'message' => $message]
            );
        }

        // 4. Redirect back with success
        return redirect()
            ->route('rent.show', $rentalAsset)
            ->with('success', 'Peminjaman berhasil disetujui dan notifikasi terkirim.');
    }

    protected function buildApprovalMessage(string $adminName, string $memberName, int $rentalId): string {
        return "Aplikasi *SIPASTI* (Sistem Informasi Peminjaman Aset)\n\n"
            . "Yth. Bapak/Ibu *{$adminName}*,\n\n"
            . "Peminjaman dari *{$memberName}* telah disetujui oleh Pimpinan, silahkan tentukan tanggal penggunaan aset.\n"
            . "Detail: " . route('rent.show', $rentalId) . "\n\n"
            . "_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren.";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalAsset $rentalAsset)
    {
        //
    }
}
