<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información de Especie</h1>

<div class="card">
	<div class="card-body">

		<div class="card-text my-3">
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Especie:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= nl2br(esc($especie->especie)) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Observaciones:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= nl2br(esc($especie->observaciones)) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Creado:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($especie->created_at);
				$strtotimefecha = strtotime($fecha);
				echo 'El '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($especie->created_by);				
				?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Última actualización:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($especie->updated_at);
				$strtotimefecha = strtotime($fecha);
				echo 'El '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($especie->updated_by);				
				?>
			</div>
		</div>

		<a href="<?= site_url('especies') ?>" class="btn btn-sm btn-info bi-person-lines-fill"> Volver al
			listado</a>
	</div>
</div>
<?= $this->endSection() ?>