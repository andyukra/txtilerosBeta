<?php 
    include 'DB.php';

    session_start();
    if(!$_SESSION['user']) die('No esta autorizado a realizar esta accion');

    //H A N D L E R S

    function imgProcess($img, $filter, $pathType) {
        if($img['size'] > 15000000) die('La imagen es muy pesada, solo se permite 15MB');
        if(!in_array($img['type'], $filter)) die('Archivo de imagen no compatible');
        $filename = $_SESSION['user'].'.'.pathinfo($img['name'], PATHINFO_EXTENSION);
        move_uploaded_file($img['tmp_name'], realpath('./files/imgs/'.$pathType).'/'.$filename);
        return 'files/imgs/'.$pathType.'/'.$filename;
    }

    if(isset($_POST)) {
        $me = $_SESSION['user'];
        $conn = dbConnect();
        $file = $_FILES['file'];
        $type = $_POST['type'] == 'avatar' ? 'foto' : 'portada';
        $pathType = $_POST['type'] == 'avatar' ? 'avatars' : 'portada';
        $filterImgs = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
        $filePath = ImgProcess($file, $filterImgs, $pathType);    
        $query = "UPDATE `usuarios` SET `$type` = '$filePath' WHERE `nombre` = '$me'";

        $res = mysqli_query($conn, $query);

        if(!$res) die('No se puedo subir la imagen a la base de datos, intente nuevamente mas tarde');
        echo 'OK';
    }

?>