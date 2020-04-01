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
						<h3 class="box-title">Perfil de usuario</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => 'Guardar'); ?>
					<?php echo form_open('usuarios/perfil'); ?>
					<div class="box-body">
						<div class="form-group">
							<?php echo form_label('Antigua contraseña', 'old'); ?>
							<?php echo form_input($old_password); ?>
						</div>
						<div class="form-group">
							<?php echo form_label("Nueva contraseña (de al menos $min_password_length caracteres de longitud)", 'new'); ?>
							<?php echo form_input($new_password); ?>
						</div>
						<div class="form-group">
							<?php echo form_label('Confirmar nueva contraseña', 'new'); ?>
							<?php echo form_input($new_password_confirm); ?>
						</div>
					</div>
					<div class="box-footer">
						<?php echo form_input($user_id); ?>
						<a class="btn btn-default" href="" title="Cancelar">Cancelar</a>
						<?php echo form_submit($data_submit, 'Guardar'); ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>