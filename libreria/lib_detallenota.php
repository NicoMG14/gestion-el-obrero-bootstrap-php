<?php
include ('conexion.php');

// alta de registros
if ($conexion=="si"){

    if (isset($_POST['Adetallenota'])){
        $producto_cod=$_POST['producto_cod'];
        $cantidad=$_POST['cantidad'];
        $nota_cod=$_POST['nota_cod'];
        $query="SELECT producto_precio,producto_med FROM producto where producto_cod=$producto_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $producto_precio=$datos['producto_precio'];
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
            header("Location: ../modulos/detallenota.php?m=$mensaje0&nota=$nota_cod");
            mysqli_close($link);
            exit();
        }
        
        
        if ($producto_precio>0){
            //aumenta stock
            $query="UPDATE producto SET producto_cant=producto_cant+$cantidad WHERE producto_cod=$producto_cod";
            if(!($result = mysqli_query($link,$query))){
             $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
             $mensaje = "Edicion Satisfactoria";
            }
            
            $campo="nota_cod,producto_cod,cantidad,subtotal";
            $newDatos="$nota_cod,$producto_cod,$cantidad,$subtotal";
            $query="INSERT INTO detallenota ($campo) VALUES ($newDatos)";

            if(!($result = mysqli_query($link,$query))){
                $mensaje = "no";
            }else{
                $mensaje = "Registro Satisfactorio";
            }
            mysqli_close($link);
            header("Location: ../modulos/detallenota.php?m=$mensaje&nota=$nota_cod");
        }else{
            $mensaje = "no";
            mysqli_close($link);
            header("Location: ../modulos/detallenota.php?m=$mensaje&nota=$nota_cod");
        }
    }
}


 // busqueda de producto
        if (isset($_POST['ingreso'])){
          $producto=$_POST['producto'];
          $nota_cod=$_POST['nota_cod'];
          $query="SELECT producto_cod,producto_desc FROM producto where producto_cod LIKE '%$producto%' OR producto_desc LIKE '%$producto%'";
          $resultado=mysqli_query($link,$query);
          $datos=mysqli_fetch_assoc($resultado);
          $producto_cod=$datos['producto_cod'];
          if ($producto_cod==""){
              $mensaje="noexist";
              mysqli_close($link);
              header("Location: ../modulos/detallenota.php?m=$mensaje&nota=$nota_cod");
          }else{
              $mensaje="encont";
              mysqli_close($link);
              header("Location: ../modulos/detallenota.php?m=$mensaje&nota=$nota_cod&pro=$producto");
          }
        }


// baja de registros
if (isset($_POST['Bproducto'])){
        $producto_cod=$_POST['producto_codB'];
        $nota_cod=$_POST['nota_cod'];
        $cantidad=$_POST['cantidadB'];

        //disminuye stock
        $query="UPDATE producto SET producto_cant=producto_cant-$cantidad WHERE producto_cod=$producto_cod";
        if(!($result = mysqli_query($link,$query))){
         $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
         $mensaje = "Edicion Satisfactoria";
        }
    

        $query="DELETE FROM detallenota WHERE producto_cod=$producto_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/detallenota.php?m=$mensaje&nota=$nota_cod");
         } 
}


// baja de nota
if (isset($_POST['Bnota'])){
        $nota_cod=$_POST['nota_codB'];
        $rowcont=$_POST['rowcont'];
        if ($rowcont==0){
             $query="DELETE FROM notadecredito WHERE nota_cod=$nota_cod";
             if (!($result = mysqli_query($link,$query))){
                $mensaje="no se pudo eliminar el registro";
             }else{
                $mensaje="el registro se elimino correctamente";
                mysqli_close($link);
                header("Location: ../modulos/nota.php?m=$mensaje");
             } 
        }else{
            $mensaje="br";
            header("Location: ../modulos/detallenota.php?nota=$nota_cod&m=$mensaje");
        }
        
}


?>