var map;
var heatmap;
var cantidad_figuras = 0;
var figuras = {};
var markersArray = [];
var infowindow = new google.maps.InfoWindow();

window.onload = function() {
	var myOptions = {
		zoom: 14,
		disableDoubleClickZoom: false,
		center: new google.maps.LatLng(-32.720525, -68.595277),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map-reclamos"), myOptions);
	heatmap = new HeatmapOverlay(map,
			{
				// radius should be small ONLY if scaleRadius is true (or small radius is intended)
				"radius": 30,
				"maxOpacity": 1,
				// scales the radius based on map zoom
				"scaleRadius": false,
				// if set to false the heatmap uses the global maximum for colorization
				// if activated: uses the data maximum within the current map boundaries 
				//   (there will always be a red spot with useLocalExtremas true)
				"useLocalExtrema": false,
				// which field name in your data represents the latitude - default "lat"
				latField: 'lat',
				// which field name in your data represents the longitude - default "lng"
				lngField: 'lng',
				// which field name in your data represents the data value - default "value"
				valueField: 'count',
				gradient: {0.20: "rgb(0,0,255)", 0.40: "rgb(0,255,0)", 0.60: "yellow", 0.80: "rgb(255,0,0)"}
			}
	);
	filtrarFiguras();
};

function dibujarMapa(data_figura) {
	if (data_figura !== '') {
		var _figuras = data_figura;
		if (tipo === 'puntos') {
			$.each(_figuras, function(key, value) {
				var index = cantidad_figuras;
				figuras[index] = value;
				var figura_overlay = new google.maps.Marker({
					position: new google.maps.LatLng(value.puntos[0]['lat'], value.puntos[0]['lng']),
					icon: 'img/reclamos/sectores/' + value.marker + '.png',
					clickable: true,
					draggable: false
				});
				markersArray.push(figura_overlay);
				figura_overlay.setMap(map);
				google.maps.event.addListener(figura_overlay, 'click', function(e) {
					infowindow.setContent(value.tooltip);
					infowindow.setPosition(e.latLng);
					infowindow.open(map);
				});
				cantidad_figuras++;
			});
		} else {
			var ar = [];
			$.each(_figuras, function(key, value) {
				ar.push({lat: value.puntos[0]['lat'], lng: value.puntos[0]['lng'], count: 1});
			});
			heatmap.setData({
				max: 8,
				data: ar
			});
		}
	}
}

function filtrarFiguras() {
	var fecha_desde = -1;
	var fecha_hasta = -1;
	if ($('#inicio_reclamos').val() !== '') {
		fecha_desde = $('#inicio_reclamos').data('daterangepicker').startDate.format('DD/MM/YYYY');
		fecha_hasta = $('#inicio_reclamos').data('daterangepicker').endDate.format('DD/MM/YYYY');
	}
	var sector = $('#sector option:selected').val();
	var motivo = $('#motivo option:selected').val();
	var estado = $('#estado').val();
	var grupo = $('#grupo option:selected').val();
	var distrito = $('#distrito option:selected').val();
	limpiarMapa();
	$.ajax({
		type: "POST",
		url: 'reclamos/Mapa/getData',
		dataType: "json",
		data: {sector: sector, motivo: motivo, estado: estado, grupo: grupo, distrito: distrito, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, csrf_lavalle: hash},
		success: function(data, textStatus, jqXHR) {
			if (data !== null) {
				dibujarMapa(data);
			}
		}
	});
}

function limpiarMapa() {
	//Limpia puntos
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}

	//Limpia calor
	heatmap.setData({
		max: 8,
		data: []
	});
}