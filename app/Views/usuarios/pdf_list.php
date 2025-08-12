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

		<h2>Informe listado alfabético de Usuarios</h2>
		<table>
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($usuarios as $usuario): ?>
				<tr>
					<td><?= esc($usuario->nombre) ?></td>
					<td><?= esc($usuario->telefono) ?></td>
					<td><?= esc($usuario->email) ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>