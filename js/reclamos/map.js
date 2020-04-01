var map = '';
var marker = '';
var markersArray = [];

function initialize() {
	if (centro !== null) {
		var center = new google.maps.LatLng(centro.lat, centro.long);
	} else {
		var center = new google.maps.LatLng(-32.720525, -68.595277);
	}
	var mapOptions = {
		zoom: 14,
		disableDoubleClickZoom: false,
		center: center,
		mapTypeId: google.maps.MapTypeId.HYBRID
	};
	map = new google.maps.Map(document.getElementById('map'), mapOptions);

	if (editable)
		google.maps.event.addListener(map, 'click', function(event) {
			placeMarker(event.latLng);
			document.getElementById("lat_mapa").value = event.latLng.lat();
			document.getElementById("long_mapa").value = event.latLng.lng();
		});
	loadMarker();
}

function placeMarker(location) {
	deleteOverlays();
	marker = new google.maps.Marker({
		position: location,
		map: map,
		draggable: editable,
		animation: google.maps.Animation.DROP
	});
	markersArray.push(marker);
	google.maps.event.addListener(marker, 'dragend', function(event) {
		document.getElementById("lat_mapa").value = event.latLng.lat();
		document.getElementById("long_mapa").value = event.latLng.lng();
	});
}

function deleteOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}
}

function loadMarker() {
	var input_lat = document.getElementById('lat_mapa').value;
	var input_lng = document.getElementById('long_mapa').value;

	if (input_lat !== '' && input_lng !== '') {
		var ubicacion = new google.maps.LatLng(input_lat, input_lng);
		placeMarker(ubicacion);
		map.setCenter(ubicacion);
	}
}

function centerMap(lat, lng) {
	if (lat !== '' && lng !== '') {
		var center = new google.maps.LatLng(lat, lng);
		map.setCenter(center);
	}
}

function codeAddress(address) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({address: address + ', Lujan de Cuyo, MZ', region: 'AR'}, function(results, status) {
		deleteOverlays();
		var add = false;
		if (status === google.maps.GeocoderStatus.OK) {
			for (var row in results[0].address_components) {
				if (jQuery.inArray('route', results[0].address_components[row].types) !== -1) {
					console.log('ok');
					add = true;
				}
			}
			if (add) {
				document.getElementById("lat_mapa").value = results[0].geometry.location.lat();
				document.getElementById("long_mapa").value = results[0].geometry.location.lng();
				loadMarker();
//				map.setCenter();
//				var marker = new google.maps.Marker({
//					map: map,
//					position: results[0].geometry.location
//				});
//				markers.push(marker);
//				console.log(results[0].geometry);
//				document.getElementById("lat_mapa").value = results[0].geometry.location.lat();
//				document.getElementById("long_mapa").value = results[0].geometry.location.lng();
			}
			var new_addr = results[0].formatted_address;
			$(geocode_found_addr).html(new_addr.replace(', Mendoza, Argentina', ''));
		} else {
			$(geocode_found_addr).html(' - Sin Resultados - ');
		}
	});
}
google.maps.event.addDomListener(window, 'load', initialize);