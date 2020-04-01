<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script>
$(document).ready(function() {
		$('#editor-control').ckeditor();
	});
</script>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>
            Vista previa del formulario
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
                    <!-- Mi codigo -->
                    <div class="box-header with-border">
                        <h3 class="box-title">{{formulario.nombre}}</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        <!--<form v-on:submit.prevent="onSubmit">-->
                        <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#searchModal">{{consulta.titulo}}</button>
                        <form method="post" action="<?=base_url('expedientes/plantillas/create_pdf')?>">
                            <input type="hidden" name="idplant" value="<?= $idplan; ?>"/>
                            <div class="form-group" v-for="item in elements">
                                <div v-if="item.type != 'submit'" >
                                    <label for="item.name">{{item.label}}</label>
                                    <input v-if="item.element == 'input'" v-on:keyup="actionInput(item)" v-bind:type="item.type" v-bind:class="item.class" v-bind:id="item.name" v-bind:name="item.name" v-model="item.value">
                                    <select v-if="item.element == 'select'" v-bind:class="item.class" v-bind:id="item.name" v-bind:name="item.name" v-html="item.options" v-model="item.value">

                                    </select>
                                    <textarea v-if="item.element === 'textarea'" v-bind:class="item.class" v-model="item.value" v-bind:id="item.class"></textarea>
                                    <p>cadena que se reemplazara #{ {{item.name}} }</p>
                                </div>
                                <div v-else-if="item.type == 'submit'">
                                    <input v-if="item.element == 'input'" v-bind:type="item.type" v-bind:class="item.class" v-bind:id="item.name" v-bind:value="item.label" data-toggle="modal" data-target=".ventana-pdf">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <!-- fin de mi codigo -->
                </div> 
            </div>
        </div>
    </section>
<div class="modal fade ventana-pdf" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" v-html="pdf_result">
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchPersLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="searchModalLabel">{{consulta.titulo}}</h4>
      </div>
      <div class="modal-body">
        
              <div class="col-lg-6">
                <div class="input-group">
                  <input type="text" class="form-control" v-model="search">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" v-on:click="searchData">Buscar</button>
                  </span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <hr>
              <div class="col-lg-8">
                  <table v-if="data_search" class="table tab-bordered table-striped">
                      <thead>
                          <tr>
                              <th v-for="item in data_search.head">{{item}}</th> 
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="item in data_search.body">
                              <td>{{item.col1}}</td>
                              <td>{{item.col2}}</td>
                              <td><button v-on:click="pushData(item)" class="btn btn-success">Seleccionar</button></td>
                          </tr>
                      </tbody>
                  </table>
              </div>
              
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

</div>

<script type="text/javascript">
var idplant = <?= $idplan; ?>;
var idform = <?= $idform; ?>;
var array_w = new Array();
new Vue({
    el: "#app",
    created: function () {
        this.getElements();
    },
    data: {
        elements: [],
        campos: [],
        formulario: [],
        pdf_result: '',
        cant_cond: 0,
        consulta: [],
        search: '',
        data_search:[],
    },
    methods: {
        getElements: function () {
            axios.post("<?= base_url('expedientes/plantillas/get_form_data') ?>", {
                id_form: idform,
            }).then(response => {
                //console.log(response.data);
                this.elements = response.data;
            });


            axios.post("<?= base_url('expedientes/plantillas/get_form_by_id') ?>", {
                id_form: idform,
            }).then(response => {
                //console.log(response.data);
                this.formulario = response.data;
            });
            
            axios.post("<?= base_url('expedientes/plantillas/get_elements_consulta') ?>",{
                id_form: idform,
            }).then(response => {
                //console.log(response.data);
                this.campos = response.data;
                for(var  i = 0; i < this.campos.length; i++){
                    if(this.campos[i].where == 1){
                        this.cant_cond++;
                    }
                }
            });
            axios.post("<?= base_url('expedientes/plantillas/get_consulta') ?>",{
                id_form: idform,
            }).then(response => {
                //console.log(response.data);
                this.consulta = response.data[0];
            }).catch(function (error) {
             console.log(error);
            });
        },
        onSubmit: function(){
            axios.post("expedientes/plantillas/create_form",{
                data: this.elements,
                idplant: idplant,
            }).then(response => {
                //se retornara el nombree del archivo pdf que resulta de esta plantilla
                this.pdf_result = '<object type="application/pdf" data="'+response.data+'" width="100%" height="500" style="height: 85vh;">No Support</object>';
            }).catch(function (error) {
             console.log(error);
            });
        },
        searchData:  function(){
            let campo_w ='';
            for(var  i = 0; i < this.campos.length; i++){
                if(this.campos[i].where == 1){
                    campo_w = this.campos[i].alias;
                    break;
                }
            }
            
            axios.post("expedientes/plantillas/search_data",{
                buscar: this.search,
                consulta: this.consulta.consulta,
                campow: campo_w,
            }).then(response => {
                console.log(response.data);
                this.data_search = response.data;
            });
        },
        pushData: function(item){
            
            var datadb = item;
            
            if(datadb != null){
                for(var  i = 0; i < this.elements.length; i++){
                    for(var  j = 0; j < this.campos.length; j++){
                        if(this.elements[i].name == this.campos[j].alias){
                            this.elements[i].value = datadb[this.campos[j].campo];
                        }
                    }
                }
            }
            $('#searchModal').modal('hide')
        }
    }
});
</script>
