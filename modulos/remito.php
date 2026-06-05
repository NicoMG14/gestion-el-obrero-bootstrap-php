<?php 

session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    $usuario_cod=$_SESSION['usuario_cod'];
    header("Location:login.php");
    session_destroy();
    exit();
  }
  include ("../libreria/conexion.php");
$venta_cod=$_GET['venta'];
// capturo variable producto de la busqueda de la libreria
$producto=$_GET['pro'];

if (isset($_POST['busca'])){
      $nota_cod=$_POST['nota_cod'];
      $venta_cod=$_POST['venta'];

      $query = "SELECT nota_cod,nota_total,nota_estado FROM notadecredito WHERE nota_cod=$nota_cod";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $nota_estado= $datos['nota_estado'];
                if ($nota_estado==1){
                    $nota_totalM = $datos['nota_total'];
                }else{         
                   $mensaje="¡La nota de credito ingresada esta INACTIVA!";
                   $m="";
                   echo "<script> alert('".$mensaje."'); </script>";
                }
            }
        }
    }

    }

$m=$_GET['m'];
$mensaje="";
if ($m=="non"){
   $mensaje="¡El total de la venta no puede ser un numero negativo!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
   }
if ($m=="ar"){
   $mensaje="¡Debe agregar productos!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="c"){
   $mensaje="¡Debe seleccionar cliente!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="br"){
   $mensaje="¡Debe eliminar todos los productos!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="no"){
  $mensaje="Debe ingresar un codigo existente!";
  $m="";
  echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="nostock"){
  $mensaje="No hay stock del producto!";
  $m="";
  echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="nollega"){
  $mensaje="No hay suficiente stock del producto!";
  $m="";
  echo "<script> alert('".$mensaje."'); </script>";
}
if ($m=="noexist"){
  $mensaje="El producto ingresado no existe!";
  $m="";
  echo "<script> alert('".$mensaje."'); 
                    var modal='false';
                   </script>";
}
if ($m=="encont"){
  $mensaje="Encontrado";
  $m="";
  echo "<script> 
         var modal='true';
        </script>";
}
if ($m=="nomed"){
   $mensaje="¡La cantidad de los productos por UNIDAD no pueden llevar decimales!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
}

