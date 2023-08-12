google.maps.event.addDomListener(window, "load", initialize);

function initialize() {
	var input = document.getElementById("alamatLayanan");
	var autocomplete = new google.maps.places.Autocomplete(input);
	autocomplete.addListener("place_changed", function() {
		var place = autocomplete.getPlace();
		console.log(place);
		var clickedLocation = place["geometry"]["location"];
		console.log(clickedLocation);

		$("#lat").val(place.geometry["location"].lat());
		$("#long").val(place.geometry["location"].lng());
	});
}
$(document).ready(function() {
	$("#detailLocation").hide();
	$("#alamatLayanan").bind("keypress", function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
		}
	});
	initMap();
	var map; //Will contain map object.
	var marker = false; ////Has the user plotted their location marker?

	//Function called to initialize / create the map.
	//This is called when the page has loaded.
	function initMap() {
		var centerOfMap;
		var geocoder = new google.maps.Geocoder();
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(position => {
				console.log(position);
				centerOfMap = new google.maps.LatLng(
					position.coords.latitude,
					position.coords.longitude
				);

				var options = {
					center: centerOfMap, //Set center.
					zoom: 18 //The zoom value.
				};

				//Create the map object.
				map = new google.maps.Map(document.getElementById("map"), options);

				let marker = new google.maps.Marker({
					map: map,
					position: {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					},
					title: "Lokasi anda"
				});

				//Listen for any clicks on the map.
				google.maps.event.addListener(map, "click", function(event) {
					//Get the location that the user clicked.
					var clickedLocation = event.latLng;
					//If the marker hasn't been added.
					if (marker === false) {
						//Create the marker.
						marker = new google.maps.Marker({
							position: clickedLocation,
							map: map,
							draggable: true //make it draggable
						});
						//Listen for drag events!
						google.maps.event.addListener(marker, "dragend", function(event) {
							var currentLocation = marker.getPosition();
							//Add lat and lng values to a field that we can save.
							document.getElementById("lat").value = currentLocation.lat(); //latitude
							document.getElementById("long").value = currentLocation.lng(); //longitude
						});
					} else {
						//Marker has already been added, so just change its location.
						console.log(clickedLocation);
						marker.setPosition(clickedLocation);
					}
					//Get the marker's location.
					var currentLocation = marker.getPosition();
					//Add lat and lng values to a field that we can save.
					document.getElementById("lat").value = currentLocation.lat(); //latitude
					document.getElementById("long").value = currentLocation.lng(); //longitude

					const Http = new XMLHttpRequest();
					const url =
						"https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
						currentLocation.lat() +
						"," +
						currentLocation.lng() +
						"&key=AIzaSyCd3miLE8-Nd7ItbiXjPe0v3ALs-BziV3c";
					Http.open("GET", url);
					Http.send();

					Http.onreadystatechange = e => {
						console.log(Http.responseText);
					};
				});
			});
		} else {
			alert("Geolocation is not supported by this browser.");
		}
		//The center location of our map.
	}

	//This function will get the marker's current location and then add the lat/long
	//values to our textfields so that we can save the location.
	function markerLocation() {
		//Get location.
		var currentLocation = marker.getPosition();
		//Add lat and lng values to a field that we can save.
		document.getElementById("lat").value = currentLocation.lat(); //latitude
		document.getElementById("long").value = currentLocation.lng(); //longitude
	}
});
