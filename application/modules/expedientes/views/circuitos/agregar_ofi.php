<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Circuito
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active"><?php echo ucfirst($metodo); ?></li>
		</ol>
	</section>
	<section class="content">
		<?php if (!empty($error)) : ?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Error!</h4>
				<?php echo $error; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($message)) : ?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> OK!</h4>
				<?php echo $message; ?>
			</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Nodo de circuito (<?= $tramite->nombre ?>)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
                                            <?php 
                                            if($ultimo_destino){
                                                //solo muestro tabla de la nueva oficina destino y la ultima oficina destino pasa a ser  la origen
                                                ?>
                                            <div class="col-xs-12">
                                                <h3>Oficina Destino <small id="destino-nombre"></small></h3>
                                                <table class="table table-hover table-striped" id="table_destino">
                                                    <thead>
                                                        <tr>
                                                            <th>Numero</th>
                                                            <th>Nombre</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($data_ofdestino as $o){
                                                            ?>
                                                        <tr class="data">
                                                            <th name="destino_id"><?= $o['id'] ?></th>
                                                            <td name="destino_name"><?= $o['nombre'] ?></td>
                                                            <td>
                                                                <button title="Agregar"  class="btn btn-default btn_destino"><i class="fa fa-check"></i> Seleccionar</button>
                                                            </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>

                                               <div class="paging-container" id="pagination_destino"> </div>
                                            </div>
                                                <?php
                                            }else{
                                                //si es el inicio de un circuito (no hay ultimo destino) y no hay plantilla entonces mustro las dos tablas
                                                ?>
                                            <div class="col-xs-6">
                                                <h3>Oficina Origen <small id="origen-nombre"></small></h3>
                                                
                                                <table class="table table-hover table-striped table-bordered table-condensed dt-responsive" id="table_origen">
                                                    <thead>
                                                        <tr>
                                                            <th>Numero</th>
                                                            <th>Oficina</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($data_ofdestino as $row){
                                                            ?>
                                                        <tr class="data">
                                                            <th name="origen_id"><?= $row['id'] ?></th>
                                                            <td name="origen_name"><?= $row['nombre'] ?></td>
                                                            <td>
                                                                <button title="Agregar"  class="btn btn-default btn_origen"><i class="fa fa-check"></i> Seleccionar</button>
                                                            </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>

                                                <div class="paging-container" id="pagination_origen"> </div>
                                            </div>
                                            
                                            <div class="col-xs-6">
                                                <h3>Oficina Destino <small id="destino-nombre"></small></h3>
                                                <table class="table table-hover table-striped" id="table_destino">
                                                    <thead>
                                                        <tr>
                                                            <th>Numero</th>
                                                            <th>Nombre</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($data_ofdestino as $o){
                                                            ?>
                                                        <tr class="data">
                                                            <th name="destino_id"><?= $o['id'] ?></th>
                                                            <td name="destino_name"><?= $o['nombre'] ?></td>
                                                            <td style="padding: 5px;">
                                                                <button title="Agregar"  class="btn btn-default btn_destino"><i class="fa fa-check"></i> Seleccionar</button>
                                                            </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>

                                               <div class="paging-container" id="pagination_destino"> </div>
                                            </div>
                                                <?php
                                            }
                                            ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="javascript:window.history.back();" title="Cancelar">Cancelar</a>
                                                <button class="btn btn-primary pull-right" id="btn_guardar_nodo">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
var URL = '<?= base_url()?>';
var id_tramite = <?= $tramite->id ?>;
var origen = new Object();
var destino = new Object();
var ultimo_dest = <?= ($ultimo_destino ? $ultimo_destino['oficina_destino_id'] : 'false') ?>;
origen.id = ultimo_dest;

$(document).ready(function(){
    $(".btn_origen").click(function(){
        var fila = $(this).parents('tr');
        if(destino.id != $.trim(fila.find('th[name=origen_id]').html())){
            origen.id = $.trim(fila.find('th[name=origen_id]').html());
            origen.nombre = $.trim(fila.find('td[name=origen_name]').html());
            $("#origen-nombre").html('('+origen.nombre+')');
            
        }
    });
    
    $(".btn_destino").click(function(){
        var fila = $(this).parents('tr');
        if(ultimo_dest || origen.id != $.trim(fila.find('th[name=destino_id]').html())){
            destino.id = $.trim(fila.find('th[name=destino_id]').html());
            destino.nombre = $.trim(fila.find('td[name=destino_name]').html());
            $("#destino-nombre").html('('+destino.nombre+')');
        }
        /**/
 
    });
    
    $("#btn_guardar_nodo").click(function(){
        $(this).attr('disabled','true');
        var request = $.ajax({
            url: "<?php echo base_url('/expedientes/circuitos/asignar_oficina/')?>",
            method: "POST",
            data: { origenid : origen.id, destinoid: destino.id, tid: id_tramite},
            dataType: "html"
          });
          
        request.done(function( msg ) {
            console.log(msg);
          if(msg == "OK"){
              window.location.href = URL+"/expedientes/circuitos/listar/"+id_tramite;
          }else{
              alert("ERROR: Ocurrio un problema en la asignacion de la plantilla.");
          }
        });
    });
    
    
    //apginacion de usuarios
    
    window.tp = new Pagination('#pagination_destino', {
        itemsCount: <?= sizeof($data_ofdestino)?>,
        onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
        },
        onPageChange: function (paging) {
                //custom paging logic here
                console.log(paging);
                var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('#table_destino').find('.data');

                $rows.hide();

                for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                }
        }
    });
    
    new Pagination('#pagination_origen', {
        itemsCount: <?= sizeof($data_oforigen)?>,
        onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
        },
        onPageChange: function (paging) {
                //custom paging logic here
                console.log(paging);
                var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('#table_origen').find('.data');

                $rows.hide();

                for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                }
        }
    });
});

</script>