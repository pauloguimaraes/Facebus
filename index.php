<?php
    require_once './auth/auth_sptrans.php'
?>

<html>
    <head>
        <title>BuStop</title>
        <script src='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />

        <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.min.js'></script>
        <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.css' type='text/css' />

        <script src='scripts/mapa.js'></script>
    </head>
    <body>
        <div id='mapa' style='width: 75%; height: 75%;'></div>
        <script>
            showMap('<SEU_TOKEN>');
        </script>
    </body>
</html>