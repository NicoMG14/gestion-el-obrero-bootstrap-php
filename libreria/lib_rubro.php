<?php
include ('conexion.php');

// alta de registros
if ($conexion=="si"){
    if (isset($_POST['Arubro'])){
        $rubro_desc=$_POST['rubro_desc'];

        
        $campo="rubro_desc";
        $newDatos="'$rubro_desc'";
        $query="INSERT INTO rubro ($campo) VALUES ($newDatos)";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/rubro.php?m=$mensaje");
    }
}

// modificacion de registros
if ($conexion=="si"){
    if (isset($_POST['Mrubro'])){
        $rubro_cod=$_POST['rubro_codE'];
        $rubro_desc=$_POST['rubro_descE'];
        $newDatos="rubro_desc='$rubro_desc'";
        $query="UPDATE rubro SET $newDatos WHERE rubro_cod=$rubro_cod";
        
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Edicion Satisfactoria";
        }
        mysqli_close($link);
        header("Location: ../modulos/rubro.php?m=$mensaje");
    }
}

// baja de registros
if ($conexion=="si"){
if (isset($_POST['Brubro'])){
        $rubro_cod=$_POST['rubro_codB'];
        $query="DELETE FROM rubro WHERE rubro_cod=$rubro_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/rubro.php?m=$mensaje");
         } 
}
}

?>