<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Asignar usuario revisor
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title">Administración de requerimiento</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['agregar']; ?>" href=<?php echo !isset($admin) ? "revisor_firmante/agregar" : "requerimientos/agregar_personales" ?>>
							<i class="fa fa-plus" id="btn-agregar"></i> Agregar
						</a>
						<?php if(!isset($admin)): ?>
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="revisor_firmante/ver/<?php echo (!empty($requerimientos->id)) ? $requerimientos->id : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<?php endif; ?>
						<a class="btn btn-app btn-app-zetta <?php echo $class['editar']; ?>" href="revisor_firmante/<?php echo !isset($admin) ? "editar" : "editar_personales" ?>/<?php echo (!empty($requerimientos->id)) ? $requerimientos->id : ''; ?>">
							<i class="fa fa-edit" id="btn-editar"></i> Editar
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['eliminar']; ?>" href="revisor_firmante/<?php echo !isset($admin) ? "eliminar" : "eliminar_personales" ?>/<?php echo (!empty($requerimientos->id)) ? $requerimientos->id : ''; ?>">
							<i class="fa fa-ban" id="btn-eliminar"></i> Eliminar
						</a>
                        <div class="form-group">
							<?php if(isset($editar)): ?>
								<input type="hidden" value="<?php echo $firmantes[0]['id'] ?>" name="firmantes">
							<?php endif; ?>
                            <label for="firmantes" >Firmantes</label>
                            <select class="form-control" name="firmantes" onchange="get_revisores()" <?= (isset($editar) ? 'disabled' : '') ?>>
								<?php if(!isset($editar)): ?>
									<option value="0">-- Seleccione un firmante --</option>
								<?php endif; ?>
                                <?php if(isset($firmantes)): ?>
                                    <?php foreach ($firmantes as $firmante) { ?>
                                        <option value="<?php echo $firmante['id'] ?>"><?php echo $firmante['nombre'] ?></option>
                                    <?php } ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="revisores">Revisores</label>
                            <select class="form-control" name="revisores" id="select_revisores">
                                <option value="0">-- Seleccione un firmante --</option>
                            </select>
                        </div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href= <?php echo !isset($admin) ? "requerimientos/listar" : "requerimientos/listar_personales" ?> title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo ($txt_btn === 'Guardar' || $txt_btn === 'Eliminar') ? form_hidden('id', $id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
	function get_revisores(){
		var id_firmante = $('select[name="firmantes"]').val();
		$.post('./revisor_firmante/get_revisores', {
			id_firmante: id_firmante,
		}).done(function(data){
			var revisores = JSON.parse(data);
			$('#select_revisores').empty();
			$.each(revisores, function(index, val){
				console.log(val);
				var option = document.createElement('option');
				option.innerHTML = val.nombre;
				option.setAttribute('value', val.id);
				$('#select_revisores').append(option);
				console.log(option);
			});
		});
	}
	<?php if(isset($editar)):	?>
		$(document).ready(function(){
			get_revisores();
		});
	<?php endif; ?>
</script>