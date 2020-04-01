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
				font-family: monospace;
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
			<div style="border:black solid 1px; background-color:#9F9F9F; font-weight:bold; font-size:11px;">
				<div style="text-align:center;">
					Constancia de Retención - <?php echo $retencion->retencion_detalle; ?>
				</div>
				<div style="text-align:right;">
					Certificado N° <?php echo $retencion->nro_certificado; ?>
				</div>
			</div>
			<div style="border:black solid 1px; background-color:#9F9F9F; text-align:center; font-weight:bold; font-size:11px;">
				Datos del Agente de Retención
			</div>
			<div style="border:black solid 1px; font-weight:bold; font-size:12px;">
				MUNICIPALIDAD DE LAVALLE<br/>
				CUIT: 30-67639188-2<br/>
				Agente de Retención N°: 093416-0<br/>
				Domicilio Fiscal en Mendoza: FRAY LUIS BELTRÁN 37 - VILLA TULUMAYA
			</div>
			<div style="border:black solid 1px; background-color:#9F9F9F; text-align:center; font-weight:bold; font-size:11px;">
				Datos del Sujeto Retenido
			</div>
			<div style="border:black solid 1px; font-weight:bold; font-size:12px;">
				<?php echo $retencion->proveedor; ?><br/>
				CUIT: <?php echo $retencion->cuit; ?><br/>
				N° Inscripción: <?php echo $retencion->nro_inscrip; ?><br/>
				Domicilio Fiscal: <?php echo $retencion->domicilio; ?><br/>
				Expediente: <?php echo $retencion->expe_pago; ?> - Liquidación: <?php echo $retencion->nro_liquidacion; ?> - Orden de Pago: <?php echo $retencion->numero_op; ?><br/>
				Detalle: <?php echo $retencion->orden_pago->detalle_op; ?><br/>
			</div>
			<div style="border:black solid 1px; background-color:#9F9F9F; text-align:center; font-weight:bold; font-size:11px;">
				Datos de la Retención
			</div>
			<table border=1 style="width:100%; border-collapse:collapse;">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Comprobante que origina<br/>la retención</th>
						<th>Importe Gravado</th>
						<th>Tasa Aplicada (%)</th>
						<th>Penalidad</th>
						<th>Exención (%)</th>
						<th>Importe Retenido</th>
					</tr>
				</thead>
				<tbody>
					<?php $tot_er = 0; ?>
					<?php foreach ($retencion->erogaciones as $erogacion): ?>
						<?php $tot_er+= $erogacion->importe; ?>
						<tr>
							<td><?php echo date_format(new DateTime($retencion->orden_pago->fecha_op), 'd/m/Y'); ?></td>
							<td style="text-align:right;"><?php echo $erogacion->nro_factura; ?></td>
							<td style="text-align:right;">$ <?php echo number_format($erogacion->importe, 2, ',', '.'); ?></td>
							<td style="text-align:center;"><?php echo number_format($retencion->alicuota, 0); ?></td>
							<td style="text-align:center;"><?php echo $retencion->Penalidad; ?></td>
							<td style="text-align:center;"><?php echo $retencion->exencion; ?></td>
							<td style="text-align:center;">sin discriminar</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<?php $this->load->helper('numeros'); ?>
						<td colspan="5" style="text-align:center;">Son Pesos: <?php echo num_to_letras($retencion->importe); ?></td>
						<td>Total Retenido</td>
						<td>$ <?php echo number_format($retencion->importe, 2, ',', '.'); ?></td>
					</tr>
				</tfoot>
			</table>
			<div style="border:black solid 1px; background-color:#9F9F9F; text-align:center; font-weight:bold; font-size:11px;">
				Retenciones Acumuladas
			</div>
			<table border=1 style="width:100%; border-collapse:collapse; text-align:center;">
				<thead>
					<tr>
						<th style="width:33%;">Monto imponible (acumulado)</th>
						<th style="width:33%;">Retención acumulada</th>
						<th style="width:33%;">Importe a cobrar</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo number_format($tot_er, 2, ',', '.'); ?></td>
						<td><?php echo number_format($retencion->importe, 2, ',', '.'); ?></td>
						<td><?php echo number_format($tot_er - $retencion->importe, 2, ',', '.'); ?></td>
					</tr>
				</tbody>
			</table>
			<div style="margin-left:55%; font-size:10px;">
				<br/><br/>
				Firma: .....................................................................<br/><br/><br/>
				Aclaración: ................................................................<br/><br/><br/>
				Carácter: ..................................................................
			</div>
		</section>
	</body>
</html>
