<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Especie</h1>

<div class="card">
	<div class="card-body text-center">
		<?php if (session('validation')): ?>
		<div class="alert alert-danger validation-errors">
			<h3>Atención</h3>
			<?= session('validation')->listErrors() ?>
		</div>
		<?php endif; ?>
		<form class="text-start" action="<?= site_url('especies/update') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="id" value="<?= $especie->id ?>">

			<div class="mb-3">
				<label for="especie" class="fs-6 fw-mute fw-light fst-italic"><small>Especie</small></label>
				<input type="text" class="form-control" name="especie" id="especie"
					value="<?= old('especie', $especie->especie) ?>" required autofocus>
			</div>

			<div class="mb-3">
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones"
					class="form-control"><?= old('observaciones', $especie->observaciones) ?></textarea>
			</div>

			<hr>
			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
			<a href="<?= site_url('especies') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>