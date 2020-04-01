<html>
	<head>
		<style>
			body {
				font-family:Arial, "Helvetica Neue", Helvetica, sans-serif;
				font-size:11pt;
			}
			tbody > tr:nth-child(odd) {
				background-color: #f9f9f9;
			}
		</style>
	</head>
	<body>
		<div style="border-top:2px solid #000; border-bottom:2px solid #000; margin-bottom:20px; font-size:12pt;">
			<div style="padding:0 3px; width:120px; background-color:#BFBFBF; float:left; text-align:right;">Oficina: </div> 
			<div style="padding:0 3px; float:left;"> <?php echo $oficina_nombre; ?></div>
		</div>
		<table style="width:100%; border-collapse:collapse;">
			<thead>
				<tr style="background-color:#3F3F3F;">
					<th style="width:85%; color:#fff;">Usuario</th>
					<th style="width:15%; color:#fff;">Cant. pases</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($pases)): ?>
					<?php $fila = 1; ?>
					<?php foreach ($pases as $Pase): ?>
						<tr <?php echo $fila++ % 2 === 0 ? 'style="background-color:#E5E5E5;"' : ''; ?>>
							<td style="padding-left:8px;"><?php echo $Pase->usuario; ?></td>
							<td style="text-align:right;padding-right:8px;"><?php echo $Pase->cantidad; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</body>
</html>