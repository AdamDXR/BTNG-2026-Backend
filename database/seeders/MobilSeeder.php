<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        $daftarMobil = [
            [
                'nama' => 'Avanza 1.5 G CVT',
                'brand' => 'Toyota',
                'harga' => 275000000,
                'tahun' => 2024,
                'transmisi' => 'CVT',
                'bahan_bakar' => 'Bensin',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2',
            ],
            [
                'nama' => 'Civic RS Turbo',
                'brand' => 'Honda',
                'harga' => 615000000,
                'tahun' => 2024,
                'transmisi' => 'CVT',
                'bahan_bakar' => 'Bensin',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888',
            ],
            [
                'nama' => 'Xpander Ultimate CVT',
                'brand' => 'Mitsubishi',
                'harga' => 331000000,
                'tahun' => 2023,
                'transmisi' => 'CVT',
                'bahan_bakar' => 'Bensin',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a',
            ],
            [
                'nama' => 'Pajero Sport Dakar 4x2',
                'brand' => 'Mitsubishi',
                'harga' => 622000000,
                'tahun' => 2023,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Diesel',
                'status' => 'sold',
                'foto' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf',
            ],
            [
                'nama' => 'Fortuner 2.8 GR Sport',
                'brand' => 'Toyota',
                'harga' => 725000000,
                'tahun' => 2024,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Diesel',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c',
            ],
            [
                'nama' => 'Ioniq 5 Signature Long Range',
                'brand' => 'Hyundai',
                'harga' => 859000000,
                'tahun' => 2024,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Listrik',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1617788138017-80ad40651399',
            ],
            [
                'nama' => 'Kijang Innova Zenix Q Hybrid',
                'brand' => 'Toyota',
                'harga' => 610000000,
                'tahun' => 2024,
                'transmisi' => 'CVT',
                'bahan_bakar' => 'Hybrid',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8',
            ],
            [
                'nama' => 'Ertiga Hybrid GX',
                'brand' => 'Suzuki',
                'harga' => 290000000,
                'tahun' => 2023,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Hybrid',
                'status' => 'sold',
                'foto' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d',
            ],
            [
                'nama' => 'Brio RS',
                'brand' => 'Honda',
                'harga' => 256000000,
                'tahun' => 2024,
                'transmisi' => 'Manual',
                'bahan_bakar' => 'Bensin',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1542362567-b07e54358753',
            ],
            [
                'nama' => 'Air ev Long Range',
                'brand' => 'Wuling',
                'harga' => 299000000,
                'tahun' => 2024,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Listrik',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6',
            ],
        ];

        foreach ($daftarMobil as $mobil) {
            Mobil::updateOrCreate(['nama' => $mobil['nama']], $mobil);
        }
    }
}
