// This example displays a marker at the center of Singapore.
// When the user clicks the marker, an info window opens.

var roadMarkers = [];
var fireMarkers = [];
var dengueMarkers = [];
var infoWindow;
var map;
var weatherLayer;
var heatMap;
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

function addDengueMarker(location, radius, numOfPeople) {
    var stroke;
    var fill;
    
    if (status == 'Alert') {
        //red
        fill = "red";
    } else {
        //yellow
        fill = "yellow";
    }
    
    var dengueMarker = new google.maps.Circle({
        center: location,
        radius: radius,
        strokeOpacity:  0.8,
        strokeWeight:   2,
        fillColor:  fill,
        fillOpacity:    0.4,
        map: map
    });
    
    dengueMarkers.push(dengueMarker);
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


function addDengueMarkerListener(location, radius, numOfPeople) {
    google.maps.event.addListener(dengueMarkers[i], 'click', function() { 
        if (infoWindow) {
            infoWindow.close();
        }
        
        infoWindow = new google.maps.InfoWindow({
            content: '<div id="content"><h5 id="firstHeading" class="firstHeading">' + 'Dengue Hot Spot (' + radius + 'm radius)</h5><div id="bodyContent"><p>No. of people infected: ' + numOfPeople + '</p></div></div>',
            position: location
        });
        
        infoWindow.open(map, dengueMarkers[i]);
    });
}

//function to set all categories markers onto map EXCEPT weather and PSI
function setAllMap(map) {
    showRoadMarkers(map);
    showFireMarkers(map);
    showDengueMarkers(map);
}

//clears ALL markers INCLUDING weather and PSI
function clearMarkers() {
    setAllMap(null);
    clearWeather();
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
    heatMap.setMap(heatMap.getMap() ? null : map);
}


//shows ALL markers INCLUDING weather and PSI
function showMarkers() {
    setAllMap(map);
    showWeather();
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
    //ctaLayer.setMap(map);
    
    latlng = new google.maps.MVCArray();

    $.getJSON("/dengue.json", function( data ) {
      for(i = 0; i < data.length; i++){
        marker = [new google.maps.LatLng(data[i].latitude, data[i].longitude), data[i].radius, data[i].noOfPeopleInfected, data[i].severity];
        dengueHotSpots.push(marker);
        latlng.push({
          location: marker[0],
          weight: marker[1]});
        addDengueMarker(marker[0], marker[1]);
        addDengueMarkerListener(i, marker[1], marker[2]);
      }
      

    });

    $.getJSON("/incident.json", function( data ) {
      for(i = 0; i < data.length; i++){
        marker = [new google.maps.LatLng(data[i].latitude, data[i].longitude), data[i].incidentTitle, data[i].incidentDetails];
        roadIncidents.push(marker);
        addRoadMarker(marker[0], marker[1]);
        addRoadMarkerListener(i, marker[1], marker[2]);
      }
    });

    heatMap = new google.maps.visualization.HeatmapLayer({
      data: latlng,
      radius: 30,
      maxIntensity: 50
    });
    heatMap.setMap(map);

}

google.maps.event.addDomListener(window, 'load', initialize);