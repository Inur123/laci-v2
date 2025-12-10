<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\KalenderKegiatan;

class KalenderKegiatanTest extends TestCase
{
    use RefreshDatabase;

    protected $cabang;
    protected $periode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cabang = User::factory()->create([
            'role' => 'sekretaris_cabang',
            'email_verified_at' => now(),
        ]);

        $this->periode = Periode::factory()->create([
            'user_id' => $this->cabang->id,
        ]);

        $this->cabang->update(['periode_aktif_id' => $this->periode->id]);
    }

    /** @test */
    public function kalender_kegiatan_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.kalender-kegiatan'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_kegiatan()
    {
        Livewire::actingAs($this->cabang)
            ->test(KalenderKegiatan::class)
            ->set('action', 'create')
            ->set('judul', 'Kegiatan Test')
            ->set('tanggal_mulai', '2025-12-15 10:00:00')
            ->set('lokasi', 'Lokasi Test')
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('kegiatan', 1);
    }

    /** @test */
    public function nama_kegiatan_is_required()
    {
        Livewire::actingAs($this->cabang)
            ->test(KalenderKegiatan::class)
            ->set('action', 'create')
            ->set('tanggal_mulai', '2025-12-15 10:00:00')
            ->call('save')
            ->assertHasErrors(['judul']);
    }

    /** @test */
    public function tanggal_is_required()
    {
        Livewire::actingAs($this->cabang)
            ->test(KalenderKegiatan::class)
            ->set('action', 'create')
            ->set('judul', 'Kegiatan Test')
            ->call('save')
            ->assertHasErrors(['tanggal_mulai']);
    }

    /** @test */
    public function can_edit_kegiatan()
    {
        $kegiatan = Kegiatan::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'judul' => 'Old Kegiatan',
            'tanggal_mulai' => '2025-12-15 10:00:00',
            'lokasi' => 'Old Lokasi',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(KalenderKegiatan::class)
            ->call('edit', $kegiatan->id)
            ->set('judul', 'New Kegiatan')
            ->call('update')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('kegiatan', [
            'id' => $kegiatan->id,
        ]);
    }

    /** @test */
    public function can_delete_kegiatan()
    {
        $kegiatan = Kegiatan::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'judul' => 'Kegiatan Test',
            'tanggal_mulai' => '2025-12-15 10:00:00',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(KalenderKegiatan::class)
            ->call('delete', $kegiatan->id)
            ->assertDispatched('flash');

        $this->assertDatabaseCount('kegiatan', 0);
    }

    /** @test */
    public function can_search_kegiatan()
    {
        Kegiatan::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'judul' => 'Kegiatan Searchable',
            'tanggal_mulai' => '2025-12-15 10:00:00',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(KalenderKegiatan::class)
            ->set('search', 'Searchable')
            ->assertSee('Kegiatan Searchable');
    }
}
