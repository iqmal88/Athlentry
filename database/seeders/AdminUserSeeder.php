<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'Name'           => 'MUHAMMAD IQMAL HAFIY BIN TAJUDIN',
            'MatricNo'       => 'CB22047',
            'Email'          => 'admin@athlentry.com',
            'Password'       => Hash::make('Admin2425'),
            'Role'           => 'admin',
            'PhoneNumber'    => '0123456789', // Added default phone
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}