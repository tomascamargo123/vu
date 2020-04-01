<script>
	$(document).ready(function() {
		$('.duallistbox').bootstrapDualListbox({
			filterTextClear: 'mostrar todos',
			filterPlaceHolder: 'Filtrar',
			moveSelectedLabel: 'Asignar',
			moveAllLabel: 'Asignar todos',
			removeSelectedLabel: 'Quitar',
			removeAllLabel: 'Quitar todos',
			selectedListLabel: 'Asignados',
			nonSelectedListLabel: 'Disponibles',
			showFilterInputs: true,
			infoText: 'Mostrando todos {0}',
			infoTextFiltered: '<span class="label label-warning">Filtrados</span> {0} de {1}',
			infoTextEmpty: 'Lista vacía',
			filterOnValues: true,
                        sortByInputOrder: false
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Usuarios
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
						<h3 class="box-title">Administración de usuario</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<a class="btn btn-app btn-app-zetta <?php echo $class['ver']; ?>" href="usuarios/verig/<?php echo (!empty($usuario->CodiUsua)) ? $usuario->CodiUsua : ''; ?>">
							<i class="fa fa-search" id="btn-ver"></i> Ver
						</a>
						<a class="btn btn-app btn-app-zetta <?php echo $class['editar']; ?>" href="usuarios/editarig/<?php echo (!empty($usuario->CodiUsua)) ? $usuario->CodiUsua : ''; ?>">
							<i class="fa fa-edit" id="btn-editar"></i> Editar
						</a>
						<div class="form-group">
							<?php echo $fields['username']['label']; ?>
							<?php echo $fields['username']['form']; ?>
						</div>
						<div class="tabs-x align-center tabs-above tab-bordered">
							<ul class="nav nav-tabs">
								<li id="li_tab_usuario" class="active">
									<a href="#tab_usuario" data-toggle="tab">
										<i class="fa fa-user"></i> Usuario
									</a>
								</li>
								<li id="li_tab_reclamos" class="">
									<a href="#tab_reclamos" data-toggle="tab">
										<i class="fa fa-warning"></i> Reclamos
									</a>
								</li>
								<li id="li_tab_expedientes" class="">
									<a href="#tab_expedientes" data-toggle="tab">
										<i class="fa fa-file-text"></i> Expedientes
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_usuario">
									<div class="form-group">
										<?php echo $fields['first_name']['label']; ?>
										<?php echo $fields['first_name']['form']; ?>
									</div>
									<div class="form-group">
										<?php echo $fields['last_name']['label']; ?>
										<?php echo $fields['last_name']['form']; ?>
									</div>
									<div class="form-group">
										<?php echo $fields['email']['label']; ?>
										<?php echo $fields['email']['form']; ?>
									</div>
									<div class="form-group">
										<?php echo $fields['last_login']['label']; ?>
										<?php echo $fields['last_login']['form']; ?>
									</div>
									<div class="form-group">
										<?php echo $fields['groups']['label']; ?>
										<?php echo $fields['groups']['form']; ?>
									</div>
								</div>
								<div class="tab-pane" id="tab_expedientes">
									<div class="form-group">
										<?php echo $fields['exp_oficinas']['label']; ?>
										<?php echo $fields['exp_oficinas']['form']; ?>
									</div>
								</div>
								<div class="tab-pane" id="tab_reclamos">
									<div class="form-group">
										<?php echo $fields['rec_grupos']['label']; ?>
										<?php echo $fields['rec_grupos']['form']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="usuarios/listar" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo $txt_btn === 'Editar' ? form_hidden('id', $usuario->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>