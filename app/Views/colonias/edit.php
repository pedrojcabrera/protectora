<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Colonia <?=$colonia->nombre?></h1>

<div class="card">
	<div class="card-body text-center">
		<?php if (session('validation')): ?>
		<div class="alert alert-danger validation-errors">
			<h3>Atención</h3>
			<?= session('validation')->listErrors() ?>
		</div>
		<?php endif; ?>
		<form class="text-start" action="<?= site_url('colonias/update') ?>" method="post">
			<?= csrf_field() ?>

			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id" value="<?= $colonia->id ?>">

			<div class="row col-12">
				<div class="col-6 mb-3">
					<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
					<input type="text" class="form-control" name="nombre" id="nombre"
						value="<?= old('nombre', $colonia->nombre) ?>" required autofocus>
				</div>

				<?php $selectedTipo = old('tipo', $colonia->tipo ?? ''); ?>

				<div class="col-6 mb-3">
					<label for="tipo" class="fs-6 fw-mute fw-light fst-italic">Tipo</label>
					<select name="tipo" id="tipo" class="form-select" required>
						<option value="" disabled selected>
							Identifica el tipo de colonia
						</option>
						<?php foreach ($tipos as $tipo): ?>
						<option value="<?= esc($tipo) ?>" <?= $selectedTipo === $tipo ? 'selected' : '' ?>>
							<?= ucFirst(esc($tipo)) ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="mb-3">
				<label for="ubicacion" class="fs-6 fw-mute fw-light fst-italic"><small>Ubicación
						(detallada)</small></label>
				<textarea name="ubicacion" id="ubicacion"
					class="form-control"><?= old('ubicacion',$colonia->ubicacion) ?></textarea>
			</div>

			<div class="mb-3">
				<label for="gps" class="fs-6 fw-mute fw-light fst-italic"><small>Ubicacióm GPS
						(google.maps)</small></label>
				<input type="text" class="form-control" name="gps" id="gps" value="<?= old('gps', $colonia->gps) ?>">
			</div>

			<div class="mb-3">
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones"
					class="form-control"><?= old('observaciones', $colonia->observaciones) ?></textarea>
			</div>

			<div class="mb-3">
				<label for="responsable" class="fs-6 fw-mute fw-light fst-italic">Responsable</label>
				<select name="responsable" id="responsable" class="form-select" required>
					<option value="" selected disabled>Selecciona un responsable</option>"
					<?php foreach ($socios as $socio): ?>
					<option value="<?= $socio->id ?>"
						<?= old('responsable', $colonia->responsable_id) == $socio->id ? 'selected' : '' ?>>
						<?= $socio->nombre ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mb-3">
				<label for="adjunto" class="fs-6 fw-mute fw-light fst-italic">Responsable adjunto</label>
				<select name="adjunto" id="adjunto" class="form-select">
					<option value="" selected>sin responsable adjunto</option>
					<?php foreach ($socios as $socio): ?>
					<option value="<?= $socio->id ?>"
						<?= old('adjunto', $colonia->adjunto_id) == $socio->id ? 'selected' : '' ?>>
						<?= $socio->nombre ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
			<hr>
			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Actualizar</button>
			<a href="<?= site_url('colonias') ?>" class="btn btn-sm btn-secondary bi-box-arrow-left"> Cancelar</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>