<?php

namespace Tests\Unit;

use App\Models\KeluhanPelanggan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeluhanPelangganTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_keluhan_by_id()
    {
        $keluhan = KeluhanPelanggan::factory()->create();

        $response = $this->getJson("/api/keluhan-pelanggan/{$keluhan->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $keluhan->id,
                    'nama' => $keluhan->nama,
                    'email' => $keluhan->email,
                    'nomor_hp' => $keluhan->nomor_hp,
                    'status_keluhan' => $keluhan->status_keluhan,
                    'keluhan' => $keluhan->keluhan,
                    'created_at' => $keluhan->created_at->format('Y-m-d H:i:s'),
                ]
            ]);
    }
}
