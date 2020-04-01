<script type="text/javascript" dir="/vu/plugins/pdfjs/pdf.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        if($("#message p").text() == ""){
            $("#message").hide();
        }
        $('#contenido').ckeditor({
            toolbar: 'Full',
            height: 500,
            toolbarCanCollapse: true,
            width: 800
        });
        
        $("#btn-editar").click(function (evt){
            evt.preventDefault();
        });
        
        $("#btn-ver").click(function (evt){
            evt.preventDefault();
        });
        
        $("#btn-agregar").click(function (evt){
            evt.preventDefault();
        });
        $("#btn_nuevarevi").click(function(){
            var rev_id = $("#idrev").val();
            var rev_text = $("#contenido").val();
            var rev_obse = $("#observacion").val();
            var pase_id = $("#idpase").val();
            var parametros = {
                    revid: rev_id,
                    revtext: rev_text,
                    revobse: rev_obse,
                    paseid: pase_id
                };
            $.ajax({
                url: "/vu/expedientes/pases/nueva_revision",
                method: "POST",
                data: JSON.stringify(parametros),
                dataTye: "html"
            }).done(function(data){
                console.log(data);
                if(data.status == "success"){
                    window.location.href = "/vu/expedientes/pases/listar_pendientes_ee";
                }else{
                    alert(data.message);
                }
            });
        });
        
        $("#btn_finalizar").click(function(msj){
            if(!confirm('¿Esta seguro de finalizar la revision?'))return;
            var rev_id = $("#idrev").val();
            var rev_text = $("#contenido").val();
            var parametros = {
                    revid: rev_id,
                    revtext: rev_text,
					adjuntos: adjuntos
                };
            $.ajax({
                url: "/vu/expedientes/pases/finalizar_revision",
                method: "POST",
                data: JSON.stringify(parametros),
                dataTye: "html"
            }).done(function(data){
                console.log(data);
                if(data.status == "success"){
                    window.location.href = "/vu/expedientes/pases/listar_pendientes_ee";
                }else{
                    alert(data.message);
                }
            });
        });
    });
    
    function asignar_revisor(usuario,idrev){
        var revobse = $("#observacion").val();
        var revtext = $("#contenido").val();
        var params = {
                usuario: usuario,
                idrev: idrev,
                revobse: revobse,
                revtext: revtext
            };
        $.ajax({
            url:"/vu/expedientes/pases/asignar_revisor",
            method: "POST",
            data: JSON.stringify(params),
            dataType: "html"
        }).done(function(data){
            console.log(data);
            $("#message").show();
            var result = JSON.parse(data);
            if(result.status == "success"){
                window.location.href = "/vu/expedientes/pases/listar_pendientes_ee";
            }else{
                $("#revisor_status").text(result.message);
            } 
        });
    }

    var adjuntos = [];

    function readAllPDF(){
        var container = document.getElementById('container');
        for(var i=0; i<adjuntos.length; i++){
            if(document.getElementById(adjuntos[i].name) === null){
                var iframe_container = document.createElement('div'); 
                var iframe = document.createElement('iframe');
                var iframe_title = document.createElement('div');
                var iframe_delete = document.createElement('div');
                iframe.width = '160px';
                iframe.height = '160px';
                iframe.setAttribute('class', 'iframe');
                iframe.src = adjuntos[i].data;

                iframe_container.setAttribute('class', 'iframe-container');
                iframe_container.setAttribute('id', adjuntos[i].name);
                iframe_delete.setAttribute('class', 'iframe-delete');
                iframe_delete.innerHTML = '<button class="btn btn-danger" type="button" onclick="eliminarArchivosAdjuntos('+i+', \''+adjuntos[i].name+'\')"><i aria-hidden="true" class="fa fa-trash"></i> Eliminar</button>';
                iframe_title.setAttribute('class', 'iframe-title');
                iframe_title.innerHTML = adjuntos[i].name;
                
                iframe_container.appendChild(iframe);
                iframe_container.appendChild(iframe_title);
                iframe_container.appendChild(iframe_delete);

                container.appendChild(iframe_container);
            }
        }
    }

    function almacenarArchivosAdjuntos(){
        var files = document.getElementById('archivos').files;
        var i = 0;
        for(var file of files){
            if(adjuntos.length > 0){
                var existe = false;
                for(var search of adjuntos){
                    if(search.name === file.name){
                        alert('Este archivo ya fue adjuntado');
                        existe = true;
                    }
                }
                if(!existe){
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    var file_data = new Object();
                    file_data.name = file.name;
					file_data.size = file.size;
                    reader.onload = function (e) {
                        file_data.data = e.target.result;
                    };
                    adjuntos.push(file_data);
                    reader.onloadend = function (e) {
                        readAllPDF();
                    }
                }
            } else {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                var file_data = new Object();
                file_data.name = file.name;
                file_data.size = file.size;
                reader.onload = function (e) {
                    file_data.data = e.target.result;
                };
                adjuntos.push(file_data);
                reader.onloadend = function (e) {
                    readAllPDF();
                }
            }
            i++;
        }
    }

    function eliminarArchivosAdjuntos(index, name){
        var container = document.getElementById('container');
        container.removeChild(document.getElementById(name));
        for(var data of adjuntos){
            if(data.name === name){
                adjuntos.splice(adjuntos.indexOf(data), 1);
            }
        }
    }
