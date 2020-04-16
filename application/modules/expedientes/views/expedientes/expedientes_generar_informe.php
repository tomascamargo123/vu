<script>
	var plantillas_table;
	function seleccionar_plantilla(id) {
		window.location.replace('expedientes/expedientes/generar_informe/<?php echo $expediente->id; ?>/<?php echo $ultimo_pase[0]->id; ?>/' + id);
	}
	$(document).ready(function() {
<?php if (!empty($plantilla)): ?>
			$('#texto').ckeditor({toolbar: 'Basic'});
<?php endif; ?>
		$('#buscar_plantilla_modal').on('shown.bs.modal', function() {
			plantillas_table.responsive.recalc();
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Generar Informe
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-home"></i> Inicio</a></li>
			<li><a href="expedientes/escritorio">Expedientes</a></li>
			<li><a href="expedientes/<?php echo $controlador; ?>/listar"><?php echo ucfirst($controlador); ?></a></li>
			<li class="active">Generar Informe</li>
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
						<h3 style="vertical-align:middle;" class="box-title">
							Generar Informe <?php echo "Expediente $expediente->numero / $expediente->ano - $expediente->anexo"; ?>
						</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<?php echo form_open(uri_string(), array('data-toggle' => 'validator',  'id' => 'form_plantilla', 'name' => 'form_plantilla')); ?>
					<div class="box-body label-expedientes">
						<div class="row">
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<label for="expediente">Expediente</label>
									</div>
									<div class="col-sm-10">
										<input type="text" name="expediente" value="<?php echo "$expediente->numero / $expediente->ano - $expediente->anexo"; ?>" id="expediente" class="form-control" disabled>
										<input type="hidden" name="id" value="<?php echo $expediente->id; ?>">
									</div>
								</div>
							</div>
							<div class="form-group col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-sm-2">
										<label for="plantilla">Plantilla</label>
									</div>
									<div class="col-sm-10">
										<input type="text" name="plantilla" value="<?php echo empty($plantilla) ? '' : $plantilla->nombre; ?>" id="plantilla" class="form-control" disabled>
									</div>
								</div>
							</div>
							<div class="form-group col-md-3 col-sm-3 col-xs-12">
								<button type="button" id="btn_buscar_plantilla" class="btn btn-warning" data-toggle="modal" data-target="#buscar_plantilla_modal">Seleccionar plantilla</button>
							</div>
							<?php if (!empty($plantilla)): ?>
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<div class="col-sm-12">
											<textarea name="texto" id="texto" class="form-control">
												<?php echo htmlentities($plantilla->texto); ?>
											</textarea>
										</div>
									</div>
								</div>
							<?php endif; ?>							
						</div>
						<!--<button type="button" class="btn btn-primary" onclick="javascript:agregarFirmas()">Agregar firmas</button>-->
					</div>
					<?php if($firma_pad > 0) { ?>
                            <div id="form_pad_sign" style="padding: 10px;">
                                <div class="alert alert-success" role="alert" id="alert-message-pad"></div>
                                
                                <table border="1" cellpadding="0"  width="500">
                                  <tr>
                                    <td height="250" width="500">
                                        <!-- canvas de firma del pad -->
                                        <canvas id="cnv" name="cnv" width="500" height="250"></canvas>
                                    </td>
                                  </tr>
                                </table>
                                <br>
                                <p>
                                    <textarea type="hidden" name="firmapad" id="firmapad" cols="5" class="form-control" style="display: none;"></textarea>
                                    <br>
                                    <!-- botones de escucha y borrado de firma -->
                                    <input id="SignBtn" class="btn btn-info btn-sm" name="SignBtn" type="button" value="Firmar"  onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="button1" class="btn btn-warning btn-sm" name="ClearBtn" type="button" value="Borrar firma" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp

                                     <input id="button2" class="btn btn-danger btn-sm" name="DoneBtn" type="button" value="Cargar firma" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp
                                </p>
                                <div id="show_firmas" class="alert alert-success">
                                    <p>Firmas:</p>
                                </div>
                            </div>
                            <?php } ?>
					<div class="box-footer">
						<a class="btn btn-default" href="expedientes/expedientes/ver/<?php echo $expediente->id; ?>" title="Cancelar">Cancelar</a>
						<?php echo form_submit(array('class' => 'btn btn-primary pull-right', 'title' => 'Guardar'), 'Guardar'); ?>
						<a class="btn btn-default" href="javascript:window.history.back();" title="Volver">Volver</a>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="buscar_plantilla_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Buscar plantilla</h4>
			</div>
			<div class="modal-body">
				<?php echo $js_table_plantillas; ?>
				<?php echo $html_table_plantillas; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
//var idplant = <?= $idplan; ?>;
//var id_exp = <?= $idexp;?>;
</script>

<!-- firma pad -->
<?php if($firma_pad > 0){ ?>
<!-- funciones jquery pad de firmas -->
<script type="text/javascript">
var cant_firmas = <?= $firma_pad ?>;
var contador_f = 0;
$(document).ready(function(){
    $("#alert-message-pad").hide();
        $("#show_firmas").hide();
    $("#SignBtn").click(function(){
        $("#alert-message-pad").html("<p>El pad de firmas se encuentra listo para firma. Total de firmas disponibles "+cant_firmas+"</p>");
        $("#alert-message-pad").show('slow');
        $("#show_firmas").show('slow');
    });
});
</script>
<!-- pad de firmas -->


<script type="text/javascript">
var tmr;

function onSign()
{
   var ctx = document.getElementById('cnv').getContext('2d');         
   SetDisplayXSize( 500 );
   SetDisplayYSize( 250 );
   SetTabletState(0, tmr);
   SetJustifyMode(0);
   ClearTablet();
   if(tmr == null)
   {
      tmr = SetTabletState(1, ctx, 50);
   }
   else
   {
      SetTabletState(0, tmr);
      tmr = null;
      tmr = SetTabletState(1, ctx, 50);
   }
}
function onClear()
{
   ClearTablet();
}
function onDone()
{
   if(NumberOfTabletPoints() == 0)
   {
      alert("Please sign before continuing");
   }
   else
   {
       contador_f++;
       if(cant_firmas == contador_f){
            SetTabletState(0, tmr);//bloquea el firmador
       }
      //RETURN BMP BYTE ARRAY CONVERTED TO BASE64 STRING
      SetImageXSize(500);
      SetImageYSize(250);
      SetImagePenWidth(1);
      GetSigImageB64(SigImageCallback);
   }
}
function SigImageCallback( str )
{  
   let html_str = $("#show_firmas").html();
   $("#show_firmas").html(html_str+'<img src="data:image/png;base64,'+str+'" height="75" width="150"><span>&nbsp&nbsp</span>');
   document.form_plantilla.firmapad.value += str+"<separator>";
}
</script> 


<script type="text/javascript">
window.onunload = window.onbeforeunload = (function(){
closingSigWeb();
})

function closingSigWeb()
{
   ClearTablet();
   SetTabletState(0, tmr);
}

var cantidad_de_firmas = 0;
function agregarFirmas(){
	var container = document.getElementById('cke_texto');
	var procesadorDeTexto = container.getElementsByTagName('iframe')[0];
	var doc = procesadorDeTexto.contentWindow.document;
	var hoja = doc.getElementsByTagName('body')[0];
	var p = document.createElement('p');
	p.innerHTML = '#{firma_pad_'+cantidad_de_firmas+'}';
	hoja.appendChild(p)
	cantidad_de_firmas++;
}

</script>
<?php } ?>