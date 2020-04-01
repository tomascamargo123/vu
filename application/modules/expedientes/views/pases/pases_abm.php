<script>
	function confirmar_accion() {
		if (!$("#btn_submit").hasClass('disabled')) {
			$('#confirmacion_pase_modal').modal();
		}
	}
	function enviar_pase() {
		$('#form_pase').submit();
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Pases
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador . '/' . $metodo; ?>"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title"><?php echo $box_title; ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator', 'id' => 'form_pase')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['fecha_usuario']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['fecha_usuario']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['oficina_origen']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['oficina_origen']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['oficina_id']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['oficina_id']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6 col-sm-6 col-xs-8">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['oficina']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['oficina']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_oficina_destino" class="btn btn-warning" data-toggle="modal" data-target="#buscar_oficina_destino_modal">Cambiar oficina destino</button>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['observaciones']['label']; ?>
									</div>
									<div class="col-sm-10">
                                                                                
										<?php echo $fields['observaciones']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<?php if ($txt_btn === 'Guardar') : ?>
							<div class="row">
								<div class="form-group col-md-3 col-sm-3 col-xs-4">
									<div class="row">
										<div class="col-sm-6">
											<?php echo $fields['respuesta']['label']; ?>
										</div>
										<div class="col-sm-6">
											<?php echo $fields['respuesta']['form']; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<div class="row" <?= ($digital ? 'style="display:none;"' : '')?> >
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['fojas']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['fojas']['form']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<?php if ($txt_btn === 'Enviar') : ?>
							<a class="btn btn-default" href="expedientes/pases/listar_pendientes_e" title="Cancelar">Cancelar</a>
						<?php else: ?>
							<a class="btn btn-default" href="expedientes/pases/listar_enviados_sinr" title="Cancelar">Cancelar</a>
						<?php endif; ?>
						<button onclick="javascript:confirmar_accion();" id="btn_submit" type="button" class="btn btn-primary pull-right"><?php echo $txt_btn; ?></button>
						<?php echo ($txt_btn === 'Enviar' || $txt_btn === 'Guardar') ? form_hidden('id', $pase->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_oficina_destino_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar oficina destino</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_oficinas_destino; ?>
				<?php echo $html_table_oficinas_destino; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirmacion_pase_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Advertencia</h4>
			</div>
			<div class="modal-body">
				<p>¿Desea <?php echo ($txt_btn === 'Enviar') ? 'enviar' : 'modificar'; ?> el pase?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
				<button onclick="javascript:enviar_pase();" type="button" class="btn btn-primary pull-right">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<!--<script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>-->
<script>
    var expediente_id = <?= $pase->id_expediente ?>;
    console.log(expediente_id);
    var destino_id = "<?= isset($destino) ? $destino : ''?>";
    $(document).ready(function(){
        $("#oficina_id").val(destino_id);
        
	$.ajax({
		url: "expedientes/pases/is_digital_exp",
		type: "POST",
		dataType: "html",
		data: {id_exp: expediente_id}
	}).done(function(data) {
		if(data.required){
                    $("#observaciones").attr("required");
                    $("label[for=observaciones]").text("Observaciones");
                }else{
                    $("#observaciones").removeAttr("required");
                    $("label[for=observaciones]").text("Observaciones*");
                }
	}).fail(function (var1, var2){
            console.log(var2);
        });
        
    });
//    
//    CKEDITOR.replace( 'observaciones', {
//        language: 'es',
//        uiColor: '#9AB8F3'
//    });



</script>