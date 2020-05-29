<script>
	function confirmar_accion(id, accion) {
		$('#accion_confirmacion').html(accion);
		var a = document.getElementById('link_confirmacion');
		a.href = "expedientes/pases/" + accion + "/" + id;
		$('#confirmacion_pase_modal').modal();
	}
	function rechazar_firma(archivo_id, idexp, firma_id) {
		$('#form-rechazar').attr('action', 'expedientes/archivos_adjuntos/rechazar_firma/' + archivo_id + '/bandeja/'+idexp);
                console.log('expedientes/archivos_adjuntos/rechazar_firma/' + archivo_id + '/bandeja/'+idexp);
		$('#rechazar_firma_id').val(firma_id);
		$('#modal-rechazar').modal();
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Firmas
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador . '/' . $metodo; ?>"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active"><?php echo $metodo_visual; ?></li>
		</ol>
	</section>
	<section class="content">
			<div class="alert alert-danger alert-dismissable" id="alert-error" style="display: none;">
				<button type="button" class="close" onclick="$('#alert-error').hide()">×</button>
				<h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
				Contraseña incorrecta
			</div>
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
						<?php echo $html_table; ?>
					</div>
                                    <div class="box-footer">
                                        <?php if($html_table != ""){
                                            ?>
                                        <button class="btn btn-danger" style="float: right;" data-toggle="modal" data-target="#modal-confirmar" id="btn-firmar-selec">Firmar Seleccionados</button>
                                            <?php
                                        } ?>
                                    </div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="modal-rechazar" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open("#", 'id="form-rechazar"'); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Ingrese motivo del rechazo de la firma</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Motivo</label>
					<input class="form-control" name="motivo_rechazo"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<input type="hidden" id="rechazar_firma_id" name="rechazar_firma_id" value="0">
				<?php echo form_submit(array('class' => 'btn btn-danger pull-right', 'title' => 'Rechazar'), 'Rechazar'); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-confirmar" tabindex="-1" role="dialog" style="margin-top: 50px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Ingrese contraseña para confirmar</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Contraseña</label>
					<input class="form-control" type="password" name="password"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="confirmar_firmas()">Confirmar</button>
			</div>
		</div>
	</div>
</div>
