<?php

namespace Tests\Feature\SekretarisPac;

use App\Models\User;
use App\Models\Surat;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisPac\ArsipSurat as ArsipSuratComponent;

class ArsipSuratTest extends TestCase
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
    public function arsip_surat_page_can_be_rendered()
    {
        $response = $this->actingAs($this->pac)
            ->get(route('pac.arsip-surat'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_surat_masuk()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->set('action', 'create')
            ->set('jenis_surat', 'masuk')
            ->set('no_surat', 'SM/001/2025')
            ->set('perihal', 'Test Perihal')
            ->set('tanggal', '2025-12-10')
            ->set('pengirim_penerima', 'Test Pengirim')
            ->set('file', UploadedFile::fake()->create('surat.pdf', 1000))
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('surat', 1);
    }

    /** @test */
    public function can_create_surat_keluar()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->set('action', 'create')
            ->set('jenis_surat', 'keluar')
            ->set('no_surat', 'SK/001/2025')
            ->set('perihal', 'Test Perihal')
            ->set('tanggal', '2025-12-10')
            ->set('pengirim_penerima', 'Test Penerima')
            ->set('file', UploadedFile::fake()->create('surat.pdf', 1000))
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('surat', 1);
    }

    /** @test */
    public function no_surat_is_required()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->set('action', 'create')
            ->set('jenis_surat', 'Surat Masuk')
            ->set('file', UploadedFile::fake()->create('surat.pdf', 1000))
            ->call('save')
            ->assertHasErrors(['no_surat']);
    }

    /** @test */
    public function can_filter_by_jenis()
    {
        Surat::factory()->create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
            'jenis_surat' => 'Surat Masuk',
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->set('filterJenis', 'Surat Masuk')
            ->assertSee('Surat Masuk');
    }

    /** @test */
    public function can_search_surat()
    {
        Surat::factory()->create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
            'no_surat' => 'SEARCH/001/2025',
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->set('search', 'SEARCH')
            ->assertSee('Search');
    }

    /** @test */
    public function can_delete_surat()
    {
        Storage::fake('local');

        $surat = Surat::factory()->create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->call('delete', $surat->id)
            ->assertDispatched('flash');

        $this->assertDatabaseCount('surat', 0);
    }

    /** @test */
    public function only_shows_own_surat()
    {
        $otherPac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
        ]);

        $otherPeriode = Periode::factory()->create([
            'user_id' => $otherPac->id,
        ]);

        Surat::factory()->create([
            'user_id' => $otherPac->id,
            'periode_id' => $otherPeriode->id,
            'no_surat' => 'OTHER/001/2025',
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipSuratComponent::class)
            ->assertDontSee('OTHER/001/2025');
    }
}
