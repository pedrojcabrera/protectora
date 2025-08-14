<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Perfil de <?= session('usuario_nombre') ?></h1>

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
		<form class="text-start" action="<?= site_url('usuarios/perfilDatos') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="id" value="<?= session('usuario_id') ?>">

			<div class="mb-3">
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" class="form-control" name="nombre" id="nombre"
					value="<?= old('nombre', $usuario->nombre) ?>" required>
			</div>

			<div class="mb-3">
				<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
				<input type="text" class="form-control" name="telefono" id="telefono"
					value="<?= old('telefono', $usuario->telefono) ?>">
			</div>

			<div class="mb-3">
				<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Email</small></label>
				<input type="email" class="form-control" name="email" id="email"
					value="<?= old('email', $usuario->email) ?>">
			</div>
			<div class="mt-3 botonera-fija">
				<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
				<a href="<?= site_url('/') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
			</div>
		</form>
	</div>
</div>
<?= $this->endSection() ?>