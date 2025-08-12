<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Razas</h1>

<div class="card">
	<div class="card-body text-center">
		<?php if (session('error')): ?>
		<div class="alert alert-danger validation-errors">
			<h3>Atención</h3>
			<?= session('error') ?>
		</div>
		<?php endif; ?>
		<form class="text-start" action="<?= site_url('razas/update') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="id" value="<?= $raza->id ?>">

			<div class="mb-3">
				<label for="especie" class="fs-6 text-muted fw-light fst-italic"><small>Especie</small></label>
				<select name="especie" id="especie" class="form-select" required>
					<option value="" selected disabled>Seleccione una especie</option>
					<?php foreach ($especies as $especie): ?>
					<option value="<?= $especie->id ?>"
						<?= old('especie', $raza->especie_id) == $especie->id ? 'selected' : '' ?>>
						<?= esc($especie->especie) ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mb-3">
				<label for="raza" class="fs-6 text-muted fw-light fst-italic"><small>Raza</small></label>
				<input type="text" class="form-control" name="raza" id="raza" value="<?= old('raza', $raza->raza) ?>"
					required autofocus>
			</div>

			<div class="mb-3">
				<label for="observaciones"
					class="fs-6 text-muted fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones"
					class="form-control"><?= old('observaciones', $raza->observaciones) ?></textarea>
			</div>

			<hr>
			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
			<a href="<?= site_url('razas') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>