<div style="text-align:center;">
	<p style="font-size:10pt;">&nbsp;</p>
	<p>
		<img width="270" src="img/generales/municipalidad_marca_lavalle.png">
	</p>
	<table width="80%" style="margin-left:10%;text-align:center;font-family:sans-serif">
		<tr><td style="font-size:24pt;"><p>___________________________________</p></td></tr>	
		<tr><td style="font-size:8pt;"><p>&nbsp;</p></td></tr>	
		<tr><td style="font-size:16pt;text-align:right;"><p>Ticket N°<?= $ticket->id; ?></p></td></tr>	
		<tr><td style="font-size:10pt;text-align: left;">
                        <p>&nbsp;</p>
                        <p>
                                Oficina Receptora:	<?php echo "$ticket->oficina_receptora - $ticket->oficina_nombre"; ?>
                        </p>
                        <p>
                                Cantidad de expedientes: <?php echo $ticket->cantexpe; ?>
                        </p>
                        <p>
                                Usuario: <?php echo $ticket->usuario; ?>
                        </p>
                        <p>
                            Fecha: <?php echo date_format(date_create($ticket->fecha),"d/m/Y H:i:s"); ?>
                        </p>
                        <p>
                            Expedientes:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:10pt;text-align: left;">
                        <?php 
                        
                        foreach ($expedientes as $exp){
                            ?>
                            <li><?= $exp->numero.' - '.$exp->ano .' / '.$exp->anexo?></li>
                            <?php
                        }
                        
                        ?>
                        <p>&nbsp;</p>
                    </td>
                </tr>
		<tr><td style="font-size:24pt;"><p>___________________________________</p></td></tr>	
	</table>
</div>