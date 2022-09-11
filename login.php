<?php 

    session_start();

    include 'DB.php';
    if(isset($_POST) && isset($_POST['nombre']) && isset($_POST['clave'])) {

        $conn = dbConnect();
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $query = "SELECT `nombre`, `clave` FROM `usuarios` WHERE `nombre` = '$nombre'";
        $result = mysqli_query($conn, $query);
        $numRows = mysqli_num_rows($result);

        if($numRows == 0) die('El usuario no existe');

        $res = mysqli_fetch_row($result);

        if($clave != $res[1]) die('La clave es incorrecta');

        //CREATE SESSION
        $_SESSION['user'] = $res[0];

        header('Location:home.php');

        //echo 'Bienvenido '.$res[0];


    }


?>