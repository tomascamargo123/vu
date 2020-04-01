<div style="text-align:center;">
	<p style="font-size:10pt;">&nbsp;</p>
	<p>
		<img width="300" src="img/expedientes/logo_caratula.png">
	</p>
	<table width="80%" style="margin-left:10%;text-align:center;font-family:sans-serif">
		<tr><td style="font-size:24pt;"><p>___________________________________</p></td></tr>	
		<tr><td style="font-size:8pt;"><p>&nbsp;</p></td></tr>	
		<tr><td style="font-size:16pt;text-align:right;"><p>VENTANILLA ÚNICA</p></td></tr>	
		<tr><td style="font-size:10pt;text-align: left;">
				<p>&nbsp;</p>
				<p>
					Expediente:	<?php echo "$expediente->numero / $expediente->ano - $expediente->anexo"; ?>
				</p>
				<p>
					Interesado: <?php echo $expediente->caratula; ?>
				</p>
				<p>
					Trámite: <?php echo $expediente->tramite; ?>
				</p>
				<p>
					Objeto: <?php echo $expediente->objeto; ?>
				</p>
				<p>&nbsp;</p>
			</td></tr>	
		<tr><td style="font-size:10pt;text-align: right;">
				<p>
					<?php
					$inicio = new DateTime($expediente->inicio);
					$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
					$mes = $meses[$inicio->format('n') - 1];
					echo 'Lavalle, ' . $inicio->format('j') . ' de ' . $mes . ' de ' . $inicio->format('Y');
					?>
				</p>
			</td></tr>	
		<tr><td style="font-size:24pt;"><p>___________________________________</p></td></tr>	
                <tr>
                    <td style="font-size:10pt;text-align: left;"><p>Atendido por: <?= $this->session->userdata('last_name').' '.$this->session->userdata('first_name')?></p></td>
                </tr>
	</table>
</div>