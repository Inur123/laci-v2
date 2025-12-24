<?php

namespace Tests\Feature\SekretarisPac;

use App\Models\User;
use App\Models\Periode;
use App\Models\PengajuanSuratPac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisPac\PengajuanSurat;

class PengajuanSuratTest extends TestCase
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
    public function pengajuan_surat_page_can_be_rendered()
    {
        $response = $this->actingAs($this->pac)
            ->get(route('pac.pengajuan-surat'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_pengajuan()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->set('action', 'create')
            ->set('penerima', 'ipnu')
            ->set('no_surat', 'PG/001/2025')
            ->set('keperluan', 'Test Pengajuan')
            ->set('tanggal', '2025-12-10')
            ->set('file', UploadedFile::fake()->create('pengajuan.pdf', 1000))
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseCount('pengajuan_surat_pac', 1);
    }

    /** @test */
    public function no_surat_is_required()
    {
        Storage::fake('local');

        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->set('action', 'create')
            ->set('penerima', 'ipnu')
            ->set('tanggal', '2025-12-10')
            ->set('file', UploadedFile::fake()->create('pengajuan.pdf', 1000))
            ->call('save')
            ->assertHasErrors(['no_surat']);
    }

    /** @test */
    public function keperluan_is_required()
    {
        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->set('action', 'create')
            ->set('penerima', 'ipnu')
            ->set('no_surat', 'PG/001/2025')
            ->set('tanggal', '2025-12-10')
            ->call('save')
            ->assertHasErrors(['keperluan']);
    }

    /** @test */
    public function can_filter_by_status()
    {
        PengajuanSuratPac::create([
            'user_id' => $this->pac->id,
            'periode_id_pac' => $this->periode->id,
            'no_surat' => 'PG/001/2025',
            'penerima' => 'ipnu',
            'tanggal' => '2025-12-10',
            'keperluan' => 'Test',
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->set('filterStatus', 'pending')
            ->assertSee('PG/001/2025');
    }

    /** @test */
    public function can_search_pengajuan()
    {
        PengajuanSuratPac::create([
            'user_id' => $this->pac->id,
            'periode_id_pac' => $this->periode->id,
            'no_surat' => 'SEARCH/001/2025',
            'penerima' => 'ipnu',
            'tanggal' => '2025-12-10',
            'keperluan' => 'Searchable',
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->set('search', 'Searchable')
            ->assertSee('Searchable');
    }

    /** @test */
    public function can_delete_pengajuan()
    {
        Storage::fake('local');

        $pengajuan = PengajuanSuratPac::create([
            'user_id' => $this->pac->id,
            'periode_id_pac' => $this->periode->id,
            'no_surat' => 'PG/001/2025',
            'penerima' => 'ipnu',
            'tanggal' => '2025-12-10',
            'keperluan' => 'Test',
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->call('delete', $pengajuan->id)
            ->assertDispatched('flash');

        $this->assertDatabaseCount('pengajuan_surat_pac', 0);
    }

    /** @test */
    public function only_shows_own_pengajuan()
    {
        $otherPac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
        ]);

        $otherPeriode = Periode::factory()->create([
            'user_id' => $otherPac->id,
        ]);

        PengajuanSuratPac::create([
            'user_id' => $otherPac->id,
            'periode_id_pac' => $otherPeriode->id,
            'no_surat' => 'OTHER/001/2025',
            'penerima' => 'ipnu',
            'tanggal' => '2025-12-10',
            'keperluan' => 'Other PAC',
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Livewire::actingAs($this->pac)
            ->test(PengajuanSurat::class)
            ->assertDontSee('Other PAC');
    }
}
