
new Vue({
    el: '#app',
    data: {
        vforms: [],//dentro de cada form estaran su array de campos y array de consulta
        str_search: '',//string a buscar en la consulta dinamica
        result_data: [],//tendra el resultado de lo devuelto por la query
        tbody_index: 0,//sera el index de la tabla a cargar
    },
    created: function(){
        this.getFormularios();
    },
    updated: function(){
        $('#editor-control').ckeditor({toolbar: 'Basic'});
    },
    methods:{
        getFormularios: function(){
            axios.post('expedientes/plantillas/get_my_forms_complete',{
                idplant: idplant,idexp: id_exp
            }).then((response) => {
                console.log(response.data);
                this.vforms = response.data;
                this.loadSolicitante();
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        getColumnas: function(index_f){
           //console.log(str_columns);
           return this.vforms[index_f].consulta[this.vforms[index_f].consulta_index].colums_table.split(',');
        },
        cambiarPlaceholder: function(index_f){
            $("#search_txt_"+this.vforms[index_f].id).text("Buscar por "+this.vforms[index_f].consulta[this.vforms[index_f].consulta_index].placeholder+":");
        },
        searchData: function(index_f){
            //busco el campo de filtro principal de la consulta entre los campos que formaran parte del formulario
            var campo_w = '';
            var consulta_id = this.vforms[index_f].
                    consulta[this.vforms[index_f].
                        consulta_index].id;
            this.vforms[index_f].campos_key.forEach(function(value,index) {
                if(value.where == 1 && value.consulta_id == consulta_id){ 
                    campo_w = value.alias;
                }
            });
            
            //traigo los resultados y los pongo el la tabla
            let este =  this;
            axios.post("expedientes/plantillas/search_data",{
                buscar: this.vforms[index_f].search_param,
                consulta: this.vforms[index_f].
                        consulta[this.vforms[index_f].
                            consulta_index].consulta,
                campow: campo_w,
            }).then(function (response){
                este.vforms[index_f].data_table = response.data;
                if(index_f == 0){
                    for(var i = 0; i < este.vforms.length; i++){
                            if(i == 0){
                                continue;
                            }
                            if(response.data.length == 1){
                                este.vforms[i].search_param = response.data[0].col1;
                                este.searchData(i);
                                este.vforms[i].search_param = '';
                            }else{
                                este.vforms[i].search_param = '';
                                este.vforms[i].data_table.error = "Debe seleccionar una persona";
                            }
                        }
                }
            });
            
            if(this.vforms[index_f].data_table['error']){
                $("#body_form_"+this.vforms[index_f].id).hide();
            }else{
                $("#body_form_"+this.vforms[index_f].id).show();
            }
        },
        loadNextTable: function(index_f,row){
            if(row.col1 != '' && this.vforms.length >= (index_f+1)){
                if(this.vforms[index_f+1] !== undefined){
                    this.vforms[index_f+1].search_param = row.col1;
                    this.searchData(index_f+1);
                    this.vforms[index_f+1].search_param = '';
                    for(var i = index_f+2; i < this.vforms.length; i++){
                        this.vforms[i].data_table = new Array();
                    }
                }  
            }else{
                if(row.col1 == '' && this.vforms.length >= (index_f+1)){
                    this.vforms[(index_f+1)].search_param = '';
                    this.vforms[(index_f+1)].data_table.error = "No hay dato para relacionar";
                }
            }
        },
        loadDataForm: function(index_f,row){
            for(var i = 0; i < this.vforms[index_f].elements.length; i++){
                for(var j = 0; j < this.vforms[index_f].campos_key.length; j++){
                    if(this.vforms[index_f].elements[i].name == this.vforms[index_f].campos_key[j].alias){
                        this.vforms[index_f].elements[i].value = row[this.vforms[index_f].campos_key[j].campo];
                        break;
                    }
                }
            }
        },
        loadSolicitante: function(){
            if(id_exp != '0'){
                //esta funcion se ejecutara para cargar la tabla perteneciente al primer formulario
                let este = this;
                axios.get("expedientes/pases/get_solicitante_data/"+id_exp,{
                }).then(function (response) {
                    console.log(response);
                    if(response.data === null){
                        este.vforms[0]['search_param'] = returnCuil(id_exp); 
                    } else {
                        console.log(response.data.cuil);
                        este.vforms[0]['search_param'] = response.data.cuil;  
                    }
                    este.searchData(0);
                });
            }
        },
        toBoolean: function(value){
            if(value == "1")
                return true;
            else
                return null;
        },
        autoCompletarHistorial: function(vforms){
            for(var i = 0; i < vforms.length; i++){
                vforms[i]['elements'].forEach(function(element){
                    if(element['plantilla_origen'] > 0){
                        axios.get("expedientes/plantillas/buscarhistorial/"+id_exp+"/"+element['alias_origen'],{}).then(function(response){
                            element['value'] = response.data.value;
                        });
                    }
                });
            }
            this.vform = vforms;
            return this.vforms;
        },
    }
});

function returnCuil(id_exp){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'expedientes/pases/get_solicitante_data/'+id_exp, true);
    xhr.onreadystatechange = function (data){
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                return xhr.responseText;
            }
        }
    };
    xhr.send(null);
}