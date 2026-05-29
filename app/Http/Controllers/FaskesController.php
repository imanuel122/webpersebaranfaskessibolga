<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use App\Models\JenisFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaskesController extends Controller
{
    // ── INDEX — daftar semua faskes dengan filter ──
    public function index(Request $request)
    {
        $query = FasilitasKesehatan::with('jenisFasilitas')->latest();

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis_faskes_id', $request->jenis);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by bpjs
        if ($request->filled('bpjs')) {
            $query->where('bpjs', (bool) $request->bpjs);
        }

        // Search by nama
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_faskes', 'ilike', '%' . $request->search . '%')
                    ->orWhere('alamat', 'ilike', '%' . $request->search . '%')
                    ->orWhere('kecamatan', 'ilike', '%' . $request->search . '%');
            });
        }

        $faskes = $query->paginate(15)->withQueryString();
        $jenisFasilitas = JenisFasilitas::withCount('fasilitasKesehatan')->get();

        // Stat cards
        $totalFaskes = FasilitasKesehatan::count();
        $totalAktif = FasilitasKesehatan::where('status', 'Aktif')->count();
        $totalBpjs = FasilitasKesehatan::where('bpjs', true)->count();

        return view('faskes.index', compact(
            'faskes',
            'jenisFasilitas',
            'totalFaskes',
            'totalAktif',
            'totalBpjs'
        ));
    }

    // ── CREATE — form tambah ──
    public function create()
    {
        $jenisFasilitas = JenisFasilitas::all();
        return view('faskes.create', compact('jenisFasilitas'));
    }

    // ── STORE — simpan data baru dengan PostGIS ──
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_faskes' => 'nullable|string|max:50',
            'nama_faskes' => 'required|string|max:255',
            'jenis_faskes_id' => 'required|exists:jenis_fasilitas,id',
            'kategori' => 'nullable|string|max:100',
            'alamat' => 'required|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'jam_operasional' => 'nullable|string|max:100',
            'kapasitas_tempat_tidur' => 'nullable|integer|min:0',
            'akreditasi' => 'nullable|string|max:100',
            'status_kepemilikan' => 'nullable|string|max:100',
            'kelas_rs' => 'nullable|string|max:20',
            'bpjs' => 'boolean',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'link_googlemaps' => 'nullable|url|max:500',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        try {
            // INSERT dengan PostGIS — kolom geom diisi ST_MakePoint
            DB::statement("
                INSERT INTO fasilitas_kesehatan (
                    kode_faskes, nama_faskes, jenis_faskes_id, kategori,
                    alamat, kelurahan, kecamatan, kode_pos, telepon,
                    jam_operasional, kapasitas_tempat_tidur, akreditasi,
                    status_kepemilikan, kelas_rs, bpjs,
                    latitude, longitude, link_googlemaps, status,
                    geom, created_at, updated_at
                ) VALUES (
                    ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?, ?, ?,
                    ?, ?, ?,
                    ?, ?, ?, ?,
                    ST_SetSRID(ST_MakePoint(?, ?), 4326),
                    NOW(), NOW()
                )
            ", [
                $validated['kode_faskes'] ?? null,
                $validated['nama_faskes'],
                $validated['jenis_faskes_id'],
                $validated['kategori'] ?? null,
                $validated['alamat'],
                $validated['kelurahan'] ?? null,
                $validated['kecamatan'],
                $validated['kode_pos'] ?? null,
                $validated['telepon'] ?? null,
                $validated['jam_operasional'] ?? null,
                $validated['kapasitas_tempat_tidur'] ?? null,
                $validated['akreditasi'] ?? null,
                $validated['status_kepemilikan'] ?? null,
                $validated['kelas_rs'] ?? null,
                isset($validated['bpjs']) ? 1 : 0,
                $validated['latitude'],
                $validated['longitude'],
                $validated['link_googlemaps'] ?? null,
                $validated['status'],
                // ST_MakePoint(longitude, latitude)
                $validated['longitude'],
                $validated['latitude'],
            ]);

            return redirect()->route('faskes.index')
                ->with('success', "Faskes \"{$validated['nama_faskes']}\" berhasil ditambahkan!");

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // ── SHOW — detail faskes ──
    public function show($id)
    {
        $faskes = FasilitasKesehatan::with('jenisFasilitas')->findOrFail($id);

        // Ambil koordinat GeoJSON dari PostGIS
        $geom = DB::selectOne("
            SELECT ST_AsGeoJSON(geom)::json AS geojson
            FROM fasilitas_kesehatan
            WHERE id = ?
        ", [$id]);

        return view('faskes.show', compact('faskes', 'geom'));
    }

    // ── EDIT — form edit ──
    public function edit($id)
    {
        $faskes = FasilitasKesehatan::findOrFail($id);
        $jenisFasilitas = JenisFasilitas::all();
        return view('faskes.edit', compact('faskes', 'jenisFasilitas'));
    }

    // ── UPDATE — simpan perubahan + update geom PostGIS ──
    public function update(Request $request, $id)
    {
        $faskes = FasilitasKesehatan::findOrFail($id);

        $validated = $request->validate([
            'kode_faskes' => 'nullable|string|max:50',
            'nama_faskes' => 'required|string|max:255',
            'jenis_faskes_id' => 'required|exists:jenis_fasilitas,id',
            'kategori' => 'nullable|string|max:100',
            'alamat' => 'required|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'jam_operasional' => 'nullable|string|max:100',
            'kapasitas_tempat_tidur' => 'nullable|integer|min:0',
            'akreditasi' => 'nullable|string|max:100',
            'status_kepemilikan' => 'nullable|string|max:100',
            'kelas_rs' => 'nullable|string|max:20',
            'bpjs' => 'boolean',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'link_googlemaps' => 'nullable|url|max:500',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        try {
            // Update data biasa dulu
            $faskes->update([
                'kode_faskes' => $validated['kode_faskes'] ?? null,
                'nama_faskes' => $validated['nama_faskes'],
                'jenis_faskes_id' => $validated['jenis_faskes_id'],
                'kategori' => $validated['kategori'] ?? null,
                'alamat' => $validated['alamat'],
                'kelurahan' => $validated['kelurahan'] ?? null,
                'kecamatan' => $validated['kecamatan'],
                'kode_pos' => $validated['kode_pos'] ?? null,
                'telepon' => $validated['telepon'] ?? null,
                'jam_operasional' => $validated['jam_operasional'] ?? null,
                'kapasitas_tempat_tidur' => $validated['kapasitas_tempat_tidur'] ?? null,
                'akreditasi' => $validated['akreditasi'] ?? null,
                'status_kepemilikan' => $validated['status_kepemilikan'] ?? null,
                'kelas_rs' => $validated['kelas_rs'] ?? null,
                'bpjs' => $request->boolean('bpjs'),
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'link_googlemaps' => $validated['link_googlemaps'] ?? null,
                'status' => $validated['status'],
            ]);

            // Update kolom geom PostGIS dengan ST_MakePoint
            DB::statement("
                UPDATE fasilitas_kesehatan
                SET geom = ST_SetSRID(ST_MakePoint(?, ?), 4326)
                WHERE id = ?
            ", [$validated['longitude'], $validated['latitude'], $id]);

            return redirect()->route('faskes.show', $id)
                ->with('success', "Faskes \"{$validated['nama_faskes']}\" berhasil diperbarui!");

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // ── DESTROY — hapus faskes ──
    public function destroy($id)
    {
        try {
            $faskes = FasilitasKesehatan::findOrFail($id);
            $nama = $faskes->nama_faskes;
            $faskes->delete();

            return redirect()->route('faskes.index')
                ->with('success', "Faskes \"{$nama}\" berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->route('faskes.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}