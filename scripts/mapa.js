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
        mapa.flyTo({
            center: [
                location.coords.longitude,
                location.coords.latitude
            ]
        });
    });
}