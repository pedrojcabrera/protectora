<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Colonias</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= site_url('colonias/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= site_url('colonias/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
			Informe</a>
		<hr>
		<!-- Cabecera -->
		<div class="row text-start fw-bold border-bottom py-2">
			<div class="col-2">Nombre</div>
			<div class="col-3">GPS</div>
			<div class="col-5">Responsables</div>
			<div class="col-2 text-center">Acciones</div>
		</div>
		<!-- Datos -->
		<?php foreach($colonias as $colonia): ?>
		<div class="row text-start border-bottom py-2 align-items-center">
			<div class="col-2"><strong><?= esc($colonia->nombre) ?></strong></div>
			<div class="col-3"><small><?= esc($colonia->gps) ?></small></div>
			<div class="col-5 text-start">
				<small><em>Titular: </em><?= esc($colonia->responsable_nombre) ?></small>
				<?php if ($colonia->adjunto_nombre): ?>
				<br>
				<small><em>Adjunto titular: </em><?= esc($colonia->adjunto_nombre) ?></small>
				<?php endif; ?>
			</div>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= site_url('colonias/show/' . $colonia->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver "></a>
				<a href="<?= site_url('colonias/edit/' . $colonia->id) ?>"
					class="d-inline btn btn-sm btn-primary bi-pencil" title="Editar"></a>
				<form action="<?= site_url('colonias/delete') ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta colonia?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $colonia->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
			</div>
		</div>
		<?php endforeach; ?>
		<hr>
		<caption><?= count($colonias) ?> colonias</caption>
	</div>
</div>
<?= $this->endSection() ?>