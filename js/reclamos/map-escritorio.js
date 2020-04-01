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
	filtrarFiguras();
};

function dibujarMapa(data_figura) {
	if (data_figura !== '') {
		var _figuras = data_figura;
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
	}
}

function filtrarFiguras() {
	limpiarMapa();
	$.ajax({
		type: "POST",
		url: 'reclamos/escritorio/getMapData',
		dataType: "json",
		data: {csrf_lavalle: hash},
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
}