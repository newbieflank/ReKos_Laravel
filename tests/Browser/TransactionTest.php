<?php

namespace Tests\Browser;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TransactionTest extends DuskTestCase
{
    /**
     * Skenario: User bisa melakukan booking kamar dan sampai ke halaman sukses
     */
    public function test_user_can_book_and_checkout_room()
    {
        // 1. Buat User Biasa (Pencari Kos)
        $user = User::factory()->create([
            'role' => 'tenant',
            'password' => bcrypt('password123'),
        ]);
        UserDetail::create([
            'user_id' => $user->id,
            'phone' => '081234567890',
            'gender' => 'male',
            'birth_date' => '2000-01-01',
        ]);

        // 2. Buat Data Kos dan Kamar
        $owner = User::factory()->create(['role' => 'owner']);
        $kos = BoardingHouse::create([
            'owner_id' => $owner->id,
            'boarding_house_name' => 'Kost Transaksi Dusk',
            'boarding_house_type' => 'mixed',
            'alamat' => 'Jl. Transaksi No. 123',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'description' => 'Kost untuk testing transaksi',
            'rating' => 5,
        ]);
        $room = Room::create([
            'boarding_house_id' => $kos->id,
            'room_name' => 'Kamar VIP Transaksi',
            'room_size' => '3x4',
            'facilities' => ['AC', 'WIFI'],
            'available' => 1,
            'daily_price' => 100000,
            'weekly_price' => 500000,
            'monthly_price' => 1500000,
        ]);

        $this->browse(function (Browser $browser) use ($user, $room) {
            $browser->loginAs($user)
                    // Masuk ke halaman form informasi booking
                    ->visit('/payment/create/' . $room->id)
                    ->assertSee('Pilih Durasi Sewa')
                    ->assertSee('Lanjut ke Pembayaran')
                    ->press('Lanjut ke Pembayaran')
                    ->pause(1500)
                    
                    // Masuk ke halaman pilihan metode pembayaran
                    ->assertPathIs('/payment/pembayaran')
                    ->assertSee('Pilih Metode Pembayaran')
                    // Langsung klik bayar (default BRI Virtual Account)
                    ->press('Bayar Sekarang ...')
                    ->pause(3000) // Tunggu API Midtrans memproses
                    
                    // Masuk ke halaman konfirmasi
                    ->assertPathIs('/payment/konfirmasi')
                    ->assertSee('Instruksi Pembayaran')
                    ->assertSee('Ringkasan Pembayaran')
                    
                    // Checklist dan Selesaikan
                    ->check('confirm')
                    ->press('Simpan & Selesaikan')
                    ->pause(2000)
                    
                    // Masuk ke halaman sukses
                    ->assertPathIs('/payments/success')
                    ->assertSee('Pembayaran Berhasil');
        });
    }
}
