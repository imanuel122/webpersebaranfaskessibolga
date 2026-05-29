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
        Schema::create('fasilitas_kesehatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_faskes', 20)->unique();
            $table->string('nama_faskes', 255);
            $table->foreignId('jenis_faskes_id')->constrained('jenis_fasilitas');
            $table->string('kategori', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('jam_operasional', 50)->nullable();
            $table->integer('kapasitas_tempat_tidur')->default(0);
            $table->string('akreditasi', 50)->nullable();
            $table->string('status_kepemilikan', 50)->nullable();
            $table->string('kelas_rs', 30)->nullable();
            $table->boolean('bpjs')->default(false);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('link_googlemaps')->nullable();
            $table->string('status', 20)->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas_kesehatan');
    }
};