</script>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>
            <?php echo (empty($titulo_pagina) ? 'Titulo' : $titulo_pagina); ?>
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
                    <div class="box-body">
                        <!-- mi codigo -->
                        <div style="text-align: center;">
                            <a class="btn btn-app btn-app-zetta" href="expedientes/pases/listar_pendientes_ee">
                                    <i class="fa fa-undo" id="btn-vover"></i> Volver
                            </a>
                            <a class="btn btn-app btn-app-zetta <?= $class['ver'] ?>" href="<?= 'expedientes/pases/revision/view/'.$idpase.'/'.$idrev?>">
                                    <i class="fa fa-search" id="btn-ver"></i> Ver
                            </a>
                            <a class="btn btn-app btn-app-zetta <?= $class['editar'] ?>" <?= (empty($usuarev) || strtoupper($usuarev) == strtoupper($this->session->userdata('CodiUsua')) ? 'href="expedientes/pases/revision/edit/'.$idpase.'/'.$idrev.'" ' : ' onclick="event.preventDefault();" disabled')?>>
                                    <i class="fa fa-edit" id="btn-editar"></i> Editar
                            </a>
                        </div>

                        <hr>
                        
                        <center>
                            <?php if(!empty($usuarev) || !empty($observacion)): ?>
                            <div class="alert alert-info" id="message" style="width: 500px;">
                                <p id="revisor_status"><?=(empty($usuarev) ? "":"El formulario tiene asignado a <strong style='color:yellow;'>".  strtoupper($usuarev)."</strong> como revisor")?></p>
                                <?php if(!empty($observacion)): ?>
                                <p >NOTA: <?= $observacion ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <input type="hidden" id="idrev" value="<?= $idrev ?>">
                            <input type="hidden" id="idpase" value="<?= $idpase ?>">
                            <textarea name="texto" id="contenido" class="form-control" <?= ($class['ver'] != '' ? 'disabled' : '')?>>
                                    <?php echo htmlentities($contenidopdf); ?>
                            </textarea>
                            <br>
                            <?php if($class['ver'] == ""): ?>
                                <label>Observaciones: </label><br>
                                <textarea id="observacion" rows="6" cols="125"></textarea>
                            <?php endif; ?>
                            <br><br><br>
                            <form id="form">
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-6">
                                        <div tabindex="500" class="btn btn-primary btn-file"><i class="glyphicon glyphicon-plus"></i> <span class="hidden-xs">Adjuntar archivos al formulario</span><input id="archivos" name="archivos[]" type="file" accept="text/*" class="input-file" onchange="almacenarArchivosAdjuntos();" <?= ($class['ver'] != "" ? 'disabled="true"' : '')?>></div>                   
                                    </div>
                                    <div class="col-xs-3"></div>
                                </div>
                            </form>
							<br>
                        </center>
                            <div id="container" <?= ($class['ver'] != "" ? 'style="display: none;"' : '')?>>
                            </div>
                        <center>
                            
                            <br><br>
                            <a class="btn btn-danger" <?= ($class['ver'] != "" ? 'disabled' : 'id="btn-agregar"')?> href="#" <?= ($class['editar'] == "" ? "onclick=\"event.preventDefault();\" disabled" :" data-toggle=\"modal\" data-target=\"#buscar_revisor_modal\" ") ?>>
                                    Solicitar Revisión a Usuario
                            </a>
                            <button class="btn btn-warning" <?= ($class['ver'] != "" ? 'disabled' : 'id="btn_nuevarevi"')?>>Solicitar Nueva revisión</button>
                            <button class="btn btn-success" <?= ($class['ver'] != "" ? 'disabled' : 'id="btn_finalizar"')?>>Finalizar Revision</button>
                            
                        </center>
                        <br>
                    
                    </div>
                    
                    <!-- fin de mi codigo -->
                </div> 
            </div>
        </div>
    </section>
    
</div>

<div class="modal fade" id="buscar_revisor_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Seleccione una persona</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_revisor; ?>
				<?php echo $html_table_revisor; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<style>
    .file{
        height: 60px;
        border-bottom: 1px solid #f4f4f4;
    }
    .info{
        height: 100%;
        display: table;
    }
    .info p{
        display: table-cell;
        vertical-align: middle;
    }
    .infob{
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .iframe-container{
        display: inline-block;
        padding: 6px;
        margin: 8px;
        margin-bottom: 60px;
        border: 1px solid #ddd;
        box-shadow: 1px 1px 5px 0 #a2958a;
    }
    .iframe-container:hover{
        box-shadow: 3px 3px 5px 0 #333;
    }
    .iframe{
        border: none;
    }
    .iframe html{
        zoom: 0.75; 
        -moz-transform: scale(0.75); 
        -moz-transform-origin: 0 0; 
    }
    .iframe-title{
        font-size: 11px;
        color: #777;
        margin: 5px auto 10px;
        width: 160px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
    }
    .iframe-title:hover{
        color: #000;
    }
    #container{
        min-height: 280px;
		width: 70.5%;
		border: 1px solid #ddd;
		border-radius: 3px;
		margin-left: auto;
		margin-right: auto;
    }
    .iframe-delete{
        position: relative;
        width: auto;
		height: 0px;
		text-align: center;
    }
    .iframe-delete button{
		margin-top: 30px;
    }
</style>
