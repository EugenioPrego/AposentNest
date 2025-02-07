<?php

    session_start();
    unset($_SESSION["idUsuario"]);
    header("location: ../../views/index.php");
    exit;

?>