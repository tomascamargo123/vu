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
						<h3 class="box-title">Filtros</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Sector', 'sector', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('sector', $sector_opt, $sector_opt_selected, 'class="form-control" id="sector"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Estado', 'estado', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('estado', $estado_opt, $estado_opt_selected, 'class="form-control" id="estado"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6">
								<div class="form-group">
									<?php echo form_label('Grupo', 'grupo', array('class' => 'control-label')); ?>
									<?php echo form_dropdown('grupo', $grupo_opt, $grupo_opt_selected, 'class="form-control" id="grupo"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6">
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
						<h3 class="box-title">Listado de reclamos</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $js_table; ?>
						<?php echo $html_table; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-primary pull-right" href="reclamos/reclamos/agregar" title="Agregar reclamo">Agregar reclamo</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>