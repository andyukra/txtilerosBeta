<?php 

    include 'DB.php';

    if(isset($_GET)) {

        $conn = dbConnect();
        $category = $_GET['category'];
        $page = $_GET['page'];
        $limitOffset =  ($page * 10 + $page);
        $limitCount =  $limitOffset + 10;
        $query = "SELECT publicaciones.*, usuarios.foto FROM publicaciones INNER JOIN usuarios ON publicaciones.autor = usuarios.nombre WHERE publicaciones.categoria = '$category' ORDER BY publicaciones.fecha DESC LIMIT $limitOffset, $limitCount";
        $data = [];

        $res = mysqli_query($conn, $query);

        while($parse = mysqli_fetch_assoc($res)) {
            array_push($data, $parse);
        }

        echo json_encode($data);
        
    
    }//E N D

?>