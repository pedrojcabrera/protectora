<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<style>
		.logo,
		h2 {
			text-align: center;
			margin-bottom: 1em;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #f2f2f2;
		}
		</style>
	</head>

	<body>

		<div class="logo">
			<img src="<?=base_url('images/logoGatos150.png')?>" style="height: 120px;">
		</div>

		<h2>Informe listado alfabético de Animales</h2>
		<table>
			<thead>
				<tr>
					<th>Datos</th>
					<th>Caracerísticas</th>
					<th>Foto Carnet</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($animales as $animal): ?>
				<tr>
					<td>
						<strong><?= $animal->nombre_colonia ?></strong><br>
						<?= $animal->nombre_responsable ?><br>
						...<br>
						<?=$animal->nombre_especie.' '.$animal->nombre_raza?><br>
						<?=$animal->genero?><br>
						Tamaño/peso: <?=$animal->peso.'/'.$pesos[$animal->peso]?><br>
						Fecha Nacimiento : <?=date('d/m/Y', strtotime($animal->fecha_nacimiento))?><br>
						<span><i>* La fecha puede ser aproximada</i></span>
					</td>
					<td>
						<i>Se entregaría: </i><?= implode(', ', explode(',', $animal->se_entrega)); ?><br>
						<i>Compatible con: </i><?= implode(', ', explode(',', $animal->compatible_con)); ?><br>
						<i>Personalidad: </i><?= implode(', ', explode(',', $animal->personalidad)); ?><br>
						<i>Estado Actual: </i><?= implode(', ', explode(',', $animal->estado)); ?><br>
						<i>Puede viajar: </i><?=$animal->puede_viajar ? 'Sí' : 'No' ?><br>
						<i>Vía de adopción:
						</i><?=$animal->via_de_adopcion ? $animal->via_de_adopcion : 'No adoptado' ?>
					</td>
					<td>
						<?php if($animal->foto): ?>
						<img src="<?=base_url($animal->foto)?>" style="max-width: 150px; border-radius: 10px;" alt="">
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>