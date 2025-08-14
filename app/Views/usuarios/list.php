<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Usuarios</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= site_url('usuarios/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= site_url('usuarios/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
			Informe</a>
		<hr>
		<!-- Cabecera -->
		<div class="row text-start fw-bold border-bottom py-2">
			<div class="col-4">Nombre</div>
			<div class="col-4">Email</div>
			<div class="col-2">Nivel</div>
			<div class="col-2 text-center">Acciones</div>
		</div>
		<!-- Datos -->
		<?php foreach($usuarios as $usuario): ?>
		<div class="row text-start border-bottom py-2 align-items-center <?= $textosColores[esc($usuario->estado)] ?>">
			<div class="col-4"><?= esc($usuario->nombre) ?></div>
			<div class="col-4"><?= esc($usuario->email) ?></div>
			<div class="col-2"><small><?= $niveles[esc($usuario->nivel)] ?></small></div>
			<?php if($usuario->estado != 'pendiente'): ?>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= site_url('usuarios/show/' . $usuario->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver "></a>
				<a href="<?= site_url('usuarios/edit/' . $usuario->id) ?>"
					class="d-inline btn btn-sm btn-primary bi-pencil" title="Editar"></a>
				<form action="<?= site_url('usuarios/delete/' . $usuario->id) ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $usuario->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
			</div>
			<?php endif ?>
		</div>
		<?php endforeach; ?>
		<div class="mt-3">
			<caption><?= count($usuarios) ?> usuarios</caption>
		</div>
	</div>
</div>
<?= $this->endSection() ?>