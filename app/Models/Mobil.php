<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    public const TRANSMISI = ['Manual', 'Matic', 'CVT'];

    public const BAHAN_BAKAR = ['Bensin', 'Diesel', 'Hybrid', 'Listrik'];

    public const STATUS = ['tersedia', 'sold'];

    protected $fillable = [
        'nama',
        'brand',
        'harga',
        'tahun',
        'transmisi',
        'bahan_bakar',
        'status',
        'foto',
    ];

    protected $attributes = [
        'status' => 'tersedia',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'tahun' => 'integer',
        ];
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        });

        foreach (['brand', 'transmisi', 'bahan_bakar', 'status'] as $column) {
            $query->when($filters[$column] ?? null, fn (Builder $query, string $value) => $query->where($column, $value));
        }
    }
}
