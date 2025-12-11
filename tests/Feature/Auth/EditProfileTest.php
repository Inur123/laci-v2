<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Auth\EditProfile;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function edit_profile_page_can_be_rendered()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get(route('edit-profile'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_update_profile_name()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('name', 'New Name')
            ->call('updateProfile')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('name', '')
            ->call('updateProfile')
            ->assertHasErrors(['name']);
    }

    /** @test */
    public function can_update_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'newpassword')
            ->call('updateProfile')
            ->assertDispatched('flash');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword', $user->password));
    }

    /** @test */
    public function current_password_must_be_correct()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'differentpassword')
            ->call('updateProfile')
            ->assertHasErrors(['password']);
    }

    /** @test */
    public function new_password_must_be_confirmed()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'differentpassword')
            ->call('updateProfile')
            ->assertHasErrors(['password']);
    }
}
