<?php
include ('conexion.php');
// alta de nota

if ($conexion=="si"){
    if (isset($_POST['Anota'])){
    
        $query="INSERT INTO notadecredito () VALUES ()";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        $nota_cod = mysqli_insert_id($link);
  
        mysqli_close($link);
        header("Location: ../modulos/detallenota.php?m=$mensaje&nota=$nota_cod");
    }
}


// modificacion de alta de nota
if ($conexion=="si"){
    if (isset($_POST['Mnota'])){
        $nota_cod=$_POST['nota_codM'];
        $nota_estado=$_POST['nota_estadoM'];
        $venta_cod=$_POST['venta_codM'];
        $nota_total=$_POST['nota_totalM'];
        $usuario_cod=$_POST['usuario_codM'];
        $nota_fecha=$_POST['nota_fechaM'];

        //validar venta existente
        $query="SELECT venta_cod FROM venta where venta_cod=$venta_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $valventa=$datos['venta_cod'];

        $newDatos="nota_estado='$nota_estado',venta_cod=$venta_cod,nota_total=$nota_total,usuario_cod=$usuario_cod,nota_fecha='$nota_fecha'";


        
        if ($nota_total==NULL){
            $mensaje="ar";
            header("Location: ../modulos/detallenota.php?nota=$nota_cod&m=$mensaje");
        }elseif ($venta_cod==NULL){
            $mensaje="v";
            header("Location: ../modulos/detallenota.php?nota=$nota_cod&m=$mensaje");
        }elseif ($nota_estado==NULL) {
             $mensaje="e";
             header("Location: ../modulos/detallenota.php?nota=$nota_cod&m=$mensaje");
        }elseif ($valventa==NULL){
            $mensaje="nov";
            header("Location: ../modulos/detallenota.php?nota=$nota_cod&m=$mensaje");
        }else{
             $query="DELETE FROM detallenota";
             if (!($result = mysqli_query($link,$query))){
                $mensaje="no se pudo eliminar el registro";
             }else{
                $mensaje="el registro se elimino correctamente";
             }
            //

            $query="UPDATE notadecredito SET $newDatos WHERE nota_cod=$nota_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            mysqli_close($link);
            header("Location: ../modulos/nota.php?m=$mensaje");
        }



        
    }
}


// modificacion de estado nota
if ($conexion=="si"){
    if (isset($_POST['MMnota'])){
        $nota_cod=$_POST['nota_codM'];
        $nota_estado=$_POST['nota_estadoM'];
        
        $newDatos="nota_estado=$nota_estado";

        $query="UPDATE notadecredito SET $newDatos WHERE nota_cod=$nota_cod";
        
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Edicion Satisfactoria";
        }
        mysqli_close($link);
        header("Location: ../modulos/nota.php?m=$mensaje");
    }
}



// baja de nota
if (isset($_POST['Bnota'])){
        $nota_cod=$_POST['nota_codB'];
        $rowcont=$_POST['rowcont'];

             $query="DELETE FROM notadecredito WHERE nota_cod=$nota_cod";
             if (!($result = mysqli_query($link,$query))){
                $mensaje="no se pudo eliminar el registro";
             }else{
                $mensaje="el registro se elimino correctamente";
                mysqli_close($link);
                header("Location: ../modulos/nota.php?m=$mensaje");
             } 
     
}


?>
