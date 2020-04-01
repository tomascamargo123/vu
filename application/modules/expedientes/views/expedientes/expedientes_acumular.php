<script>
	var expedientes_table;
	$(document).ready(function() {
		$('#buscar_expediente_modal').on('shown.bs.modal', function() {
			expedientes_table.responsive.recalc();
		});
	});
	function acumular_expediente(id, numero, ano, anexo) {
		$('#lista_expedientes').append('<li>Expediente ' + numero + '/' + ano + '-' + anexo + '<input type="hidden" name="expedientes[]" value="' + id + '"> <button class="btn btn-danger btn-sm"onclick="$(this).parent().remove();">Quitar</button></li>');
                $("#row_"+id).parent("td").parent("tr").hide();
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Expedientes
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>/listar"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 style="vertical-align:middle;" class="box-title">Acumular Expediente</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['caratula']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php if (empty($expediente->persona_id)): ?>
											<?php echo $fields['caratula']['form']; ?>
										<?php else: ?>
											<div class="input-group">
												<input type="text" name="caratula" value="<?php echo $expediente->caratula; ?>" id="caratula" class="form-control" disabled="">
												<span class="input-group-btn">
													<a class="btn btn-primary" href="expedientes/personas/ver/<?php echo $expediente->persona_id; ?>"><i class="fa fa-search"></i></a>
												</span>
											</div>
										<?php endif; ?>
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
										<?php echo $fields['tramite']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['tramite']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['fojas']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['fojas']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['objeto']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['objeto']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-sm-12 text-center">
								<button type="button" id="btn_buscar_expediente" class="btn btn-warning" data-toggle="modal" data-target="#buscar_expediente_modal" onclick="busca_expediente = 'anexar';">Seleccionar expedientes a acumular</button>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<ul id="lista_expedientes">
								</ul>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo form_hidden('id', $expediente->id); ?>
						<a class="btn btn-default" href="javascript:window.history.back();" title="Volver">Volver</a>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_expediente_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar expediente</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_expedientes; ?>
				<?php echo $html_table_expedientes; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>