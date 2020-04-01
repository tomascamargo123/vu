<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>
            Formularios
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
                        <h3 class="box-title">Administración de Formulario</h3><br>
                        <a class="btn btn-info" href="<?= base_url('expedientes/plantillas/crear_form/' . $idplantilla); ?>">Crear Nuevo Formulario</a>
                    </div>

                    <div class="box-body">
                        <!-- MIS FORMULARIOS -->
                        <h4 class="box-title">Mis formularios</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tabla referenciada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in myforms">
                                    <td>{{item.nombre}}</td>
                                    <td>{{item.titulo}}</td>
                                    <td>
                                        <button v-on:click="removeForm(item.id)" class="btn btn-danger">Quitar</button>
                                        <button v-on:click="redirectPage(item.id)" class="btn btn-info">Ver</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <!-- FORMULARIOS DISPONIBLES -->
                        <h4 class="box-title">Elegir formulario a agregar.</h4>
                        
                        <!--  -->
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tabla referenciada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in forms">
                                    <td>{{item.nombre}}</td>
                                    <td>{{item.titulo}}</td>
                                    <td>
                                        <button v-on:click="addForm(item.id)" class="btn btn-success">Agregar</button>
                                        <button v-on:click="redirectPage(item.id)" class="btn btn-info">Ver</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- fin de mi codigo -->
                </div> 
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
var idplantilla = <?= $idplantilla; ?>;
var urlform = "<?=  base_url('expedientes/plantillas/get_forms/'.$idplantilla);?>";
var urlmyforms = "<?=  base_url('expedientes/plantillas/get_my_forms_get/'.$idplantilla);?>";
var urlaction = "<?=  base_url('expedientes/plantillas/action_form_themplate');?>";
new Vue({
    el: "#app",
    created: function(){
        this.loadArrays();
    },
    data: {
        forms: [],
        myforms: []
    },
    methods: {
        loadArrays: function(){
            axios.get(urlform).then(response => {
                console.log(response.data);
                this.forms = response.data;
            });
            
            axios.get(urlmyforms).then(response => {
                console.log(response.data);
                this.myforms = response.data;
            });
        },
        addForm: function(idf){
            axios.post(urlaction,{
                action : "add",
                idform : idf,
                idplant: idplantilla,
            }).then(response => {
                this.loadArrays();
            }).catch(function (error) {
             console.log(error);
            });
        },
        removeForm: function(idf){
            axios.post(urlaction,{
                action: "remove",
                idform : idf,
                idplant: idplantilla,
            }).then(response => {
                this.loadArrays();
            });
        },
        redirectPage: function(idform){
            location.href= "<?php echo base_url('expedientes/plantillas/ver_formulario');?>/"+idplantilla+"/"+idform;
        },
        
    }
});
</script>