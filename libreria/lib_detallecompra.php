<?php
include ('conexion.php');

// alta de registros
if ($conexion=="si"){

    if (isset($_POST['Adetallecompra'])){
        $producto_cod=$_POST['producto_cod'];
        $cantidad=$_POST['cantidad'];
        $compra_cod=$_POST['compra_cod'];
        $ingreso_precio=$_POST['ingreso_precio'];
        $coeficiente=$_POST['coeficiente'];
        $subtotal=$cantidad*$ingreso_precio;

          //comprueba si la variable es entera
        $query="SELECT producto_med FROM producto where producto_cod=$producto_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $producto_med=$datos['producto_med'];

        if (ctype_digit($cantidad)) {
            $valcant="si";
        }else{
            $valcant="no";
        }
        // comprueba si es unidad
        if ($producto_med=="Unidad" && $valcant=="no"){
            //no sigue
            $mensaje="nomed";
            header("Location: ../modulos/detallecompra.php?m=$mensaje&compra=$compra_cod&c=$coeficiente");
            mysqli_close($link);
            exit();
        }
        

        //validar codigo de producto
        

        
        //aumenta stock
        $precio=$ingreso_precio*$coeficiente;
        $query="UPDATE producto SET producto_cant=producto_cant+$cantidad,producto_precio=$precio WHERE producto_cod=$producto_cod";
        if(!($result = mysqli_query($link,$query))){
         $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
         $mensaje = "Edicion Satisfactoria";
        }
        

        $campo="compra_cod,producto_cod,cantidad,ingreso_precio,subtotal";
        $newDatos="$compra_cod,$producto_cod,$cantidad,$ingreso_precio,$subtotal";
        $query="INSERT INTO detallecompra ($campo) VALUES ($newDatos)";

        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/detallecompra.php?m=$mensaje&compra=$compra_cod&c=$coeficiente");
    
    }
}

// busqueda de producto
        if (isset($_POST['ingreso'])){
          $producto=$_POST['producto'];
          $compra_cod=$_POST['compra_cod'];
          $query="SELECT producto_cod,producto_desc FROM producto where producto_cod LIKE '%$producto%' OR producto_desc LIKE '%$producto%'";
          $resultado=mysqli_query($link,$query);
          $datos=mysqli_fetch_assoc($resultado);
          $producto_cod=$datos['producto_cod'];
          if ($producto_cod==""){
              $mensaje="noexist";
              mysqli_close($link);
              header("Location: ../modulos/detallecompra.php?m=$mensaje&compra=$compra_cod");
          }else{
              $mensaje="encont";
              mysqli_close($link);
              header("Location: ../modulos/detallecompra.php?m=$mensaje&compra=$compra_cod&pro=$producto");
          }
        }





// baja de registros
if (isset($_POST['Bproducto'])){
        $producto_cod=$_POST['producto_codB'];
        $compra_cod=$_POST['compra_cod'];
        $precio_actual=$_POST['precio_actualB'];
        $cantidad=$_POST['cantidadB'];
        
        // dosminuye stock
        $query="UPDATE producto SET producto_cant=producto_cant-$cantidad,producto_precio=$precio_actual WHERE producto_cod=$producto_cod";
        if(!($result = mysqli_query($link,$query))){
         $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
         $mensaje = "Edicion Satisfactoria";
        }

        $query="DELETE FROM detallecompra WHERE producto_cod=$producto_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/detallecompra.php?m=$mensaje&compra=$compra_cod");
         } 
}

// baja de venta
if (isset($_POST['Bcompra'])){
        $compra_cod=$_POST['compra_codB'];
        $rowcont=$_POST['rowcont'];

        if ($rowcont==0) {
            
       
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
        }else{
            $mensaje="br";
            header("Location: ../modulos/detallecompra.php?compra=$compra_cod&m=$mensaje");
        }
        
}




?>