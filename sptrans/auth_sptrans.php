<?php

/**
 ** Exercício de programação - Soluções Web baseadas em Software Livre
 ** Professor Doutor Osvaldo Gogliano Sobrinho
 **
 ** Autores:
 ** Lucas Borelli Amaral - 9360951
 ** Mateus Angelo Castro - 9377532
 ** Paulo Henrique Freitas Guimarães - 9390361
 **
 ** Interagindo com o WebService da SpTrans - Autenticando
 **/



// Variáveis 
$chave_api = file_get_contents('http://ec2-52-15-33-123.us-east-2.compute.amazonaws.com/Facebus/auth/sptrans.txt');
$URL = 'http://api.olhovivo.sptrans.com.br/v2.1';
$cookie = '/tmp/cookie.txt';



// Abre o CURL
$ch = curl_init();
// Configura
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $URL . '/Login/Autenticar?token=' . $chave_api);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

// Executa
curl_exec($ch);
// Fecha
curl_close($ch);

?>