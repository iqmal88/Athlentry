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
            'Name'           => 'MUHAMMAD ADEEB IRFAAN BIN ABDUL HANIM',
            'MatricNo'       => 'adminpetakom2190',
            'Email'          => 'admin2425@gmail.com',
            'Password'       => Hash::make('superadmin2190@'),
            'Role'           => 'admin',
            'PhoneNumber'    => '0123456789', // Added default phone
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}