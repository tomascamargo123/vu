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
				PASE N° <?php echo $pase->id; ?>
			</div>
			<br/>
			<div>
				<div style="text-align:center; font-weight:bold; width:50%; float:left;">
					Fecha: <?php echo date_format(new DateTime($pase->fecha), 'd/m/Y'); ?>
				</div>
				<div style="text-align:center; font-weight:bold; width:50%; float:left;">
					Expediente: <?php echo "$pase->numero/$pase->ano Anexo $pase->anexo"; ?>
				</div>
			</div>
			<hr>
			<div style="width:50%; float:left;">
				<div style="font-weight:bold;">Origen: <?php echo "$pase->origen - $pase->origen_of"; ?></div>
				<div style="font-size:11px;">Fecha: <?php echo date_format(new DateTime($pase->fecha_usuario), 'd/m/Y H:i:s'); ?></div>
				<div style="font-size:11px;">Usuario: <?php echo $pase->usuario_emisor; ?></div>
			</div>
			<div style="width:50%; float:left;">
				<div style="font-weight:bold;">Destino: <?php echo "$pase->destino - $pase->destino_of"; ?></div>
				<div style="font-size:11px;">Fecha: <?php echo date_format(new DateTime($pase->fecha), 'd/m/Y H:i:s'); ?></div>
				<div style="font-size:11px;">Usuario: <?php echo $pase->usuario_receptor; ?></div>
			</div>
			<br/>
			<?php if (!empty($pase->nota_pase)): ?>
				<div style="font-weight:bold;">Nota:</div>
				<div style="font-size:11px;"><?php echo $pase->nota_pase; ?></div>
			<?php else: ?>
				<br/>
				<br/>
			<?php endif; ?>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<!--<div style="text-align:center; font-size:12px;">Municipalidad de Lavalle</div>-->
			<!--<div style="text-align:center; font-size:12px;">Pase N°: <?php echo $pase->id; ?></div>-->
		</section>
	</body>
</html>