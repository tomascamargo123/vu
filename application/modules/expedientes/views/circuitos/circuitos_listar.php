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
                                                        <td><span id="f_1"><?= $row['firmantes'] ?></span></td>
                                                        <td>
                                                            <a href="<?php echo base_url('expedientes/circuitos/editar_nodo/'.$tramite->id.'/'.$row['orden']); ?>" class="btn_fir_circ" title="Editar Nodo"><i class="fa fa-cogs"></i></a>
                                                            <?php
                                                            if(trim($row['name_form']) != ''){
                                                              ?><a href="<?php echo base_url('expedientes/circuitos/firmantes/'.$row['tramite_id'].'/'.$row['plantilla_id']); ?>" class="btn_fir_circ" title="Firmantes" ><i class="fa fa-pencil-square-o"></i></a><?php  
                                                            }
                                                            ?>
                                                            <a href="#" class="btn_del_circ" title="Eliminar" ><i class="fa fa-trash"></i></a>
                                                            <a href="<?php echo base_url('expedientes/circuitos/cargar_formularios/'.$row['orden'].'/'.$row['plantilla_id'].'/'.$row['tramite_id']); ?>" class="btn_fir_circ" title="Autocargado"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
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
          if(msg == "OK"){
              window.location.href = URL+"/expedientes/circuitos/listar/"+t_id;
          }
          else{
              alert("ERROR: Ocurrio un erro al eliminar los datos de parte del circuito.");
          }
        });
    });
    
});
</script>