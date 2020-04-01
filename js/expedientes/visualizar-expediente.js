// Renderizar Pag pdf.js
function renderPage(num, hoja) {
	pdfDoc.getPage(num).then(function(page) {
		var viewport = page.getViewport(scale);
		hoja.height = viewport.height;
		hoja.width = viewport.width;
		var renderContext = {
			canvasContext: hoja.getContext('2d'),
			viewport: viewport
		};
		page.render(renderContext);
	});
}

function loadApp() {
	//Evento Window Ready
	$('#canvas').fadeIn(1000);
	var flipbook = $('.magazine');

	// Check if the CSS was already loaded
	if (flipbook.width() == 0 || flipbook.height() == 0) {
		setTimeout(loadApp, 10);
		return;
	}

	// Create the flipbook
	flipbook.turn({
		display: 'single',
		acceleration: !isChrome(),
		// Magazine width
		width: 420,
		// Magazine height
		height: 597,
		// Duration in millisecond
		duration: 1000,
		// Enables gradients
		gradients: true,
		// Auto center this flipbook
		autoCenter: true,
		// Elevation from the edge of the flipbook when turning a page
		elevation: 50,
		// Events
		when: {
			turning: function(event, page, view) {
				var book = $(this), currentPage = book.turn('page'), pages = book.turn('pages');
				// Update the current URI
				Hash.go('page/' + page).update();
				$.ajax('../firmas/' + expediente_id + '/' + page, {
					dataType: 'json',
					success: function(data) {
						var html = '';
						if (data !== 'no_data') {
							$('#firmas-title').html('<span style="font-size:18px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Firmas <i class="fa fa-pencil-square-o" aria-hidden="true"></i><br/>Foja ' + data.foja + '</span><br/>' + data.title);
							for (var i in data.firmas) {
								var firma = data.firmas[i];
								html += '';
								if (firma.firma) {
									html += '<span class="firma firma-' + (firma.valida ? 'valida' : 'invalida') + '" title="' + firma.usuario + '">' + firma.usuario_nombre + ' ' + firma.usuario_apellido + '<br/>' + moment(firma.fecha_firma).format('DD/MM/YYYY HH:mm:ss') + '</span>';
									html += '<br/><span><a class="btn btn-default" href="/expedientes/archivos_adjuntos/descargar_firma/' + firma.id + '">Firma</a></span>';
									html += '<span style="float:right;"><a class="btn btn-default" href="/expedientes/archivos_adjuntos/descargar_clave_publica/' + firma.id + '">Clave Pública</a></span>';
									html += '</div>';
								} else {
									html += '<span class="firma firma-pendiente" title="' + firma.usuario + '">' + firma.usuario_nombre + ' ' + firma.usuario_apellido + '<br/>'+firma.estado+'</span><br/>';
									html += '<span class="solicitud">Solicita: <span title="' + firma.solicitante + '">' + firma.solicitante_nombre + ' ' + firma.solicitante_apellido + '</span><br/>' + moment(firma.fecha_solicitud).format('DD/MM/YYYY HH:mm:ss') + '</span>';
								}
								html += '<br/>';
							}
						} else {
							$('#firmas-title').html('');
						}
						$('#firmas-content').html(html);
					},
				});
				// Show and hide navigation buttons
				disableControls(page);
			},
			turned: function(event, page, view) {
				disableControls(page);
				$(this).turn('center');
				$('#slider').slider('value', getViewNumber($(this), page));
				if (page == 1) {
					$(this).turn('peel', 'br');
				}
			}
		}
	});

	// Zoom.js
	$('.magazine-viewport').zoom({
		flipbook: $('.magazine'),
		max: function() {
			return 2;
		},
		when: {
			swipeLeft: function() {
				$(this).zoom('flipbook').turn('next');
			},
			swipeRight: function() {
				$(this).zoom('flipbook').turn('previous');
			},
			zoomIn: function() {
				$('#slider-bar').hide();
				$('.made').hide();
				$('.magazine').removeClass('animated').addClass('zoom-in');
				$('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');
				if (!window.escTip && !$.isTouch) {
					escTip = true;
					$('<div />', {'class': 'exit-message'}).
									html('<div>Press ESC to exit</div>').
									appendTo($('body')).
									delay(2000).
									animate({opacity: 0}, 500, function() {
										$(this).remove();
									});
				}
			},
			zoomOut: function() {
				$('#slider-bar').fadeIn();
				$('.exit-message').hide();
				$('.made').fadeIn();
				$('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');
				setTimeout(function() {
					$('.magazine').addClass('animated').removeClass('zoom-in');
					resizeViewport();
				}, 0);
			}
		}
	});

	// Zoom event
	if ($.isTouch)
		$('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
	else
		$('.magazine-viewport').bind('zoom.tap', zoomTo);

	// Using arrow keys to turn the page
	$(document).keydown(function(e) {
		var previous = 37, next = 39, esc = 27;
		var charCode = e.which || e.keyCode;
		switch (charCode) {
			case previous:
				// left arrow
				$('.magazine').turn('previous');
				e.preventDefault();
				break;
			case next:
				//right arrow
				$('.magazine').turn('next');
				e.preventDefault();
				break;
			case esc:
				$('.magazine-viewport').zoom('zoomOut');
				e.preventDefault();
				break;
		}
	});

	// URIs - Format #/page/1
	Hash.on('^page\/([0-9]*)$', {
		yep: function(path, parts) {
			var page = parts[1];
			if (page !== undefined) {
				if ($('.magazine').turn('is'))
					$('.magazine').turn('page', page);
			}
		},
		nop: function(path) {
			if ($('.magazine').turn('is'))
				$('.magazine').turn('page', 1);
		}
	});

	$(window).resize(function() {
		resizeViewport();
	}).bind('orientationchange', function() {
		resizeViewport();
	});

	// Events for the next button
	$('.next-button').bind($.mouseEvents.over, function() {
		$(this).addClass('next-button-hover');
	}).bind($.mouseEvents.out, function() {
		$(this).removeClass('next-button-hover');
	}).bind($.mouseEvents.down, function() {
		$(this).addClass('next-button-down');
	}).bind($.mouseEvents.up, function() {
		$(this).removeClass('next-button-down');
	}).click(function() {
		$('.magazine').turn('next');
	});

	// Events for the next button
	$('.previous-button').bind($.mouseEvents.over, function() {
		$(this).addClass('previous-button-hover');
	}).bind($.mouseEvents.out, function() {
		$(this).removeClass('previous-button-hover');
	}).bind($.mouseEvents.down, function() {
		$(this).addClass('previous-button-down');
	}).bind($.mouseEvents.up, function() {
		$(this).removeClass('previous-button-down');
	}).click(function() {
		$('.magazine').turn('previous');
	});

	// Mousewheel
	$('#magazine-viewport').mousewheel(function(event, delta, deltaX, deltaY) {
		var data = $(this).data(),
						step = 30,
						flipbook = $('.magazine'),
						actualPos = $('#slider').slider('value') * step;

		if (typeof (data.scrollX) === 'undefined') {
			data.scrollX = actualPos;
			data.scrollPage = flipbook.turn('page');
		}

		data.scrollX = Math.min($("#slider").slider('option', 'max') * step,
						Math.max(0, data.scrollX + deltaX));

		var actualView = Math.round(data.scrollX / step),
						page = Math.min(flipbook.turn('pages'), Math.max(1, actualView * 2 - 2));

		if ($.inArray(data.scrollPage, flipbook.turn('view', page)) == -1) {
			data.scrollPage = page;
			flipbook.turn('page', page);
		}

		if (data.scrollTimer)
			clearInterval(data.scrollTimer);

		data.scrollTimer = setTimeout(function() {
			data.scrollX = undefined;
			data.scrollPage = undefined;
			data.scrollTimer = undefined;
		}, 1000);
	});

	// Slider
	$("#slider").slider({
		min: 1,
		max: numberOfViews(flipbook),
		stop: function() {
			$('.magazine').turn('page', Math.max(1, $(this).slider('value') * 2 - 2));
		}
	});
	resizeViewport();
	$('.magazine').addClass('animated');

	// Zoom icon
	$('.zoom-icon').bind('mouseover', function() {
		if ($(this).hasClass('zoom-icon-in'))
			$(this).addClass('zoom-icon-in-hover');

		if ($(this).hasClass('zoom-icon-out'))
			$(this).addClass('zoom-icon-out-hover');
	}).bind('mouseout', function() {
		if ($(this).hasClass('zoom-icon-in'))
			$(this).removeClass('zoom-icon-in-hover');

		if ($(this).hasClass('zoom-icon-out'))
			$(this).removeClass('zoom-icon-out-hover');
	}).bind('click', function() {
		if ($(this).hasClass('zoom-icon-in'))
			$('.magazine-viewport').zoom('zoomIn');
		else if ($(this).hasClass('zoom-icon-out'))
			$('.magazine-viewport').zoom('zoomOut');
	});
}
$('#canvas').hide();