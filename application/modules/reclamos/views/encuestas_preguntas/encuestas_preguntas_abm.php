<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Preguntas de encuestas
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="reclamos/escritorio">Reclamos</a></li>
			<li><a href="reclamos/<?php echo $controlador; ?>">Preguntas de encuestas</a></li>
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
						<h3 class="box-title">Administración de preguntas de encuestas</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => ($txt_btn === 'Editar' ? 'Grabar' : $txt_btn)); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['agregar']; ?>" href="reclamos/encuestas_preguntas/agregar">
							<i class="fa fa-plus" id="btn-agregar"></i> Agregar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="reclamos/encuestas_preguntas/ver/<?php echo (!empty($encuestas_pregunta->id)) ? $encuestas_pregunta->id : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['editar']; ?>" href="reclamos/encuestas_preguntas/editar/<?php echo (!empty($encuestas_pregunta->id)) ? $encuestas_pregunta->id : ''; ?>">
							<i class="fa fa-edit" id="btn-editar"></i> Editar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['eliminar']; ?>" href="reclamos/encuestas_preguntas/eliminar/<?php echo (!empty($encuestas_pregunta->id)) ? $encuestas_pregunta->id : ''; ?>">
							<i class="fa fa-ban" id="btn-eliminar"></i> Eliminar
						</a>
						<?php foreach ($fields as $field): ?>
							<div class="form-group">
								<?php echo $field['label']; ?> 
								<?php echo $field['form']; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="reclamos/encuestas_preguntas/listar" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, ($txt_btn === 'Editar' ? 'Grabar' : $txt_btn)) : ''; ?>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Eliminar') ? form_hidden('id', $encuestas_pregunta->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>