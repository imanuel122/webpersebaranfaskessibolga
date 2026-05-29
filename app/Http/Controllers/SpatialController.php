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
ST_AsGeoJSON(ST_SetSRID(ST_MakePoint(f.longitude, f.latitude), 4326))::json AS geometry
FROM fasilitas_kesehatan f
LEFT JOIN jenis_fasilitas j ON j.id = f.jenis_faskes_id
WHERE f.latitude IS NOT NULL
AND f.longitude IS NOT NULL
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
'geometry' => $geometry,
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