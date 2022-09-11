<?php 
    include 'DB.php';

    session_start();
    if(!$_SESSION['user']) header('Location:index.html');

    if(isset($_GET['id'])){

        $conn = dbConnect();
        $id = $_GET['id'];
        $me = $_SESSION['user'];

        $query = "SELECT * from `publicaciones` WHERE id = '$id' AND autor = '$me'";

        $res = mysqli_query($conn, $query);

        $pub = mysqli_fetch_assoc($res);

        if(!$pub) die('no se encontro la publicacion');

        if($pub['imagen']) unlink($pub['imagen']);
        if($pub['documento']) unlink($pub['documento']);

        $query = $query = "DELETE from `publicaciones` WHERE id = '$id' AND autor = '$me'";

        mysqli_query($conn, $query);

        echo 'OK';

    }

?>