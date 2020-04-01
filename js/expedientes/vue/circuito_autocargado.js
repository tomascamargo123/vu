var app = new Vue({
    el: '#datos-formulario',
    data: {
      titulo : "Autocargado de Formulario",
      formularios: []
    },
    mounted(){
      this.getFormularios();
      console.log(this.formularios);
    },
    methods:{
      getFormularios: function(){
          axios.post('/vu/expedientes/circuitos/get_elements_formulario',{
              idplan: idplan, idtram: idtram, orden: orden
          }).then((response) => {
            this.formularios = response.data;

            for(var index_f = 0; index_f < this.formularios.length; index_f++){
              for(var index_e = 0; index_e < this.formularios[index_f].elements.length; index_e++){
                if(this.formularios[index_f].elements[index_e].alias_origen != null){
                  this.load_alias(index_f,index_e);
                  console.log("ALIAS ORIGEN: ",this.formularios[index_f].elements[index_e].alias_origen);
                }
              }
            }

          })
          .catch(function (error) {
              console.log(error);
          });
      },
      load_alias: function(index_f,index_e){
        if(this.formularios[index_f].elements[index_e].plantilla_origen == 0) return;

        console.log("event successfull",index_f,index_e);
        axios.post('/vu/expedientes/circuitos/get_alias_list_formulario',{
            idplant: this.formularios[index_f].elements[index_e].plantilla_origen
        }).then(response => (this.formularios[index_f].elements[index_e].alias_list = response.data))
        .catch(function (error) {
            console.log(error);
        });
      },
      save_refence: function(elem){
          axios.post('/vu/expedientes/circuitos/save_reference',{
              form_element_id: elem.form_element_id,
              formulario_id: elem.formulario_id,
              element_id: elem.element_id,
              tramite_id: idtram,
              plantilla_origen: elem.plantilla_origen,
              alias_origen: elem.alias_origen
          }).then((response) => {
            console.log(response.data.status);
            alert(response.data.message);
          })
          .catch(function (error) {
              console.log(error);
          });
      }
      
    }
  });