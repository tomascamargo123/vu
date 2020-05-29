<script>
	function confirmar_firma_abm(archivoadjunto, id){
		<?php #echo base_url("expedientes/archivos_adjuntos/download_jnlp/".$firma->archivo_adjunto_id."/".$firma->id); ?>
		console.log(archivoadjunto + ' ' + id);
		var password = $('input[name="password"]').val();
		if(password === ''){
			alert('Ingrese una contraseña');
		} else {
			$.post('expedientes/archivos_adjuntos/confirmar_firma', {
				password : password,
			}).done(function(data){
				if(data === 'Valido'){
					location.href = "./expedientes/archivos_adjuntos/download_jnlp/"+archivoadjunto+"/"+id;
				} else {
					alert('Contraseña incorrecta');
				}
			});
		}
	}

	function activar_firma(id) {
		$('#firma_id').val(id);
	}
	function rechazar_firma(id) {
		$('#rechazar_firma_id').val(id);
	}
	function mostrar_motivo_rechazo(motivo_rechazo) {
		$('#motivo_rechazo').html(motivo_rechazo);
		$('#motivo_rechazo_modal').modal();
	}
	$(document).ready(function() {
		$('#tbl_firmas').dataTable({
			paging: false,
			searching: false,
			sort: false,
			responsive: true,
			language: {"url": "plugins/datatables/spanish.json"}
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Archivos adjuntos
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/expedientes">Expedientes</a></li>
			<li><a href="expedientes/expedientes/ver/<?php echo $expediente->id; ?>">Ver expediente <?php echo "$expediente->numero / $expediente->ano - $expediente->anexo"; ?></a></li>
			<li><a href="expedientes/archivos_adjuntos/listar/<?php echo $expediente->id; ?>">Archivos adjuntos</a></li>
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
						<h3 class="box-title">Archivo adjunto</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<div class="row">
							<?php foreach ($fields as $field): ?>
								<div class="form-group col-md-6 col-sm-6">
									<div class="row">
										<div class="col-sm-4">
											<?php echo $field['label']; ?>
										</div>
										<div class="col-sm-8">
											<?php echo $field['form']; ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="form-group">
							<label>Archivo</label>
							<p class="form-control-static">
								<a target="_blank" href="expedientes/archivos_adjuntos/vista_preliminar/<?php echo $archivo_adjunto->id; ?>">Ver / Descargar</a>
							</p>
						</div>
						<div class="form-group">
							<label>Firmas</label>
						</div>
						<?php if (!empty($firmas)): ?>
							<table id="tbl_firmas" class="table table-hover table-bordered table-condensed">
								<thead>
									<tr>
										<th data-priority="1"></th>
										<th data-priority="6">Fecha Solicitud</th>
										<th data-priority="5">Solicitado por</th>
										<th data-priority="1">Firmante</th>
										<th data-priority="4">Fecha</th>
										<th data-priority="2">Estado</th>
										<th data-priority="3">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($firmas as $firma): ?>
										<tr>
											<td></td>
											<td><?php echo (new DateTime($firma->fecha_solicitud))->format('d/m/Y H:i:s'); ?></td>
											<td><?php echo "$firma->first_name_s $firma->last_name_s ($firma->username_s)"; ?></td>
											<td><?php echo "$firma->first_name $firma->last_name ($firma->username)"; ?></td>
											<?php
											switch ($firma->estado)
											{
												case 'Realizada':
													echo '<td>' . (new DateTime($firma->fecha_firma))->format('d/m/Y H:i:s') . '</td>';
													echo '<td class="text-success text-bold">' . $firma->estado . '</td>';
													break;
												case 'Rechazada':
													echo '<td>' . (new DateTime($firma->fecha_rechazo))->format('d/m/Y H:i:s') . '</td>';
													echo '<td class="text-danger text-bold">' . $firma->estado . ' <a class="btn btn-sm btn-danger" onclick="javascript:mostrar_motivo_rechazo(\'' . html_escape($firma->motivo_rechazo) . '\');"><i class="fa fa-question"></i></a></td>';
													break;
												case 'Solicitada':
													echo '<td></td>';
													echo '<td class="text-bold">' . $firma->estado . '</td>';
													break;
											}
											?>
											<td>
												<?php if (isset($firma->firma)): ?>
													<span>
														<?php echo anchor("expedientes/archivos_adjuntos/descargar_firma/$firma->id", '<i class="fa fa-download"></i> Firma', 'class="btn btn-xs btn-' . ($firma->valida ? 'success' : 'danger') . '"'); ?>
													</span>
													<span>
														<?php echo anchor("expedientes/archivos_adjuntos/descargar_clave_publica/$firma->id", '<i class="fa fa-download"></i> Clave Pública', 'class="btn btn-xs btn-default"'); ?>
													</span>
												<?php elseif ($firma->usuario_id === $this->session->userdata('user_id') && $firma->estado === 'Solicitada'): ?>
                                                	<a class="btn btn-xs btn-success firmar-btn"  data-toggle="modal" data-target="#modal-confirmar" ><i class="fa fa-pencil"></i> Firmar</a>
													<a class="btn btn-xs btn-danger rechazar-btn" data-toggle="modal" data-target="#modal-rechazar" onclick="rechazar_firma(<?php echo $firma->id; ?>);"><i class="fa fa-ban"></i> Rechazar</a>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php endif; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/expedientes/ver/<?php echo $expediente->id; ?>" title="Volver">Volver</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Eliminar') ? form_hidden('id', $archivo_adjunto->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>

<div class="modal fade" id="modal-confirmar" tabindex="-1" role="dialog" style="margin-top: 50px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Ingrese contraseña para confirmar</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Contraseña</label>
					<input class="form-control" type="password" name="password"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="confirmar_firma_abm(<?= $firma->archivo_adjunto_id; ?>, <?= $firma->id; ?>)">Confirmar</button>
			</div>
		</div>
	</div>
</div>

	<div class="modal fade" id="modal-rechazar" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<?php echo form_open("expedientes/archivos_adjuntos/rechazar_firma/$archivo_adjunto->id"); ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ingrese motivo del rechazo de la firma</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Motivo</label>
						<input class="form-control" name="motivo_rechazo"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<input type="hidden" id="rechazar_firma_id" name="rechazar_firma_id" value="0">
					<?php echo form_submit(array('class' => 'btn btn-danger pull-right', 'title' => 'Rechazar'), 'Rechazar'); ?>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="motivo_rechazo_modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Motivo de rechazo de firma</h4>
			</div>
			<div class="modal-body">
				<p id="motivo_rechazo"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

});
</script>

