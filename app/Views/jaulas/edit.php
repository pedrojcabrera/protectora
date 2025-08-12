<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Jaula Trampa</h1>

<div class="card">
	<div class="card-body text-center">
		<?php if (session('validation')): ?>
		<div class="alert alert-danger validation-errors">
			<h3>Atención</h3>
			<?= session('validation')->listErrors() ?>
		</div>
		<?php endif; ?>
		<form class="text-start" action="<?= base_url('jaulas/update') ?>" method="post">
			<?= csrf_field() ?>
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id" value="<?= esc($jaula->id ?? '') ?>">

			<div class="col-12">
				<!-- Etiqueta y Estado -->
				<div class="row mb-3">
					<div class="col-6">
						<label for="etiqueta"
							class="fs-6 text-muted fw-light fst-italic"><small>Etiqueta</small></label>
						<input type="text" class="form-control" name="etiqueta" id="etiqueta"
							value="<?= esc(old('etiqueta', $jaula->etiqueta ?? '')) ?>" maxlength="20" required
							autofocus style="width: 20ch">
					</div>
					<div class="col-6">
						<label for="estado" class="fs-6 text-muted fw-light fst-italic"><small>Estado</small></label>
						<select name="estado" id="estado" class="form-select w-auto">
							<option value="1" <?= old('estado', $jaula->estado ?? '') == '1' ? 'selected' : '' ?>>Útil
							</option>
							<option value="0" <?= old('estado', $jaula->estado ?? '') == '0' ? 'selected' : '' ?>>No
								útil</option>
						</select>
					</div>
				</div>

				<!-- Descripción -->
				<div class="row mb-3">
					<div class="col-12">
						<label for="descripcion"
							class="fs-6 text-muted fw-light fst-italic"><small>Descripción</small></label>
						<input type="text" class="form-control" name="descripcion" id="descripcion"
							value="<?= esc(old('descripcion', $jaula->descripcion ?? '')) ?>" required>
					</div>
				</div>

				<!-- Propietario y Ubicación -->
				<div class="row mb-3">
					<div class="col-6">
						<label for="propietario" class="fs-6 text-muted fw-light fst-italic">Propietario</label>
						<select name="propietario" id="propietario" class="form-select">
							<option value="La Protectora"
								<?= old('propietario', $jaula->propietario ?? '') == 'La Protectora' ? 'selected' : '' ?>>
								Asociación Protectora
							</option>
							<option value="0" disabled>-----------------------------</option>
							<?php foreach ($socios as $socio): ?>
							<option value="<?= esc($socio->nombre) ?>"
								<?= old('propietario', $jaula->propietario ?? '') == $socio->nombre ? 'selected' : '' ?>>
								<?= esc($socio->nombre) ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-6">
						<label for="ubicacion" class="fs-6 text-muted fw-light fst-italic">Ubicación</label>
						<input list="listaUbicaciones" name="ubicacion" id="ubicacion" class="form-control"
							value="<?= esc(old('ubicacion', $jaula->ubicacion ?? '')) ?>"
							placeholder="Seleccione o escriba una ubicación">

						<datalist id="listaUbicaciones">
							<option value="En nuestra protectora">
							<option value="Se encuentra Perdida">
							<option value="---" disabled>
								<?php foreach ($socios as $socio): ?>
							<option value="<?= esc($socio->nombre) ?>">
								<?php endforeach; ?>
						</datalist>
					</div>
				</div>

				<!-- Características -->
				<div class="mb-3">
					<label for="caracteristicas"
						class="fs-6 text-muted fw-light fst-italic"><small>Características</small></label>
					<textarea name="caracteristicas" id="caracteristicas"
						class="form-control"><?= esc(old('caracteristicas', $jaula->caracteristicas ?? '')) ?></textarea>
				</div>

				<!-- Botones -->
				<hr>
				<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
				<a href="<?= base_url('jaulas') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Volver</a>
			</div>
		</form>

	</div>
</div>
<?= $this->endSection() ?>