<?php
session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    $_SESSION['usuario_cod'];
    header("Location:login.php");
    session_destroy();
    exit();
  }
include ("../libreria/conexion.php");

$m=$_GET['m'];
$nota=$_GET['nota'];
$mensaje="";
if ($m=="not"){
   $mensaje="¡Se ha generado la nota de credito numero $nota!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
   }

$totaldia=0;
$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT venta_cod,venta_fecha,venta_total,cliente.cliente_nom,usuario.usuario_nom FROM venta
        INNER JOIN cliente
        ON venta.cliente_cod=cliente.cliente_cod
        INNER JOIN usuario
        ON venta.usuario_cod=usuario.usuario_cod
        WHERE venta_fecha='$fecha_actual'
        ORDER BY venta_cod ASC
    ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $venta_cod = $datos['venta_cod'];
                $venta_fecha = $datos['venta_fecha'];
                $venta_total = $datos['venta_total'];
                $cliente_nom = $datos['cliente_nom'];
                $usuario_nom = $datos['usuario_nom'];
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$venta_cod</td>";
                $tabla_filas .= "<td>$venta_fecha</td>"; 
                $tabla_filas .= "<td>$venta_total</td>"; 
                $tabla_filas .= "<td>$cliente_nom</td>"; 
                $tabla_filas .= "<td>$usuario_nom</td>";            
                $tabla_filas .= "<td><a href=\"\" onclick=\"window.open('../generadorpdf/pdfremito.php?venta=".$venta_cod."')\"><i class=\"text-primary bi bi-printer\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$venta_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
                $tabla_filas .= "</tr>";
                $totaldia=$totaldia+$venta_total;
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
    <link href="../datatables/datatables.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/select2.js"></script>
    <script src="../datatables/datatables.min.js"></script>
    <title>Ventas</title>
    <style type="text/css">
     .select2-container--open {
        z-index: 999999;
        top: initial;
        bottom: 0
      }
    </style>
    <script>
       $(document).ready(function(){
          $('#fecha').select2();
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
<h3 align="center">Administracion de Ventas</h3>
<br>

<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-outline-primary" onclick="location.href='venta.php'">Ventas</button>
  <button type="button" class="btn btn-outline-primary" onclick="location.href='cliente.php'">Clientes</button>
</div>

<br>
</br>

<div>
    <form action="../libreria/lib_venta.php" method="post" enctype="multipart/form-data">
      <button type="submit" name="Aventa" id="Aventa" class="btn btn-success">Nueva Venta</button>
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#caja">Caja diaria</button>
    </form>
</div>

<br>

<h4 align="center">Ventas realizadas el dia: <?php echo $fecha_actual; ?></h4>

<table class="table table-hover" id="registros">
  <thead>
    <tr>
      <th scope="col">Num. de venta</th>
      <th scope="col">Fecha</th>
      <th scope="col">Total</th>
      <th scope="col">Cliente</th>
      <th scope="col">Usuario</th>
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

<?php 
  $query= " SELECT venta.usuario_cod,usuario.usuario_nom,venta_fecha, COUNT(venta.usuario_cod) tot
            FROM venta,usuario
            WHERE venta.usuario_cod=usuario.usuario_cod AND venta_fecha='$fecha_actual'
            GROUP BY usuario_cod ORDER BY tot DESC
            LIMIT 1
  ";
  $resultado=mysqli_query($link,$query);
  $datos=mysqli_fetch_assoc($resultado);
  $usuariodest=$datos['usuario_nom'];
?>

<h5>TOTAL = <?php echo $totaldia; ?></h5> 
<h5>Usuario destacado: 
  <?php 
    if ($usuariodest==""){
      $usuariodest="Aun no se realizo ninguna venta!";
    }
    echo $usuariodest; 
  ?>
  
</h5>


<!-- modal de caja -->

<div class="modal fade" id="caja"  aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i>Caja diaria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="venta2.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">

           <div class="row mb-3">
              <label class="col-sm-4" for="fecha">Caja diaria:</label>
              <div class="col-sm-8">
              <select name="fecha" id="fecha" class="form-control" aria-label="Default select example"  onchange="fecha()" required style="width: 100%;">
              <option value="">Seleccione fecha</option>
              <?php
                $query = mysqli_query($link, "SELECT DISTINCT venta_fecha FROM venta ORDER BY venta_fecha DESC")
                 or die(mysqli_error($link));
                while ($valores = mysqli_fetch_array($query)) {
                  echo '<option value="'.$valores[venta_fecha].'">'.$valores[venta_fecha].'</option>';
                }
              ?>
              </select>
              </div>
           </div>
        
          </div>
          <div class="modal-footer">
            <button type="submit" name="Tfecha" class="btn btn-success">Ver</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>


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
      <form action="../libreria/lib_venta.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar la venta? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="venta_codB" id="venta_codB">
            <button type="submit" name="Bventa" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal seleccion fecha -->

<div class="modal fade" id="ventatotal" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seleccione Fecha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
             <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="fecha">Fecha:</label>
                  <div class="col-sm-8">
                    <select name="fecha" id="fecha" class="form-control" aria-label="Default select example" required >
                         <option value="">Seleccione Fecha:</option>
                          <?php
                            $query = mysqli_query($link, "SELECT venta_cod,venta_fecha FROM venta ORDER BY venta_fecha ASC")
                             or die(mysqli_error($link));
                            while ($valores = mysqli_fetch_array($query)) {
                              echo '<option value="'.$valores[venta_cod].'">'.$valores[venta_fecha].'</option>';
                            }
                          ?>
                    </select>
                  </div>
                 </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="Bfecha" onclick="window.open('../generadorpdf/pdfventa.php')">Ver</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>


<script>
    function delReg(venta_cod){
        document.getElementById('venta_codB').value = venta_cod; 
    }    

  
   function fecha(){
     var f=document.getElementById('venta_cod').value;
     document.getElementById('fecha').value=f;
     alert (f);
     document.getElementById('fecha').value=f;
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
