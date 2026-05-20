<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    /**
     * Skenario 1: Tes User bisa mengubah profilnya.
     */
    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        
        $user->userDetail()->create([
            'phone' => '0811111111',
            'gender' => 'unknown',
            'birth_date' => '2000-01-01'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user) 
                    ->visit('/profile') 
                    ->assertSee('Informasi Pribadi') 

                    ->type('name', 'Budi Test Otomatis') 
                    ->select('gender', 'male')           
                    ->type('phone', '089912345678')       
                    ->press('Save Changes')
                    ->assertPathIs('/profile');
        });
    }
}
