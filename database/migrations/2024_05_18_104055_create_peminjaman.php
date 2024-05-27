<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('durasi_pinjam', function (Blueprint $table) {
            $table->id('id_durasi');
            $table->string('nama');
            $table->integer('durasi');
            $table->timestamps();
        });
        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda');
            $table->string('nama');
            $table->integer('denda');
            $table->timestamps();
        });
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('nomor_peminjaman')->primary();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
                $table->unsignedBigInteger('id_durasi')->nullable();
                $table->foreign('id_durasi')->references('id_durasi')->on('durasi_pinjam');
                $table->unsignedBigInteger('id_denda')->nullable();
                $table->foreign('id_denda')->references('id_denda')->on('denda');
                $table->timestamp('tanggal_peminjaman')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        /**
        * Reverse the migrations.
        */
        public function down(): void
        {
            Schema::dropIfExists('peminjaman');
            Schema::dropIfExists('durasi_pinjam');
            Schema::dropIfExists('denda');
        }
    };
