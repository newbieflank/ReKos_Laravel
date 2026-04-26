<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the user ID for owner@gmail.com
        $owner = DB::table('users')
            ->where('email', 'owner@gmail.com')
            ->first();

        if (!$owner) {
            $this->command->error('❌ User dengan email owner@gmail.com tidak ditemukan!');
            return;
        }

        $ownerId = $owner->id;
        $now = Carbon::now();

        // =========================
        // KOS 1
        // =========================
        $kos1Id = DB::table('boarding_houses')->insertGetId([
            'owner_id' => $ownerId,
            'boarding_house_name' => 'Kost Nyaman Pasar',
            'alamat' => 'Jl. Gatot Subroto No. 123, Kemayoran, Jakarta Pusat, 12130, Indonesia',
            'latitude' => -6.18048000,
            'longitude' => 106.83268000,
            'boarding_house_type' => 'mixed',
            'facilities' => json_encode([
                'Free WiFi',
                'Laundry',
                'Parkir Luas',
                'Keamanan 24j',
                'Dapur Bersama',
                'Full AC'
            ]),
            'description' => 'Kost berkualitas dengan fasilitas lengkap, lokasi strategis di pusat kota Jakarta.',
            'house_rule' => 'Jam malam pukul 22.00, tidak boleh membawa lawan jenis ke kamar setelah jam 21.00.',
            'rating' => 4.50,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rooms_kos1 = [
            [
                'room_name' => 'Kamar A1',
                'room_type' => 'standar',
                'room_size' => '3x4 m',
                'facilities' => json_encode(['WiFi', 'AC', 'Kamar Mandi', 'Meja', 'Lemari']),
                'daily_price' => 50000,
                'weekly_price' => 300000,
                'monthly_price' => 1000000,
                'monthly_expense' => 150000.00,
            ],
            [
                'room_name' => 'Kamar B1',
                'room_type' => 'deluxe',
                'room_size' => '4x5 m',
                'facilities' => json_encode(['WiFi', 'AC', 'Kamar Mandi', 'Meja', 'Lemari', 'TV']),
                'daily_price' => 75000,
                'weekly_price' => 450000,
                'monthly_price' => 1500000,
                'monthly_expense' => 200000.00,
            ],
            [
                'room_name' => 'Kamar Premium',
                'room_type' => 'premium',
                'room_size' => '5x6 m',
                'facilities' => json_encode(['WiFi', 'Full AC', 'Kamar Mandi', 'Meja', 'Lemari', 'TV', 'Kursi']),
                'daily_price' => 100000,
                'weekly_price' => 600000,
                'monthly_price' => 2000000,
                'monthly_expense' => 250000.00,
            ],
        ];

        foreach ($rooms_kos1 as $room) {
            DB::table('rooms')->insert([
                'boarding_house_id' => $kos1Id,
                'room_name' => $room['room_name'],
                'room_type' => $room['room_type'],
                'room_size' => $room['room_size'],
                'facilities' => $room['facilities'],
                'daily_price' => $room['daily_price'],
                'weekly_price' => $room['weekly_price'],
                'monthly_price' => $room['monthly_price'],
                'monthly_expense' => $room['monthly_expense'],
                'available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // =========================
        // KOS 2
        // =========================
        $kos2Id = DB::table('boarding_houses')->insertGetId([
            'owner_id' => $ownerId,
            'boarding_house_name' => 'Kost Premium Nangkaan',
            'alamat' => 'Jl. Merdeka Barat No. 456, Menteng, Jakarta Pusat, 10110, Indonesia',
            'latitude' => -6.19428000,
            'longitude' => 106.81627000,
            'boarding_house_type' => 'female',
            'facilities' => json_encode([
                'Free WiFi',
                'Full AC',
                'Room Service',
                'Keamanan 24j',
                'Laundry',
                'Gym Area'
            ]),
            'description' => 'Kost khusus perempuan dengan standar keamanan dan kenyamanan tertinggi.',
            'house_rule' => 'Khusus perempuan, jam malam pukul 23.00, tidak boleh membawa tamu laki-laki setelah jam 20.00.',
            'rating' => 4.80,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rooms_kos2 = [
            [
                'room_name' => 'Kamar 101',
                'room_type' => 'standar',
                'room_size' => '3x4 m',
                'facilities' => json_encode(['WiFi', 'AC', 'Kamar Mandi', 'Meja', 'Lemari']),
                'daily_price' => 55000,
                'weekly_price' => 330000,
                'monthly_price' => 1100000,
                'monthly_expense' => 160000.00,
            ],
            [
                'room_name' => 'Kamar 201',
                'room_type' => 'deluxe',
                'room_size' => '4x5 m',
                'facilities' => json_encode(['WiFi', 'Full AC', 'Kamar Mandi', 'Meja', 'Lemari', 'TV']),
                'daily_price' => 80000,
                'weekly_price' => 480000,
                'monthly_price' => 1600000,
                'monthly_expense' => 210000.00,
            ],
            [
                'room_name' => 'Kamar VIP',
                'room_type' => 'premium',
                'room_size' => '5x6 m',
                'facilities' => json_encode(['WiFi', 'Full AC', 'Room Service', 'Kamar Mandi', 'TV', 'Kursi']),
                'daily_price' => 110000,
                'weekly_price' => 660000,
                'monthly_price' => 2200000,
                'monthly_expense' => 280000.00,
            ],
        ];

        foreach ($rooms_kos2 as $room) {
            DB::table('rooms')->insert([
                'boarding_house_id' => $kos2Id,
                'room_name' => $room['room_name'],
                'room_type' => $room['room_type'],
                'room_size' => $room['room_size'],
                'facilities' => $room['facilities'],
                'daily_price' => $room['daily_price'],
                'weekly_price' => $room['weekly_price'],
                'monthly_price' => $room['monthly_price'],
                'monthly_expense' => $room['monthly_expense'],
                'available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // =========================
        // KOS 3
        // =========================
        $kos3Id = DB::table('boarding_houses')->insertGetId([
            'owner_id' => $ownerId,
            'boarding_house_name' => 'Kost Santai Sudirman',
            'alamat' => 'Jl. Jendral Sudirman No. 88, Jakarta Selatan, 10220, Indonesia',
            'latitude' => -6.21462000,
            'longitude' => 106.82298000,
            'boarding_house_type' => 'male',
            'facilities' => json_encode([
                'Free WiFi',
                'Parkir Motor',
                'Keamanan 24j',
                'Dapur Bersama'
            ]),
            'description' => 'Kost khusus pria dengan lokasi strategis dekat perkantoran Sudirman.',
            'house_rule' => 'Khusus pria, jam malam pukul 22.00, tidak boleh berisik setelah jam 21.00.',
            'rating' => 4.30,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rooms_kos3 = [
            [
                'room_name' => 'Kamar S1',
                'room_type' => 'standar',
                'room_size' => '3x3 m',
                'facilities' => json_encode(['WiFi', 'Kipas', 'Meja', 'Lemari']),
                'daily_price' => 40000,
                'weekly_price' => 250000,
                'monthly_price' => 900000,
                'monthly_expense' => 120000.00,
            ],
            [
                'room_name' => 'Kamar S2',
                'room_type' => 'deluxe',
                'room_size' => '4x4 m',
                'facilities' => json_encode(['WiFi', 'AC', 'Meja', 'Lemari', 'Kamar Mandi']),
                'daily_price' => 65000,
                'weekly_price' => 390000,
                'monthly_price' => 1300000,
                'monthly_expense' => 180000.00,
            ],
            [
                'room_name' => 'Kamar S3',
                'room_type' => 'premium',
                'room_size' => '5x5 m',
                'facilities' => json_encode(['WiFi', 'AC', 'TV', 'Kamar Mandi', 'Meja', 'Lemari']),
                'daily_price' => 90000,
                'weekly_price' => 540000,
                'monthly_price' => 1800000,
                'monthly_expense' => 230000.00,
            ],
        ];

        foreach ($rooms_kos3 as $room) {
            DB::table('rooms')->insert([
                'boarding_house_id' => $kos3Id,
                'room_name' => $room['room_name'],
                'room_type' => $room['room_type'],
                'room_size' => $room['room_size'],
                'facilities' => $room['facilities'],
                'daily_price' => $room['daily_price'],
                'weekly_price' => $room['weekly_price'],
                'monthly_price' => $room['monthly_price'],
                'monthly_expense' => $room['monthly_expense'],
                'available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // =========================
        // KOS 4
        // =========================
        $kos4Id = DB::table('boarding_houses')->insertGetId([
            'owner_id' => $ownerId,
            'boarding_house_name' => 'Kost Harmoni Tebet',
            'alamat' => 'Jl. Tebet Raya No. 12, Tebet, Jakarta Selatan, 12820, Indonesia',
            'latitude' => -6.23115000,
            'longitude' => 106.84695000,
            'boarding_house_type' => 'mixed',
            'facilities' => json_encode([
                'Free WiFi',
                'Laundry',
                'Parkir Mobil',
                'Keamanan 24j'
            ]),
            'description' => 'Kost nyaman di Tebet, cocok untuk pekerja maupun mahasiswa.',
            'house_rule' => 'Jam malam pukul 23.00, dilarang merokok di dalam kamar, wajib menjaga kebersihan.',
            'rating' => 4.60,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rooms_kos4 = [
            [
                'room_name' => 'Kamar T1',
                'room_type' => 'standar',
                'room_size' => '3x4 m',
                'facilities' => json_encode(['WiFi', 'Kipas', 'Meja', 'Lemari']),
                'daily_price' => 45000,
                'weekly_price' => 270000,
                'monthly_price' => 950000,
                'monthly_expense' => 130000.00,
            ],
            [
                'room_name' => 'Kamar T2',
                'room_type' => 'deluxe',
                'room_size' => '4x5 m',
                'facilities' => json_encode(['WiFi', 'AC', 'Meja', 'Lemari', 'Kamar Mandi']),
                'daily_price' => 70000,
                'weekly_price' => 420000,
                'monthly_price' => 1400000,
                'monthly_expense' => 190000.00,
            ],
            [
                'room_name' => 'Kamar T3',
                'room_type' => 'premium',
                'room_size' => '5x6 m',
                'facilities' => json_encode(['WiFi', 'Full AC', 'TV', 'Kamar Mandi', 'Meja', 'Lemari']),
                'daily_price' => 95000,
                'weekly_price' => 570000,
                'monthly_price' => 1900000,
                'monthly_expense' => 240000.00,
            ],
        ];

        foreach ($rooms_kos4 as $room) {
            DB::table('rooms')->insert([
                'boarding_house_id' => $kos4Id,
                'room_name' => $room['room_name'],
                'room_type' => $room['room_type'],
                'room_size' => $room['room_size'],
                'facilities' => $room['facilities'],
                'daily_price' => $room['daily_price'],
                'weekly_price' => $room['weekly_price'],
                'monthly_price' => $room['monthly_price'],
                'monthly_expense' => $room['monthly_expense'],
                'available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // =========================
        // KOS 5
        // =========================
        $kos5Id = DB::table('boarding_houses')->insertGetId([
            'owner_id' => $ownerId,
            'boarding_house_name' => 'Kost Eksklusif Kelapa Gading',
            'alamat' => 'Jl. Boulevard Raya No. 99, Kelapa Gading, Jakarta Utara, 14240, Indonesia',
            'latitude' => -6.15895000,
            'longitude' => 106.90877000,
            'boarding_house_type' => 'mixed',
            'facilities' => json_encode([
                'Free WiFi',
                'Full AC',
                'Laundry',
                'Parkir Mobil',
                'CCTV',
                'Keamanan 24j'
            ]),
            'description' => 'Kost eksklusif dengan fasilitas modern di kawasan Kelapa Gading.',
            'house_rule' => 'Jam malam pukul 23.00, wajib menjaga kebersihan, tidak boleh membuat keributan.',
            'rating' => 4.90,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rooms_kos5 = [
            [
                'room_name' => 'Kamar G1',
                'room_type' => 'standar',
                'room_size' => '3x4 m',
                'facilities' => json_encode(['WiFi', 'AC', 'Meja', 'Lemari']),
                'daily_price' => 60000,
                'weekly_price' => 360000,
                'monthly_price' => 1200000,
                'monthly_expense' => 170000.00,
            ],
            [
                'room_name' => 'Kamar G2',
                'room_type' => 'deluxe',
                'room_size' => '4x5 m',
                'facilities' => json_encode(['WiFi', 'Full AC', 'TV', 'Meja', 'Lemari', 'Kamar Mandi']),
                'daily_price' => 85000,
                'weekly_price' => 510000,
                'monthly_price' => 1700000,
                'monthly_expense' => 220000.00,
            ],
            [
                'room_name' => 'Kamar G3',
                'room_type' => 'premium',
                'room_size' => '5x6 m',
                'facilities' => json_encode(['WiFi', 'Full AC', 'TV', 'Kamar Mandi', 'Meja', 'Lemari', 'Kursi']),
                'daily_price' => 120000,
                'weekly_price' => 720000,
                'monthly_price' => 2400000,
                'monthly_expense' => 300000.00,
            ],
        ];

        foreach ($rooms_kos5 as $room) {
            DB::table('rooms')->insert([
                'boarding_house_id' => $kos5Id,
                'room_name' => $room['room_name'],
                'room_type' => $room['room_type'],
                'room_size' => $room['room_size'],
                'facilities' => $room['facilities'],
                'daily_price' => $room['daily_price'],
                'weekly_price' => $room['weekly_price'],
                'monthly_price' => $room['monthly_price'],
                'monthly_expense' => $room['monthly_expense'],
                'available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('✅ Seeder berhasil membuat 5 kos dan masing-masing 3 kamar!');
    }
}