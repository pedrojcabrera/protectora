<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Socio</h1>

<div class="card-body text-center">

	<?php if (session('validation')): ?>
	<div class="alert alert-danger validation-errors">
		<h3>Atención</h3>
		<?= session('validation')->listErrors() ?>
	</div>
	<?php endif; ?>
</div>

<form class="text-start" action="<?= site_url('socios/update') ?>" method="post" enctype="multipart/form-data">
	<?= csrf_field() ?>
	<input type="hidden" name="_method" value="PUT">
	<input type="hidden" name="id" value="<?= $socio->id ?? '' ?>">

	<div class="fs-5 fw-mute fw-light fst-italic">Datos de Localización</div>
	<div class="card px-2 py-1">
		<div class="d-grid mb-3" style="grid-template-columns: 2fr 2fr 1fr; gap: 1ch;">
			<div>
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" name="nombre" id="nombre" class="form-control"
					value="<?= old('nombre', $socio->nombre ?? '') ?>" required>
			</div>
			<div>
				<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Correo electrónico</small></label>
				<input type="email" name="email" id="email" class="form-control"
					value="<?= old('email', $socio->email ?? '') ?>">
			</div>
			<div>
				<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
				<input type="text" name="telefono" id="telefono" class="form-control"
					value="<?= old('telefono', $socio->telefono ?? '') ?>">
			</div>
		</div>

		<div class="d-grid mb-3" style="grid-template-columns: 1fr; gap: 1ch;">
			<div>
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones"
					class="form-control"><?= old('observaciones', $socio->observaciones ?? '') ?></textarea>
			</div>
			<div>
				<label for="direccion" class="fs-6 fw-mute fw-light fst-italic"><small>Dirección</small></label>
				<textarea name="direccion" id="direccion"
					class="form-control"><?= old('direccion', $socio->direccion ?? '') ?></textarea>
			</div>
		</div>

		<div class="d-grid mb-3" style="grid-template-columns: 1fr 2fr 2fr; gap: 1ch;">
			<div>
				<label for="codpostal" class="fs-6 fw-mute fw-light fst-italic"><small>Código Postal</small></label>
				<input type="text" name="codpostal" id="codpostal" class="form-control"
					value="<?= old('codpostal', $socio->codpostal ?? '') ?>">
			</div>
			<div>
				<label for="poblacion" class="fs-6 fw-mute fw-light fst-italic"><small>Población</small></label>
				<input type="text" name="poblacion" id="poblacion" class="form-control"
					value="<?= old('poblacion', $socio->poblacion ?? '') ?>">
			</div>
			<div>
				<label for="provincia" class="fs-6 fw-mute fw-light fst-italic"><small>Provincia</small></label>
				<input type="text" name="provincia" id="provincia" class="form-control"
					value="<?= old('provincia', $socio->provincia ?? '') ?>">
			</div>
		</div>

		<div class="d-grid mb-3" style="grid-template-columns: 1fr 2fr 2fr; gap: 1ch;">
			<div>
				<label for="tipo_documentoId" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo de
						documento</small></label>
				<select name="tipo_documentoId" id="tipo_documentoId" class="form-select" style="font-size: .9rem;"
					required>
					<option value="">-- Selecciona --</option>
					<?php $tipoDoc = old('tipo_documentoId', $socio->tipo_documentoId ?? ''); ?>
					<option value="DNI" <?= $tipoDoc === 'DNI' ? 'selected' : '' ?>>DNI</option>
					<option value="NIF" <?= $tipoDoc === 'NIF' ? 'selected' : '' ?>>NIF</option>
					<option value="NIE" <?= $tipoDoc === 'NIE' ? 'selected' : '' ?>>NIE</option>
				</select>
			</div>
			<div>
				<label for="documentoId" class="fs-6 fw-mute fw-light fst-italic"><small>Documento</small></label>
				<input type="text" name="documentoId" id="documentoId" class="form-control"
					value="<?= old('documentoId', $socio->documentoId ?? '') ?>">
			</div>
			<div>
				<label for="fecha_nacimiento" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha de
						nacimiento</small></label>
				<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
					style="font-size: .9rem;" value="<?= old('fecha_nacimiento', $socio->fecha_nacimiento ?? '') ?>">
			</div>
		</div>

		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr; gap: 1ch;">
			<!-- FOTO DNI ANVERSO -->
			<div class="text-center">
				<label for="foto_dni_anverso" class="fs-6 fw-mute fw-light fst-italic">
					<small>Foto DNI (anverso)</small>
				</label>
				<input type="file" class="form-control" id="foto_dni_anverso" name="foto_dni_anverso" accept="image/*"
					style="font-size: .9rem;" onchange="previewImage(event, 'preview_anverso', 'btn_cancelar_anverso')">

				<div class="mt-2 d-flex justify-content-center">
					<img id="preview_anverso"
						src="<?= isset($socio) && !empty($socio->foto_dni_anverso) ? base_url($socio->foto_dni_anverso) : '' ?>"
						data-original-src="<?= isset($socio) && !empty($socio->foto_dni_anverso) ? base_url($socio->foto_dni_anverso) : '' ?>"
						alt="Previsualización Anverso"
						style="max-width: 200px; max-height: 150px; <?= empty($socio->foto_dni_anverso) ? 'display:none;' : '' ?>">
				</div>

				<?php if (!empty($socio->foto_dni_anverso)): ?>
				<label for="borrar_foto_dni_anverso"
					class="btn btn-warning btn-sm mt-1 d-inline-flex align-items-center" style="cursor: pointer;">
					<input type="checkbox" name="borrar_foto_dni_anverso" id="borrar_foto_dni_anverso" value="1"
						class="form-check-input me-2" style="cursor: pointer;">
					Eliminar foto DNI (anverso) actual
				</label>
				<?php endif; ?>


				<button type="button" id="btn_cancelar_anverso" class="btn btn-sm btn-warning mt-1"
					style="display:none;"
					onclick="cancelarSeleccion('foto_dni_anverso', 'preview_anverso', 'btn_cancelar_anverso', 'borrar_foto_dni_anverso')">
					Cancelar selección
				</button>
			</div>

			<!-- FOTO DNI REVERSO -->
			<div class="text-center">
				<label for="foto_dni_reverso" class="fs-6 fw-mute fw-light fst-italic">
					<small>Foto DNI (reverso)</small>
				</label>
				<input type="file" class="form-control" id="foto_dni_reverso" name="foto_dni_reverso" accept="image/*"
					style="font-size: .9rem;" onchange="previewImage(event, 'preview_reverso', 'btn_cancelar_reverso')">

				<div class="mt-2 d-flex justify-content-center">
					<img id="preview_reverso"
						src="<?= isset($socio) && !empty($socio->foto_dni_reverso) ? base_url($socio->foto_dni_reverso) : '' ?>"
						data-original-src="<?= isset($socio) && !empty($socio->foto_dni_reverso) ? base_url($socio->foto_dni_reverso) : '' ?>"
						alt="Previsualización Reverso"
						style="max-width: 200px; max-height: 150px; <?= empty($socio->foto_dni_reverso) ? 'display:none;' : '' ?>">
				</div>

				<?php if (!empty($socio->foto_dni_reverso)): ?>
				<label for="borrar_foto_dni_reverso"
					class="btn btn-warning btn-sm mt-1 d-inline-flex align-items-center" style="cursor: pointer;">
					<input type="checkbox" name="borrar_foto_dni_reverso" id="borrar_foto_dni_reverso" value="1"
						class="form-check-input me-2" style="cursor: pointer;">
					Eliminar foto DNI (reverso) actual
				</label>
				<?php endif; ?>


				<button type="button" id="btn_cancelar_reverso" class="btn btn-sm btn-warning mt-1"
					style="display:none;"
					onclick="cancelarSeleccion('foto_dni_reverso', 'preview_reverso', 'btn_cancelar_reverso', 'borrar_foto_dni_reverso')">
					Cancelar selección
				</button>
			</div>

			<div>
				<label for="tipo" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo de socio</small></label>
				<?php $tipoSel = old('tipo', $socio->tipo ?? ''); ?>
				<select name="tipo" id="tipo" class="form-select" style="font-size: .9rem;">
					<?php foreach ($tipos as $tipo => $valor): ?>
					<option value="<?= $tipo ?>" <?= $tipoSel === $tipo ? 'selected' : '' ?>><?= $valor ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	<?php if(session('usuario_nivel') != "user"): ?>
	<!-- Datos Bancarios -->
	<div class="mt-3 fs-5 fw-mute fw-light fst-italic">Datos de gestión Bancaria</div>
	<div class="card px-2 py-1">
		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr; gap: 1ch;">
			<div>
				<label for="entidad_bancaria" class="fs-6 fw-mute fw-light fst-italic"><small>Entidad
						Bancaria</small></label>
				<input type="text" name="entidad_bancaria" id="entidad_bancaria" class="form-control"
					value="<?= old('entidad_bancaria', $socio->entidad_bancaria ?? '') ?>">
			</div>
			<div>
				<label for="cuenta_bancaria" class="fs-6 fw-mute fw-light fst-italic"><small>Número de Cuenta
						Bancaria</small></label>
				<input type="text" name="cuenta_bancaria" id="cuenta_bancaria" class="form-control"
					pattern="[A-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" maxlength="29"
					placeholder="ES00 0000 0000 0000 0000 0000"
					value="<?= old('cuenta_bancaria', $socio->cuenta_bancaria ?? '') ?>">
			</div>
		</div>
		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr; gap: 1ch;">
			<div>
				<label for="cuota_anual" class="fs-6 fw-mute fw-light fst-italic"><small>Cuota Anual</small></label>
				<input type="text" name="cuota_anual" id="cuota_anual" class="form-control"
					value="<?= old('cuota_anual', $socio->cuota_anual ?? '') ?>">
			</div>
			<div>
				<label for="complemento" class="fs-6 fw-mute fw-light fst-italic"><small>Complemento
						Voluntario</small></label>
				<input type="text" name="complemento" id="complemento" class="form-control"
					value="<?= old('complemento', $socio->complemento ?? '') ?>">
			</div>
			<div>
				<label for="modalidad_pago" class="fs-6 fw-mute fw-light fst-italic"><small>Modalidad de
						Pago</small></label>
				<select name="modalidad_pago" id="modalidad_pago" class="form-select" style="font-size: .9rem;">
					<?php foreach ($modalidadPago as $key => $valor): ?>
					<option value="<?= $key ?>"
						<?= old('modalidad_pago', $socio->modalidad_pago ?? '') === $key ? 'selected' : '' ?>>
						<?= $valor ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="ultimo_recibo_fecha" class="fs-6 fw-mute fw-light fst-italic"><small>Último Recibo
						Fecha</small></label>
				<input type="date" disabled name="ultimo_recibo_fecha" id="ultimo_recibo_fecha" class="form-control"
					value="<?= old('ultimo_recibo_fecha', $socio->ultimo_recibo_fecha ?? '') ?>">
			</div>
			<div>
				<label for="ultimo_recibo_importe" class="fs-6 fw-mute fw-light fst-italic"><small>Último Recibo
						Importe</small></label>
				<input type="text" disabled name="ultimo_recibo_importe" id="ultimo_recibo_importe" class="form-control"
					value="<?= old('ultimo_recibo_importe', $socio->ultimo_recibo_importe ?? '') ?>">
			</div>
		</div>

	</div>
	<?php endif; ?>

	<div class="mt-3">
		<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
		<a href="<?= site_url('socios') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Volver</a>
	</div>
