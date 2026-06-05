<?php 

session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }

include ("../libreria/conexion.php");

$m=$_GET['m'];
if ($m=="nostock"){
  $mensaje="¡No hay stock del producto!";
  echo "<script> alert('".$mensaje."'); </script>";
}
$m=$_GET['m'];
if ($m=="noexist"){
  $mensaje="El producto ingresado de existe!";
  echo "<script> alert('".$mensaje."'); </script>";
   echo "<script> alert('".$mensaje."'); 
            var modal='false';
           </script>";
}
$m=$_GET['m'];
if ($m=="encont"){
  echo "<script> 
    var modal='true';
   </script>";
}
if ($m=="nomed"){
   $mensaje="¡La cantidad de los productos por UNIDAD no pueden llevar decimales!";
   echo "<script> alert('".$mensaje."'); </script>";
}

$producto=$_GET['pro'];


$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT presupuesto.producto_cod,producto.producto_desc,producto.producto_precio,cantidad,subtotal FROM presupuesto,producto WHERE presupuesto.producto_cod=producto.producto_cod";
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
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$producto_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
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
    <<meta charset="utf-8">
    <meta name="keywords" content="HTML5, CSS, Javascript">
    <link href="../css/bootstrap.css" rel="stylesheet" >
    <link href="../css/bootstrap_icons/bootstrap-icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/select2.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/select2.js"></script> 
    <title>Presupuesto</title>
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



    </script>
   </head>
  <body>
<div class="container">
<br>


<div class="row mb-3">
               
      <label class="col-lg-1 col-form-label" for="fecha">Fecha:</label>
      <div class="col-lg-2">
      <input type="datetime" class="form-control" name="fecha" id="fecha" value="<?= $fecha_actual?>"placeholder="" readonly="" >
      </div>
</div>

 
<br>
<div>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta" >Agregar Producto</button>
</div>
<!-- <div class="oculto">
<button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta" id="btnalta">Alta</button>
</div> -->
<br/>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Codigo</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Precio</th>
      <th scope="col">Cantidad</th>
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
    <input class="form-control" id="total" name="total" value="<?= $total?>" type="text" placeholder="" readonly="" required>
</div>
</div>


    <!-- almacena el codigo de cliente -->

<form action="" method="post" enctype="multipart/form-data">
        <div class="">
            <input type="hidden" name="venta_totalM" id="venta_totalM" value="<?= $total?>">
            <input type="hidden" name="cliente_codM" id="cliente_codM">
            <input type="hidden" name="usuario_codM" id="usuario_codM" value="0">
            <button type="submit" name="" id="" class="btn btn-success" onclick="window.open('../generadorpdf/pdfpresupuesto.php')">Imprimir Presupuesto</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajapresupuesto">Atras</button>
        </div>
</form>



<!-- modal para nuevo registro -->
<div class="modal fade" id="alta" name="alta"  aria-labellebly="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese Producto y Cantidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_presupuesto.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           <input type="hidden" name="venta_cod" id="venta_cod" value="<?= $venta_cod?>">

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
            <button type="submit" name="Apresupuesto" id="Apresupuesto" class="btn btn-success" >Agregar al detalle</button>
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
      <form action="../libreria/lib_presupuesto.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar este producto? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="producto_codB" id="producto_codB">
            <button type="submit" name="Bproducto" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal de eliminacion descartar presupuesto-->

<div class="modal fade" id="bajapresupuesto" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_presupuesto.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Volver al sector Productos?
          </div>
          <div class="modal-footer">
            
            <button type="submit" name="Bpresupuesto" class="btn btn-success">Aceptar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>




<script>
  function delReg(producto_cod){
        document.getElementById('producto_codB').value = producto_cod; 
  } 



</script>
</div>
</body>
</html>