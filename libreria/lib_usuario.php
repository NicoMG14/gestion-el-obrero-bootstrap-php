<?php
session_start();
if (!isset($_SESSION['usuario_dni'])) {
 header("Location:login.php");
 session_destroy();
  exit();
}

include ('conexion.php');




// alta de registros
if ($conexion=="si"){
    if (isset($_POST['Ausuario'])){
        $usuario_nom=$_POST['usuario_nom'];
        $usuario_dni=$_POST['usuario_dni'];
        $usuario_clave=$_POST['usuario_clave'];
        $usuario_telef=$_POST['usuario_telef'];
        $usuario_cbu=$_POST['usuario_cbu'];

        $campo="usuario_nom,usuario_dni,usuario_clave,usuario_telef,usuario_cbu";
        $newDatos="'$usuario_nom',$usuario_dni,'$usuario_clave',$usuario_telef,'$usuario_cbu'";
        $query="INSERT INTO usuario ($campo) VALUES ($newDatos)";

        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/usuario.php?m=$mensaje");
    }
}

// modificacion de registros
if ($conexion=="si"){
    if (isset($_POST['Musuario'])){
        $usuario_cod=$_POST['usuario_codE'];
        $usuario_nom=$_POST['usuario_nomE'];
        $usuario_dni=$_POST['usuario_dniE'];
        $usuario_telef=$_POST['usuario_telefE'];
        $usuario_cbu=$_POST['usuario_cbuE'];

        if ($_SESSION['usuario_dni']==$usuario_dni){
            $newDatos="usuario_nom='$usuario_nom',usuario_telef=$usuario_telef,usuario_cbu='$usuario_cbu'";
            $query="UPDATE usuario SET $newDatos WHERE usuario_cod=$usuario_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            mysqli_close($link);
            header("Location: ../modulos/usuario.php?m=$mensaje");
        }else{
            $mensaje="no";
            mysqli_close($link);
            header("Location: ../modulos/usuario.php?m=$mensaje");
        }


        
    }
}

// baja de registros
if ($conexion=="si"){
if (isset($_POST['Busuario'])){
        $usuario_codB=$_POST['usuario_codB'];
        if ($_SESSION['usuario_dni']=="12345678"){
            $query="DELETE FROM usuario WHERE usuario_cod=$usuario_codB";
             if (!($result = mysqli_query($link,$query))){
                $mensaje="no se pudo eliminar el registro";
                mysqli_close($link);
                header("Location: ../modulos/usuario.php?m=$mensaje");
             }else{
                $mensaje="el registro se elimino correctamente";
                mysqli_close($link);
                header("Location: ../modulos/usuario.php?m=$mensaje");
             } 
        }else{
            $mensaje="no";
            mysqli_close($link);
            header("Location: ../modulos/usuario.php?m=$mensaje");
        }  
        
}
}


?>