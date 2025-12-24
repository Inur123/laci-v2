<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\Periode as PeriodeComponent;

class PeriodeTest extends TestCase
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
    public function periode_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.periode'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_periode()
    {
        Livewire::actingAs($this->cabang)
            ->test(PeriodeComponent::class)
            ->call('create')
            ->set('nama', '2025-2027')
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('periodes', [
            'user_id' => $this->cabang->id,
        ]);
    }

    /** @test */
    public function nama_is_required()
    {
        Livewire::actingAs($this->cabang)
            ->test(PeriodeComponent::class)
            ->call('create')
            ->set('nama', '')
            ->call('save')
            ->assertHasErrors(['nama' => 'required']);
    }

    /** @test */
    public function can_edit_periode()
    {
        $periode = Periode::factory()->create([
            'user_id' => $this->cabang->id,
            'nama' => '2020-2022',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(PeriodeComponent::class)
            ->call('edit', $periode->id)
            ->set('nama', '2021-2023')
            ->call('update')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('periodes', [
            'id' => $periode->id,
        ]);
    }

    /** @test */
    public function can_delete_periode()
    {
        $periode = Periode::factory()->create([
            'user_id' => $this->cabang->id,
        ]);

        Livewire::actingAs($this->cabang)
            ->test(PeriodeComponent::class)
            ->call('delete', $periode->id);

        $this->assertDatabaseMissing('periodes', [
            'id' => $periode->id,
        ]);
    }

    /** @test */
    public function can_search_periode()
    {
        Periode::factory()->create([
            'user_id' => $this->cabang->id,
            'nama' => '2020-2022',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(PeriodeComponent::class)
            ->set('search', '2020')
            ->assertSee('2020');
    }
}
