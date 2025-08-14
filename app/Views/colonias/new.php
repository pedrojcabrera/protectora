<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Agregar colonia</h1>

<div class="card">
	<div class="card-body text-center">
		<?php if (session('validation')): ?>
		<div class="alert alert-danger validation-errors">
			<h3>Atención</h3>
			<?= session('validation')->listErrors() ?>
		</div>
		<?php endif; ?>

		<form class="text-start" action="<?= site_url('colonias/store') ?>" method="post">
			<?= csrf_field() ?>
			<div class="row col-12">
				<div class="col-6 mb-3">
					<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
					<input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>"
						required>
				</div>
				<div class="col-6 mb-3">
					<label for="tipo" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo</small></label>
					<select name="tipo" id="tipo" class="form-select">
						<option value="" disabled selected>Identifica el tipo de colonia</option>
						<?php foreach ($tipos as $tipo): ?>
						<option value="<?= $tipo ?>" <?= old('tipo') == $tipo ? 'selected' : '' ?>>
							<?= ucFirst($tipo) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="mb-3">
				<label for="ubicacion" class="fs-6 fw-mute fw-light fst-italic"><small>Ubicación
						(detallada)</small></label>
				<textarea name="ubicacion" id="ubicacion" class="form-control"><?= old('ubicacion') ?></textarea>
			</div>
			<div class="mb-3">
				<label for="gps" class="fs-6 fw-mute fw-light fst-italic"><small>Ubicación GPS
						(google.maps)</small></label>
				<input type="text" name="gps" id="gps" class="form-control" value="<?= old('gps') ?>">
			</div>

			<div class="mb-3">
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones"
					class="form-control"><?= old('observaciones') ?></textarea>
			</div>

			<div class="mb-3">
				<label for="responsable" class="fs-6 fw-mute fw-light fst-italic"><small>responsable</small></label>
				<select name="responsable" id="responsable" class="form-select" required>
					<option value="" disabled selected>Selecciona un responsable</option>
					<?php foreach ($socios as $socio): ?>
					<option value="<?= $socio->id ?>" <?= old('responsable') == $socio->id ? 'selected' : '' ?>>
						<?= $socio->nombre ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mb-3">
				<label for="adjunto" class="fs-6 fw-mute fw-light fst-italic"><small>adjunto</small></label>
				<select name="adjunto" id="adjunto" class="form-select">
					<option value="" selected></option>
					<?php foreach ($socios as $socio): ?>
					<option value="<?= $socio->id ?>" <?= old('adjunto') == $socio->id ? 'selected' : '' ?>>
						<?= $socio->nombre ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="mt-3 botonera-fija">
				<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
				<a href="<?= site_url('colonias') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Volver</a>
			</div>
		</form>
	</div>
</div>
<?= $this->endSection() ?>