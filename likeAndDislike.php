<?php

    include 'DB.php';
    session_start();
    if(!$_SESSION['user']) die('NO');

    if(isset($_POST)) {

        $type = $_POST['type'];
        $idPub = $_POST['idPub'];
        $conn = dbConnect();
        $query = null;

        if($type == 'like') $query = "UPDATE `publicaciones` SET `likes` =  `likes` + 1 WHERE `id` = '$idPub'";
        if($type == 'dislike') $query = "UPDATE `publicaciones` SET `dislikes` =  `dislikes` + 1 WHERE `id` = '$idPub'";

        $res = mysqli_query($conn, $query);

        if($res) echo 'OK';

    }

?>