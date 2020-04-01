<script>
	var startDate = "<?php echo $desde; ?>";
	var endDate = "<?php echo $hasta; ?>";
	var maxDate = "<?php echo $hasta; ?>";
	$(document).ready(function() {
		$('#inicio_reclamos').on('apply.daterangepicker', function(ev, picker) {
			filtrar_graficos_reportes();
		});
		$('#sector').change(function() {
			filtrar_graficos_reportes();
		});
		$('#grupo').change(function() {
			filtrar_graficos_reportes();
		});
		$('#distrito').change(function() {
			filtrar_graficos_reportes();
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Gráficos
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
			<div class="col-lg-8 col-md-7">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Reclamos por fecha</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body border-radius-none">
						<div class="chart">
							<?php echo $linechartreclamos; ?>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer no-border">
						<div class="row">
							<script>
								$(function() {
									$(".knob").knob();
								});
							</script>
							<div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
								<input type="text" id="knob-reclamos-pendiente" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['Pendiente']) ? $reclamos_estado['Pendiente'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#dd4b39">
								<div class="knob-label">Pendiente</div>
							</div><!-- ./col -->
							<div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
								<input type="text" id="knob-reclamos-en-proceso" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['En Proceso']) ? $reclamos_estado['En Proceso'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#f39c12">
								<div class="knob-label">En proceso</div>
							</div><!-- ./col -->
							<div class="col-xs-3 text-center">
								<input type="text" id="knob-reclamos-finalizados" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['Finalizado']) ? $reclamos_estado['Finalizado'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#00a65a">
								<div class="knob-label">Finalizados</div>
							</div><!-- ./col -->
							<div class="col-xs-3 text-center">
								<input type="text" id="knob-reclamos-anulados" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['Anulado']) ? $reclamos_estado['Anulado'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#969696">
								<div class="knob-label">Anulados</div>
							</div><!-- ./col -->
						</div><!-- /.row -->
					</div><!-- /.box-footer -->
				</div><!-- /.box -->
			</div>
			<div class="col-lg-4 col-md-5">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title" id="titulo_grafico_3">Reclamos detalle por sector</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body border-radius-none">
						<div class="col-md-12">
							<div class="chart-responsive">
								<?php echo $piechartsectores; ?>
							</div><!-- ./chart-responsive -->
						</div>
						<div class="col-md-12">
							<div id="piechartsectores-legend"></div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer no-border">
						<div class="row">
							<div class="col-md-12" id="chart-legend" ></div>
						</div><!-- /.row -->
					</div><!-- /.box-footer -->
				</div><!-- /.box -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title" id="titulo_grafico_4">Reclamos finalizados por sector</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $barchartvencimiento; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Resultado encuestas</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $barchartsatisfaccion; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title" id="titulo_grafico_6">Reclamos detalle por sector</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $barchartsectores; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>