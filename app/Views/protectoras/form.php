<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row mx-3 mt-3">
	<h2 class="mb-3">Datos de la Protectora</h2>

	<?php if (session()->getFlashdata('msg')): ?>
	<div class="alert alert-success">
		<?= session('msg') ?>
	</div>
	<?php endif; ?>

	<form action="<?= site_url('protectora/update') ?>" method="post" enctype="multipart/form-data" class="card p-2">
		<?= csrf_field() ?>
		<input type="hidden" name="id" value="<?= $protectora->id ?>">

		<div class="row mb-3">
			<div class="col-md-12">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Nombre</small></label>
				<input type="text" name="nombre" class="form-control" value="<?= esc($protectora->nombre) ?>">
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-md-6">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Nombre Corto</small></label>
				<input type="text" name="nombre_corto" class="form-control"
					value="<?= esc($protectora->nombre_corto) ?>">
			</div>
			<div class="col-md-6">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>NIF</small></label>
				<input type="text" name="nif" class="form-control" value="<?= esc($protectora->nif) ?>">
			</div>
		</div>

		<div class="mb-3">
			<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Dirección</small></label>
			<textarea name="dirección" class="form-control" rows="2"><?= esc($protectora->dirección) ?></textarea>
		</div>

		<div class="row mb-3">
			<div class="col-md-3">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Código Postal</small></label>
				<input type="text" name="codpostal" class="form-control" value="<?= esc($protectora->codpostal) ?>">
			</div>
			<div class="col-md-5">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Población</small></label>
				<input type="text" name="poblacion" class="form-control" value="<?= esc($protectora->poblacion) ?>">
			</div>
			<div class="col-md-4">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Provincia</small></label>
				<input type="text" name="provincia" class="form-control" value="<?= esc($protectora->provincia) ?>">
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-md-4">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Teléfono</small></label>
				<input type="text" name="telefono" class="form-control" value="<?= esc($protectora->telefono) ?>">
			</div>
			<div class="col-md-8">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Email</small></label>
				<input type="email" name="email" class="form-control" value="<?= esc($protectora->email) ?>">
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-md-3">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1">
					<small>Cuota Anual</small>
				</label>
				<input type="number" name="cuota_anual" id="cuota_anual" class="form-control text-end px-2"
					value="<?= esc($protectora->cuota_anual) ?>" step="1" min="0">
			</div>
			<div class="col-md-3">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Día del mes a
						Remesar</small></label>
				<input type="number" name="dia_remesa" class="form-control text-end"
					value="<?= esc($protectora->dia_remesa) ?>" step="1" min="1" max="28">
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-md-5">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Entidad
						Bancaria</small></label>
				<input type="text" name="banco" class="form-control" value="<?= esc($protectora->banco) ?>">
			</div>
			<div class="col-md-3">
				<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Swifth / BIC</small></label>
				<input type="text" name="swifth_bic" class="form-control" value="<?= esc($protectora->swifth_bic) ?>">
				<div class="form-label fs-6 fw-light fst-italic"><small>Solo para gestión internacional</small></div>

			</div>
			<div class="col-md-4">
				<label for="iban" class="form-label fs-6 fw-light m-0 mt-1 fst-italic">
					<small>Número de Cuenta Bancaria</small>
				</label>
				<input type="text" name="iban" id="iban" class="form-control"
					pattern="[A-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" maxlength="29"
					placeholder="ES00 0000 0000 0000 0000 0000" value="<?= old('iban', $protectora->iban ?? '') ?>">
				<div class="form-label fs-6 fw-light fst-italic"><small>Introduce el IBAN en formato español
						(ES00...)</small></div>
			</div>
		</div>
		<!-- logo -->
		<div class="mb-3 mx-auto text-center">
			<label class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Logo</small></label>

			<div class="mb-2">
				<?php if ($protectora->logo): ?>
				<img id="previewLogo" src="<?= base_url('imagenes/protectora/' . $protectora->logo) ?>" alt="Logo"
					class="img-thumbnail" style="max-height: 120px;">
				<?php else: ?>
				<img id="previewLogo" src="<?= base_url('images/sinlogo.png') ?>" alt="Logo" class="img-thumbnail"
					style="max-height: 120px;">
				<?php endif; ?>
			</div>

			<input type="file" name="logo" id="logoInput" class="form-control" accept="image/*" />

			<!-- Botón para quitar logo antes de guardar -->
			<button type="button" class="btn btn-warning btn-sm mt-2" id="removeLogoBtn">Quitar logo</button>

			<!-- Campo hidden que indica al controlador si borrar el logo -->
			<input type="hidden" name="delete_logo" id="deleteLogo" value="0">
		</div>
		<div class="mt-3 botonera-fija">
			<button type="submit" class="btn btn-sm btn-success bi-hand-thumbs-up"> Guardar Cambios</button>
		</div>

	</form>
</div>

<script>
const logoInput = document.getElementById('logoInput');
const previewLogo = document.getElementById('previewLogo');
const removeBtn = document.getElementById('removeLogoBtn');
const deleteLogoInput = document.getElementById('deleteLogo');

// Previsualizar imagen al seleccionarla
logoInput.addEventListener('change', function(event) {
	const [file] = event.target.files;
	if (file) {
		previewLogo.src = URL.createObjectURL(file);
		deleteLogoInput.value = 0; // no borrar si seleccionamos archivo
	}
});

// Quitar imagen antes de guardar
removeBtn.addEventListener('click', function() {
	logoInput.value = ''; // limpiar input
	previewLogo.src = "<?= base_url('images/sinlogo.png') ?>"; // placeholder
	deleteLogoInput.value = 1; // marcar para borrar logo actual
});
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