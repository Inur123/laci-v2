<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\DataUserPac;

class DataUserPacTest extends TestCase
{
    use RefreshDatabase;

    protected $cabang;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cabang = User::factory()->create([
            'role' => 'sekretaris_cabang',
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function data_user_pac_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.data-user-pac'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_pac_users()
    {
        $pac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
            'name' => 'PAC Test User',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(DataUserPac::class)
            ->assertSee('PAC Test User');
    }

    /** @test */
    public function can_search_pac_users()
    {
        User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
            'name' => 'Searchable PAC',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(DataUserPac::class)
            ->set('search', 'Searchable')
            ->assertSee('Searchable PAC');
    }
}
