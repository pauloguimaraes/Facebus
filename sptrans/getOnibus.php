<?php

$URL = 'http://api.olhovivo.sptrans.com.br/v2.1';
$cookie = '/tmp/cookie.txt';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $URL . '/Posicao');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

$resultado = curl_exec($ch);

curl_close($ch);

$resultado = json_decode($resultado)->l;
$resultado = json_encode($resultado);
echo $resultado;

?>