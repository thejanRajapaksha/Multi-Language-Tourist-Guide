@include('Includes.header')
@include('Includes.top-navbar')

<div class="container mt-5">
    <h1 class="about_taital text-center mb-5">Locator</h1>
    <div id="map" style="height: 500px; width: 100%;"></div>
</div>

@include('Includes.footer')
@include('Includes.footerscripts')

<!-- Leaflet.js for OpenStreetMap -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('map').setView([7.8731, 80.7718], 8); // Default to Sri Lanka

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Request user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;

            // Add user location marker
            L.marker([userLat, userLng])
                .addTo(map)
                .bindPopup("<b>You are here!</b>")
                .openPopup();

            // Center map on user location
            map.setView([userLat, userLng], 10);
        }, function (error) {
            alert("Location access denied or unavailable.");
        });
    } else {
        alert("Geolocation is not supported by your browser.");
    }

    // Hardcoded tourist places (Can later fetch from database)
    var places = [
        { name: "Sigiriya", lat: 7.9570, lng: 80.7603, description: "Ancient rock fortress with breathtaking views.", 'icon' : 'sigiriya.png' },
        { name: "Temple of the Tooth", lat: 7.2936, lng: 80.6411, description: "Sacred Buddhist temple in Kandy.", 'icon' : 'temple.png' },
        { name: "Galle Fort", lat: 6.0269, lng: 80.2170, description: "Historic Dutch fort with colonial architecture.", 'icon' : 'fort.png' }
    ];

    // Add markers for places
    places.forEach(function (place) {
        L.marker([place.lat, place.lng])
            .addTo(map)
            .bindPopup("<b>" + place.name + "</b><br>" + place.description);
    });
});
</script>
