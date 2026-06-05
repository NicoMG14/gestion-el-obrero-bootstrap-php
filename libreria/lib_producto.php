<?php
include ('conexion.php');
$mensaje="";
// alta de registros
if ($conexion=="si"){
    if (isset($_POST['Aproducto'])){
        $fecha_mod=$_POST['fecha_mod'];
        $producto_desc=$_POST['producto_desc'];
        $producto_precio=$_POST['producto_precio'];
        $producto_cant=$_POST['producto_cant'];
        $producto_cantmin=$_POST['producto_cantmin'];
        $producto_med=$_POST['producto_med'];
        $proveedor_cod=$_POST['proveedor_cod'];
        $rubro_cod=$_POST['rubro_cod'];

        
         //comprueba si la variable es entera
        if (ctype_digit($producto_cant)) {
            $valcant="si";
        }else{
            $valcant="no";
        }
        if (ctype_digit($producto_cantmin)) {
            $valcantmin="si";
        }else{
            $valcantmin="no";
        }

        // comprueba si es unidad
        if ($producto_med=="Unidad" && $valcant=="no"){
            //no sigue
            $mensaje="nomed";
            header("Location: ../modulos/producto.php?m=$mensaje");
            mysqli_close($link);
            exit();
        }
        if ($producto_med=="Unidad" && $valcantmin=="no"){
            //no sigue
            $mensaje="nomed";
            header("Location: ../modulos/producto.php?m=$mensaje");
            mysqli_close($link);
            exit();
        }
        


        $producto_foto="0";
        // Carga de la foto
    
       $producto_foto=$_FILES['producto_foto']['name'];

       move_uploaded_file($_FILES['producto_foto']['tmp_name'],"../imagenes/".$_FILES['producto_foto']['name']);
       if($producto_foto==""){
            $producto_foto="0";
        }     
      
    
        $campo="fecha_mod,producto_desc,producto_precio,producto_cant,producto_cantmin,producto_med,producto_foto,proveedor_cod,rubro_cod,precio_actual";
        $newDatos="'$fecha_mod','$producto_desc',$producto_precio,$producto_cant,$producto_cantmin,'$producto_med','$producto_foto',$proveedor_cod,$rubro_cod,$producto_precio";

        $query="INSERT INTO producto ($campo) VALUES ($newDatos)";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        mysqli_close($link);
        header("Location: ../modulos/producto.php?m=$mensaje");
    }
}

// modificacion de registros
if ($conexion=="si"){
    if (isset($_POST['Mproducto'])){
        $producto_cod=$_POST['producto_codE'];
        $fecha_mod=$_POST['fecha_modE'];
        $producto_desc=$_POST['producto_descE'];
        $producto_precio=$_POST['producto_precioE'];
        $producto_cant=$_POST['producto_cantE'];
        $producto_cantmin=$_POST['producto_cantminE'];
        $producto_med=$_POST['producto_medE'];
        $proveedor_cod=$_POST['proveedor_codE'];
        $rubro_cod=$_POST['rubro_codE'];
        

        //comprueba si la variable es entera
        if (ctype_digit($producto_cant)) {
            $valcant="si";
        }else{
            $valcant="no";
        }
        if (ctype_digit($producto_cantmin)) {
            $valcantmin="si";
        }else{
            $valcantmin="no";
        }

        // comprueba si es unidad
        if ($producto_med=="Unidad" && $valcant=="no"){
            //no sigue
            $mensaje="nomed";
            header("Location: ../modulos/producto.php?m=$mensaje");
            mysqli_close($link);
            exit();
        }
        if ($producto_med=="Unidad" && $valcantmin=="no"){
            //no sigue
            $mensaje="nomed";
            header("Location: ../modulos/producto.php?m=$mensaje");
            mysqli_close($link);
            exit();
        }
        
        $producto_fotoee=$_POST['producto_fotoee'];
        $producto_fotoE=$_FILES['producto_fotoE']['name'];

        if ($producto_fotoee == "Sin archivo" AND $producto_fotoE==NULL){
            $producto_foto="0";
        }else if ($producto_fotoee != "" AND $producto_fotoE==NULL){
            $producto_foto=$producto_fotoee;
        }else if($producto_fotoE!=""){
            $producto_foto=$producto_fotoE;
            move_uploaded_file($_FILES['producto_fotoE']['tmp_name'],"../imagenes/".$_FILES['producto_fotoE']['name']);
        }

        
        $newDatos="fecha_mod='$fecha_mod',producto_desc='$producto_desc',producto_precio=$producto_precio,producto_cant=$producto_cant,producto_cantmin=$producto_cantmin,producto_med='$producto_med',producto_foto='$producto_foto',proveedor_cod=$proveedor_cod,rubro_cod=$rubro_cod,precio_actual=$producto_precio";


        $query="UPDATE producto SET $newDatos WHERE producto_cod=$producto_cod";
        
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Edicion Satisfactoria";
        }
        mysqli_close($link);
        header("Location: ../modulos/producto.php?m=$mensaje");
    }
}

// baja de registros
if ($conexion=="si"){
if (isset($_POST['Bproducto'])){
        $producto_cod=$_POST['producto_codB'];
        $query="DELETE FROM producto WHERE producto_cod=$producto_cod";
         if (!($result = mysqli_query($link,$query))){
            $mensaje="no se pudo eliminar el registro";
         }else{
            $mensaje="el registro se elimino correctamente";
            mysqli_close($link);
            header("Location: ../modulos/producto.php?m=$mensaje");
         } 
}
}


?>