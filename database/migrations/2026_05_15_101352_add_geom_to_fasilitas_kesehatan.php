<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aktifkan ekstensi PostGIS (aman dijalankan berkali-kali)
        DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');

        // Tambah kolom geom
        DB::statement('ALTER TABLE fasilitas_kesehatan ADD COLUMN IF NOT EXISTS geom geometry(Point, 4326)');

        // Isi kolom geom dari data lat/lon yang sudah ada
        DB::statement('
        UPDATE fasilitas_kesehatan
        SET geom = ST_SetSRID(ST_MakePoint(longitude, latitude), 4326)
        WHERE latitude IS NOT NULL AND longitude IS NOT NULL
    ');

        // Buat spatial index GIST
        DB::statement('CREATE INDEX IF NOT EXISTS idx_faskes_geom ON fasilitas_kesehatan USING GIST(geom)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS idx_faskes_geom');
        DB::statement('ALTER TABLE fasilitas_kesehatan DROP COLUMN IF EXISTS geom');
    }
};
