<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Lista de Animales</h1>

<div class="card">
	<div class="card-body text-center">
		<a href="<?= base_url('animales/new') ?>" class="btn btn-sm btn-primary bi-plus"> Agregar</a>
		<a href="<?= base_url('animales/pdf') ?>" class="btn btn-sm btn-info bi-filetype-pdf" target="_blank">
			Informe</a>
		<hr>
		<!-- Cabecera -->
		<div class="row text-start fw-bold border-bottom py-2">
			<div class="col-4 text-center">Animal</div>
			<div class="col-6 text-center">Observaciones</div>
			<div class="col-2 text-center">Acciones</div>
		</div>
		<!-- Datos -->
		<?php foreach($animales as $animal): ?>
		<div class="row text-start border-bottom py-2 align-items-center">
			<div class="col-2"><?= esc($animal->nombre) ?></div>
			<div class="col-2">
				<?php if ($animal->foto): ?>
				<img src="<?= base_url($animal->foto) ?>" alt="Miniatura" class="img-thumbnail shadow-sm"
					style="width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalFoto"
					data-img="<?= base_url($animal->foto) ?>">
				<?php endif; ?>
			</div>
			<div class="col-6"><?= esc($animal->observaciones) ?></div>
			<div class="col-2 d-flex justify-content-center gap-1 text-right">
				<a href="<?= base_url('animales/show/' . $animal->id) ?>"
					class="d-inline btn btn-sm btn-success bi-person-vcard" title="Ver "></a>
				<a href="<?= base_url('animales/edit/' . $animal->id) ?>"
					class="d-inline btn btn-sm btn-primary bi-pencil" title="Editar"></a>
				<form action="<?= base_url('animales/delete') ?>" method="post" class="d-inline"
					onsubmit="return confirm('¿Estás seguro de que deseas eliminar este animal?');">
					<?= csrf_field() ?>
					<input type="hidden" name="id" value="<?= $animal->id ?>">
					<button type="submit" class="btn btn-sm btn-danger bi-trash" title="Eliminar"></button>
				</form>
			</div>
		</div>
		<?php endforeach; ?>

		<!-- Modal a pantalla completa con X visualmente dentro de la imagen -->
		<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen">
				<div class="modal-content bg-dark bg-opacity-75 border-0">
					<div class="modal-body d-flex justify-content-center align-items-center p-0">

						<!-- Contenedor ajustado al tamaño de la imagen -->
						<div class="position-relative d-inline-block">
							<!-- Imagen -->
							<img id="modalImagen" src="" alt="Foto ampliada" class="img-thumbnail"
								style="max-height: 95vh; object-fit: contain; display: block;">
							<!-- Botón de cierre con icono Bootstrap centrado -->
							<button type="button"
								class="position-absolute d-flex justify-content-center align-items-center bg-dark bg-opacity-50 rounded-circle border-0"
								style="top: 10px; right: 10px; width: 45px; height: 45px; z-index: 10;"
								data-bs-dismiss="modal" aria-label="Cerrar">
								<i class="bi bi-x-lg text-white fs-4"></i>
							</button>

						</div>

					</div>
				</div>
			</div>
		</div>



		<hr>
		<caption><?= count($animales) ?> animales</caption>
	</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scriptsAnexos')?>
<script>
document.addEventListener('DOMContentLoaded', function() {
	const modal = document.getElementById('modalFoto');
	const imgModal = document.getElementById('modalImagen');

	modal.addEventListener('show.bs.modal', function(event) {
		const trigger = event.relatedTarget;
		const imgSrc = trigger.getAttribute('data-img');
		imgModal.src = imgSrc;
	});
});
</script>
<?= $this->endSection() ?>