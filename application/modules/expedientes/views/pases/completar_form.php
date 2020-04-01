<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<link href="<?= base_url().'css/expedientes/formularios_dinamicos.css'; ?>">
<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>
            <?php echo (empty($titulo_pagina) ? 'Vista previa del formulario' : $titulo_pagina); ?>
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
        <?php if(!empty($idplan)){ ?>
            <div class="alert alrt-info alert-dismissable box box-primary">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <div class="row">
                    <div class="col-md-2 col-md-offset-1 circulo-origen">
                        <p style="margin-top: 30px;"><?= $origen_oficina ?></p>
                    </div>
                    <div class="col-md-1">
                        <img src="img/expedientes/next_node.png" class="img img-responsive center-block" style="margin-top: 20px;">
                    </div>
                    <div class="col-md-2 circulo-destino">
                        <p style="margin-top: 30px;"><?= $destino_oficina ?></p>
                    </div>
                    <div class="col-md-5 col-md-offset-2">
                        <p>Si usted pretende realizar un pase saliendo del circuito de expediente electronico pulse en el boton debajo del presente texto.</p>
                        <p style="text-align: right;"><a href="<?= "expedientes/pases/enviar/$idpase/enviar/$idexp/1" ?>" class="btn btn-primary btn-xs">Salir de circuito</a></p>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <!-- Mi codigo -->
                    <div class="col-xs-6" style="border-right: 1px solid blue;">
                        <form id="form_plantilla" name="form_plantilla" method="post" action="<?=base_url('expedientes/pases/revision')?>">
                            <input type="hidden" name="fecha" value="<?=  date('d-m-Y')?>">
                            <fieldset v-for="(form, index) in autoCompletarHistorial(vforms)" v-bind:id="'form_'+index" class="form-group" style="margin-top: 3em;">
                                <legend>{{form.nombre}}</legend>
                                <!--<button class="btn btn-primary" style="float: right;" v-on:click.prevent="mostrarModal(form,index)">{{form.consulta[0].titulo}}</button>-->
                                <input type="hidden" name="idplant" value="<?= $idplan; ?>"/>
                                <input type="hidden" name="idexp" value="<?= $idexp; ?>"/>
                                <input type="hidden" name="idtram" value="<?= $idtram; ?>"/>
                                <div class="form-group" v-for="(element, index_e) in form.elements">
                                    <div v-if="element.type != 'submit'" >
                                        <label for="element.name">{{element.label}} {{ toBoolean(element.isrequired) ? "*" : "" }}</label>
                                        <input v-if="element.element == 'input'" v-bind:type="element.type" v-bind:class="element.class" v-bind:id="element.name" v-bind:name="element.name" v-model="element.value" v-bind:readonly="toBoolean(element.disable)" v-bind:required="toBoolean(element.isrequired)">
                                        <select v-if="element.element == 'select'" v-bind:class="element.class" v-bind:id="element.name" v-bind:name="element.name" v-html="element.options" v-model="element.value" v-bind:disabled="toBoolean(element.disable)" v-bind:required="toBoolean(element.isrequired)">

                                        </select>
                                        <textarea v-if="element.element === 'textarea'" v-bind:class="element.class" v-bind:id="element.class" v-bind:name="element.name" v-model="element.value" v-bind:readonly="toBoolean(element.disable)" v-bind:required="toBoolean(element.isrequired)"></textarea>
                                    </div>
                                </div>


                            </fieldset>
                            
                            <?php if($firma_pad > 0) { ?>
                            <div id="form_pad_sign">
                                <div class="alert alert-success" role="alert" id="alert-message-pad"></div>
                                
                                <table border="1" cellpadding="0"  width="500">
                                  <tr>
                                    <td height="250" width="500">
                                        <!-- canvas de firma del pad -->
                                        <canvas id="cnv" name="cnv" width="500" height="250"></canvas>
                                    </td>
                                  </tr>
                                </table>
                                <br>
                                <p>
                                    <textarea type="hidden" name="firmapad" id="firmapad" cols="5" class="form-control" style="display: none;"></textarea>
                                    <br>
                                    <!-- botones de escucha y borrado de firma -->
                                    <input id="SignBtn" class="btn btn-info btn-sm" name="SignBtn" type="button" value="Firmar"  onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="button1" class="btn btn-warning btn-sm" name="ClearBtn" type="button" value="Borrar firma" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp

                                     <input id="button2" class="btn btn-danger btn-sm" name="DoneBtn" type="button" value="Cargar firma" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp
                                </p>
                                <div id="show_firmas"class="alert alert-success">
                                    <p>Firmas:</p>
                                </div>
                            </div>
                            <?php } ?>
                            <input type="submit" value="Enviar" class="btn btn-primary btn-lg" style="float: right;">
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <br>
                        <h4>Filtros Relacionados</h4>
                        <div id="container_form" v-for="(form, index_f) in vforms" style="height: 650px;overflow-y: scroll;">
                            <div v-if="form.ver_filtro" >
                            <h4>{{form.nombre}}</h4>
                            <form v-on:submit.prevent="searchData(index_f)" v-bind:id="'form_'+index_f">
                                <div v-if="form.consulta[1]">
                                    <p>Seleccione consulta:</p>
                                    <select v-model="form.consulta_index" v-on:change="cambiarPlaceholder(index_f)">
                                        <option v-for="(clta, index_c) in form.consulta" v-bind:value="index_c">{{clta.titulo}}</option>
                                    </select>
                                </div>
                                <p v-bind:id="'search_txt_'+form.id">Buscar por {{form.consulta[0].placeholder}}:</p>
                                <input type="text" v-model="form.search_param">
                                <input type="submit" class="btn btn-primary btn-sm" value="Buscar">
                            </form>
                            <div v-if="form.data_table.error" class="panel panel-danger text-center">
                                <p style="margin-top: 10px;">{{ form.data_table.error }}</p>
                            </div>
                            <table v-if="!form.data_table.error" class="table table-hover table-striped tab-bordered table-dinamic">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th v-for="col in getColumnas(index_f)">{{col}}</th>
                                    </tr>
                                </thead>
                                <tbody v-bind:id="'body_form_'+form.id" v-bind:id="'tbody_form_'+form.id">
                                    <tr v-for="(item, index) in form.data_table" v-bind:id="'row_'+index" v-on:click="loadNextTable(index_f,item)">
                                        <td>
                                            <a href="#" v-on:click.prevent="loadDataForm(index_f,item)"><i class="glyphicon glyphicon-arrow-left success"></i></a>
                                        </td>
                                        <td class="col1">{{ item.col1 }}</td>
                                        <td class="col2">{{ item.col2 }}</td>
                                        <td class="col3">{{ item.col3 }}</td>
                                        <td class="col4">{{ item.col4 }}</td>
                                        <td v-if="item.col5 != null" class="col5">{{ item.col5 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <?php } ?>
    </section>

    

</div>

<script type="text/javascript">
var idplant = <?= $idplan; ?>;
var id_exp = <?= $idexp;?>;
</script>

<script type="text/javascript" src="<?= base_url().'js/expedientes/vue/dinamic_forms_vue.js'?>"></script>

<!-- firma pad -->
<?php if($firma_pad > 0){ ?>
<!-- funciones jquery pad de firmas -->
<script type="text/javascript">
var cant_firmas = <?= $firma_pad ?>;
var contador_f = 0;
$(document).ready(function(){
    $("#alert-message-pad").hide();
        $("#show_firmas").hide();
    $("#SignBtn").click(function(){
        $("#alert-message-pad").html("<p>El pad de firmas se encuentra listo para firma. Total de firmas disponibles "+cant_firmas+"</p>");
        $("#alert-message-pad").show('slow');
        $("#show_firmas").show('slow');
    });
});
</script>
<!-- pad de firmas -->


<script type="text/javascript">
var tmr;

function onSign()
{
   var ctx = document.getElementById('cnv').getContext('2d');         
   SetDisplayXSize( 500 );
   SetDisplayYSize( 250 );
   SetTabletState(0, tmr);
   SetJustifyMode(0);
   ClearTablet();
   if(tmr == null)
   {
      tmr = SetTabletState(1, ctx, 50);
   }
   else
   {
      SetTabletState(0, tmr);
      tmr = null;
      tmr = SetTabletState(1, ctx, 50);
   }
}
function onClear()
{
   ClearTablet();
}
function onDone()
{
   if(NumberOfTabletPoints() == 0)
   {
      alert("Please sign before continuing");
   }
   else
   {
       contador_f++;
       if(cant_firmas == contador_f){
            SetTabletState(0, tmr);//bloquea el firmador
       }
      //RETURN BMP BYTE ARRAY CONVERTED TO BASE64 STRING
      SetImageXSize(500);
      SetImageYSize(250);
      SetImagePenWidth(1);
      GetSigImageB64(SigImageCallback);
   }
}
function SigImageCallback( str )
{  
   let html_str = $("#show_firmas").html();
   $("#show_firmas").html(html_str+'<img src="data:image/png;base64,'+str+'" height="75" width="150"><span>&nbsp&nbsp</span>');
   document.form_plantilla.firmapad.value += str+"<separator>";
}
</script> 


<script type="text/javascript">
window.onunload = window.onbeforeunload = (function(){
closingSigWeb();
})

function closingSigWeb()
{
   ClearTablet();
   SetTabletState(0, tmr);
}

</script>
<?php } ?>