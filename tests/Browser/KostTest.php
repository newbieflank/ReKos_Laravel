<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class KostTest extends DuskTestCase
{
    use DatabaseTruncation;
    protected function setUp(): void
    {
        parent::setUp();

        if (!User::where('email', 'owner@gmail.com')->exists()) {
            $this->artisan('db:seed', ['--class' => 'SpecificUserSeeder']);
        }

        $owner = User::where('email', 'owner@gmail.com')->first();
        
        if (!BoardingHouse::where('boarding_house_name', 'Kos Bintang 5')->exists()) {
            $kost = BoardingHouse::create([
                'owner_id' => $owner->id,
                'boarding_house_name' => 'Kos Bintang 5',
                'boarding_house_type' => 'mixed',
                'alamat' => 'Jl. Bintang Terang No. 10',
                'latitude' => '-7.9',
                'longitude' => '113.8',
                'description' => 'Kos mewah dengan fasilitas lengkap dan nyaman.',
                'status' => 'approved'
            ]);

            Room::create([
                'boarding_house_id' => $kost->id,
                'room_name' => 'Kamar VIP',
                'room_type' => 'VIP',
                'monthly_price' => 1500000,
                'available' => true,
                'room_size' => '4x4',
                'description' => 'Kamar VIP dengan AC dan kamar mandi dalam.'
            ]);
        }
    }

    /**
     * Skenario 7: Menampilkan daftar kost
     */
    public function test_can_view_kost_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/all-kos')
                    ->pause(1000)
                    ->assertSee('Pilihan Kost Terbaik di Sekitarmu')
                    ->assertSee('Kos Bintang 5')
                    ->assertSee('Kamar VIP');
        });
    }

    /**
     * Skenario 8: Menampilkan detail kost (Harus Login)
     */
    public function test_can_view_kost_detail()
    {
        $kost = BoardingHouse::where('boarding_house_name', 'Kos Bintang 5')->first();
        $room = Room::where('boarding_house_id', $kost->id)->first();
        
        $user = User::factory()->create();
        \App\Models\UserDetail::create([
            'user_id' => $user->id, 
            'phone' => '0877777', 
            'gender' => 'male',
            'birth_date' => '2000-01-01'
        ]);

        $this->browse(function (Browser $browser) use ($user, $kost, $room) {
            $browser->loginAs($user)
                    ->visit('/kos/' . $kost->id . '?room_id=' . $room->id)
                    ->pause(1000)
                    ->assertSee($kost->boarding_house_name)
                    ->assertSee('Kos mewah dengan fasilitas lengkap dan nyaman.')
                    ->assertSee('Kamar VIP')
                    ->assertSee('1.500.000');
        });
    }

    /**
     * Skenario 9: Pencarian kost
     */
    public function test_can_search_kost()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(1000)
                    ->script('document.querySelector("select[name=\'tipe\']").value = "mixed";');
                    
            $browser->click('form[action="' . route('allkos.index') . '"] button[type="submit"]')
                    ->pause(1500)
                    ->assertPathIs('/all-kos')
                    ->assertSee('Kos Bintang 5');
        });
    }
}
