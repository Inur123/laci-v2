<?php

namespace Tests\Feature\SekretarisPac;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisPac\DataAnggota\Anggota as AnggotaComponent;

class AnggotaTest extends TestCase
{
    use RefreshDatabase;

    protected $pac;
    protected $periode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
        ]);

        $this->periode = Periode::factory()->create([
            'user_id' => $this->pac->id,
        ]);

        $this->pac->update(['periode_aktif_id' => $this->periode->id]);
    }

    /** @test */
    public function anggota_page_can_be_rendered()
    {
        $response = $this->actingAs($this->pac)
            ->get(route('pac.data-anggota'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_anggota()
    {
        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->set('action', 'create')
            ->set('nama_lengkap', 'Test Anggota PAC')
            ->set('jenis_kelamin', 'Laki-laki')
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('anggotas', 1);
    }

    /** @test */
    public function nama_is_required()
    {
        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->set('action', 'create')
            ->set('jenis_kelamin', 'Laki-laki')
            ->call('save')
            ->assertHasErrors(['nama_lengkap']);
    }

    /** @test */
    public function jenis_kelamin_is_required()
    {
        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->set('action', 'create')
            ->set('nama_lengkap', 'Test Anggota')
            ->call('save')
            ->assertHasErrors(['jenis_kelamin']);
    }

    /** @test */
    public function can_edit_anggota()
    {
        $anggota = Anggota::factory()->create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
            'nama_lengkap' => 'Old Name',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->call('edit', $anggota->id)
            ->set('nama_lengkap', 'New Name')
            ->set('jenis_kelamin', 'Perempuan')
            ->call('update')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('anggotas', [
            'id' => $anggota->id,
        ]);
    }

    /** @test */
    public function can_delete_anggota()
    {
        $anggota = Anggota::factory()->create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
        ]);

        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->call('delete', $anggota->id)
            ->assertDispatched('flash');

        $this->assertDatabaseCount('anggotas', 0);
    }

    /** @test */
    public function can_search_anggota()
    {
        Anggota::factory()->create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
            'nama_lengkap' => 'Searchable Name',
        ]);

        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->set('search', 'Searchable')
            ->assertSee('Search');
    }

    /** @test */
    public function only_shows_own_anggotas()
    {
        $otherPac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
        ]);

        $otherPeriode = Periode::factory()->create([
            'user_id' => $otherPac->id,
        ]);

        Anggota::factory()->create([
            'user_id' => $otherPac->id,
            'periode_id' => $otherPeriode->id,
            'nama_lengkap' => 'Other PAC Anggota',
        ]);

        Livewire::actingAs($this->pac)
            ->test(AnggotaComponent::class)
            ->assertDontSee('Other PAC Anggota');
    }
}
