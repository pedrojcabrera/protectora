<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Editar Animal</h1>

<div class="card">
	<form class="text-start" action="<?= site_url('animales/update') ?>" method="post" enctype="multipart/form-data">
		<?= csrf_field() ?>

		<div class="card-body text-center">

			<?php if (session('validation')): ?>
			<div class="alert alert-danger validation-errors">
				<h3>Atención</h3>
				<?= session('validation')->listErrors() ?>
			</div>
			<?php endif; ?>

			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id" value="<?= $animal->id ?>">

			<div class="row mb-3">
				<!-- Input de nombre -->
				<div class="col-4">
					<label for="nombre"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
					<input type="text" class="form-control" name="nombre" id="nombre"
						value="<?= old('nombre', $animal->nombre ?? '') ?>" required autofocus>
				</div>
				<!-- Select de colonias -->
				<div class="col-6">
					<label for="colonia"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Colonia</small></label>
					<select id="colonia" name="colonia" class="form-select" required>
						<option value="">Selecciona una colonia</option>
						<?php foreach ($colonias as $colonia): ?>
						<option value="<?= esc($colonia->id) ?>"
							<?= (old('colonia', $animal->colonia_id ?? '') == $colonia->id) ? 'selected' : '' ?>>
							<?= esc($colonia->nombre) . ' - ' . $colonia->responsable_nombre ?>
							<?php endforeach; ?>
					</select>
				</div>
				<!-- Select de género -->
				<div class="col-2">
					<label for="genero" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Género</small>
					</label>
					<select id="genero" name="genero" class="form-select" required>
						<option value="" disabled <?= old('genero', $animal->genero ?? '') === '' ? 'selected' : '' ?>>
							Género</option>
						<option value="Hembra"
							<?= old('genero', $animal->genero ?? '') === 'Hembra' ? 'selected' : '' ?>>Hembra</option>
						<option value="Macho" <?= old('genero', $animal->genero ?? '') === 'Macho' ? 'selected' : '' ?>>
							Macho</option>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<!-- Select de especies -->
				<div class="col-3">
					<label for="especie_id" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Especie</small>
					</label>
					<select id="especie_id" name="especie_id" class="form-select" required>
						<option value="">Selecc. una especie</option>
						<?php foreach ($especies as $especie): ?>
						<option value="<?= esc($especie->id) ?>"
							<?= (old('especie_id', $animal->especie_id ?? '') == $especie->id) ? 'selected' : '' ?>>
							<?= esc($especie->especie) ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- Select de razas -->
				<div class="col-6">
					<label for="raza_id" class="form-label fs-6 fw-mute fw-light fst-italic"><small>Raza</small></label>
					<select id="raza_id" name="raza_id" class="form-select" required>
						<option value="">Selecciona una raza</option>
						<?php if (old('raza_id', $animal->raza_id ?? false)): ?>
						<option value="<?= old('raza_id', $animal->raza_id) ?>" selected>
							<?= old('raza_nombre', $animal->raza_nombre ?? 'Raza actual') ?>
						</option>
						<?php endif; ?>
						<!-- Se llenará dinámicamente -->
					</select>
				</div>
				<!-- Select de peso -->
				<div class="col-3">
					<label for="peso" class="form-label fs-6 fw-mute fw-light fst-italic"><small>Peso</small></label>
					<select id="peso" name="peso" class="form-select" required>
						<option value="" disabled <?= old('peso', $animal->peso ?? '') === '' ? 'selected' : '' ?>>Peso
						</option>

						<?php foreach($pesos as $key => $value): ?>
						<option value="<?= esc($key) ?>"
							<?= old('peso', $animal->peso ?? '') == $key ? 'selected' : '' ?>>
							<?= esc($value) ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>

			</div>
			<div class="row mb-3">
				<!-- Select de provincias -->
				<div class="col-3">
					<label for="provincia" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Provincia</small>
					</label>
					<select id="provincia" name="provincia" class="form-select" required>
						<option value="">Seleccione una provincia</option>
						<?php foreach ($provincias as $provincia): ?>
						<option value="<?= esc($provincia->id) ?>"
							<?= old('provincia', $animal->provincia ?? '') == $provincia->id ? 'selected' : '' ?>>
							<?= esc($provincia->provincia) ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- Select de poblaciones -->
				<div class="col-6">
					<label for="poblacion" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Población</small>
					</label>
					<select id="poblacion" name="poblacion" class="form-select" required>
						<option value="">Selecciona una población</option>
						<?php if (old('poblacion', $animal->poblacion ?? false)): ?>
						<option value="<?= old('poblacion', $animal->poblacion) ?>" selected>
							<?= old('poblacion_nombre', $animal->poblacion_nombre ?? 'Población actual') ?>
						</option>
						<?php endif; ?>
					</select>
				</div>
				<!-- Fecha de Nacimiento -->
				<?php
				$fechaNacimiento = old('fecha_nacimiento') 
					?: (isset($animal->fecha_nacimiento) ? date('Y-m-d', strtotime($animal->fecha_nacimiento)) : '');
				?>
				<div class="col-3">
					<label for="fecha_nacimiento" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Fecha de nacimiento</small>
					</label>
					<input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
						value="<?= esc($fechaNacimiento) ?>" class="form-control" required>
				</div>
			</div>
			<div class="d-grid" style="grid-template-columns: 2fr 1fr; gap: 1rem;">
				<!-- Columna izquierda -->
				<div class="p-3 bg-light border">
					<!-- Se entrega -->
					<?php
					$opciones = ['Desparasitado', 'Sano', 'Esterilizado', 'Identificado', 'Microchip', 'Pasaporte'];
					$entregas_old = old('se_entrega[]') ?: (isset($animal->se_entrega) ? explode(',', $animal->se_entrega) : []);
					?>
					<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Se entrega</label>
					<div class="row px-5 pb-1">
						<?php foreach ($opciones as $opcion): ?>
						<div class="form-check col-6 col-md-4 text-start">
							<input class="form-check-input" type="checkbox" name="se_entrega[]"
								value="<?= esc($opcion) ?>" id="<?= esc($opcion) ?>"
								<?= in_array($opcion, $entregas_old) ? 'checked' : '' ?>>
							<label class="form-check-label fs-6" for="<?= esc($opcion) ?>">
								<small><?= esc($opcion) ?></small>
							</label>
						</div>
						<?php endforeach; ?>
					</div>
					<hr>
					<!-- Compatible con -->
					<?php
					$opciones = ['Niños', 'Perros', 'Gatos', 'Otros animales', 'Personas mayores', 'Familias'];
					$compatible_old = old('compatible_con[]') ?? explode(',', $animal->compatible_con ?? '');
					?>
					<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Compatible con</label>
					<div class="row px-5 pb-1">
						<?php foreach ($opciones as $opcion): ?>
						<div class="form-check col-6 col-md-4 text-start">
							<input class="form-check-input" type="checkbox" name="compatible_con[]"
								value="<?= esc($opcion) ?>" id="<?= esc($opcion) ?>"
								<?= in_array($opcion, $compatible_old) ? 'checked' : '' ?>>
							<label class="form-check-label fs-6" for="<?= esc($opcion) ?>">
								<small><?= esc($opcion) ?></small>
							</label>
						</div>
						<?php endforeach; ?>
					</div>
					<hr>
					<!--  Personalidad -->
					<?php
					$opciones = ['Cariñoso', 'Necesita Cuidados', 'Hiperactivo', 'Miedoso', 'Tranquilo', 'Sociable', 'Sedentario'];
					$personalidad_old = old('personalidad') ?? explode(',', $animal->personalidad ?? '');
					$personalidad_old = is_array($personalidad_old) ? $personalidad_old : [];
					?>
					<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Personalidad</label>
					<div class="row px-5 pb-1">
						<?php foreach ($opciones as $opcion): ?>
						<div class="form-check col-6 col-md-4 text-start">
							<input class="form-check-input" type="checkbox" name="personalidad[]"
								value="<?= esc($opcion) ?>" id="personalidad_<?= esc($opcion) ?>"
								<?= in_array($opcion, $personalidad_old) ? 'checked' : '' ?>>
							<label class="form-check-label" for="personalidad_<?= esc($opcion) ?>">
								<small><?= esc($opcion) ?></small>
							</label>
						</div>
						<?php endforeach; ?>
					</div>
					<hr>

					<!-- Estado -->
					<?php
					$opciones = ['Para adoptar', 'En acogida', 'Adoptado', 'Inactivo', 'Fallecido', 'Callejero'];
					$estado_old = old('estado') ?? explode(',', $animal->estado ?? '');
					$estado_old = is_array($estado_old) ? $estado_old : [];
					?>
					<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Estado</label>
					<div class="row px-5 pb-1">
						<?php foreach ($opciones as $opcion): ?>
						<div class="form-check col-6 col-md-4 text-start">
							<input class="form-check-input" type="checkbox" name="estado[]" value="<?= esc($opcion) ?>"
								id="estado_<?= esc($opcion) ?>" <?= in_array($opcion, $estado_old) ? 'checked' : '' ?>>
							<label class="form-check-label" for="estado_<?= esc($opcion) ?>">
								<small><?= esc($opcion) ?></small>
							</label>
						</div>
						<?php endforeach; ?>
					</div>

				</div>
				<!-- Columna derecha -->
				<div class="p-3 bg-light border">
					<!-- Fotografía -->
					<h5>Fotografía</h5>

					<div class="mb-3">
						<label for="fotoCarnet" class="form-label">Selecciona su foto carné</label>
						<input class="form-control" type="file" name="fotoCarnet" id="fotoCarnet" accept="image/*">
					</div>

					<?php if (!empty($animal->foto)) : ?>
					<div class="mb-3">
						<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Fotografía actual</label><br>
						<img src="<?= base_url(esc($animal->foto)) ?>" alt="Fotografía actual"
							class="img-fluid img-thumbnail" style="max-height: 250px;">
						<div class="d-flex justify-content-center">
							<div class="form-check mt-2">
								<input class="form-check-input" type="checkbox" name="quitar_foto" id="quitar_foto"
									value="1">
								<label class="form-check-label text-start" for="quitar_foto">
									Quitar foto actual
								</label>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="mb-3">
						<label id="label-preview" for="preview"
							class="form-label pt-1 fs-6 fw-mute fw-light fst-italic d-none">Nueva Fotografía</label>
						<img id="preview" src="#" alt="Previsualización" class="img-fluid img-thumbnail d-none"
							style="max-height: 250px;">
						<button type="button" id="btn-cancelar-foto" class="btn btn-sm btn-danger mt-2 d-none">Cancelar
							selección</button>
					</div>
					<hr>
					<!-- Puede viajar o no -->
					<?php
						$puede_viajar = old('puede_viajar') ?? ($animal->puede_viajar ?? 0);
						?>
					<div class="d-flex justify-content-center">
						<div class="form-check text-start mb-2">
							<input class="form-check-input" type="checkbox" name="puede_viajar" id="puede_viajar"
								value="1" <?= $puede_viajar ? 'checked' : '' ?>>
							<label class="form-check-label" for="puede_viajar">
								Puede viajar
							</label>
						</div>
					</div>
					<hr>
					<!-- Vía de adopción -->
					<?php
					$opciones = ['Kiwoko', 'Tienda Animal', 'Asociación', 'Otros'];
					$seleccionada = old('via_de_adopcion') ?? trim($animal->via_de_adopcion ?? '');
					?>
					<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Vía de Adopción</label>
					<div class="d-flex justify-content-center">
						<div>
							<?php foreach ($opciones as $opcion): 
							$id = strtolower(str_replace(' ', '_', $opcion)); ?>
							<div class="form-check text-start">
								<input class="form-check-input" type="radio" name="via_de_adopcion"
									value="<?= esc($opcion) ?>" id="via_<?= esc($id) ?>"
									<?= $opcion === $seleccionada ? 'checked' : '' ?>>
								<label class="form-check-label" for="via_<?= esc($id) ?>">
									<small><?= esc($opcion) ?></small>
								</label>
							</div>
							<?php endforeach; ?>

							<div class="mt-2">
								<button type="button" class="btn btn-sm btn-danger" onclick="limpiarViaAdopcion()">
									Limpiar selección
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Observaciones -->
			<div class="row col-12 mb-3">
				<label for="observaciones" class="form-label fs-6 fw-mute fw-light fst-italic">
					<small>Observaciones</small>
				</label>
				<textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?= old('observaciones') ?? esc($animal->observaciones ?? '') ?>
				</textarea>
			</div>

			<!-- Decripción corta -->
			<div class="row">
				<div class="col-12 mb-3">
					<label for="descripcion_corta" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Descripción corta</small>
					</label>
					<textarea class="form-control" id="descripcion_corta" name="descripcion_corta"
						rows="3"><?= old('descripcion_corta') ?? esc($animal->descripcion_corta ?? '') ?></textarea>
				</div>
			</div>
			<!-- Descripción larga -->
			<div class="row">
				<div class="col-12 mb-3">
					<label for="descripcion_larga" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Descripción larga</small>
					</label>
					<textarea class="form-control" id="descripcion_larga" name="descripcion_larga"
						rows="3"><?= old('descripcion_larga') ?? esc($animal->descripcion_larga ?? '') ?></textarea>
				</div>
			</div>
			<div class="mt-3 botonera-fija">
				<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
				<a href="<?= site_url('animales') ?>" class="btn btn-sm btn-info bi-box-arrow-left"> Volver</a>
			</div>
		</div>
	</form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAnexos') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
	$('#provincia').on('change', function() {
		let provincia_id = $(this).val();
		const baseUrlPoblaciones = "<?= base_url('poblaciones/porProvincia') ?>";
		const poblacionSeleccionada = "<?= old('poblacion', $animal->poblacion ?? '') ?>";

		if (provincia_id) {
			$.ajax({
				url: baseUrlPoblaciones + '/' + provincia_id,
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					let $poblacion = $('#poblacion');
					$poblacion.empty();
					$poblacion.append('<option value="">Selecciona una población</option>');
					$.each(data, function(i, poblacion) {
						let selected = (poblacion.id == poblacionSeleccionada) ?
							' selected' : '';
						$poblacion.append('<option value="' + poblacion.id + '"' +
							selected + '>' + poblacion.poblacion + '</option>');
					});
				},
				error: function() {
					alert('Error al obtener las poblaciones');
				}
			});
		} else {
			$('#poblacion').empty().append(
				'<option value="" disabled selected>Selecciona una población</option>');
		}
	});

	// Al cargar la página, disparar el cambio para cargar y seleccionar la población
	$(document).ready(function() {
		if ($('#provincia').val()) {
			$('#provincia').trigger('change');
		}
	});

	$('#especie_id').on('change', function() {
		let especie_id = $(this).val();
		const baseUrlRazas = "<?= base_url('razas/porEspecie') ?>";
		const razaSeleccionada = "<?= old('raza_id', $animal->raza_id ?? '') ?>";

		if (especie_id) {
			$.ajax({
				url: baseUrlRazas + '/' + especie_id,
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					let $raza = $('#raza_id');
					$raza.empty();
					$raza.append('<option value="">Selecciona una raza</option>');
					$.each(data, function(i, raza) {
						let selected = (raza.id == razaSeleccionada) ? ' selected' :
							'';
						$raza.append('<option value="' + raza.id + '"' + selected +
							'>' + raza.raza + '</option>');
					});
				},
				error: function() {
					alert('Error al obtener las razas');
				}
			});
		} else {
			$('#raza_id').empty().append(
				'<option value="" disabled selected>Selecciona una raza</option>'
			);
		}
	});

	// JS para previsualización

	document.getElementById("fotoCarnet").addEventListener("change", function(e) {
		const file = e.target.files[0];
		const preview = document.getElementById("preview");
		const label_preview = document.getElementById("label-preview");
		const btnCancelar = document.getElementById("btn-cancelar-foto");

		if (file && file.type.startsWith("image/")) {
			const reader = new FileReader();
			reader.onload = function(e) {
				preview.src = e.target.result;
				preview.classList.remove("d-none");
				label_preview.classList.remove("d-none");
				btnCancelar.classList.remove("d-none");
			};
			reader.readAsDataURL(file);
		} else {
			preview.src = "#";
			preview.classList.add("d-none");
			label_preview.classList.add("d-none");
			btnCancelar.classList.add("d-none");
		}
	});

	document.getElementById("btn-cancelar-foto").addEventListener("click", function() {
		const inputFile = document.getElementById("fotoCarnet");
		const preview = document.getElementById("preview");
		const label_preview = document.getElementById("label-preview");
		const btnCancelar = document.getElementById("btn-cancelar-foto");

		// Vaciar el input file (no es trivial, se reemplaza el input)
		inputFile.value = "";

		// Ocultar preview, label y botón
		preview.src = "#";
		preview.classList.add("d-none");
		label_preview.classList.add("d-none");
		btnCancelar.classList.add("d-none");
	});

});
</script>

<script>
function limpiarViaAdopcion() {
	// Buscar todos los radios con name="via_de_adopcion" y desmarcarlos
	const radios = document.querySelectorAll('input[name="via_de_adopcion"]');
	radios.forEach(radio => radio.checked = false);
}
</script>

<?= $this->endSection() ?>