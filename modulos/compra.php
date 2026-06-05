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
    $query = "SELECT compra_cod,compra_fecha,proveedor.proveedor_nom,compra_total,compra_estado FROM compra
        INNER JOIN proveedor
        ON compra.proveedor_cod=proveedor.proveedor_cod
        ORDER BY compra_cod ASC
    ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $compra_cod = $datos['compra_cod'];
                $compra_fecha = $datos['compra_fecha'];
                $proveedor_nom = $datos['proveedor_nom'];
                $compra_total = $datos['compra_total'];
                $compra_estado = $datos['compra_estado'];
                if ($compra_estado==1){
                  $compra_estado='Activo';
                }else{
                  $compra_estado='Inactivo';
                }
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$compra_cod</td>";
                $tabla_filas .= "<td>$compra_fecha</td>"; 
                $tabla_filas .= "<td>$proveedor_nom</td>"; 
                $tabla_filas .= "<td>$compra_total</td>";            
                $tabla_filas .= "<td>$compra_estado</td>";
                // parametros para modificar
                $parametros= "$compra_cod,'$compra_estado'";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#modificar\" onclick=\"editReg(".$parametros.")\"><i class=\"text-warning bi bi-pencil\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" onclick=\"window.open('../generadorpdf/pdfcompra.php?compra=".$compra_cod."')\"><i class=\"text-primary bi bi-printer\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$compra_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
                $tabla_filas .= "</tr>";
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
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../datatables/datatables.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <title>Compras</title>
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
<br> </br>

    <div>
    <form action="../libreria/lib_compra.php" method="post" enctype="multipart/form-data">
        <button type="submit" name="Acompra" id="Acompra" class="btn btn-success">Nueva Compra</button>
    </form>
    </div>


<br>
<h4 align="center">Compras Realizadas</h4>

<table class="table table-hover" id="registros">
  <thead>
    <tr>
      <th scope="col">Num. de Compra</th>
      <th scope="col">Fecha de llegada</th>
      <th scope="col">Proveedor</th>
      <th scope="col">Total</th>
      <th scope="col">Estado</th>
      <th scope="col">Editar</th>
      <th scope="col">Imprimir</th>
      <th scope="col">Borrar</th>

  </thead>
  <!-- Carga de datos -->
  <tbody>
    <?php
        echo $tabla_filas;
    ?>
  </tbody>
</table>

</body>
</html>

<!-- modal de eliminacion -->

<div class="modal fade" id="baja" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Eliminacion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_compra.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar la compra? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="compra_codB" id="compra_codB">
            <button type="submit" name="Bcompra" class="btn btn-success">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal para edicion de registro -->

<div class="modal fade" id="modificar" tabindex="-1" aria-labelledby="modalmdificarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edicion de Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_compra.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="compra_codM" id="compra_codM">
        <div class="modal-body">
            
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label" for="compra_estado">Estado:</label>
            <div class="col-sm-8">
             <select name="compra_estadoM" id="compra_estadoM" class="form-control">
               <option value="1">Activo</option>
               <option value="0">Inactivo</option>
             </select>
            </div>
          </div>   

        </div>
          <div class="modal-footer">
            <button type="submit" name="Mcompra" id="Mcompra" class="btn btn-success">Modificar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>


<script>
    function delReg(compra_cod){
        document.getElementById('compra_codB').value = compra_cod; 
    }    
     function editReg(compra_cod,compra_estado){
        document.getElementById('compra_codM').value = compra_cod;
        if (compra_estado=="Activo"){
          compra_estado=1;
        }else{
          compra_estado=0;
        };
        document.getElementById('compra_estadoM').value = compra_estado;
    
    }
    
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
