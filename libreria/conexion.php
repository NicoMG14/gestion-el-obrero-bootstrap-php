<?php
$host="localhost";
$user="root";
$clave="12345678";
$db="elobrero";

if (!($link = mysqli_connect($host,$user,$clave,$db))){
    $conexion="no";
}else{
    $conexion="si";
}
date_default_timezone_set('America/Argentina/Jujuy');
$fecha_actual=date("Y-m-d");
?>