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
 ** Interagindo com o WebService da SpTrans - Ônibus
 **/



 // Variáveis
$URL = 'http://api.olhovivo.sptrans.com.br/v2.1';
$cookie = '/tmp/cookie.txt';



// Iniciando a sessão
session_start();



// Se a sessão não está configurada
if (!isset($_SESSION['tempo_de_sessao']))
{
    // Configura
    $_SESSION['tempo_de_sessao'] = time();
}
// Senão, se a sessão já passou de 5 minutos
else if (time() - $_SESSION['tempo_de_sessao'] > 300)
{
    // Reconfigura as sessões
    session_regenerate_id(true);
    unset($_SESSION['onibus']);
    $_SESSION['tempo_de_sessao'] = time();
}



// Se o JSON está guardado em sessão
if(isset($_SESSION['onibus']) && !empty($_SESSION['onibus']) && !isset($_GET['update'])) 
{
    echo $_SESSION['onibus'];
}
// Se não está
else
{
    // Abre o CURL
    $ch = curl_init();
    // Configura
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $URL . '/Posicao');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

    // Executa
    $resultado = curl_exec($ch);
    // Fecha
    curl_close($ch);

    // Decodifica recuperando o 'l'
    $resultado = json_decode($resultado)->l;
    // Codifica
    $resultado = json_encode($resultado);

    // Salva em sessão
    $_SESSION['onibus'] = $resultado;
    echo $_SESSION['onibus'];

}

?>