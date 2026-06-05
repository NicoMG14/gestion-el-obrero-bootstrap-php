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
    $query = "SELECT * FROM proveedor";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $proveedor_cod = $datos['proveedor_cod'];
                $proveedor_nom = $datos['proveedor_nom'];
                $proveedor_email = $datos['proveedor_email'];
                $proveedor_telef = $datos['proveedor_telef'];
                $proveedor_cbu = $datos['proveedor_cbu'];
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$proveedor_nom</td>";
                $tabla_filas .= "<td>$proveedor_email</td>";
                $tabla_filas .= "<td>$proveedor_telef</td>";
                $tabla_filas .= "<td>$proveedor_cbu</td>";       
                $parametros= "$proveedor_cod,'$proveedor_nom','$proveedor_email',$proveedor_telef,'$proveedor_cbu'";     
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#modificar\" onclick=\"editReg(".$parametros.")\"><i class=\"text-warning bi bi-pencil\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$proveedor_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
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
    <title>Proveedor</title>
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
   <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta">Agregar Proovedor</button>
</div>

<br>
<h4 align="center">Proveedores</h4>

<table class="table table-hover" id="registros">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Email</th>
      <th scope="col">Telefono</th>
      <th scope="col">CBU/Alias</th>
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

	</body>
</html>


<!-- modal para nuevo registro -->

<div class="modal fade" id="alta" tabindex="-1" aria-labelledby="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese datos de Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_proveedor.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_nom">Nombre:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="proveedor_nom" id="proveedor_nom" placeholder="Ingrese nombre" required>
              </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_email">Email:</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" name="proveedor_email" id="proveedor_email" step="0.01" placeholder="Ingrese email" required>
              </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_telef">Telefono:</label>
              <div class="col-sm-9">
                <input type="number" step="" class="form-control" name="proveedor_telef" id="proveedor_telef" placeholder="Ingrese telefono" required>
              </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_cbu">CBU/Alias:</label>
              <div class="col-sm-9">
                <input type="text" step="" class="form-control" name="proveedor_cbu" id="proveedor_cbu" placeholder="Ingrese CBU o Alias" required>
              </div>
           </div>
          
        
        </div>
          <div class="modal-footer">
            <button type="submit" name="Aproveedor" class="btn btn-success">Guardar</button>
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
      <form action="../libreria/lib_proveedor.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="proveedor_codE" id="proveedor_codE">
        <div class="modal-body">
         
             <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_nomE">Nombre:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="proveedor_nomE" id="proveedor_nomE" placeholder="" required>
              </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_emailE">Email:</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" name="proveedor_emailE" id="proveedor_emailE" step="0.01" placeholder="" required>
              </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_telefE">Telefono:</label>
              <div class="col-sm-9">
                <input type="number" step="" class="form-control" name="proveedor_telefE" id="proveedor_telefE" placeholder="" required>
              </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="proveedor_cbuE">CBU/Alias:</label>
              <div class="col-sm-9">
                <input type="text" step="" class="form-control" name="proveedor_cbuE" id="proveedor_cbuE" placeholder="" required>
              </div>
           </div>
          

        </div>
          <div class="modal-footer">
            <button type="submit" name="Mproveedor" id="Mproveedor" class="btn btn-success">Modificar</button>
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
      <form action="../libreria/lib_proveedor.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar el proveedor? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="proveedor_codB" id="proveedor_codB">
            <button type="submit" name="Bproveedor" class="btn btn-success">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>




<script>
    function editReg(proveedor_cod,proveedor_nom,proveedor_email,proveedor_telef,proveedor_cbu){
        document.getElementById('proveedor_codE').value = proveedor_cod;
        document.getElementById('proveedor_nomE').value =proveedor_nom;
        document.getElementById('proveedor_emailE').value =proveedor_email;
        document.getElementById('proveedor_telefE').value =proveedor_telef;
        document.getElementById('proveedor_cbuE').value =proveedor_cbu;
    }

    function delReg(proveedor_cod){
        document.getElementById('proveedor_codB').value = proveedor_cod; 
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
