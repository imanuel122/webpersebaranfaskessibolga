<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Faskes — Sibolga</title>
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

        #map-picker {
            height: 320px !important;
            width: 100% !important;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            display: block;
        }

        .leaflet-pane {
            z-index: 1 !important;
        }

        .leaflet-overlay-pane {
            z-index: 2 !important;
        }

        .leaflet-shadow-pane {
            z-index: 3 !important;
        }

        .leaflet-marker-pane {
            z-index: 4 !important;
        }

        .leaflet-tooltip-pane {
            z-index: 5 !important;
        }

        .leaflet-popup-pane {
            z-index: 6 !important;
        }

        .leaflet-top,
        .leaflet-bottom {
            z-index: 7 !important;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: border-color 0.2s;
            outline: none;
            background: white;
        }

        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .section-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* GPS */
        @keyframes gpsPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        .gps-loading {
            animation: gpsPulse 1s ease infinite;
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

        /* GPS accuracy ring */
        @keyframes ring {
            0% {
                transform: scale(0.8);
                opacity: 0.8;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .gps-ring {
            animation: ring 1.5s ease-out infinite;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    @include('components.navbar')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('homepage') }}" class="hover:text-blue-600">Beranda</a>
            <span>›</span>
            <a href="{{ route('faskes.index') }}" class="hover:text-blue-600">Data Faskes</a>
            <span>›</span>
            <span class="text-slate-600 font-semibold">Tambah Faskes</span>
        </div>

        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-slate-800">Tambah Fasilitas Kesehatan</h1>
            <p class="text-slate-500 text-sm mt-1">Isi form di bawah dan tentukan lokasi faskes di peta</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-bold text-red-700">Terdapat {{ $errors->count() }} kesalahan:</p>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-xs text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('faskes.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ── KOLOM KIRI ── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Identitas --}}
                    <div class="section-card">
                        <h3 class="text-sm font-extrabold text-slate-700 mb-5 flex items-center gap-2">
                            <span
                                class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">1</span>
                            Identitas Faskes
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Kode Faskes</label>
                                <input type="text" name="kode_faskes" value="{{ old('kode_faskes') }}"
                                    class="form-input" placeholder="Contoh: RS-001" />
                            </div>
                            <div>
                                <label class="form-label">Nama Faskes <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_faskes" value="{{ old('nama_faskes') }}"
                                    class="form-input {{ $errors->has('nama_faskes') ? 'error' : '' }}"
                                    placeholder="Nama lengkap faskes" required />
                            </div>
                            <div>
                                <label class="form-label">Jenis Faskes <span class="text-red-500">*</span></label>
                                <select name="jenis_faskes_id"
                                    class="form-input {{ $errors->has('jenis_faskes_id') ? 'error' : '' }}" required>
                                    <option value="">— Pilih Jenis —</option>
                                    @foreach ($jenisFasilitas as $j)
                                        <option value="{{ $j->id }}"
                                            {{ old('jenis_faskes_id') == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-input"
                                    placeholder="Contoh: Umum, Spesialis" />
                            </div>
                            <div>
                                <label class="form-label">Kelas RS</label>
                                <select name="kelas_rs" class="form-input">
                                    <option value="">— Pilih Kelas (jika RS) —</option>
                                    @foreach (['A', 'B', 'C', 'D', 'D Pratama'] as $k)
                                        <option value="{{ $k }}"
                                            {{ old('kelas_rs') == $k ? 'selected' : '' }}>Kelas {{ $k }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Akreditasi</label>
                                <input type="text" name="akreditasi" value="{{ old('akreditasi') }}"
                                    class="form-input" placeholder="Contoh: Paripurna, Utama" />
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="section-card">
                        <h3 class="text-sm font-extrabold text-slate-700 mb-5 flex items-center gap-2">
                            <span
                                class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">2</span>
                            Lokasi & Alamat
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div class="sm:col-span-2">
                                <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat" rows="2" required class="form-input {{ $errors->has('alamat') ? 'error' : '' }}"
                                    placeholder="Jl. Contoh No.1">{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label class="form-label">Kelurahan</label>
                                <input type="text" name="kelurahan" value="{{ old('kelurahan') }}"
                                    class="form-input" placeholder="Nama kelurahan" />
                            </div>
                            <div>
                                <label class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                                <select name="kecamatan"
                                    class="form-input {{ $errors->has('kecamatan') ? 'error' : '' }}" required>
                                    <option value="">— Pilih Kecamatan —</option>
                                    @foreach (['Sibolga Kota', 'Sibolga Selatan', 'Sibolga Utara', 'Sibolga Sambas'] as $kec)
                                        <option value="{{ $kec }}"
                                            {{ old('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos') }}"
                                    class="form-input" placeholder="22513" />
                            </div>
                            <div>
                                <label class="form-label">Link Google Maps</label>
                                <input type="url" name="link_googlemaps" value="{{ old('link_googlemaps') }}"
                                    class="form-input" placeholder="https://maps.google.com/..." />
                            </div>
                        </div>

                        {{-- Koordinat box --}}
                        <div class="bg-slate-50 rounded-2xl p-4 mb-4 border border-slate-200">

                            {{-- Header koordinat + tombol GPS --}}
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-xs font-bold text-slate-600 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    Koordinat Lokasi Faskes
                                </p>
                                <button type="button" onclick="gunakanGPS()" id="btn-gps"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500 text-white text-xs font-bold shadow hover:bg-emerald-600 active:scale-95 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span id="btn-gps-text">📡 Lokasi Saya</span>
                                </button>
                            </div>

                            {{-- Cara input --}}
                            <div class="flex items-center gap-2 mb-3 text-xs">
                                <div
                                    class="flex-1 flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white border border-slate-200 text-blue-600 font-semibold">
                                    🖱 Klik langsung di peta
                                </div>
                                <span class="text-slate-400 font-bold flex-shrink-0">atau</span>
                                <div
                                    class="flex-1 flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white border border-slate-200 text-emerald-600 font-semibold">
                                    📡 Tombol GPS di atas
                                </div>
                            </div>

                            {{-- Input lat lon --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label">Latitude <span class="text-red-500">*</span></label>
                                    <input type="text" name="latitude" id="input-latitude"
                                        value="{{ old('latitude') }}"
                                        class="form-input {{ $errors->has('latitude') ? 'error' : '' }}"
                                        placeholder="1.7417" required readonly
                                        style="background:#f8fafc;cursor:not-allowed;" />
                                </div>
                                <div>
                                    <label class="form-label">Longitude <span class="text-red-500">*</span></label>
                                    <input type="text" name="longitude" id="input-longitude"
                                        value="{{ old('longitude') }}"
                                        class="form-input {{ $errors->has('longitude') ? 'error' : '' }}"
                                        placeholder="98.7792" required readonly
                                        style="background:#f8fafc;cursor:not-allowed;" />
                                </div>
                            </div>
                            <p id="coord-hint" class="text-xs text-amber-600 mt-2 font-medium">
                                ⚠ Belum ada koordinat. Klik peta atau gunakan GPS.
                            </p>
                        </div>

                        {{-- MAP --}}
                        <div id="map-picker"></div>
                        <p class="text-xs text-slate-400 mt-2 text-center">🖱 Klik peta · atau 📡 Gunakan tombol GPS di
                            atas</p>
                    </div>

                    {{-- Operasional --}}
                    <div class="section-card">
                        <h3 class="text-sm font-extrabold text-slate-700 mb-5 flex items-center gap-2">
                            <span
                                class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">3</span>
                            Informasi Operasional
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}"
                                    class="form-input" placeholder="0631-XXXXX" />
                            </div>
                            <div>
                                <label class="form-label">Jam Operasional</label>
                                <input type="text" name="jam_operasional" value="{{ old('jam_operasional') }}"
                                    class="form-input" placeholder="24 Jam / 08.00-16.00" />
                            </div>
                            <div>
                                <label class="form-label">Kapasitas Tempat Tidur</label>
                                <input type="number" name="kapasitas_tempat_tidur"
                                    value="{{ old('kapasitas_tempat_tidur', 0) }}" class="form-input"
                                    placeholder="0" min="0" />
                            </div>
                            <div>
                                <label class="form-label">Status Kepemilikan</label>
                                <select name="status_kepemilikan" class="form-input">
                                    <option value="">— Pilih —</option>
                                    @foreach (['Pemerintah Daerah', 'Pemerintah Pusat', 'TNI/Polri', 'Swasta', 'Yayasan'] as $kep)
                                        <option value="{{ $kep }}"
                                            {{ old('status_kepemilikan') == $kep ? 'selected' : '' }}>
                                            {{ $kep }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ── KOLOM KANAN ── --}}
                <div class="space-y-5">

                    {{-- Status --}}
                    <div class="section-card">
                        <h3 class="text-sm font-extrabold text-slate-700 mb-4">Status Faskes</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="form-label">Status Operasional <span
                                        class="text-red-500">*</span></label>
                                <select name="status" class="form-input" required>
                                    <option value="Aktif" {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>✅
                                        Aktif</option>
                                    <option value="Tidak Aktif"
                                        {{ old('status') === 'Tidak Aktif' ? 'selected' : '' }}>❌ Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-indigo-50 rounded-xl">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Melayani BPJS</p>
                                    <p class="text-xs text-slate-500">Faskes menerima pasien BPJS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="bpjs" value="0" />
                                    <input type="checkbox" name="bpjs" value="1" class="sr-only peer"
                                        {{ old('bpjs') ? 'checked' : '' }} />
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-checked:bg-indigo-500 rounded-full transition-colors">
                                    </div>
                                    <div
                                        class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Preview koordinat --}}
                    <div class="section-card">
                        <h3 class="text-sm font-extrabold text-slate-700 mb-3">📍 Koordinat Terpilih</h3>
                        <div id="coord-preview" class="text-center py-5 text-slate-400 text-xs">
                            <div class="text-4xl mb-2">🗺</div>
                            <p class="font-semibold text-slate-500">Belum ada koordinat</p>
                            <p class="mt-1 text-slate-400">Klik peta atau gunakan GPS</p>
                        </div>
                        <div id="coord-preview-data" class="hidden">
                            <div class="bg-slate-50 rounded-xl p-3 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-500">Latitude</span>
                                    <span id="preview-lat" class="text-xs font-mono font-bold text-slate-700">—</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-500">Longitude</span>
                                    <span id="preview-lon" class="text-xs font-mono font-bold text-slate-700">—</span>
                                </div>
                                <div id="preview-accuracy" class="hidden flex justify-between items-center">
                                    <span class="text-xs text-slate-500">Akurasi GPS</span>
                                    <span id="preview-acc-val" class="text-xs font-bold text-emerald-600">—</span>
                                </div>
                                <div id="preview-source" class="text-center mt-1">
                                    <span id="source-badge"
                                        class="inline-block px-2 py-0.5 rounded-full text-xs font-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="section-card">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-sm hover:opacity-90 transition-all shadow-lg flex items-center justify-center gap-2 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Faskes
                        </button>
                        <a href="{{ route('faskes.index') }}"
                            class="block w-full py-2.5 rounded-xl border border-slate-200 text-slate-500 text-sm font-semibold text-center hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        // ── MAP INIT ──
        const map = L.map('map-picker').setView([1.7417, 98.7792], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        // Paksa re-render setelah layout siap
        setTimeout(() => map.invalidateSize(), 300);

        let marker = null;
        let gpsCircle = null;

        // Jika ada old value (form validation gagal)
        @if (old('latitude') && old('longitude'))
            setMarker({{ old('latitude') }}, {{ old('longitude') }}, 'peta');
        @endif

        // ── Klik peta ──
        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng, 'peta');
        });

        // ── Set marker ──
        function setMarker(lat, lng, source) {
            const latF = parseFloat(lat).toFixed(6);
            const lngF = parseFloat(lng).toFixed(6);
            const isGPS = source === 'gps';
            const color = isGPS ? '#10b981' : '#2563eb';
            const label = isGPS ? '📡 Lokasi GPS Anda' : '📍 Lokasi Faskes';

            if (marker) map.removeLayer(marker);

            marker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        className: '',
                        html: `<div style="width:34px;height:34px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);background:${color};border:3px solid white;box-shadow:0 4px 14px rgba(0,0,0,0.3);"></div>`,
                        iconSize: [34, 34],
                        iconAnchor: [17, 34],
                    })
                }).addTo(map)
                .bindPopup(`<b>${label}</b><br><small style="font-family:monospace;">Lat: ${latF}<br>Lon: ${lngF}</small>`)
                .openPopup();

            map.setView([lat, lng], isGPS ? 17 : 16, {
                animate: true
            });

            // Isi input
            document.getElementById('input-latitude').value = latF;
            document.getElementById('input-longitude').value = lngF;

            // Update preview panel
            document.getElementById('coord-preview').classList.add('hidden');
            document.getElementById('coord-preview-data').classList.remove('hidden');
            document.getElementById('preview-lat').textContent = latF;
            document.getElementById('preview-lon').textContent = lngF;

            const badge = document.getElementById('source-badge');
            if (isGPS) {
                badge.textContent = '📡 Dari GPS';
                badge.className = 'inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700';
            } else {
                badge.textContent = '🖱 Dari Klik Peta';
                badge.className = 'inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700';
                document.getElementById('preview-accuracy').classList.add('hidden');
            }

            // Update hint
            const hint = document.getElementById('coord-hint');
            hint.textContent = isGPS ?
                '✅ Koordinat diisi dari GPS. Klik peta untuk koreksi jika perlu.' :
                '✅ Koordinat berhasil diisi. Klik lokasi lain untuk mengubah.';
            hint.className = 'text-xs text-emerald-600 mt-2 font-medium';
        }

        // ── GPS ──
        function gunakanGPS() {
            const btn = document.getElementById('btn-gps');
            const btnText = document.getElementById('btn-gps-text');

            if (!navigator.geolocation) {
                showToast('error', 'Perangkat tidak mendukung fitur GPS/Geolocation.');
                return;
            }

            // Loading state
            btn.disabled = true;
            btnText.innerHTML = '<span class="gps-loading">⏳ Mendeteksi lokasi...</span>';
            btn.classList.add('opacity-75');

            navigator.geolocation.getCurrentPosition(
                // ── Sukses ──
                function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const acc = Math.round(pos.coords.accuracy);

                    setMarker(lat, lng, 'gps');

                    // Lingkaran akurasi GPS
                    if (gpsCircle) map.removeLayer(gpsCircle);
                    gpsCircle = L.circle([lat, lng], {
                        radius: acc,
                        color: '#10b981',
                        fillColor: '#10b981',
                        fillOpacity: 0.08,
                        weight: 1.5,
                        dashArray: '5,5',
                    }).addTo(map);

                    // Tampilkan akurasi di preview
                    document.getElementById('preview-accuracy').classList.remove('hidden');
                    document.getElementById('preview-acc-val').textContent = `±${acc} meter`;

                    // Reset tombol
                    btn.disabled = false;
                    btn.classList.remove('opacity-75');
                    btn.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
                    btn.style.background = '#059669';
                    btnText.innerHTML = `✅ GPS aktif (±${acc}m)`;

                    showToast('success', `📡 Lokasi GPS berhasil! Akurasi ±${acc} meter.`);
                },
                // ── Error ──
                function(err) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-75');
                    btnText.innerHTML = '📡 Lokasi Saya';

                    const msgs = {
                        1: 'Akses GPS ditolak browser.\n• Klik ikon 🔒 di address bar → izinkan Lokasi\n• Atau aktifkan HTTPS / chrome://flags',
                        2: 'Sinyal GPS tidak tersedia. Coba di luar ruangan.',
                        3: 'Waktu GPS habis. Coba lagi.',
                    };
                    showToast('error', msgs[err.code] || `GPS error (${err.code}): ${err.message}`);
                }, {
                    enableHighAccuracy: true,
                    timeout: 12000,
                    maximumAge: 0
                }
            );
        }

        // ── Toast notifikasi ──
        function showToast(type, msg) {
            document.querySelectorAll('.toast-notif').forEach(el => el.remove());

            const toast = document.createElement('div');
            toast.className = 'toast-notif fixed top-5 right-5 z-[9999] max-w-sm w-full animate-slideIn';
            const ok = type === 'success';

            toast.innerHTML = `
        <div class="bg-white border ${ok ? 'border-emerald-200' : 'border-red-200'} rounded-2xl shadow-2xl p-4 flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl ${ok ? 'bg-emerald-100' : 'bg-red-100'} flex items-center justify-center flex-shrink-0 text-xl">
                ${ok ? '✅' : '❌'}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800">${ok ? 'GPS Berhasil!' : 'GPS Gagal'}</p>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed whitespace-pre-line">${msg}</p>
            </div>
            <button onclick="this.closest('.toast-notif').remove()"
                class="flex-shrink-0 w-6 h-6 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors text-sm">✕</button>
        </div>`;

            document.body.appendChild(toast);
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.4s';
                    setTimeout(() => toast.remove(), 400);
                }
            }, 6000);
        }
    </script>

</body>

</html>
