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
                        <h3 class="box-title"><?php echo $box_title; ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-9">
                            <h3 class="text-center">Carrito de pases</h3>
                            <table class="table table-hover table-bordered table-condensed" style="margin-top: 58px;">
                                <thead style="background-color: #6666ff;color: white;">
                                    <tr style="text-align: center;padding-top: 10px;">
                                        <th>Cód. Barra</th>
                                        <th>Año</th>
                                        <th>Número</th>
                                        <th>Anexo</th>
                                        <th>Fojas</th>
                                        <th>Origen</th>
                                        <th>Recepcion</th>
                                        <th>Tramite</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="carrito_body" style="background-color: #ccccff;">
                                    <?php 
                                    foreach ($table_data as $row){
                                        echo '<tr>';
                                        echo '<td>'.$row['codigo'].'</td>';
                                        echo '<td>'.$row['ano'].'</td>';
                                        echo '<td>'.$row['numero'].'</td>';
                                        echo '<td>'.$row['anexo'].'</td>';
                                        echo '<td>'.$row['fojas'].'</td>';
                                        echo '<td>'.$row['oficina_origen'].'</td>';
                                        echo '<td>'.$row['usuario_emisor'].'</td>';
                                        echo '<td>'.$row['tramite_nombre'].'</td>';
                                        echo '<td></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-center">Carrito de pases</h3>
                            <table class="table table-hover table-bordered table-condensed" style="margin-top: 58px;">
                                <thead style="background-color: #6666ff;color: white;">
                                    <tr style="text-align: center;padding-top: 10px;">
                                        <th>Código</th>
                                        <th>Expediente</th>
                                        <th>Año</th>
                                        <th>Anexo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="carrito_body" style="background-color: #ccccff;">
                                    <?php
                                    $carrito = $this->session->userdata('carrito');
                                    if (!empty($carrito))
                                        foreach ($carrito as $item) {
                                            echo '<tr>';
                                            echo '<td style="padding-left: 10px;" class="id_exp">' . $item["id_expediente"] . '</td>';
                                            echo '<td style="padding-left: 10px;" >' . $item["numero"] . '</td>';
                                            echo '<td style="padding-left: 10px;" >' . $item["ano"] . '</td>';
                                            echo '<td style="padding-left: 10px;" >' . $item["anexo"] . '</td>';
                                            echo '<td style="text-align: right;" ><a href="#"><i class="fa fa-trash btn_del_item_carr" aria-hidden="true"></i></a></td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <a id="recepcionar_all" class="btn btn-info" href="<?php echo base_url('expedientes/pases/recepcionar_carrito'); ?>">Recepcionar todo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($metodo == "listar_pendientes_r") { ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-body">

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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
<?php
if ($metodo == "listar_pendientes_r") {
    ?>
    <script>
        var ofi = '<?php echo $this->session->userdata('oficina_actual'); ?>';
        $(document).ready(function () {
            if ($("#carrito_body").children('tr').length > 0) {
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
                    var request = $.ajax({
                        url: "<?php echo base_url('expedientes/pases/is_pendiente_r'); ?>",
                        method: "POST",
                        data: {id_expediente: $(this).val(), oficina: ofi},
                        dataType: "html"
                    });

                    request.done(function (data) {
                        if (data != "error") {
                            var pase_row = JSON.parse(data);
                            var resp = confirm("Agregar a carrito de pases?");
                            if (resp) {
                                //agregamos al carrito en la variable de session
                                add_to_carrito_pases(pase_row,data);

                            }
                        } }else {
                            if (data === "error") {
                                console.error("Ocurrio un erro al consultar el estado dele expediente");
                            } else {
                                alert(data);
                            }
                        }
                    });

                }
            });

            $(".send_cart_pases").click(function (evt) {
                evt.preventDefault();
                console.log("eventeo");
    //            var fila = $(this).parents("tr");//$(this).closest("tr").remove();
    //            var cod_expe = fila.children("td[tabindex=0]").text();
    //            console.log("CODIGO DE EXPEDIENTE:: "+cod_expe);
            });

            //al borrar un elemento del carrito
            $(".btn_del_item_carr").click(function (evt) {
                evt.preventDefault();
                var fila = $(this).parents("tr");//$(this).closest("tr").remove();
                var idx_row = $(this).parents("tr").index();
                console.info("INDEX: " + idx_row);
                var request = $.ajax({
                    url: "<?php echo base_url('expedientes/pases/delete_carrito'); ?>",
                    method: "POST",
                    data: {idx_row: idx_row},
                    dataType: "html"
                });
                request.done(function (msg) {
                    if (msg == "success") {
                        fila.remove();
                    } else {
                        console.error("Ocurrio un error al eliminar la fila del carrito.\n\n" + msg);
                    }
                });
            });


        });

        function add_to_carrito_pases(pase_row, data) {
            $.ajax({
                url: "<?php echo base_url('expedientes/pases/add_carrito'); ?>",
                method: "POST",
                data: {pase: data},
                dataType: "html"
            }).done(function (msg) {
                console.log("solictud enviada correctamente");
            });
            //agregamos al carrito en la vista
            var rows_html = $("#carrito_body").html();
            rows_html += "<tr>"
                    + "<td>" + pase_row['id_expediente'] + "</td>"
                    + "<td>" + pase_row['numero'] + "</td>"
                    + "<td>" + pase_row['ano'] + "</td>"
                    + "<td>" + pase_row['anexo'] + "</td>"
                    + '<td><button class="btn btn-warning btn_del_item_carr">Eliminar</button></td>'
                    + "</tr>";
            $("#carrito_body").html(rows_html);
            $("#recepcionar_all").show();

        }
    </script>
    <?php
}
?>