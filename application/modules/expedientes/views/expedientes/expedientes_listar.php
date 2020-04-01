<script>
	var expedientes_table;
	function confirmar_accion(id, accion, expediente) {
		$('#accion_confirmacion').html(accion);
		$('#expediente_confirmacion').html(expediente);
		var a = document.getElementById('link_confirmacion');
		a.href = "expedientes/expedientes/" + accion + "/" + id;
		$('#confirmacion_expediente_modal').modal();
	}
        $(document).ready(function () {
            $(document).keypress(function (e) {
                var charCode = e.which || e.keyCode;
                if (charCode === 124 || charCode === 231 || charCode === 199 || charCode === 93) { // | ç Ç - ]240973

                    e.preventDefault();
                    $('input[placeholder="Cód.Barra"]').select();
                }
            });
        });
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Expedientes
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador . '/' . $metodo; ?>"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active"><?php echo $box_title; ?></li>
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
						<h3 class="box-title"><?php echo $box_title; ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $js_table; ?>
						<?php echo $html_table;?>
						<?php #var_dump($_SESSION['usuario']); die();?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="estado_expediente_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Estado expediente</h4>
			</div>
			<div class="modal-body">
				<b>Estado:</b> <span id="estado_expediente"></span><br />
				<b>Oficina:</b> <span id="oficina_expediente"></span><br />
				<b>Fecha:</b> <span id="fecha_expediente"></span><br />
				<b>Nota:</b> <span id="nota_expediente"></span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirmacion_expediente_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Advertencia</h4>
			</div>
			<div class="modal-body">
				<p>Está por <span id="accion_confirmacion"></span> el Expediente <span id="expediente_confirmacion"></span>. ¿Desea continuar?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
				<a id="link_confirmacion" href="" title="Aceptar" class="btn btn-primary pull-right">Aceptar</a>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('input[placeholder="Fecha"]').datepicker({
			todayHighlight: true,
			format: "dd/mm/yyyy",
			todayBtn: "linked",
			clearBtn: "linked",
			language: "es",
			autoclose: true
		});
	});
</script>
