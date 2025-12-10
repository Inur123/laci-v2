<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Auth\Login;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_page_can_be_rendered()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'sekretaris_cabang',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        Livewire::test(Login::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('captcha', 'dummy-token')
            ->call('login')
            ->assertRedirect(route('cabang.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function users_cannot_login_with_incorrect_password()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->set('captcha', 'dummy-token')
            ->call('login')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    /** @test */
    public function email_is_required()
    {
        Livewire::test(Login::class)
            ->set('email', '')
            ->set('password', 'password')
            ->set('captcha', 'dummy-token')
            ->call('login')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function password_is_required()
    {
        Livewire::test(Login::class)
            ->set('email', 'test@example.com')
            ->set('password', '')
            ->set('captcha', 'dummy-token')
            ->call('login')
            ->assertHasErrors(['password' => 'required']);
    }
}
