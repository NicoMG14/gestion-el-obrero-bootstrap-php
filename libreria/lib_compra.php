<?php
include ('conexion.php');
// alta de venta

if ($conexion=="si"){
    if (isset($_POST['Acompra'])){
        $query="INSERT INTO compra () VALUES ()";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        $compra_cod = mysqli_insert_id($link);
  
        mysqli_close($link);
        header("Location: ../modulos/detallecompra.php?m=$mensaje&compra=$compra_cod");
    }
}


// modificacion de alta de compra
if ($conexion=="si"){
    if (isset($_POST['MMcompra'])){
        $compra_cod=$_POST['compra_codM'];
        $compra_estado=$_POST['compra_estadoM'];
        $compra_total=$_POST['compra_totalM'];
        $compra_fecha=$_POST['compra_fechaM'];
        $proveedor_cod=$_POST['proveedor_codM'];

        if ($compra_total==NULL){
            $mensaje="ar";
            header("Location: ../modulos/detallecompra.php?compra=$compra_cod&m=$mensaje");
        }elseif($proveedor_cod==NULL){
            $mensaje="p";
            header("Location: ../modulos/detallecompra.php?compra=$compra_cod&m=$mensaje");
        }elseif ($compra_estado==NULL) {
            $mensaje="e";
            header("Location: ../modulos/detallecompra.php?compra=$compra_cod&m=$mensaje");
        }else{
            //actualiza precios de ambos campos.. precio actual es el precio que la BBDD guarda por cualquier razon
            $query="UPDATE producto SET precio_actual=producto_precio";
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            
            $query="UPDATE producto,detallecompra SET proveedor_cod=$proveedor_cod WHERE detallecompra.compra_cod=$compra_cod AND detallecompra.producto_cod=producto.producto_cod"; //actualiza el proveedor de los productos
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            

            $newDatos="compra_estado=$compra_estado,compra_total=$compra_total,compra_fecha='$compra_fecha',proveedor_cod=$proveedor_cod";

            $query="UPDATE compra SET $newDatos WHERE compra_cod=$compra_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }

            mysqli_close($link);
            header("Location: ../modulos/compra.php?m=$mensaje");
        }


       
    }
}



// modificacion de estado compra
if ($conexion=="si"){
    if (isset($_POST['Mcompra'])){
        $compra_cod=$_POST['compra_codM'];
        $compra_estado=$_POST['compra_estadoM'];
        $newDatos="compra_estado=$compra_estado";

       

        $query="UPDATE compra SET $newDatos WHERE compra_cod=$compra_cod";
        
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Edicion Satisfactoria";
        }
        mysqli_close($link);
        header("Location: ../modulos/compra.php?m=$mensaje");
    }
}



// baja de venta
if (isset($_POST['Bcompra'])){
        $compra_cod=$_POST['compra_codB'];
        

       
            $query="DELETE FROM compra
            WHERE compra.compra_cod=$compra_cod
            ";
             if (!($result = mysqli_query($link,$query))){
                $mensaje="no se pudo eliminar el registro";
             }else{
                $mensaje="el registro se elimino correctamente";
                mysqli_close($link);
                header("Location: ../modulos/compra.php?m=$mensaje");
            } 
      
        
}


?>