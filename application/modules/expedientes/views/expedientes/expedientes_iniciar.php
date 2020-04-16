<script>
	var busca_expediente = 'anexar';
	var expedientes_table;
	var oficinas_solicitante_table;
	var solicitantes_table;
	var oficinas_destino_table;
	var inmuebles_table;
	function seleccionar_expediente(numero, ano, anexo, nuevo_anexo) {
		if (busca_expediente === 'anexar') {
			$('#numero').val(numero);
			$('#ano').val(ano);
			$('#anexo').val(nuevo_anexo);
		} else {
			$('#numero_madre').val(numero);
			$('#ano_madre').val(ano);
			$('#anexo_madre').val(anexo);
			$('#btn_buscar_expediente_madre').hide();
			$('#btn_limpiar_expediente_madre').show();
		}
	}
	function limpiar_expediente_madre() {
		$('#numero_madre').val('');
		$('#ano_madre').val('');
		$('#anexo_madre').val('');
		$('#btn_buscar_expediente_madre').show();
		$('#btn_limpiar_expediente_madre').hide();
	}
	$(document).ready(function() {
<?php if (isset($anexar_expediente)): ?>
			var anexar_expediente =<?php echo json_encode($anexar_expediente); ?>;
			$('#numero').val(anexar_expediente['numero']);
			$('#ano').val(anexar_expediente['ano']);
			$('#anexo').val(parseInt(anexar_expediente['anexo']) + 1);
<?php endif; ?>
		actualizar_tramites();
		$('#buscar_expediente_modal').on('shown.bs.modal', function() {
			expedientes_table.responsive.recalc();
		});
		$('#buscar_oficina_solicitante_modal').on('shown.bs.modal', function() {
			oficinas_solicitante_table.responsive.recalc();
		});
		$('#buscar_solicitante_modal').on('shown.bs.modal', function() {
			solicitantes_table.responsive.recalc();
		});
		$('#buscar_oficina_destino_modal').on('shown.bs.modal', function() {
			oficinas_destino_table.responsive.recalc();
		});
		$('#buscar_inmueble_modal').on('shown.bs.modal', function() {
			inmuebles_table.responsive.recalc();
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Expedientes
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="<?php echo $controlador . '/listar'; ?>"><?php echo ucfirst($controlador); ?></a></li>
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
						<h3 class="box-title">Iniciar Expediente</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php $data_submit = array('class' => 'btn btn-primary pull-right', 'title' => $txt_btn, 'id' => 'btn_submit'); ?>
					<?php echo form_open(uri_string()/*,array('data-toggle' => 'validator')*/); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['tipo_tramite']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['tipo_tramite']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['numero']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['numero']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['ano']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['ano']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['anexo']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['anexo']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_expediente" class="btn btn-warning" data-toggle="modal" data-target="#buscar_expediente_modal" onclick="busca_expediente = 'anexar';">Anexar a otro expte.</button>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['tramite']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['tramite']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 col-xs-4" id="div_persona_id">
								<div class="row">
									<div class="col-sm-6">
										<?php echo '<label for="persona_id">Oficina</label>' ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['persona_id']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6 col-sm-6 col-xs-8" id="div_caratula">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['caratula']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['caratula']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button style="display:none;" type="button" id="btn_buscar_oficina_solicitante" class="btn btn-warning" data-toggle="modal" data-target="#buscar_oficina_solicitante_modal">Seleccionar solicitante</button>
								<button style="display:none;" type="button" id="btn_buscar_solicitante" class="btn btn-warning" data-toggle="modal" data-target="#buscar_solicitante_modal">Seleccionar solicitante</button>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['objeto']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['objeto']['form']; ?>
									</div>
								</div>
							</div>
						</div>
                                            <div class="row" id="div-fojas">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['fojas']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['fojas']['form']; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="div-destino">
							<div class="form-group col-md-3 col-sm-3 col-xs-4">
								<div class="row">
									<div class="col-sm-6">
										<?php echo $fields['oficina_id']['label']; ?>
									</div>
									<div class="col-sm-6">
										<?php echo $fields['oficina_id']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6 col-sm-6 col-xs-8">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['oficina']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['oficina']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_oficina_destino" class="btn btn-warning" data-toggle="modal" data-target="#buscar_oficina_destino_modal">Cambiar oficina destino</button>
							</div>
						</div>
						<div class="row" id="div-inmueble" style="display:none;">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<?php echo $fields['inmueble_id']['form']; ?>
										<?php echo $fields['inmueble']['label']; ?>
									</div>
									<div class="col-sm-10">
										<?php echo $fields['inmueble']['form']; ?>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_inmueble" class="btn btn-warning" data-toggle="modal" data-target="#buscar_inmueble_modal">Seleccionar inmueble</button>
							</div>
						</div>
                                            <div id="div_madre">
                                                    <div class="row">
                                                            <div class="col-sm-12">
                                                                    <h4><b>Expediente Madre</b></h4>
                                                            </div>
                                                    </div>
                                                    <div class="row">
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-4">
                                                                    <div class="row">
                                                                            <div class="col-sm-6">
                                                                                    <?php echo $fields['numero_madre']['label']; ?>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                    <?php echo $fields['numero_madre']['form']; ?>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-4">
                                                                    <div class="row">
                                                                            <div class="col-sm-6">
                                                                                    <?php echo $fields['ano_madre']['label']; ?>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                    <?php echo $fields['ano_madre']['form']; ?>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-4">
                                                                    <div class="row">
                                                                            <div class="col-sm-6">
                                                                                    <?php echo $fields['anexo_madre']['label']; ?>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                    <?php echo $fields['anexo_madre']['form']; ?>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                    <button type="button" id="btn_buscar_expediente_madre" class="btn btn-warning" data-toggle="modal" data-target="#buscar_expediente_modal" onclick="busca_expediente = 'acumular';">Acumular</button>
                                                                    <button type="button" id="btn_limpiar_expediente_madre" class="btn btn-warning" data-toggle="modal" style="display:none;" onclick="limpiar_expediente_madre();">Limpiar</button>
                                                            </div>
                                                    </div>
                                                </div>
					</div>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/expedientes/listar" title="Cancelar">Cancelar</a>
						<?php echo (!empty($txt_btn)) ? form_submit($data_submit, $txt_btn) : ''; ?>
						<?php echo ($txt_btn === 'Editar' || $txt_btn === 'Eliminar') ? form_hidden('id', $expediente->id) : ''; ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_expediente_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar expediente</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_expedientes; ?>
				<?php echo $html_table_expedientes; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="buscar_oficina_solicitante_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Seleccione oficina solicitante</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_oficinas_solicitante; ?>
				<?php echo $html_table_oficinas_solicitante; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="buscar_oficina_destino_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Seleccione oficina destino</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_oficinas_destino; ?>
				<?php echo $html_table_oficinas_destino; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="buscar_solicitante_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Seleccione una persona</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_solicitantes; ?>
				<?php echo $html_table_solicitantes; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--
<div class="modal fade" id="buscar_inmueble_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar inmueble</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_inmuebles; ?>
				<?php echo $html_table_inmuebles; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
-->
<script >
var is_digital = false;
$(document).ready(function(){
    $("#btn_submit").hide();
    $( "select[id=tramite]" )
    .change(function () {
      $( "select[id=tramite] option:selected" ).each(function() {   
          var tipot = $( this ).text();
          console.log($( this ).text());
          var request = $.ajax({
            url: '<?php echo base_url('expedientes/is_digital'); ?>',
            method: "POST",
            data: { detalle : tipot},
            dataType: "html"
          });

          request.done(function( msg ) {
            if(msg == "true"){
                is_digital = true;
                $("#div_madre").hide();
                $("#div-inmueble").hide();
                $("#div-fojas").hide();
                $("#div-destino").hide();
            }else{
                is_digital = false;
                $("#div_madre").show();
                $("#div-fojas").show();
                $("#div-destino").show();
                $("#div-inmueble").hide();
            }
          });

          request.fail(function( jqXHR, textStatus ) {
            console.error(textStatus);
          });
      });
    });
    
    $("#tipo_tramite").focusout(function(){
        habilitar_submit();
    });
    $("#ano").focusout(function(){
        habilitar_submit();
    });
    $("#fojas").focusout(function(){
        habilitar_submit();
    });
    $("#anexo").focusout(function(){
        habilitar_submit();
    });
    $("#caratula").focusout(function(){
        habilitar_submit();
    });
    $("#objeto").focusout(function(){
        habilitar_submit();
    });
    
});

function habilitar_submit(){

        var err = false;
    if(is_digital){
        //validacion digital
        err = $("#tipo_tramite").val() == '0' || $("#ano").val() < 0 || !($("#anexo").val() >= 0) || $("#caratula").val() == '' 
                || $("#objeto").val() == '';
    }else{
        //validacion expediente comun
        err = $("#tipo_tramite").val() == '0' || $("#ano").val() < 0 || !($("#anexo").val() >= 0) || $("#caratula").val() == '' 
                || $("#objeto").val() == '' || $("#fojas").val() == '' || $("#fojas").val() == 0;
    }
    if(err){
        $("#btn_submit").attr('disabled', true).hide();
    }else{
        $("#btn_submit").removeAttr('disabled').show();
    }
}

$(document).on("keypress", "input", function (e) { var code = e.keyCode || e.which; if (code == 13) { e.preventDefault(); return false; } }); 

</script>