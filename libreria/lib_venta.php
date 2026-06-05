<?php
include ('conexion.php');
include ('lib_remito.php');
// alta de venta

if ($conexion=="si"){
    if (isset($_POST['Aventa'])){
        $query="INSERT INTO venta () VALUES ()";
        if(!($result = mysqli_query($link,$query))){
            $mensaje = "Falló la conexión, inténtelo más tarde";
        }else{
            $mensaje = "Registro Satisfactorio";
        }
        $venta_cod = mysqli_insert_id($link);
  
        mysqli_close($link);
        header("Location: ../modulos/remito.php?m=$mensaje&venta=$venta_cod");
    }
}






// modificacion de venta
if ($conexion=="si"){
    if (isset($_POST['Mventa'])){
        $venta_cod=$_POST['venta_codM'];
        $venta_fecha=$_POST['venta_fechaM'];
        $total=$_POST['totalM'];
        $cliente_cod=$_POST['cliente_codM'];
        $usuario_cod=$_POST['usuario_codM'];
        $nota_cod=$_POST['nota_codM'];

        $nota_total=0;

        $query="SELECT nota_cod,nota_total FROM notadecredito where nota_cod=$nota_cod";
        $resultado=mysqli_query($link,$query);
        $datos=mysqli_fetch_assoc($resultado);
        $nota_total=$datos['nota_total'];
        
        $venta_total=0;
        if ($nota_total==NULL){
            $nota_total=0;
            $nota_resto=0;
        }


        //si venta es igual a 0
        if ($total==0){
            $mensaje="ar";
            header("Location: ../modulos/remito.php?venta=$venta_cod&m=$mensaje");
        }elseif ($cliente_cod==NULL) {
             $mensaje="c";
            header("Location: ../modulos/remito.php?venta=$venta_cod&m=$mensaje");
        }elseif ($nota_total>$total) { //si nota es mayor a venta a pagar
            
            // update de nota cargada
            $query="UPDATE notadecredito SET nota_estado=0 WHERE nota_cod=$nota_cod";
            
            if(!($result = mysqli_query($link,$query))){
             $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
             $mensaje = "Edicion Satisfactoria";
            }


            $nota_resto=$nota_total-$total;
            
            $query="INSERT INTO notadecredito (nota_fecha,nota_total,nota_estado,venta_cod,usuario_cod) VALUES ('$venta_fecha',$nota_resto,1,$venta_cod,$usuario_cod)";
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Registro Satisfactorio";
            }
            $nota_cod1 = mysqli_insert_id($link);

            $newDatos="venta_fecha='$venta_fecha',venta_total=$venta_total,cliente_cod=$cliente_cod,usuario_cod=$usuario_cod,nota_resto=$nota_total";

            $query="UPDATE venta SET $newDatos WHERE venta_cod=$venta_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            mysqli_close($link);

            $mensaje="not";
            header("Location: ../modulos/venta.php?nota=$nota_cod1&m=$mensaje");
        }else if($total==$nota_total){ // si la venta a pagar es igual a la nota
                $venta_total=0;

            // update de nota cargada
            $query="UPDATE notadecredito SET nota_estado=0 WHERE nota_cod=$nota_cod";
            
            if(!($result = mysqli_query($link,$query))){
             $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
             $mensaje = "Edicion Satisfactoria";
            }
            
            $newDatos="venta_fecha='$venta_fecha',venta_total=$venta_total,cliente_cod=$cliente_cod,usuario_cod=$usuario_cod,nota_resto=$nota_total";

            $query="UPDATE venta SET $newDatos WHERE venta_cod=$venta_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            mysqli_close($link);
            header("Location: ../modulos/venta.php?m=$mensaje");
        }else if($total>$nota_total){// nota menor a venta
            $venta_total=$total-$nota_total;

            // update de nota cargada
            $query="UPDATE notadecredito SET nota_estado=0 WHERE nota_cod=$nota_cod";
            
            if(!($result = mysqli_query($link,$query))){
             $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
             $mensaje = "Edicion Satisfactoria";
            }

            $newDatos="venta_fecha='$venta_fecha',venta_total=$venta_total,cliente_cod=$cliente_cod,usuario_cod=$usuario_cod,nota_resto=$nota_total";
            $query="UPDATE venta SET $newDatos WHERE venta_cod=$venta_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            mysqli_close($link);
            header("Location: ../modulos/venta.php?m=$mensaje");
        }else{// nota null o menor
            $venta_total=$total;
            $newDatos="venta_fecha='$venta_fecha',venta_total=$venta_total,cliente_cod=$cliente_cod,usuario_cod=$usuario_cod,nota_resto=$nota_total";
            $query="UPDATE venta SET $newDatos WHERE venta_cod=$venta_cod";
            
            if(!($result = mysqli_query($link,$query))){
                $mensaje = "Falló la conexión, inténtelo más tarde";
            }else{
                $mensaje = "Edicion Satisfactoria";
            }
            mysqli_close($link);
            header("Location: ../modulos/venta.php?m=$mensaje");
        }
        

    }
}



// baja de venta
if (isset($_POST['Bventa'])){
        $rowcont=$_POST['rowcont'];
        $venta_cod=$_POST['venta_codB'];

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
    
        
}


?>