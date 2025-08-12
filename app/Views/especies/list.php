<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Especies</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= site_url('especies/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= site_url('especies/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
			Informe</a>
		<hr>
		<!-- Cabecera -->
		<div class="row text-start fw-bold border-bottom py-2">
			<div class="col-2">Especie</div>
			<div class="col-8">Observaciones</div>
			<div class="col-2 text-center">Acciones</div>
		</div>
		<!-- Datos -->
		<?php foreach($especies as $especie): ?>
		<div class="row text-start border-bottom py-2 align-items-center">
			<div class="col-2"><?= esc($especie->especie) ?></div>
			<div class="col-8"><?= esc($especie->observaciones) ?></div>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= site_url('especies/show/' . $especie->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver "></a>
				<a href="<?= site_url('especies/edit/' . $especie->id) ?>"
					class="d-inline btn btn-sm btn-primary bi-pencil" title="Editar"></a>
				<form action="<?= site_url('especies/delete') ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta especie?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $especie->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
			</div>
		</div>
		<?php endforeach; ?>
		<hr>
		<caption><?= count($especies) ?> especies</caption>
	</div>
</div>
<?= $this->endSection() ?>