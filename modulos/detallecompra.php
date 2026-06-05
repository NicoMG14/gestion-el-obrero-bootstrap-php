<?php 
session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }
  
include ("../libreria/conexion.php");
$compra_cod=$_GET['compra'];
$coeficiente=$_GET['c'];
$producto=$_GET['pro'];

$m=$_GET['m'];
$mensaje="";
if ($m=="ar"){
   $mensaje="¡Debe agregar productos!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="p"){
   $mensaje="¡Debe seleccionar proveedor!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="e"){
   $mensaje="¡Debe seleccionar estado de la compra!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="br"){
   $mensaje="¡Debe eliminar los productos cargados!";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="no"){
   $mensaje="¡Debe ingresar un codigo existente!";
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




$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT compra.compra_cod,detallecompra.producto_cod,producto.producto_desc,ingreso_precio,cantidad,subtotal,producto.precio_actual FROM detallecompra
        INNER JOIN producto
        ON detallecompra.producto_cod=producto.producto_cod
        INNER JOIN compra
        ON detallecompra.compra_cod=compra.compra_cod
        WHERE compra.compra_cod=$compra_cod
        ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $ingreso_precio = $datos['ingreso_precio'];
                $cantidad = $datos['cantidad'];
                $subtotal = $datos['subtotal'];
                $precio_actual = $datos['precio_actual'];
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
                $tabla_filas .= "<td>$ingreso_precio</td>"; 
                $tabla_filas .= "<td>$cantidad</td>"; 
                $tabla_filas .= "<td>$subtotal</td>";
                $parametros="$producto_cod,$cantidad,$precio_actual";         
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
    <title>Compra</title>
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
          $('#proveedor_cod').select2();
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
               
      <label class="col-lg-1 col-form-label" for="compra_cod">Compra:</label>
      <div class="col-lg-2">
        <input type="number" class="form-control" name="compra_cod" id="compra_cod" value="<?= $compra_cod?>"placeholder="" readonly="" required>
      </div>
</div>
<div class="row mb-3">
               
      <label class="col-lg-1 col-form-label" for="compra_fecha">Fecha:</label>
      <div class="col-lg-2">
      <input type="datetime" class="form-control" name="compra_fecha" id="compra_fecha" value="<?= $fecha_actual?>"placeholder="" readonly="" required >
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
      <th scope="col">Precio de Compra</th>
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
    <label class="col-lg-1 form-label" for="proveedor_cod">Proveedor:</label>
    <div class="col-lg-2">
    <select name="proveedor_cod" id="proveedor_cod" class="form-select" onchange="proveedor()">
         <option>Seleccione proveedor</option>
            <?php
                $query = mysqli_query($link, "SELECT proveedor_cod,proveedor_nom FROM proveedor")
                  or die(mysqli_error($link));
                while ($valores = mysqli_fetch_array($query)) {
                  echo '<option value="'.$valores[proveedor_cod].'">'.$valores[proveedor_nom].'</option>';
                }
            ?>
            
    </select>
  </div>
</div>

<div class="row mb-3">
      <label class="col-lg-1 col-form-label" for="compra_estado">Estado:</label>
      <div class="col-lg-2">
        <select name="compra_estado" id="compra_estado" class="form-select" onchange="estado()">
          <option>Seleccion estado</option>
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
      </div>
</div>       
    <input type="hidden" name="proveedor" id="proveedor">
    <input type="hidden" name="estado" id="estado">
    <!-- almacena el codigo de proveedor -->

<form action="../libreria/lib_compra.php" method="post" enctype="multipart/form-data">
        <div class="">
            <input type="hidden" name="compra_codM" id="compra_codM" value="<?= $compra_cod?>">
            <input type="hidden" name="compra_fechaM" id="compra_fechaM" value="<?= $fecha_actual?>">
            <input type="hidden" name="compra_totalM" id="compra_totalM" value="<?= $total?>">
            <input type="hidden" name="proveedor_codM" id="proveedor_codM">
            <input type="hidden" name="compra_estadoM" id="compra_estadoM">
            <button type="submit" name="MMcompra" id="MMcompra" class="btn btn-success">Confirmar Compra</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajacompra">Descartar Compra</button>
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
      <form action="../libreria/lib_detallecompra.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           <input type="hidden" name="compra_cod" id="compra_cod" value="<?= $compra_cod?>">
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

           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="ingreso_precio">Precio de compra:</label>
               <div class="col-sm-8"> 
                <input type="number" step="0.01" value="" class="form-control" name="ingreso_precio" id="ingreso_precio" placeholder="Ingrese precio de compra" required>
              </div>
           </div>
   

           <div class="row mb-3">
             <label class="col-sm-4 col-form-label" for="coeficiente">Coeficiente:</label>
             <div class="col-sm-8">
              <input type="number" class="form-control" name="coeficiente" id="coeficiente" value="<?= $coeficiente ?>" step="0.01" placeholder="Ingrese coeficiente" required>
             </div>
           </div>
        
       </div>
          <div class="modal-footer">
            <button type="submit" name="Adetallecompra" id="Adetallecompra" class="btn btn-success" >Agregar al detalle</button>
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
      <form action="../libreria/lib_detallecompra.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar este producto? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="producto_codB" id="producto_codB">
            <input type="hidden" name="cantidadB" id="cantidadB">
            <input type="hidden" name="precio_actualB" id="precio_actualB">
            <input type="hidden" name="compra_cod" id="compra_cod" value="<?= $compra_cod?>">
            <button type="submit" name="Bproducto" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal de eliminacion descartar compra-->

<div class="modal fade" id="bajacompra" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Eliminacion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_detallecompra.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar la compra? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="compra_codB" id="compra_codB" value="<?= $compra_cod?>">
            <input type="hidden" name="rowcont" id="rowcont" value="<?= $rowcont?>">
            <button type="submit" name="Bcompra" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>



<script>
  function delReg(producto_cod,cantidad,precio_actual){
        document.getElementById('producto_codB').value = producto_cod;
        document.getElementById('cantidadB').value = cantidad;
        document.getElementById('precio_actualB').value = precio_actual;
  } 

  function proveedor(){
   var pro=document.getElementById('proveedor_cod').value;
   document.getElementById('proveedor').value=pro;
   //alert (pro);
   document.getElementById('proveedor_codM').value=pro;
  }

  function estado(){
   var est=document.getElementById('compra_estado').value;
   document.getElementById('estado').value=est;
   //alert (pro);
   document.getElementById('compra_estadoM').value=est;
  }  
</script>
</div>
</body>
</html>