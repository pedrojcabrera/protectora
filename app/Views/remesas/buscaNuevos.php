<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->has('errores_email')): ?>
    <?php $errores = session('errores_email'); ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5>Errores al enviar emails:</h5>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Socio</th>
                    <th>Email</th>
                    <th>Error</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($errores as $e): ?>
                    <tr>
                        <td><?= esc($e['socio']) ?></td>
                        <td><?= esc($e['email']) ?></td>
                        <td><?= esc($e['error']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php if (session()->has('mensajes')): ?>
<?php $mensajes = session('mensajes'); ?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	<h4>Resultados del envío de correos:</h4>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Socio</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mensajes as $e): ?>
                    <tr>
                        <td><?= esc($e['socio']) ?></td>
                        <td><?= esc($e['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>
<?php endif; ?>



<?php if(!$remesa_bancaria || $remesa_bancaria === null): ?>
<h2 class="text-center mt-3">No hay recibos bancarios para el próximo <?= str_replace("-", "/", $fechaRemesa) ?></h2>
<?php else: ?>
<h2>Remesa <?= esc($remesa_bancaria->remesa) ?> del <?= $fechaRemesa ?></h2>
<?php if (empty($recibos_bancarios)): ?>
<div class="alert alert-warning">
	No hay socios para crear remesas el <?= str_replace("-", "/", $fechaRemesa) ?>.
</div>
<?php else: ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Socio</th>
			<th>Importe (€)</th>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recibos_bancarios as $r): ?>
		<tr>
			<td><?= esc($r->socio_nombre) ?></td>
			<td class="text-end pe-5"><?= number_format($r->importe, 2, ',', '.') ?></td>
			<td><?= date('d/m/Y', strtotime($r->fecha_cobro)) ?></td>
			<td><?= esc($r->estado) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="mt-3 botonera-fija">
	<?php if($remesa_bancaria->estado === 'pendiente'): ?>
	<a href="<?= site_url('remesas/exportar') ?>" class="btn btn-sm btn-success mb-1">
		Generar un archivo SEPA XML
	</a>
	<br>
	<a href="<?= site_url('remesas/cartearRBAN') ?>" class="btn btn-sm btn-success">
		Cartear a los socios con recibos bancarios la proximidad de la remesa
	</a>
	<?php else: ?>
	<div class="alert alert-danger">
		La remesa ya ha sido procesada, pero puede ser generada nuevamente.
		<br>
		Si ya ha enviado el fichero anterior a su banco, no lo envíe de nuevo
	</div>
	<a href="<?= site_url('remesas/exportar') ?>" class="btn btn-sm btn-danger mb-1">
		Generar de nuevo un archivo SEPA XML
	</a>
	<br>
	<a href="<?= site_url('remesas/cartearRBAN') ?>" class="btn btn-sm btn-success">
		Cartear a los socios con recibos bancarios la proximidad de la remesa
	</a>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if(!$remesa_ingresos || $remesa_ingresos === null): ?>
<h2 class="text-center mt-3">No hay ingresos para el próximo <?= str_replace("-", "/", $fechaRemesa) ?></h2>
<?php else: ?>
<h2>Remesa <?= esc($remesa_ingresos->remesa) ?> del <?= $fechaRemesa ?></h2>
<?php if (empty($recibos_ingresos)): ?>
<div class="alert alert-warning">
	No hay socios para crear remesas el <?= str_replace("-", "/", $fechaRemesa) ?>.
</div>
<?php else: ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Socio</th>
			<th>Importe (€)</th>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recibos_ingresos as $r): ?>
		<tr>
			<td><?= esc($r->socio_nombre) ?></td>
			<td class="text-end pe-5"><?= number_format($r->importe, 2, ',', '.') ?></td>
			<td><?= date('d/m/Y', strtotime($r->fecha_cobro)) ?></td>
			<td><?= esc($r->estado) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="mt-3 botonera-fija">
	<?php if($remesa_ingresos->estado === 'pendiente'): ?>
	<a href="<?= site_url('remesas/cartearICTA') ?>" class="btn btn-sm btn-success">
		Generar correo recordatorio de ingresos
	</a>
	<?php else: ?>
	<div class="alert alert-danger">
		Los correos ya han sido emitidos, pero puede ser generados nuevamente.
	</div>
	<a href="<?= site_url('remesas/cartearICTA') ?>" class="btn btn-sm btn-danger">
		Generar de nuevo correo recordatorio de ingresos
	</a>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>


<?= $this->endSection() ?>