<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información de <?= esc($usuario->usuario) ?></h1>

<div class="card">
	<div class="card-body">

		<div class="card-text my-3">
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Nombre:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= nl2br(esc($usuario->nombre)) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Teléfono:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($usuario->telefono) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Email:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($usuario->email) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Estado:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($usuario->estado) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Nivel:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= $niveles[esc($usuario->nivel)] ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Creado:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?php
				$fecha = esc($usuario->created_at);
				echo date('d/m/Y   H:i:s', strtotime($fecha));				
				?>
			</div>
		</div>
		<div class="mt-3 botonera-fija">
			<a href="<?= site_url('usuarios') ?>" class="btn btn-sm btn-info bi-person-lines-fill"> Volver al
				listado</a>
		</div>
	</div>
</div>
<?= $this->endSection() ?>