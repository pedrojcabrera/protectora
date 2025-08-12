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
		<h2>Listado de Razas por Especie</h2>
		<table>
			<thead>
				<tr>
					<th>Especie</th>
					<th>Raza</th>
					<th>Observaciones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($razas as $raza): ?>
				<tr>
					<td><?= esc($raza->especie) ?></td>
					<td><?= esc($raza->raza) ?></td>
					<td><?= nl2br(esc($raza->observaciones)) ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>