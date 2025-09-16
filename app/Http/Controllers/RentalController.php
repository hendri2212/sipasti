<?php

namespace App\Http\Controllers;

use App\Models\RentalAsset;
use App\Models\Institution;
use App\Models\Asset;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
            'recommendation'       => $request->has('recommendation') ? true : false,
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
        $rentalAsset->load('schedules');
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
        // 1) Authorization: allow admin or super_admin
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized action.');
        }
        // If not super_admin, ensure the admin manages this asset (based on pivot table asset_user)
        if (auth()->user()->role !== 'super_admin') {
            if (!$rentalAsset->asset || !$rentalAsset->asset->users()->where('users.id', auth()->id())->exists()) {
                abort(403, 'Anda tidak berwenang mengelola aset ini.');
            }
        }

        // 2) Validate request (explicit per-item checks to avoid wildcard "after" pitfalls)
        $validator = Validator::make($request->all(), [
            'schedules' => ['required', 'array', 'min:1'],
            'recommendation_letter' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $schedules = $request->input('schedules', []);
            foreach ($schedules as $i => $sch) {
                // date
                if (!isset($sch['date']) || !strtotime($sch['date'])) {
                    $validator->errors()->add("schedules.$i.date", 'Tanggal tidak valid.');
                }
                // start_time: HH:MM
                if (empty($sch['start_time']) || !preg_match('/^\d{2}:\d{2}$/', $sch['start_time'])) {
                    $validator->errors()->add("schedules.$i.start_time", 'Jam mulai harus format HH:ii.');
                }
                // end_time: HH:MM and after start_time
                if (empty($sch['end_time']) || !preg_match('/^\d{2}:\d{2}$/', $sch['end_time'])) {
                    $validator->errors()->add("schedules.$i.end_time", 'Jam selesai harus format HH:ii.');
                } else {
                    if (!empty($sch['start_time'])) {
                        $start = strtotime($sch['start_time']);
                        $end   = strtotime($sch['end_time']);
                        if ($end !== false && $start !== false && $end <= $start) {
                            $validator->errors()->add("schedules.$i.end_time", 'Jam selesai harus setelah jam mulai.');
                        }
                    }
                }
            }
        });

        $validator->validate();

        // 3) Atomic write: replace schedules + update status (and optional recommendation letter) in a transaction
        DB::transaction(function () use ($request, $rentalAsset) {
            // Hapus jadwal lama
            $rentalAsset->schedules()->delete();

            // Simpan jadwal baru
            foreach ($request->input('schedules', []) as $schedule) {
                $rentalAsset->schedules()->create([
                    'date'       => $schedule['date'],
                    'start_time' => $schedule['start_time'],
                    'end_time'   => $schedule['end_time'],
                ]);
            }

            $updateData = ['status' => 'finish'];

            // Jika ada surat rekomendasi
            if ($rentalAsset->recommendation && $request->hasFile('recommendation_letter')) {
                $path = $request->file('recommendation_letter')->store('recommendation', 'public');
                $updateData['recommendation_letter'] = $path;
            }

            $rentalAsset->update($updateData);
        });

        // 4) Refresh relations for notification
        $rentalAsset->load('schedules', 'asset', 'member');
        \Illuminate\Support\Carbon::setLocale('id');

        $firstSchedule = $rentalAsset->schedules->sortBy('date')->first();
        $lastSchedule  = $rentalAsset->schedules->sortByDesc('date')->first();

        $formattedStart = $firstSchedule
            ? \Carbon\Carbon::parse($firstSchedule->date)->translatedFormat('d F Y') . ' jam ' . substr($firstSchedule->start_time, 0, 5) . ' WITA'
            : '-';
        $formattedEnd = $lastSchedule
            ? \Carbon\Carbon::parse($lastSchedule->date)->translatedFormat('d F Y') . ' jam ' . substr($lastSchedule->end_time, 0, 5) . ' WITA'
            : '-';
        $formattedRentalDate = $rentalAsset->letter_date
            ? \Carbon\Carbon::parse($rentalAsset->letter_date)->format('d-m-Y')
            : '-';

        $asset  = $rentalAsset->asset;
        $member = $rentalAsset->member;

        // 5) Kirim notifikasi WA (aman walau jadwal kosong)
        if ($member && $asset) {
            $message = "Aplikasi *SIPASTI* (Sistem Informasi Peminjaman Aset)\n\n"
                . "Yth. Bapak/Ibu *{$member->name}*,\n\n"
                . "Permohonan Anda untuk penggunaan *{$asset->name}* telah disetujui oleh DISPARPORA Kotabaru.\n\n"
                . "*Nomor Surat:* {$rentalAsset->letter_number}\n"
                . "*Tanggal Surat:* {$formattedRentalDate}\n"
                . "*Tanggal Penggunaan:* {$formattedStart}\n"
                . "*Tanggal Selesai:* {$formattedEnd}\n\n";

            if ($rentalAsset->recommendation_letter) {
                $fileUrl = asset('storage/' . $rentalAsset->recommendation_letter);
                $message .= "*Surat Rekomendasi:* {$fileUrl}\n\n";
            }

            $message .= "Terima kasih.\n\n_Disparpora Kotabaru_\nTransformasi Komunikasi — Mudah, Cepat, Keren.";

            Http::post(
                config('services.whatsapp.endpoint') ?? 'https://wabot.tukarjual.com/send',
                ['to' => preg_replace('/^0/', '62', $member->phone), 'message' => $message]
            );
        }

        // 6) Selesai
        return redirect()
            ->route('rent.show', $rentalAsset)
            ->with('success', 'Jadwal penggunaan dan status berhasil diperbarui.');
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

    public function reject(RentalAsset $rentalAsset) {
        // 1. Update status to 'reject'
        $rentalAsset->update([
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

    public function cancel(RentalAsset $rentalAsset) {
        // Hapus semua jadwal event untuk rental ini
        $rentalAsset->schedules()->delete();
        // 1. Update status to 'cancel'
        $rentalAsset->update([
            'status' => 'cancel',
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
        // Hapus semua jadwal event untuk rental ini
        $rentalAsset->schedules()->delete();
        $rentalAsset->update([
            'status' => 'process',
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
        $rentalAssets = RentalAsset::with(['institution', 'schedules'])
            ->where('asset_id', $assetId)
            ->whereHas('schedules') // pastikan hanya yang memiliki jadwal
            ->get();

        foreach ($rentalAssets as $item) {
            $current = \Carbon\Carbon::parse($item->start_at)->startOfDay();
            $end = \Carbon\Carbon::parse($item->end_at)->startOfDay();

            foreach ($item->schedules as $schedule) {
                $events[] = [
                    'title' => $item->institution->name,
                    'start' => $schedule->date,
                ];
            }
        }

        return response()->json($events);
    }

    public function report(Request $request) {
        $start = $request->get('start_date');
        $end   = $request->get('end_date');

        $query = RentalAsset::with([
            'institution',
            'asset',
            'member',
            'schedules' => function ($q) use ($start, $end) {
                // Filter schedules shown in the report (if date range provided)
                if ($start && $end) {
                    $q->whereBetween('date', [$start, $end]);
                }
                $q->orderBy('date')->orderBy('start_time');
            }
        ]);

        // Only include rentals that actually have schedules (and optionally within range)
        $query->whereHas('schedules', function ($q) use ($start, $end) {
            if ($start && $end) {
                $q->whereBetween('date', [$start, $end]);
            }
        });

        // Order the rentals by their earliest schedule date
        $query->withMin('schedules', 'date')->orderBy('schedules_min_date', 'asc');

        $rentalAssets = $query->get();

        return view('report.data', compact('rentalAssets', 'start', 'end'));
    }

    public function destroy(RentalAsset $rentalAsset) {
        //
    }
}
