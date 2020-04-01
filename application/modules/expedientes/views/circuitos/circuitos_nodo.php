

<style>
#div1, #div2, #div3 {
  float: left;
  width: 200px;
  height: 500px;
  overflow-y: scroll;
  padding: 10px;
  border: 1px solid black;
}

#div2{
    width: 60%;
}
.dv-ofic{
    height: 75px;
    width: 150px;
    border: solid 1px;
}
.dv-ofic{
    border-color: orange !important;
    border-radius: 10px !important;
}
.dv-deci{
    height: 100px;
    width: 200px;
    border: solid 1px;
    text-align: center;
    border-color: red !important;
    border-radius: 50% !important;
}
.dv-deci p{
    top: 30px;
}
.dv-docu{
    height: 100px;
    width: 100%;
    border: solid 1px;
    border-color: blue !important;
    border-radius: 5px !important;
}

</style>

<div class="content-wrapper">
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
						<h3 class="box-title">Circuito de tramite (<?= $tramite->nombre ?>)</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
                                            
                                            <!-- 
                                            your code
                                            -->
                                            
                                            
                                            <h2>Nuevo nodo</h2>
                                            <p>Dibuje el nuevo nodo arrastrando la oficina en los cuadros naranja, y el formulario a llenar en el cuadro azul.</p>

                                            <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                <h4 style="text-align: center;">Oficinas</h4>
                                                <?php
                                                foreach ($oficinas as $oficina){
                                                    ?>
                                                <div style="cursor: pointer;background-color: tomato;color: white;text-align: center;vertical-align: middle;margin-top: 5px;" draggable="true" ondragstart="drag(event)"  id="<?php echo 'ofic_'.$oficina['id']; ?>">
                                                    <input type="hidden" id="input_id" value="<?php echo $oficina['id']; ?>">
                                                    <?php echo $oficina['nombre']; ?>
                                                </div>
                                                    <?php
                                                }
                                                ?>
                                                
                                            </div>

                                            <div id="div2">
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <div class="dv-ofic">
                                                            <!-- Oficina inicial: Puede ser la oficina que toma el camino positivo o negativo del nodo anterior -->
                                                            <?php 
                                                            $index_ant = ($edit && $index_act > 1 ? $index_act-2 : sizeof($nodos)-1);
                                                            echo '<p>'.(sizeof($nodos) > 0 && $index_ant >= 0 ? $nodos[$index_ant]['oficina_origen'] : $this->session->userdata('oficina_actual')).'</p>';
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div style="text-align: center"><p><i class="fa fa-long-arrow-down fa-2x" aria-hidden="true"></i></p></div>
                                                
                                                <div class="row">
                                                    <div class="col-md-2 col-md-offset-5">
                                                        <div class="dv-docu" id="plantilla" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                            <!-- plantilla a llenar -->
                                                            <?php 
                                                            if($edit){
                                                                ?>
                                                                <div style="cursor: pointer;background-color: #24AA7A;color: white;text-align: center;vertical-align: middle;margin-top: 5px;" draggable="true" ondragstart="drag(event)" id="<?php echo 'plant_'.$formularios[$index_ant]['id']; ?>">
                                                                    <input type="hidden" id="input_id" value="<?php echo $formulario_act['id']; ?>">
                                                                    <?php echo $formulario_act['nombre']; ?>
                                                                </div>    
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="text-align: center"><p><i class="fa fa-long-arrow-down fa-2x" aria-hidden="true"></i></p></div>
                                                
                                                
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <div class="dv-ofic" id="oficina_si" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                            <!-- Oficina si-->
                                                            <?php 
                                                            if($edit){
                                                                ?>
                                                                <div style="cursor: pointer;background-color: tomato;color: white;text-align: center;vertical-align: middle;margin-top: 5px;" draggable="true" ondragstart="drag(event)"  id="<?php echo 'ofic_'.$oficina['id']; ?>">
                                                                    <input type="hidden" id="input_id" value="<?php echo $ofic_si['id']; ?>">
                                                                    <?php echo $ofic_si['nombre']; ?>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-4 col-md-offset-4">
                                                        <div class="dv-ofic" id="oficina_no" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                            <!-- Oficina no-->
                                                            <?php 
//                                                            if($edit){
                                                                ?>
                                                                <!-- <div style="cursor: pointer;background-color: tomato;color: white;text-align: center;vertical-align: middle;margin-top: 5px;" draggable="true" ondragstart="drag(event)"  id="<?php // echo 'ofic_'.$oficina['id']; ?>">
                                                                    <input type="hidden" id="input_id" value="<?php // echo $ofic_no['id']; ?>">
                                                                    <?php // echo $ofic_no['nombre']; ?>
                                                                </div>
                                                                <?php
//                                                            }else if(sizeof($nodos) > 0){
                                                                 ?>
                                                                <div style="cursor: pointer;background-color: tomato;color: white;text-align: center;vertical-align: middle;margin-top: 5px;" draggable="true" ondragstart="drag(event)"  id="<?php // echo 'ofic_'.$oficina['id']; ?>">
                                                                    <input type="hidden" id="input_id" value="<?php // echo $nodos[$index_ant]['oficina_id']; ?>">
                                                                    <?php // echo $nodos[$index_ant]['oficina_origen']; ?>
                                                                </div>
                                                                <?php 
//                                                            }
                                                            ?>
                                                        </div>
                                                    </div>-->
                                                </div>
                                                
                                            </div>
                                            
                                            
                                            <div id="div3" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                <h4 style="text-align: center;">Formulario</h4>
                                                <?php
                                                foreach ($formularios as $formulario){
                                                    ?>
                                                    <div style="cursor: pointer;background-color: #24AA7A;color: white;text-align: center;vertical-align: middle;margin-top: 5px;" draggable="true" ondragstart="drag(event)" id="<?php echo 'plant_'.$formulario['id']; ?>">
                                                        <input type="hidden" id="input_id" value="<?php echo $formulario['id']; ?>">
                                                        <?php echo $formulario['nombre']; ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                
                                            </div>
                                            
					</div>
					<div class="box-footer">
                                            <!-- your footer code -->
						<a class="btn btn-default" href="javascript:window.history.back();" title="Cancelar">Cancelar</a>
						<button class="btn btn-primary pull-right" title="crear Nodo" id="btn_new_nodo">Guardar Nodo</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  if(ev.target.id == "oficina_si"){
      $("#oficina_si").html('');
  }
//  if(ev.target.id == "oficina_no"){
//      $("#oficina_no").html('');
//  }
  if(ev.target.id == "plantilla"){
      $("#plantilla").html('');
  }
  
  var id_element = ev.dataTransfer.getData("text");
  
  var type_item = id_element.split('_')[0];
  var id_contenedor =ev.srcElement.attributes.id.nodeValue;
  
  if(type_item == "plant" && id_contenedor == "plantilla"){
    ev.target.appendChild(document.getElementById(id_element));
  }else if(type_item == "ofic" && (id_contenedor == "oficina_si" /*|| id_contenedor == "oficina_no"*/)){
        ev.target.appendChild(document.getElementById(id_element));
  }
}
var action = '<?php echo $edit ? 'editar_nodo_back' : 'crear_nodo_back' ; ?>';
var orden = <?php echo $edit ? $orden_edit : 0; ?>;
var ofic_origen = '<?php echo sizeof($nodos) > 0 ? $nodos[$index_ant]['oficina_destino_id'] : $this->session->userdata('oficina_actual_id');?>';
var tramite_id = <?php echo $tramite->id; ?>;
$(document).ready(function(){
    $("#btn_new_nodo").click(function(){
        $(this).attr('enabled','true');
        
        var ofic_destino = 0;
//        var ofic_rechazo = 0;
        var plantilla = 0;
        
        ofic_destino = $($("#oficina_si").children("div")).children('input').val();
//        ofic_rechazo = $($("#oficina_no").children("div")).children('input').val();
        plantilla = $($("#plantilla").children("div")).children('input').val();
        
        if(ofic_destino == null 
                /*&& ofic_rechazo == null*/){
           alert("Error usted debe completar oficina destino y oficina rechazo");
        }else{
            //guardamos el nodo y redireccionamos
            if(plantilla == null){
                plantilla = 0;
            }
            $.ajax({
                url: "<?php echo base_url("expedientes/circuitos/"); ?>"+action,
                method: "post",
                data: {plan_id: plantilla, ofic_id: ofic_origen,ofic_dest_id: ofic_destino/*, ofic_rech_id: ofic_rechazo*/, tram_id: tramite_id, orden_e: orden},
                dataType: "html"
            }).done(function(msg){
                if(msg == "OK"){
                    alert("Nodo Guardado");
                }
                if(msg == "ERROR"){
                    alret("No se puedo guardar el nodo");
                }
                
                window.location.href = "<?php echo base_url('expedientes/circuitos/listar/');?>"+tramite_id;
            }).fail(function(jqXHR, textStatus){
                console.log(textStatus+": "+jqXHR.getAllResponseHeaders());
            });
        }
    });
});
</script>

