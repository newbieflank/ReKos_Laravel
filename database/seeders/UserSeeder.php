<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Admin (Spesifik untuk login)
        User::factory()
            ->admin()
            ->has(UserDetail::factory()) // Otomatis buat detail
            ->create([
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
            ]);

        // 2. Buat Owner (5 orang acak)
        User::factory(5)
            ->owner()
            ->has(UserDetail::factory())
            ->create();

        // 3. Buat Tenant (10 orang acak)
        User::factory(10)
            ->has(UserDetail::factory())
            ->create([
                'role' => 'tenant'
            ]);
    }
}
