<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use App\Models\JenisFasilitas;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $stats = [
            'total'     => FasilitasKesehatan::count(),
            'rs'        => FasilitasKesehatan::whereHas('jenisFasilitas', fn($q) => $q->where('nama_jenis', 'Rumah Sakit'))->count(),
            'puskesmas' => FasilitasKesehatan::whereHas('jenisFasilitas', fn($q) => $q->where('nama_jenis', 'Puskesmas'))->count(),
            'klinik'    => FasilitasKesehatan::whereHas('jenisFasilitas', fn($q) => $q->where('nama_jenis', 'Klinik'))->count(),
            'apotek'    => FasilitasKesehatan::whereHas('jenisFasilitas', fn($q) => $q->where('nama_jenis', 'Apotek'))->count(),
            'optik'     => FasilitasKesehatan::whereHas('jenisFasilitas', fn($q) => $q->where('nama_jenis', 'Optik'))->count(),
        ];

        $jenis = JenisFasilitas::withCount('fasilitasKesehatan')->get();

        return view('map.index', compact('stats', 'jenis'));
    }

    public function geojson(Request $request)
    {
        $query = FasilitasKesehatan::with('jenisFasilitas');

        if ($request->jenis) {
            $query->whereHas('jenisFasilitas', fn($q) => $q->where('nama_jenis', $request->jenis));
        }

        $features = $query->get()->map(fn($f) => [
            'type'     => 'Feature',
            'geometry' => [
                'type'        => 'Point',
                'coordinates' => [(float) $f->longitude, (float) $f->latitude],
            ],
            'properties' => [
                'id'              => $f->id,
                'nama'            => $f->nama_faskes,
                'jenis'           => $f->jenisFasilitas->nama_jenis,
                'kategori'        => $f->kategori,
                'warna'           => $f->jenisFasilitas->warna_marker,
                'alamat'          => $f->alamat,
                'kelurahan'       => $f->kelurahan,
                'kecamatan'       => $f->kecamatan,
                'telepon'         => $f->telepon ?? '-',
                'jam'             => $f->jam_operasional ?? '-',
                'bpjs'            => $f->bpjs ? 'Ya' : 'Tidak',
                'status'          => $f->status,
                'link_maps'       => $f->link_googlemaps,
            ],
        ]);

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
