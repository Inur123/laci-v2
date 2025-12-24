<?php

namespace Tests\Feature\SekretarisPac;

use App\Models\User;
use App\Models\Periode;
use App\Models\ArsipBerkasPac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisPac\ArsipBerkasPac as ArsipBerkasPacComponent;

class ArsipBerkasPacTest extends TestCase
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
    public function arsip_berkas_pac_page_can_be_rendered()
    {
        $response = $this->actingAs($this->pac)
            ->get(route('pac.arsip-berkas-pac'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_arsip_berkas()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(ArsipBerkasPacComponent::class)
            ->set('action', 'create')
            ->set('nama', 'Berkas Test')
            ->set('tanggal', '2025-12-10')
            ->set('file', UploadedFile::fake()->create('document.pdf', 1000))
            ->call('save');

        $this->assertDatabaseCount('arsip_berkas_pac', 1);
    }

    /** @test */
    public function nama_berkas_is_required()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(ArsipBerkasPacComponent::class)
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

        $berkas = ArsipBerkasPac::create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
            'nama' => 'Berkas Test',
            'tanggal' => '2025-12-10',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipBerkasPacComponent::class)
            ->call('delete', $berkas->id);

        $this->assertDatabaseCount('arsip_berkas_pac', 0);
    }

    /** @test */
    public function can_search_arsip_berkas()
    {
        ArsipBerkasPac::create([
            'user_id' => $this->pac->id,
            'periode_id' => $this->periode->id,
            'nama' => 'Berkas Searchable',
            'tanggal' => '2025-12-10',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipBerkasPacComponent::class)
            ->set('search', 'Searchable')
            ->assertSee('Berkas Searchable');
    }

    /** @test */
    public function only_shows_own_berkas()
    {
        $otherPac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
        ]);

        $otherPeriode = Periode::factory()->create([
            'user_id' => $otherPac->id,
        ]);

        ArsipBerkasPac::create([
            'user_id' => $otherPac->id,
            'periode_id' => $otherPeriode->id,
            'nama' => 'Other PAC Berkas',
            'tanggal' => '2025-12-10',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(ArsipBerkasPacComponent::class)
            ->assertDontSee('Other PAC Berkas');
    }
}
