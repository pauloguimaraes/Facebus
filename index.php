<?php
    require_once './auth/auth_sptrans.php'
?>

<html>
    <head>
        <title>BuStop</title>

        <!-- Referências do MapBox -->
        <script src='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />

        <!-- Referências do MapBox - Geocoder -->
        <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.min.js'></script>
        <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.css' type='text/css' />

        <!-- JavaScript e CSS customizados -->
        <link rel='stylesheet' href='./styles/index.css' type='text/css' />
        <script src='scripts/jquery-3.3.1.js'></script>
        <script src='scripts/mapa.js'></script>
    </head>
    <body>
        <div id='geocoder' class='geocoder searchBox'></div>
        <div id='opcoes' style='width: 90%; height: 50px; margin-left: 5%; margin-top: 20px'>
            <input type='checkbox' id='paradas' value='paradas' /><label for='paradas'>Paradas</label>
            <input type='checkbox' id='onibus' value='onibus' /><label for='onibus'>Ônibus</label>
        </div>
        <div id='mapa' class='mapa'></div>
        <?php
            $token_map = file_get_contents('/var/www/html/bustop/auth/mapbox.txt');
            echo "<script>showMap('" . $token_map ."');</script>";
        ?>
        <div id='ha'></div>
    </body>
</html>