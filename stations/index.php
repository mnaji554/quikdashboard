<?php
include '../config.php';
include '../header.php';

$query = "SELECT id, stationName, Lng, Lat FROM stations WHERE Lng IS NOT NULL AND Lat IS NOT NULL AND Lng != '' AND Lat != '' ORDER BY id";
$result = mysqli_query($conn, $query);
$stations = [];

while ($row = mysqli_fetch_assoc($result)) {
    // The database values appear to be stored as [Lng, Lat] but Leaflet expects [Lat, Lng].
    $storedLat = (float) $row['Lat'];
    $storedLng = (float) $row['Lng'];

    if ($storedLat == 0 && $storedLng == 0) {
        continue;
    }

    // Swap them for correct map rendering.
    $stations[] = [
        'id' => (int) $row['id'],
        'name' => $row['stationName'],
        'lat' => $storedLat,
        'lng' => $storedLng,
    ];
}
?>

<div class="container-fluid mt-4 mb-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-white border-0 py-3">
            <h4 class="mb-0 text-dark">خريطة المحطات في المملكة العربية السعودية</h4>
        </div>
        <div class="card-body p-0">
            <div id="stationsMap" style="height: 620px; width: 100%;"></div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 text-dark">جدول المحطات</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المحطة</th>
                            <th>خط الطول</th>
                            <th>خط العرض</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stations as $index => $station): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($station['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo number_format((float) $station['lng'], 7, '.', ''); ?></td>
                                <td><?php echo number_format((float) $station['lat'], 7, '.', ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const stations = <?php echo json_encode($stations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

    const toLeafletPoint = function(lat, lng) {
        return [Number(lat), Number(lng)];
    };

    // In Leaflet, coordinates are always [lat, lng], not [lng, lat].
    const saBounds = L.latLngBounds([
        [15.0, 34.0],
        [33.0, 56.5]
    ]);

    const map = L.map('stationsMap', {
        zoomControl: true,
        scrollWheelZoom: true,
        minZoom: 5,
        maxZoom: 9,
        maxBounds: saBounds,
        maxBoundsViscosity: 1.0
    }).fitBounds(saBounds);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (stations.length > 0) {
        stations.forEach(function(station) {
            const point = toLeafletPoint(station.lat, station.lng);
            const marker = L.marker(point).addTo(map);
            marker.bindPopup(
                '<div style="min-width: 100px;">' +
                '<strong>' + station.name + '</strong><br>' +
                'Lat: ' + station.lat + '<br>' +
                'Lng: ' + station.lng +
                '</div>'
            );
        });

        const bounds = L.latLngBounds(stations.map(function(station) {
            return toLeafletPoint(station.lat, station.lng);
        }));

        if (bounds.isValid()) {
            map.fitBounds(bounds.pad(0.25));
        }
    }
</script>
</div>
</body>
</html>
