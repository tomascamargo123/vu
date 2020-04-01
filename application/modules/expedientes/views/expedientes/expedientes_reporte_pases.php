<div style="text-align:center; font-family:'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; height:100%;">
	<p>
        <img width="500" src="img/expedientes/municipalidad_marca.png">
	</p>
    <p style="font-size:24pt;">
        <?php echo "Expediente $expediente->numero / $expediente->ano - $expediente->anexo"; ?>
    </p>
    <p style="font-size:24pt;">
        Pases realizados
    </p>
<table class="table">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Oficina emisora</th>
            <th>Usuario emisor</th>
            <th>Oficina receptora</th>
            <th>Usuario receptor</th>
            <th>Respuesta</th>
            <th>Fojas</th>
        </tr>
    </thead>
    <?php foreach ($pases as $pase): ?>
    <tr>
        <td><?php echo $pase->fecha ?></td>
        <td><?php echo $pase->origen ?></td>
        <td><?php echo $pase->usuario_emisor ?></td>
        <td><?php echo $pase->destino ?></td>
        <td><?php echo $pase->usuario_receptor ?></td>
        <td><?php echo $pase->respuesta ?></td>
        <td><?php echo $pase->fojas ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<style>
.table{
    font-size:8pt; 
    font-family:'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; 
    border:0.5px solid #f4f4f4; 
    border-spacing:0; 
    border-radius:2px;
    margin: auto;
}
.table tr td{
    text-align:left; 
    border:0.5px solid #f4f4f4;
    height:40px;
    padding: 5px;
}
.table tr th{
    text-align:left; 
    border:0.5px solid #f4f4f4;
    border-bottom: 2px solid #f4f4f4;
    padding: 5px;
}
</style>