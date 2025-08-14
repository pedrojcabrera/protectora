<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Jaulas trampa y otros accesorios</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= site_url('jaulas/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= site_url('jaulas/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
			Informe</a>
		<hr>
		<!-- Cabecera -->
		<div class="row text-start fw-bold border-bottom py-2">
			<div class="col-3">Etiqueta/Descripción</div>
			<div class="col-2">Estado</div>
			<div class="col-5">Propiedad/Ubicación</div>
			<div class="col-2 text-center">Acciones</div>
		</div>
		<!-- Datos -->
		<?php foreach($jaulas as $jaula): ?>
		<div class="row text-start border-bottom py-2 align-items-center">
			<div class="col-3">
				<?= '<strong>'.$jaula->etiqueta.'</strong>'.($jaula->descripcion ? '<br>'.$jaula->descripcion : '')?>
			</div>
			<div class="col-2"><?= ($jaula->estado) ? 'Util' : 'No útil' ?></div>
			<div class="col-5">· <?= esc($jaula->propietario).'<br>· '. esc($jaula->ubicacion) ?></div></small>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= site_url('jaulas/show/' . $jaula->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver "></a>
				<a href="<?= site_url('jaulas/edit/' . $jaula->id) ?>" class="d-inline btn btn-sm btn-primary bi-pencil"
					title="Editar"></a>
				<form action="<?= site_url('jaulas/delete') ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta jaula?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $jaula->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="mt-3">
			<caption><?= count($jaulas) ?> elemento<?= (count($jaulas) > 1 )? 's' : '' ?></caption>
		</div>
	</div>
</div>

<?= $this->endSection() ?>