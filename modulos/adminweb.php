<?php
session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }
include ("../libreria/conexion.php");
$indexmodelo=0;

// capturo variable producto de la busqueda de la libreria
$producto=$_GET['pro'];

$m=$_GET['m'];
if($m=="nop"){
    $mensaje="Debe ingresar un codigo existente!";
    echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="nof"){
    $mensaje="El producto seleccionado no posee foto!";
    echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="nos"){
    $mensaje="No hay stock del producto!";
    echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="nofecha"){
  $mensaje="Debe ingresar una fecha posterior a la actual!";
  echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="noexist"){
  $mensaje="El producto ingresado no existe!";
  echo "<script> alert('".$mensaje."'); 
                    var modal='false';
                   </script>";
}
if ($m=="encont"){
  $mensaje="Encontrado";
  echo "<script> 
         var modal='true';
        </script>";
}
if ($m=="nofecha"){
  $mensaje="Debe ingresar una fecha posterior a la actual!";
  
}

if($conexion=="si"){
     $query="SELECT oferta_cod,oferta.producto_cod,producto.producto_desc,producto.producto_foto,oferta_desc,producto.producto_precio,fecha_cierre FROM oferta,producto WHERE oferta.producto_cod=producto.producto_cod";
    if ($result=mysqli_query($link,$query)){
        $rowcont=mysqli_num_rows($result);
        if ($rowcont>0){
            while ($datos=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                if ($datos['oferta_cod']>=0){
                    $arraymodelo[$indexmodelo]['oferta_cod']=$datos['oferta_cod'];
                    $arraymodelo[$indexmodelo]['producto_cod']=$datos['producto_cod'];
                    $arraymodelo[$indexmodelo]['producto_desc']=$datos['producto_desc'];
                    $arraymodelo[$indexmodelo]['producto_foto']=$datos['producto_foto'];
                    $arraymodelo[$indexmodelo]['oferta_desc']=$datos['oferta_desc'];
                    $arraymodelo[$indexmodelo]['producto_precio']=$datos['producto_precio'];
                    $arraymodelo[$indexmodelo]['fecha_cierre']=$datos['fecha_cierre'];
                    $indexmodelo++;
                }
            }
            mysqli_free_result($result);
        }
    }
}
?>

<!DOCTYPE html >
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5, CSS, Javascript">
    <link href="../css/bootstrap.css" rel="stylesheet" >
    <link href="../css/bootstrap_icons/bootstrap-icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/select2.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/select2.js"></script>
    <title>Administracion web</title>
    <style type="text/css">
     .select2-container--open {
        z-index: 999999;
        top: initial;
        bottom: 0
      }
    </style>
    <script>
       $(document).ready(function(){
          $('#producto_cod').select2();
        });
        if (modal=='true'){
           $(document).ready(function(){
          $("#editOferta").modal('show');
          });
        };
    </script>
  </head>
  <body>
<div class="container">
<br>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="home.php"><?php echo $_SESSION['usuario_nom']?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="producto.php">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="venta.php">Ventas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="nota.php">Notas de Credito</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="compra.php">Compras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuario.php">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="adminweb.php">Administracion web</a>
        </li>
      </ul>
      <a href="../libreria/lib_logout.php"><button type="button" class="btn btn-outline-danger">Cerrar Sesion</button></a>
    </div>
  </div>
</nav>



<br>
<h3 align="center">Administracion de Ofertas</h3>
<br>

<div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editOferta">Agregar Oferta</button>
</div>

<br>

