<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MobilResource;
use App\Models\Mobil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class MobilController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:50'],
            'transmisi' => ['nullable', Rule::in(Mobil::TRANSMISI)],
            'bahan_bakar' => ['nullable', Rule::in(Mobil::BAHAN_BAKAR)],
            'status' => ['nullable', Rule::in(Mobil::STATUS)],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ], $this->messages(), $this->attributes());

        $mobil = Mobil::query()
            ->filter($filters)
            ->orderBy('id')
            ->paginate($filters['per_page'] ?? 10)
            ->withQueryString();

        return MobilResource::collection($mobil)
            ->additional(['message' => 'Daftar mobil berhasil diambil']);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'brand' => ['required', 'string', 'max:50'],
            'harga' => ['required', 'integer', 'min:0'],
            'tahun' => ['required', 'integer', 'min:1950', 'max:'.(now()->year + 1)],
            'transmisi' => ['required', Rule::in(Mobil::TRANSMISI)],
            'bahan_bakar' => ['required', Rule::in(Mobil::BAHAN_BAKAR)],
            'status' => ['sometimes', Rule::in(Mobil::STATUS)],
            'foto' => ['nullable', 'url', 'max:255'],
        ], $this->messages(), $this->attributes());

        $mobil = Mobil::create($data);

        return (new MobilResource($mobil))
            ->additional(['message' => 'Data mobil berhasil ditambahkan'])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Mobil $mobil): MobilResource
    {
        return (new MobilResource($mobil))
            ->additional(['message' => 'Detail mobil berhasil diambil']);
    }

    public function update(Request $request, Mobil $mobil): MobilResource
    {
        $data = $request->validate([
            'nama' => ['sometimes', 'required', 'string', 'max:100'],
            'brand' => ['sometimes', 'required', 'string', 'max:50'],
            'harga' => ['sometimes', 'required', 'integer', 'min:0'],
            'tahun' => ['sometimes', 'required', 'integer', 'min:1950', 'max:'.(now()->year + 1)],
            'transmisi' => ['sometimes', 'required', Rule::in(Mobil::TRANSMISI)],
            'bahan_bakar' => ['sometimes', 'required', Rule::in(Mobil::BAHAN_BAKAR)],
            'status' => ['sometimes', 'required', Rule::in(Mobil::STATUS)],
            'foto' => ['sometimes', 'nullable', 'url', 'max:255'],
        ], $this->messages(), $this->attributes());

        $mobil->update($data);

        return (new MobilResource($mobil))
            ->additional(['message' => 'Data mobil berhasil diperbarui']);
    }

    public function destroy(Mobil $mobil): MobilResource
    {
        $mobil->delete();

        return (new MobilResource($mobil))
            ->additional(['message' => 'Data mobil berhasil dihapus']);
    }

    private function messages(): array
    {
        return [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'integer' => 'Kolom :attribute harus berupa angka.',
            'url' => 'Kolom :attribute harus berupa URL yang valid.',
            'in' => 'Kolom :attribute harus salah satu dari: :values.',
            'min' => [
                'numeric' => 'Kolom :attribute minimal :min.',
            ],
            'max' => [
                'numeric' => 'Kolom :attribute maksimal :max.',
                'string' => 'Kolom :attribute maksimal :max karakter.',
            ],
        ];
    }

    private function attributes(): array
    {
        return [
            'nama' => 'nama mobil',
            'bahan_bakar' => 'bahan bakar',
            'per_page' => 'jumlah per halaman',
        ];
    }
}
