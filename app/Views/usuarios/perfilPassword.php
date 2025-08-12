<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Contaseña de <?= session('usuario_nombre') ?></h1>

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
		<form class="text-start" action="<?= site_url('usuarios/perfilPassword') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="id" value="<?= session('usuario_id') ?>">

			<div class="mb-3">
				<label for="password" class="fs-6 fw-mute fw-light fst-italic"><small>Password
						(contraseña)</small></label>
				<input type="password" class="form-control" name="password" id="password" required>
			</div>

			<div class="mb-3">
				<label for="repite_Password" class="fs-6 fw-mute fw-light fst-italic"><small>Repite
						Password (contraseña)</small></label>
				<input type="password" class="form-control" name="repite_Password" id="repite_Password" required>
			</div>

			<hr>

			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
			<a href="<?= site_url('/') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>