// muestra registros
$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT venta.venta_cod,detalleventa.producto_cod,producto.producto_desc,producto.producto_precio,cantidad,subtotal FROM detalleventa
        INNER JOIN producto
        ON detalleventa.producto_cod=producto.producto_cod
        INNER JOIN venta
        ON detalleventa.venta_cod=venta.venta_cod
        WHERE venta.venta_cod=$venta_cod
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
    <title>Venta</title>
    <style type="text/css">
     .select2-container--open {
        z-index: 999999;
        top: initial;
        bottom: 0
      }
    </style>
    <script>

        $(document).ready(function(){
          $('#cliente_cod').select2();
        });
        $(document).ready(function(){
          $('#nota_cod').select2();
        });
        $(document).ready(function(){
          $('#producto_cod').select2();
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
               
      <label class="col-lg-1 col-form-label" for="venta_cod">Venta num.:</label>
      <div class="col-lg-2">
      <input type="number" class="form-control" name="venta_cod" id="venta_cod" value="<?= $venta_cod?>"placeholder="" readonly="" >
    </div>
</div>

<div class="row mb-3">
               
      <label class="col-lg-1 col-form-label" for="venta_fecha">Fecha:</label>
      <div class="col-lg-2">
      <input type="datetime" class="form-control" name="venta_fecha" id="venta_fecha" value="<?= $fecha_actual?>"placeholder="" readonly="" >
    </div>
</div>

 
<br>


<div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta" >Agregar Producto</button>

</div>



<br/>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Codigo de Producto</th>
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
  
    <label class="col-lg-1 form-label" for="subtotal">Total:</label>
    <div class="col-lg-2">
    <input class="form-control" id="subtotal" name="subtotal" value="<?= $total?>" type="text" placeholder="" readonly="" required>
</div>
</div>




<div class="row mb-3">
    <label class="col-lg-1 form-label" for="nota_cod">Nota de credito:</label>
    <div class="col-lg-2">
    <select name="nota_cod" id="nota_cod" class="form-select" onchange="nota()" required>
         <option value="">Seleccione nota de cred.</option>
            <?php
                $query = mysqli_query($link, "SELECT nota_cod,nota_total FROM notadecredito WHERE nota_estado=1")
                  or die(mysqli_error($link));
                while ($valores = mysqli_fetch_array($query)) {
                  echo '<option value="'.$valores[nota_cod].'">'.$valores[nota_cod].' = $'.$valores[nota_total].'</option>';
                }
            ?>
            
    </select>
  </div>
</div>



 <div class="row mb-3">
    <label class="col-lg-1 form-label" for="cliente_cod">Cliente:</label>
    <div class="col-lg-2">
    <select name="cliente_cod" id="cliente_cod" class="form-select" onchange="cliente()" required>
         <option value="">Seleccione cliente</option>
            <?php
                $query = mysqli_query($link, "SELECT cliente_cod,cliente_nom FROM cliente")
                  or die(mysqli_error($link));
                while ($valores = mysqli_fetch_array($query)) {
                  echo '<option value="'.$valores[cliente_cod].'">'.$valores[cliente_nom].'</option>';
                }
            ?>
            
    </select>
  </div>
</div>


    <input type="hidden" name="cliente" id="cliente">
    <!-- almacena el codigo de cliente -->

<form action="../libreria/lib_venta.php" method="post" enctype="multipart/form-data">
        <div class="">
            <input type="hidden" name="venta_codM" id="venta_codM" value="<?= $venta_cod?>">
            <input type="hidden" name="venta_fechaM" id="venta_fechaM" value="<?= $fecha_actual?>">
            <input type="hidden" name="totalM" id="totalM" value="<?= $total?>">
            <input type="hidden" name="nota_codM" id="nota_codM">
            <input type="hidden" name="cliente_codM" id="cliente_codM">
            <input type="hidden" name="usuario_codM" id="usuario_codM" value="<?= $_SESSION['usuario_cod']; ?>">
            <button type="submit" name="Mventa" id="Mventa" class="btn btn-success">Confirmar Venta</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaventa">Descartar Venta</button>
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
      <form action="../libreria/lib_remito.php" method="post" enctype="multipart/form-data">
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
            <button type="submit" name="Aremito" id="Aremito" class="btn btn-success" >Agregar al detalle</button>
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
      <form action="../libreria/lib_remito.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar este producto? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="producto_codB" id="producto_codB">
            <input type="hidden" name="cantidadB" id="cantidadB">
            <input type="hidden" name="venta_cod" id="venta_cod" value="<?= $venta_cod?>">
            <button type="submit" name="Bproducto" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal de eliminacion descartar venta-->

<div class="modal fade" id="bajaventa" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Eliminacion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_remito.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea descartar la venta? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="rowcont" id="rowcont" value="<?= $rowcont?>">
            <input type="hidden" name="venta_codB" id="venta_codB" value="<?= $venta_cod?>">
            <button type="submit" name="Bventa" class="btn btn-danger">Eliminar</button>
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

  function cliente(){
   var cli=document.getElementById('cliente_cod').value;
   document.getElementById('cliente').value=cli;
   //alert (cli);
   document.getElementById('cliente_codM').value=cli;
  }

  function nota(){
   var nota=document.getElementById('nota_cod').value;
   document.getElementById('nota_codM').value=nota;
  }

  const input = document.querySelector('nota_cod');
  const log = document.getElementById('nota_codM');

  input.addEventListener('change', updateValue);

  function updateValue(e) {
    log.textContent = e.target.value;
  }

</script>
</div>
</body>
</html>