var app = new Vue({
  el: '#app-firmantes',
  data: {
    usuarios: [],
    firmantes: [],
    nuevos_firmantes: []
  },
  mounted: function() {
      var self = this;
      axios.get('/vu/expedientes/circuitos/get_usuarios/'+id_tramite+'/'+id_plantilla)
      .then(function(response){
          self.usuarios = response.data.usuarios;
          
      });
      
      axios.get('/vu/expedientes/circuitos/get_firmantes/'+id_tramite+'/'+id_plantilla)
      .then(function(response){
          self.firmantes = response.data.firmantes;
          
      });
  },
  methods:{
      quitar: function(index){
        var r = confirm("¿Confirma desvincular a "+this.firmantes[index].usuario+" de ser un firmante en este nodo? ");
        if(r == true){
            var self = this;
            axios.post('/vu/expedientes/circuitos/quitar_firmante/',{
                id_tram: id_tramite,
                id_plan: id_plantilla,
                id_firmante: self.firmantes[index].id
            })
            .then(function(response){
                self.firmantes = response.data.firmantes;
                self.usuarios = response.data.usuarios;
            });
        }
      },
      agregar: function(index){
            var add = true;
            var idx_rm = -1;
            for(var i = 0; i < this.nuevos_firmantes.length; i++){
                if(this.nuevos_firmantes[i].usuario == this.usuarios[index].username){
                    add = false;
                    idx_rm = i;
                }
            }
            if(add){
                this.nuevos_firmantes.push({
                    tramite_id: id_tramite,
                    plantilla_id: id_plantilla,
                    usuario: this.usuarios[index].username
                });
            }else{
                this.nuevos_firmantes.splice(idx_rm,1);
            }
      },
      confirmar: function(){
        var self = this
        axios.post('/vu/expedientes/circuitos/confirmar_nuevos_firmantes/',{
            id_tram: id_tramite,
            id_plan: id_plantilla,
            firmantes: JSON.stringify(self.nuevos_firmantes)
        })
        .then(function(response){
            self.firmantes = response.data.firmantes;
            self.usuarios = response.data.usuarios;
            $("#searchNewFirmante").modal('hide');
        });
      }
  }
})