<script type="text/javascript">
var lon = '<?=$presensi->lon?>';
var lat = '<?=$presensi->lat?>';
var nama_pegawai = '<?=$presensi->nama_pegawai?>';
var map = L.map('mapid').setView([lon,lat], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([0.878438,124.0280393]).addTo(map)
    .bindPopup(nama_pegawai)
    .openPopup();
</script>