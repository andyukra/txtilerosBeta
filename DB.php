<?php

header('Access-Control-Allow-Origin: http://localhost:8080');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}


function dbConnect()
{
    /*$host = 'localhost';
        $user = 'id19524648_andy';
        $pass = 'Terminator87*';
        $db = 'id19524648_txtileros';*/
    /*$host = 'localhost';
        $user = 'c1741435_tx';
        $pass = 'Terminator87';
        $db = 'c1741435_tx';*/
    $host = '127.0.0.1';
    $user = 'andy';
    $pass = '';
    $db = 'txtileros';

    $conn = mysqli_connect($host, $user, $pass, $db);

    if (!$conn) die('Error en la base de datos' . PHP_EOL);

    return $conn;
}

function compressImg($source)
{
    $imagen = null;
    $imgInfo = getimagesize($source);
    $imgType = $imgInfo['mime'];

    switch ($imgType) {
        case 'image/jpeg':
            $imagen = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $imagen = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $imagen = imagecreatefromgif($source);
            break;
        default:
            $imagen = imagecreatefromjpeg($source);
    }

    return $imagen;
}
