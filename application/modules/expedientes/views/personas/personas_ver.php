<script>
	$(document).ready(function() {
		$('#tbl_expedientes').dataTable({
			paging: false,
			searching: false,
			responsive: true,
			language: {"url": "plugins/datatables/spanish.json"}
		});
	});
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
						<h3 class="box-title">Información de la persona</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator')); ?>
					<div class="box-body">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['DetaPers']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['DetaPers']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['NudoPers']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['NudoPers']['form']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/personas/listar" title="Listo">Listo</a>
					</div>
					<?php echo form_close(); ?>
				</div>
				<div class="tabs-x align-center tabs-above tab-bordered">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#one2" data-toggle="tab">Expedientes de <?php echo $persona->DetaPers; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="one2">
							<?php if (empty($expedientes)): ?>
								La persona aún no tiene expedientes.<br/>
							<?php else: ?>
								<table id="tbl_expedientes" class="table table-hover table-bordered table-condensed">
									<thead>
										<tr>
											<th data-priority="1">Año</th>
											<th data-priority="2">Número</th>
											<th data-priority="2">Anexo</th>
											<th data-priority="2">Fojas</th>
											<th data-priority="2">Carátula</th>
											<th data-priority="2">Objeto</th>
											<th data-priority="2">Fecha</th>
											<th data-priority="1">Acción</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($expedientes as $expediente): ?>
											<tr>
												<td><?php echo $expediente->ano; ?></td>
												<td><?php echo $expediente->numero; ?></td>
												<td><?php echo $expediente->anexo; ?></td>
												<td><?php echo $expediente->fojas; ?></td>
												<td><?php echo $expediente->caratula; ?></td>
												<td><?php echo $expediente->objeto; ?></td>
												<td><?php echo date_format(new DateTime($expediente->inicio), 'd/m/Y'); ?></td>
												<td>
													<a class="btn btn-xs btn-primary" href="expedientes/ver/<?php echo $expediente->id; ?>">Ver Expediente</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
							<a target="_blank" class="btn btn-primary" href="expedientes/expedientes/iniciar">Iniciar expediente</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>