<?php

$URL = 'http://api.olhovivo.sptrans.com.br/v2.1';
$cookie = '/tmp/cookie.txt';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $URL . '/Corredor');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

$resultado = curl_exec($ch);
curl_close($ch);

$resultado = json_decode($resultado);
$vetor = [];
foreach($resultado as $item)
{
    $codigo_do_corredor = $item->cc;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $URL . '/Parada/BuscarParadasPorCorredor?codigoCorredor=' . $codigo_do_corredor);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

    $resposta = curl_exec($ch);
    $resposta = json_decode($resposta);

    foreach($resposta as $i)
    {
        $vetor[] = $i;
    }

    curl_close($ch);
}

$resultado = json_encode($vetor);
echo $resultado;

?>