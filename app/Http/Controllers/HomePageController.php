<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use App\Models\JenisFasilitas;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalFaskes = FasilitasKesehatan::count();
        $totalAktif = FasilitasKesehatan::where('status', 'Aktif')->count();
        $totalBpjs = FasilitasKesehatan::where('bpjs', true)->count();
        $totalJenis = JenisFasilitas::count();

        $jenisFasilitas = JenisFasilitas::withCount('fasilitasKesehatan')->get();

        $faskes = FasilitasKesehatan::with('jenisFasilitas')
            ->where('status', 'Aktif')
            ->orderBy('nama_faskes', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('homepage', compact(
            'totalFaskes',
            'totalAktif',
            'totalBpjs',
            'totalJenis',
            'jenisFasilitas',
            'faskes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FasilitasKesehatan $fasilitasKesehatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FasilitasKesehatan $fasilitasKesehatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FasilitasKesehatan $fasilitasKesehatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FasilitasKesehatan $fasilitasKesehatan)
    {
        //
    }

    public function profil()
    {
        return view('profil');
    }

}
