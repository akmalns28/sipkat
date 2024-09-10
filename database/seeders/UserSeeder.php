<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'nik' => 0001,
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'super@gmail.com',
                'password' => '12345678',
                'role' => 'super admin',
            ]
        );
        User::create(
            [
                'nik' => 0002,
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'akmalnursidiq28@gmail.com',
                'password' => '12345678',
                'role' => 'admin',
            ]
        );
        User::create(
            [
                'nik' => 0003,
                'name' => 'Kepala Bidang',
                'username' => 'Kepbid',
                'email' => 'kepbid@gmail.com',
                'password' => '12345678',
                'role' => 'kepala bidang',
            ]
        );
    }
}
