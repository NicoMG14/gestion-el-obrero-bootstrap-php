<?php
include ('conexion.php');

// alta de registros
if ($conexion=="si"){
    if (isset($_POST['Acliente'])){
        $cliente_nom=$_POST['cliente_nom'];
        $cliente_cuit=$_POST['cliente_cuit'];
        
        $campo="cliente_nom,cliente_cuit";
        $newDatos="'$cliente_nom','$cliente_cuit'";
        $query="INSERT INTO cliente ($campo) VALUES ($newDatos)";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/cliente.php?m=$mensaje");
    }
}

// modificacion de registros
if ($conexion=="si"){
    if (isset($_POST['Mcliente'])){
        $cliente_cod=$_POST['cliente_codE'];
        $cliente_nom=$_POST['cliente_nomE'];
        $cliente_cuit=$_POST['cliente_cuitE'];
        $newDatos="cliente_nom='$cliente_nom',cliente_cuit='$cliente_cuit'";
        $query="UPDATE cliente SET $newDatos WHERE cliente_cod=$cliente_cod";
        
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Edicion Satisfactoria";
        }
        mysqli_close($link);
        header("Location: ../modulos/cliente.php?m=$mensaje");
    }
}



?>