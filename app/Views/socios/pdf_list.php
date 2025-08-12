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

		<h2>Informe listado alfabético de Socios</h2>
		<table>
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Email</th>
					<?php if(session('usuario_nivel') !== 'user'): ?>
					<th>Tipo de Socio</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($socios as $socio): ?>
				<tr>
					<td><?= esc($socio->nombre) ?></td>
					<td><?= esc($socio->telefono) ?></td>
					<td><?= esc($socio->email) ?></td>
					<?php if(session('usuario_nivel') !== 'user'): ?>
					<td><?= $tipos[$socio->tipo] ?></td>
					<?php endif; ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>