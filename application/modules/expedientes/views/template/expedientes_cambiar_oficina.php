<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Cambio de oficina
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active">Cambiar oficina</li>
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
						<h3 class="box-title">Seleccione la oficina sobre la que desea trabajar</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body border-radius-none">
						<?php echo form_open(uri_string(), array('data-toggle' => 'validator', 'id' => 'cambiar_oficina')); ?>
						<div class="row">
							<div class="form-group col-md-12">
								<?php echo form_label('Oficina', 'oficina', array('class' => 'control-label')); ?>
								<?php echo form_dropdown('oficina', $oficina_opt, $oficina_opt_selected, 'class="form-control" id="oficina" onchange="cambiarOficina();"'); ?>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<a class="btn btn-default pull-right" href="expedientes/escritorio" title="Ir al inicio">Ir al inicio</a>
					</div>
				</div><!-- /.box -->
			</div>
		</div>
	</section>
</div>

<script>
function cambiarOficina(){
	localStorage.clear();
	$('#cambiar_oficina').submit();
}
</script>