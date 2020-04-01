<script>
	var informes_table;
	function seleccionar_informe(id) {
		window.location.replace('expedientes/expedientes/generar_informe_infogov/<?php echo $expediente->id; ?>/' + id);
	}
	$(document).ready(function() {
		$('#buscar_informe_modal').on('shown.bs.modal', function() {
			informes_table.responsive.recalc();
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Generar Informe Infogov
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>/listar"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active">Generar Informe Infogov</li>
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
							Generar Informe <?php echo "Expediente $expediente->numero / $expediente->ano - $expediente->anexo"; ?>
						</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<label for="expediente">Expediente</label>
									</div>
									<div class="col-sm-10">
										<input type="text" name="expediente" value="<?php echo "$expediente->numero / $expediente->ano - $expediente->anexo"; ?>" id="expediente" class="form-control" disabled>
										<input type="hidden" name="id" value="<?php echo $expediente->id; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<label for="informe">Tipo de Informe</label>
									</div>
									<div class="col-sm-10">
										<input type="text" name="informe" value="<?php echo empty($informe) ? '' : $informe->nombre; ?>" id="informe" class="form-control" disabled>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_informe" class="btn btn-warning" data-toggle="modal" data-target="#buscar_informe_modal">Seleccionar tipo de informe</button>
							</div>
						</div>
						<?php if (!empty($informe)): ?>
							<div class="row">
								<?php foreach ($fields as $field): ?>
									<div class="form-group col-md-9 col-sm-9 col-xs-12">
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
						<?php endif; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/expedientes/ver/<?php echo $expediente->id; ?>" title="Cancelar">Cancelar</a>
						<?php echo form_submit(array('class' => 'btn btn-primary pull-right', 'title' => 'Guardar'), 'Guardar'); ?>
						<a class="btn btn-default" href="javascript:window.history.back();" title="Volver">Volver</a>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_informe_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar tipo de informe</h4>
			</div>
			<div class="modal-body">
				<script type="text/javascript">
					$(document).ready(function() {
						$.fn.dataTable.moment("DD/MM/YYYY");
						informes_table = $("#informes_table").DataTable({order: [[0, "asc"]], initComplete: function() {
								var r = $('#informes_table tfoot tr');
								r.find('th').each(function() {
									$(this).css('padding', 8);
								});
								$('#informes_table thead').append(r);
								$('#search_0').css('text-align', 'center');
							},
							dom: 'rtip',
							processing: true,
							autoWidth: false,
							pagingType: "simple_numbers",
							language: {"url": "plugins/datatables/spanish.json"},
							columns: [{"data": "nombre"}, {"data": "select"}, ],
							columnDefs: [
								{"targets": 0, "width": "95%"},
								{
									"targets": 1,
									"width": "5%",
									"className": "dt-body-center",
									"searchable": false,
									"sortable": false
								},
							],
							colReorder: true
						});
					});
				</script>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#informes_table tfoot th').each(function() {
							var title = $(this).text();
							if (title !== '')
								$(this).html('<input style="width: 100%;" type="text" placeholder="' + title + '" />');
						});
						informes_table.columns().every(function() {
							var that = this;
							$('input', informes_table.table().footer().children[0].children[this[0][0]]).on('change', function() {
								if (that.search() !== this.value) {
									that.search(this.value).draw();
								}
							});
						});
					});
				</script>
				<div id="informes_table_wrapper">
					<table id="informes_table" class="table">
						<thead>
							<tr>
								<th>Nombre</th>
								<th></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td>Orden de Pago</td>
								<td class=" dt-body-center">
									<a data-dismiss="modal" href="" onclick="seleccionar_informe(1);" title="Seleccionar">
										<i class="fa fa-check"></i>
									</a>
								</td>
							</tr>
							<tr>
								<td>Constancia de Retención</td>
								<td class=" dt-body-center">
									<a data-dismiss="modal" href="" onclick="seleccionar_informe(2);" title="Seleccionar">
										<i class="fa fa-check"></i>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
