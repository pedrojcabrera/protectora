<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1 class="text-center">Bienvenidos al panel de control</h1>

<div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 224px);">
	<div class="bg-warning text-dark rounded text-center" style="padding: 3ch;">
		Bienvenidos al panel de gestión de la protectora
		<br>
		-------x-------
		<br>
		Esta aplicación se encuentra en desarrollo, para pruebas y no es apta para producción.
		<br>
		La información que aquí se presenta no es verídica sino de testeo.
	</div>
</div>

<?= $this->endSection() ?>