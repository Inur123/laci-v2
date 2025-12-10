<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\SekretarisCabang\DataAnggota\Anggota as AnggotaComponent;

class AnggotaTest extends TestCase
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
    public function anggota_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.data-anggota'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_anggota()
    {
        Livewire::actingAs($this->cabang)
            ->test(AnggotaComponent::class)
            ->call('create')
            ->set('nama_lengkap', 'John Doe')
            ->set('nik', '1234567890123456')
            ->set('nia', '1234567890')
            ->set('email', 'john@example.com')
            ->set('tempat_lahir', 'Jakarta')
            ->set('tanggal_lahir', '2000-01-01')
            ->set('jenis_kelamin', 'Laki-laki')
            ->set('alamat_lengkap', 'Jalan Test No. 123')
            ->set('no_hp', '081234567890')
            ->set('hobi', 'Membaca')
            ->set('jabatan', 'Anggota Biasa')
            ->call('save')
            ->assertDispatched('flash');

        $this->assertDatabaseHas('anggotas', [
            'periode_id' => $this->periode->id,
        ]);

        $this->assertDatabaseCount('anggotas', 1);
    }

    /** @test */
    public function nama_is_required()
    {
        Livewire::actingAs($this->cabang)
            ->test(AnggotaComponent::class)
            ->call('create')
            ->set('nama_lengkap', '')
            ->call('save')
            ->assertHasErrors(['nama_lengkap' => 'required']);
    }

    /** @test */
    public function email_must_be_valid()
    {
        Livewire::actingAs($this->cabang)
            ->test(AnggotaComponent::class)
            ->call('create')
            ->set('email', 'invalid-email')
            ->call('save')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function can_edit_anggota()
    {
        $anggota = Anggota::factory()->create([
            'user_id' => $this->cabang->id,
            'periode_id' => $this->periode->id,
            'nama_lengkap' => 'Old Name',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Livewire::actingAs($this->cabang)
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
            'periode_id' => $this->periode->id,
        ]);

        Livewire::actingAs($this->cabang)
            ->test(AnggotaComponent::class)
            ->call('delete', $anggota->id);

        $this->assertDatabaseMissing('anggotas', [
            'id' => $anggota->id,
        ]);
    }

    /** @test */
    public function can_search_anggota()
    {
        Anggota::factory()->create([
            'periode_id' => $this->periode->id,
            'nama_lengkap' => 'John Doe',
        ]);

        Anggota::factory()->create([
            'periode_id' => $this->periode->id,
            'nama_lengkap' => 'Jane Smith',
        ]);

        Livewire::actingAs($this->cabang)
            ->test(AnggotaComponent::class)
            ->set('search', 'John')
            ->assertSee('John');
    }
}
