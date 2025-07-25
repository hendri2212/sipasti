<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            ['title'=>'Lapangan Siring Laut','img'=>'https://picsum.photos/id/1011/400/200','desc'=>'Lapangan serbaguna di tepi laut dengan pemandangan indah.'],
            ['title'=>'Panggung Apung','img'=>'https://picsum.photos/id/1012/400/200','desc'=>'Panggung terapung untuk pertunjukan seni dan budaya.'],
            ['title'=>'Pantai Gedambaan','img'=>'https://picsum.photos/id/1013/400/200','desc'=>'Pantai berpasir putih dengan fasilitas rekreasi keluarga.'],
            ['title'=>'Hutan Meranti','img'=>'https://picsum.photos/id/1015/400/200','desc'=>'Hutan hijau lebat untuk trekking dan edukasi alam.'],
            ['title'=>'Tumpang Dua','img'=>'https://picsum.photos/id/1016/400/200','desc'=>'Area pertemuan outdoor bergaya tradisional.'],
            ['title'=>'Kolam Renang','img'=>'https://picsum.photos/id/1018/400/200','desc'=>'Kolam renang modern dengan fasilitas lengkap.'],
            ['title'=>'Stadion Sepak Bola Bamega','img'=>'https://picsum.photos/id/1020/400/200','desc'=>'Stadion berkapasitas besar untuk pertandingan sepak bola.'],
            ['title'=>'GOR Bulu Tangkis Bamega','img'=>'https://picsum.photos/id/1021/400/200','desc'=>'Gelanggang olahraga bulu tangkis standar internasional.'],
            ['title'=>'Basket Indoor','img'=>'https://picsum.photos/id/1024/400/200','desc'=>'Lapangan basket indoor dengan pencahayaan baik.'],
            ['title'=>'Lapangan Volly','img'=>'https://picsum.photos/id/1025/400/200','desc'=>'Lapangan voli outdoor dengan permukaan berkualitas.'],
            ['title'=>'Gedung Tenis Indoor Gunung Jambangan','img'=>'https://picsum.photos/id/1027/400/200','desc'=>'Tenis indoor dengan atap tertutup dan ventilasi bagus.'],
            ['title'=>'Lapangan Futsal Gunung Pemandangan','img'=>'https://picsum.photos/id/1035/400/200','desc'=>'Lapangan futsal outdoor dekat pusat kota.'],
            ['title'=>'Lapangan Karate Tugu Nelayan','img'=>'https://picsum.photos/id/1036/400/200','desc'=>'Dojo terbuka untuk latihan karate terbimbing.'],
            ['title'=>'Lapangan Tenis Meja','img'=>'https://picsum.photos/id/1037/400/200','desc'=>'Arena tenis meja dengan meja standar ITTF.'],
        ];

        foreach ($assets as $item) {
            Asset::updateOrCreate(
                ['name' => $item['title']],
                [
                    'description' => $item['desc'],
                    'image'       => $item['img'],
                    'user_id'     => 1,
                ]
            );
        }
    }
}
