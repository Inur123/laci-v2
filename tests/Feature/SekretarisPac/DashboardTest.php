<?php

namespace Tests\Feature\SekretarisPac;

use App\Models\User;
use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
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
    public function dashboard_page_can_be_rendered()
    {
        $response = $this->actingAs($this->pac)
            ->get(route('pac.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function dashboard_shows_periode_aktif()
    {
        $response = $this->actingAs($this->pac)
            ->get(route('pac.dashboard'));

        $response->assertSee($this->periode->nama);
    }
}
