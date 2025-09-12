<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= esc($title ?? 'Inicio') ?></title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Leaflet CSS -->
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
		<link href="<?= base_url('css/styles.css') ?>" rel="stylesheet">

	</head>

	<body>

		<!-- Header -->
		<header class="navbar navbar-dark bg-dark fixed-top">
			<div class="container-fluid d-flex justify-content-between align-items-center">
				<button class="btn btn-dark d-lg-none" type="button" data-bs-toggle="offcanvas"
					data-bs-target="#sidebar" aria-controls="sidebar">☰</button>
				<span id="protectora"><?=session('prote_nombre_corto')?></span>
				<div class="d-flex align-items-center">
					<small id="user" class="text-white me-3">Bienvenido,
						<?= esc(session()->get('usuario_nombre')) ?>
					</small>
					<a href="<?= base_url('salir') ?>" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
				</div>
			</div>
		</header>

		<!-- SIDEBAR OFFCANVAS -->
		<aside id="sidebar" class="offcanvas offcanvas-start bg-light p-3 border-end" tabindex="-1">
			<div class="logo-container text-center mb-1">

				<?php if(file_exists(FCPATH.'imagenes/protectora/'.session()->get('prote_logo'))):?>
				<img src="<?= base_url('imagenes/protectora/' . session()->get('prote_logo')) ?>" alt="Logo"
					class="img-fluid w-100" style="height: auto; max-width:150px">
				<?php else: ?>
				<img src="<?= base_url('images/SinLogo.png') ?>" alt="Logo" class="img-fluid w-100"
					style="height: auto;">
				<?php endif; ?>
			</div>

			<div class="offcanvas-header d-lg-none">
				<h5 class="offcanvas-title">Menú</h5>
				<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
			</div>

			<div class="offcanvas-body">
				<nav class="nav flex-column">
					<a class="nav-link" href="<?=base_url('/')?>" data-bs-dismiss="offcanvas">Inicio</a>

					<!-- Mantenimientos -->
					<a class="nav-link" data-bs-toggle="collapse" href="#menuMantenimientos" role="button"
						aria-expanded="false" aria-controls="menuMantenimientos">Mantenimientos</a>
					<div class="collapse ps-3" id="menuMantenimientos">
						<a class="nav-link" href="<?=base_url('veterinarios')?>"
							data-bs-dismiss="offcanvas">Veterinarios</a>
						<a class="nav-link" href="<?=base_url('socios')?>" data-bs-dismiss="offcanvas">Socios</a>
						<a class="nav-link" href="<?=base_url('colonias')?>" data-bs-dismiss="offcanvas">Colonias</a>
						<a class="nav-link" href="<?=base_url('especies')?>" data-bs-dismiss="offcanvas">Especies</a>
						<a class="nav-link" href="<?=base_url('razas')?>" data-bs-dismiss="offcanvas">Razas</a>
						<a class="nav-link" href="<?=base_url('animales')?>" data-bs-dismiss="offcanvas">Animales</a>
						<a class="nav-link" href="<?=base_url('jaulas')?>" data-bs-dismiss="offcanvas">Jaulas y
							Accesorios</a>
						<!-- Restringidos -->
						<?php if (session('is_loged') && session('usuario_nivel') !== 'user'): ?>
						<div class="nav-link p-0 m-0" style="line-height: 1;" data-bs-dismiss="offcanvas">
							<hr class="m-1 border-danger">
						</div>
						<a class="nav-link text-danger" href="<?=base_url('protectora')?>"
							data-bs-dismiss="offcanvas">La Protectora</a>
						<a class="nav-link text-danger" href="<?=base_url('usuarios')?>"
							data-bs-dismiss="offcanvas">Usuarios</a>
						<?php endif; ?>
					</div>
					<span class="text"></span>

					<!-- Reservas -->
					<a class="nav-link" data-bs-toggle="collapse" href="#menuReservas" role="button"
						aria-expanded="false" aria-controls="menuReservas">Reservas</a>
					<div class="collapse ps-3" id="menuReservas">
						<a class="nav-link" href="#" data-bs-dismiss="offcanvas">Veterinarios</a>
						<a class="nav-link" href="#" data-bs-dismiss="offcanvas">Accesorios</a>
					</div>

					<!-- Gestiones -->
					<a class="nav-link" data-bs-toggle="collapse" href="#menuGestiones" role="button"
						aria-expanded="false" aria-controls="menuGestiones">Gestiones</a>
					<div class="collapse ps-3" id="menuGestiones">
						<a class="nav-link" href="<?=base_url('remesas/listadoRemesas')?>"
							data-bs-dismiss="offcanvas">Ver
							Remesas</a>
						<!-- Restringidos -->
						<?php if (session('is_loged') && session('usuario_nivel') !== 'user'): ?>
						<div class="nav-link p-0 m-0" style="line-height: 1;" data-bs-dismiss="offcanvas">
							<hr class="m-1 border-danger">
						</div>
						<a class="nav-link text-danger" href="<?=base_url('buscarNuevosRecibos')?>"
							data-bs-dismiss="offcanvas">Nuevos Recibos</a>
						<?php endif; ?>
					</div>

					<!-- Reportes -->
					<a class="nav-link" data-bs-toggle="collapse" href="#menuReportes" role="button"
						aria-expanded="false" aria-controls="menuReportes">Reportes</a>
					<div class="collapse ps-3" id="menuReportes">
						<a class="nav-link" href="<?=base_url('veterinarios/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Veterinarios
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('socios/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Socios
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('colonias/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Colonias
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('especies/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Especies
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('razas/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Razas
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('jaulas/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Jaulas
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('animales/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Animales
							(PDF)</a>
						<a class="nav-link" href="<?=base_url('colonias/showMapa')?>" data-bs-dismiss="offcanvas">Plano
							Colonias</a>
						<!-- Restringidos -->
						<?php if (session('is_loged') && session('usuario_nivel') !== 'user'): ?>
						<div class="nav-link p-0 m-0" style="line-height: 1;" data-bs-dismiss="offcanvas">
							<hr class="m-1 border-danger">
						</div>
						<a class="nav-link text-danger" href="<?=base_url('usuarios/pdf')?>" data-bs-dismiss="offcanvas"
							target="_blank">Usuarios
							(PDF)</a>
						<?php endif; ?>
					</div>

					<!-- Perfil -->
					<a class="nav-link" data-bs-toggle="collapse" href="#menuPerfil" role="button" aria-expanded="false"
						aria-controls="menuPerfil">Perfil</a>
					<div class="collapse ps-3" id="menuPerfil">
						<a class="nav-link" href="<?= base_url('usuarios/perfilDatos') ?>"
							data-bs-dismiss="offcanvas">Datos</a>
						<a class="nav-link" href="<?= base_url('usuarios/perfilPassword') ?>"
							data-bs-dismiss="offcanvas"><span class="text-danger">Contraseña</span></a>
					</div>
				</nav>
			</div>
		</aside>

		<main id="mainContent" class="container-fluid mt-5 pt-3">
			<?= $this->renderSection('content') ?>
		</main>

		<div id="scriptsContent" class="flex-grow-1 p-2">
			<?= $this->renderSection('scriptsAnexos') ?>
		</div>

		<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
		</script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

		<script>
		document.querySelectorAll('#sidebar a.nav-link').forEach(function(link) {
			link.addEventListener('click', function(e) {
				const href = link.getAttribute('href');
				const hasSubmenu = link.hasAttribute('data-bs-toggle');

				// Si abre un submenú, no cerramos ni interferimos
				if (hasSubmenu) return;

				// Si es un enlace real (no "#" ni vacío), cerramos y dejamos navegar
				if (href && href !== '#') {
					const sidebarEl = document.getElementById('sidebar');
					const offcanvasInstance = bootstrap.Offcanvas.getInstance(sidebarEl);
					if (offcanvasInstance) {
						offcanvasInstance.hide();
					}
					window.location.href = href;

					// Dejamos que el navegador siga el enlace
					return;
				}

				// Si es un ancla vacía, prevenimos navegación
				e.preventDefault();
			});
		});

		document.querySelectorAll('#sidebar [data-bs-toggle="collapse"]').forEach(toggle => {
			toggle.addEventListener('click', function(e) {
				const currentTarget = document.querySelector(this.getAttribute('href'));

				// Cierra todos los demás paneles colapsables dentro del sidebar
				document.querySelectorAll('#sidebar .collapse.show').forEach(opened => {
					if (opened !== currentTarget) {
						const bsCollapse = bootstrap.Collapse.getInstance(opened) || new bootstrap
							.Collapse(opened, {
								toggle: false
							});
						bsCollapse.hide();
					}
				});
			});
		});
		</script>

	</body>

</html>