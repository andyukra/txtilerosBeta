<?php 

    function dbConnect() {
        /*$host = 'localhost';
        $user = 'id19524648_andy';
        $pass = 'Terminator87*';
        $db = 'id19524648_txtileros';*/
        /*$host = 'localhost';
        $user = 'c1741435_tx';
        $pass = 'se59baroDE';
        $db = 'c1741435_tx';*/
        $host = '127.0.0.1';
        $user = 'andy';
        $pass = '';
        $db = 'txtileros';

        $conn = mysqli_connect($host, $user, $pass, $db);

        if(!$conn) die('Error en la base de datos' . PHP_EOL);

        return $conn;
    }

?>