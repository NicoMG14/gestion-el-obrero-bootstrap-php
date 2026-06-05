<?php
session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }

include ("../libreria/conexion.php");
$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT fecha_mod,producto_cod,producto_desc,producto_precio,producto_cant,producto_cantmin,proveedor.proveedor_nom,rubro.rubro_desc FROM producto
INNER JOIN proveedor
ON producto.proveedor_cod = proveedor.proveedor_cod
INNER JOIN rubro
ON producto.rubro_cod = rubro.rubro_cod
WHERE producto.producto_cant<=producto.producto_cantmin
ORDER BY proveedor_nom ASC
    ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $fecha_mod = $datos['fecha_mod'];
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $producto_precio = $datos['producto_precio'];
                $producto_cant = $datos['producto_cant'];
                $producto_cantmin = $datos['producto_cantmin'];
                $proveedor_nom = $datos['proveedor_nom'];
                $rubro_desc = $datos['rubro_desc'];
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
                $tabla_filas .= "<td>$producto_cant</td>";
                $tabla_filas .= "<td>$producto_cantmin</td>";
                $tabla_filas .= "<td>$proveedor_nom</td>";
                $tabla_filas .= "<td>$rubro_desc</td>";     
               
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
    <link href="../datatables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/select2.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../datatables/datatables.min.js"></script>
    <script src="../js/select2.js"></script>
    <title>Pedidos</title>
    <style type="text/css">
     .select2-container--open {
        z-index: 999999;
        top: initial;
        bottom: 0
      }
    </style>
    <script>
       $(document).ready(function(){
          $('#proveedor_cod').select2();
        });

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
<h3 align="center">Administracion de Compras</h3>
<br>


    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-outline-primary" onclick="location.href='compra.php'">Compras</button>
      <button type="button" class="btn btn-outline-primary" onclick="location.href='pedido.php'">Pedidos</button>
    </div>

<br>
</br>

    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pedido">Generar nota de pedido</button>
    </div>


<br>
<h4 align="center">Lista de Pedidos</h4>

<div class="table-responsive">
<table class="table table-hover" id="registros">
    <thead>
    <tr class="table-type">
        <th scope="col">Codigo</th>
        <th scope="col">Descripcion</th>
        <th scope="col">Precio</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Cantidad Minima</th>
        <th scope="col">Proveedor</th>
        <th scope="col">Rubro</th>
    </tr>
    </thead>
    <tbody>
        <?php
            echo $tabla_filas;
        ?>
    </tbody>
</table>
</div>


<!-- modal de control de inventario -->

<div class="modal fade" id="pedido" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i>Nota de pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../generadorpdf/pdfpedido.php" method="post" enctype="multipart/form-data" target="_blank">
        <div class="modal-body">

           <div class="row mb-3">
              <label class="col-sm-4" for="rubro_cod">Proveedor:</label>
              <div class="col-sm-8">
                <select name="proveedor_cod" id="proveedor_cod" class="form-select" aria-label="Default select example" required style="width: 100%;">
                     <option value="">Seleccione proveedor</option>
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
        
          </div>
          <div class="modal-footer">
            <button type="submit" name="proveedor" class="btn btn-success">Ver</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>


<script>
   $(document).ready( function () {
       $('#registros').DataTable( {
            language: {
              url: '../datatables/spanish.json'
            }
       } );
    } );
</script>

</div>

  </body>
</html>
