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

		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1ch;">
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
			<div>
				<label for="fecha_alta" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha de
						Alta</small></label>
				<input type="date" name="fecha_alta" id="fecha_alta" class="form-control" style="font-size: .9rem;"
					value="<?= old('fecha_alta', $socio->fecha_alta ?? '') ?>">
			</div>
		</div>

		<div class="d-grid mb-3" style="grid-template-columns: 2fr 2fr 1fr 1fr; gap: 1ch;">
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

			<div>
				<label for="forma_de_pago" class="fs-6 fw-mute fw-light fst-italic"><small>Forma de
						pago</small></label>
				<?php $formaSel = old('forma_de_pago', $socio->forma_de_pago ?? ''); ?>
				<select name="forma_de_pago" id="forma_de_pago" class="form-select" style="font-size: .9rem;">
					<?php foreach ($formas as $forma => $valor): ?>
					<option value="<?= $forma ?>" <?= $formaSel === $forma ? 'selected' : '' ?>><?= $valor ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	<?php if(session('usuario_nivel') != "user"): ?>
	<!-- Datos Bancarios -->
	<div class="mt-3 fs-5 fw-mute fw-light fst-italic">Datos de gestión Bancaria</div>
	<div class="card px-2 py-1">
		<div class="d-grid mb-3" style="grid-template-columns: 2fr 2fr; gap: 1ch;">
			<div>
				<label for="entidad_bancaria" class="fs-6 fw-mute fw-light fst-italic"><small>Entidad
						Bancaria</small></label>
				<input type="text" name="entidad_bancaria" id="entidad_bancaria" class="form-control"
					value="<?= old('entidad_bancaria', $socio->entidad_bancaria ?? '') ?>">
			</div>
			<div>
				<label for="iban" class="fs-6 fw-mute fw-light fst-italic">
					<small>Número de Cuenta Bancaria</small>
				</label>
				<input type="text" name="iban" id="iban" class="form-control"
					pattern="[A-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" maxlength="29"
					placeholder="ES00 0000 0000 0000 0000 0000" value="<?= old('iban', $socio->iban ?? '') ?>" required>
				<div class="fs-6 fw-mute fw-light fst-italic"><small>Introduce el IBAN en formato español
						(ES00...)</small></div>
			</div>
		</div>
		<!-- Nuevos campos SEPA -->
		<div class="d-grid mb-3" style="grid-template-columns: 2fr 1fr; gap: 1ch;">
			<div>
				<label for="mandato" class="fs-6 fw-mute fw-light fst-italic"><small>Mandato SEPA</small></label>
				<input type="text" name="mandato" id="mandato" class="form-control"
					value="<?= old('mandato', $socio->mandato ?? '') ?>"
					placeholder="Ej: MANDATO-<?= date('Y') ?>-#####">
			</div>
			<div>
				<label for="fecha_mandato" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha Mandato</small></label>
				<input type="date" name="fecha_mandato" id="fecha_mandato" class="form-control"
					style="font-size: .9rem;"
					value="<?= old('fecha_mandato', $socio->fecha_mandato ?? date('Y-m-d')) ?>">
			</div>
		</div>
		<!-- Fin nuevos campos -->
		<div class="d-grid mb-3" style="grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1ch;">
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
					value="<?= $ultimoRecibo->fecha ?? '' ?>">
			</div>
			<div>
				<label for="ultimo_recibo_importe" class="fs-6 fw-mute fw-light fst-italic"><small>Último Recibo
						Importe</small></label>
				<input type="text" disabled name="ultimo_recibo_importe" id="ultimo_recibo_importe" class="form-control"
					value="<?= $ultimoRecibo->importe ?? '' ?>">
			</div>
		</div>

	</div>
	<?php endif; ?>

	<div class="mt-3 botonera-fija">
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
<script>
(function() {
	const input = document.getElementById('iban');

	function formatIBAN(value) {
		// Mayúsculas y solo A-Z/0-9
		let raw = value.toUpperCase().replace(/[^A-Z0-9]/g, '');
		// Solo dígitos a partir del 5º carácter (después de ES00)
		raw = raw.slice(0, 4) + raw.slice(4).replace(/\D/g, '');
		// Espacio cada 4 caracteres (ES00 0000 0000 0000 0000 0000)
		const groups = raw.match(/.{1,4}/g) || [];
		return groups.join(' ');
	}

	// Mantener la posición del cursor al re-formatear
	function setCaretByNonSpaces(el, nonSpaceCount) {
		const v = el.value;
		let count = 0,
			pos = v.length;
		for (let i = 0; i < v.length; i++) {
			if (v[i] !== ' ') {
				count++;
				if (count === nonSpaceCount) {
					pos = i + 1;
					break;
				}
			}
		}
		el.setSelectionRange(pos, pos);
	}

	function onInput(e) {
		const el = e.target;
		const oldVal = el.value;
		const caretNonSpaces = oldVal.slice(0, el.selectionStart).replace(/ /g, '').length;

		el.value = formatIBAN(oldVal);
		setCaretByNonSpaces(el, caretNonSpaces);
	}

	function onPaste(e) {
		e.preventDefault();
		const text = (e.clipboardData || window.clipboardData).getData('text');
		const start = input.selectionStart;
		const end = input.selectionEnd;
		const before = input.value.slice(0, start);
		const after = input.value.slice(end);
		const merged = before + text + after;
		input.value = formatIBAN(merged);
		// Colocar el cursor tras lo pegado (contando sin espacios)
		const nonSpaces = (before + text).replace(/[^A-Z0-9]/g, '').length;
		setCaretByNonSpaces(input, nonSpaces);
	}

	input.addEventListener('input', onInput);
	input.addEventListener('paste', onPaste);
})();
</script>
<?= $this->endSection() ?>