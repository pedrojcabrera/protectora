<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('subTitulo') ?>
Agregar Veterinario
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
	<div class="card-body text-center">
		<?php if (session()->getFlashdata('error')): ?>
		<div class="alert alert-danger">
			<?= session('error') ?>
		</div>
		<?php endif; ?>

		<?php if (isset($validation)): ?>
		<div class="alert alert-danger">
			<?= $validation->listErrors() ?>
		</div>
		<?php endif; ?>

		<form class="text-start" action="<?= site_url('veterinarios/store') ?>" method="post">
			<?= csrf_field() ?>

			<div class="mb-3">
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" required>
			</div>

			<div class="mb-3">
				<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
				<input type="text" name="telefono" id="telefono" class="form-control" value="<?= old('telefono') ?>">
			</div>

			<div class="mb-3">
				<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Correo</small> electrónico</label>
				<input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>">
			</div>

			<div class="mb-3">
				<label for="dirección" class="fs-6 fw-mute fw-light fst-italic"><small>Dirección</small></label>
				<textarea name="direccion" id="direccion" class="form-control" rows="3"
					required><?= old('direccion') ?></textarea>
			</div>

			<div class="mb-3">
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones" class="form-control"
					rows="3"><?= old('observaciones') ?></textarea>
			</div>
			<hr>
			<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
			<a href="<?= site_url('veterinarios') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>