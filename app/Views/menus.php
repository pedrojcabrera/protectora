	<nav class="nav flex-column">
		<a class="nav-link" href="<?=base_url('/')?>">Inicio</a>

		<a class="nav-link" data-bs-toggle="collapse" href="#mantenimientosMenu" role="button" aria-expanded="false"
			aria-controls="mantenimientosMenu">
			Mantenimientos
		</a>
		<div class="collapse ps-3" id="mantenimientosMenu">
			<?php if (session('is_loged') && session('usuario_nivel') != 'user'): ?>
			<a class="nav-link" href="<?=base_url('usuarios')?>">Usuarios</a>
			<?php endif; ?>
			<a class="nav-link" href="<?=base_url('veterinarios')?>">Veterinarios</a>
			<a class="nav-link" href="#">Socios</a>
		</div>

		<a class="nav-link" data-bs-toggle="collapse" href="#gestionesMenu" role="button" aria-expanded="false"
			aria-controls="gestionesMenu">
			Gestiones
		</a>
		<div class="collapse ps-3" id="gestionesMenu">
			<a class="nav-link" href="<?=base_url('reservas')?>">Reservas Veterinario</a>
			<a class="nav-link" href="#">Reservas Jaulas</a>
		</div>

		<a class="nav-link" data-bs-toggle="collapse" href="#reportesMenu" role="button" aria-expanded="false"
			aria-controls="reportesMenu">
			Reportes
		</a>
		<div class="collapse ps-3" id="reportesMenu">
			<a class="nav-link" href="#">Cazas</a>
			<a class="nav-link" href="#">Visitas Veterinario</a>
		</div>
	</nav>