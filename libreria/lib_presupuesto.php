<?php
include ('conexion.php');

// alta de registros
if ($conexion=="si"){
    if (isset($_POST['Apresupuesto'])){
        $producto_cod=$_POST['producto_cod'];
        $cantidad=$_POST['cantidad'];
        
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
            header("Location: ../modulos/presupuesto.php?m=$mensaje");
            mysqli_close($link);
            exit();
        }
        
        
    
        $campo="producto_cod,cantidad,subtotal";
        $newDatos="$producto_cod,$cantidad,$subtotal";

        if ($producto_cant<=0) {
            $mensaje="nostock";
            mysqli_close($link);
            header("Location: ../modulos/presupuesto.php?m=$mensaje");
        }else{
            
        $query="INSERT INTO presupuesto ($campo) VALUES ($newDatos)";

        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/presupuesto.php?m=$mensaje");
        }

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
              header("Location: ../modulos/presupuesto.php?m=$mensaje");     
  }else{
      $mensaje="encont";
              mysqli_close($link);
              header("Location: ../modulos/presupuesto.php?m=$mensaje&pro=$producto");
  }
}



// baja de registros
if (isset($_POST['Bproducto'])){
        $producto_cod=$_POST['producto_codB'];
        $query="DELETE FROM presupuesto WHERE producto_cod=$producto_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/presupuesto.php?m=$mensaje");
         } 
}

if (isset($_POST['Bpresupuesto'])){
        $query="DELETE FROM presupuesto";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/producto.php?m=$mensaje");
         } 
}




?>