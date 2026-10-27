<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('brand', 50);
            $table->unsignedBigInteger('harga');
            $table->unsignedSmallInteger('tahun');
            $table->string('transmisi', 10);
            $table->string('bahan_bakar', 10);
            $table->string('status', 10)->default('tersedia');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
