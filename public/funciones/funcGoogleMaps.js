let map	= null;
let marker = null;
let markers = [];
let geocoder = null;
let infoWindow = null;

function initMap(lat=-12.046367,long=-77.042853,zoom=13,elementId="map",options=[]){
    map = new google.maps.Map(document.getElementById(elementId), {
        center: {lat: lat, lng: long},
        zoom: zoom,
        mapTypeId: 'roadmap',
        disableDefaultUI : true,
        zoomControl : true,
    });
    return map;
}

function changeMapOptions(lat,lng,zoom,options=[]){
    map.setCenter({lat: lat, lng: lng});
    map.setZoom(zoom);
}

function initInputAutocomplete(elementId="address-map",pushMap = true){
    let input = document.getElementById(elementId);

    if(pushMap){
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    }
    return new google.maps.places.Autocomplete(
        (input),
        {
            types: [],//'geocode'
            componentRestrictions: {'country': 'pe'}
        });
}


function addMarker(title,lat,lng,icon="",options={'draggable':false},mapParam=""){

    let mapToAdd = mapParam  === "" ? map : mapParam;

    // console.log('addmarker:',options);
    if(icon == ""){
        icon = {
            url: `${urlPagina}/images/geocode-71.png`,
            size: new google.maps.Size(150, 150),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        };
    }
    marker = new google.maps.Marker({
        map: mapToAdd,
        icon: icon,
        draggable: options['draggable'],
        title: title,
        position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    });
    markers.push(marker);
    return marker;
}


function addDefaultMarker(title,lat,lng,icon="",options=[]){
    marker = new google.maps.Marker({
        map: map,
        icon: icon,
        title: title,
        position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    });
    markers.push(marker);
    return marker;
}

// Borra el marcador del mapa
function clearMarker(marker){
    if(marker !=  null){
        marker.setMap(null);
    }
}

// Borra el marcador del mapa y de la variable global
function deleteMarker(markerParam){
    clearMarker(markerParam);
    marker = null;
}


// Borra todos los marcadores del mapa
function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
        clearMarker(markers[i]);
    }
}

// Borra todos los marcadores del mapa y de la variable global
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

// Agrega los marcadores de la variable global al mapa
function addMarkers() {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function addAddress() {
    // Get the place details from the autocomplete object.
    var place = this.getPlace();

    if(place.geometry.location.lat == null){
        fg.modalMessage("Puede mover el marcador para precisar la dirección.","danger");
        return;
    }
    //borra los marcadores del mapa
    clearMarkers();
    let title = place.name;
    let lat =  place.geometry.location.lat();
    let lng = place.geometry.location.lng();
    let marker = addMarker(title,lat,lng,'',{'draggable':true});

    addDragMarker(marker);

    changeMapOptions(lat,lng,17);

    setMapDataToForm(lat,lng);

    fg.modalMessage("Puede mover el marcador para precisar la ubicación.","success");
}

// realiza una accion cuando se mueve el marcador
function addDragMarker(marker){
    google.maps.event.addListener(marker, 'dragend', function (event) {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    // console.log(results[0].formatted_address);
                    document.getElementById('address-map').value = results[0].formatted_address;
                    setMapDataToForm(marker.getPosition().lat(),marker.getPosition().lng())
                }
            }else{
                fg.modalMessage("No se pudo obtener la dirección, mueva el marcador o realice una busqueda en el campo de texto.","warning");
            }
        });
    });
}

/**
 * Pone los datos necesarios en el formulario para el registro
 *
 * return void
 */
function setMapDataToForm(lat,lng){
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}


function setInputPosition() {
    // Get the place details from the autocomplete object.
    var place = this.getPlace();

    if(place.geometry.location.lat == null){
        fg.modalMessage("La dirección escrita no es válida.","danger");
        return;
    }

    let title = place.name;
    let lat =  place.geometry.location.lat();
    let lng = place.geometry.location.lng();

    $('.input-latitude').val(lat);
    $('.input-longitude').val(lng);

}


function addMarkerBusiness(business){

    let starsHtml = getStarsHtml(business.score_average,business.total_reviews)

    let contentInfoWindow =`
    <div class="card card-info-window">
        <div class="view overlay">
            <img class="card-img-top" src="${business.logo_url_medium}" alt="${business.name}">
            <a href="${business.url_page}" title="Ir a la pagina del negocio">
                <div class="mask rgba-white-slight"></div>
            </a>
        </div>
        <div class="card-body p-1">
            <h4 class="card-title mb-1">
                <a href="${business.url_page}" class="font-weight-bold h5" title="Ir a la pagina del negocio">
                    ${business.name}
                </a>
            </h4>
            ${starsHtml}
            <p class="mb-0">
                <i class="fas fa-map-marker-alt mr-2"></i>${business.address}
            </p>
        </div>
    </div>`;

    // console.log(contentInfoWindow);


    var infoWindow = new google.maps.InfoWindow({
        content: contentInfoWindow
    });

    let marker = new google.maps.Marker({
        map: map,
        title: business.name,
        position: {lat: parseFloat(business.latitude), lng: parseFloat(business.longitude)},
    });
    marker.open = false;

    marker.addListener('click', function(e) {
        console.log("infoWindow:",infoWindow);
        console.log("marker:",marker);
        // e.open = true;
        // infoWindow.open(map, marker);
        console.log('marker click')
        if(marker.open){
            marker.open = false;
            infoWindow.close();
        }else{
            marker.open = true;
            infoWindow.open(map,marker);
        }
        google.maps.event.addListener(map, 'click', function() {
            infoWindow.close();
            marker.open = false;
        });
    });

    markers.push(marker);
    return marker;
}


/*
* Obtiene el html de las estrellas
*
* @param numeric scoreAverage
* @param numeric totalReviews
* @param string textTotalReviews
* @return string
*/
function getStarsHtml(scoreAverage,totalReviews,textTotalReviews=""){
    // console.log('getStartsHtml');

    let startsHtml = `<ul class="list-unstyled list-inline rating mb-2">`;

    for(let i=1;i<=5 ;i++){
        let iconClass = "";

        if(parseFloat(scoreAverage) >= parseFloat(i)){
            iconClass = 'fas fa-star';
        }else if(parseFloat(this.scoreAverage) >= parseFloat(i)-0.5 ){
            iconClass = 'fas fa-star-half-alt';
        }else{
            iconClass = 'far fa-star';
        }

        startsHtml += `<li class="list-inline-item mr-1">
                    <i class="${iconClass} amber-text"></i>
                </li>`;
    }

    if(textTotalReviews !== ''){
        textTotalReviews = " "+textTotalReviews;
    }
    return startsHtml += `<li class="list-inline-item">
                    <span class="text-muted">
                        ${parseFloat(scoreAverage).toFixed(2)} (${totalReviews}${textTotalReviews})
                    </span>
                </li>
            </ul>`;
}


function getCurrentPosition(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                console.log(pos);

                // infoWindow.setPosition(pos);
                // infoWindow.setContent("Location found.");
                // infoWindow.open(map);
                // map.setCenter(pos);

            },
            () => {
                // handleLocationError(true, infoWindow, map.getCenter());
                fg.modalMessage('No se pudo obtener la ubicación.','error');
            }
        );
    } else {
        // Browser doesn't support Geolocation
        // handleLocationError(false, infoWindow, map.getCenter());
        fg.modalMessage('No se pudo obtener la ubicación.','error');
    }
}


