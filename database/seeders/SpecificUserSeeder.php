<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class SpecificUserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(UserDetail::factory())
            ->create([
                'name' => 'Admin RE-KOST',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123qweasd'),
                'role' => 'admin',
            ]);

        User::factory()
            ->has(UserDetail::factory())
            ->create([
                'name' => 'Owner Kost',
                'email' => 'owner@gmail.com',
                'password' => bcrypt('123qweasd'),
                'role' => 'owner',
            ]);

        User::factory()
            ->has(UserDetail::factory())
            ->create([
                'name' => 'Penyewa Kamar',
                'email' => 'tenant@gmail.com',
                'password' => bcrypt('123qweasd'),
                'role' => 'tenant',
            ]);
    }
}
