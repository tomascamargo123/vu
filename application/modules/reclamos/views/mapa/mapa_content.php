<script>
	var tipo = '<?php echo $tipo_mapa_opt_selected; ?>';
	var startDate = "<?php echo $desde; ?>";
	var endDate = "<?php echo $hasta; ?>";
	var maxDate = "<?php echo $hasta; ?>";
	$(document).ready(function() {
		actualizar_motivos('list');
		$('#tipo_mapa').change(function() {
			tipo = $('#tipo_mapa').val();
			filtrarFiguras();
		});
		$('#inicio_reclamos').on('apply.daterangepicker', function(ev, picker) {
			filtrarFiguras();
		});
		$('#sector').change(function() {
			actualizar_motivos('map');
		});
		$('#motivo').change(function() {
			filtrarFiguras();
		});
		$('#estado').change(function() {
			filtrarFiguras();
		});
		$('#grupo').change(function() {
			filtrarFiguras();
		});
		$('#distrito').change(function() {
			filtrarFiguras();
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Mapa de reclamos
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
						<h3 class="box-title">Filtros</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Tipo de mapa', 'tipo_mapa', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('tipo_mapa', $tipo_mapa_opt, $tipo_mapa_opt_selected, 'class="form-control" id="tipo_mapa"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Inicio reclamo', 'inicio_reclamos', array('class' => 'control-label')); ?>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<?php echo form_input($inicio_reclamos); ?>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Sector', 'sector', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('sector', $sector_opt, $sector_opt_selected, 'class="form-control" id="sector"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Motivo', 'motivo', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('motivo', $motivo_opt, $motivo_opt_selected, 'class="form-control" id="motivo"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Estado', 'estado', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('estado', $estado_opt, $estado_opt_selected, 'class="form-control" id="estado"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Grupo', 'grupo', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('grupo', $grupo_opt, $grupo_opt_selected, 'class="form-control" id="grupo"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Distrito', 'distrito', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('distrito', $distrito_opt, $distrito_opt_selected, 'class="form-control" id="distrito"'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Mapa de reclamos</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div id="map-reclamos" style="min-height:500px;"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php echo form_input($figuras); ?>