/**
 * Exercício de programação - Soluções Web baseadas em Software Livre
 * Professor Doutor
 * 
 * Autores:
 * Lucas
 * Matheus
 * Paulo
 * 
 * Funções JavaScript relacionadas ao mapa
 */


 
var onibus = []

/**
 * Apresenta o mapa do MapBox, adicionando navegação e Geocoder
 * 
 * @param {*} token - Token do MapBox
 */
function showMap(token) {
    mapboxgl.accessToken = token;

    // Instanciando o mapa
    var mapa = new mapboxgl.Map({
        container: 'mapa',
        style: 'mapbox://styles/mapbox/streets-v10',
        zoom: 15
    });

    // Adicionando controles de navegação
    mapa.addControl(new mapboxgl.NavigationControl());

    // Adicionando a barra de pesquisa
    var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken
    });
    document.getElementById('geocoder').appendChild(geocoder.onAdd(mapa));

    // Centralizando na localização atual
    navigator.geolocation.getCurrentPosition(function(location) {
        flyToCurrentLocation(mapa, location);
    }, 
    function() {
        flyToSeCathedral(mapa);
    });

    document.getElementById('onibus').addEventListener('change', function(element) {
        toggleOnibus(element, mapa);
    });
}



/**
 * Centraliza o mapa em determinada localização
 * 
 * @param {*} mapa Mapa onde a localização vai ser centralizada
 * @param {*} location Posição a ser centralizada
 */
function flyToCurrentLocation(mapa, location) {
    mapa.flyTo({
        center: [
            location.coords.longitude,
            location.coords.latitude
        ]
    });
}



/**
 * Centraliza o mapa na Catedral da Sé
 * 
 * @param {*} mapa Mapa que será centralizado
 */
function flyToSeCathedral(mapa) {
    mapa.flyTo({
        center: [
            -46.6343,
            -23.5513
        ]
    });
}



function toggleParadas(element) {
    element.checked = !element.checked
}



function getCurrentBusPositions(mapa){
    var dict = [];
    $.ajax({
        type: 'GET',
        url: 'http://localhost/bustop/sptrans/getOnibus.php',
        dataType: 'json',
        success: function(html) {
            $.each(html, function(key, value) {
                var pos = value.vs;
                $.each(pos, function(k, v) {
                    dict[value.c + ',' + pos[k].p + ','  + value.lt0 + ' - ' + value.lt1] = [pos[k].px, pos[k].py]
                });
            });
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        complete: function(data) {
            for(const[key, value] of Object.entries(dict)) {
                try {
                    var splitted = key.split(',');
                    var numero_linha = splitted[0];
                    var descricao_linha = splitted[2];

                    var marker = new mapboxgl.Marker()
                        .setLngLat(dict[key])
                        .setPopup(new mapboxgl.Popup({ offset: 25})
                        .setHTML('<h3>' + numero_linha + '</h3><p>' + descricao_linha + '</p>'))
                        .addTo(mapa);
                    onibus.push(marker);
                }
                catch(err) {
                    alert(err);
                }
            }
        }
    });
}



function removeAllOnibus(onibus) {
    for(var i = 0; i < onibus.length; i++)
    {
        onibus[i].remove();
    }
    
    while(onibus.length > 0) 
    {
        onibus.pop();
    }
}



function toggleOnibus(element, mapa) {
    element.checked = !element.checked

    if(onibus.length <= 0)
    {
        getCurrentBusPositions(mapa);
    }
    else
    {
        removeAllOnibus(onibus);
    }
}