<?php 
    include 'DB.php';

    session_start();
    if(!$_SESSION['user']) die('No esta autorizado a realizar esta accion');

    //H A N D L E R S

    function imgProcess($img, $filter) {
        if($img['size'] > 15000000) die('La imagen es muy pesada, solo se permite 15MB');
        if(!in_array($img['type'], $filter)) die('Archivo de imagen no compatible');
        $filename = $_SESSION['user'].'.'.pathinfo($img['name'], PATHINFO_EXTENSION);
        move_uploaded_file($img['tmp_name'], realpath('./files/imgs/avatars').'/'.$filename);
        return 'files/imgs/avatars/'.$filename;
    }

    if(isset($_POST)) {
        $me = $_SESSION['user'];
        $conn = dbConnect();
        $file = $_FILES['file'];
        $filterImgs = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
        $filePath = ImgProcess($file, $filterImgs);    
        $query = "UPDATE `usuarios` SET `foto` = '$filePath' WHERE `nombre` = '$me'";

        $res = mysqli_query($conn, $query);

        if(!$res) die('No se puedo subir la imagen a la base de datos, intente nuevamente mas tarde');
        echo 'OK';
    }

?>