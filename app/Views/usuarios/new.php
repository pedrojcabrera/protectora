<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('subTitulo') ?>
Agregar Usuario
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

		<form class="text-start" action="<?= site_url('usuarios/store') ?>" method="post">
			<?= csrf_field() ?>

			<div class="mb-3">
				<label for="usuario" class="fs-6 fw-mute fw-light fst-italic"><small>Usuario</small></label>
				<input type="text" name="usuario" id="usuario" class="form-control" value="<?= old('usuario') ?>"
					required>
			</div>

			<div class="mb-3">
				<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Correo</small> electrónico</label>
				<input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>">
			</div>

			<div class="mb-3">
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" required>
			</div>

			<div class="mb-3">
				<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
				<input type="text" name="telefono" id="telefono" class="form-control" value="<?= old('telefono') ?>">
			</div>

			<div class="form-check form-switch">
				<label class="form-check-label" for="nivel">Administrador</label>
				<input class="form-check-input" type="checkbox" name="nivel" value="admin" id="nivel"
					<?= old('nivel') === 'admin' ? 'checked' : '' ?>>
			</div>

			<div class="mt-3 botonera-fija">
				<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
				<a href="<?= site_url('usuarios') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Volver</a>
			</div>

		</form>
	</div>
</div>
<?= $this->endSection() ?>