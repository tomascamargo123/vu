<script>
	var editable = true;
	var options, a;
	var centro = null;
	var solicitantes_table;
	$(document).ready(function() {
		$('#sector').change(function() {
			actualizar_grupo('cambio', 'Grupo modificado automáticamente, verifique que sea correcto.');
			actualizar_motivos('abm');
		});
		$('#tipo_solicitante').change(function() {
			actualizar_tipo_solicitante();
		});
		$('#solicitante').change(function() {
			actualizar_solicitante();
		});
		$('#prioridad').change(function() {
			actualizar_vencimiento();
		});
		$("#archivos").fileinput({
			language: 'es',
			showUpload: false,
			previewFileType: "image",
			browseClass: "btn btn-primary",
			browseLabel: "Seleccionar imágenes",
			browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
			removeClass: "btn btn-danger",
			removeLabel: "Eliminar",
			removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
		});
		$('#buscar_solicitante_modal').on('shown.bs.modal', function() {
			solicitantes_table.responsive.recalc();
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Reclamos
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="reclamos/escritorio">Reclamos</a></li>
			<li><a href="reclamos/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title">Administración de reclamo</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php echo form_open_multipart(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['agregar']; ?>" href="reclamos/reclamos/agregar">
							<i class="fa fa-plus" id="btn-agregar"></i> Agregar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="reclamos/reclamos/ver/<?php echo (!empty($reclamo->id)) ? $reclamo->id : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['editar']; ?>" href="reclamos/reclamos/editar/<?php echo (!empty($reclamo->id)) ? $reclamo->id : ''; ?>">
							<i class="fa fa-edit" id="btn-editar"></i> Editar
						</a>
						<div class="row">
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<div id="map" class="map-reclamos">
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['fecha_inicio']['label']; ?>
								<?php echo $fields['fecha_inicio']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['prioridad']['label']; ?>
								<?php echo $fields['prioridad']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['vencimiento']['label']; ?>
								<?php echo $fields['vencimiento']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['sector']['label']; ?>
								<?php echo $fields['sector']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['motivo']['label']; ?>
								<?php echo $fields['motivo']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['grupo']['label']; ?>
								<?php echo $fields['grupo']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['tipo_solicitante']['label']; ?>
								<?php echo $fields['tipo_solicitante']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['solicitante']['label']; ?>
								<div class="input-group">
									<div class="input-group-btn">
										<button type="button" id="btn_buscar_solicitante" class="btn btn-warning" data-toggle="modal" data-target="#buscar_solicitante_modal"><i class="fa fa-search"></i></button>
									</div>
									<?php echo $fields['solicitante']['form']; ?>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['apellido']['label']; ?>
								<?php echo $fields['apellido']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['nombre']['label']; ?>
								<?php echo $fields['nombre']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['mail']['label']; ?>
								<?php echo $fields['mail']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['telefono']['label']; ?>
								<?php echo $fields['telefono']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['distrito']['label']; ?>
								<?php echo $fields['distrito']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['calle']['label']; ?>
								<?php echo $fields['calle']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['numero']['label']; ?>
								<?php echo $fields['numero']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['manzana']['label']; ?>
								<?php echo $fields['manzana']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['casa']['label']; ?>
								<?php echo $fields['casa']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['numero_luminaria']['label']; ?>
								<?php echo $fields['numero_luminaria']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields['estado']['label']; ?>
								<?php echo $fields['estado']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<?php echo $fields['tarea']['label']; ?>
								<?php echo $fields['tarea']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<?php echo $fields['descripcion']['label']; ?>
								<?php echo $fields['descripcion']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<?php echo $fields['observaciones']['label']; ?>
								<?php echo $fields['observaciones']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<label class="control-label">Agregar Foto/s:</label>
								<input id="archivos" name="archivos[]" multiple type="file" accept="image/*" class="file-loading">
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="reclamos/reclamos/listar" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit(array('class' => 'btn btn-primary pull-right', 'title' => ($txt_btn === 'Editar' ? 'Grabar' : $txt_btn)), ($txt_btn === 'Editar' ? 'Grabar' : $txt_btn)) : ''; ?>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Eliminar') ? form_hidden('id', $reclamo->id) : ''; ?>
					</div>
					<?php echo $fields['lat_mapa']['form']; ?>
					<?php echo $fields['long_mapa']['form']; ?>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_solicitante_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar Solicitante</h4>
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
<div class="modal fade" id="dialog_form_avisos">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Aviso</h4>
			</div>
			<div class="modal-body">
				<div id="aviso_msj">Aviso</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>