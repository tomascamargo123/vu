<div style="text-align:center; font-family:sans-serif;border: 5px solid;height: 100%;">
	<p style="<?= ($expediente->digital == 1 ? 'font-size:10pt;' : 'font-size:30pt;')?>">&nbsp;</p>
	<p>
            <img width="500" src="img/expedientes/municipalidad_marca.png">
	</p>
	<br />
	<br />
	<p style="height:30pt;">
	<barcode code="<?php echo "|$expediente->id"; ?>" type="EAN128B" size="1" class="barcode" height="1.5"/>
	<br /><?php echo $expediente->id; ?>
</p>
<p style="font-size:24pt;">
	<?php echo "Expediente $expediente->numero / $expediente->ano - $expediente->anexo"; ?>
</p>
<p style="font-size:16pt;">
	<?php
	$inicio = new DateTime($expediente->inicio);
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$mes = $meses[$inicio->format('n') - 1];
	echo $inicio->format('j') . ' de ' . $mes . ' de ' . $inicio->format('Y');
	?>
	<br>
	<?php
	echo $inicio->format('H:i');
	?>
</p>
<p style="font-size:14pt;">__________________________________________________________</p>
<p style="font-size:3pt;">&nbsp;</p>
<p style="font-size:18pt;">
	<?php echo "$expediente->caratula"; ?>
</p>
<p style="font-size:14pt;">__________________________________________________________</p>
<p style="font-size:16pt;">
	Tramite: <?php echo $expediente->tramite; ?>
</p>
<p style="font-size:14pt;">
	Objeto: <?php echo $expediente->objeto; ?>
</p>
</div>