<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Plano de las colonias<?= (isset($id)) ? ' de '.$responsable : ' - Puntos de Alimentación' ?></h1>

<div class="card">
	<div class="card-body">

		<div id="map" style="height: calc(100vh - 200px);"></div>
		<!-- Mapa se cargará aquí -->
	</div>

</div>
</div>
<?= $this->endSection() ?>


<!-- Leaflet JS script to display the map -->
<?= $this->section('scriptsAnexos') ?>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const puntos = <?= json_encode($puntos) ?>;

// const map = L.map('map').setView([puntos[0].lat, puntos[0].lon], 14);

const map = L.map('map');

// Crear un array de coordenadas a partir de los puntos
const coordenadas = puntos.map(p => [p.lat, p.lon]);

// Calcular los límites
const bounds = L.latLngBounds(coordenadas);

// Ajustar el mapa para que muestre todos los puntos
map.fitBounds(bounds);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

var iconoGatourb = L.icon({
	iconUrl: "<?= base_url('images/iconitoAzul.png') ?>",
	iconSize: [20.4, 32],
	iconAnchor: [16, 32],
	popupAnchor: [10, -32]
});
var iconoGatorur = L.icon({
	iconUrl: "<?= base_url('images/iconitoVerde.png') ?>",
	iconSize: [20.4, 32],
	iconAnchor: [16, 32],
	popupAnchor: [10, -32]
});

puntos.forEach(p => {
	const marker = L.marker([p.lat, p.lon], {
		icon: p.tip.includes('urb') ? iconoGatourb : iconoGatorur,
	}).addTo(map);

	// Mostrar el nombre como tooltip permanente
	marker.bindTooltip(p.nom, {
		permanent: false,
		direction: 'top',
		offset: [0, -33], // Subimos el texto un poco más
	});

	// Mostrar el responsable al pinchar
	marker.bindPopup(p.nom + '<br>' + p.res);
});
</script>


<?= $this->endSection() ?>