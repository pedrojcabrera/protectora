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

		<h2>Informe listado alfabético de Jaulas y Accesorios</h2>
		<table>
			<thead>
				<tr>
					<th>Etiqueta</th>
					<th>Estado</th>
					<th>Ubicación</th>
					<th>Observaciones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($jaulas as $jaula): ?>
				<tr>
					<td><?= esc($jaula->etiqueta) ?></td>
					<td><?= $jaula->estado ? 'Util' : 'No útil' ?></td>
					<td><?= esc($jaula->ubicacion) ?></td>
					<td><?= nl2br(esc($jaula->caracteristicas))?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>