function actualizar_oficina() {
	var oficina_id = $('#oficina_id').val();
	$('#oficina').val('');
	if(oficina_id !== ''){
		$.ajax({
			url: "expedientes/oficinas/get_oficina",
			type: "POST",
			dataType: "json",
			data: {oficina_id: oficina_id, csrf_lavalle: hash}
		}).done(function(data) {
			if(data.nombre === undefined){
				window.alert('No existe oficina');
			} else {
				$('#oficina').val(data.nombre);
				$('#oficina').focus();
				$('#btn_buscar_oficina_destino').focus();
			}
		});
	}
}

function actualizar_solicitante() {
	var oficina_id = $('#persona_id').val();
	$('#caratula').val('');
	if(oficina_id !== ''){
		$.ajax({
			url: "expedientes/oficinas/get_oficina",
			type: "POST",
			dataType: "json",
			data: {oficina_id: oficina_id, csrf_lavalle: hash}
		}).done(function(data) {
			if(data.nombre === undefined){
				window.alert('No existe oficina');
			} else {
				$('#caratula').val(data.nombre);
				$('#caratula').focus();
				$('#buscar_solicitante_modal').focus();
			}
		});
	}
}


function actualizar_tramites() {
	var tipo_tramite = $('#tipo_tramite option:selected').val();
	$('#persona_id').val('');
	$('#caratula').val('');
	jQuery('#btn_buscar_oficina_solicitante').hide();
	jQuery('#btn_buscar_solicitante').hide();

	$.ajax({
		url: "expedientes/tramites/get_tramites",
		type: "POST",
		dataType: "json",
		data: {tipo_tramite: tipo_tramite, csrf_lavalle: hash}
	}).done(function(data) {
		var select = $('#tramite');
		if (select.prop) {
			var options = select.prop('options');
		} else {
			var options = select.attr('options');
		}
		$('option', select).remove();
		options[options.length] = new Option('-- Seleccionar trámite --', 0);
		$.each(data, function(text, val) {
			options[options.length] = new Option(text, val);
		});
		if (tipo_tramite === 'I' || tipo_tramite === 'ID') {
			jQuery('#btn_buscar_oficina_solicitante').show();
			jQuery('#div_persona_id').show();
			jQuery('#div_caratula').attr('class', 'form-group col-md-6 col-sm-6 col-xs-8');
			jQuery('#persona_id').removeAttr('disabled');
			
		} else if (tipo_tramite === 'E' || tipo_tramite === 'ED') {
			jQuery('#btn_buscar_solicitante').show();
			jQuery('#div_persona_id').hide();
			jQuery('#div_caratula').attr('class', 'form-group col-md-9 col-sm-9 col-xs-12');
		} else {
			jQuery('#persona_id').attr('disabled', 'true');
		}
	});
}
function ver_estado_expediente(expt_id) {
	$.ajax({
		url: "expedientes/expedientes/get_estado",
		type: "POST",
		dataType: "json",
		data: {id: expt_id, csrf_lavalle: hash}
	}).done(function(data) {
		$('#estado_expediente').html(data.estado);
		$('#oficina_expediente').html(data.oficina);
		$('#fecha_expediente').html(data.fecha);
		$('#nota_expediente').html(data.nota);
		$('#estado_expediente_modal').modal('show');
	});
}
function ver_nota_pase(nota_pase_id) {
	$.ajax({
		url: "expedientes/notas_pases/get_nota",
		type: "POST",
		dataType: "json",
		data: {id: nota_pase_id, csrf_lavalle: hash}
	}).done(function(data) {
		$('#contenido_nota').html(data.contenido);
		$('#nota_pase_modal').modal('show');
	});
}
function ver_extras_expediente() {
	var tramite = $('#tramite option:selected').val();
	if (tramite === '18' || tramite === '17' || tramite === '1' || tramite === '61' || tramite === '29' || tramite === '2' || tramite === '19') {	//BAJA COMERCIO/HAB COMERCIO/CONEXION AGUA/CONEXION CLOACA/CONEXION GAS/CONEXION LUZ/TRASLADO DE COMERCIO
		$('#div-inmueble').show();
		$('#div-ayuda-social').hide();
	} else if (tramite === '100' || tramite === '101') { //AYUDA SOCIAL
		$('#div-inmueble').hide();
		$('#div-ayuda-social').show();
	} else {
		$('#div-inmueble').hide();
		$('#div-ayuda-social').hide();
	}
}

