<?php

include 'DB.php';

session_start();
if (!$_SESSION['user']) die('Usted no puede realizar esta accion');

if (isset($_GET)) {
    $conn = dbConnect();
    $me = $_SESSION['user'];
    $query = "SELECT `foto` FROM `usuarios` WHERE `nombre` = '$me'";

    $res = mysqli_query($conn, $query);

    if (!$res) die('No se pudo obtener los datos del usuario');

    return json_encode(mysqli_fetch_row($res));
}
