<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        DB::table('users')->insert([
            'name'           => 'Hendri Arifin',
            'phone'          => '085746080544',
            'password'       => Hash::make('12345678'),
            'role'           => 'super_admin',
            'institution_id' => null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}