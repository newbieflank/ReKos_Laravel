<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\RoleRequest;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminApprovalTest extends DuskTestCase
{
    use DatabaseTruncation;
    /**
     * Skenario: User biasa mengajukan diri sebagai owner dan disetujui admin
     */
    public function test_user_can_request_owner_and_admin_approve()
    {
        // 1. Buat User biasa (Tenant)
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

        // 2. Buat Admin
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);
        UserDetail::create([
            'user_id' => $admin->id,
            'phone' => '08999999999',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
        ]);

        $dummyPath = storage_path('app/public/dummy.png');
        if (!file_exists($dummyPath)) {
            $im = imagecreate(1, 1);
            imagecolorallocate($im, 0, 0, 0);
            imagepng($im, $dummyPath);
            imagedestroy($im);
        }

        $this->browse(function (Browser $browser, Browser $adminBrowser) use ($user, $admin, $dummyPath) {
            // --- BROWSER 1: USER ---
            $browser->loginAs($user)
                    ->visit('/')
                    ->click('#profileDropdown')
                    ->pause(500)
                    ->clickLink('Ajukan Jadi Owner')
                    ->pause(1000)
                    ->attach('#ktp_image', $dummyPath)
                    ->press('Kirim Pengajuan')
                    ->pause(1000)
                    ->click('#profileDropdown')
                    ->pause(500)
                    ->assertSee('Dalam proses persetujuan admin');

            // --- BROWSER 2: ADMIN ---
            $user->refresh();
            $adminBrowser->loginAs($admin)
                         ->visit('/admin/persetujuan')
                         ->pause(2000)
                         ->assertSee($user->name)
                         ->with('form[action="' . route('admin.approve-role', $user->roleRequest->id) . '"]', function ($form) {
                             $form->press('Setuju');
                         })
                         ->pause(1000)
                         ->assertSee('sekarang resmi menjadi Owner');
                         
            // --- BROWSER 1: USER ---
            // Logout dan Login kembali untuk memastikan role terbaru terbaca
            $browser->visit('/login') // Logout via UI tidak bisa karena dropdown mungkin belum di-hover. Kita langsung logout via form atau relogin
                    ->logout()
                    ->loginAs($user)
                    ->visit('/')
                    ->pause(1000)
                    ->click('#profileDropdown')
                    ->waitForText('Manajemen Kost', 5)
                    ->assertDontSee('Ajukan Jadi Owner');
        });
    }
}
