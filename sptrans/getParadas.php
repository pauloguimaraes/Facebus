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
 ** Interagindo com o WebService da SpTrans - Paradas
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
// Senão, se a sessão já passou de 30 minutos
else if (time() - $_SESSION['tempo_de_sessao'] > 1800)
{
    // Reconfigura as sessões
    session_regenerate_id(true);
    unset($_SESSION['paradas']);
    $_SESSION['tempo_de_sessao'] = time();
}



// Se o JSON está guardado em sessão
if(isset($_SESSION['paradas']) && !empty($_SESSION['paradas']))
{
    echo $_SESSION['paradas'];
}
// Se não está
else
{
    /*
     * A estratégia será recuperar todos os corredores existentes
     * Para posteriormente recuperar suas paradas
     */

    // Abre o CURL
    $ch = curl_init();
    // Configura
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $URL . '/Corredor');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

    // Executa
    $resultado = curl_exec($ch);
    curl_close($ch);

    // Decodifica o resultado
    $resultado = json_decode($resultado);
    $vetor = [];

    // Percorre todos os corredores
    foreach($resultado as $item)
    {
        $codigo_do_corredor = $item->cc;

        // Busca todas as suas paradas
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL . '/Parada/BuscarParadasPorCorredor?codigoCorredor=' . $codigo_do_corredor);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

        $resposta = curl_exec($ch);
        $resposta = json_decode($resposta);

        // Adiciona todas as paradas para esse corredor no vetor resultado
        foreach($resposta as $i)
        {
            $vetor[] = $i;
        }

        curl_close($ch);
    }

    // Codifica o vetor resultado
    $resultado = json_encode($vetor);
    $_SESSION['paradas'] = $resultado;
    echo $_SESSION['paradas'];

}

?>