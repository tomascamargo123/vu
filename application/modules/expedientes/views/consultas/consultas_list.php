<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>
            Consultas
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="expedientes/escritorio">Expedientes</a></li>
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
                    
                    <div class="box-body">
                        <!-- MIS CONSULTAS -->
                        <h4 class="box-title">Mis Consultas</h4>
                        <a href="expedientes/consultas/crear/" class="btn btn-info">Crear Nueva Consulta</a>
                        <br><br>
                        <table class="table table-hover">
                            <?php echo $js_table; ?>
						    <?php echo $html_table; ?>
                        </table>
                    </div>
                    <!-- fin de mi codigo -->
                </div> 
            </div>
        </div>
    </section>
</div>
<div class="modal fade in" id="confirmacion_eliminar_consulta" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Advertencia</h4>
			</div>
			<div class="modal-body">
				<p>¿Desea eliminar la consulta? Esta acción no se puede deshacer</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
				<button onclick="eliminar();" type="button" class="btn btn-primary pull-right">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var id;
function setId(id){
    this.id = id;
}
function modal(){
    $('#confirmacion_eliminar_consulta').modal();
}  
function eliminar(){
    $.post("../vu/expedientes/consultas/eliminar/"+id)
    .done(function(){
        location.reload();
    })
    .fail(function (xhr, status, error) {
        console.log(xhr.status + "  " + status + "  " + error);
    });
    
}
</script>