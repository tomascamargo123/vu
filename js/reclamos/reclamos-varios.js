function actualizar_estado() {
	var estado = $('#estado option:selected').val();
	if (estado === 'Finalizado') {
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1;
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd
		}
		if (mm < 10) {
			mm = '0' + mm
		}
		today = dd + '-' + mm + '-' + yyyy;
		$('#fecha_finalizacion').val(today);
		$('#resolucion').attr('readonly', false);
	} else {
		$('#fecha_finalizacion').val('');
		$('#resolucion').attr('readonly', true);
	}
}

function actualizar_grupo(uso, msj) {
	var sector = $('#sector option:selected').val();
	$.ajax({
		url: "reclamos/sectores/get_grupo",
		type: "POST",
		dataType: "json",
		data: {sector: sector, csrf_lavalle: hash}
	}).done(function(data) {
		if (data !== "error") {
			$("#grupo").val(data);
			$('#grupo').next('div').find('input').val($("#grupo option:selected").text());
			$("#aviso_msj").html(msj);
			if (uso !== 'inicio') {
				$("#dialog_form_avisos").modal();
			}
		}
	});
}

function actualizar_motivos(template) {
	var sector = $('#sector option:selected').val();
	$.ajax({
		url: "reclamos/motivos_reclamos/get_motivos_por_sector",
		type: "POST",
		dataType: "json",
		data: {sector: sector, template: template, csrf_lavalle: hash}
	}).done(function(data) {
		if (data !== "error") {
			var select = $('#motivo');
			if (select.prop) {
				var options = select.prop('options');
			}
			else {
				var options = select.attr('options');
			}
			$('option', select).remove();
			if (template === 'list' || template === 'map') {
				options[options.length] = new Option('Todos', 'Todos');
			} else if (template === 'abm') {
				options[options.length] = new Option('-- Seleccionar motivo --', '0');
			}
			$.each(data, function(text, val) {
				options[options.length] = new Option(text, val);
			});
			select.next('div').find('input').val($("#motivo option:selected").text());
			if (template === 'map') {
				filtrarFiguras();
			}
		}
	});
}

function actualizar_vencimiento() {
	var id = $('#prioridad option:selected').val();
	var fecha_inicio = $('#fecha_inicio').val();
	$.ajax({
		url: "reclamos/prioridades/get_vencimiento",
		type: "POST",
		dataType: "json",
		data: {id: id, fecha_inicio: fecha_inicio, csrf_lavalle: hash}
	}).done(function(data) {
		if (data !== "error") {
			$('#vencimiento').val(data);
		}
	});
}

function actualizar_solicitante() {
	var dni = $('#solicitante').val();
	if (dni === '') {
		$('#apellido').attr('placeholder', 'Ingrese Apellido');
		$('#nombre').attr('placeholder', 'Ingrese Nombre');
		$('#mail').attr('placeholder', 'Ingrese Mail');
		$('#telefono').attr('placeholder', 'Ingrese Teléfono');
		$('#apellido,#nombre,#mail,#telefono').attr('readonly', false);
	} else {
		$.ajax({
			url: "reclamos/solicitantes/get_solicitante",
			type: "POST",
			dataType: "json",
			data: {dni: dni, csrf_lavalle: hash}
		}).done(function(data) {
			if (data !== "error") {
				$('#solicitante').val(data.dni);
				$('#apellido').val(data.apellido);
				$('#nombre').val(data.nombre);
				$('#mail').val(data.mail);
				$('#telefono').val(data.telefono);
				$('#apellido,#nombre,#mail,#telefono').attr('readonly', true);
			} else {
				$('#apellido').val('');
				$('#apellido').attr('placeholder', 'Ingrese Apellido');
				$('#nombre').val('');
				$('#nombre').attr('placeholder', 'Ingrese Nombre');
				$('#mail').val('');
				$('#mail').attr('placeholder', 'Ingrese Mail');
				$('#telefono').val('');
				$('#telefono').attr('placeholder', 'Ingrese Teléfono');
				$('#apellido,#nombre,#mail,#telefono').attr('readonly', false);
			}
		});
	}
}

