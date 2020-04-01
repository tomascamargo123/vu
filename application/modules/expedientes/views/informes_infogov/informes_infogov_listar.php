<script>
	$(document).ready(function() {
		$('#informes_infogov_table').dataTable({
			responsive: true,
			language: {"url": "plugins/datatables/spanish.json"}
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Informes Infogov
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>">Informes Infogov</a></li>
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
						<h3 class="box-title">Listado de informes infogov</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div id="informes_infogov_table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
							<div class="row">
								<div class="col-sm-12">
									<table id="informes_infogov_table" class="table table-hover table-bordered table-condensed dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="informes_infogov_table_info">
										<thead>
											<tr role="row">
												<th tabindex="0" style="width: 95%;" data-column-index="0">Nombre</th>
												<th class="all dt-body-center" style="width: 5%;" data-column-index="1"></th>
											</tr>
										</thead>
										<tbody>
											<tr role="row" class="odd">
												<td tabindex="0">Orden de Pago</td>
												<td class=" dt-body-center">
													<a href="expedientes/informes_infogov/circuito_firmas/1" title="Circuito Firmas"><i class="fa fa-circle"></i></a>
												</td>
											</tr>
											<tr role="row" class="even">
												<td class="sorting_1" tabindex="0">Constancia Retención</td>
												<td class=" dt-body-center">
													<a href="expedientes/informes_infogov/circuito_firmas/2" title="Circuito Firmas"><i class="fa fa-circle"></i></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
					</div>
				</div>
			</div>
		</div>
	</section>
</div>