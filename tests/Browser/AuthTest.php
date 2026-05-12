<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{

    /**
     * Skenario: Tes User Registrasi Berhasil
     */
    public function test_user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $email = 'tester' . time() . '@rekos.com';
            $phone = '0812' . rand(10000000, 99999999);
            
            $browser->visit('/register')
                    ->assertSee('Create Account')
                    ->type('name', 'Pencari Kos Baru')
                    ->type('email', $email)
                    ->type('phone', $phone)
                    ->type('password', 'password123')
                    ->press('Create Account')
                    ->pause(1500)
                    ->assertPathIs('/login');
        });
    }

    /**
     * Skenario 1: Login Berhasil
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);
        \App\Models\UserDetail::create(['user_id' => $user->id, 'phone' => '0844444', 'gender' => 'male', 'birth_date' => '2000-01-01']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->assertSee('Selamat Datang')
                    ->type('email', $user->email)
                    ->type('password', 'password123')
                    ->press('Login')
                    ->pause(1500)
                    ->assertPathIsNot('/login'); 
        });
    }

    /**
     * Skenario 2: Login Gagal (Password Salah)
     */
    public function test_user_login_failed_wrong_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);
        \App\Models\UserDetail::create(['user_id' => $user->id, 'phone' => '0855555', 'gender' => 'male', 'birth_date' => '2000-01-01']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()
                    ->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'salahpasswordnya')
                    ->press('Login')
                    ->pause(1000)
                    ->assertPathIs('/login');
        });
    }

    /**
     * Skenario 3: Input Login Kosong
     */
    public function test_login_empty_input()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/login')
                    // Biarkan email dan password kosong
                    ->press('Login')
                    ->pause(1000)
                    ->assertPathIs('/login'); // HTML5 "required" akan memblokir submit, jadi URL tidak berubah
        });
    }
}
