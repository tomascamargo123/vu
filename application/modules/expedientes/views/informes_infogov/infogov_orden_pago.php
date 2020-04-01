<html>
	<head>
		<style>
			body{
				/*font-family: "Dejavu Sans";*/
			}
			table tbody tr td{
				font-family: monospace;
				font-size: 10px;
				vertical-align: top;
			}
			table thead tr th{
				font-size: 10px;
			}
			table tfoot tr td{
				font-size: 12px;
				text-align: right;
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<section>
			<div style="text-align:center; font-weight:bold;">
				<img height="80" style="float:left;" src="img/generales/logo_infogov.png">
				<br/>
				MUNICIPALIDAD DE LAVALLE
			</div>
			<br/>
			<div style="text-align:center; font-weight:bold; font-size:16px;">
				ORDEN DE PAGO N° <?php echo $orden_pago->numero_op; ?>
			</div>
			<div>
				<div style="text-align:center; font-weight:bold; width:50%; float:left;">
					Fecha: <?php echo date_format(new DateTime($orden_pago->fecha_op), 'd/m/Y'); ?>
				</div>
				<div style="text-align:center; font-weight:bold; width:50%; float:left;">
					Expediente: <?php echo $orden_pago->expe_pago; ?> - Liq:<?php echo $orden_pago->nro_liquidacion; ?>
				</div>
			</div>
			<hr>
			<div style="font-weight:bold;">
				Páguese por Tesorería la cantidad expresada, en concepto de:
			</div>
			<div style="font-size:11px;"><?php echo $orden_pago->detalle_op; ?></div>
			<br/>
			<div>
				<div style="float:left; width:195px; font-weight:bold;">Orden de pago a favor de:</div>
				<div style="float:left; width:400px; font-family:monospace; font-size:10px;">
					<?php
					$total_erogaciones = 0;
					foreach ($orden_pago->erogaciones as $erogacion)
					{
						echo "$erogacion->cuit $erogacion->proveedor<br/>";
						$total_erogaciones+= $erogacion->importe;
					}
					?>
				</div>
			</div>
			<br/>
			<?php $this->load->helper('numeros'); ?>
			<div style="font-weight:bold;">Por la cantidad de pesos: <?php echo num_to_letras($total_erogaciones); ?>.-</div>
			<br/>
			<?php if (!empty($orden_pago->erogaciones)): ?>
				<?php if ($orden_pago->tipo === 'Presupuestaria'): ?>
					<table border=1 style="width:100%; border-collapse:collapse;">
						<thead>
							<tr style="background-color:#9F9F9F;">
								<th style="width:29%;">Acreedor</th>
								<th style="width:23%;">Partida</th>
								<th style="width:15%;">Organigrama</th>
								<th style="width:9%;">Nro Imp.</th>
								<th style="width:14%;">Factura</th>
								<th style="width:10%;">Importe</th>
							</tr>
						</thead>
						<tbody>
							<?php $total_deb = 0; ?>
							<?php foreach ($orden_pago->erogaciones as $erogacion): ?>
								<tr>
									<td style="width:29%;">
										<?php echo $erogacion->cuit; ?><br/>
										<?php echo $erogacion->proveedor; ?>
									</td>
									<td><?php echo "$erogacion->partida_codigo - $erogacion->partida_detalle"; ?></td>
									<td><?php echo $erogacion->oficina_codigo; ?></td>
									<td style="text-align:right;"><?php echo $erogacion->nro_imputacion; ?></td>
									<td><?php echo $erogacion->nro_factura; ?></td>
									<td style="text-align:right;"><?php echo number_format($erogacion->importe, 2, ',', '.'); ?></td>
									<?php $total_deb+=$erogacion->importe; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5">TOTAL DE DEBITOS</td>
								<td><?php echo number_format($total_deb, 2, ',', '.'); ?></td>
							</tr>
						</tfoot>
					</table>
				<?php else: ?>
					<table border=1 style="width:100%; border-collapse:collapse;">
						<thead>
							<tr style="background-color:#9F9F9F;">
								<th style="width:29%;" colspan="2">Acreedor</th>
								<th style="width:23%;">Detalle</th>
								<th style="width:15%;">Cuenta Contable</th>
								<th style="width:9%;">Débito N°</th>
								<th style="width:14%;">Factura</th>
								<th style="width:10%;">Importe</th>
							</tr>
						</thead>
						<tbody>
							<?php $total_deb = 0; ?>
							<?php foreach ($orden_pago->erogaciones as $erogacion): ?>
								<tr>
									<td style="width:10%; text-align:right;"><?php echo $erogacion->cuit; ?></td>
									<td style="width:19%;"><?php echo $erogacion->proveedor; ?></td>
									<td><?php echo $orden_pago->detalle_op; ?></td>
									<td style="text-align:right;"><?php echo $erogacion->ctacble_codigo; ?><br/><?php echo $erogacion->ctacble_detalle; ?></td>
									<td style="text-align:right;"><?php echo $erogacion->nro_debito; ?></td>
									<td><?php echo $erogacion->nro_factura; ?></td>
									<td style="text-align:right;"><?php echo number_format($erogacion->importe, 2, ',', '.'); ?></td>
									<?php $total_deb+=$erogacion->importe; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6">TOTAL DE DEBITOS</td>
								<td><?php echo number_format($total_deb, 2, ',', '.'); ?></td>
							</tr>
						</tfoot>
					</table>
				<?php endif; ?>
			<?php endif; ?>
			<br/>
			<?php if (!empty($orden_pago->retenciones)): ?>
				<div style="font-weight:bold;">Efectuando las siguientes retenciones:</div>
				<table border=1 style="width:100%; border-collapse:collapse;">
					<thead>
						<tr style="background-color:#9F9F9F;">
							<th style="width:23%;">Acreedor</th>
							<th style="width:19%;" colspan="2">Retención</th>
							<th style="width:24%;" colspan="2">Categoría</th>
							<th style="width:5%;">Base<br/>Imp</th>
							<th style="width:5%;">Alic.<br/>(%)</th>
							<th style="width:5%;">Penal.</th>
							<th style="width:5%;">Ex.<br/>(%)</th>
							<th style="width:4%;">Cert.</th>
							<th style="width:10%;">Importe</th>
						</tr>
					</thead>
					<tbody>
						<?php $total_retenciones = 0; ?>
						<?php foreach ($orden_pago->retenciones as $retencion): ?>
							<tr>
								<td style="width:23%;">
									<?php echo $retencion->cuit; ?><br/>
									<?php echo $retencion->proveedor; ?>
								</td>
								<td style="width:2%;"><?php echo $retencion->retencion_codigo; ?></td>
								<td style="width:17%;"><?php echo "$retencion->retencion_detalle ($retencion->ctacble)"; ?></td>
								<td style="width:2%;"><?php echo $retencion->categoria_codigo; ?></td>
								<td style="width:22%;"><?php echo $retencion->categoria_detalle; ?></td>
								<td style="width:5%; text-align:right;"><?php echo number_format($retencion->base, 0); ?></td>
								<td style="width:5%; text-align:right;"><?php echo number_format($retencion->alicuota, 0); ?></td>
								<td style="width:5%;"><?php echo $retencion->Penalidad; ?></td>
								<td style="width:5%; text-align:right;"><?php echo number_format($retencion->exencion, 0); ?></td>
								<td style="width:4%;"><?php echo $retencion->nro_certificado; ?></td>
								<td style="width:10%; text-align:right;"><?php echo number_format($retencion->importe, 2, ',', '.'); ?></td>
								<?php $total_retenciones+=$retencion->importe; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="10">TOTAL DE RETENCIONES</td>
							<td><?php echo number_format($total_retenciones, 2, ',', '.'); ?></td>
						</tr>
					</tfoot>
				</table>
				<br/>
			<?php endif; ?>
			<?php if (!empty($orden_pago->cheques)): ?>
				<table border=1 style="width:100%; border-collapse:collapse;">
					<thead>
						<tr style="background-color:#9F9F9F;">
							<th style="width:30%;" colspan="3">A la orden de</th>
							<th style="width:25%;" colspan="2">Banco</th>
							<th style="width:8%;">Cheque</th>
							<th style="width:12%;">Fecha emisión</th>
							<th style="width:11%;">Importe</th>
							<th style="width:14%;">Recibí conforme</th>
						</tr>
					</thead>
					<tbody>
						<?php $total_cheque_em = 0; ?>
						<?php $total_cheque_no_em = 0; ?>
						<?php foreach ($orden_pago->cheques as $cheque): ?>
							<tr>
								<td style="width:10%; text-align:right;"><?php echo $cheque->cuit; ?></td>
								<td style="width:22%;"><?php echo $cheque->alaordende; ?></td>
								<td style="width:3%; text-align:center;"><?php echo $cheque->ref_interb; ?></td>
								<td style="width:3%; text-align:center;"><?php echo $cheque->banco_codigo; ?></td>
								<td style="width:22%;"><?php echo $cheque->banco_detalle; ?></td>
								<td style="text-align:right;"><?php echo $cheque->numero; ?></td>
								<td style="text-align:center;"><?php echo $cheque->emision; ?></td>
								<td style="text-align:right;"><?php echo number_format($cheque->importe, 2, ',', '.'); ?></td>
								<td></td>
								<?php if (!empty($cheque->emision)): ?>
									<?php $total_cheque_em+=$cheque->importe; ?>
								<?php else: ?>
									<?php $total_cheque_no_em+=$cheque->importe; ?>
								<?php endif; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">TOTAL DE CHEQUES EMITIDOS</td>
							<td><?php echo number_format($total_cheque_em, 2, ',', '.'); ?></td>
							<td rowspan="2"></td>
						</tr>
						<tr>
							<td colspan="7">TOTAL DE CHEQUES SIN EMITIR</td>
							<td><?php echo number_format($total_cheque_no_em, 2, ',', '.'); ?></td>
						</tr>
					</tfoot>
				</table>
			<?php endif; ?>
			<br/>
			<br/>
			<br/>
			<br/>
			<div style="text-align:center; font-size:12px;">
				Municipalidad de Lavalle
			</div>
			<div style="text-align:center; font-size:12px;">
				Orden de pago: <?php echo $orden_pago->numero_op; ?>
			</div>
			<br/>
			<br/>
			<br/>
			<div style="float:left; width:45%; text-align:center; padding:2%; font-size:12px;">
				<hr>Contador
			</div>
			<div style="float:left; width:45%; text-align:center; padding:2%; font-size:12px;">
				<hr>Secretario de Gobierno
			</div>
			<br/>
			<br/>
			<br/>
			<div style="float:left; width:45%; text-align:center; padding:2%; font-size:12px;">
				<hr>Intendente Municipal
			</div>
			<div style="float:left; width:45%; text-align:center; padding:2%; font-size:12px;">
				<hr>Tesorero municipal
			</div>
			<div>
				Orden de Pago N° <?php echo $orden_pago->numero_op; ?>
			</div>
			<div>
				<!--EMITIR-->
				Fecha de remisión: <?php echo date_format(new DateTime($orden_pago->remision_op), 'd/m/Y'); ?>
				<?php if (!empty($orden_pago->fecha_archivo)) echo '- Fecha de archivo: ' . date_format(new DateTime($orden_pago->fecha_archivo), 'd/m/Y'); ?>
			</div>
		</section>
	</body>
</html>
