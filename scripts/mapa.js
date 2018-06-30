function showMap(token) {
    alert(token);
    mapboxgl.accessToken = token;
    var mapa = new mapboxgl.Map({
        container: 'mapa',
        style: 'mapbox://styles/mapbox/streets-v10',
        zoom: 9
    });
    mapa.addControl(new mapboxgl.NavigationControl());
    mapa.addControl(new MapboxGeocoder({
        accessToken: mapboxgl.accessToken
    }));

    navigator.geolocation.getCurrentPosition(function(location) {
        mapa.flyTo({
            center: [
                location.coords.latitude,
                location.coords.longitude
            ]
        });
    });
}