</form>

<script>
function previewImage(event, previewId, btnCancelarId) {
	const input = event.target;
	const preview = document.getElementById(previewId);
	const btnCancelar = document.getElementById(btnCancelarId);

	if (input.files && input.files[0]) {
		const reader = new FileReader();
		reader.onload = function(e) {
			preview.src = e.target.result;
			preview.style.display = 'block';
			if (btnCancelar) btnCancelar.style.display = 'inline-block';
		};
		reader.readAsDataURL(input.files[0]);
	} else {
		// Si no hay archivo seleccionado, oculta imagen y botón cancelar
		preview.style.display = 'none';
		preview.src = '';
		if (btnCancelar) btnCancelar.style.display = 'none';
	}
}

function cancelarSeleccion(inputId, previewId, btnCancelarId, checkboxBorrarId) {
	const input = document.getElementById(inputId);
	const preview = document.getElementById(previewId);
	const btnCancelar = document.getElementById(btnCancelarId);
	const checkboxBorrar = checkboxBorrarId ? document.getElementById(checkboxBorrarId) : null;

	// Limpia selección del input file
	input.value = '';

	// Si había imagen original en edición, vuelve a mostrarla
	if (preview.hasAttribute('data-original-src') && preview.getAttribute('data-original-src') !== '') {
		preview.src = preview.getAttribute('data-original-src');
		preview.style.display = 'block';

		// Desmarca checkbox borrar si estaba marcado
		if (checkboxBorrar) {
			checkboxBorrar.checked = false;
		}
	} else {
		// No hay imagen original, oculta preview y botón
		preview.src = '';
		preview.style.display = 'none';
	}

	if (btnCancelar) btnCancelar.style.display = 'none';
}
</script>
<?= $this->endSection() ?>