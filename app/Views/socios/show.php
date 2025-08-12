<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información del socio <?= esc($socio->nombre) ?></h1>

<div class="fs-5 fw-mute fw-light fst-italic">Datos de Localización</div>
<div class="card px-2 py-1">
	<div class="d-grid mb-3" style="grid-template-columns: 2fr 2fr 1fr; gap: 1ch;">
		<div>
			<label for="nombre" class="fs-6 fw-mute fw-light fst-italic"><small>Nombre</small></label>
			<p class="form-control">
				<?= !empty($socio->nombre) ? $socio->nombre : '' ?>
			</p>

		</div>
		<div>
			<label for="email" class="fs-6 fw-mute fw-light fst-italic"><small>Correo</small>
				electrónico</label>
			<p class="form-control">
				<?= !empty($socio->email) ? $socio->email : 'No definido' ?>
			</p>
		</div>
		<div>
			<label for="telefono" class="fs-6 fw-mute fw-light fst-italic"><small>Teléfono</small></label>
			<p class="form-control">
				<?= !empty($socio->telefono) ? $socio->telefono : 'No definido' ?>
			</p>
		</div>
	</div>
	<div class="d-grid mb-3" style="grid-template-columns: 1fr; gap: 1ch;">
		<div>
			<label for="observaciones" class="fs-6 fw-mute fw-light fst-italic"><small>Observaciones</small></label>
			<p class="form-control">
				<?= !empty($socio->observaciones) ? nl2br(esc($socio->observaciones)) : 'No hay observaciones' ?>
			</p>
		</div>
		<div>
			<label for="direccion" class="fs-6 fw-mute fw-light fst-italic"><small>Dirección</small></label>
			<p class="form-control">
				<?= !empty($socio->direccion) ? nl2br(esc($socio->direccion)) : 'No definido' ?>
			</p>
		</div>
	</div>
	<div class="d-grid mb-3" style="grid-template-columns: 1fr 2fr 2fr; gap: 1ch;">
		<div>
			<label for="codpostal" class="fs-6 fw-mute fw-light fst-italic"><small>Código Postal</small></label>
			<p class="form-control">
				<?= !empty($socio->codpostal) ? $socio->codpostal : 'No definido' ?>
			</p>
		</div>

		<div>
			<label for="poblacion" class="fs-6 fw-mute fw-light fst-italic"><small>Población</small></label>
			<p class="form-control">
				<?= !empty($socio->poblacion) ? $socio->poblacion : 'No definido' ?>
			</p>
		</div>

		<div>
			<label for="provincia" class="fs-6 fw-mute fw-light fst-italic"><small>Provincia</small></label>
			<p class="form-control">
				<?= !empty($socio->provincia) ? $socio->provincia : 'No definido' ?>
			</p>
		</div>
	</div>

	<div class="d-grid mb-3" style="grid-template-columns: 1fr 2fr 2fr; gap: 1ch;">
		<div>
			<label for="tipo_documentoId" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo de
					documento</small></label>
			<p class="form-control">
				<?= !empty($socio->tipo_documentoId) ? $socio->tipo_documentoId : 'No definido' ?>
			</p>
		</div>
		<div>
			<label class="fs-6 fw-mute fw-light fst-italic"><small>Documento</small></label>
			<p class="form-control">
				<?= !empty($socio->documentoId) ? $socio->documentoId : 'No definido' ?>
			</p>
		</div>
		<div>
			<label for="fecha_nacimiento" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha de
					nacimiento</small></label>
			<p class="form-control">
				<?= !empty($socio->fecha_nacimiento) ? date('d-m-Y', strtotime($socio->fecha_nacimiento)) : 'No definido' ?>
			</p>
		</div>
	</div>
	<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr; gap: 1ch;">
		<div class="text-center">
			<label for="foto_dni_anverso" class="fs-6 fw-mute fw-light fst-italic">
				<small>Foto DNI (anverso)</small>
			</label>

			<div class="mt-2 d-flex justify-content-center">
				<img id="preview_anverso"
					src="<?= isset($socio) && !empty($socio->foto_dni_anverso) ? base_url($socio->foto_dni_anverso) : '' ?>"
					alt="Visualización Anverso"
					style="max-width: 200px; max-height: 150px; <?= empty($socio->foto_dni_anverso) ? 'display:none;' : '' ?>">
			</div>
		</div>

		<div class="text-center">
			<label for="foto_dni_reverso" class="fs-6 fw-mute fw-light fst-italic">
				<small>Foto DNI (reverso)</small>
			</label>

			<div class="mt-2 d-flex justify-content-center">
				<img id="preview_reverso"
					src="<?= isset($socio) && !empty($socio->foto_dni_reverso) ? base_url($socio->foto_dni_reverso) : '' ?>"
					alt="Visualización Reverso"
					style="max-width: 200px; max-height: 150px; <?= empty($socio->foto_dni_reverso) ? 'display:none;' : '' ?>">
			</div>
		</div>

		<div>
			<label for="tipo" class="fs-6 fw-mute fw-light fst-italic"><small>Tipo de socio</small></label>
			<p class="form-control">
				<?= !empty($socio->tipo) ? $tipos[$socio->tipo] : 'No definido' ?>
			</p>
		</div>
	</div>
