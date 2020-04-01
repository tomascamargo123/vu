<script>
	var editable = <?php echo (isset($txt_btn) && $txt_btn === 'Editar') ? 'true' : 'false'; ?>;
	var options, a;
	var centro = null;
	var solicitantes_table;
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	});
	$(document).ready(function() {
		actualizar_tipo_solicitante();
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
		$('#estado').change(function() {
			actualizar_estado();
		});
<?php if (isset($txt_btn) && $txt_btn === 'Editar'): ?>
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
<?php endif; ?>
		$('#buscar_solicitante_modal').on('shown.bs.modal', function() {
			solicitantes_table.responsive.recalc();
		});
	});
</script>
<?php $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"); ?>
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
								<?php if (isset($txt_btn) && $txt_btn === 'Editar'): ?>
									<div class="input-group">
										<?php echo $fields['solicitante']['form']; ?>
										<?php if (empty($reclamo->solicitante_id)): ?>
											<div class="input-group-btn">
												<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#buscar_solicitante_modal"><i class="fa fa-search"></i></button>
											</div>
										<?php else: ?>
											<div class="input-group-btn">
												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a data-toggle="modal" data-target="#buscar_solicitante_modal"><i class="fa fa-search"></i>Buscar</a></li>
													<li><a onclick="window.open('reclamos/solicitantes/ver/<?php echo $reclamo->solicitante_id; ?>', '_blank');"><i class="fa fa-edit"></i>Editar</a></li>
													<li><a onclick="habilitar_solicitante();"><i class="fa fa-remove"></i>Anónimo</a></li>
												</ul>
											</div>
										<?php endif; ?>
									</div>
								<?php else: ?>
									<?php echo $fields['solicitante']['form']; ?>
								<?php endif; ?>
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
								<?php echo $fields['fecha_finalizacion']['label']; ?>
								<?php echo $fields['fecha_finalizacion']['form']; ?>
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
							<?php if (isset($txt_btn) && $txt_btn === 'Editar'): ?>
								<div class="form-group col-md-9 col-sm-12 col-xs-12">
									<?php echo $fields['observaciones']['label']; ?>
									<?php echo $fields['observaciones']['form']; ?>
								</div>
								<div class="form-group col-md-offset-3 col-md-9 col-sm-12 col-xs-12">
									<?php echo $fields['resolucion']['label']; ?>
									<?php echo $fields['resolucion']['form']; ?>
								</div>
								<div class="form-group col-md-offset-3 col-md-9 col-sm-12 col-xs-12">
									<label class="control-label">Agregar Foto/s:</label>
									<input id="archivos" name="archivos[]" multiple type="file" accept="image/*" class="file-loading">
								</div>
							<?php else: ?>
								<div class="form-group col-md-9 col-sm-12 col-xs-12">
									<?php echo $fields['resolucion']['label']; ?>
									<?php echo $fields['resolucion']['form']; ?>
								</div>
							<?php endif; ?>
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
		<?php if (!empty($timeline)): ?>
			<div class="row">
				<div class="col-xs-12">
					<ul class="timeline">
						<?php $last_date = ''; ?>
						<?php foreach ($timeline as $time => $line): ?>
							<?php $date = date_format(new DateTime($time), 'd M Y'); ?>
							<?php if ($last_date !== $date): ?>
								<li class="time-label">
									<span class="bg-lavalle">
										<?php echo date_format(new DateTime($time), 'd') . " " . $meses[date_format(new DateTime($time), 'n') - 1] . " " . date_format(new DateTime($time), 'Y'); ?>
									</span>
								</li>
								<?php $last_date = $date; ?>
							<?php endif; ?>
							<?php if (!empty($line['archivos'])): ?>
								<li>
									<i class="fa fa-camera bg-purple"></i>
									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> <?php echo date_format(new DateTime($time), 'H:i'); ?></span>
										<h3 class="timeline-header"><?php echo "{$line['archivos'][0]->first_name} {$line['archivos'][0]->last_name} ({$line['archivos'][0]->grupo})"; ?> adjuntó nuevas imágenes</h3>
										<div class="timeline-body">
											<?php foreach ($line['archivos'] as $archivo): ?>
												<a href="reclamos/reclamos/get_image/<?php echo $archivo->ruta; ?>" data-toggle="lightbox" data-gallery="imgreclamo" data-title='<?php echo "{$line['archivos'][0]->first_name} {$line['archivos'][0]->last_name} ({$line['archivos'][0]->grupo})"; ?>' data-footer='<span style="float:left;"><?php echo $date; ?></span><span><i class="fa fa-clock-o"></i> <?php echo date_format(new DateTime($time), 'H:i'); ?></span>'>
													<img style="max-height:100px;" src="reclamos/reclamos/get_image/<?php echo $archivo->ruta; ?>"/>
												</a>
											<?php endforeach; ?>
										</div>
									</div>
								</li>
							<?php endif; ?>
							<?php if (!empty($line['observaciones'])): ?>
								<?php foreach ($line['observaciones'] as $observacion): ?>
									<li>
										<i class="<?php echo $observacion->icono; ?>"></i>
										<div class="timeline-item">
											<span class="time"><i class="fa fa-clock-o"></i> <?php echo date_format(new DateTime($observacion->fecha), 'H:i'); ?></span>
											<h3 class="timeline-header"><?php echo "$observacion->first_name $observacion->last_name ($observacion->grupo)"; ?></h3>
											<div class="timeline-body">
												<?php echo $observacion->observacion; ?>
											</div>
										</div>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
	</section>
</div>
<?php if (isset($txt_btn) && $txt_btn === 'Editar'): ?>
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
<?php endif; ?>
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