/*Seleccion multiple de firmantes*/
var array_user =new Array();
function comprobarSeleccionados(){
	console.log(array_user);
	var filas = $('#usuarios_table').find('tbody').find('tr');
	$.each(filas, function(key, value){
		var iduser = $(value).find('td:eq(2)').find('input:eq(0)').prop('id');
		var seleccionado = array_user.includes(iduser);
		if(seleccionado){
			$(value).css({
				'background' : '#4A75B5',
				'color' : '#FFFFFF'
			});
		}
	});		
}
function checkedArray_firmas(id, val, fila){
	if(val){
		if(!array_user.includes(id)){
			array_user.push(id);
			$(fila).css({
				'background' : '#4A75B5',
				'color' : '#FFFFFF'
			});
		} else {
			var pos = array_user.indexOf(id);
			array_user.splice( pos, 1 );
			$(fila).prop('style', '');
		}
	}else if(!val){
		var pos = array_user.indexOf(id);
		array_user.splice( pos, 1 );
		$(fila).prop('style', '');	
	}
	console.log(array_user);
}
function borrar_firmas(){
	array_user = [];
}
function enviar_solicitud_firmas(id_archivo_adjunto){
	
	var json_solicitud = JSON.stringify({"id_user": array_user});
	
	var request = $.ajax({
		url: "expedientes/Archivos_adjuntos/solicitar_firma/" + id_archivo_adjunto + "/" + array_user[0] ,
		method: "POST",
		data: { users : json_solicitud },
		dataType: "html"
	});
	
	request.done(function() {
		array_user = [];
		$('#buscar_usuario_modal').modal('hide');
		location.reload();
	});
}

/*victor*/
var array_docs_firmar = new Array();
$("#btn-firmar-selec").hide();

function agregar_solicitud_firma(docuento_adjunto_id, firma_id){
    if(array_docs_firmar.indexOf({pdf_id : docuento_adjunto_id,firma_id: firma_id}) >= 0){
        array_docs_firmar.splice(array_docs_firmar.indexOf(docuento_adjunto_id,1));
    }else{
        array_docs_firmar.push({pdf_id : docuento_adjunto_id,firma_id: firma_id});
    }
    
    if(array_docs_firmar.length == 0)
        $("#btn-firmar-selec").hide();
    else 
        $("#btn-firmar-selec").show();
}

function confirmar_firmas(){
	var password = $('input[name="password"]').val();
	if(password === ''){
		alert('Ingrese una contraseña');
	} else {
		var json_afirmar = JSON.stringify({"id_files":array_docs_firmar});
		$.post('expedientes/firmas/confirmar_firma', {
			password : password,
			afirmar : json_afirmar,
		}).done(function(data){
			if(data === ''){
				$('#alert-error').show();
			} else {
				$('input[name="password"]').val('');
				var jnlp = JSON.parse(data);
				var blob = new Blob([jnlp.xml_str], {
					type: 'text/plain'
				});
				descargarArchivo(blob,jnlp.fichero_name);
			}
		});
	}
}

function descargarArchivo(contenidoEnBlob, nombreArchivo) {
    var reader = new FileReader();
    reader.onload = function (event) {
        var save = document.createElement('a');
        save.href = event.target.result;
        save.target = '_blank';
        save.download = nombreArchivo || 'archivo.dat';
        var clicEvent = new MouseEvent('click', {
            'view': window,
                'bubbles': true,
                'cancelable': true
        });
        save.dispatchEvent(clicEvent);
        (window.URL || window.webkitURL).revokeObjectURL(save.href);
    };
    reader.readAsDataURL(contenidoEnBlob);
};

var pase_id = '';
function guardar_pase_id(id){
	pase_id = id;
}

function confirmar_a_resolucion(){
	var motivo = $('#motivo_resolucion').val();
	var usuario = $('select[name="usuario_derivado"]').val();
	if(pase_id !== '' && motivo !== ""){
		$.post('expedientes/pases/enviar_a_resolucion/'+pase_id, {
			motivo: motivo,
			usuario: usuario
		});
		location.reload();
	} else {
		alert('Ingrese un motivo');
	}
}