<h4 align="center">Ofertas</h4>

 <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 my-5">
        <?php 

            for($i=0;$i<$indexmodelo;$i++){
                $oferta_cod=$arraymodelo[$i]['oferta_cod'];
                $producto_cod=$arraymodelo[$i]['producto_cod'];
                $producto_desc=$arraymodelo[$i]['producto_desc'];
                $producto_foto=$arraymodelo[$i]['producto_foto'];
                $oferta_desc=$arraymodelo[$i]['oferta_desc'];
                $producto_precio=$arraymodelo[$i]['producto_precio'];
                $fecha_cierre=$arraymodelo[$i]['fecha_cierre'];
                if ($fecha_cierre<$fecha_actual){
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
                echo "
                <div class=\"col\">
                    <div class=\"card text-white bg-white mb-2\" style=\"width: 20rem\">
                       <img src=\"../imagenes/".$producto_foto."\" class=\"card-img-top\" alt=\"...\" style=\"height:230px\">
                       <div class=\"bg-white text-end text-white d-flex justify-content-end align-items-center m-0\">
                         <span style=\"margin-top:-1rem;\" class=\"rounded-pill bg-dark p-2 fs-5 me-0\">$".$producto_precio."</span>
                       </div>
                     <div class=\"card-body bg-white\">
                         <h5 class=\"card-title text-success\">".$producto_desc."</h5>
                         <p class=\"card-text text-black\">Descripcion: ".$oferta_desc."</p>
                      </div>
                      <div class=\"card-footer bg-success d-flex justify-content-between text-white\">
                         <p class=\"card-text text-white\">Válido hasta: ".$fecha_cierre."</p>
                         <button type=\"button\" class=\"btn btn-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#delOferta\" onclick=\"delReg(".$oferta_cod.")\">Eliminar</button>
                      </div>
                    </div>
              </div>";
            }
            if ($oferta_desc==""){
                echo "No hay ofertas disponibles en este momento";
            }
        ?> 
 </div>



<!-- Formulario Modal (Edición de Oferta) -->
<div class="modal fade" id="editOferta" aria-labelledby="editOfertaLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content border border-success">
      <div class="modal-header bg-success p-2">
        <h5 class="modal-title text-white"><i class="bi bi-pencil-fill me-2 text-white"></i>Agregar oferta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_oferta.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="numoferta" id="numoferta">
        <div class="modal-body">
           <div class="row mb-3">
              <label class="col-sm-4" for="producto_cod">Producto:</label>
              <div class="col-sm-8">
              <select name="producto_cod" id="producto_cod" class="form-select" required style="width: 100%">
                   <option value="">Seleccione producto</option>
                      <?php
                          $query = mysqli_query($link, "SELECT * FROM producto")
                            or die(mysqli_error($link));
                          while ($valores = mysqli_fetch_array($query)) {
                            echo '<option value="'.$valores[producto_cod].'">'.$valores[producto_cod].' '.$valores[producto_desc].' $'.$valores[producto_precio].' cant:'.$valores[producto_cant].' '.$valores[producto_med].'</option>';
                          }
                      ?>
                  
              </select>
              </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="oferta_precio">Precio:</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" value="" class="form-control" name="oferta_precio" id="oferta_precio" placeholder="Ingrese precio de oferta" required>  
              </div>
              
           </div>
          <div class="row mb-3">           
            <label class="col-sm-4 col-form-label" for="fecha_cierre">Fecha de cierre:</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" name="fecha_cierre" id="fecha_cierre" value="" placeholder="Selecciones fecha" min="<?php echo $fecha_actual; ?>" required>
              </div>
           </div>
                 
          <div class="row mb-3">
                <div class="form-group">
                    <label for="oferta_desc" class="form-label">Descripción:</label>
                    <textarea class="form-control form-control-sm" id="oferta_desc" name="oferta_desc" placeholder="Ingrese descripcion de la oferta" rows="3" required></textarea>
                </div>
            </div>

                    <div class="border-top border-success text-end pt-3 mt-3">
                        <button type="button" name="cancelar" id="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" name="newOferta" id="newOferta">Guardar</button>
                    </div>
        </div>
            </form>
        </div>
    </div>
</div>

<!-- modal de eliminacion -->

<div class="modal fade" id="delOferta" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Eliminacion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_oferta.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar esta oferta? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="oferta_codB" id="oferta_codB">
            <button type="submit" name="Boferta" class="btn btn-success">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>
<script>
     function delReg(oferta_cod){
        document.getElementById('oferta_codB').value = oferta_cod; 
    }
</script>
  </body>
</html>