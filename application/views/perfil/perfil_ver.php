<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Perfil
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="<?php echo $controlador; ?>/ver"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title">Ver perfil</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4 text-center">
								<img class="img-circle avatar avatar-original" style="-webkit-user-select:none; display:block; margin:auto;" src="img/users/0.png">
							</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-12">
										<h1 class="only-bottom-margin"><?php echo!empty($usuario->first_name) ? $usuario->first_name : ''; ?> <?php echo!empty($usuario->last_name) ? $usuario->last_name : ''; ?></h1>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<span class="text-muted">Usuario:</span> <?php echo $usuario->username; ?><br>
										<span class="text-muted">Email:</span> <?php echo $usuario->email; ?><br>
										<span class="text-muted">Creado:</span> <?php echo date('d/m/Y H:i', $usuario->created_on); ?><br>
										<span class="text-muted">Clave de firma:</span> <?php echo empty($key) ? 'No generada' : 'Generada el ' . (new DateTime($key->created_on))->format('d/m/Y H:i:s'); ?><br>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="" title="Cancelar">Cancelar</a>
						<a class="btn btn-primary pull-right" href="perfil/firma" title="Firma">Firma</a>
					</div>
				</div>
			</div>
		</div>
		<form method="GET" action="<?php echo base_url()."perfil/primeraOficina" ?>" accept-charset="utf-8">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Oficina principal</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-2 text-center">
								<label>Oficina actual:</label>
							</div>
							<div class="col-md-8">
								<input class="form-control" disabled value="<?=$oficina[0]['nombre']?>"/>
							</div>
						</div>
						<br>
						<?php unset($oficina[0]); ?>
						<div class="row">
							<div class="col-md-2 text-center">
								<label>Nueva oficina:</label> 
							</div>
							<div class="col-md-8">
								<select class="form-control" name="nueva_primera">
								<?php 
                        
								foreach ($oficina as $of){
									?>
									<option value="<?=$of['ID_OFICINA'].'#'.$of['ORDEN']?>"><?=$of['nombre']?></option>
									<?php
								}
								
								?>
								</select>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<input type="submit" class="btn btn-primary pull-right" title="Guardar" value="Guardar"/>
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>
</div>