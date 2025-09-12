<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Agregar Socio</h1>

<div class="card-body text-center">

	<?php if (session('validation')): ?>
	<div class="alert alert-danger validation-errors">
		<h3>Atención</h3>
		<?= session('validation')->listErrors() ?>
	</div>
	<?php endif; ?>
</div>

<form class="text-start" action="<?= site_url('socios/store') ?>" method="post" enctype="multipart/form-data">
	<?= csrf_field() ?>
	<div class="fs-5 fw-mute fw-light fst-italic">Datos de Localización</div>
	<div class="card px-2 py-1">
		<div class="d-grid mb-3" style="grid-template-columns: 2fr 2fr 1fr; gap: 1ch;">
			<div>
				<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" required>
			</div>
			<div>
				<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Correo</small>
					electrónico</label>
				<input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>">
			</div>
			<div>
				<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
				<input type="text" name="telefono" id="telefono" class="form-control" value="<?= old('telefono') ?>">
			</div>
		</div>
		<div class="d-grid mb-3" style="grid-template-columns: 1fr; gap: 1ch;">
			<div>
				<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
				<textarea name="observaciones" id="observaciones"
					class="form-control"><?= old('observaciones') ?></textarea>
			</div>
			<div>
				<label for="direccion" class="fs-6 fw-mute fw-light fst-italic"><small>Dirección</small></label>
				<textarea name="direccion" id="direccion" class="form-control"><?= old('direccion') ?></textarea>
			</div>
		</div>
		<div class="d-grid mb-3" style="grid-template-columns: 1fr 2fr 2fr; gap: 1ch;">
			<div>
				<label for="codpostal" class="fs-6 fw-mute fw-light fst-italic"><small>Código Postal</small></label>
				<input type="text" name="codpostal" id="codpostal" class="form-control" value="<?= old('codpostal') ?>">
			</div>

			<div>
				<label for="poblacion" class="fs-6 fw-mute fw-light fst-italic"><small>Población</small></label>
				<input type="text" name="poblacion" id="poblacion" class="form-control" value="<?= old('poblacion') ?>">
			</div>

			<div>
				<label for="provincia" class="fs-6 fw-mute fw-light fst-italic"><small>Provincia</small></label>
				<input type="text" name="provincia" id="provincia" class="form-control" value="<?= old('provincia') ?>">
			</div>
		</div>

		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1ch;">
			<div>
				<label for="tipo_documentoId" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo de
						documento</small></label>
				<select name="tipo_documentoId" id="tipo_documentoId" class="form-select" style="font-size: .9rem;"
					required>
					<option value="">-- Selecciona --</option>
					<option value="DNI" <?= old('tipo_documentoId') === 'DNI' ? 'selected' : '' ?>>DNI</option>
					<option value="NIF" <?= old('tipo_documentoId') === 'NIF' ? 'selected' : '' ?>>NIF</option>
					<option value="NIE" <?= old('tipo_documentoId') === 'NIE' ? 'selected' : '' ?>>NIE</option>
				</select>
			</div>
			<div>
				<label for="documentoId" class="fs-6 fw-mute fw-light fst-italic"><small>Documento</small></label>
				<input type="text" name="documentoId" id="documentoId" class="form-control"
					value="<?= old('documentoId') ?>">
			</div>
			<div>
				<label for="fecha_nacimiento" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha de
						nacimiento</small></label>
				<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
					style="font-size: .9rem;" value="<?= old('fecha_nacimiento',) ?>">
			</div>
			<div>
				<label for="fecha_alta" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha de
						Alta</small></label>
				<input type="date" name="fecha_alta" id="fecha_alta" class="form-control" style="font-size: .9rem;"
					value="<?= old('fecha_alta') ?? date('Y-m-d') ?>">
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
					<img id="preview_anverso" src="" data-original-src="" alt="Previsualización Anverso"
						style="max-width: 200px; max-height: 150px; display:none;">
				</div>

				<button type="button" id="btn_cancelar_anverso" class="btn btn-sm btn-warning mt-1"
					style="display:none;"
					onclick="cancelarSeleccion('foto_dni_anverso', 'preview_anverso', 'btn_cancelar_anverso', null)">
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
					<img id="preview_reverso" src="" data-original-src="" alt="Previsualización Reverso"
						style="max-width: 200px; max-height: 150px; display:none;">
				</div>

				<button type="button" id="btn_cancelar_reverso" class="btn btn-sm btn-warning mt-1"
					style="display:none;"
					onclick="cancelarSeleccion('foto_dni_reverso', 'preview_reverso', 'btn_cancelar_reverso', null)">
					Cancelar selección
				</button>
			</div>

			<div>
				<label for="tipo" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo de socio</small></label>
				<select name="tipo" id="tipo" class="form-select" style="font-size: .9rem;">
					<?php foreach ($tipos as $tipo => $valor): ?>
					<option value="<?= $tipo ?>" <?= old('tipo') === $tipo ? 'selected' : '' ?>><?= $valor ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div>
				<label for="forma_de_pago" class="fs-6 fw-mute fw-light fst-italic"><small>Forma de Pago</small></label>
				<select name="forma_de_pago" id="forma_de_pago" class="form-select" style="font-size: .9rem;">
					<?php foreach ($formas as $forma => $valor): ?>
					<option value="<?= $forma ?>" <?= old('forma_de_pago') === $forma ? 'selected' : '' ?>><?= $valor ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	<div class="mt-3 fs-5 fw-mute fw-light fst-italic">Datos de gestión Bancaria</div>
	<div class="card px-2 py-1">
		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr; gap: 1ch;">
			<div>
				<label for="entidad_bancaria" class="fs-6 fw-mute fw-light fst-italic"><small>Entidad
						Bancaria</small></label>
				<input type="text" name="entidad_bancaria" id="entidad_bancaria" class="form-control"
					value="<?= old('entidad_bancaria') ?>">
			</div>

			<div>
				<label for="cuenta_bancaria" class="fs-6 fw-mute fw-light fst-italic">
					<small>Número de Cuenta Bancaria</small>
				</label>
				<input type="text" name="cuenta_bancaria" id="cuenta_bancaria" class="form-control"
					pattern="[A-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" maxlength="29"
					placeholder="ES00 0000 0000 0000 0000 0000" value="<?= old('cuenta_bancaria') ?>">
			</div>
		</div>
		<!-- Nuevos campos SEPA -->
		<div class="d-grid mb-3" style="grid-template-columns: 2fr 1fr; gap: 1ch;">
			<div>
				<label for="mandato" class="fs-6 fw-mute fw-light fst-italic"><small>Mandato SEPA</small></label>
				<input type="text" name="mandato" id="mandato" class="form-control" value="<?= old('mandato') ?>"
					placeholder="Ej: MANDATO-<?= date('Y') ?>-##### (si no se rellena, se generará automáticamente)">
			</div>
			<div>
				<label for="fecha_mandato" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha Mandato</small></label>
				<input type="date" name="fecha_mandato" id="fecha_mandato" class="form-control"
					style="font-size: .9rem;" value="<?= old('fecha_mandato') ?? date('Y-m-d') ?>">
			</div>
		</div>
		<!-- Fin nuevos campos -->

		<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr; gap: 1ch;">
			<div>
				<label for="cuota_anual" class="fs-6 fw-mute fw-light fst-italic"><small>Cuota Anual</small></label>
				<input type="text" id="cuota_anual" class="form-control" readonly disabled
					value="<?= old('cuota_anual') ?>">
			</div>
			<div>
				<label for="complemento" class="fs-6 fw-mute fw-light fst-italic"><small>Complemento
						Voluntario</small></label>
				<input type="text" name="complemento" id="complemento" class="form-control"
					value="<?= old('complemento') ?>">
			</div>
			<div>
				<label for="modalidad_pago" class="fs-6 fw-mute fw-light fst-italic">
					<small>Modalidad de Pago</small>
				</label>
				<select name="modalidad_pago" id="modalidad_pago" class="form-select" style="font-size: .9rem;">
					<?php foreach ($modalidadPago as $key => $valor): ?>
					<option value="<?= $key ?>" <?= old('modalidad_pago') === $key ? 'selected' : '' ?>>
						<?= $valor ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>

		</div>
	</div>
	<div class="mt-3 botonera-fija">
		<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
		<a href="<?= site_url('socios') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Volver</a>
	</div>
</form>

<script>
document.getElementById('tipo').addEventListener('change', function() {
	let cuota = (this.value === 'socio') ? 30 : 0;
	document.getElementById('cuota_anual').value = cuota;
});
</script>


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
	const input = document.getElementById('cuenta_bancaria');

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