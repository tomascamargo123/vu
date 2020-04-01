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
						<h3 class="box-title">Circuito de tramite (<?= $tramite->nombre ?>)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
                                            <table class="table table-hover table-bordered table-condensed dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Orden</th>
                                                        <th>Plantilla</th>
                                                        <th>Oficina</th>
                                                        <th>Of. Destino</th>
                                                        <th>Firmantes</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($data_table as $row){
                                                        ?>
                                                    <tr>
                                                        <th>
                                                            <input type="hidden" name="pid" value="<?= $row['plantilla_id']?>">
                                                            <input type="hidden" name="tid" value="<?= $row['tramite_id']?>">
                                                            <input type="hidden" name="ord_t" value="<?= $row['orden']?>">
                                                            <?= $row['orden'] ?>
                                                        </th>
                                                        <td><?= $row['name_form'] ?></td>
                                                        <td><?= $row['name_ofic'] ?></td>
                                                        <td><?= $row['name_ofic_destino'] ?></td>
                                                        <td><span id="f_1"><?= $row['firmante_1'].'</span> - <span id="f_2">'.$row['firmante_2'].'</span> - <span id="f_3">'.$row['firmante_3'].'</span> - <span id="f_4">'.$row['firmante_4'] ?></span></td>
                                                        <td>
                                                            <a href="<?php echo base_url('expedientes/circuitos/editar_nodo/'.$tramite->id.'/'.$row['orden']); ?>" class="btn_fir_circ" title="Editar Nodo"><i class="fa fa-cogs"></i></a>
                                                            <a href="#" class="btn_fir_circ" title="Firmantes" <?= (!empty($row['name_form']) ? 'data-toggle="modal" data-target="#buscar_firmante_modal"':'disabled')?> ><i class="fa fa-pencil-square-o"></i></a>
                                                            <a href="#" class="btn_del_circ" title="Eliminar" ><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="<?= base_url('/expedientes/tramites/listar');?>" title="Cancelar">Cancelar</a>
                                                <a class="btn btn-primary pull-right" style="margin-left: 10px;" href="<?= base_url('expedientes/circuitos/agregar_nodo/'.$tramite->id)?>" title="Agregar cargo">Agregar Nodo</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<div class="modal fade" id="buscar_firmante_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Seleccionar firmante</h4>
			</div>
			<div class="modal-body">
                            <table class="table table-hover table-striped" id="table">

                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Seleccion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($usuarios as $u)
                                        {
                                            ?>
                                        <tr class="data" id="<?= $u['codiusua']?>">
                                            <td id="username"><?= $u['codiusua']?></td>
                                            <td>
                                                <input type="checkbox" name="user_check" class="select_user"/>
                                            </td>
                                        </tr>
                                            <?php
                                        }                                    
                                        ?>
                                    </tbody>
                                </table>
                                
                                <div class="paging-container" id="tablePaging"> </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                                <button class="btn btn-success" id="btn_saver_signer">Guardar</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="buscar_destino_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Seleccionar oficina destino</h4>
			</div>
			<div class="modal-body">
                            <table class="table table-hover table-striped" id="table_ofi">

                                    <thead>
                                        <tr>
                                            <th>Oficina</th>
                                            <th>Seleccion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($oficinas as $u)
                                        {
                                            ?>
                                        <tr class="data">
                                            <td id="username">
                                                <input type="hidden" name="id_ofic" value="<?= $u['id']?>">
                                                <?= $u['nombre']?>
                                            </td>
                                            <td>
                                                <input type="button" name="btn_ofice" class="btn btn-success btn_seleccionar" value="Seleccionar"/>
                                            </td>
                                        </tr>
                                            <?php
                                        }                                    
                                        ?>
                                    </tbody>
                                </table>
                                
                                <div class="paging-container" id="paginador_ofi"> </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                                <button class="btn btn-success" id="btn_saver_signer">Guardar</button>
			</div>
		</div>
	</div>
</div>

<script>
var URL = '<?php echo base_url(); ?>';
var contador_check = 0;
var firmantes = new Array();
var p_id = 0;
var t_id = 0;
$(document).ready(function(){
    $(".btn_del_circ").click(function(event){
        event.preventDefault();
        var fila = $(this).parents('tr');
        p_id = fila.find('input[name=pid]').val();
        t_id = fila.find('input[name=tid]').val();
        ord_t = fila.find('input[name=ord_t]').val();//orden del tramite
        
        var request = $.ajax({
            url: URL+"/expedientes/circuitos/remove_data/",
            method: "POST",
            data: { odt : ord_t,tid: t_id },
            dataType: "html"
          });
          
          
        request.done(function( msg ) {
          console.log("Mensage desde el backend: "+msg);
          if(msg == "OK"){
              window.location.href = URL+"/expedientes/circuitos/listar/"+t_id;
          }
          else{
              alert("ERROR: Ocurrio un erro al eliminar los datos de parte del circuito.");
          }
        });
    });
    // seleccionar oficina
    $(".btn_seleccionar").click(function(){
        var fila = $(this).parents("tr");
        var id_ofic = fila.find("input[name=id_ofic]").val();
        var request = $.ajax({
            url: URL+"/expedientes/circuitos/save_destino",
            method: "POST",
            data: {tid: t_id, pid: p_id, destino: id_ofic},
            dataType: "html"
        });
        
        request.done(function( msg ) {
          if(msg == "OK"){
              window.location.href = URL+"/expedientes/circuitos/listar/"+t_id;
          }
          else{
              alert("ERROR: Ocurrio un erro al eliminar los datos de parte del circuito.");
          }
        });
    });
    //apginacion de usuarios
    
    window.tp = new Pagination('#tablePaging', {
        itemsCount: <?= sizeof($usuarios)?>,
        onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
        },
        onPageChange: function (paging) {
                //custom paging logic here
                console.log(paging);
                var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('#table').find('.data');

                $rows.hide();

                for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                }
        }
    });
    
    
    new Pagination('#paginador_ofi', {
        itemsCount: <?= sizeof($oficinas)?>,
        onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
        },
        onPageChange: function (paging) {
                //custom paging logic here
                console.log(paging);
                var start = paging.pageSize * (paging.currentPage - 1),
                        end = start + paging.pageSize,
                        $rows = $('#table_ofi').find('.data');

                $rows.hide();

                for (var i = start; i < end; i++) {
                        $rows.eq(i).show();
                }
        }
    });
    
    //validacion de la seleccion de usuarios
    
    
    $(".select_user").click(function(event){
         if($( "input:checked" ).length > contador_check){//si es mayor es un nuevo check  si no es un discheck
             if(firmantes.length <= 4 && $( "input:checked" ).length <= 4){
                contador_check = $( "input:checked" ).length;
                var fila = $(this).parents('tr');
                var str_user = fila.find("td[id=username]").html();
                firmantes.push(str_user);
            }else{
                event.preventDefault();
                alert("No puede seleccionar mas firmantes");
            }
         }else{
             var fila = $(this).parents('tr');
             var str_user = fila.find("td[id=username]").html();
             console.log(str_user);
             var index = $.inArray(str_user,firmantes);
             console.log(index);
             firmantes.splice(index,1);
             contador_check = $( "input:checked" ).length;
         }
         console.log(firmantes);
    });
    
    $("#btn_saver_signer").click(function(){
        var response = $.ajax({
            url: "<?= base_url(); ?>expedientes/circuitos/guardar_firmantes",
            method: "POST",
            data: { 
                array_firm : JSON.stringify(firmantes),
                tid: t_id,
                pid: p_id
                },
            dataType: "html"
        });
        
        
        response.done(function( msg ) {
          if(msg == "OK"){
              window.location.href = URL+"/expedientes/circuitos/listar/"+t_id;
          }else{
              alert("Ah ocurrido un error en la transacción.");
          }
        });
    });
});
</script>