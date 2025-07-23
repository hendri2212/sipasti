<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            'Sekretariat Daerah Kabupaten Kotabaru',
            'Dinas Pariwisata, Pemuda dan Olahraga (Disparpora)',
            'Dinas Pendidikan dan Kebudayaan',
            'Dinas Kesehatan',
            'Dinas Pekerjaan Umum dan Penataan Ruang',
            'Dinas Perhubungan',
            'Dinas Komunikasi dan Informatika',
            'Dinas Kependudukan dan Pencatatan Sipil',
            'Dinas Sosial',
            'Dinas Lingkungan Hidup',
            'Dinas Perindustrian, Perdagangan, Koperasi dan UKM',
            'Dinas Penanaman Modal dan PTSP',
            'Badan Perencanaan Pembangunan Daerah (Bappeda)',
            'Badan Keuangan dan Aset Daerah (BKAD)',
            'Inspektorat Daerah',
            'SMP Negeri 1 Kotabaru',
            'SMA Negeri 1 Kotabaru',
            'SMK Negeri 1 Kotabaru',
            'SD Negeri 1 Dirgahayu',
            'SD Negeri 2 Kotabaru',
            'MTs Negeri Kotabaru',
            'MAN Kotabaru',
            'Universitas Islam Kalimantan (UNISKA) Kampus Kotabaru',
            'Politeknik Kotabaru',
            'PT Arutmin Indonesia Site Senakin',
            'PT Silo',
            'PT Sebuku Iron Lateritic Ores (SILO) Kotabaru',
            'PT Smart Tbk (Kebun Sawit Kotabaru)',
            'PT Multi Tambangjaya Utama',
            'Bank Kalsel Cabang Kotabaru'
        ];

        foreach ($institutions as $name) {
            Institution::firstOrCreate(['name' => $name]);
        }
    }
}
