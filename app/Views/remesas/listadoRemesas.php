<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
/* Acordeón cerrado → verde suave */
.accordion-button.collapsed {
	background-color: #d1e7dd;
	/* verde BS5 */
	color: #0f5132;
	/* verde más oscuro para contraste */
}

/* Acordeón abierto → azul suave */
.accordion-button:not(.collapsed) {
	background-color: #cfe2ff;
	/* azul BS5 */
	color: #084298;
	/* azul más oscuro para contraste */
}
</style>

<h2>Remesas</h2>

<div class="accordion" id="accordionRemesas">
	<?php foreach ($remesas as $index => $remesa): ?>
	<div class="accordion-item">
		<h2 class="accordion-header" id="heading<?= $index ?>">
			<button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button"
				data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>"
				aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
				<?= date('d/m/Y', strtotime($remesa->fecha_cobro)) ?>
				&nbsp; | &nbsp; <?= $remesa->num_recibos ?> recibos
				&nbsp; | &nbsp; Total: <?= number_format($remesa->total, 2, ',', '.') ?> €
			</button>
		</h2>
		<div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
			aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionRemesas">
			<div class="accordion-body">
				<table class="table table-striped table-sm">
					<thead>
						<tr>
							<th>Fecha cobro</th>
							<th>Socio</th>
							<th>Importe (€)</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($remesa->detalles as $recibo): ?>
						<tr>
							<td><?= date('d/m/Y', strtotime($recibo->fecha_cobro)) ?></td>
							<td><?= esc($recibo->nombre) ?></td>
							<td class="text-end pe-5"><?= number_format($recibo->importe, 2, ',', '.') ?></td>
							<td><?= ucfirst(esc($recibo->estado)) ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>


<?= $this->endSection() ?>