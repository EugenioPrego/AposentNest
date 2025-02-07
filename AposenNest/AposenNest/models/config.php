<?php

    $host = "localhost";
    $username = "root";
    $dbname = "aposennest";
    $password = "";

    try {
        
        $conn = new PDO("mysql: host=" .$host. "; dbname=" .$dbname,$username,$password);

        if($conn){

            // echo "Base de dados configurado com Sucesso!";

        }
    } catch (PDOException $e) {
        
            echo "Erro: " .$e->getMessage();

    }

?>