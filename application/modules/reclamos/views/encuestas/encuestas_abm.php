<script>
	var editable = false;
	var options, a;
	var centro = null;
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	});
	$(function() {
		$(".slider").ionRangeSlider({
			type: "single",
			min: 1,
			max: 10,
			step: 1,
<?php echo (empty($txt_btn)) ? 'disable: true,' : ''; ?>
			grid: true,
			grid_snap: true
		});
	});
</script>
<?php $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Encuestas
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
						<h3 class="box-title">Administración de encuesta</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => ($txt_btn === 'Editar' ? 'Grabar' : $txt_btn)); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['agregar']; ?>" href="reclamos/encuestas/listar">
							<i class="fa fa-plus" id="btn-agregar"></i> Agregar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="reclamos/encuestas/ver/<?php echo (!empty($encuesta->id)) ? $encuesta->id : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<?php
						foreach ($preguntas as $Pregunta)
						{
							if (empty($Pregunta->puntaje))
							{
								$Pregunta->puntaje = 1;
							}
							echo "<div class='form-group'>";
							echo "<label for='$Pregunta->id'>$Pregunta->pregunta</label>";
							echo "<input id='pregunta_$Pregunta->id' class='slider' type='text' name='pregunta_$Pregunta->id' value='$Pregunta->puntaje'>";
							echo "</div>";
						}
						?>
						<?php foreach ($fields as $field): ?>
							<div class="form-group">
								<?php echo $field['label']; ?> 
								<?php echo $field['form']; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="reclamos/encuestas/listar" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, ($txt_btn === 'Editar' ? 'Grabar' : $txt_btn)) : ''; ?>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Eliminar') ? form_hidden('id', $encuesta->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Reclamo a encuestar</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<div id="map" class="map-reclamos">
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['fecha_inicio']['label']; ?>
								<?php echo $fields_reclamo['fecha_inicio']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['prioridad']['label']; ?>
								<?php echo $fields_reclamo['prioridad']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['vencimiento']['label']; ?>
								<?php echo $fields_reclamo['vencimiento']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['sector']['label']; ?>
								<?php echo $fields_reclamo['sector']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['motivo']['label']; ?>
								<?php echo $fields_reclamo['motivo']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['grupo']['label']; ?>
								<?php echo $fields_reclamo['grupo']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['solicitante']['label']; ?>
								<?php if (isset($txt_btn) && $txt_btn === 'Editar'): ?>
									<div class="input-group">
										<?php echo $fields_reclamo['solicitante']['form']; ?>
										<div class="input-group-btn">
											<button type="button" class="btn btn-warning" onclick="window.open('reclamos/solicitantes/ver/<?php echo $reclamo->solicitante_id; ?>', '_blank');"><i class="fa fa-edit"></i></button>
										</div>
									</div>
								<?php else: ?>
									<?php echo $fields_reclamo['solicitante']['form']; ?>
								<?php endif; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['apellido']['label']; ?>
								<?php echo $fields_reclamo['apellido']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['nombre']['label']; ?>
								<?php echo $fields_reclamo['nombre']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['mail']['label']; ?>
								<?php echo $fields_reclamo['mail']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['telefono']['label']; ?>
								<?php echo $fields_reclamo['telefono']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['estado']['label']; ?>
								<?php echo $fields_reclamo['estado']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['distrito']['label']; ?>
								<?php echo $fields_reclamo['distrito']['form']; ?>
							</div>
							<div class="form-group col-md-6 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['calle']['label']; ?>
								<?php echo $fields_reclamo['calle']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['numero']['label']; ?>
								<?php echo $fields_reclamo['numero']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['manzana']['label']; ?>
								<?php echo $fields_reclamo['manzana']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['casa']['label']; ?>
								<?php echo $fields_reclamo['casa']['form']; ?>
							</div>
							<div class="form-group col-md-3 col-sm-6 col-xs-12">
								<?php echo $fields_reclamo['fecha_finalizacion']['label']; ?>
								<?php echo $fields_reclamo['fecha_finalizacion']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<?php echo $fields_reclamo['tarea']['label']; ?>
								<?php echo $fields_reclamo['tarea']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<?php echo $fields_reclamo['descripcion']['label']; ?>
								<?php echo $fields_reclamo['descripcion']['form']; ?>
							</div>
							<div class="form-group col-md-9 col-sm-12 col-xs-12">
								<?php echo $fields_reclamo['resolucion']['label']; ?>
								<?php echo $fields_reclamo['resolucion']['form']; ?>
							</div>
						</div>
					</div>
					<?php echo $fields_reclamo['lat_mapa']['form']; ?>
					<?php echo $fields_reclamo['long_mapa']['form']; ?>
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
												<a href="reclamos/encuestas/get_image/<?php echo $archivo->ruta; ?>" data-toggle="lightbox" data-gallery="imgreclamo" data-title='<?php echo "{$line['archivos'][0]->first_name} {$line['archivos'][0]->last_name} ({$line['archivos'][0]->grupo})"; ?>' data-footer='<span style="float:left;"><?php echo $date; ?></span><span><i class="fa fa-clock-o"></i> <?php echo date_format(new DateTime($time), 'H:i'); ?></span>'>
													<img style="max-height:100px;" src="reclamos/encuestas/get_image/<?php echo $archivo->ruta; ?>"/>
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