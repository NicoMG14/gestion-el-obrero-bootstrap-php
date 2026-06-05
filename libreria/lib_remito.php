<?php
include ('conexion.php');

// alta de registros
// if ($conexion=="si"){
// }

    // busqueda de datos
    // busqueda de producto
        if (isset($_POST['ingreso'])){
          $producto=$_POST['producto'];
          $venta_cod=$_POST['venta_cod'];
          $query="SELECT producto_cod,producto_desc FROM producto where producto_cod LIKE '%$producto%' OR producto_desc LIKE '%$producto%'";
          $resultado=mysqli_query($link,$query);
          $datos=mysqli_fetch_assoc($resultado);
          $producto_cod=$datos['producto_cod'];
          if ($producto_cod==""){
              $mensaje="noexist";
              mysqli_close($link);
              header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
          }else{
              $mensaje="encont";
              mysqli_close($link);
              header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod&pro=$producto");
          }
        }


    

    // alta de productos al remito
    if (isset($_POST['Aremito'])){
        $producto_cod=$_POST['producto_cod'];
        $cantidad=$_POST['cantidad'];
        $venta_cod=$_POST['venta_cod'];

        $query="SELECT producto_precio,producto_cant,producto_med FROM producto where producto_cod=$producto_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $producto_precio=$datos['producto_precio'];
        $producto_cant=$datos['producto_cant'];
        $producto_med=$datos['producto_med'];
        $subtotal=$cantidad*$producto_precio;

         //comprueba si la variable es entera
        if (ctype_digit($cantidad)) {
            $valcant="si";
        }else{
            $valcant="no";
        }
        // comprueba si es unidad
        if ($producto_med=="Unidad" && $valcant=="no"){
            //no sigue
            $mensaje="nomed";
            header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
            mysqli_close($link);
            exit();
        }
        

        if ($producto_cant<=0) {
            $mensaje="nostock";
            mysqli_close($link);
            header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
        }elseif ($producto_cant<$cantidad) {
            $mensaje="nollega";
            mysqli_close($link);
            header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
        }else{

            //resta stock
            $query="UPDATE producto SET producto_cant=producto_cant-$cantidad WHERE producto_cod=$producto_cod";
            
            if(!($result = mysqli_query($link,$query))){
             $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
             $mensaje = "Edicion Satisfactoria";
            }
        
            $campo="venta_cod,producto_cod,cantidad,producto_precio,subtotal";
            $newDatos="$venta_cod,$producto_cod,$cantidad,$producto_precio,$subtotal";
            $query="INSERT INTO detalleventa ($campo) VALUES ($newDatos)";
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "no";
            }else{
                $mensaje = "Registro Satisfactorio";
            }
            mysqli_close($link);
            header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
        }
    
      
    }






// baja de registros
if (isset($_POST['Bproducto'])){
        $producto_cod=$_POST['producto_codB'];
        $venta_cod=$_POST['venta_cod'];
        $cantidad=$_POST['cantidadB'];

        // aumenta stock
        $query="UPDATE producto SET producto_cant=producto_cant+$cantidad WHERE producto_cod=$producto_cod";
        
        if(!($result = mysqli_query($link,$query))){
         $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
         $mensaje = "Edicion Satisfactoria";
        }


        $query="DELETE FROM detalleventa WHERE producto_cod=$producto_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
         } 
}


// baja de venta
if (isset($_POST['Bventa'])){
        $rowcont=$_POST['rowcont'];
        $venta_cod=$_POST['venta_codB'];

        if ($rowcont==0){
            $query="DELETE FROM venta
            WHERE venta.venta_cod=$venta_cod
            ";
            if (!($result = mysqli_query($link,$query))){
             $mensaje="no se pudo eliminar el registro";
            }else{
                $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/venta.php?m=$mensaje");
            } 
        }else{
            $mensaje="br";
            header("Location: ../modulos/remito.php?venta=$venta_cod&m=$mensaje");
        }
        
}




?>