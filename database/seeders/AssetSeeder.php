<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            ['title'=>'Lapangan Siring Laut','img'=>'siring_laut.webp','desc'=>'Lapangan serbaguna di tepi laut dengan pemandangan indah.'],
            ['title'=>'Panggung Apung','img'=>'panggung_apung.webp','desc'=>'Panggung terapung untuk pertunjukan seni dan budaya.'],
            ['title'=>'Masjid Kapal Pesiar','img'=>'masjid_kapal_pesiar.webp','desc'=>'Masjid ikonik berbentuk kapal pesiar, simbol wisata religi dan arsitektur unik.'],
            ['title'=>'Pantai Gedambaan','img'=>'pantai_gedambaan.webp','desc'=>'Pantai berpasir putih dengan fasilitas rekreasi keluarga.'],
            ['title'=>'Hutan Meranti','img'=>'hutan_meranti.webp','desc'=>'Hutan hijau lebat untuk trekking dan edukasi alam.'],
            ['title'=>'Tumpang Dua','img'=>'tumpang_dua.webp','desc'=>'Area pertemuan outdoor bergaya tradisional.'],
            ['title'=>'Kolam Renang','img'=>'kolam_renang.webp','desc'=>'Kolam renang modern dengan fasilitas lengkap.'],
            ['title'=>'Stadion Sepak Bola Bamega','img'=>'stadion_bamega.webp','desc'=>'Stadion berkapasitas besar untuk pertandingan sepak bola.'],
            ['title'=>'GOR Bulu Tangkis Bamega','img'=>'gor_bulu_tangkis.webp','desc'=>'Gelanggang olahraga bulu tangkis standar internasional.'],
            ['title'=>'Basket Indoor','img'=>'basket_indor.webp','desc'=>'Lapangan basket indoor dengan pencahayaan baik.'],
            ['title'=>'Lapangan Volly','img'=>'lapangan_voly.webp','desc'=>'Lapangan voli outdoor dengan permukaan berkualitas.'],
            ['title'=>'Gedung Tenis Indoor Gunung Jambangan','img'=>'tenis_jambangan.webp','desc'=>'Tenis indoor dengan atap tertutup dan ventilasi bagus.'],
            ['title'=>'Lapangan Futsal Gunung Pemandangan','img'=>'futsal_pemandangan.webp','desc'=>'Lapangan futsal outdoor dekat pusat kota.'],
            ['title'=>'Lapangan Karate Tugu Nelayan','img'=>'lapangan_tugu_nelayan.webp','desc'=>'Dojo terbuka untuk latihan karate terbimbing.'],
            ['title'=>'Lapangan Tenis Meja','img'=>'tenis_meja.webp','desc'=>'Arena tenis meja dengan meja standar ITTF.'],
            ['title'=>'Gedung Mahligai Pemuda','img'=>'gedung_mahligai.webp','desc'=>'Gedung serbaguna untuk acara kecil sampai besar.'],
            ['title'=>'Bumi Perkemahan','img'=>'bumi_perkemahan.webp','desc'=>'Lokasi tanah lapang untuk camping dan acara pramuka.'],
            ['title'=>'Sirkuit Trail','img'=>'sirkuit_trail.webp','desc'=>'Lintasan off-road untuk olahraga motor trail dan kegiatan adventure.'],
            ['title'=>'Aula Pertemuan Pantai Gedambaan','img'=>'aula_gedambaan.webp','desc'=>'Aula semi terbuka di tepi pantai untuk pertemuan dan kegiatan komunitas.'],
            ['title'=>'Panggung Gedambaan','img'=>'panggung_gedambaan.webp','desc'=>'Panggung permanen untuk pertunjukan seni dan budaya di area Pantai Gedambaan.'],
            ['title'=>'Panggung Akrab','img'=>'panggung_akrab.webp','desc'=>'Panggung serba guna untuk pertunjukan seni dan budaya di area wista siring laut.'],
        ];

        foreach ($assets as $item) {
            $imageUrl = filter_var($item['img'], FILTER_VALIDATE_URL)
                ? $item['img']
                : Storage::url('assets/' . $item['img']);
            Asset::updateOrCreate(
                ['name' => $item['title']],
                [
                    'description' => $item['desc'],
                    'image'       => $imageUrl,
                ]
            );
        }
    }
}
