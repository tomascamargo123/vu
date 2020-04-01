<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Firmantes
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="expedientes/<?php echo $controlador; ?>"><?php echo ucfirst($controlador); ?></a></li>
            <li class="active"><?php echo ucfirst($metodo); ?></li>
        </ol>
    </section>
    <section class="content" id="app-firmantes">
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
                        <h3 class="box-title">Lista de firmantes</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <!-- MI CODIGO  -->
                        <ul class="list-group">
                            <li class="list-group-item" v-for="(item,index) in firmantes">
                                <a v-on:click.prevent="quitar(index)"><span style="float: right"><i class="fa fa-trash-o"></i></span></a>
                              {{item.DetaPers}} ( {{item.usuario}} )
                            </li>
                          </ul>


                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default" href="<?= base_url('/expedientes/tramites/listar'); ?>" title="Volver">Volver</a>
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#searchNewFirmante" style="float: right;" title="Agregar Firmante">Agregar Firmante</a>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Modal -->
        <div class="modal fade" id="searchNewFirmante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Buscar Firmante</h4>
              </div>
              <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item" v-for="(item,index) in usuarios">
                        <input type="checkbox" class="checkbox" v-on:change="agregar(index)" v-model="item.checked" style="float: right">
                      {{item.DetaPers}} ( {{ item.username}} )
                    </li>
                  </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" v-on:click="confirmar()">Confirmar</button>
              </div>
            </div>
          </div>
        </div>
        
    </section>
</div>
<script>
var id_tramite = <?=$idtram?>;
var id_plantilla = <?=$idplan?>;
</script>
