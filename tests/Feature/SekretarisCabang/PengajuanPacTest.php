<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use App\Models\PengajuanSuratPac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\PengajuanPac;

class PengajuanPacTest extends TestCase
{
    use RefreshDatabase;

    protected $cabang;
    protected $pac;
    protected $periode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cabang = User::factory()->create([
            'role' => 'sekretaris_cabang',
            'email_verified_at' => now(),
        ]);

        $this->pac = User::factory()->create([
            'role' => 'sekretaris_pac',
            'email_verified_at' => now(),
        ]);

        $this->periode = Periode::factory()->create([
            'user_id' => $this->cabang->id,
        ]);

        $this->cabang->update(['periode_aktif_id' => $this->periode->id]);
    }

    /** @test */
    public function pengajuan_pac_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.pengajuan-pac'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_pengajuan_list()
    {
        $pengajuan = PengajuanSuratPac::create([
            'user_id' => $this->pac->id,
            'periode_id_pac' => $this->periode->id,
            'no_surat' => 'TEST/001/2025',
            'penerima' => 'ipnu',
            'tanggal' => '2025-12-10',
            'keperluan' => 'Test Pengajuan',
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(PengajuanPac::class)
            ->assertStatus(200);

        $this->assertDatabaseCount('pengajuan_surat_pac', 1);
    }

    /** @test */
    public function can_filter_by_status()
    {
        PengajuanSuratPac::create([
            'user_id' => $this->pac->id,
            'periode_id_pac' => $this->periode->id,
            'no_surat' => 'TEST/001/2025',
            'penerima' => 'ipnu',
            'tanggal' => '2025-12-10',
            'keperluan' => 'Test Pending',
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(PengajuanPac::class)
            ->set('filterStatus', 'pending')
            ->assertSet('filterStatus', 'pending');
    }
}
