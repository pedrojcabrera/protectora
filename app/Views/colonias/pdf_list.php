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

		<h2>Informe listado alfabético de Colonias</h2>
		<table>
			<thead>
				<tr>
					<th>Nombre</th>
					<th>GPS</th>
					<th>Responsables</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($colonias as $colonia): ?>
				<tr>
					<td><?= esc($colonia->nombre) ?></td>
					<td><?= esc($colonia->gps) ?></td>
					<td>
						<?= esc($colonia->responsable_nombre) ?>
						<?php if ($colonia->adjunto_nombre): ?>
						<br>
						<?= esc($colonia->adjunto_nombre) ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>