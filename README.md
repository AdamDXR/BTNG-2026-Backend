# Showroom Mobil API

RESTful API untuk manajemen data showroom mobil, dibuat sebagai Tugas Akhir Kelas Website Backend BTNG 2026 menggunakan **Laravel 12** dan **MySQL**.

## Link Live

| Keterangan | URL |
| --- | --- |
| Base URL API | `https://btng-2026-backend.cleverapps.io/api` |
| Dokumentasi (Scramble) | `https://btng-2026-backend.cleverapps.io/docs/api` |

## Fitur

- CRUD data mobil (5 endpoint RESTful)
- Validasi input dengan pesan error berbahasa Indonesia
- Respons seragam menggunakan API Resource dengan amplop `message` dan `data`
- Pencarian, filter, dan pagination pada daftar mobil
- Dokumentasi API interaktif di `/docs/api`
- Seeder berisi 10 data mobil
- Feature test untuk seluruh endpoint mobil

## Teknologi

- PHP 8.2+
- Laravel 12
- MySQL
- Scramble (`dedoc/scramble`)

## Instalasi Lokal

1. Clone repository

   ```bash
   git clone https://github.com/AdamDXR/BTNG-2026-Backend.git
   cd BTNG-2026-Backend
   ```

2. Install dependency

   ```bash
   composer install
   ```

3. Salin file environment lalu generate key

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Buat database MySQL kosong (misalnya `showroom_mobil` lewat Laragon/XAMPP), lalu sesuaikan bagian ini di `.env`

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=showroom_mobil
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Jalankan migration dan seeder

   ```bash
   php artisan migrate --seed
   ```

6. Jalankan server

   ```bash
   php artisan serve
   ```

API dapat diakses di `http://127.0.0.1:8000/api/mobil` dan dokumentasi di `http://127.0.0.1:8000/docs/api`.

## Daftar Endpoint

| Method | Endpoint | Keterangan | Status Sukses |
| --- | --- | --- | --- |
| GET | `/api/mobil` | Mengambil daftar mobil | 200 OK |
| GET | `/api/mobil/{id}` | Mengambil detail mobil | 200 OK |
| POST | `/api/mobil` | Menambahkan mobil baru | 201 Created |
| PUT/PATCH | `/api/mobil/{id}` | Memperbarui data mobil | 200 OK |
| DELETE | `/api/mobil/{id}` | Menghapus data mobil | 200 OK |

### Query Parameter `GET /api/mobil`

| Parameter | Contoh | Keterangan |
| --- | --- | --- |
| `search` | `?search=avanza` | Cari berdasarkan nama atau brand |
| `brand` | `?brand=Toyota` | Filter brand |
| `transmisi` | `?transmisi=CVT` | `Manual`, `Matic`, `CVT` |
| `bahan_bakar` | `?bahan_bakar=Hybrid` | `Bensin`, `Diesel`, `Hybrid`, `Listrik` |
| `status` | `?status=tersedia` | `tersedia`, `sold` |
| `per_page` | `?per_page=5` | Jumlah data per halaman (1-100, default 10) |
| `page` | `?page=2` | Nomor halaman |

## Atribut Mobil

| Field | Tipe | Aturan |
| --- | --- | --- |
| `nama` | string | wajib, maks 100 karakter |
| `brand` | string | wajib, maks 50 karakter |
| `harga` | integer | wajib, minimal 0 (Rupiah) |
| `tahun` | integer | wajib, 1950 sampai tahun depan |
| `transmisi` | string | wajib, `Manual` / `Matic` / `CVT` |
| `bahan_bakar` | string | wajib, `Bensin` / `Diesel` / `Hybrid` / `Listrik` |
| `status` | string | opsional, `tersedia` / `sold` (default `tersedia`) |
| `foto` | string | opsional, URL valid |

## Contoh Respons

**Berhasil mengambil data (200)**

```json
{
    "data": [
        {
            "id": 1,
            "nama": "Avanza 1.5 G CVT",
            "brand": "Toyota",
            "harga": 275000000,
            "tahun": 2024,
            "transmisi": "CVT",
            "bahan_bakar": "Bensin",
            "status": "tersedia",
            "foto": "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2"
        }
    ],
    "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
    "meta": { "current_page": 1, "last_page": 1, "per_page": 10, "total": 10 },
    "message": "Daftar mobil berhasil diambil"
}
```

**Berhasil menambahkan data (201)**

```json
{
    "data": {
        "id": 11,
        "nama": "Civic RS Turbo",
        "brand": "Honda",
        "harga": 615000000,
        "tahun": 2024,
        "transmisi": "CVT",
        "bahan_bakar": "Bensin",
        "status": "tersedia",
        "foto": null
    },
    "message": "Data mobil berhasil ditambahkan"
}
```

**Validasi gagal (422)**

```json
{
    "message": "Kolom nama mobil wajib diisi. (and 1 more error)",
    "errors": {
        "nama": ["Kolom nama mobil wajib diisi."],
        "harga": ["Kolom harga harus berupa angka."]
    }
}
```

**Data tidak ditemukan (404)**

```json
{
    "message": "Data tidak ditemukan"
}
```

## Testing

```bash
php artisan test --filter=MobilApiTest
```

Test berjalan di SQLite memory, sehingga tidak mengubah data di database MySQL.

## Postman

Collection Postman tersedia di `postman/Showroom-Mobil-API.postman_collection.json`. Ubah variabel `base_url` sesuai alamat server.
