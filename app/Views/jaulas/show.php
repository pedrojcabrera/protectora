<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información del accesorio <?= esc($jaula->etiqueta) ?></h1>

<div class="card">
	<div class="card-body">

		<div class="card-text my-3">
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Etiqueta / Descripción:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= "<strong>".$jaula->etiqueta."</strong> / ".$jaula->descripcion ?>
				<p>
					<br><span class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Estado:
						</small></span>
					<?= $jaula->estado ? 'Util' : 'No útil'  ?>
				</p>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Características:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<p>
					<span class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Propietario:
						</small></span>
					<?= esc($jaula->propietario) ?>
				</p>
				<p>
					<span class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Ubicación:
						</small></span>
					<?= esc($jaula->ubicacion) ?>
				</p>
				<p>
					<span class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Características:
						</small></span>
					<br><?= nl2br(esc($jaula->caracteristicas)) ?>
				</p>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Creado:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($jaula->created_at);
				$strtotimefecha = strtotime($fecha);
				echo 'El '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($jaula->created_by);				
				?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Última actualización:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($jaula->updated_at);
				$strtotimefecha = strtotime($fecha);
				echo 'El '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($jaula->updated_by);				
				?>
			</div>
		</div>
		<div class="mt-3">
			<a href="<?= site_url('jaulas') ?>" class="btn btn-sm btn-info bi-person-lines-fill"> Volver al
				listado</a>
		</div>
	</div>
</div>
<?= $this->endSection() ?>