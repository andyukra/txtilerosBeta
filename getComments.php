<?php 

    include 'DB.php';

    if(isset($_GET)) {

        $conn = dbConnect();
        $idPub = $_GET['idPub'];
        $data = [];

        $query = "SELECT comentarios.*, usuarios.foto FROM `comentarios` INNER JOIN usuarios ON comentarios.autor = usuarios.nombre WHERE comentarios.idPub = '$idPub' ORDER BY comentarios.fecha DESC";

        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) == 0) die('NADA');

        while($comment = mysqli_fetch_assoc($res)) {
            array_push($data, $comment);
        }

        echo json_encode($data);

    }

?>