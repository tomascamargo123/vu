<script>
function changeStyles () {
	$('#avisos_table tr').each(function() {
		if ($(this).find("td:first").length > 0) {
			var estado = $(this).find("td").eq(1);
			var importancia = $(this).find("td").eq(2);
			switch(estado.html()){
				case 'Pendiente':
					$(estado).attr('class', 'amarillo');
					break;
				case 'En proceso':
					$(estado).attr('class', 'celeste');
					break;
				case 'Resuelto':
					$(estado).attr('class', 'verde');
					break;
				case 'Rechazado':
					$(estado).attr('class', 'rojo');
					break;
				default:
					break;
			}
			console.log(importancia.html());
			switch(importancia.html()){
				case 'Baja':
					$(importancia).attr('class', 'verde');
					break;
				case 'Moderada':
					$(importancia).attr('class', 'amarillo');
					break;
				case 'Alta':
					$(importancia).attr('class', 'rojo');
					break;
				default:
					break;
			}
		}
	});
}
</script>
<style>
.amarillo{
	color: #f39c12;
	font-weight: bold;
}
.verde{
	color: #8eb436;
	font-weight: bold;
}
.celeste{
	color: #00c0ef;
	font-weight: bold;
}
.rojo{
	color: #ac2925;
	font-weight: bold;
}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Avisos
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title">Listado de avisos</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php echo $js_table; ?>
						<?php echo $html_table; ?>
					</div>
					<div class="box-footer">
						<a class="btn btn-primary pull-right" href="expedientes/avisos/agregar" title="Agregar aviso">Agregar aviso</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>