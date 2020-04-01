<script>
    function confirmar_accion(id, accion) {
        $('#accion_confirmacion').html(accion);
        var a = document.getElementById('link_confirmacion');
        a.href = "expedientes/pases/" + accion + "/" + id;
        $('#confirmacion_pase_modal').modal();
    }
    $(document).ready(function () {
        $(document).keypress(function (e) {
            var charCode = e.which || e.keyCode;
            if (charCode === 124 || charCode === 231 || charCode === 199 || charCode === 93) { // | ç Ç - ]240973

                e.preventDefault();
                $('input[placeholder="Cód.Barra"]').select();
            }
        });
    });
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pases
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="expedientes/escritorio">Expedientes</a></li>
            <li><a href="expedientes/<?php echo $controlador . '/' . $metodo; ?>"><?php echo ucfirst($controlador); ?></a></li>
            <li class="active"><?php echo $metodo_visual; ?></li>
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
        <?php if (!empty($message) || !empty($alert_message)) : ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> OK!</h4>
                <?php echo !empty($message) ? $message : '' ;?>
                <?php
                echo !empty($alert_message) ? $alert_message : '';
                if(!empty('$message') && !empty($ticket_id)){
                    echo '<br><a href="expedientes/pases/pdf_ticket_r/'.$ticket_id.'" target="_blank" class="btn btn-warning" style="text-decoration:none;color-background: orange;"><i class="fa fa-print"></i> Imprimir Ticket</a>';
                }
                ?>
            </div>
        <?php endif; ?>
        <?php if ($metodo == "listar_pendientes_r") { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Carrito de Pases</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        
                        <div class="col-md-12" id="col-carrito">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                  Lista de pases del carrito
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group" id="list-carrito">
                                        <?php
                                        $carrito = $this->session->userdata('carrito');
                                        if (!empty($carrito))
                                            foreach ($carrito as $item) {
                                            ?>
                                            <li class="list-group-item">
                                                <button class="btn btn-primary badge btn_del_item_carr">Eliminar</button>
                                                <span class="id_exp"><?=$item["id_expediente"]?></span>
                                                <?= $item["numero"] . '/' . $item["ano"] . ' - ' . $item["anexo"] ?>
                                            </li>
                                             <?php
                                            }
                                        ?>
                                    </ul>
                                    <a id="limpiar_all" class="btn btn-danger" style="float: left;" href="<?php echo base_url('expedientes/pases/limpiar_carrito'); ?>">Limpiar carrito</a>
                                    <a id="recepcionar_all" class="btn btn-info" style="float: right;" href="<?php echo base_url('expedientes/pases/recepcionar_carrito'); ?>">Recepcionar todo</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php 
        }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $box_title; ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12" id="col-pases">
                            <?php echo $js_table; ?>
                            <?php echo $html_table; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
</div>
<div class="modal fade" id="nota_pase_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Nota de Pase</h4>
            </div>
            <div class="modal-body">
                <b>Nota:</b> <span id="contenido_nota"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmacion_pase_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Advertencia</h4>
            </div>
            <div class="modal-body">
                <p>Está por <span id="accion_confirmacion"></span> el pase. ¿Desea continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <a id="link_confirmacion" href="" title="Aceptar" class="btn btn-primary pull-right">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmacion_rechazo_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Confirmar rechazo</h4>
            </div>
            <div class="modal-body">
                <p>¿Desea rechazar el pase?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <a id="link_confirmacion_rechazo" title="Aceptar" class="btn btn-primary pull-right" onclick="rechazar()">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<?php
