<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penerbit', function (Blueprint $table) { 
            $table->id('id_penerbit');
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('posisi', function (Blueprint $table) {
            $table->id('id_posisi');
            $table->string('posisi');
            $table->timestamps();
        });

        Schema::create('buku', function (Blueprint $table) {
            $table->string('nomor_buku')->primary();
            $table->unsignedBigInteger('id_posisi')->nullable();
            $table->foreign('id_posisi')->references('id_posisi')->on('posisi')->onDelete('no action')->nullable();
            $table->unsignedBigInteger('id_penerbit')->nullable();
            $table->foreign('id_penerbit')->references('id_penerbit')->on('penerbit')->nullable();
            $table->string('judul_buku');
            $table->string('pengarang')->nullable();
            $table->string('image')->nullable();
            $table->integer('ketersediaan') ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
        Schema::dropIfExists('posisi');
        Schema::dropIfExists('penerbit');
    }
};
