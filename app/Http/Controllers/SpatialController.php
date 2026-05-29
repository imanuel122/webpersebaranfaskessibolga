<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpatialController extends Controller
{
    /**
     * ① Cari faskes terdekat dari koordinat user (Nearest Neighbor)
     */
    public function terdekat(Request $request)
    {
        $lat = $request->input('lat', 1.7417);   // default: tengah Sibolga
        $lon = $request->input('lon', 98.7792);
        $limit = $request->input('limit', 5);

        $hasil = DB::select("
            SELECT
                f.id,
                f.nama_faskes,
                f.alamat,
                f.kecamatan,
                j.nama_jenis,
                f.telepon,
                f.bpjs,
                ROUND(
                    ST_Distance(
                        f.geom::geography,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                    )::numeric, 2
                ) AS jarak_meter
            FROM fasilitas_kesehatan f
            LEFT JOIN jenis_fasilitas j ON j.id = f.jenis_faskes_id
            WHERE f.geom IS NOT NULL
            ORDER BY f.geom <-> ST_SetSRID(ST_MakePoint(?, ?), 4326)
            LIMIT ?
        ", [$lon, $lat, $lon, $lat, $limit]);

        return response()->json([
            'status' => 'success',
            'koordinat' => ['lat' => $lat, 'lon' => $lon],
            'data' => $hasil,
        ]);
    }

    /**
     * ② Cari faskes dalam radius tertentu (ST_DWithin)
     */
    public function dalamRadius(Request $request)
    {
        $lat = $request->input('lat', 1.7417);
        $lon = $request->input('lon', 98.7792);
        $radius = $request->input('radius', 1000); // meter, default 1km

        $hasil = DB::select("
            SELECT
                f.id,
                f.nama_faskes,
                f.alamat,
                f.kecamatan,
                j.nama_jenis,
                f.bpjs,
                ROUND(
                    ST_Distance(
                        f.geom::geography,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                    )::numeric, 2
                ) AS jarak_meter
            FROM fasilitas_kesehatan f
            LEFT JOIN jenis_fasilitas j ON j.id = f.jenis_faskes_id
            WHERE
                f.geom IS NOT NULL
                AND ST_DWithin(
                    f.geom::geography,
                    ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                    ?
                )
            ORDER BY jarak_meter ASC
        ", [$lon, $lat, $lon, $lat, $radius]);

        return response()->json([
            'status' => 'success',
            'koordinat' => ['lat' => $lat, 'lon' => $lon],
            'radius_meter' => $radius,
            'total' => count($hasil),
            'data' => $hasil,
        ]);
    }

    /**
     * ③ Hitung jarak antara dua faskes (ST_Distance)
     */
    public function jarakDuaFaskes(Request $request)
    {
        $id_a = $request->input('id_a');
        $id_b = $request->input('id_b');

        $hasil = DB::select("
            SELECT
                a.nama_faskes AS faskes_a,
                b.nama_faskes AS faskes_b,
                a.alamat      AS alamat_a,
                b.alamat      AS alamat_b,
                ROUND(
                    ST_Distance(a.geom::geography, b.geom::geography)::numeric
                , 2) AS jarak_meter,
                ROUND(
                    ST_Distance(a.geom::geography, b.geom::geography)::numeric / 1000
                , 3) AS jarak_km
            FROM fasilitas_kesehatan a, fasilitas_kesehatan b
            WHERE a.id = ? AND b.id = ?
        ", [$id_a, $id_b]);

        return response()->json([
            'status' => 'success',
            'data' => $hasil,
        ]);
    }

    /**
     * ④ GeoJSON semua faskes untuk ditampilkan di peta (Leaflet/MapLibre)
     */
    public function geojson(Request $request)
    {
        $jenis = $request->input('jenis'); // filter opsional

        $query = "
            SELECT
                f.id,
                f.nama_faskes,
                f.alamat,
                f.kecamatan,
                f.telepon,
                f.jam_operasional,
                f.bpjs,
                f.status,
                j.nama_jenis,
                j.warna_marker,
                j.ikon,
                ST_AsGeoJSON(f.geom)::json AS geometry
            FROM fasilitas_kesehatan f
            LEFT JOIN jenis_fasilitas j ON j.id = f.jenis_faskes_id
            WHERE f.geom IS NOT NULL
        ";

        $params = [];
        if ($jenis) {
            $query .= " AND j.nama_jenis = ?";
            $params[] = $jenis;
        }

        $rows = DB::select($query, $params);

        // Format GeoJSON FeatureCollection
        $features = array_map(function ($row) {
            // Parse geometry dari string JSON ke array
            $geometry = is_string($row->geometry)
                ? json_decode($row->geometry, true)
                : (array) $row->geometry;

            return [
                'type' => 'Feature',
                'geometry' => $geometry,  // ← sudah jadi array/object
                'properties' => [
                    'id' => $row->id,
                    'nama_faskes' => $row->nama_faskes,
                    'alamat' => $row->alamat,
                    'kecamatan' => $row->kecamatan,
                    'telepon' => $row->telepon,
                    'jam_operasional' => $row->jam_operasional,
                    'bpjs' => $row->bpjs,
                    'status' => $row->status,
                    'nama_jenis' => $row->nama_jenis,
                    'warna_marker' => $row->warna_marker,
                    'ikon' => $row->ikon,
                ],
            ];
        }, $rows);

        return response()->json([
            'type' => 'FeatureCollection',
            'total' => count($features),
            'features' => $features,
        ]);
    }

    /**
     * ⑤ Statistik per kecamatan dari Materialized View
     */
    public function statistikKecamatan()
    {
        $data = DB::select("SELECT * FROM mv_faskes_per_kecamatan");

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}