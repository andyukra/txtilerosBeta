<?php 
    include 'DB.php';
    session_start();

    //H A N D L E R S
    function imgProcess($img, $filter) {
        if($img['size'] > 15000000) die('La imagen es muy pesada, solo se permite 15MB');
        if(!in_array($img['type'], $filter)) die('Archivo de imagen no compatible');
        $filename = explode(' ', microtime())[1].'.'.pathinfo($img['name'], PATHINFO_EXTENSION);

        $imgCompressed = compressImg($img['tmp_name']);
        imagejpeg($imgCompressed, realpath('./files/imgs').'/'.$filename, 75);

        return 'files/imgs/'.$filename;
    }

    function docProcess($doc, $filter) {
        if($doc['size'] > 70000000) die('La imagen es muy pesada, solo se permite 70MB');
        if(!in_array($doc['type'], $filter)) die('Archivo de documento no compatible');
        $filename = explode(' ', microtime())[1].'.'.pathinfo($doc['name'], PATHINFO_EXTENSION);
        $newName = str_replace(' ', '_', $doc['name']);
        move_uploaded_file($doc['tmp_name'], realpath('./files/docs').'/'.$newName);
        return 'files/docs/'.$newName;
    }

    if(isset($_POST)) {

        $conn = dbConnect();
        $me = $_SESSION['user'];
        if(!$me) die('No esta autorizado a publicar');
        $filterImgs = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
        $filterDocs = array('application/msword', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'plain/text');
        $text = $_POST['text'] ?? '';
        $category = $_POST['category'];
        $image = ($_FILES['image']['size'] > 0) ? $_FILES['image'] : '';
        $document = ($_FILES['document']['size'] > 0) ? $_FILES['document'] : '';
        $typeFile = ($image) ? 'imagen' : (($document) ? 'documento' : '');
        $file = '';
        $query = "INSERT INTO publicaciones (`autor`, `texto`, `categoria`) VALUES ('$me', '$text', '$category')";
        if($image && $document) die('Solo se puede subir imagen o documento, no ambos.');
        
        //IMAGE OR DOCUMENT POST
        switch($typeFile) {
            case 'imagen':
                $file = imgProcess($image, $filterImgs, $conn);
                $query = "INSERT INTO publicaciones (`autor`, `texto`, `categoria`, `imagen`) VALUES ('$me', '$text', '$category', '$file')";
                break;
            case 'documento':
                $file = docProcess($document, $filterDocs, $conn);
                $query = "INSERT INTO publicaciones (`autor`, `texto`, `categoria`, `documento`) VALUES ('$me', '$text', '$category', '$file')";
                break;
        }

        //S A V E  T O  D A T A B A S E
        $res = mysqli_query($conn, $query);
        if($res != 1) die('Hubo un problema al guardar la publicacion, intente nuevamente mas tarde.');

        header('Location:home.php');

    }

?>