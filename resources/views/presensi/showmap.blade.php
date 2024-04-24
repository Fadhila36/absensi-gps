 <style>
     #map {
         height: 250px;
     }
 </style>
 <div id="map">
 </div>

 <script>
     let lokasi = "{{ $presensi->lokasi_in }}"
     let lok = lokasi.split(",");
     let latitude = lok[0];
     let longitude = lok[1];
     let map = L.map('map', {
         attributionControl: false
     }).setView([latitude, longitude], 17);
     L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
         maxZoom: 19,
         attribution: '&copy; <a href="http://www.inditara.com">PT. Intelek Digital Nusantara</a>'
     }).addTo(map);
     let marker = L.marker([latitude, longitude]).addTo(map);
     let circle = L.circle([-6.3650752481413315, 107.34753819793875], {
         color: 'red',
         fillColor: '#f03',
         fillOpacity: 0.5,
         radius: 30
     }).addTo(map);
     let popup = L.popup()
    .setLatLng([latitude, longitude])
    .setContent("{{ $presensi->nama_lengkap }}")
    .openOn(map);
 </script>
