<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Usuario</h1>

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
		<form class="text-start" action="<?= site_url('usuarios/update') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="id" value="<?= $usuario->id ?>">

			<div class="mb-3">
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" class="form-control" name="nombre" id="nombre"
					value="<?= old('nombre', $usuario->nombre) ?>" required autofocus>
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

			<div class="mb-3">
				<?php $estadoSeleccionado = old('estado') ?? $usuario->estado ?? ''; ?>
				<label for="estado" class="fs-6 fw-mute fw-light fst-italic"><small>Estado</small></label>
				<select name="estado" id="estado" class="form-select" required
					<?= session('nivel') === 'user' ? 'readonly' : '' ?>>
					<option value="">-- Selecciona estado --</option>
					<option value="activo" <?= $estadoSeleccionado === 'activo' ? 'selected' : '' ?>>Activo</option>
					<option value="inactivo" <?= $estadoSeleccionado === 'inactivo' ? 'selected' : '' ?>>Inactivo
					</option>
				</select>
			</div>

			<div class="mb-3">
				<?php $nivelSeleccionado = old('nivel') ?? $usuario->nivel ?? ''; ?>
				<label for="nivel" class="fs-6 fw-mute fw-light fst-italic"><small>Nivel</small></label>
				<select name="nivel" id="nivel" class="form-select" required
					<?= session('nivel') != 'super' ? 'readonly' : '' ?>>
					<option value="">-- Selecciona nivel --</option>
					<option value="user" <?= $nivelSeleccionado === 'user' ? 'selected' : '' ?>>Usuario</option>
					<option value="admin" <?= $nivelSeleccionado === 'admin' ? 'selected' : '' ?>>Administrador
					</option>
				</select>
			</div>
			<hr>
			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
			<a href="<?= site_url('usuarios') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>