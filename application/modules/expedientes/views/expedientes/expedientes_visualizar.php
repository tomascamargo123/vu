<!doctype html>
<html lang="es">
	<head>
    <title>Expedientes - Visualizar</title>
    <meta name="viewport" content="width = 1050, user-scalable = no" />
    <link rel="stylesheet" href="/vu/css/expedientes/visualizar-expediente.css">
		<link rel="stylesheet" href="/vu/plugins/font-awesome/css/font-awesome.min.css" />
		<script type="text/javascript" src="/vu/plugins/turnjs/extras/jquery.min.1.7.js"></script>
		<script type="text/javascript" src="/vu/plugins/turnjs/extras/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="/vu/plugins/turnjs/extras/jquery.mousewheel.min.js"></script>
		<script type="text/javascript" src="/vu/plugins/turnjs/extras/modernizr.2.5.3.min.js"></script>
		<script type="text/javascript" src="/vu/plugins/daterangepicker/moment.min.js"></script>
		<script type="text/javascript" src="/vu/plugins/turnjs/hash.js"></script>
		<script type="text/javascript" src="/vu/plugins/pdfjs/pdf.js"></script>
		<script type="text/javascript" src="/vu/js/expedientes/visualizar-expediente.js"></script>
	</head>
	<body>
		<div id="indice"></div>
		<div id="canvas">
			<div class="zoom-icon zoom-icon-in"></div>
			<div class="magazine-viewport">
				<div ignore="1" class="next-button"></div>
				<div ignore="1" class="previous-button"></div>
				<div class="container">
					<div class="magazine"></div>
				</div>
			</div>
			<div class="bottom">
				<div id="slider-bar" class="turnjs-slider">
					<div id="slider"></div>
				</div>
			</div>
		</div>
    <script type="text/javascript">
		PDFJS.disableWorker = true;
		var pdfDoc, scale, file, np, expediente_id;
		expediente_id =<?php echo $expediente_id; ?>;
		$(document).ready(function() {
			file = '<?php echo base_url(); ?>/expedientes/expedientes/pdf_exportar/<?php echo $expediente_id; ?>/D';

			PDFJS.getDocument(file).then(function(doc) {
				pdfDoc = doc;
				np = (doc.numPages);
				$.ajax('../indice/<?php echo $expediente_id; ?>', {
					dataType: 'json',
					success: function(data) {
						var html = '<ul>';
						html += '<li><span class="pagina"></span><a class="contenido" href="#" onclick="$(\'.magazine\').turn(\'page\', 1);return false;">' + data[1] + '</a></li>';
						for (var i = 2; i <= np; i++) {
							if (typeof data[i] !== 'undefined') {
								html += '<li><span class="pagina">' + String("0" + (i - 1)).slice(-2) + '</span><a class="contenido" href="#" onclick="$(\'.magazine\').turn(\'page\', ' + i + ');return false;">' + data[i] + '</a></li>';
							} else {
								html += '<li><span class="pagina">' + String("0" + (i - 1)).slice(-2) + '</span><a class="contenido" href="#" onclick="$(\'.magazine\').turn(\'page\', ' + i + ');return false;">&nbsp;</a></li>';
							}
						}
						html += '</ul>';
						$('#indice').html(html);
					},
				});
				scale = 2;
				for (var i = 1; i <= np; i++) {
					$(".magazine").html($(".magazine").html() + '<div><canvas id="hoja' + i + '" style="width: 99.4%; height: 99.5%;"></canvas></div>');
				}
				for (var i = 1; i <= np; i++) {
					renderPage(i, document.getElementById('hoja' + i));
				}
				// Load the HTML4 version if there's not CSS transform
				yepnope({
					test: Modernizr.csstransforms,
					yep: ['/vu/plugins/turnjs/turn.min.js'],
					nope: ['/vu/plugins/turnjs/turn.html4.min.js', '/vu/plugins/turnjs/css/jquery.ui.html4.css'],
					both: ['/vu/plugins/turnjs/zoom.min.js', '/vu/plugins/turnjs/css/jquery.ui.css', '/vu/plugins/turnjs/magazine.js', '/vu/plugins/turnjs/css/magazine.css'],
					complete: loadApp
				});
			});
		});
	</script>
		<div id="firmas">
			<div id="firmas-title"></div>
			<div id="firmas-content"></div>
		</div>
	</body>
</html>