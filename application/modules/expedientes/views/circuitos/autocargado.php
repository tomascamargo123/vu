<div class="content-wrapper" id="datos-formulario">
	<section class="content-header">
		<h1>
			Circuito
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
                        <div class="forumalios-list" v-for="(form,index_f) in formularios">
                            <h3>{{ form.nombre }}</h3>
                            <table class="table table-hover table-bordered table-condensed dt-responsive">
                                <thead>
                                    <tr>
                                        <th>Elemento</th>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Plantilla_origen</th>
                                        <th>Alias_origen</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(elem,index_e) in form.elements">
                                        <td>{{elem.element}}</td>
                                        <td>{{elem.type}}</td>
                                        <td>{{elem.name}}</td>
                                        <td>
                                            <select v-show="form.plantillas_before.length" v-on:change="load_alias(index_f,index_e)" v-model="elem.plantilla_origen">
                                                <option value="0"></option>
                                                <option v-for="plant in form.plantillas_before" v-bind:value="plant.id">{{ plant.nombre }}</option>
                                            </select>
                                            </td>
                                            <td>
                                            <select v-if="elem.plantilla_origen != null && elem.plantilla_origen != 0" v-model="elem.alias_origen">
                                                <option value=""></option>
                                                <option v-for="item in elem.alias_list" v-bind:value="item.name" >{{ item.name }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-success" v-on:click="save_refence(elem)">Guardar cambio</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
var idtram = <?=$idtram?>;
var idplan = <?=$idplan?>;
var orden = <?=$orden?>;
</script>