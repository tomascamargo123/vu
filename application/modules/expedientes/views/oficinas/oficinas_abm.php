<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Oficinas
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
						<h3 class="box-title">Administración de oficina</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['agregar']; ?>" href="expedientes/oficinas/agregar">
							<i class="fa fa-plus" id="btn-agregar"></i> Agregar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="expedientes/oficinas/ver/<?php echo (!empty($oficina->id)) ? $oficina->id : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['editar']; ?>" href="expedientes/oficinas/editar/<?php echo (!empty($oficina->id)) ? $oficina->id : ''; ?>">
							<i class="fa fa-edit" id="btn-editar"></i> Editar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['deshabilitar']; ?>" href="expedientes/oficinas/deshabilitar/<?php echo (!empty($oficina->id)) ? $oficina->id : ''; ?>">
							<i class="fa fa-ban" id="btn-eliminar"></i> Deshabilitar
						</a>
						<?php foreach ($fields as $field): ?>
							<div class="form-group">
								<?php echo $field['label']; ?> 
								<?php echo $field['form']; ?>
							</div>
						<?php endforeach; ?>
						<?php if($txt_btn != 'Aceptar'){ ?>
							<div class="form-group">
								<label for="inicia_expediente">Emisora de pases: </label>
								<input type="checkbox" name="emisora_pase" id="emisora_pase" <?= (isset($oficina) ? (isset($editar) ? ($oficina->emisora_pase > 0 ? "checked" : "") : ($oficina->emisora_pase > 0 ? "checked disabled" : "disabled")) : ""); ?>>
							</div>
							<div class="form-group">
								<label for="inicia_expediente">Receptora de pases: </label>
								<input type="checkbox" name="receptora_pase" id="receptora_pase" <?= (isset($oficina) ? (isset($editar) ? ($oficina->receptora_pase > 0 ? "checked" : "") : ($oficina->receptora_pase > 0 ? "checked disabled" : "disabled")) : ""); ?>>
							</div>
							<div class="form-group">
								<label for="inicia_expediente">Inicia Expediente: </label>
								<input type="checkbox" name="inicia_expediente" id="inicia_expediente" <?= (isset($oficina) ? (isset($editar) ? ($editar > 0 ? "checked" : "") : ($oficina->inicia_expediente > 0 ? "checked disabled" : "disabled")) : ""); ?>>
							</div>
						<?php } else { ?>
							<div class="form-group">
								<label for="estado" class="control-label">Estado</label>
								<select name="estado" class="form-control" id="estado">
									<option value='A'>Habilitada</option>
									<option value='B' <?= ($oficina->proceso_usuario == 'B' ? 'selected="true"' : '') ?>>Deshabilitada</option>
								</select>
							</div>
						<?php } ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/oficinas/listar" title="Cancelar">Cancelar</a>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Aceptar') ? form_hidden('id', $oficina->id) : ''; ?>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>