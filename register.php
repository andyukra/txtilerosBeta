<?php
    include 'DB.php';

    if(isset($_POST) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['clave'])) {
        
        $conn = dbConnect();
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $clave = $_POST['clave'];
        $query = "INSERT INTO usuarios (`nombre`, `apellido`, `clave`) VALUES ('$nombre', '$apellido', '$clave')";

        //CHECK IF USER ALREADY EXISTS
        $res = mysqli_query($conn, "SELECT `nombre` FROM usuarios WHERE `nombre` = '$nombre'");
        $exists = mysqli_num_rows($res);
        if($exists) die('El nombre de usuario ya esta en uso');
    
        $result = mysqli_query($conn, $query);

        if($result == 1) {
            header('Location:index.html');
        } else {
            die('Problema en el registro, intente nuevamente mas tarde');
        }

    }

    
?>