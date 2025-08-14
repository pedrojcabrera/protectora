<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información de <?= esc($veterinario->nombre) ?></h1>

<div class="card">
	<div class="card-body">
		<div class="card-text my-3">
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Dirección:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= nl2br(esc($veterinario->direccion)) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Teléfono:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($veterinario->telefono) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Email:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($veterinario->email) ?>
			</div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Observaciones:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= nl2br(esc($veterinario->observaciones)) ?>
			</div>
		</div>
		<div class="mt-3 botonera-fija">
			<a href="<?= site_url('veterinarios') ?>" class="btn btn-sm btn-info bi-person-lines-fill"> Volver al
				listado</a>
		</div>
	</div>
</div>
<?= $this->endSection() ?>