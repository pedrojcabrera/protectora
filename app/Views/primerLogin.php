<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<title>Iniciar sesión</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body class="bg-light">

		<div class="container">
			<div class="row justify-content-center mt-5">
				<div class="col-lg-4 col-md-6 col-sm-8">
					<div class="card shadow">
						<div class="card-header text-center">
							<h4>Primer acceso</h4>
						</div>
						<div class="card-body">
							<?php if (session('error')): ?>
							<div class="alert alert-danger"><?= session('error') ?></div>
							<?php endif; ?>
							<?php if (session()->getFlashdata('success')): ?>
							<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
							<?php endif; ?>
							<form method="post" action="<?= base_url('primerAcceso') ?>">
								<?= csrf_field() ?>
								<input type="hidden" name="id" value="<?=$usuario->id?>">
								<div class="mb-3">
									<label for="usuario" class="form-label">Usuario</label>
									<input type="text" name="usuario" class="form-control"
										value="<?=$usuario->usuario?>" readonly required autofocus>
								</div>
								<div class="mb-3">
									<label for="nombre" class="form-label">Nombre</label>
									<input type="text" name="nombre" class="form-control" value="<?=$usuario->nombre?>"
										readonly required autofocus>
								</div>
								<div class="mb-3">
									<label for="password" class="form-label">Contraseña</label>
									<input type="password" name="password" class="form-control" required>
								</div>
								<div class="mb-3">
									<label for="RepitePassword" class="form-label">Repite Contraseña</label>
									<input type="password" name="repitePassword" class="form-control" required>
								</div>
								<div class="d-grid">
									<button type="submit" class="btn btn-primary">Entrar</button>
								</div>
							</form>
						</div>
						<div class="card-footer text-muted text-center">
							&copy; <?= date('Y') ?> - Tu protectora
						</div>
					</div>
				</div>
			</div>
		</div>

	</body>

</html>