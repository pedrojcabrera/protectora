<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Veterinarios</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= site_url('veterinarios/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= site_url('veterinarios/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
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
		<?php foreach ($veterinarios as $veterinario): ?>
		<div class="row text-start border-bottom py-2 align-items-center">
			<div class="col-4"><?= esc($veterinario->nombre) ?></div>
			<div class="col-4"><?= esc($veterinario->email) ?></div>
			<div class="col-2"><?= esc($veterinario->telefono) ?></div>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= site_url('veterinarios/show/' . $veterinario->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver detalles"></a>
				<?php if(session('usuario_nivel') != 'user'): ?>
				<a href="<?= site_url('veterinarios/edit/' . $veterinario->id) ?>"
					class="d-inline btn btn-sm btn-primary bi-pencil" title="Editar"></a>
				<form action="<?= site_url('veterinarios/delete') ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar este veterinario?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $veterinario->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
				<?php endif ?>
			</div>
		</div>
		<?php endforeach; ?>
		<hr>
		<caption><?= count($veterinarios) ?> veterinarios</caption>
	</div>
</div>


<?= $this->endSection() ?>