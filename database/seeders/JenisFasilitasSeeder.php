<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisFasilitas;

class JenisFasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_jenis'    => 'Rumah Sakit',
                'warna_marker'  => '#EF4444',
                'ikon'          => 'rs',
                'keterangan'    => 'Rumah Sakit Umum dan Khusus',
            ],
            [
                'nama_jenis'    => 'Puskesmas',
                'warna_marker'  => '#22C55E',
                'ikon'          => 'pkm',
                'keterangan'    => 'Puskesmas dan Puskesmas Pembantu',
            ],
            [
                'nama_jenis'    => 'Klinik',
                'warna_marker'  => '#8B5CF6',
                'ikon'          => 'klinik',
                'keterangan'    => 'Klinik Pratama, Klinik Utama, dan Dokter Praktik',
            ],
            [
                'nama_jenis'    => 'Apotek',
                'warna_marker'  => '#F97316',
                'ikon'          => 'apotek',
                'keterangan'    => 'Apotek dan Instalasi Farmasi',
            ],
            [
                'nama_jenis'    => 'Optik',
                'warna_marker'  => '#06B6D4',
                'ikon'          => 'optik',
                'keterangan'    => 'Optik dan Klinik Mata',
            ],
        ];

        foreach ($data as $d) {
            JenisFasilitas::create($d);
        }
    }
}
