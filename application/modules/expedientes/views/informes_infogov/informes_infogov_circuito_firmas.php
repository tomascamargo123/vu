<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Informes Infogov
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>">Informes Infogov</a></li>
			<li class="active">Circuito de Firmas</li>
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
						<h3 class="box-title">Administración de informe Infogov</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta active btn-app-zetta-active" href="expedientes/informes_infogov/circuito_firmas/<?php echo $informe_infogov->id; ?>">
							<i class="fa fa-circle" id="btn-circuto-firmas"></i> Circuito de Firmas
						</a>
						<div class="form-group">
							<?php echo $fields['nombre']['label']; ?>
							<?php echo $fields['nombre']['form']; ?>
						</div>
						<?php echo $js_table; ?>
						<?php echo $html_table; ?>
						<?php echo form_open(base_url("expedientes/informes_infogov/circuito_firmas_add/$informe_infogov->id"), array('data-toggle' => 'validator')); ?>
						<div class="form-group">
							<label for="cargo">Agregar firma a circuito</label>
							<span class="input-group">
								<?php echo form_dropdown('cargo', $array_cargo, 0, 'class="form-control"'); ?>
								<span class="input-group-btn"><button class="btn btn-primary" type="submit" name="action" value="Agregar">Agregar</button></span>
							</span>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/informes_infogov/listar" title="Cancelar">Cancelar</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>