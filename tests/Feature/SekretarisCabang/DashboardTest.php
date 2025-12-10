<?php

namespace Tests\Feature\SekretarisCabang;

use App\Models\User;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
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
    public function dashboard_page_can_be_rendered()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function dashboard_shows_periode_aktif()
    {
        $response = $this->actingAs($this->cabang)
            ->get(route('cabang.dashboard'));

        $response->assertSee($this->periode->nama);
    }
}
