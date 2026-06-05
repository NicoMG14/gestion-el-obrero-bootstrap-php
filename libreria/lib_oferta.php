<?php
include ('conexion.php');
if ($conexion=="si"){
    // Registro de nuevas ofertas
    if (isset($_POST['newOferta'])){
        $producto_cod=$_POST['producto_cod'];
        $oferta_precio=$_POST['oferta_precio'];
        $fecha_cierre=$_POST['fecha_cierre'];
        $oferta_desc=$_POST['oferta_desc'];
        $oferta_cod=$_POST['oferta_cod'];

        $query="SELECT producto_cod,producto_foto,producto_cant FROM producto WHERE producto_cod=$producto_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $val_cod=$datos['producto_cod'];
        $val_foto=$datos['producto_foto'];
        $val_cant=$datos['producto_cant'];

        if ($val_cod==""){
            $mensaje="nop";
            mysqli_close($link);
            header("Location: ../modulos/adminweb.php?m=$mensaje");

        }else if ($val_foto=="0"){
            $mensaje="nof";
            mysqli_close($link);
            header("Location: ../modulos/adminweb.php?m=$mensaje");
        }else if ($val_cant<=0) {
            $mensaje="nos";
            mysqli_close($link);
            header("Location: ../modulos/adminweb.php?m=$mensaje");
        }else if ($fecha_cierre<=$fecha_actual){
            $mensaje="nofecha";
            mysqli_close($link);
            header("Location: ../modulos/adminweb.php?m=$mensaje");
        }else{

            //cambiar de precio el producto
             
            $newDatos="producto_precio=$oferta_precio";
            
            $query="UPDATE producto SET $newDatos WHERE producto_cod=$producto_cod";
             if(!($result = mysqli_query($link,$query))){
             $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
             $mensaje = "Edicion Satisfactoria";
            }
        
            //  Dar de Alta a la nueva oferta

            $campo="producto_cod,oferta_desc,fecha_cierre";
            $newDatos="$producto_cod,'$oferta_desc','$fecha_cierre'";

            $query="INSERT INTO oferta ($campo) VALUES ($newDatos)";
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Registro Satisfactorio";
            }

            mysqli_close($link);
            header("Location: ../modulos/adminweb.php?m=$mensaje");
        }
              
    }

       // busqueda de producto
        if (isset($_POST['ingreso'])){
          $producto=$_POST['producto'];
          $query="SELECT producto_cod,producto_desc FROM producto where producto_cod LIKE '%$producto%' OR producto_desc LIKE '%$producto%'";
          $resultado=mysqli_query($link,$query);
          $datos=mysqli_fetch_assoc($resultado);
          $producto_cod=$datos['producto_cod'];
          if ($producto_cod==""){
              $mensaje="noexist";
              mysqli_close($link);
              header("Location: ../modulos/adminweb.php?m=$mensaje");
          }else{
              $mensaje="encont";
              mysqli_close($link);
              header("Location: ../modulos/adminweb.php?m=$mensaje&pro=$producto");
          }
        }



    // eliminacion de oferta
    if (isset($_POST['Boferta'])){
        $oferta_cod=$_POST['oferta_codB'];

        //cambiar de precio el producto

        $query="SELECT oferta_cod,oferta.producto_cod,producto.producto_precio,producto.precio_actual FROM oferta,producto WHERE oferta_cod=$oferta_cod AND oferta.producto_cod=producto.producto_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $producto_cod=$datos['producto_cod'];
        $producto_precio=$datos['producto_precio'];
        $precio_actual=$datos['precio_actual'];
             
        $newDatos="producto_precio=$precio_actual";
    
        $query="UPDATE producto SET $newDatos WHERE producto_cod=$producto_cod";
         if(!($result = mysqli_query($link,$query))){
         $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
         $mensaje = "Edicion Satisfactoria";
        }


        // eliminar oferta
        $query="DELETE FROM oferta WHERE oferta_cod=$oferta_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/adminweb.php?m=$mensaje");
         } 
    }

}

?>