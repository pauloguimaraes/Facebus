<?php

// $xh = $_GET['xh'];
// $yh = $_GET['yh'];
// $xb = $_GET['xb'];
// $yb = $_GET['yb'];

// $upd = $_GET['update'];

$URL = 'http://api.olhovivo.sptrans.com.br/v2.1';
$cookie = '/tmp/cookie.txt';

// unset($_SESSION['onibus']);
// session_start();
// if(isset($_SESSION['time_onibus']) && !empty($_SESSION['time_onibus']))
// {
//     if(time() - $_SESSION['time_onibus'] >= 180)
//     {
//         session_destroy();
//         session_start();
//     }
//     else
//     {
//         $_SESSION['time_onibus'] = time();
//     }
// }
// else
// {
//     session_destroy();
//     session_start();
//     $_SESSION['time_onibus'] = time();
// }

// // // if(isset($_SESSION['onibus']) && !empty($_SESSION['onibus'])) 
// // // {
    // echo 'n buscou';
    // $vetor = [];
    // // // echo json_encode($_SESSION['onibus']);
    // $dec = json_decode($_SESSION['onibus']);
    // // echo $xh;
    // foreach($dec as $item)
    // {
    //     foreach($item->vs as $temp) 
    //     {
    //         $y = json_encode($temp->py);
    //         $x = json_encode($temp->px);

    //         if($x >= $xh && $x <= $xb)
    //         {
    //             if($y <= $yh && $y >= $yb) {
    //                 $vetor[] = $item;
    //                 // echo json_encode($item);
    //             }
    //         }
    //     }
    // }

    // echo json_encode($vetor);
// // // }
// // // else
// // // {
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


    $_SESSION['onibus'] = $resultado;
    echo $_SESSION['onibus'];

    // $vetor = [];
    // $dec = json_decode($_SESSION['onibus']);
    // // echo $xh;
    // foreach($dec as $item)
    // {
    //     foreach($item->vs as $temp) 
    //     {
    //         $y = json_encode($temp->py);
    //         $x = json_encode($temp->px);

    //         if($x >= $xh && $x <= $xb)
    //         {
    //             if($y <= $yh && $y >= $yb) {
    //                 $vetor[] = $item;
    //                 // echo json_encode($item);
    //             }
    //         }
    //     }
    // }

    // echo json_encode($vetor);
// // // }


?>