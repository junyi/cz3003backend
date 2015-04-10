// This example displays a marker at the center of Singapore.
// When the user clicks the marker, an info window opens.

var roadMarkers = [];
var fireMarkers = [];
var dengueMarkers = [];
var floodMarkers = [];
var suicideMarkers = [];
var infoWindow;
var map;
var weatherLayer;
var ctaLayer;

function addRoadMarker(location, title) {
    var roadMarker = new google.maps.Marker({
        position: location,
        map: map,
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        title: title
    });
    roadMarkers.push(roadMarker);
}

function addFireMarker(location, title) {
    var fireMarker = new google.maps.Marker({
        position: location,
        map: map,
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        title: title
    });
    fireMarkers.push(fireMarker);
}

function addFloodMarker(location, title) {
    var floodMarker = new google.maps.Marker({
        position: location,
        map: map,
        icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png',
        title: title
    });
    floodMarkers.push(floodMarker);
}

function addSuicideMarker(location, title) {
    var suicideMarker = new google.maps.Marker({
        position: location,
        map: map,
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png',
        title: title
    });
    suicideMarkers.push(suicideMarker);
}

function addDengueMarker(polygon, severity) {
    var stroke;
    var fill;
    
    if (severity == 'Alert') {
        //red
        fill = "red";
    } else {
        //yellow
        fill = "yellow";
    }

    var gpolygon = new google.maps.Polygon({
      paths: polygon,
      strokeOpacity:  0.8,
      strokeWeight:   2,
      fillColor:  fill,
      fillOpacity:    0.4,
    });

    gpolygon.setMap(map);
    dengueMarkers.push(gpolygon);
}

function addRoadMarkerListener(i, title, content) {
    google.maps.event.addListener(roadMarkers[i], 'click', function() { 
        if (infoWindow) {
            infoWindow.close();
        }
        
        infoWindow = new google.maps.InfoWindow({
            content: '<div id="content"><h5 id="firstHeading" class="firstHeading">' + title + '</h5><div id="bodyContent"><p>' + content + '</p></div></div>'
        });
        
        infoWindow.open(map, roadMarkers[i]);
    });
}

function addFireMarkerListener(i, title, content) {
    google.maps.event.addListener(fireMarkers[i], 'click', function() { 
        if (infoWindow) {
            infoWindow.close();
        }
        
        infoWindow = new google.maps.InfoWindow({
            content: '<div id="content"><h5 id="firstHeading" class="firstHeading">' + title + '</h5><div id="bodyContent"><p>' + content + '</p></div></div>'
        });
        
        infoWindow.open(map, fireMarkers[i]);
    });
}


function addDengueMarkerListener(i, region, severity, numOfPeople, center) {
    google.maps.event.addListener(dengueMarkers[i], 'click', function() { 
        if (infoWindow) {
            infoWindow.close();
        }
        
        infoWindow = new google.maps.InfoWindow({
            content: '<div id="content"><h5 id="firstHeading" class="firstHeading">' + 'Dengue Hotspot</h5><div id="bodyContent"><p>No. of people infected: ' + numOfPeople + '<br/>Location: ' + region + '</p></div></div>',
            position: center
        });
        
        infoWindow.open(map, dengueMarkers[i]);
    });
}

//function to SET all ROAD markers onto map
function showRoadMarkers(map) {
    for(i=0; i<roadMarkers.length;i++) {
        roadMarkers[i].setMap(map);
    }
}

//function to SET all FIRE markers onto map
function showFireMarkers(map) {
    for(i=0; i<fireMarkers.length;i++) {
        fireMarkers[i].setMap(map);
    }
}

//function to SET all DENGUE markers onto map
function showDengueMarkers(map) {
    for(i=0; i<dengueMarkers.length;i++) {
        dengueMarkers[i].setMap(map);
    }
}

//function to CLEAR all ROAD markers from map
function clearRoadMarkers() {
    for(i=0; i<roadMarkers.length;i++) {
        roadMarkers[i].setMap(null);
    }
}

