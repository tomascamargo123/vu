<script>
	function confirmar_accion() {
		if (!$("#btn_submit").hasClass('disabled')) {
			$('#confirmacion_nota_modal').modal();
		}
	}
	function adjuntar_nota() {
		$('#form_pase').submit();
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Notas de pases
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>/agregar">Notas de pases</a></li>
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
						<h3 class="box-title"><?php echo ($txt_btn === 'Editar') ? 'Modificar' : 'Adjuntar'; ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator', 'id' => 'form_pase')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['fecha']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['fecha']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['numero']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['numero']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['ano']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['ano']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['anexo']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['anexo']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['oficina_origen']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['oficina_origen']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['contenido']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['contenido']['form']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/pases/listar_pendientes_e" title="Cancelar">Cancelar</a>
						<button onclick="javascript:confirmar_accion();" id="btn_submit" type="button" class="btn btn-primary pull-right">Guardar</button>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Eliminar') ? form_hidden('id', $nota_pase->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="confirmacion_nota_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Advertencia</h4>
			</div>
			<div class="modal-body">
				<p>¿Desea adjuntar esta nota?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
				<button onclick="javascript:adjuntar_nota();" type="button" class="btn btn-primary pull-right">Aceptar</button>
			</div>
		</div>
	</div>
</div>