$(function() {
	$(this).find('.box-body').find('select,input:not([readonly])').filter(':first').focus();
	$(this).find('.box-body').find('select,input:not([readonly]),input:not(.daterange):not([readonly])').filter(':first').select();
	$("body").on('collapsed.pushMenu', function(e) {
		set_menu_collapse(1);
	});
	$("body").on('expanded.pushMenu', function(e) {
		set_menu_collapse(0);
	});

	$('form').preventDoubleSubmission();

	$('.datepicker').each(function(index, element) {
		$(element).daterangepicker({
			singleDatePicker: true,
			"locale": {
				"format": "DD/MM/YYYY",
				"daysOfWeek": [
					"Do",
					"Lu",
					"Ma",
					"Mi",
					"Ju",
					"Vi",
					"Sa"
				],
				"monthNames": [
					"Enero",
					"Febrero",
					"Marzo",
					"Abril",
					"Mayo",
					"Junio",
					"Julio",
					"Agosto",
					"Septiembre",
					"Octubre",
					"Noviembre",
					"Diciembre"
				],
				"firstDay": 1
			}
		});
	});

	$('.daterange').each(function(index, element) {
		$(element).daterangepicker({
			"locale": {
				"format": "DD/MM/YYYY",
				"separator": " - ",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cancelar",
				"fromLabel": "Desde",
				"toLabel": "Hasta",
				"daysOfWeek": [
					"Do",
					"Lu",
					"Ma",
					"Mi",
					"Ju",
					"Vi",
					"Sa"
				],
				"monthNames": [
					"Enero",
					"Febrero",
					"Marzo",
					"Abril",
					"Mayo",
					"Junio",
					"Julio",
					"Agosto",
					"Septiembre",
					"Octubre",
					"Noviembre",
					"Diciembre"
				],
				"firstDay": 1
			},
			"applyClass": "btn-primary",
			"startDate": ((typeof startDate !== 'undefined') ? startDate : "01/01/" + moment().year()),
			"endDate": ((typeof endDate !== 'undefined') ? endDate : "31/12/" + moment().year()),
			"minDate": ((typeof minDate !== 'undefined') ? minDate : "01/01/" + (moment().year() - 10)),
			"maxDate": ((typeof maxDate !== 'undefined') ? maxDate : "31/12/" + (moment().year() + 10))
		});
	});
});

function set_menu_collapse(val) {
	$.ajax({
		type: 'POST',
		url: 'ajax/set_menu_collapse',
		data: {value: val, csrf_lavalle: hash},
		dataType: 'json'
	});
}

jQuery.fn.preventDoubleSubmission = function() {
	$(this).bind('submit', function(e) {
		var $form = $(this);
		if ($form.data('submitted') === true) {
			e.preventDefault();
		} else {
			$form.data('submitted', true);
		}
	});
	return this;
};