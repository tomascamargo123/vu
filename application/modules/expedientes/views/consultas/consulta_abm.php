<div class="content-wrapper" id="consulta-formulario">
	<section class="content-header">
		<h1>
			Consultas
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
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
						<h3 class="box-title">{{titulo}}</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
                        <!-- mi codigo -->
						<form v-on:submit.prevent="guardarConsulta">
							<h3>Consulta</h3>
							<div class="form-group">
								<label for="titulo">Titulo</label>
								<input type="text" class="form-control" id="titulo" v-model="consulta.titulo">
							</div>
							<div class="form-group">
								<label for="alias">Alias</label>
								<input type="text" class="form-control" id="alias" v-model="consulta.alias">
							</div>
							<div class="form-group">
								<label for="placeholder">Placeholder</label>
								<input type="text" class="form-control" id="placeholder" v-model="consulta.placeholder">
							</div>
							<div class="form-group">
								<label for="columnas">Inserte nombre de las primeras 4 columnas a ver en la busqueda</label>
								<input type="text" class="form-control" id="columnas" placeholder="colum1,colum2,colum3,..." v-model="consulta.colums_table">
							</div>
							<div class="form-group">
								<label for="consulta">SQL</label>
								<pre><textarea class="form-control" v-model="consulta.consulta" cols="30" rows="10"></textarea></pre>
							</div>
							<hr>
							<h3>Campos</h3>
							<button class="btn btn-info" type="button" v-on:click="generarCampos">Generar Campos a partir de consulta</button>
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>Campo</th>
										<th>Alias</th>
										<th>In Where</th>
										<th width="10">Quitar</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item,index) in campos">
										<td>{{item.campo}}</td>
										<td>
											<input type="text" v-model="item.alias" class="form-control">
										</td>
										<td>
											<select v-model="item.where">
												<option value="0">No</option>
												<option value="1">Si</option>
											</select>
										</td>
										<td>
											<a class="btn btn-danger" v-on:click="quitarCampo(index)" ><i class="fa fa-trash" aria-hidden="true"></i>Quitar</a>
										</td>
									</tr>
								</tbody>
							</table>
							<br>
							<a href="javascript: history.go(-1)" class="btn btn-default">Volver</a>
							<button type="submit" class="btn btn-primary pull-right">Guardar</button>
						</form>
                        <!-- fin mi codigo -->
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
var idcons = <?=(empty($id_consulta) ? 0 : $id_consulta)?>;

</script>