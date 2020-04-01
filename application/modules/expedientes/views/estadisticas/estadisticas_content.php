<script>
	var oficinas_table;
	$(document).ready(function() {
		$("#btn_generar_informe").click(function() {
			$("#form_estadisticas").attr('target', '_blank');
			$("#form_estadisticas").data('submitted', false);
			return true;
		});
		$("#btn_generar_grafico").click(function() {
			$("#form_estadisticas").attr('target', '_self');
			$("#form_estadisticas").data('submitted', false);
			return true;
		});
		$('#buscar_oficina_solicitante_modal').on('shown.bs.modal', function() {
			oficinas_solicitante_table.responsive.recalc();
		});
	});
	function limpiar_inputs() {
<?php if ($elige_oficina) : ?>
			$('#oficina').val('');
			$('#oficina_id').val('');
<?php endif; ?>
		$('#desde').val('');
		$('#hasta').val('');
<?php if ($elige_mostrar) : ?>
			$('#mostrar').val('E');
<?php endif; ?>
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Estadísticas
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active"><?php echo ucfirst($metodo_visual); ?></li>
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
					<?php echo form_open(uri_string(), array('id' => 'form_estadisticas', 'data-toggle' => 'validator')); ?>
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo $box_title; ?></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body label-expedientes">
						<?php if ($elige_oficina) : ?>
							<div class="row">
								<div class="form-group col-md-9 col-sm-9 col-xs-12">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields['oficina_id']['form']; ?>
											<?php echo $fields['oficina']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields['oficina']['form']; ?>
										</div>
									</div>
								</div>
								<div class="form-group col-md-3 col-sm-3 col-xs-12">
									<button type="button" id="btn_buscar_oficina" class="btn btn-warning" data-toggle="modal" data-target="#buscar_oficina_modal">Elegir oficina</button>
								</div>
							</div>
						<?php endif; ?>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['desde']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['desde']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['hasta']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['hasta']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<?php if ($elige_mostrar) : ?>
							<div class="row">
								<div class="form-group col-md-9 col-sm-9 col-xs-12">
									<div class="row">
										<div class="col-sm-2">
											<?php echo $fields['mostrar']['label']; ?>
										</div>
										<div class="col-sm-10">
											<?php echo $fields['mostrar']['form']; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" id="btn_generar_grafico" name="btn_grafico" value="Generar Gráfico" title="Generar Gráfico" <?php echo $metodo_visual === 'Pases por Oficina/Usuario' ? 'disabled' : ''; ?> />
						<input type="submit" class="btn btn-primary" id="btn_generar_informe" name="btn_informe" value="Generar Informe" title="Generar Informe" />
						<a class="btn btn-primary" href="javascript:limpiar_inputs();" title="Limpiar">Limpiar</a>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<?php if (!empty($chart)) : ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $grafico_title; ?></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body border-radius-none">
							<?php if ($grafico_title === 'Cantidad de trámites por tipo' || $grafico_title === 'Cantidad de pases emitidos'): ?>
								<div class="col-md-8">
									<div class="chart-responsive">
										<?php echo $chart; ?>
									</div><!-- ./chart-responsive -->
								</div>
								<div class="col-md-4">
									<div id="chart-legend"></div>
								</div>
							<?php else: ?>
								<div class="col-md-12">
									<div class="chart-responsive">
										<?php echo $chart; ?>
									</div><!-- ./chart-responsive -->
								</div>
							<?php endif; ?>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		<?php endif; ?>
	</section>
</div>
<?php if ($elige_oficina) : ?>
	<div class="modal fade" id="buscar_oficina_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Seleccione oficina</h4>
				</div>
				<div class="modal-body">
					<?php echo $js_table_oficinas; ?>
					<?php echo $html_table_oficinas; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>