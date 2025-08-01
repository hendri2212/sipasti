<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asset_user')->insert([
            ['user_id' => 3, 'asset_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'asset_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'asset_id' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'asset_id' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'asset_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 19,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'asset_id' => 20,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 7,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 19,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'asset_id' => 20,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'asset_id' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'asset_id' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'asset_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'asset_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 9,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'asset_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 16, 'asset_id' => 4,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}