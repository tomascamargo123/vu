<script>
	$(document).ready(function() {
		$('#texto').ckeditor();
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Plantillas
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title">Administración de plantilla</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['agregar']; ?>" href="expedientes/plantillas/agregar">
							<i class="fa fa-plus" id="btn-agregar"></i> Agregar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="expedientes/plantillas/ver/<?php echo (!empty($plantilla->id)) ? $plantilla->id : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['editar']; ?>" href="expedientes/plantillas/editar/<?php echo (!empty($plantilla->id)) ? $plantilla->id : ''; ?>">
							<i class="fa fa-edit" id="btn-editar"></i> Editar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['eliminar']; ?>" href="expedientes/plantillas/eliminar/<?php echo (!empty($plantilla->id)) ? $plantilla->id : ''; ?>">
							<i class="fa fa-ban" id="btn-eliminar"></i> Eliminar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['formulario']; ?>" href="expedientes/plantillas/formulario/<?php echo (!empty($plantilla->id)) ? $plantilla->id : ''; ?>">
							<i class="fa fa-file-text-o" id="btn-formulario"></i> Formulario
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['vista_previa']; ?>" href="expedientes/plantillas/vista_previa/<?php echo (!empty($plantilla->id)) ? $plantilla->id : ''; ?>">
							<i class="fa fa-eye" id="btn-vista-previa"></i> Vista Previa
						</a>
						<?php foreach ($fields as $field): ?>
							<div class="form-group">
								<?php echo $field['label']; ?>
								<?php echo $field['form']; ?>
							</div>
						<?php endforeach; ?>
                                            <label for="firmapad">Posee firma con pad</label><br>
                                            <input type="number" id="firmapad" class="form-control" name="firmapad" value="<?= (!empty($plantilla) && $plantilla->firmapad > 0 ? $plantilla->firmapad : '0')?>"/>
						<div class="form-group">
							<label for="digital">Dinámico: </label>
							<input type="checkbox" name="dinamica" id="dinamica" <?= (isset($plantilla->dinamica) ? ($plantilla->dinamica == '0' ? "" : "checked") : "")?>>
						</div>
				
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="javascript:window.history.back();" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo ($txt_btn === 'Guardar' || $txt_btn === 'Eliminar') ? form_hidden('id', $plantilla->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div> 