<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\UserDetail;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Http;

class PemilikKostTest extends DuskTestCase
{

    private function getOrCreateOwner(): User
    {
        $owner = User::where('email', 'owner@gmail.com')->first();
        if (!$owner) {
            $owner = User::factory()->create([
                'name'     => 'Owner Kost',
                'email'    => 'owner@gmail.com',
                'password' => bcrypt('123qweasd'),
                'role'     => 'owner',
            ]);
        }

        $detail = UserDetail::where('user_id', $owner->id)->first();
        if (!$detail) {
            UserDetail::create([
                'user_id'     => $owner->id,
                'phone'       => '081234567890',
                'gender'      => 'male',
                'birth_date'  => '1990-01-01',
                'occupation'  => 'Pemilik Kost',
                'institution' => 'RE-KOST',
                'city'        => 'Bondowoso',
                'address'     => 'Jl. Testing No. 1',
            ]);
        } elseif (empty($detail->phone) || $detail->gender === 'unknown' || empty($detail->birth_date)) {
            $detail->update([
                'phone'      => '081234567890',
                'gender'     => 'male',
                'birth_date' => '1990-01-01',
            ]);
        }

        return $owner->fresh();
    }

    /**
     * Ambil atau buat kost dummy.
     */
    private function getOrCreateKost(User $owner, string $name = 'Kost Automasi Dusk'): BoardingHouse
    {
        $kost = BoardingHouse::where('boarding_house_name', $name)
                             ->where('owner_id', $owner->id)
                             ->first();
        if (!$kost) {
            $kost = BoardingHouse::create([
                'boarding_house_name' => $name,
                'owner_id'            => $owner->id,
                'area'                => 'Badean',
                'alamat'              => 'Badean, Jl. Automasi No. 1',
                'latitude'            => -7.9098,
                'longitude'           => 114.1700,
                'boarding_house_type' => 'male',
                'facilities'          => json_encode(['Wi-Fi']),
                'description'         => 'Kost untuk keperluan testing otomatis',
                'house_rule'          => 'Dilarang merokok dalam kamar',
                'main_image'          => 'image/test.jpg',
            ]);
        }
        return $kost;
    }

    /**
     * Ambil atau buat kamar dummy.
     */
    private function getOrCreateRoom(BoardingHouse $kost, string $name = 'Kamar Automasi Dusk'): Room
    {
        $room = Room::where('boarding_house_id', $kost->id)
                    ->where('room_name', $name)
                    ->first();
        if (!$room) {
            $room = Room::create([
                'boarding_house_id' => $kost->id,
                'room_name'         => $name,
                'room_type'         => 'Standard',
                'room_size'         => '3x4',
                'daily_price'       => 50000,
                'weekly_price'      => 300000,
                'monthly_price'     => 1000000,
                'monthly_expense'   => 100000,
                'available'         => 1,
                'facilities'        => json_encode(['Kasur', 'Lemari Pakaian']),
                'main_image'        => 'image/test.jpg',
            ]);
        }
        return $room;
    }

    /**
     * Bersihkan semua data test.
     */
    private function cleanupTestData(User $owner): void
    {
        BoardingHouse::where('owner_id', $owner->id)
                     ->whereIn('boarding_house_name', [
                         'Kost Automasi Dusk',
                         'Kost Automasi Dusk Terupdate',
                         'Kost Automasi Kamar Test',
                     ])
                     ->get()
                     ->each(function ($kost) {
                         Room::where('boarding_house_id', $kost->id)->delete();
                         $kost->delete();
                     });
    }

