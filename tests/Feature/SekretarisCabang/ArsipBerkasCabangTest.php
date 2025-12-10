<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use App\Models\ArsipBerkasCabang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\ArsipBerkasCabang as ArsipBerkasCabangComponent;

class ArsipBerkasCabangTest extends TestCase
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
    public function arsip_berkas_cabang_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.arsip-berkas-cabang'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_arsip_berkas()
    {
        Storage::fake('local');

        Livewire::actingAs($this->cabang)
            ->test(ArsipBerkasCabangComponent::class)
            ->set('action', 'create')
            ->set('nama', 'Berkas Test')
            ->set('tanggal', '2025-12-10')
            ->set('file', UploadedFile::fake()->create('document.pdf', 1000))
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('arsip_berkas_cabang', 1);
    }

    /** @test */
    public function nama_berkas_is_required()
    {
        Storage::fake('local');

        Livewire::actingAs($this->cabang)
            ->test(ArsipBerkasCabangComponent::class)
            ->set('action', 'create')
            ->set('tanggal', '2025-12-10')
            ->set('file', UploadedFile::fake()->create('document.pdf', 1000))
            ->call('save')
            ->assertHasErrors(['nama']);
    }

    /** @test */
    public function can_delete_arsip_berkas()
    {
        Storage::fake('local');

        $berkas = ArsipBerkasCabang::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'nama' => 'Berkas Test',
            'tanggal' => '2025-12-10',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(ArsipBerkasCabangComponent::class)
            ->call('delete', $berkas->id)
            ->assertDispatched('flash');

        $this->assertDatabaseCount('arsip_berkas_cabang', 0);
    }

    /** @test */
    public function can_search_arsip_berkas()
    {
        ArsipBerkasCabang::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'nama' => 'Berkas Searchable',
            'tanggal' => '2025-12-10',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(ArsipBerkasCabangComponent::class)
            ->set('search', 'Searchable')
            ->assertSee('Berkas Searchable');
    }
}
