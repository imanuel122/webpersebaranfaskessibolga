<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Faskes — {{ $faskes->nama_faskes }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #map-detail {
            height: 280px;
            border-radius: 16px;
            overflow: hidden;
        }

        .info-row {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            min-width: 160px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .info-value {
            font-size: 14px;
            color: #334155;
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slideIn {
            animation: slideIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    @include('components.navbar')

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('homepage') }}" class="hover:text-blue-600">Beranda</a>
            <span>›</span>
            <a href="{{ route('faskes.index') }}" class="hover:text-blue-600">Data Faskes</a>
            <span>›</span>
            <span class="text-slate-600 font-semibold truncate max-w-xs">{{ $faskes->nama_faskes }}</span>
        </div>

        {{-- Header card --}}
        @php $color = $faskes->jenisFasilitas->warna_marker ?? '#2563eb'; @endphp
        <div class="rounded-2xl overflow-hidden shadow-md mb-6"
            style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}cc)">
            <div class="p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl flex-shrink-0">
                        {!! $faskes->jenisFasilitas->ikon ?? '🏥' !!}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-semibold">
                                {{ $faskes->jenisFasilitas->nama_jenis ?? '-' }}
                            </span>
                            @if ($faskes->status === 'Aktif')
                                <span
                                    class="px-3 py-1 rounded-full bg-emerald-400/30 text-white text-xs font-semibold border border-white/20">●
                                    Aktif</span>
                            @else
                                <span
                                    class="px-3 py-1 rounded-full bg-red-400/30 text-white text-xs font-semibold border border-white/20">●
                                    Tidak Aktif</span>
                            @endif
                            @if ($faskes->bpjs)
                                <span
                                    class="px-3 py-1 rounded-full bg-indigo-400/30 text-white text-xs font-semibold border border-white/20">✓
                                    BPJS</span>
                            @endif
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                            {{ $faskes->nama_faskes }}</h1>
                        <p class="text-white/80 text-sm mt-1">{{ $faskes->alamat }}, {{ $faskes->kecamatan }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('faskes.edit', $faskes->id) }}"
                        class="px-4 py-2.5 rounded-xl bg-white/20 border border-white/30 text-white text-sm font-semibold hover:bg-white/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('faskes.destroy', $faskes->id) }}" method="POST" id="form-delete">
                        @csrf @method('DELETE')
                        <button type="button" onclick="showDeleteModal()"
                            class="px-4 py-2.5 rounded-xl bg-red-500/30 border border-red-300/30 text-white text-sm font-semibold hover:bg-red-500/50 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── KOLOM KIRI: detail info ── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Informasi Umum --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="text-sm font-extrabold text-slate-700 mb-4 flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">📋</span>
                        Informasi Umum
                    </h3>
                    <div>
                        @if ($faskes->kode_faskes)
                            <div class="info-row">
                                <span class="info-label">Kode Faskes</span>
                                <span class="info-value font-mono">{{ $faskes->kode_faskes }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Kategori</span>
                            <span class="info-value">{{ $faskes->kategori ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status Kepemilikan</span>
                            <span class="info-value">{{ $faskes->status_kepemilikan ?? '-' }}</span>
                        </div>
                        @if ($faskes->kelas_rs)
                            <div class="info-row">
                                <span class="info-label">Kelas RS</span>
                                <span class="info-value">{{ $faskes->kelas_rs }}</span>
                            </div>
                        @endif
                        @if ($faskes->akreditasi)
                            <div class="info-row">
                                <span class="info-label">Akreditasi</span>
                                <span class="info-value">{{ $faskes->akreditasi }}</span>
                            </div>
                        @endif
                        @if ($faskes->kapasitas_tempat_tidur)
                            <div class="info-row">
                                <span class="info-label">Kapasitas Tempat Tidur</span>
                                <span class="info-value">{{ number_format($faskes->kapasitas_tempat_tidur) }} tempat
                                    tidur</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="text-sm font-extrabold text-slate-700 mb-4 flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">📍</span>
                        Lokasi & Alamat
                    </h3>
                    <div>
                        <div class="info-row">
                            <span class="info-label">Alamat</span>
                            <span class="info-value">{{ $faskes->alamat }}</span>
                        </div>
                        @if ($faskes->kelurahan)
                            <div class="info-row">
                                <span class="info-label">Kelurahan</span>
                                <span class="info-value">{{ $faskes->kelurahan }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Kecamatan</span>
                            <span class="info-value">{{ $faskes->kecamatan }}</span>
                        </div>
                        @if ($faskes->kode_pos)
                            <div class="info-row">
                                <span class="info-label">Kode Pos</span>
                                <span class="info-value font-mono">{{ $faskes->kode_pos }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Koordinat</span>
                            <span class="info-value font-mono text-xs">
                                Lat: {{ $faskes->latitude }}, Lon: {{ $faskes->longitude }}
                            </span>
                        </div>
                        @if ($faskes->link_googlemaps)
                            <div class="info-row">
                                <span class="info-label">Google Maps</span>
                                <a href="{{ $faskes->link_googlemaps }}" target="_blank"
                                    class="info-value text-blue-600 hover:underline text-sm flex items-center gap-1">
                                    🗺 Buka Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Operasional --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="text-sm font-extrabold text-slate-700 mb-4 flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">🕐</span>
                        Operasional & Kontak
                    </h3>
                    <div>
                        <div class="info-row">
                            <span class="info-label">Telepon</span>
                            <span class="info-value">{{ $faskes->telepon ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jam Operasional</span>
                            <span class="info-value">{{ $faskes->jam_operasional ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Layanan BPJS</span>
                            <span class="info-value">
                                @if ($faskes->bpjs)
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">✓
                                        Melayani BPJS</span>
                                @else
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">Tidak
                                        Melayani BPJS</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Data PostGIS --}}
                {{-- <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="text-sm font-extrabold text-slate-700 mb-4 flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center text-xs">🌐</span>
                        Data Spasial PostGIS
                    </h3>
                    <div class="bg-slate-900 rounded-xl p-4">
                        <p class="text-xs text-slate-400 mb-2 font-semibold uppercase tracking-wider">GeoJSON
                            (ST_AsGeoJSON)</p>
                        <pre class="text-xs text-emerald-400 font-mono overflow-x-auto">{{ json_encode($geom->geojson ?? null, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">
                        Kolom <code class="bg-slate-100 px-1 rounded">geom</code> tersimpan sebagai
                        <code class="bg-slate-100 px-1 rounded">geometry(Point, 4326)</code> di PostgreSQL/PostGIS.
                    </p>
                </div> --}}

            </div>

            {{-- ── KOLOM KANAN: peta + aksi ── --}}
            <div class="space-y-5">

                {{-- Peta mini --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-4 pt-4 pb-2">
                        <h3 class="text-sm font-extrabold text-slate-700 flex items-center gap-2">
                            🗺 Lokasi di Peta
                        </h3>
                    </div>
                    <div id="map-detail" class="mx-3 mb-3"></div>
                    @if ($faskes->link_googlemaps)
                        <div class="px-4 pb-4">
                            <a href="{{ $faskes->link_googlemaps }}" target="_blank"
                                class="block w-full py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600 text-center hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-colors">
                                Buka di Google Maps →
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Info cepat --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                    <h3 class="text-sm font-extrabold text-slate-700">Info Cepat</h3>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs text-slate-500">Status</span>
                        @if ($faskes->status === 'Aktif')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">●
                                Aktif</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">●
                                Tidak Aktif</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs text-slate-500">BPJS</span>
                        @if ($faskes->bpjs)
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">✓
                                Ya</span>
                        @else
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600">Tidak</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs text-slate-500">Jenis</span>
                        <span
                            class="text-xs font-bold text-slate-700">{{ $faskes->jenisFasilitas->nama_jenis ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-slate-500">Kecamatan</span>
                        <span class="text-xs font-bold text-slate-700">{{ $faskes->kecamatan }}</span>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-2">
                    <a href="{{ route('faskes.edit', $faskes->id) }}"
                        class="flex items-center gap-2 w-full py-2.5 px-4 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Data Faskes
                    </a>
                    <a href="{{ route('faskes.index') }}"
                        class="flex items-center gap-2 w-full py-2.5 px-4 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors justify-center">
                        ← Kembali ke Daftar
                    </a>
                    <button onclick="showDeleteModal()"
                        class="flex items-center gap-2 w-full py-2.5 px-4 rounded-xl border border-red-200 text-red-600 text-sm font-semibold hover:bg-red-50 transition-colors justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Faskes
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal hapus --}}
    <div id="delete-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 animate-slideIn">
            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-800 text-center mb-2">Hapus Faskes?</h3>
            <p class="text-sm text-slate-500 text-center mb-1">Apakah kamu yakin ingin menghapus:</p>
            <p class="text-sm font-bold text-slate-800 text-center mb-2 px-4">"{{ $faskes->nama_faskes }}"</p>
            <p class="text-xs text-red-500 text-center mb-5">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex gap-3">
                <button onclick="document.getElementById('delete-modal').classList.add('hidden')"
                    class="flex-1 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </button>
                <button onclick="document.getElementById('form-delete').submit()"
                    class="flex-1 py-2.5 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        // Peta detail
        const lat = {{ $faskes->latitude ?? 1.7417 }};
        const lng = {{ $faskes->longitude ?? 98.7792 }};
        const color = '{{ $faskes->jenisFasilitas->warna_marker ?? '#2563eb' }}';

        const map = L.map('map-detail').setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        L.marker([lat, lng], {
                icon: L.divIcon({
                    className: '',
                    html: `<div style="width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);background:${color};border:3px solid white;box-shadow:0 4px 14px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [36, 36],
                    iconAnchor: [18, 36],
                })
            }).addTo(map)
            .bindPopup(`<b>{{ $faskes->nama_faskes }}</b><br><small>{{ $faskes->kecamatan }}</small>`)
            .openPopup();
    </script>

</body>

</html>
