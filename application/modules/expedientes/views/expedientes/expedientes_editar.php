<script>
	var oficinas_solicitante_table;
	var solicitantes_table;
	var inmueble_table;
	$(document).ready(function() {
		$('#buscar_oficina_solicitante_modal').on('shown.bs.modal', function() {
			oficinas_solicitante_table.responsive.recalc();
		});
		$('#buscar_solicitante_modal').on('shown.bs.modal', function() {
			solicitantes_table.responsive.recalc();
		});
		$('#buscar_inmueble_modal').on('shown.bs.modal', function() {
			inmueble_table.responsive.recalc();
		});
		ver_extras_expediente();

		var tramite = $('#tramite').val();
		var tipo = "";
		$.ajax({
			url: "expedientes/tramites/verificarTipo/"+tramite,
			type: "GET",
			dataType: "json"
		}).done(function(data){
			if(data === 0){
				$('#persona_id').attr('disabled', true);
				$('#div_persona_id').hide();
				$('#div_caratula').attr('class', 'form-group col-md-9 col-sm-9 col-xs-12');
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
			<li><a href="expedientes/<?php echo $controlador; ?>/listar"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active">Editar</li>
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
						<h3 class="box-title">
							<?php echo "Expediente $expediente->numero / $expediente->ano - $expediente->anexo"; ?>
						</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['numero']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['numero']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['ano']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['ano']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['anexo']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['anexo']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['inicio']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['inicio']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<div style="display:none;"><?php echo $fields['persona_id']['form']; ?></div>
										<?php echo $fields['caratula']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['caratula']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button <?php if (!$expediente->tipo_tramite) echo 'style="display:none;"'; ?> type="button" id="btn_buscar_oficina_solicitante" class="btn btn-warning" data-toggle="modal" data-target="#buscar_oficina_solicitante_modal">Seleccionar solicitante</button>
								<button <?php if ($expediente->tipo_tramite) echo 'style="display:none;"'; ?> type="button" id="btn_buscar_solicitante" class="btn btn-warning" data-toggle="modal" data-target="#buscar_solicitante_modal">Seleccionar solicitante</button>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['tramite']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['tramite']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['objeto']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['objeto']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
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
						<div class="row" id="div-inmueble" style="display:none;">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['inmueble_id']['form']; ?>
										<?php echo $fields['inmueble']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['inmueble']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_inmueble" class="btn btn-warning" data-toggle="modal" data-target="#buscar_inmueble_modal">Seleccionar inmueble</button>
							</div>
						</div>
						<div class="row" id="div-ayuda-social" style="display:none;">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields_ayuda_social['numeroDeFichaApros']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields_ayuda_social['numeroDeFichaApros']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields_ayuda_social['nombreDelBeneficiario']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields_ayuda_social['nombreDelBeneficiario']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields_ayuda_social['detalleSolicitud']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields_ayuda_social['detalleSolicitud']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields_ayuda_social['detalleFamiliares']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields_ayuda_social['detalleFamiliares']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields_ayuda_social['detalleBeneficioEntregado']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields_ayuda_social['detalleBeneficioEntregado']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields_ayuda_social['tipo_ayuda_social']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields_ayuda_social['tipo_ayuda_social']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<?php if ($expediente->acumulado): ?>
							<div class="row">
								<div class="col-sm-12">
									<h4><b>Expediente Madre:</b></h4>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-3 col-sm-3 col-xs-4">
									<div class="row">
										<div class="col-sm-6">
											<?php echo $fields['numero_madre']['label']; ?>
										</div>
										<div class="col-sm-6">
											<?php echo $fields['numero_madre']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-3 col-sm-3 col-xs-4">
									<div class="row">
										<div class="col-sm-6">
											<?php echo $fields['ano_madre']['label']; ?>
										</div>
										<div class="col-sm-6">
											<?php echo $fields['ano_madre']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-3 col-sm-3 col-xs-4">
									<div class="row">
										<div class="col-sm-6">
											<?php echo $fields['anexo_madre']['label']; ?>
										</div>
										<div class="col-sm-6">
											<?php echo $fields['anexo_madre']['form']; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/expedientes/listar" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo ($txt_btn === 'Guardar' || $txt_btn === 'Eliminar') ? form_hidden('id', $expediente->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_oficina_solicitante_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar oficina solicitante</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_oficinas_solicitante; ?>
				<?php echo $html_table_oficinas_solicitante; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="buscar_solicitante_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar solicitante</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_solicitantes; ?>
				<?php echo $html_table_solicitantes; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="buscar_inmueble_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar inmueble</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_inmuebles; ?>
				<?php echo $html_table_inmuebles; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>