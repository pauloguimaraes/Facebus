function showMap() {
    mapboxgl.accessToken = '<SEU_TOKEN>';
    var mapa = new mapboxgl.Map({
        container: 'mapa',
        style: 'mapbox://styles/mapbox/streets-v10',
        zoom: 9
    });
    mapa.addControl(new mapboxgl.NavigationControl());

    navigator.geolocation.getCurrentPosition(function(location) {
        mapa.flyTo({
            center: [
                location.coords.latitude,
                location.coords.longitude
            ]
        });
    });
}