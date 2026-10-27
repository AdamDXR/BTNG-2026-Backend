<?php

namespace Tests\Feature;

use App\Models\Mobil;
use Database\Seeders\MobilSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobilApiTest extends TestCase
{
    use RefreshDatabase;

    private array $payload = [
        'nama' => 'Civic RS Turbo',
        'brand' => 'Honda',
        'harga' => 615000000,
        'tahun' => 2024,
        'transmisi' => 'CVT',
        'bahan_bakar' => 'Bensin',
        'foto' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888',
    ];

    public function test_menampilkan_daftar_mobil(): void
    {
        $this->seed(MobilSeeder::class);

        $this->getJson('/api/mobil')
            ->assertOk()
            ->assertJsonPath('message', 'Daftar mobil berhasil diambil')
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure(['data' => [['id', 'nama', 'brand', 'harga', 'tahun', 'transmisi', 'bahan_bakar', 'status', 'foto']]]);
    }

    public function test_filter_dan_pencarian_mobil(): void
    {
        $this->seed(MobilSeeder::class);

        $this->getJson('/api/mobil?brand=Toyota&status=tersedia')
            ->assertOk()
            ->assertJsonCount(3, 'data');

        $this->getJson('/api/mobil?search=avanza')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.nama', 'Avanza 1.5 G CVT');
    }

    public function test_menambahkan_mobil(): void
    {
        $this->postJson('/api/mobil', $this->payload)
            ->assertCreated()
            ->assertJsonPath('message', 'Data mobil berhasil ditambahkan')
            ->assertJsonPath('data.nama', 'Civic RS Turbo')
            ->assertJsonPath('data.status', 'tersedia');

        $this->assertDatabaseHas('mobils', ['nama' => 'Civic RS Turbo']);
    }

    public function test_validasi_gagal_saat_data_tidak_lengkap(): void
    {
        $this->post('/api/mobil', ['harga' => 'mahal', 'transmisi' => 'Otomatis'])
            ->assertUnprocessable()
            ->assertJsonPath('errors.nama.0', 'Kolom nama mobil wajib diisi.')
            ->assertJsonPath('errors.harga.0', 'Kolom harga harus berupa angka.')
            ->assertJsonPath('errors.transmisi.0', 'Kolom transmisi harus salah satu dari: Manual, Matic, CVT.');
    }

    public function test_menampilkan_detail_mobil(): void
    {
        $mobil = Mobil::create($this->payload);

        $this->getJson("/api/mobil/{$mobil->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $mobil->id);
    }

    public function test_mobil_tidak_ditemukan(): void
    {
        $this->getJson('/api/mobil/999')
            ->assertNotFound()
            ->assertJsonPath('message', 'Data tidak ditemukan');
    }

    public function test_memperbarui_mobil(): void
    {
        $mobil = Mobil::create($this->payload);

        $this->patchJson("/api/mobil/{$mobil->id}", ['status' => 'sold', 'harga' => 600000000])
            ->assertOk()
            ->assertJsonPath('message', 'Data mobil berhasil diperbarui')
            ->assertJsonPath('data.status', 'sold')
            ->assertJsonPath('data.harga', 600000000);
    }

    public function test_menghapus_mobil(): void
    {
        $mobil = Mobil::create($this->payload);

        $this->deleteJson("/api/mobil/{$mobil->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Data mobil berhasil dihapus');

        $this->assertDatabaseMissing('mobils', ['id' => $mobil->id]);
    }
}
