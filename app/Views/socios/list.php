<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Socios</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= site_url('socios/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= site_url('socios/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
			Informe</a>
		<hr>
		<!-- Cabecera -->
		<div class="row text-start fw-bold border-bottom py-2">
			<div class="col-4">Nombre</div>
			<div class="col-4">Email</div>
			<div class="col-2">Teléfono</div>
			<div class="col-2 text-center">Acciones</div>
		</div>
		<!-- Datos -->
		<?php foreach($socios as $socio): ?>
		<div class="row text-start border-bottom py-2 align-items-center">
			<div class="col-4"><?= esc($socio->nombre) ?></div>
			<div class="col-4"><?= esc($socio->email) ?></div>
			<div class="col-2"><?= esc($socio->telefono) ?></div></small>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= site_url('socios/show/' . $socio->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver "></a>
				<a href="<?= site_url('socios/edit/' . $socio->id) ?>" class="d-inline btn btn-sm btn-primary bi-pencil"
					title="Editar"></a>
				<form action="<?= site_url('socios/delete') ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar este socio?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $socio->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
				<a href="<?=base_url('colonias/showMapa/' . $socio->id)?>"
					class="d-inline btn btn-sm btn-primary bi-geo-alt-fill" title="Colonias Propias"></a>

			</div>
		</div>
		<?php endforeach; ?>
		<br>
		<caption><?= count($socios) ?> socios</caption>
	</div>
</div>
<?= $this->endSection() ?>