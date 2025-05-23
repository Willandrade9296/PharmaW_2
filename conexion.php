<?php

    try{ 
    $host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "v_clinica";
    $conexion = mysqli_connect($host,$user,$clave,$bd);
    if (mysqli_connect_errno()){
        echo "No se logró conectar a la base de datos";
        exit();
    }
    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");
    mysqli_set_charset($conexion,"utf8");
    }catch(Exception $e){

        echo "Error: ".$e->getMessage();
    }
?>
