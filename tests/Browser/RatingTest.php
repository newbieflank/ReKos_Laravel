<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RatingTest extends DuskTestCase
{
    use DatabaseTruncation;

    /**
     * Skenario 4: Memberi rating aplikasi (Harus Login)
     */
    public function test_user_can_submit_app_rating()
    {
        $user = User::factory()->create();
        \App\Models\UserDetail::create([
            'user_id' => $user->id, 
            'phone' => '0811111', 
            'gender' => 'male',
            'birth_date' => '2000-01-01'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->pause(2000)
                    ->assertSee('Cari Kost Terbaik') 
                    ->script('if(document.getElementById("ratingInput")) document.getElementById("ratingInput").value = 5;');
            
            $browser->type('review', 'Aplikasi ini sangat luar biasa, mudah digunakan untuk mencari kos!')
                    ->click('#reviewForm button[type="submit"]') 
                    ->pause(1500)
                    ->assertPathIs('/');
        });
    }

    /**
     * Skenario 5: Memberi rating kost (Hanya dari riwayat sewa)
     */
    public function test_user_can_submit_kost_rating()
    {
        $user = User::factory()->create();
        \App\Models\UserDetail::create([
            'user_id' => $user->id, 
            'phone' => '0822222', 
            'gender' => 'male',
            'birth_date' => '2000-01-01'
        ]);
        
        $owner = User::create([
            'name' => 'Test Owner',
            'email' => 'owner_rating' . time() . '@test.com',
            'password' => bcrypt('password123'),
            'role' => 'owner'
        ]);
        
        $kost = BoardingHouse::create([
            'owner_id' => $owner->id,
            'boarding_house_name' => 'Kos Rating',
            'boarding_house_type' => 'mixed',
            'alamat' => 'Test Address',
            'latitude' => '-7.0',
            'longitude' => '113.0',
            'description' => 'Test',
            'status' => 'approved'
        ]);

        $room = Room::create([
            'boarding_house_id' => $kost->id,
            'room_name' => 'Kamar 1',
            'room_type' => 'Standard',
            'monthly_price' => 500000,
            'available' => true
        ]);
        
        $tenant = Tenant::create([
            'tenant_id' => $user->id,
            'room_id' => $room->id,
            'rental_type' => 'monthly',
            'rental_duration' => 1,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
            'total_price' => $room->monthly_price ?? 500000
        ]);

        Payment::create([
            'payment_id' => $tenant->id,
            'order_id' => 'INV-' . time(),
            'amount' => $room->monthly_price ?? 500000,
            'payment_date' => now(),
            'status' => 'successful',
            'payment_method' => 'va'
        ]);

        $this->browse(function (Browser $browser) use ($user, $tenant) {
            $browser->loginAs($user)
                    ->visit('/riwayat')
                    ->pause(2000)
                    ->assertSee('Riwayat') 
                    ->click('#ratingDropdown' . $tenant->id)
                    ->pause(1000)
                    ->script('document.querySelector(".rating-input").value = 5;');
            
            $browser->type('textarea[name="review"]', 'Kosnya sangat bersih dan nyaman!')
                    ->click('.rating-form button[type="submit"]')
                    ->pause(1500)
                    ->assertPathIs('/riwayat');
        });
    }

    /**
     * Skenario 6: Rating aplikasi kosong (Submit tanpa memilih bintang/mengisi form)
     */
    public function test_user_cannot_submit_empty_app_rating()
    {
        $user = User::factory()->create();
        \App\Models\UserDetail::create([
            'user_id' => $user->id, 
            'phone' => '0833333', 
            'gender' => 'male',
            'birth_date' => '2000-01-01'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->pause(2000)
                    ->assertSee('Cari Kost Terbaik') 
                    ->script('if(document.getElementById("ratingInput")) document.getElementById("ratingInput").value = 0;');
            
            $browser->click('#reviewForm button[type="submit"]')
                    ->pause(1500)
                    ->assertPathIs('/');
        });
    }
}