if ($metodo == "listar_pendientes_r") {
    ?>
    <script>
        var idPase;
        function setIdPase(idPase){
            this.idPase = idPase;
            rechazar();
        }
        function rechazar(){
            document.getElementById("link_confirmacion_rechazo").href = 'expedientes/pases/rechazar/'+idPase;
        }
        var ofi = '<?php echo $this->session->userdata('oficina_actual'); ?>';
        $(document).ready(function () {
            if ($("#list-carrito").children('li').length > 0) {
                $("#recepcionar_all").show();
            } else {
                $("#recepcionar_all").hide();
            }

            $("input[placeholder='Cód.Barra']").keypress(function (e) {
                var charCode = e.which || e.keyCode;
                if (charCode === 124 || charCode === 231 || charCode === 199 || charCode === 93) { // | ç Ç - ]240973

                    e.preventDefault();
                    $('input[placeholder="Cód.Barra"]').select();
                }

                if (e.which == 13) {
                    //colocar un ajax que consulta la existencia del expediente asi lanzar la confirmacion
                    var id_exp = $(this).val();
                    add_to_carrito_pases(id_exp);
                }
            });
            
            //al borrar un elemento del carrito
            $(".btn_del_item_carr").click(function (evt) {
                evt.preventDefault();
                quitar_de_carrito(this);
            });

            if($.trim($("#list-carrito").html()) == ""){
                $("#col-carrito").hide();
            }
        });

        function add_to_carrito_pases(idexp, buttonNow = null) {
            var request = $.ajax({
                url: "<?php echo base_url('expedientes/pases/is_pendiente_r'); ?>",
                method: "POST",
                data: {id_expediente: idexp, oficina: ofi},
                dataType: "html"
            });

            request.done(function (data) {
                if (data != "error") {
                    var pase_row = JSON.parse(data);
                    var resp = confirm("Caratula: "+pase_row['caratula']+"\nObjeto: "+pase_row['objeto']+"\nExpediente: "+pase_row['numero'] + "/" + pase_row['ano'] + " - " + pase_row['anexo']+"\nFojas: "+pase_row['fojas']+"\nOrigen: "+pase_row['oficina']+"\n\n¿Agregar a carrito de pases?");
                    if (resp) {
                        //agregamos al carrito en la variable de session
                        $.ajax({
                            url: "<?php echo base_url('expedientes/pases/add_carrito'); ?>",
                            method: "POST",
                            data: {pase: data},
                            dataType: "html"
                        }).done(function (msg) {
                            //console.log("solictud enviada correctamente");
                            //agregamos al carrito en la vista
                            var rows_html = $("#list-carrito").html();
                            rows_html += '<li class="list-group-item">'
                                            + '<button class="btn btn-primary badge btn_del_item_carr">Eliminar</button>'
                                            + '<span class="id_exp">' + pase_row['id_expediente'] + '</span> '
                                            + pase_row['numero'] + "/" + pase_row['ano'] + " - " + pase_row['anexo']
                                        + '</li>';
                            $("#list-carrito").html(rows_html);
                            $("#col-carrito").show();
                            $("#recepcionar_all").show();

                            $(".btn_del_item_carr").bind('click',function (evt) {
                                evt.preventDefault();
                                quitar_de_carrito(this);
                            });
                            document.getElementById("button_rec_"+pase_row['id']).parentNode.parentNode.style.display = 'none';
                        });

                    }
                }else {
                    if (data == "error") {
                        console.error("Ocurrio un error al consultar el estado dele expediente");
                    } else {
                        console.log(data);
                    }
                }
            });
        }
        
        function f_enviar_a_carrito(idexp,buttonNow){
            //Codigo Victor
            add_to_carrito_pases(idexp,buttonNow);
        }
        
        function quitar_de_carrito(content){
            var fila = $(content).parents("li");//$(this).closest("tr").remove();
                var idx_row = $(content).parents("li").index();
                console.info("INDEX_ROW_DEL: " + idx_row);
                var request = $.ajax({
                    url: "<?php echo base_url('expedientes/pases/delete_carrito'); ?>",
                    method: "POST",
                    data: {idx_row: idx_row},
                    dataType: "html"
                });
                request.done(function (msg) {
                    if (msg == "success") {
                        /*fila.remove();
                        if($.trim($("#list-carrito").html()) == ""){
                            $("#col-carrito").hide();
                            console.log($("#list-carrito").html());
                        }*/
                        location.reload();
                    } else {
                        console.error("Ocurrio un error al eliminar la fila del carrito.\n\n" + msg);
                    }
                });
        }
        
        function recibir(id){
            $("#button_rec_"+id).attr({'disabled':'disabled'}).removeAttr('onclick');
            window.location.href= 'expedientes/pases/recibir/'+id;
        }
    </script>
    <?php
}
?>