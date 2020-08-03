<script>
	function mostrar_nota(nota) {
		$('#contenido_nota').html(nota);
		$('#contenido_nota_modal').modal();
	}

	function subir(btn){
		var fila = $(btn).parent().parent();
		var val1 = $(fila).find('td:first-child').html();
		if (val1 > 1) {
			var id1 = $(fila).attr('id');
			var id2 = 0;
			var val2 = parseInt(val1)-1;
			console.log(val1+' '+val2);
			var tabla = document.getElementById("tbl_adjuntos");
			var cant = tabla.rows.length;
			for(var x=0; x<cant; x++){
				var row = tabla.rows[x];
				console.log('asd');
				if(row.cells[0].innerHTML === val2.toString()){
					console.log('qwe');
					id2 = $(row).attr('id');
					if($('#'+id1).attr('name') === $('#'+id2).attr('name')){
						row.cells[0].innerHTML = val1;
					}
				}
			}
			if($('#'+id1).attr('name') === $('#'+id2).attr('name')){
				$('#'+id1).after($('#'+id2));
				$(fila).find('td:first-child').html(val2);
				id1 = id1.slice(8);
				id2 = id2.slice(8);
				console.log(id1+' '+id2);
				$.post('expedientes/expedientes/intercambiar', {
					id1: id1,
					val2: val2,
					id2: id2,
					val1: val1
				});
			} else {
				console.log('No puede subir más');
			}	
		} else {
			console.log('No puede subir más');
		}
	}

	function bajar(btn){
		var fila = $(btn).parent().parent();
		var val1 = $(fila).find('td:first-child').html();
		var tabla = document.getElementById("tbl_adjuntos");
		var cant = tabla.rows.length;
		if (val1 < (cant-1) && val1 != 0) {
			var id1 = $(fila).attr('id');
			var id2 = 0;
			var val2 = parseInt(val1)+1;
			console.log(val1+' '+val2);
			
			for(var x=0; x<cant; x++){
				var row = tabla.rows[x];
				console.log('asd');
				if(row.cells[0].innerHTML === val2.toString()){
					console.log('qwe');
					id2 = $(row).attr('id');
					if($('#'+id1).attr('name') === $('#'+id2).attr('name')){
						row.cells[0].innerHTML = val1;
					}
				}
			}
			if($('#'+id1).attr('name') === $('#'+id2).attr('name')){
				$('#'+id2).after($('#'+id1));
				$(fila).find('td:first-child').html(val2);
				id1 = id1.slice(8);
				id2 = id2.slice(8);
				console.log(id1+' '+id2);
				$.post('expedientes/expedientes/intercambiar', {
					id1: id1,
					val2: val2,
					id2: id2,
					val1: val1
				});
			} else {
				console.log('No puede bajar más');
			}
		} else {
			console.log('No puede bajar más');
		}
	}

	var archivo_adjunto_id = 0;
	function solicitar_firma(id) {
		window.location.href = 'expedientes/archivos_adjuntos/solicitar_firma/' + archivo_adjunto_id + '/' + id;
	}

	function descargarArchivo_verExp(id, nombre){
		console.log(id + ' ' + nombre);
		$.post('expedientes/archivos_adjuntos/vista_preliminar/'+id)
		.done(function(data){
			contenido = [];
			contenido.push(data);
			descargarArchivo(new Blob(contenido, { type: 'text/plain' }), nombre);
		});
	}

	$(document).ready(function () {
		$('#tbl_anexos, #tbl_acumulados').dataTable({
			paging: false,
			searching: false,
			responsive: true,
			language: {"url": "plugins/datatables/spanish.json"}
		});
		$('#tbl_pases').dataTable({
			paging: false,
			searching: false,
			responsive: true,
			language: {"url": "plugins/datatables/spanish.json"},
			order: [[5, "desc"], [0, "desc"]]
		});
		$('#tbl_adjuntos').dataTable({
			paging: false,
			searching: false,
			responsive: true,
			language: {"url": "plugins/datatables/spanish.json"},
			/*"columnDefs": [
				{
					"targets": [ 0 ],
					"visible": false,
					"searchable": false
				}
			],*/
		});
		$("#archivos").fileinput({
			language: 'es',
			showUpload: true,
			browseClass: "btn btn-primary",
			browseLabel: "Agregar",
			browseIcon: "<i class=\"glyphicon glyphicon-plus\"></i> ",
			removeClass: "btn btn-danger",
			removeLabel: "Eliminar",
			removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
		});
		$('#usuarios_table').on('click', 'tbody tr',function(){
			var input = $(this).find('td:eq(2)').find('input:eq(0)');
			if($(input).prop('checked')){
				$(input).prop('checked', false);
			} else {
				$(input).prop('checked', true);
			}
			//checkedArray_firmas($(input).prop('id'), $(input).prop('checked'));
		});
	});
	var id = 0;
	function adjuntoId(val){
		id = val;
	}

	function eliminarArchivo(){
		console.log('asdasd  ' + id);
		$.post( "expedientes/archivos_adjuntos/eliminar", { 
			id: id,
			<?php if(!empty($adjuntos[0])): ?>
			id_expediente: <?= $adjuntos[0]['id_expediente'] ?> 
			<?php endif;?>
			})
		.done(function(){
			location.reload();
		});
	}

	function notificacion() {
		var noti = new Notification( "Notificación" );
		setTimeout( function() { noti.close() }, 1000)
	}

	function marca_resuelto(){
		var motivo = document.getElementById('motivo_resuelto');
		console.log(motivo.value);
		$.post( "expedientes/expedientes/marcar_resuelto/<?php echo $expediente->id; ?>", { 
			motivo: motivo.value,
		})
		.done(function(){
			location.reload();
		});
	}

	function marca_resolucion(){
		var motivo = document.getElementById('motivo_resolucion');
		console.log(motivo.value);
		$.post( "expedientes/expedientes/marcar_resolucion/<?php echo $expediente->id; ?>", { 
			motivo: motivo.value,
		})
		.done(function(){
			location.reload();
		});
	}

	function cancelar_firma(){
		console.log('asdasd  ' + archivo_adjunto_id);
		$.post( "expedientes/archivos_adjuntos/cancelar_firma", { 
			id: id,
			<?php if(!empty($adjuntos[0])): ?>
			id_expediente: <?= $adjuntos[0]['id_expediente'] ?> 
			<?php endif;?>
			})
		.done(function(){
			location.reload();
		});
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
						<h3 style="vertical-align:middle;" class="box-title">
							<?php echo "Expediente $expediente->numero / $expediente->ano - $expediente->anexo"; ?>
							<?php if ($expediente->tramite_id == 100 || $expediente->tramite_id == 101): ?>
								<span style="vertical-align: middle;margin-top: -3px;"class="badge label-info">- AYUDA SOCIAL -</span>
							<?php endif; ?>
							<?php if ($archivado): ?>
								<span style="vertical-align: middle;margin-top: -3px;"class="badge label-danger">[ARCHIVADO]</span>
							<?php endif; ?>
							<?php if (!empty($acumulados)): ?>
								<span style="vertical-align: middle;margin-top: -3px;"class="badge label-warning">- MADRE -</span>
							<?php endif; ?>
							<?php if ($expediente->acumulado > 0): ?>
								<span style="vertical-align: middle;margin-top: -3px;"class="badge label-warning">- ACUMULADO -</span>
							<?php endif; ?>
							<?php if ($pendiente_resolucion != null): ?>
								<span style="vertical-align: middle;margin-top: -3px;"class="badge label-warning">- PENDIENTE DE RESOLUCIÓN -</span>	
							<?php endif; ?>
						</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
						<?php if ($motivo != null): ?>
							<h4>Motivo: <?php echo $motivo ?></h4>
						<?php endif; ?>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn); ?>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h4 class="text-bold">
									<?php echo "Carátula: $expediente->caratula"; ?>
									<br />
									<?php echo "Tipo de trámite: $expediente->tramite"; ?>
								</h4>
							</div>
						</div>
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
										<?php echo $fields['inicio']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['inicio']['form']; ?>
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
						<?php if (!empty($expediente->madre_numero)): ?>
							<div class="row">
								<div class="form-group col-md-9 col-sm-9 col-xs-12">
									<div class="row">
										<div class="col-sm-2">
											<label for="expediente_madre">Expediente Madre</label>
										</div>
										<div class="col-sm-10">
											<a class="form-control-static lg" name="expediente_madre" href="expedientes/expedientes/ver/<?php echo $expediente->acumulado; ?>">
												<?php echo "Ver Expediente $expediente->madre_numero / $expediente->madre_ano - $expediente->madre_anexo"; ?>
											</a>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($expediente->tramite_id == 100 || $expediente->tramite_id == 101): ?>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h4 class="text-bold">
										Datos de Ayuda Social
									</h4>
								</div>
							</div>
							<div class="row" id="div-ayuda-social">
								<div class="form-group col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields_ayuda_social['numeroDeFichaApros']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields_ayuda_social['numeroDeFichaApros']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields_ayuda_social['nombreDelBeneficiario']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields_ayuda_social['nombreDelBeneficiario']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields_ayuda_social['detalleSolicitud']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields_ayuda_social['detalleSolicitud']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields_ayuda_social['detalleFamiliares']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields_ayuda_social['detalleFamiliares']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields_ayuda_social['detalleBeneficioEntregado']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields_ayuda_social['detalleBeneficioEntregado']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-9 col-sm-9 col-xs-9">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields_ayuda_social['tipo_ayuda_social']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields_ayuda_social['tipo_ayuda_social']['form']; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if($organigrama == $this->session->userdata('organigrama')): ?>
							<?php if (!$archivado && $expediente->acumulado <= 0): ?>
								<?php if (($ver_expediente && $editar_caratula && $admin_exp && $imprime_caratula) || $acceso_total): ?>
									<a class="btn btn-primary btn-margin-bottom" href="expedientes/expedientes/editar/<?php echo $expediente->id; ?>">Editar Carátula</a>
								<?php endif; ?>
									<a class="btn btn-primary btn-margin-bottom" href="expedientes/expedientes/iniciar?anexar=<?php echo $expediente->id; ?>">Anexar</a>
								<?php if ($expediente->acumulado <= 0 && $admin_exp && $acumular): ?>
									<a class="btn btn-primary btn-margin-bottom" href="expedientes/expedientes/acumular/<?php echo $expediente->id; ?>">Acumular</a>
								<?php endif; ?>
									<a class="btn btn-primary btn-margin-bottom" target="_blank" href="expedientes/expedientes/pdf_caratula/<?php echo $expediente->id; ?>">Carátula</a>
									<a class="btn btn-primary btn-margin-bottom" target="_blank" href="expedientes/expedientes/pdf_comprobante/<?php echo $expediente->id; ?>">Comprobante</a>
								<?php if ($ver_expediente || $acceso_total): ?>
									<a class="btn btn-primary btn-margin-bottom" href="expedientes/expedientes/generar_informe/<?php echo $expediente->id; ?>">Generar Informe</a>
									<!--<a class="btn btn-primary btn-margin-bottom" href="expedientes/expedientes/generar_informe_infogov/<?php echo $expediente->id; ?>">Informe Infogov</a>-->
								<?php endif; ?>
							<?php endif; ?>
							<?php if ((($ver_expediente || $archivado) && $imprime_caratula) || $acceso_total): ?>
								<a class="btn btn-primary btn-margin-bottom" target="_blank" href="expedientes/expedientes/pdf_exportar/<?php echo $expediente->id; ?>">Exportar a PDF</a>
							<?php endif; ?>
							
						<?php endif; ?>

						<a class="btn btn-primary btn-margin-bottom" target="_blank" href="expedientes/expedientes/visualizar/<?php echo $expediente->id; ?>">Visualizar</a>
						
						<a class="btn btn-primary btn-margin-bottom" target="_blank" href="expedientes/expedientes/generar_reporte_pases/<?php echo $expediente->id; ?>">Reporte de pases</a>
					<br>
					<br>
					
						<?php if ((($ver_expediente && $editar_caratula) || $acceso_total) && $eliminar_expediente): ?>
							<a class="btn btn-danger btn-margin-bottom" href="#" data-toggle="modal" data-target="#eliminar_modal">Eliminar</a>
						<?php endif; ?>
						<?php if ($rechaza_expediente && $imprime_caratula && ($derivado || $derivador)): ?>
							<button type="button" class="btn btn-danger btn-margin-bottom" data-toggle="modal" data-target="#rechazar_modal">Rechazar</button>
						<?php endif; ?>
						<?php if($derivado): ?>
							<?php if($estado != "resolucion"): ?>
								<button type="button" class="btn btn-danger btn-margin-bottom" data-toggle="modal" data-target="#resolucion_modal">A resolución</button>
							<?php endif; ?>
							<?php if($estado != "resuelto"): ?>
								<button type="button" class="btn btn-success btn-margin-bottom" data-toggle="modal" data-target="#resuelto_modal">Resuelto</button>
							<?php endif; ?>
						<?php endif; ?> 
						<?php if($derivado || $derivador): ?>
							<?php if($estado != "resolver"): ?>
								<a href="expedientes/pases/enviar/<?php echo $pase_id; ?>/enviar/<?php echo $expediente->id; ?>" title="Enviar Pase" class="btn btn-success btn-margin-bottom" target="_blank">Enviar Pase</a>			
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="javascript:window.history.back();" title="Volver">Volver</a>
					</div>
					<?php echo form_close(); ?>
				</div>
				<div class="tabs-x align-center tabs-above tab-bordered">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#one2" data-toggle="tab">Pases (<?php echo empty($pases) ? 0 : count($pases); ?>)</a></li>
						<li><a href="#two2" data-toggle="tab">Anexos (<?php echo empty($anexos) ? 0 : count($anexos); ?>)</a></li>
						<li><a href="#three2" data-toggle="tab">Acumulados (<?php echo empty($acumulados) ? 0 : count($acumulados); ?>)</a></li>
						<?php if ($imprime_caratula): ?>
							<?php if ($derivador): ?>
								<li><a href="#four2" data-toggle="tab">Archivos Adjuntos (<span id="cantidad_adjuntos"><?php echo empty($adjuntos) ? 0 : count($adjuntos); ?></span>)</a></li>
							<?php else: ?>
								<?php if ($derivado): ?>
									<li><a href="#four2" data-toggle="tab">Archivos Adjuntos (<span id="cantidad_adjuntos"><?php echo empty($adjuntos) ? 0 : count($adjuntos); ?></span>)</a></li>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
                                                        <li><a href="#five2" data-toggle="tab">Firmas Pendientes (<?php echo empty($firmas) ? 0 : count($firmas); ?>)</a></li>
					</ul>   
					<div class="tab-content">
						<div class="tab-pane active" id="one2">
							<?php if (empty($pases)): ?>
								Este expediente no contiene pases.<br/>
							<?php else: ?>
								<table id="tbl_pases" style="width:100%;" class="table table-hover table-bordered table-condensed">
									<thead>
										<tr>
											<th data-priority="1">Fecha</th>
											<th data-priority="2">Oficina Emisora</th>
											<th data-priority="2">Usuario Emisor</th>
											<th data-priority="2">Oficina Receptora</th>
											<th data-priority="2">Usuario Receptor</th>
											<th data-priority="2">Estado</th>
											<th data-priority="2">Fojas</th>
											<th data-priority="2">Nota</th>
											<th data-priority="1">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($pases as $pase): ?>
											<tr>
												<td data-order="<?php echo empty($pase->fecha) ? '' : date_format(new DateTime($pase->fecha), 'YmdHi'); ?>"><?php echo empty($pase->fecha) ? '' : date_format(new DateTime($pase->fecha), 'd/m/Y H:i'); ?></td>
												<td><?php echo $pase->ofi_emi; ?></td>
												<td><?php echo $pase->usu_emi; ?></td>
												<td><?php echo $pase->ofi_rec; ?></td>
												<td><?php echo $pase->usu_rec; ?></td>
                                                                                                <td><?php echo ($pase->btn_disabled != '' && trim(strtoupper($pase->respuesta)) == 'PENDIENTE' ? ($pase->revision_estado != 2 ? 'PENDIENTE' : 'FIRMA PENDIENTE') : strtoupper($pase->respuesta)); ?></td>
												<td><?php echo $pase->fojas; ?></td>
												<td><?php echo empty($pase->nota_pase_id) ? '' : '<a class="btn btn-xs btn-primary" onclick="javascript:mostrar_nota(\'' . html_escape($pase->contenido) . '\')" style="width: 100px;">Ver</a>'; ?></td>
												<td>
													<a style="width: 100px;" class="btn btn-xs btn-primary" href="expedientes/pases/ver/<?php echo $pase->id; ?>" >Ver Pase</a>
													<?php if (!$archivado && $pase->origen === $this->session->userdata('oficina_actual_id') && ($pase->respuesta === 'pendiente' || $pase->respuesta === 'rechazado') && ($pase->destino === '-1' || $pase->destino === '-2') && $pase->btn_disabled == '' && $pase->revision_estado == 2): ?>
														<a style="width: 100px;" class="btn btn-xs btn-success" href="expedientes/pases/enviar/<?php echo $pase->id; ?>/enviar/<?= $expediente->id?>" title="Enviar Pase">Continuar Circuito</a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
						</div>
						<div class="tab-pane" id="two2">
							<?php if (empty($anexos)): ?>
								Este expediente aún no tiene otros expedientes adjuntos.
							<?php else: ?>
								<table id="tbl_anexos" style="width:100%;" class="table table-hover table-bordered table-condensed">
									<thead>
										<tr>
											<th data-priority="1">Fecha</th>
											<th data-priority="2">Número</th>
											<th data-priority="2">Anexo</th>
											<th data-priority="2">Trámite</th>
											<th data-priority="2">Objeto</th>
											<th data-priority="2">Fojas</th>
											<th data-priority="1">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($anexos as $anexo): ?>
											<tr>
												<td><?php echo date_format(new DateTime($anexo->inicio), 'd/m/Y'); ?></td>
												<td><?php echo $anexo->numero; ?></td>
												<td><?php echo $anexo->anexo; ?></td>
												<td><?php echo $anexo->tramite; ?></td>
												<td><?php echo $anexo->objeto; ?></td>
												<td><?php echo $anexo->fojas; ?></td>
												<td>
													<a style="width: 100px;" class="btn btn-xs btn-primary" href="expedientes/ver/<?php echo $anexo->id; ?>">Ver Expediente</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
						</div>
						<div class="tab-pane" id="three2">
							<?php if (empty($acumulados)): ?>
								Este expediente no contiene acumulados.
							<?php else: ?>
								<table id="tbl_acumulados" style="width:100%;" class="table table-hover table-bordered table-condensed">
									<thead>
										<tr>
											<th data-priority="1">Fecha</th>
											<th data-priority="2">Número</th>
											<th data-priority="2">Anexo</th>
											<th data-priority="2">Trámite</th>
											<th data-priority="2">Objeto</th>
											<th data-priority="2">Fojas</th>
											<th data-priority="1">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($acumulados as $acumulado): ?>
											<tr>
												<td data-order="<?php echo date_format(new DateTime($acumulado->inicio), 'Ymd'); ?>"><?php echo date_format(new DateTime($acumulado->inicio), 'd/m/Y'); ?></td>
												<td><?php echo $acumulado->numero; ?></td>
												<td><?php echo $acumulado->anexo; ?></td>
												<td><?php echo $acumulado->tramite; ?></td>
												<td><?php echo $acumulado->objeto; ?></td>
												<td><?php echo $acumulado->fojas; ?></td>
												<td>
													<a style="width: 100px;" class="btn btn-xs btn-primary" href="expedientes/ver/<?php echo $acumulado->id; ?>">Ver Expediente</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
						</div>
						<?php if (($ver_expediente || $archivado) && $es_digital):?>
							<div class="tab-pane" id="four2">
								<?php if (empty($adjuntos)): ?>
									Este expediente aún no tiene archivos adjuntos.<br/>
									Solo adjunte archivos en formato pdf.
									<?php echo form_open_multipart("expedientes/archivos_adjuntos/nuevo/$expediente->id"); ?>
									<input id="archivos" name="archivos[]" multiple type="file" accept="text/*" class="file-loading">
									<?php echo form_close(); ?>
								<?php else: ?>
									Solo adjunte archivos en formato pdf.
									<?php echo form_open_multipart("expedientes/archivos_adjuntos/nuevo/$expediente->id"); ?>
									<input id="archivos" name="archivos[]" multiple type="file" accept="text/*" class="file-loading">
									<?php echo form_close(); ?>
									<table id="tbl_adjuntos" style="width:100%;" class="table table-hover table-bordered table-condensed">
										<thead>
											<tr>
												<th style="display:none;"></th>
												<th data-priority="1">Nombre de archivo</th>
												<th data-priority="2">Fecha</th>
												<th data-priority="2">Tamaño (apróx.)</th>
												<th data-priority="1">Acción</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($adjuntos as $adjunto): ?>
												<tr id="adjunto_<?= $adjunto['id'] ?>" name="pase_<?= $adjunto['pase_id'] ?>">
													<td style="display:none;"><?php echo $adjunto['orden'] ?></td>
													<td><a target="_blank" href="expedientes/archivos_adjuntos/vista_preliminar/<?php echo $adjunto['id']; ?>"><?php echo $adjunto['nombre']; ?></a></td>
													<td data-order="<?php echo date_format(new DateTime($adjunto['fecha']), 'YmdHis'); ?>"><?php echo date_format(new DateTime($adjunto['fecha']), 'd/m/Y H:i:s'); ?></td>
													<td><?php echo number_format($adjunto['tamanio'] / 1024, 2) . ' KB'; ?></td>
													<td>
														<a style="width: 100px;" target="_blank" class="btn btn-xs btn-primary" href="expedientes/archivos_adjuntos/ver/<?php echo $adjunto['id']; ?>">Ver</a>
														<?php if($adjunto['firma_pendiente'] == '0'): ?>
															<?php if(explode('.', $adjunto['nombre'])[1] == 'pdf'): ?>
																<button style="width: 100px;" type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#buscar_usuario_modal" onclick="archivo_adjunto_id =<?php echo $adjunto['id']; ?>;">Solicitar Firma</button>
															<?php endif;?>
															<?php if($pase_id == $adjunto['pase_id']): ?>
																<button style="width: 100px;" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#eliminar_adjunto_modal"  onclick="javascript:adjuntoId(<?= $adjunto['id'] ?>)">Eliminar</button>
																<button class="btn btn-default" onclick="subir(this)" id="btn-subir"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
																<button class="btn btn-default" onclick="bajar(this)" id="btn-bajar"><i class="fa fa-arrow-down" aria-hidden="true"></i></button>
															<?php endif;?>
														<?php else:?>
															<?php if(explode('.', $adjunto['nombre'])[1] == 'pdf'): ?>
															<?php endif;?>
														<?php endif;?>
														<button class="btn btn-default" type="button" onclick="descargarArchivo_verExp('<?php echo $adjunto['id'];?>', '<?php echo $adjunto['nombre']; ?>');">Descargar</button>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								<?php endif; ?>
							</div>
						<?php endif; ?>
                                            <div class="tab-pane" id="five2">
							<?php if (empty($firmas)): ?>
								Este expediente aún no tiene firmas pendientes.
							<?php else: ?>
								<table id="tbl_firmas" style="width:100%;" class="table table-hover table-bordered table-condensed">
									<thead>
										<tr>
											<th data-priority="1">Nombre del archivo</th>
											<th data-priority="2">Fecha</th>
											<th data-priority="2">Firmante</th>
											<th data-priority="2">Solicitante</th>
										</tr>
									</thead>
									<tbody>
										<?php 
                                                                                if(count($firmas) == 1 ){
                                                                                    $firmas = array($firmas);//
                                                                                }
                                                                                foreach ($firmas as $firma): 
                                                                                ?>
											<tr>
                                                                                            <td><a target="_blank" href="expedientes/archivos_adjuntos/vista_preliminar/<?php echo $firma->documento_id; ?>"><?php echo $firma->documento; ?></a></td>
                                                                                                <td><?php echo date_format(new DateTime($firma->fecha), 'd/m/Y'); ?></td>
												<td><?php echo $firma->firmante; ?></td>
												<td><?php echo $firma->solicitante; ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="contenido_nota_modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Contenido Nota</h4>
			</div>
			<div class="modal-body">
				<p id="contenido_nota"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<?php if ($ver_expediente): ?>
	<div class="modal fade" id="buscar_usuario_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Seleccionar usuario a solicitar firma</h4>
				</div>
				<div class="modal-body">
					<?php echo $js_table_usuarios; ?>
					<?php echo $html_table_usuarios; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success pull-right" onclick="javascript:enviar_solicitud_firmas(archivo_adjunto_id)">Enviar Solicitud</button>
					<button type="button" class="btn btn-default pull-left"  onclick="javascript:borrar_firmas()" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if (($ver_expediente && $editar_caratula) || $acceso_total): ?>
	<div class="modal fade" id="eliminar_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Confirmar acción</h4>
				</div>
				<div class="modal-body">
                                    <p>¿Esta seguro de <b>eliminar</b> el expediente?</p>
				</div>
				<div class="modal-footer">
                                        <a href="expedientes/expedientes/eliminar/<?php echo $expediente->id; ?>" class="btn btn-danger">Aceptar</a>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ($rechaza_expediente): ?>
	<div class="modal fade" id="rechazar_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Confirmar acción</h4>
				</div>
				<div class="modal-body">
                                    <p>¿Esta seguro de <b>rechazar</b> el expediente?</p>
				</div>
				<div class="modal-footer">
					<a href="expedientes/expedientes/rechazar_expdigital/<?php echo $expediente->id; ?>" class="btn btn-danger">Aceptar</a>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="modal fade" id="eliminar_adjunto_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Confirmar acción</h4>
			</div>
			<div class="modal-body">
				<p>¿Esta seguro de <b>eliminar</b> el archivo adjuntado?</p>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" onclick="javascript:eliminarArchivo()" class="btn btn-danger">Aceptar</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="resuelto_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Confirmar acción</h4>
			</div>
			<div class="modal-body">
				<p>¿Esta seguro de marcar este expediente como resuelto?</p>
				<div class="form-group">
					<label>Motivo*</label>
					<input class="form-control" type="text" name="motivo" id="motivo_resuelto"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" onclick="marca_resuelto()">Aceptar</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="resolucion_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Confirmar acción</h4>
			</div>
			<div class="modal-body">
				<p>¿Esta seguro de marcar este expediente como pendiente de resolución?</p>
				<div class="form-group">
					<label>Motivo*</label>
					<input class="form-control" type="text" name="motivo" id="motivo_resolucion"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" onclick="marca_resolucion()">Aceptar</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="cancelar_firma_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Confirmar acción</h4>
			</div>
			<div class="modal-body">
				<p>¿Esta seguro de <b>cancelar</b> la firma?</p>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" onclick="cancelar_firma()" class="btn btn-danger">Aceptar</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
