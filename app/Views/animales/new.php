<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Agregar Animal</h1>

<div class="card">
	<div class="card-body text-center">
		<?php if (session('validation')): ?>
		<div class="alert alert-danger validation-errors">
			<h3>Atención</h3>
			<?= session('validation')->listErrors() ?>
		</div>
		<?php endif; ?>

		<form class="text-start" action="<?= base_url('animales/store') ?>" method="post" enctype="multipart/form-data">
			<?= csrf_field() ?>

			<div class="row mb-3">
				<!-- Input de nombre -->
				<div class="col-4">
					<label for="nombre"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
					<input type="text" class="form-control" name="nombre" id="nombre" value="<?= old('nombre') ?>"
						required autofocus>
				</div>
				<!-- Select de colonias -->
				<div class="col-6">
					<label for="colonia"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Colonia</small></label>
					<select id="colonia" name="colonia" class="form-select" required>
						<option value="">Selecciona una colonia</option>
						<?php foreach ($colonias as $colonia): ?>
						<option value="<?= esc($colonia->id) ?>">
							<?= esc($colonia->nombre).' - '.$colonia->responsable_nombre ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- Select de género -->
				<div class="col-2">
					<label for="genero" class="form-label fs-6 fw-mute fw-light fst-italic">
						<small>Género</small>
					</label>
					<select id="genero" name="genero" class="form-select" required>
						<option value="" disabled selected>Género</option>
						<option value="Hembra"
							<?= old('genero', $animal->genero ?? '') === 'Hembra' ? 'selected' : '' ?>>Hembra</option>
						<option value="Macho"
							<?= old('genero', $animal->genero ?? '') === 'Macho'  ? 'selected' : '' ?>>Macho</option>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<!-- Select de especies -->
				<div class="col-3">
					<label for="especie_id"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Especie</small></label>
					<select id="especie_id" name="especie_id" class="form-select" required>
						<option value="">Selecc. una especie</option>
						<?php foreach ($especies as $especie): ?>
						<option value="<?= esc($especie->id) ?>"><?= esc($especie->especie) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- Select de razas -->
				<div class="col-6">
					<label for="raza_id" class="form-label fs-6 fw-mute fw-light fst-italic"><small>Raza</small></label>
					<select id="raza_id" name="raza_id" class="form-select" required>
						<option value="">Selecciona una raza</option>
						<!-- Se llenará dinámicamente -->
					</select>
				</div>
				<!-- Select de peso -->
				<div class="col-3">
					<label for="peso" class="form-label fs-6 fw-mute fw-light fst-italic"><small>Peso</small></label>
					<select id="peso" name="peso" class="form-select" required>
						<option value="" disabled selected>Peso</option>

						<?php foreach($pesos as $key => $value): ?>
						<option value=<?= $key ?> <?= old('peso') ?>><?= $value ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<!-- Select de provincias -->
				<div class="col-3">
					<label for="provincia"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Provincia</small></label>
					<select id="provincia" name="provincia" class="form-select" required>
						<option value="">Seleccione una provincia</option>
						<?php foreach ($provincias as $provincia): ?>
						<option value="<?= esc($provincia->id) ?>"><?= esc($provincia->provincia) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- Select de poblaciones -->
				<div class="col-6">
					<label for="poblacion"
						class="form-label fs-6 fw-mute fw-light fst-italic"><small>Población</small></label>
					<select id="poblacion" name="poblacion" class="form-select" required>
						<option value="">Selecciona una población</option>
						<!-- Se llenará dinámicamente -->
					</select>
				</div>
				<!-- Fecha de Nacimiento -->
				<div class="col-3">
					<label for="fecha_nacimiento" class="form-label fs-6 fw-mute fw-light fst-italic"><small>Fecha de
							nacimiento</small></label>
					<input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
						value="<?=old('fecha_nacimiento')?>" class="form-select" required>
				</div>
			</div>
			<div class="d-grid" style="grid-template-columns: 2fr 1fr; gap: 1rem;">
				<!-- Columna izquierda -->
				<div class="p-3 bg-light border">
					<!-- Se entrega -->
					<?php
					$opciones = ['Desparasitado', 'Sano', 'Esterilizado', 'Identificado', 'Microchip', 'Pasaporte'];
					$entregas_old = old('se_entrega[]') ?? explode(',', $animal->se_entrega ?? '');
					?>
					<div>
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
					</div>
					<hr>
					<!-- Compatible con -->
					<?php
					$opciones = ['Niños', 'Perros', 'Gatos', 'Otros animales', 'Personas mayores', 'Familias'];
					$compatible_old = old('compatible_con[]') ?? explode(',', $animal->compatible_con ?? '');
					?>
					<div>
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
					</div>
					<hr>
					<!-- Personalidad -->
					<?php
					$opciones = ['Cariñoso', 'Necesita Cuidados', 'Hiperactivo', 'Miedoso', 'Tranquilo', 'Sociable', 'Sedentario'];
					$personalidad_old = old('personalidad[]') ?? explode(',', $animal->personalidad ?? '');
					?>
					<div>
						<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Personalidad</label>
						<div class="row px-5 pb-1">
							<?php foreach ($opciones as $opcion): ?>
							<div class="form-check col-6 col-md-4 text-start">
								<input class="form-check-input" type="checkbox" name="personalidad[]"
									value="<?= esc($opcion) ?>" id="<?= esc($opcion) ?>"
									<?= in_array($opcion, $personalidad_old) ? 'checked' : '' ?>>
								<label class="form-check-label" for="<?= esc($opcion) ?>">
									<small><?= esc($opcion) ?></small>
								</label>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<hr>
					<!-- Estado -->
					<?php
					$opciones = ['Para adoptar', 'En acogida', 'Adoptado', 'Inactivo', 'Fallecido', 'Callejero'];
					$estado_old = old('estado[]') ?? explode(',', $animal->estado ?? '');
					?>
					<div class="col-12 mb-3">
						<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Estado</label>
						<div class="row px-5 pb-1">
							<?php foreach ($opciones as $opcion): ?>
							<div class="form-check col-6 col-md-4 text-start">
								<input class="form-check-input" type="checkbox" name="estado[]"
									value="<?= esc($opcion) ?>" id="<?= esc($opcion) ?>"
									<?= in_array($opcion, $estado_old) ? 'checked' : '' ?>>
								<label class="form-check-label" for="<?= esc($opcion) ?>">
									<small><?= esc($opcion) ?></small>
								</label>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<!-- Columna derecha -->
				<div class="p-3 bg-light border">
					<!-- Fotografía -->
					<div class="p-3 text-center">
						<div>
							<h5>Fotografía</h5>
							<div class="mb-3">
								<label for="fotoCarnet" class="form-label">Selecciona su foto carné</label>
								<input class="form-control" type="file" name='fotoCarnet' id="fotoCarnet"
									accept="image/*">
							</div>
							<div class="mb-3">
								<label id="label-preview" for="preview"
									class="form-label pt-1 fs-6 fw-mute fw-light fst-italic d-none">Nueva
									Fotografía</label>
								<img id="preview" src="#" alt="Previsualización" class="img-fluid img-thumbnail d-none"
									style="max-height: 250px;">
								<button type="button" id="btn-cancelar-foto"
									class="btn btn-sm btn-danger mt-2 d-none">Cancelar
									selección</button>
							</div>
						</div>
					</div>
					<hr>
					<!-- Marca si puede viajar -->
					<div class="text-center">
						<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic text-center">Puede desplazarse
							para adopción</label>
						<div class="d-flex justify-content-center">
							<div class="form-check text-start">
								<input class="form-check-input" type="checkbox" name="puede_viajar" id="puede_viajar"
									value="1">
								<label class="form-check-label" for="puede_viajar">
									Puede viajar
								</label>
							</div>
						</div>
					</div>
					<hr>
					<!-- Vía adopción -->
					<div class="text-center">
						<?php
						$opciones = ['Kiwoko', 'Tienda Animal', 'Asociación', 'Otros'];
						$via_de_adopcion = old('via_de_adopcion') ?? ''; // Valor previamente enviado, si lo hay
						$via_de_adopcion = trim($via_de_adopcion);
						?>
						<label class="form-label pt-1 fs-6 fw-mute fw-light fst-italic">Vía de Adopción</label>
						<div class="d-flex justify-content-center">
							<div>
								<div id="grupo-via-adopcion">
									<?php foreach ($opciones as $opcion): ?>
									<div class="form-check text-start">
										<input class="form-check-input" type="radio" name="via_de_adopcion"
											value="<?= esc($opcion) ?>" id="via_<?= esc($opcion) ?>"
											<?= $opcion === $via_de_adopcion ? 'checked' : '' ?>>
										<label class="form-check-label" for="via_<?= esc($opcion) ?>">
											<small><?= esc($opcion) ?></small>
										</label>
									</div>
									<?php endforeach; ?>
								</div>

								<!-- Botón para limpiar -->
								<div class="mt-2">
									<button type="button" class="btn btn-sm btn-danger" onclick="limpiarViaAdopcion()">
										Limpiar selección
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-grid" style="grid-template-columns: 1fr; gap: 1rem;">
				<div class="row">
					<div class="col-12 mb-3">
						<label for="observaciones"
							class="form-label fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
						<textarea class="form-control" id="observaciones" name="observaciones"
							rows="3"><?= old('observaciones') ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-3">
						<label for="descripcion_corta"
							class="form-label fs-6 fw-mute fw-light fst-italic"><small>Descripción
								corta</small></label>
						<textarea class="form-control" id="descripcion_corta" name="descripcion_corta"
							rows="3"><?= old('descripcion_corta') ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-3">
						<label for="descripcion_larga"
							class="form-label fs-6 fw-mute fw-light fst-italic"><small>Descripción
								larga</small></label>
						<textarea class="form-control" id="descripcion_larga" name="descripcion_larga"
							rows="3"><?= old('descripcion_larga') ?></textarea>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-sm btn-success bi-floppy"> Guardar</button>
			<a href="<?= base_url('animales') ?>" class="btn btn-sm btn-info bi-box-arrow-left">
				Volver</a>
		</form>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scriptsAnexos') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
	$('#provincia').on('change', function() {
		let provincia_id = $(this).val();
		const baseUrlPoblaciones = "<?= base_url('poblaciones/porProvincia') ?>";
		if (provincia_id) {
			$.ajax({
				url: baseUrlPoblaciones + '/' + provincia_id,
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					let $poblacion = $('#poblacion');
					$poblacion.empty();
					$poblacion.append('<option value="">Selecciona una poblacion</option>');
					$.each(data, function(i, poblacion) {
						$poblacion.append('<option value="' + poblacion.id + '">' +
							poblacion.poblacion +
							'</option>');
					});
					console.log($poblacion);
				},
				error: function() {
					alert('Error al obtener las poblaciónes');
				}
			});
		} else {
			$('#poblacion').empty().append(
				'<option value="" disabled selected>Selecciona una población</option>');
		}
	});

	$('#especie_id').on('change', function() {
		let especie_id = $(this).val();
		const baseUrlRazas = "<?= base_url('razas/porEspecie') ?>"; // solo si estás en la vista

		console.log("Especie seleccionada:", especie_id);

		if (especie_id) {
			$.ajax({
				url: baseUrlRazas + '/' + especie_id,
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					console.log("Datos recibidos:", data);
					let $raza = $('#raza_id');
					$raza.empty();
					$raza.append('<option value="">Selecciona una raza</option>');
					$.each(data, function(i, raza) {
						$raza.append('<option value="' + raza.id + '">' + raza
							.raza + '</option>');
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