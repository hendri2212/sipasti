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
            'institution_id'       => $request->institution_id,
            'member_id'            => $member->id,
            'asset_id'             => $request->asset_id,
            'photo'                => $path,
            'letter_number'        => $request->letter_number,
            'letter_date'          => $request->letter_date,
            'incoming_letter_date' => $request->incoming_letter_date,
            'recommendation'       => $request->recommendation,
            'regarding'            => $request->regarding,
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
                        . "Silakan cek detailnya di " . route('rent.show', $rental->id) . "\n\n"
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
        $data = $request->validate([
            'start_at' => 'required|string',
            'end_at'   => 'required|string',
        ]);

        $start = \Carbon\Carbon::parse($data['start_at']);
        $end = \Carbon\Carbon::parse($data['end_at']);
        
        $rentalAsset->update([
            'start_at' => $start,
            'end_at'   => $end,
            'status'   => 'finish',
        ]);

        if ($rentalAsset->recommendation && $request->hasFile('recommendation_letter')) {
            $request->validate([
                'recommendation_letter' => 'file|mimes:pdf,jpg,jpeg,png|max:5120'
            ]);
            $path = $request->file('recommendation_letter')->store('recommendation', 'public');
            $rentalAsset->update(['recommendation_letter' => $path]);
        }

        $asset = Asset::find($rentalAsset->asset_id);

        $member = Member::find($rentalAsset->member_id);
        \Illuminate\Support\Carbon::setLocale('id');
        $formattedStart = $rentalAsset->start_at->translatedFormat('d F Y') . ' jam ' . $rentalAsset->start_at->format('H.i') . ' WITA';
        $formattedEnd = $rentalAsset->end_at->translatedFormat('d F Y') . ' jam ' . $rentalAsset->end_at->format('H.i') . ' WITA';
        $formattedRentalDate = optional($rentalAsset->letter_date)->format('d-m-Y');

        Http::post(
            config('services.whatsapp.endpoint') ?? 'https://wabot.tukarjual.com/send',
            [
                'to'      => preg_replace('/^0/', '62', $member->phone),
                'message' => "Aplikasi *SIPASTI* (Sistem Informasi Peminjaman Aset)\n\n"
                    . "Yth. Bapak/Ibu *{$member->name}*,\n\n"
                    . "Permohonan Anda untuk penggunaan *{$asset->name}* telah disetujui oleh DISPARPORA Kotabaru.\n\n"
                    . "*Nomor Surat:* {$rentalAsset->letter_number}\n"
                    . "*Tanggal Surat:* {$formattedRentalDate}\n"
                    . "*Tanggal Penggunaan:* {$formattedStart}\n"
                    . "*Tanggal Selesai:* {$formattedEnd}\n\n"
                    . "Terima kasih.\n\n_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren."
            ]
        );

        return redirect()
            ->route('rent.show', $rentalAsset)
            ->with('success', 'Tanggal penggunaan dan status berhasil diperbarui.');
    }

    public function approve(RentalAsset $rentalAsset) {
        // 1. Update status
        $rentalAsset->update(['status' => 'process']);

        // 2. Load related asset owners and member
        $rentalAsset->load('asset.users', 'member');

        $admins = $rentalAsset->asset->users()->where('role', 'admin')->get();

        // 3. Prepare and send WhatsApp notification to all admins
        foreach ($admins as $admin) {
            $to      = preg_replace('/^0/', '62', $admin->phone);
            $message = $this->buildApprovalMessage(
                $admin->name,
                $rentalAsset->member->name,
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
            . "Cek detail pada link " . route('rent.show', $rentalId) . "\n\n"
            . "_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren.";
    }

    public function cancel(RentalAsset $rentalAsset) {
        // 1. Update status to 'cancel'
        $rentalAsset->update([
            'start_at' => null,
            'status'   => 'cancel',
        ]);
        
        $asset = Asset::find($rentalAsset->asset_id);
        // 2. Load related member
        $member = Member::find($rentalAsset->member_id);

        // 3. Prepare and send WhatsApp notification if member exists
        if ($member) {
            $to      = preg_replace('/^0/', '62', $member->phone);
            $message = "Aplikasi *SIPASTI* (Sistem Informasi Peminjaman Aset)\n\n"
                . "Yth. Bapak/Ibu *{$member->name}*,\n\n"
                . "Permohonan peminjaman *{$asset->name}* belum dapat kami proses lebih lanjut sehingga statusnya kami batalkan. Hal ini dapat disebabkan oleh berbagai pertimbangan, seperti ketersediaan aset, jadwal bentrok, atau persyaratan administrasi yang belum terpenuhi.\n\n"
                . "Untuk informasi lebih lanjut atau konfirmasi, silakan hubungi admin Disparpora Kotabaru.\n\n"
                . "Terima kasih atas pengertiannya.\n\n"
                . "_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren.";

            Http::post(
                config('services.whatsapp.endpoint') ?? 'https://wabot.tukarjual.com/send',
                ['to' => $to, 'message' => $message]
            );
        }

        // 4. Redirect back with success
        return redirect()
            ->route('rent.show', $rentalAsset)
            ->with('success', 'Peminjaman berhasil dibatalkan dan notifikasi terkirim.');
    }

    public function change(RentalAsset $rentalAsset) {
        // 1. Update status to 'change'
        $rentalAsset->update([
            'start_at' => null,
            'status'   => 'process',
        ]);
        
        $asset = Asset::find($rentalAsset->asset_id);
        // 2. Load related member
        $member = Member::find($rentalAsset->member_id);

        // 3. Prepare and send WhatsApp notification if member exists
        if ($member) {
            $to      = preg_replace('/^0/', '62', $member->phone);
            $message = "Aplikasi *SIPASTI* (Sistem Informasi Peminjaman Aset)\n\n"
                . "Yth. Bapak/Ibu *{$member->name}*,\n\n"
                . "Peminjaman *{$asset->name}* akan di proses ulang oleh admin, silahkan tunggu informasi selanjutnya.\n\n"
                . "_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren.";

            Http::post(
                config('services.whatsapp.endpoint') ?? 'https://wabot.tukarjual.com/send',
                ['to' => $to, 'message' => $message]
            );
        }

        // 4. Redirect back with success
        return redirect()
            ->route('rent.show', $rentalAsset)
            ->with('success', 'Peminjaman berhasil diubah dan notifikasi terkirim.');
    }

    public function byAssetId($assetId) {
        $events = [];
        $rentalAssets = RentalAsset::with('institution')
            ->where('asset_id', $assetId)
            ->whereNotNull('start_at')
            ->whereNotNull('end_at')
            ->get();

        foreach ($rentalAssets as $item) {
            $current = \Carbon\Carbon::parse($item->start_at)->startOfDay();
            $end = \Carbon\Carbon::parse($item->end_at)->startOfDay();

            while ($current->lte($end)) {
                $events[] = [
                    'title' => $item->institution->name,
                    'start' => $current->format('Y-m-d'),
                ];
                $current->addDay();
            }
        }

        return response()->json($events);
    }

    public function report(Request $request) {
        $start = $request->get('start_date');
        $end   = $request->get('end_date');

        $query = RentalAsset::with(['institution','asset','member'])
            ->orderBy('start_at','asc');

        if ($start && $end) {
            $query->whereBetween('start_at', [$start, $end]);
        }

        $rentalAssets = $query->get();
        return view('report.data', compact('rentalAssets','start','end'));
    }

    public function destroy(RentalAsset $rentalAsset) {
        //
    }
}
