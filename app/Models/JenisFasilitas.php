<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisFasilitas extends Model
{
    protected $table = 'jenis_fasilitas';

    protected $fillable = [
        'nama_jenis',
        'ikon',
        'warna_marker',
        'keterangan',
    ];

    public function fasilitasKesehatan()
    {
        return $this->hasMany(FasilitasKesehatan::class, 'jenis_faskes_id');
    }
}
