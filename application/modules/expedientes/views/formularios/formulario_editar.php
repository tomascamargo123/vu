<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Formulario
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
                        <h3 class="box-title">Administración de Formulario</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        

                        <h4 class="box-title">Agregar elementos al formulario</h4>
                        <!--  -->
                        <div id="app">
                            <!--                            <div>
                                                            {{ $data | json }}
                                                        </div>-->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Elemento de formulario</th>
                                        <th>Elemento</th>
                                        <th>type</th>
                                        <th>class</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="item in elements">
                                        <th>{{item.id}}</th>
                                        <td>
                                            <input v-if="item.element === 'input'" v-bind:type="item.type" v-bind:class="item.class"/>
                                            <select v-if="item.element === 'select'" v-bind:class="item.class" v-html="item.options">

                                            </select>
                                            <textarea v-if="item.element === 'textarea'" v-bind:class="item.class"></textarea>
                                        </td>

                                        <td>{{item.element}}</td>
                                        <td>{{item.type}}</td>
                                        <td>{{item.class}}</td>
                                        <td>
                                            <button v-on:click="agregarItem(elements.indexOf(item))" class="btn btn-primary">Agregar Elemento</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <h3>Nombre de formulario</h3>
                            <div class="panel panel-danger" v-if="mensajes != ''" >
                                <div class="panel-heading">
                                    <ul>
                                        <li v-for="msj in mensajes">{{msj}}</li>
                                    </ul>
                                </div>
                            </div>
                            <input type="text" v-model="formname" placeholder="Nombre de formulario" class="form-control"/>
                            <hr>
                            <h3>Elementos</h3>
                            <div v-if="campos != ''" style="padding: 10px; background-color: #0089db;color: white;width: 100%;">
                                <p>Nombre de disponibles sugeridos:</p>
                                <p> 
                                    <span v-for="c in campos">
                                        '{{ c.alias}}' 
                                    </span>
                                </p>
                                <p>Campos por el cual se filtrara la informacion: <span v-for="c in campos" v-if="c.where == 1">'{{c.alias}}' </span></p>
                            </div>
                            
                            <div class="form-group">
                                <label for="select_cons">Consulta:</label>
                                <select class="form-control" v-on:change="showFields()" id="select_cons">
                                    <option value="">Seleccione...</option>
                                    <option v-for="cons in listacons" v-bind:value="cons.id">{{cons.titulo}}</option>
                                </select>
                            </div>
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Elemento de formularo</th>
                                        <th>Tipo de campo</th>
                                        <th>Name</th>
                                        <th>Label</th>
                                        <th>Required</th>
                                        <th>Disable</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item2, index) in elemyform" v-bind:id="item2.item_id">
                                        <td>
                                            <input v-if="item2.elem.element === 'input'" v-bind:type="item2.elem.type" v-bind:class="item2.elem.class" disabled="true"/>
                                            <select v-if="item2.elem.element === 'select'" v-bind:class="item2.elem.class" v-html="item2.elem.options"  disabled="true">

                                            </select>
                                            <textarea v-if="item2.elem.element === 'textarea'" v-bind:class="item2.elem.class"  disabled="true"></textarea>
                                        </td>
                                        <td>
                                            <input type="text"  class="form-control" v-model="item2.elem.type" disabled="true"/>
                                        </td>
                                        <td>
                                            <input type="text"  class="form-control" v-model="item2.name"/>
                                        </td>
                                        <td>
                                            <input type="text"  class="form-control" v-model="item2.label"/>
                                        </td>
                                        <td>
                                            <input type="checkbox" v-model="item2.required"/>
                                        </td>
                                        <td>
                                            <input type="checkbox" v-model="item2.disable"/>
                                        </td>
                                        <td>
                                            <button @click="eliminarItem(index)" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary" v-if="elemyform.length > 0" v-on:click="editarFormulario()">Guardar</button>
                        </div>
                    </div>
                    <!-- fin de mi codigo -->
                </div> 
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
var urlElements = "<?php echo base_url('expedientes/plantillas/get_elements_json'); ?>";
var urlConsulta = "<?php echo base_url('expedientes/plantillas/get_consultas_json'); ?>";
var urlcampos = "<?php echo base_url('expedientes/plantillas/get_campos_json'); ?>";
new Vue({
    el: "#app",
    created: function () {
        this.getElements();
        this.getConsultas();
    },
    data: {
        elements: [],
        elemyform: [],
        listacons: [],
        fueSelec: false,
        arraykey: [],
        formname:  '',
        campos: [],
        mensajes: [],
        idc: 0,
    },
    methods: {
        getElements: function () {
            axios.get(urlElements).then(response => {
                this.elements = response.data;
                this.getFormData();
            });
        },
        getFormData: function(){
            axios.get("<?php echo base_url('expedientes/formularios/editar_data/'.$idplantilla); ?>").then(response => {
                for(var x=0; x<response.data["formitems_data"].length; x++){
                    var elem;
                    for(var i=0; i<this.elements.length; i++){
                        if(this.elements[i]["id"] === response.data["formitems_data"][x]["element_id"]){
                            elem = this.elements[i];
                            break;
                        }
                    }
                    var efp = new ElemenFormPlant(elem);
                    efp.plantilla_id = <?=$idplantilla?>;
                    efp.name = response.data["formitems_data"][x]["name"];
                    efp.label = response.data["formitems_data"][x]["label"];
                    if(response.data["formitems_data"][x]["isrequired"] === "1"){efp.required = true;}
                    if(response.data["formitems_data"][x]["disable"] === "1"){efp.disable = true;}
                    this.elemyform.push(efp);
                    console.log("new item loaded: ",efp);
                }
                this.formname = response.data["formattr_data"][0]["nombre"];
                this.idc = response.data["formattr_data"][0]["consulta_id"];
                document.getElementById('select_cons').value = response.data["formattr_data"][0]["consulta_id"];
            });
        },
        agregarItem: function(index){
            var elem = this.elements[index];
            var efp = new ElemenFormPlant(elem);
            this.item_id = this.item_id + 1;
            efp.item_id = this.item_id;
            efp.plantilla_id = <?=$idplantilla?>;
            this.elemyform.push(efp);
        },
        eliminarItem: function(elem){
            this.elemyform.splice(elem, 1);
        },
        getConsultas: function(){
            axios.get(urlConsulta).then(response => {
                this.listacons = response.data;
            });
        },
        editarFormulario: function(){
            var campo_key = false;
            var cant = this.arraykey.length;
            var cont = 0;
            for(var i = 0; i < this.elemyform.length; i++){
                var item = this.elemyform[i];
                for(var j = 0;j < this.arraykey.length;j++){
                    var cadena = this.arraykey[j];
                    if(item.name == cadena){
                        cont++;
                    }
                }
                
//                console.log("cant: "+cant);
//                console.log("cont: "+cont);
                if(cant == cont){
                    campo_key = true;
                }
            }
            if(campo_key && this.formname != ''){
                axios.post(
                    "<?php echo base_url('expedientes/formularios/editarForm/'.$idplantilla); ?>",
                    {
                        formname: this.formname,
                        consultaid: this.idc,
                        formarray: this.elemyform,
                    }
                ).then( response => {
//                  console.log(response.data);
                    window.history.back();
                })
                .catch(e => {
//                  console.log("Error: "+e);
                });
            }else{
                if(this.formname == ''){
                    this.mensajes.push("El nombre de formularion no debe ser vacio."); 
                }
                
                if(!campo_key){
                    this.mensajes.push("Faltan campos claves para realizar el filtro.");
                }
            }
        },
        showFields: function(){
            this.idc = $("#select_cons").val();
            if(this.idc != ''){
                axios.post(urlcampos,{
                    idcons : this.idc,
                }).then(response =>{
                    this.campos = response.data;
                    var arrayk = [];
                    this.campos.forEach(function(item,index,array){
                        if(item.where == 1){
                            arrayk.push(item.alias);
                        }
                    });
                    this.arraykey = arrayk;
                });
            }else{
                this.campos = [];
            }
        }
    }
});

var ElemenFormPlant = class ElemenFormPlant{
    constructor(elem){
        this.elem = elem;
        this.plantilla_id = 0;
        this.id = 0;
        this.label = "";
        this.name = "";
        this.required = false;
        this.disable = false;
        this.eliminar = 0;
    }
}


</script>