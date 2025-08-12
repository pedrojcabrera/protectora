<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Información sobre <?=$animal->nombre?></h1>

<div class="d-grid gap-2" style="grid-template-columns: 3fr 2fr;">
	<!-- Columna izquierda -->
	<div class="d-flex flex-column gap-2">
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Colonia:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<strong>
					<?= esc($animal->nombre_colonia) ?>
				</strong>
				<br>
				<?= esc($animal->nombre_responsable) ?>
				<br>
				<?= esc($poblacion->poblacion) ?>
				<br>
				<?= esc($provincia->provincia) ?>

			</div>
		</div>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Características:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= esc($animal->nombre_especie).' '.esc($animal->nombre_raza).'<br>'
				    .esc($animal->genero).'<br>'
					.'Tamaño/peso: '.$animal->peso.'/'.esc($pesos[$animal->peso]).'<br>'
					.'Fecha Nacimiento : '.date('d/m/Y', strtotime($animal->fecha_nacimiento))
					.'<br><span class="fs-6 fw-mute fw-light fst-italic"><small>* La fecha puede ser aproximada</small></span>'
					?>
			</div>
		</div>
		<?php if($animal->se_entrega): ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Se entregaría:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= implode(', ', explode(',', $animal->se_entrega)); ?>
			</div>
		</div>
		<?php endif ?>
		<?php if($animal->compatible_con): ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Puede convivir con:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= implode(', ', explode(',', $animal->compatible_con)); ?>
			</div>
		</div>
		<?php endif ?>
		<?php if($animal->personalidad): ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Personalidad:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= implode(', ', explode(',', $animal->personalidad)); ?>
			</div>
		</div>
		<?php endif ?>
	</div>
	<!-- Columna derecha -->
	<div class="d-flex flex-column gap-3">
		<?php if(base_url($animal->foto)): ?>
		<div>
			<div class="foto">
				<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Foto:</small></p>
				<img src="<?=base_url($animal->foto)?>" class="img-thumbnail rounded shadow-lg" alt=""
					style="max-width: 600px; max-height: 600px;">
			</div>
		</div>
		<?php endif ?>
		<?php if($animal->estado): ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Estado actual:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?= implode(', ', explode(',', $animal->estado)); ?>
			</div>
		</div>
		<?php endif ?>
		<?php if($animal->puede_viajar): ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Entrega con desplazamiento:</small>
			</p>
			<div class="form-control px-2 py-3 m-0">
				<?=$animal->nombre?> podría viajar hasta su adoptante.
			</div>
		</div>
		<?php endif ?>
		<?php if($animal->via_de_adopcion): ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Vía de adopción:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<?=$animal->via_de_adopcion?>
			</div>
		</div>
		<?php endif ?>
		<div>
			<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Datos de registro:</small></p>
			<div class="form-control px-2 py-3 m-0">
				<small>
					Informe realizado el <?=date('d/m/Y - i:s')?>h.
					<br>
					<?php
					$fecha = esc($animal->created_at);
					$strtotimefecha = strtotime($fecha);
					echo 'Creado el '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($animal->created_by);
					?>
					<br>
					<?php
					$fecha = esc($animal->updated_at);
					$strtotimefecha = strtotime($fecha);
					echo 'Último cambio el '.date('d/m/Y', $strtotimefecha). ' a las '. date('H:i:s', $strtotimefecha) . ' por ' . esc($animal->updated_by);				
					?>
				</small>
			</div>
		</div>

	</div>
</div>
<div class="d-grid gap-2" style="grid-template-columns: 1fr;">
	<div class="d-flex flex-column gap-3">
		<?php if(base_url($animal->observaciones)): ?>
		<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Observaciones:</small></p>
		<div class="form-control px-2 py-3 m-0">
			<?=nl2br($animal->observaciones)?>
		</div>
		<?php endif ?>
	</div>
</div>
<div class="d-grid gap-2" style="grid-template-columns: 2fr 3fr;">
	<!-- Columna izquierda -->
	<div class="d-flex flex-column gap-3">
		<?php if(base_url($animal->descripcion_corta)): ?>
		<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Descripción Corta:</small></p>
		<div class="form-control px-2 py-3 m-0">
			<?=$animal->descripcion_corta?>
		</div>
		<?php endif ?>
	</div>
	<!-- Columna derecha -->
	<div class="d-flex flex-column gap-3">
		<?php if(base_url($animal->descripcion_larga)): ?>
		<p class="fs-6 text-black fw-mute fw-light fst-italic m-0 mt-1"><small>Descripción Larga:</small></p>
		<div class="form-control px-2 py-3 m-0">
			<?=nl2br($animal->descripcion_larga)?>
		</div>
		<?php endif ?>
	</div>
</div>

<a href="<?= site_url('animales') ?>" class="mt-3 btn btn-sm btn-info bi-person-lines-fill"> Volver al
	listado</a>
<?= $this->endSection() ?>