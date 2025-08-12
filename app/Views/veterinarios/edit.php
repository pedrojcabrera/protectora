<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Agregar Veterinario</h1>

<?php $validation = session('validation'); ?>

<div class="card">
	<div class="card-body text-center">
		<?php if (session()->getFlashdata('error')): ?>
		<div class="alert alert-danger">
			<?= session('error') ?>
		</div>
		<?php endif; ?>
		<?php if (!empty($validation) && $validation->getErrors()): ?>
		<div class="alert alert-danger">
			<?= $validation->listErrors() ?>
		</div>
		<?php endif; ?>
		<form class="text-start" action="<?= site_url('veterinarios/update') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id" value="<?= $veterinario->id ?>">

			<div class="mb-3">
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" class="form-control" name="nombre" id="nombre"
					value="<?= old('nombre', $veterinario->nombre) ?>" required>
			</div>

			<div class="mb-3">
				<label for="direccion" class="fs-6 fw-mute fw-light fst-italic"><small>Dirección</small></label>
				<textarea name="direccion" id="direccion" class="form-control" rows="3"
					required><?= old('direccion', $veterinario->direccion) ?></textarea>
			</div>

			<div class="mb-3">
				<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
				<input type="text" class="form-control" name="telefono" id="telefono"
					value="<?= old('telefono', $veterinario->telefono) ?>">
			</div>

			<div class="mb-3">
				<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Email</small></label>
				<input type="email" class="form-control" name="email" id="email"
					value="<?= old('email', $veterinario->email) ?>">
			</div>

			<div class="mb-3">
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones" class="form-control"
					rows="3"><?= old('observaciones', $veterinario->observaciones) ?></textarea>
			</div>
			<hr>
			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
			<a href="<?= site_url('veterinarios') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>