<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información de la colonia <?= esc($colonia->nombre) ?></h1>

<div class="card">
	<div class="card-body">

		<div class="card-text my-3">
			<div class="row col-12">
				<div class="col-6">
					<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Nombre:</small></p>
					<div class="form-control px-2 py-3 m-0">
						<?=esc($colonia->nombre) ?>
					</div>
				</div>
				<div class="col-6">
					<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Tipo:</small></p>
					<div class="form-control px-2 py-3 m-0">
						<?=ucFirst(esc($colonia->tipo)) ?>
					</div>
				</div>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Ubicación (detallada):</small>
			</p>
			<div class="form-control px-2 py-3 m-0">
				<?=  nl2br(trim(esc($colonia->ubicacion))) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Ubicación GPS
					(gogle.maps):</small>
			</p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($colonia->gps) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Observaciones:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= nl2br(trim(esc($colonia->observaciones))) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Responsable:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($colonia->responsable_nombre) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Adjunto:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($colonia->adjunto_nombre) ?>
			</div>
			<?php if($lat): ?>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Detalle:</small></p>
			<div id="map" style="height: 300px;"></div>
			<?php endif; ?>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Creado:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($colonia->created_el);
				$strtotimefecha = strtotime($fecha);
				echo 'El '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($colonia->created_por);				
				?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Última actualización:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($colonia->updated_el);
				$strtotimefecha = strtotime($fecha);
				echo 'El '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($colonia->updated_por);				
				?>
			</div>
		</div>

		<a href="<?= site_url('colonias') ?>" class="btn btn-sm btn-info bi-person-lines-fill"> Volver al
			listado</a>
	</div>
</div>
<?= $this->endSection() ?>


<!-- Leaflet JS script to display the map -->
<?= $this->section('scriptsAnexos') ?>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Coordenadas del punto
var lat = <?= $lat ?>;
var lng = <?= $lng ?>;

// Icono personalizado
var iconoGato = L.icon({
	iconUrl: "<?= base_url('images/iconitoAzul.png') ?>",
	iconSize: [20.4, 32],
	iconAnchor: [16, 32],
	popupAnchor: [10, -32]
});

// Inicializa el mapa
var map = L.map('map').setView([lat, lng], 15); // Zoom 15

// Capa base de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Marcador
L.marker([lat, lng], {
		icon: iconoGato,
	}).addTo(map)
	.openPopup();
</script>

<?= $this->endSection() ?>