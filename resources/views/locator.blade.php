@include('Includes.header')
@include('Includes.top-navbar')

<div class="container mt-5">
    <!-- <h1 class="about_taital text-center mb-5">Locator</h1> -->
    <div id="map" style="height: 600px; width: 100%;"></div>
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

    // Hardcoded tourist places
    var places = [
        { 
            name: "Sigiriya Rock Fortress", 
            lat: 7.9570, 
            lng: 80.7603, 
            description: "Sigiriya is an ancient rock fortress located in the northern Matale District. It features frescoes, gardens, and an incredible view from the top, offering a glimpse into Sri Lanka's rich history and architectural brilliance.", 
            icon: "sigiriya.jpg" 
        },
        { 
            name: "Temple of the Sacred Tooth Relic", 
            lat: 7.2936, 
            lng: 80.6411, 
            description: "Located in the royal palace complex of Kandy, the Temple of the Tooth houses Sri Lanka’s most important Buddhist relic – a tooth of the Buddha. It's a spiritual and cultural symbol of the nation.", 
            icon: "temple.jpg" 
        },
        { 
            name: "Galle Dutch Fort", 
            lat: 6.0269, 
            lng: 80.2170, 
            description: "Built first in 1588 by the Portuguese, and later extensively fortified by the Dutch, the Galle Fort is a UNESCO World Heritage Site showcasing colonial architecture blending with South Asian traditions.", 
            icon: "fort.jpg" 
        }
    ];

    // Function to calculate distance
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;

            // Add user marker
            var userMarker = L.marker([userLat, userLng])
                .addTo(map)
                .bindPopup("<b>You are here!</b>")
                .openPopup();

            // Center map on user location
            map.setView([userLat, userLng], 10);

            // Draw a 5km circle around user
            var circle = L.circle([userLat, userLng], {
                color: 'blue',
                fillColor: '#3f8efc',
                fillOpacity: 0.2,
                radius: 5000 // in meters
            }).addTo(map);

            // Mark tourist places
            places.forEach(function (place) {
                var distance = getDistance(userLat, userLng, place.lat, place.lng);
                var isNearby = distance <= 5;

                var popupContent = `
                    <div style="text-align: center; max-width: 250px;">
                        <img src="/images/${place.icon}" alt="${place.name}" style="width:100%; height:auto; border-radius:8px; margin-bottom:8px;">
                        <h5 style="margin: 5px 0;">${place.name}</h5>
                        <p style="font-size: 14px;">${place.description}</p>
                        ${isNearby ? '<p style="color:green; font-weight:bold;">Within 5 km</p>' : ''}
                    </div>
                `;

                L.marker([place.lat, place.lng])
                    .addTo(map)
                    .bindPopup(popupContent);
            });

        }, function (error) {
            alert("Location access denied or unavailable.");
        });
    } else {
        alert("Geolocation is not supported by your browser.");
    }
});
</script>