</div>

<?php if(session('usuario_nivel') != "user"): ?>
<!-- Datos Bancarios -->

<div class="mt-3 fs-5 fw-mute fw-light fst-italic">Datos económicos y de gestión Bancaria</div>
<div class="card px-2 py-1">
	<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr; gap: 1ch;">
		<div>
			<label for="entidad_bancaria" class="fs-6 fw-mute fw-light fst-italic"><small>Entidad
					Bancaria</small></label>
			<p class="form-control">
				<?= !empty($socio->entidad_bancaria) ? $socio->entidad_bancaria : 'No definido' ?>
			</p>
		</div>

		<div>
			<label for="cuenta_bancaria" class="fs-6 fw-mute fw-light fst-italic"><small>Número de
					Cuenta Bancaria</small></label>
			<p class="form-control">
				<?= !empty($socio->cuenta_bancaria) ? $socio->cuenta_bancaria : 'No definido' ?>
			</p>
		</div>
	</div>
	<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr 1fr; gap: 1ch;">
		<div>
			<label for="cuota_anual" class="fs-6 fw-mute fw-light fst-italic"><small>Cuota anual</small></label>
			<p class="form-control">
				<?= !empty($socio->cuota_anual) ? $socio->cuota_anual : 0 ?>
			</p>
		</div>
		<div>
			<label for="complemento" class="fs-6 fw-mute fw-light fst-italic"><small>Complemento anual
					voluntario</small></label>
			<p class="form-control">
				<?= !empty($socio->complemento) ? $socio->complemento : 0 ?>
			</p>
		</div>
		<div>
			<label for="modalidad_pago" class="fs-6 fw-mute fw-light fst-italic"><small>Modalidad de
					pago</small></label>
			<p class="form-control">
				<?= !empty($socio->modalidad_pago) ? $modalidadPago[$socio->modalidad_pago] : 'No definido' ?>
			</p>
		</div>
	</div>
	<div class="d-grid mb-3" style="grid-template-columns: 1fr 1fr; gap: 1ch;">
		<div>
			<label for="ultimo_recibo_importe" class="fs-6 fw-mute fw-light fst-italic"><small>Último recibo
					(importe)</small></label>
			<p class="form-control">
				<?= !empty($socio->ultimo_recibo_importe) ? $socio->ultimo_recibo_importe : 0 ?>
			</p>
		</div>
		<div>
			<label for="ultimo_recibo_fecha" class="fs-6 fw-mute fw-light fst-italic"><small>Fecha de
					último recibo</small></label>
			<p class="form-control">
				<?= !empty($socio->ultimo_recibo_fecha) ? date('d-m-Y', strtotime($socio->ultimo_recibo_fecha)) : 'Ningún recibo emitido' ?>
			</p>
		</div>

	</div>
</div>

<?php endif; ?>

<div class="mt-3">
	<a href="<?= site_url('socios') ?>" class="btn btn-sm btn-info bi-person-lines-fill"> Volver al
		listado</a>
</div>

<?= $this->endSection() ?>