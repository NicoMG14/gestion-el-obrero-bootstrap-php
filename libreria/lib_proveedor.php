<?php
include ('conexion.php');

// alta de registros
if ($conexion=="si"){
    if (isset($_POST['Aproveedor'])){
        $proveedor_nom=$_POST['proveedor_nom'];
        $proveedor_email=$_POST['proveedor_email'];
        $proveedor_telef=$_POST['proveedor_telef'];
        $proveedor_cbu=$_POST['proveedor_cbu'];
        
        $campo="proveedor_nom,proveedor_email,proveedor_telef,proveedor_cbu";
        $newDatos="'$proveedor_nom','$proveedor_email',$proveedor_telef,'$proveedor_cbu'";
        $query="INSERT INTO proveedor ($campo) VALUES ($newDatos)";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/proveedor.php?m=$mensaje");
    }
}

// modificacion de registros
if ($conexion=="si"){
    if (isset($_POST['Mproveedor'])){
        $proveedor_cod=$_POST['proveedor_codE'];
        $proveedor_nom=$_POST['proveedor_nomE'];
        $proveedor_email=$_POST['proveedor_emailE'];
        $proveedor_telef=$_POST['proveedor_telefE'];
        $proveedor_cbu=$_POST['proveedor_cbuE'];

        $newDatos="proveedor_nom='$proveedor_nom',proveedor_email='$proveedor_email',proveedor_telef=$proveedor_telef,proveedor_cbu='$proveedor_cbu'";
        $query="UPDATE proveedor SET $newDatos WHERE proveedor_cod=$proveedor_cod";
        
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Edicion Satisfactoria";
        }
        mysqli_close($link);
        header("Location: ../modulos/proveedor.php?m=$mensaje");
    }
}

// baja de registros
if ($conexion=="si"){
if (isset($_POST['Bproveedor'])){
        $proveedor_cod=$_POST['proveedor_codB'];
        $query="DELETE FROM proveedor WHERE proveedor_cod=$proveedor_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/proveedor.php?m=$mensaje");
         } 
}
}



?>