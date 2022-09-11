<?php 

    include 'DB.php';
    session_start();
    if(!$_SESSION['user']) header('Location:index.html');

    if(isset($_POST)) {

        $conn = dbConnect();
        $text = $_POST['text'];
        $me = $_SESSION['user'];
        $idPub = $_POST['idPub'];

        if(!$text) return;

        $query = "INSERT INTO `comentarios` (`autor`, `texto`, `idPub`) VALUES ('$me', '$text', '$idPub')";

        $res = mysqli_query($conn, $query);

        if(!$res) return;

        echo 'OK';

    }

?>