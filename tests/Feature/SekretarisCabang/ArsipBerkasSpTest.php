<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use App\Models\ArsipBerkasSp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\ArsipBerkasSp as ArsipBerkasSpComponent;

class ArsipBerkasSpTest extends TestCase
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
    public function arsip_berkas_sp_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.arsip-berkas-sp'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_sp_berkas()
    {
        $berkas = ArsipBerkasSp::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'nama' => 'Berkas SP Test',
            'tanggal_mulai' => '2025-12-10',
            'tanggal_berakhir' => '2025-12-15',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(ArsipBerkasSpComponent::class)
            ->assertStatus(200);

        $this->assertDatabaseCount('arsip_berkas_sp', 1);
    }

    /** @test */
    public function can_search_berkas()
    {
        ArsipBerkasSp::create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'nama' => 'Berkas Searchable',
            'tanggal_mulai' => '2025-12-10',
            'tanggal_berakhir' => '2025-12-15',
            'file_path' => 'test.pdf',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(ArsipBerkasSpComponent::class)
            ->set('search', 'Searchable')
            ->assertSet('search', 'Searchable');
    }
}