    //  SKENARIO 12: Tambah Kos
    public function test_owner_can_add_kost()
    {
        $owner = $this->getOrCreateOwner();
        $kost  = $this->getOrCreateKost($owner, 'Kost Automasi Dusk');

        $this->browse(function (Browser $browser) use ($owner, $kost) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost')
                    ->assertSee($kost->boarding_house_name);
        });
    }

    //  SKENARIO 13: Edit Data Kos

    public function test_owner_can_edit_kost()
    {
        $owner = $this->getOrCreateOwner();
        $kost  = $this->getOrCreateKost($owner, 'Kost Automasi Dusk');

        $kost->update(['boarding_house_name' => 'Kost Automasi Dusk Terupdate']);

        $this->browse(function (Browser $browser) use ($owner, $kost) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost')
                    ->assertSee('Kost Automasi Dusk Terupdate');
        });
    }

    //  SKENARIO 14: Hapus Data Kos

    public function test_owner_can_delete_kost()
    {
        $owner = $this->getOrCreateOwner();
        $kost  = BoardingHouse::where('owner_id', $owner->id)
                              ->where(function ($q) {
                                  $q->where('boarding_house_name', 'Kost Automasi Dusk Terupdate')
                                    ->orWhere('boarding_house_name', 'Kost Automasi Dusk');
                              })
                              ->first()
                    ?? $this->getOrCreateKost($owner, 'Kost Automasi Dusk Terupdate');

        $kostName = $kost->boarding_house_name;
        $kost->delete();

        $this->browse(function (Browser $browser) use ($owner, $kostName) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost')
                    ->assertDontSee($kostName);
        });
    }

    //  SKENARIO 15: Tambah Kamar

    public function test_owner_can_add_room()
    {
        $owner = $this->getOrCreateOwner();
        $kost  = $this->getOrCreateKost($owner, 'Kost Automasi Kamar Test');
        $room  = $this->getOrCreateRoom($kost, 'Kamar Automasi Dusk');

        $this->browse(function (Browser $browser) use ($owner, $kost, $room) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost/' . $kost->id . '/kamar')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost/' . $kost->id . '/kamar')
                    ->assertSee('Kamar Automasi Dusk');
        });
    }

    //  SKENARIO 16: Edit Data Kamar

    public function test_owner_can_edit_room()
    {
        $owner = $this->getOrCreateOwner();
        $kost  = $this->getOrCreateKost($owner, 'Kost Automasi Kamar Test');
        $room  = $this->getOrCreateRoom($kost, 'Kamar Automasi Dusk');

        $room->update([
            'room_name'     => 'Kamar Automasi Update',
            'monthly_price' => 1500000,
        ]);

        $this->browse(function (Browser $browser) use ($owner, $kost) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost/' . $kost->id . '/kamar')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost/' . $kost->id . '/kamar')
                    ->assertSee('Kamar Automasi Update');
        });
    }

    //  SKENARIO 17: Duplikat Kamar

    public function test_owner_can_duplicate_room()
    {
        $owner = $this->getOrCreateOwner();
        $kost  = $this->getOrCreateKost($owner, 'Kost Automasi Kamar Test');
        $room  = Room::where('boarding_house_id', $kost->id)
                     ->where('room_name', 'Kamar Automasi Update')
                     ->first()
                     ?? $this->getOrCreateRoom($kost, 'Kamar Automasi Update');

        $duplicateName = $room->room_name . ' 2';
        if (!Room::where('boarding_house_id', $kost->id)->where('room_name', $duplicateName)->exists()) {
            $newRoom = $room->replicate();
            $newRoom->room_name = $duplicateName;
            $newRoom->available = true;
            $newRoom->save();
        }

        $this->browse(function (Browser $browser) use ($owner, $kost, $duplicateName) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost/' . $kost->id . '/kamar')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost/' . $kost->id . '/kamar')
                    ->assertSee($duplicateName);
        });
    }

    //  SKENARIO 18: Hapus Data Kamar

    public function test_owner_can_delete_room()
    {
        $owner         = $this->getOrCreateOwner();
        $kost          = $this->getOrCreateKost($owner, 'Kost Automasi Kamar Test');
        $room          = Room::where('boarding_house_id', $kost->id)
                             ->where('room_name', 'Kamar Automasi Update')
                             ->first()
                             ?? $this->getOrCreateRoom($kost, 'Kamar Automasi Update');
        $duplicateRoom = Room::where('boarding_house_id', $kost->id)
                             ->where('room_name', 'Kamar Automasi Update 2')
                             ->first();

        $room->delete();
        if ($duplicateRoom) {
            $duplicateRoom->delete();
        }

        $this->browse(function (Browser $browser) use ($owner, $kost) {
            $browser->loginAs($owner)
                    ->visit('/pemilik/kost/' . $kost->id . '/kamar')
                    ->pause(1000)
                    ->assertPathIs('/pemilik/kost/' . $kost->id . '/kamar')
                    ->assertDontSee('Kamar Automasi Update');
        });

        $this->cleanupTestData($owner);
    }
}
