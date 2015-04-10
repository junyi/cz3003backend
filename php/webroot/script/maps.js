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
    var dengueMarker = new google.maps.Circle({
        center: location,
        radius: radius,
        strokeColor:    "#114455",
        strokeOpacity:  0.8,
        strokeWeight:   2,
        fillColor:  "#14ad80",
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
            content: '<div id="content"><h4 id="firstHeading" class="firstHeading">' + title + '</h4><div id="bodyContent"><p>' + content + '</p></div></div>'
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
            content: '<div id="content"><h4 id="firstHeading" class="firstHeading">' + title + '</h4><div id="bodyContent"><p>' + content + '</p></div></div>'
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
            content: '<div id="content"><h4 id="firstHeading" class="firstHeading">' + 'Dengue Hot Spot (' + radius + 'm radius)</h4><div id="bodyContent"><p>No. of people infected: ' + numOfPeople + '</p></div></div>',
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
    //simulate PHP to extract data of road incidents
    var roadIncidents = [];
    // roadIncidents.push([new google.maps.LatLng(1.337831, 103.832363), 'Road Accident at YYYYY', 'A road accident has occurred at YYYYY']);
    // roadIncidents.push([new google.maps.LatLng(1.389641, 103.682941), 'Road Accident at ZZZZZ', 'A road accident has occurred at YYYYY']);
    // roadIncidents.push([new google.maps.LatLng(1.359641, 103.952941), 'Road Accident at XXXXX', 'A road accident has occurred at YYYYY']);
    
    // //Loop to generate all markers
    // for(i=0; i<3; i++) {
    //     //add road marker
    //     addRoadMarker(roadIncidents[i][0], roadIncidents[i][1]);
    //     //add road marker events listener
    //     addRoadMarkerListener(i, roadIncidents[i][1], roadIncidents[i][2]);
    // }
    
    //simulate PHP to extract data of road incidents
    var fireIncidents = [];
    fireIncidents.push([new google.maps.LatLng(1.357831, 103.932363), 'Fire Accident at YYYYY', 'A fire accident has occurred at YYYYY']);
    fireIncidents.push([new google.maps.LatLng(1.349641, 103.682941), 'Fire Accident at ZZZZZ', 'A fire accident has occurred at YYYYY']);
    fireIncidents.push([new google.maps.LatLng(1.349641, 103.752941), 'Fire Accident at XXXXX', 'A fire accident has occurred at YYYYY']);
    
    //Loop to generate all markers
    for(i=0; i<3; i++) {
        //add fire marker
        addFireMarker(fireIncidents[i][0], fireIncidents[i][1]);
        //add fire marker events listener
        addFireMarkerListener(i, fireIncidents[i][1], fireIncidents[i][2]);
    }
    
    var dengueHotSpots = [];
    // dengueHotSpots.push([new google.maps.LatLng(1.327831, 103.932363), 800, 13]);
    // dengueHotSpots.push([new google.maps.LatLng(1.387831, 103.832363), 500, 8]);
    // dengueHotSpots.push([new google.maps.LatLng(1.397831, 103.752363), 1000, 20]);
    
    // for(i=0; i<3; i++) {
    //     //add dengue marker
    //     addDengueMarker(dengueHotSpots[i][0], dengueHotSpots[i][1], dengueHotSpots[i][2]);
    //     //add fire marker events listener
    //     addDengueMarkerListener(dengueHotSpots[i][0], dengueHotSpots[i][1], dengueHotSpots[i][2]);
    // }
    
    ctaLayer = new google.maps.KmlLayer({
      url: 'https://dl.dropboxusercontent.com/u/18619627/timecrisis/map.kmz',
    });
    //ctaLayer.setMap(map);
    
    latlng = new google.maps.MVCArray();

    $.getJSON("/dengue.json", function( data ) {
      for(i = 0; i < data.length; i++){
        marker = [new google.maps.LatLng(data[i].latitude, data[i].longitude), data[i].radius, data[i].noOfPeopleInfected];
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