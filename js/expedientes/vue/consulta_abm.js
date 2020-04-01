var app = new Vue({
    el: '#consulta-formulario',
    data: {
      titulo : "Editor de consultas",
      consulta:{id: 0,consulta:'',titulo:'',alias:'',placeholder:'',colums_table:''},
      campos: [],
      campos_del: []
    },
    mounted(){
        if(idcons > 0){
            this.getConsulta();
            this.getCampos();
        }
    },
    methods: {
        getConsulta: function(){
            axios.post('/vu/expedientes/consultas/get_consulta',{
                idcons: idcons
            }).then((response) => {
                if(response.data.status == "success")
                {
                    this.consulta = response.data.consulta;
                }
                else {alert(response.data.message);}
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        getCampos: function(){
            axios.get('/vu/expedientes/consultas/get_campos/'+idcons).then((response) => {
                if(response.data.status == "success")
                   this.campos = response.data.campos;
                else 
                    alert(response.data.message);
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        generarCampos: function(){
            axios.post('/vu/expedientes/consultas/generate_campos/',{
                sql: this.consulta.consulta, idcons: idcons
            }).then((response) => {
                if(response.data.status == "success"){
                    var data = response.data.campos;
                    var cantidad = [];
                    console.log(data);
                    for(var x=0; x<data.length; x++){
                        var existe = false;
                        var i=0
                        while(i<cantidad.length){
                            if(cantidad[i]['campo'] == data[x]['campo']){
                                existe = true;
                                break;
                            }
                            i++
                        }
                        if(existe){
                            cantidad[i]['cantidad'] = cantidad[i]['cantidad']+1;
                        } else {
                            cantidad.push({campo:data[x]['campo'], cantidad:1});
                        }
                    }
                    for(var n=0; n<cantidad.length; n++){
                        var i=0;
                        while(i<this.campos.length){
                            if(this.campos[i]['campo'] == cantidad[n]['campo']){
                                cantidad[n]['cantidad'] = cantidad[n]['cantidad']-1;
                            }
                            i++;
                        }
                    }
                    for(var z=0; z<cantidad.length; z++){
                        if(cantidad[z]['cantidad'] > 0){
                            for(var f=0; f<data.length; f++){
                                if(cantidad[z]['campo'] == data[f]['campo']){
                                    for(var x=0; x<cantidad[z]['cantidad']; x++){
                                        this.campos.push(data[f]);
                                        cantidad[z]['cantidad'] = cantidad[z]['cantidad']-1;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    console.log(cantidad);
                }
                else {
                    alert(response.data.message);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        guardarConsulta: function(){
            console.log("consulta: ",this.consulta);
            console.log("campos: ",this.campos);

            axios.post('/vu/expedientes/consultas/save_consulta',{
                consulta: this.consulta, campos: this.campos, camposdel: this.campos_del
            }).then((response) => {
                console.log(response.data);
                alert(response.data.message);
                if(response.data.status == "success"){
                    window.location="/vu/expedientes/consultas/listar";
                }
            })
            .catch(function (error) {
                console.log('Aca');
                console.log(error);
            });
        },
        quitarCampo: function(index){
            if(this.campos[index].id > 0){
                //si el campo tiene id > 0 entonces existen en bd y hay que eliminarlo, lo agrego a una lista de campos a eliminar
                this.campos_del.push(this.campos[index]);
            }
            this.campos.splice(index,1);
            console.log("campos a eliminar: ",this.campos_del);

        },
    },
});