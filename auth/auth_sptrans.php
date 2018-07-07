<?php
$chave_api = file_get_contents('https://http://ec2-52-15-33-123.us-east-2.compute.amazonaws.com/BuStop/auth/sptrans.txt');
$URL = 'http://api.olhovivo.sptrans.com.br/v2.1';
$cookie = '/tmp/cookie.txt';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $URL . '/Login/Autenticar?token=' . $chave_api);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

curl_exec($ch);
curl_close($ch);
?>