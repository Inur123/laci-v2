<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Auth\Register;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function register_page_can_be_rendered()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_register()
    {
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'password12345')
            ->set('password_confirmation', 'password12345')
            ->set('captcha', 'dummy-token')
            ->call('register')
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        Livewire::test(Register::class)
            ->set('name', '')
            ->set('email', 'test@example.com')
            ->set('password', 'password12345')
            ->set('password_confirmation', 'password12345')
            ->set('captcha', 'dummy-token')
            ->call('register')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function email_must_be_unique()
    {
        User::factory()->create(['email' => 'test@example.com']);

        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'test@example.com')
            ->set('password', 'password12345')
            ->set('password_confirmation', 'password12345')
            ->set('captcha', 'dummy-token')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }
}
