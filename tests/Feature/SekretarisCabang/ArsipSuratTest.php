<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Surat;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\ArsipSurat;

class ArsipSuratTest extends TestCase
{
    use RefreshDatabase;

    protected $cabang;
    protected $periode;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

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
    public function arsip_surat_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.arsip-surat'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_surat_masuk()
    {
        $file = UploadedFile::fake()->create('surat.pdf', 100);

        Livewire::actingAs($this->cabang)
            ->test(ArsipSurat::class)
            ->call('create')
            ->set('jenis_surat', 'masuk')
            ->set('no_surat', '001/TEST/2025')
            ->set('tanggal', '2025-01-01')
            ->set('perihal', 'Test Surat')
            ->set('pengirim_penerima', 'Pengirim Test')
            ->set('deskripsi', 'Deskripsi test')
            ->set('file', $file)
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('surat', [
            'periode_id' => $this->periode->id,
        ]);

        $this->assertDatabaseCount('surat', 1);
    }

    /** @test */
    public function can_create_surat_keluar()
    {
        $file = UploadedFile::fake()->create('surat.pdf', 100);

        Livewire::actingAs($this->cabang)
            ->test(ArsipSurat::class)
            ->call('create')
            ->set('jenis_surat', 'keluar')
            ->set('no_surat', '001/TEST/2025')
            ->set('tanggal', '2025-01-01')
            ->set('perihal', 'Test Surat')
            ->set('pengirim_penerima', 'Penerima Test')
            ->set('file', $file)
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('surat', 1);
    }

    /** @test */
    public function no_surat_is_required()
    {
        Livewire::actingAs($this->cabang)
            ->test(ArsipSurat::class)
            ->call('create')
            ->set('no_surat', '')
            ->call('save')
            ->assertHasErrors(['no_surat' => 'required']);
    }

    /** @test */
    public function can_filter_by_jenis()
    {
        $suratMasuk = Surat::factory()->create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'jenis_surat' => 'masuk',
        ]);

        $suratKeluar = Surat::factory()->create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'jenis_surat' => 'keluar',
        ]);

        $component = Livewire::actingAs($this->cabang)
            ->test(ArsipSurat::class)
            ->set('filterJenis', 'masuk');

        $this->assertDatabaseHas('surat', [
            'id' => $suratMasuk->id,
            'periode_id' => $this->periode->id,
        ]);
    }

    /** @test */
    public function can_search_surat()
    {
        $surat = Surat::factory()->create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'no_surat' => '001/TEST/2025',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(ArsipSurat::class)
            ->set('search', '001');

        $this->assertDatabaseHas('surat', [
            'id' => $surat->id,
        ]);
    }

    /** @test */
    public function can_delete_surat()
    {
        $surat = Surat::factory()->create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
        ]);

        Livewire::actingAs($this->cabang)
            ->test(ArsipSurat::class)
            ->call('delete', $surat->id);

        $this->assertDatabaseMissing('surat', [
            'id' => $surat->id,
        ]);
    }
}