function actualizar_tipo_solicitante() {
	var tipo = $('#tipo_solicitante').val();
	if (tipo === 'Interno') {
		$('#solicitante').val('');
		$('#apellido').val('');
		$('#nombre').val('');
		$('#mail').val('');
		$('#telefono').val('');
		$('#solicitante,#apellido,#nombre,#mail,#telefono').attr('readonly', true);
		$('#btn_buscar_solicitante').prop('disabled', true);
	} else {
		$('#solicitante,#apellido,#nombre,#mail,#telefono').attr('readonly', false);
		$('#btn_buscar_solicitante').prop('disabled', false);
	}
}

function centrar_mapa() {
	var distrito = $('#distrito option:selected').val();
	$.ajax({
		url: "distritos/get_coordenadas",
		type: "POST",
		dataType: "json",
		data: {distrito: distrito, csrf_lavalle: hash}
	}).done(function(data) {
		if (data !== "error") {
			centerMap(data.lat_mapa, data.long_mapa);
		}
	});
}

function habilitar_solicitante() {
	$('#solicitante').attr('readonly', false);
	$('#solicitante').val('');
	actualizar_solicitante();
}

function filtrar_graficos_reportes() {
	var fecha_desde = -1;
	var fecha_hasta = -1;
	if ($('#inicio_reclamos').val() !== '') {
		fecha_desde = $('#inicio_reclamos').data('daterangepicker').startDate.format('DD/MM/YYYY');
		fecha_hasta = $('#inicio_reclamos').data('daterangepicker').endDate.format('DD/MM/YYYY');
	}
	var sector = $('#sector option:selected').val();
	var grupo = $('#grupo option:selected').val();
	var distrito = $('#distrito option:selected').val();
	$.ajax({
		type: "POST",
		url: 'reclamos/graficos/getData',
		dataType: "json",
		data: {sector: sector, grupo: grupo, distrito: distrito, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, csrf_lavalle: hash},
		success: function(data) {
			if (data !== null) {
				linechartreclamos.destroy();
				linechartreclamos = new Chart(linechartreclamosCanvas).Line(data[0], linechartreclamosOptions);

				piechartsectores.destroy();
				piechartsectores = new Chart(piechartsectoresCanvas).Doughnut(data[1], piechartsectoresOptions);
				$("#chart-legend").html(piechartsectores.generateLegend());
				if (sector !== 'Todos') {
					$("#titulo_grafico_3").html('Reclamos por motivo');
					$("#titulo_grafico_4").html('Reclamos finalizados por motivo');
					$("#titulo_grafico_6").html('Reclamos detalle por motivo');
				} else {
					$("#titulo_grafico_3").html('Reclamos por sector');
					$("#titulo_grafico_3").html('Reclamos finalizados por sector');
					$("#titulo_grafico_3").html('Reclamos detalle por sector');
				}

				$("#knob-reclamos-pendiente").val(data[2]['Pendiente']);
				$("#knob-reclamos-pendiente").trigger('change');
				$("#knob-reclamos-en-proceso").val(data[2]['En Proceso']);
				$("#knob-reclamos-en-proceso").trigger('change');
				$("#knob-reclamos-finalizados").val(data[2]['Finalizado']);
				$("#knob-reclamos-finalizados").trigger('change');
				$("#knob-reclamos-anulados").val(data[2]['Anulado']);
				$("#knob-reclamos-anulados").trigger('change');

				barchartvencimiento.destroy();
				barchartvencimiento = new Chart(barchartvencimientoCanvas).Bar(data[3], barchartvencimientoOptions);

				barchartsatisfaccion.destroy();
				barchartsatisfaccion = new Chart(barchartsatisfaccionCanvas).Bar(data[4], barchartsatisfaccionOptions);

				barchartsectores.destroy();
				barchartsectores = new Chart(barchartsectoresCanvas).Bar(data[5], barchartsectoresOptions);
			}
		}
	});
}