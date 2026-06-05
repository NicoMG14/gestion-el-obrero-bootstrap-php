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
    $query = "SELECT * FROM rubro";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $rubro_cod = $datos['rubro_cod'];
                $rubro_desc = $datos['rubro_desc'];
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$rubro_desc</td>";            
                $parametros= "$rubro_cod,'$rubro_desc'";     
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#modificar\" onclick=\"editReg(".$parametros.")\"><i class=\"text-warning bi bi-pencil\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$rubro_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
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
    <title>Rubros</title>
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
<h3 align="center">Administracion de Productos</h3>
<br>


<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-outline-primary" onclick="location.href='producto.php'">Productos</button>
  <button type="button" class="btn btn-outline-primary" onclick="location.href='proveedor.php'">Proveedor</button>
  <button type="button" class="btn btn-outline-primary" onclick="location.href='rubro.php'">Rubros</button>
</div>

<br/><br/>

<div class="">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta">Agregar Rubro</button>
</div>

<br>
<h4 align="center">Rubros</h4>

<table class="table table-hover" id="registros">
  <thead>
    <tr>
      <th scope="col">Descripcion</th>
      <th scope="col">Modificar</th>
      <th scope="col">Borrar</th>
    </tr>
  </thead>
  <!-- Carga de datos -->
  <tbody>
    <?php
        echo $tabla_filas;
    ?>
  </tbody>
</table>


<!-- modal para nuevo registro -->

<div class="modal fade" id="alta" tabindex="-1" aria-labelledby="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese Rubro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_rubro.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="rubro_desc">Descripcion:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="rubro_desc" id="rubro_desc" placeholder="Ingrese descripcion" required>
              </div>
           </div>
                
        
        </div>
          <div class="modal-footer">
            <button type="submit" name="Arubro" class="btn btn-success">Guardar</button>
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
      <form action="../libreria/lib_rubro.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="rubro_codE" id="rubro_codE">
        <div class="modal-body">
         
             <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="rubro_descE">Descripcion:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="rubro_descE" id="rubro_descE" placeholder="" required>
              </div>
           </div>
       
        </div>
          <div class="modal-footer">
            <button type="submit" name="Mrubro" id="Mrubro" class="btn btn-success">Modificar</button>
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
      <form action="../libreria/lib_rubro.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar el rubro? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="rubro_codB" id="rubro_codB">
            <button type="submit" name="Brubro" class="btn btn-success">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>



<script>
    function editReg(rubro_cod,rubro_desc){
        document.getElementById('rubro_codE').value = rubro_cod;
        document.getElementById('rubro_descE').value =rubro_desc;

    }

     function delReg(rubro_cod){
        document.getElementById('rubro_codB').value = rubro_cod; 
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
