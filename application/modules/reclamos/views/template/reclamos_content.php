<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Gestión de Reclamos<small style="color:#000"> Versión Beta</small>
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
			<?php echo $accesos; ?>
		</div>
		<div class="row">
			<section class="col-lg-8 col-md-7">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Reclamos por día (últimos 7 días)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body border-radius-none">
						<div class="chart">
							<?php echo $linechart; ?>
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
								<input type="text" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['Pendiente']) ? $reclamos_estado['Pendiente'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#dd4b39">
								<div class="knob-label">Pendiente</div>
							</div><!-- ./col -->
							<div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
								<input type="text" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['En Proceso']) ? $reclamos_estado['En Proceso'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#f39c12">
								<div class="knob-label">En proceso</div>
							</div><!-- ./col -->
							<div class="col-xs-3 text-center">
								<input type="text" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['Finalizado']) ? $reclamos_estado['Finalizado'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#00a65a">
								<div class="knob-label">Finalizados</div>
							</div><!-- ./col -->
							<div class="col-xs-3 text-center">
								<input type="text" class="knob" data-readonly="true" value="<?php echo isset($reclamos_estado['Anulado']) ? $reclamos_estado['Anulado'] : 0; ?>" data-width="60" data-height="60" data-fgColor="#969696">
								<div class="knob-label">Anulados</div>
							</div><!-- ./col -->
						</div><!-- /.row -->
					</div><!-- /.box-footer -->
				</div><!-- /.box -->
			</section>
			<section class="col-lg-4 col-md-5">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Reclamos por sector (últimos 7 días)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body border-radius-none">
						<div class="col-md-12">
							<div class="chart-responsive">
								<?php echo $piechart; ?>
							</div><!-- ./chart-responsive -->
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer no-border">
						<div class="row">
							<div class="col-md-12" id="chart-legend" ></div>
						</div><!-- /.row -->
					</div><!-- /.box-footer -->
				</div><!-- /.box -->
			</section>
		</div>
		<div class="row">
			<section class="col-lg-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Reclamos (últimos 7 días)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body border-radius-none">
						<div id="map-reclamos" style="height:500px;"></div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</section>
		</div>
	</section>
</div>