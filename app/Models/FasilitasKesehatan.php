<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasKesehatan extends Model
{
    protected $table = 'fasilitas_kesehatan';

    protected $fillable = [
        'kode_faskes',
        'nama_faskes',
        'jenis_faskes_id',
        'kategori',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'telepon',
        'jam_operasional',
        'kapasitas_tempat_tidur',
        'akreditasi',
        'status_kepemilikan',
        'kelas_rs',
        'bpjs',
        'latitude',
        'longitude',
        'link_googlemaps',
        'status',
    ];

    protected $casts = [
        'bpjs'      => 'boolean',
        'latitude'  => 'float',
        'longitude' => 'float',
        'kapasitas_tempat_tidur' => 'integer',
    ];

    public function jenisFasilitas()
    {
        return $this->belongsTo(JenisFasilitas::class, 'jenis_faskes_id');
    }
}
