<?php 
session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    $_SESSION['usuario_cod'];
    header("Location:login.php");
    session_destroy();
    exit();
  }
  
include ("../libreria/conexion.php");
$nota_cod=$_GET['nota'];
$producto=$_GET['pro'];

$m=$_GET['m'];
$mensaje="";
if ($m=="ar"){
   $mensaje="¡Debe agregar productos!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="v"){
   $mensaje="¡Debe ingresar numero de venta existente!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="e"){
   $mensaje="¡Debe seleccionar estado de la nota!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="br"){
   $mensaje="¡Debe eliminar los productos cargados!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if($m=="no"){
  $mensaje="Debe ingresar un codigo existente!";
  echo "<script> alert('".$mensaje."'); </script>";
}
if($m=="nov"){
  $mensaje="Debe ingresar un numero de venta existente!";
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
if ($m=="nomed"){
   $mensaje="¡La cantidad de los productos por UNIDAD no pueden llevar decimales!";
   echo "<script> alert('".$mensaje."'); </script>";
}


//
$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT detallenota.nota_cod,detallenota.producto_cod,producto.producto_desc,producto.producto_precio,cantidad,subtotal FROM detallenota
        INNER JOIN producto
        ON detallenota.producto_cod=producto.producto_cod
        WHERE nota_cod=$nota_cod
        ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $producto_precio = $datos['producto_precio'];
                $cantidad = $datos['cantidad'];
                $subtotal = $datos['subtotal'];
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$producto_cod</td>";
                $tabla_filas .= "<td>$producto_desc</td>"; 
                $tabla_filas .= "<td>$producto_precio</td>"; 
                $tabla_filas .= "<td>$cantidad</td>"; 
                $tabla_filas .= "<td>$subtotal</td>"; 
                $parametros="$producto_cod,$cantidad";          
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$parametros.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
                $tabla_filas .= "</tr>";
                $total=$total+$subtotal;
            }
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
    <title>Nota de Credito</title>
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

        $(document).ready(function(){
          $('#venta_cod').select2();
        });

        if (modal=='true'){
           $(document).ready(function(){
          $("#alta").modal('show');
          });
        };
    </script>
  </head>
  <body>
<div class="container">
<br>

<div class="row mb-3">
               
      <label class="col-lg-1 col-form-label" for="compra_cod">Nota de C.:</label>
      <div class="col-lg-2">
        <input type="number" class="form-control" name="nota_cod" id="nota_cod" value="<?= $nota_cod?>"placeholder="" readonly="" required>
      </div>
</div>
<div class="row mb-3">
               
      <label class="col-lg-1 col-form-label" for="nota_fecha">Fecha:</label>
      <div class="col-lg-2">
      <input type="datetime" class="form-control" name="nota_fecha" id="nota_fecha" value="<?= $fecha_actual?>"placeholder="" readonly="" required >
      </div>
</div>

 
<br>
<div>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta" >Agregar Producto</button>
</div>
</br>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Codigo de Producto</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Precio</th>
      <th scope="col">Cantidad que Ingresa</th>
      <th scope="col">Subtotal</th>
      <th scope="col">Borrar</th>
  </thead>
  <!-- Carga de datos -->
  <tbody>
    <?php
        echo $tabla_filas;
    ?>
  </tbody>
</table>
<br>

<div class="row mb-3">
  
    <label class="col-lg-1 form-label" for="total">Total:</label>
    <div class="col-lg-2">
    <input class="form-control" id="total" name="total" value="<?= $total?>" type="text" placeholder="" readonly="">
    </div>
</div>


 <div class="row mb-3">
    <label class="col-lg-1 form-label" for="venta_cod">Venta:</label>
    <div class="col-lg-2">
    <select name="venta_cod" id="venta_cod" class="form-select" onchange="venta()" required>
         <option value="">Seleccione venta</option>
            <?php
                $query = mysqli_query($link, "SELECT venta_cod,venta_total FROM venta")
                  or die(mysqli_error($link));
                while ($valores = mysqli_fetch_array($query)) {
                  echo '<option value="'.$valores[venta_cod].'">'.$valores[venta_cod].' = $'.$valores[venta_total].'</option>';
                }
            ?>
            
    </select>
  </div>
</div>

 

<div class="row mb-3">
               
      <label class="col-lg-1 col-form-label" for="nota_estado">Estado:</label>
      <div class="col-lg-2">
      <input type="datetime" class="form-control" name="nota_estado" id="nota_estado" value="Activo"  readonly="Activo" required >
      </div>
</div>

      
    <input type="hidden" name="estado" id="estado">
    <!-- almacena el codigo de proveedor -->

<form action="../libreria/lib_nota.php" method="post" enctype="multipart/form-data">
        <div class="">
            <input type="hidden" name="nota_codM" id="nota_codM" value="<?= $nota_cod?>">
            <input type="hidden" name="nota_fechaM" id="nota_fechaM" value="<?= $fecha_actual?>">
            <input type="hidden" name="nota_totalM" id="nota_totalM" value="<?= $total?>">
            <input type="hidden" name="usuario_codM" id="usuario_codM" value="<?= $_SESSION['usuario_cod']?>">
            <input type="hidden" name="venta_codM" id="venta_codM">
            <input type="hidden" name="nota_estadoM" id="nota_estadoM" value="1">
            <button type="submit" name="Mnota" id="Mnota" class="btn btn-success">Confirmar Nota de Credito</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajacompra">Descartar Nota de Credito</button>
        </div>
</form>




<!-- modal para nuevo registro -->
<div class="modal fade" id="alta" name="alta" aria-labellebly="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese Producto y Cantidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_detallenota.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           <input type="hidden" name="nota_cod" id="nota_cod" value="<?= $nota_cod?>">
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
              <label class="col-form-label col-sm-4" for="cantidad">Cantidad:</label>  
              <div class="col-sm-8">
                <input type="number" step="0.01" value="1" class="form-control" name="cantidad" id="cantidad" placeholder="" required>  
              </div>            
              
           </div>
        
       </div>
          <div class="modal-footer">
            <button type="submit" name="Adetallenota" id="Adetallenota" class="btn btn-success" >Agregar al detalle</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal de eliminacion producto-->

<div class="modal fade" id="baja" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Eliminacion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_detallenota.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar este producto? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="producto_codB" id="producto_codB">
            <input type="hidden" name="cantidadB" id="cantidadB">
            <input type="hidden" name="nota_cod" id="nota_cod" value="<?= $nota_cod?>">
            <button type="submit" name="Bproducto" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal de eliminacion descartar nota-->

<div class="modal fade" id="bajacompra" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Eliminacion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_detallenota.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar la Nota de Credito? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="nota_codB" id="nota_codB" value="<?= $nota_cod?>">
            <input type="hidden" name="rowcont" id="rowcont" value="<?= $rowcont?>">
            <button type="submit" name="Bnota" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>



<script>
  function delReg(producto_cod,cantidad){
        document.getElementById('producto_codB').value = producto_cod;
        document.getElementById('cantidadB').value = cantidad;        
  } 

  function venta(){
   var ven=document.getElementById('venta_cod').value;

   //alert (ven);
   document.getElementById('venta_codM').value=ven;
  }

  function estado(){
   var est=document.getElementById('nota_estado').value;
   
   //alert (pro);
   document.getElementById('nota_estadoM').value=est;
  }  
</script>
</div>
</body>
</html>