//function to CLEAR all FIRE markers from map
function clearFireMarkers() {
    for(i=0; i<fireMarkers.length;i++) {
        fireMarkers[i].setMap(null);
    }
}

//function to CLEAR all DENGUE markers from map
function clearDengueMarkers() {
    for(i=0; i<dengueMarkers.length;i++) {
        dengueMarkers[i].setMap(null);
    }
}


function toggleRoadMarkers(btn) {
    if(btn.checked == true) {
        showRoadMarkers(map);
    } else {
        clearRoadMarkers();
    }
}

function toggleFireMarkers(btn) {
    if(btn.checked == true) {
        showFireMarkers(map);
    } else {
        clearFireMarkers();
    }
}

function toggleDengueMarkers(btn) {
    if(btn.checked == true) {
        showDengueMarkers(map);
    } else {
        clearDengueMarkers();
    }
}

function initializeWeatherLayer(map) {
    weatherLayer = new google.maps.weather.WeatherLayer({
        temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT
    });
}

function showWeather() {
    weatherLayer.setMap(map);
}

function clearWeather() {
    weatherLayer.setMap(null);
}

function toggleWeather(btn) {
    if(btn.checked == true) {
        showWeather();
    } else {
        clearWeather();
    }
}

function showRegionOverlays() {
    ctaLayer.setMap(map);
}

function hideRegionOverlays() {
    ctaLayer.setMap(null);
}

function toggleRegionOverlays(btn) {
    if (btn.checked == true) {
        showRegionOverlays();
    } else {
        hideRegionOverlays();
    }
}

function initialize() {
    //initialize map
    var mapCenterLatLng = new google.maps.LatLng(1.337831, 103.832363);
    var mapOptions = {
      zoom: 11,
      center: mapCenterLatLng
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    infoWindow = null;
    
    //initialize weather layer
    initializeWeatherLayer(map);
    
    ctaLayer = new google.maps.KmlLayer({
      url: 'https://dl.dropboxusercontent.com/u/18619627/timecrisis/map.kmz',
    });

    var polygons = [];
    
    $.getJSON("/dengue.json", function( data ) {
      for(i = 0; i < data.length; i++){
        // marker = [new google.maps.LatLng(data[i].latitude, data[i].longitude), data[i].radius, data[i].noOfPeopleInfected];
        // dengueHotSpots.push(marker);
        
        // addDengueMarker(marker[0], marker[1]);
        // addDengueMarkerListener(i, marker[1], marker[2]);

        var points = data[i].polygon.split("|");
        var polygon = [];
        var bounds = new google.maps.LatLngBounds();

        for (var j = 0; j < points.length; j++) {
          points[j] = points[j].split(",");
          polygon.push(new google.maps.LatLng(parseFloat(points[j][0]), parseFloat(points[j][1])));
        };

        for (var j = 0; j < points.length; j++) {
            bounds.extend(polygon[i]);
        }

        addDengueMarker(polygon, data[i].severity);
        addDengueMarkerListener(i, data[i].region, data[i].severity, data[i].noOfPeopleInfected, bounds.getCenter());

      }

    });

    $.getJSON("/incident.json", function( data ) {
      for(i = 0; i < data.length; i++){
        
        marker = [new google.maps.LatLng(data[i].latitude, data[i].longitude), data[i].incidentTitle, data[i].incidentDetails];
        
        if (data[i].incidentCategoryID == 1) {
            addRoadMarker(marker[0], marker[1]);
            addRoadMarkerListener(i, marker[1], marker[2]);
        } else if(data[i].incidentCategoryID == 2) {
            addFireMarker(marker[0], marker[1]);
        } else if(data[i].incidentCategoryID == 3) {
            addFloodMarker(marker[0], marker[1]);
        } else if(data[i].incidentCategoryID == 4) {
            addSuicideMarker(marker[0], marker[1]);
        } else {
            alert('fail');
        }
      }
    });

}

google.maps.event.addDomListener(window, 'load', initialize);