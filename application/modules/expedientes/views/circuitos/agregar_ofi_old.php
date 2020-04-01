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
						<h3 class="box-title">Oficians - Origen (<?= $tramite->nombre ?>)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
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
                                                        <th id="origen_id"><?= $row['id'] ?></th>
                                                        <td><?= $row['nombre'] ?></td>
                                                        <td>
                                                            <button title="Agregar"  class="btn btn-success btn_plantilla" data-toggle="modal" data-target="#agregar_plantilla_modal"><i class="fa fa-plus"></i> Agregar</button>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            
                                            <div class="paging-container" id="pagination_origen"> </div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="javascript:window.history.back();" title="Cancelar">Cancelar</a>
						<a class="btn btn-primary pull-right" href="<?= base_url('/expedientes/plantillas/agregar') ?>" title="Agregar cargo">Crear Plantilla</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="agregar_plantilla_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Oficina  - Destino</h4>
			</div>
			<div class="modal-body">
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
                                        <th id="destino_id"><?= $o['id'] ?></th>
                                        <td><?= $o['nombre'] ?></td>
                                        <td>
                                            <a href="#" class="btn_sel" title="Seleccionar"><i class="fa fa-check"></i></a>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            
                           <div class="paging-container" id="pagination_destino"> </div>
			</div> 
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script>
var URL = '<?= base_url()?>';
var id_tramite = <?= $tramite->id ?>;
var id_origen = 0;
var id_destino = 0;


$(document).ready(function(){
    $(".btn_plantilla").click(function(){
        var fila = $(this).parents('tr');
        id_origen = fila.find('th[id=origen_id]').html();
    });
    
    $(".btn_sel").click(function(event){
        event.preventDefault();
        var fila = $(this).parents('tr');
        id_destino = fila.find('th[id=destino_id]').html();
        var request = $.ajax({
            url: "<?= base_url('/expedientes/circuitos/asignar_oficina/')?>",
            method: "POST",
            data: { origenid : id_origen, destinoid: id_destino, tid: id_tramite},
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