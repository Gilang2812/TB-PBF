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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->string('nomor_peminjaman');
            $table->string('nomor_buku');
            $table->primary(['nomor_peminjaman','nomor_buku']);
            $table->foreign('nomor_peminjaman')->references('nomor_peminjaman')->on('peminjaman');
            $table->foreign('nomor_buku')->references('nomor_buku')->on('buku');
            $table->date('tanggal_pengembalian')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
