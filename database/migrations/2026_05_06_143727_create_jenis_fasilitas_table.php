<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenis_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis', 100)->unique();
            $table->string('ikon', 100)->nullable();
            $table->string('warna_marker', 10)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_fasilitas');
    }
};
