<?php
session_start();
  if (!isset($_SESSION['usuario_dni'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }
include ("../libreria/conexion.php");

$inhabilitado=""; //restringir botones por admin
if ($_SESSION['usuario_dni']==12345678){
  $inhabilitado="";  
}else{    
  $inhabilitado="disabled";
}


$m=$_GET['m'];
$mensaje="";
if ($m=="si"){
  $mensaje="Encontrado";
  $m="";
  echo "<script> 
         var modal='true';
        </script>";
}
if ($m=="no"){
   $mensaje="¡No posee permiso para realizar esta accion!";
   $m="";
   echo "<script> alert('".$mensaje."'); </script>";
}

$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT * FROM usuario";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $usuario_cod = $datos['usuario_cod'];
                $usuario_nom = $datos['usuario_nom'];
                $usuario_dni = $datos['usuario_dni'];
                $usuario_telef = $datos['usuario_telef'];
                $usuario_cbu = $datos['usuario_cbu'];     
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$usuario_nom</td>"; 
                $tabla_filas .= "<td>$usuario_dni</td>";
                $tabla_filas .= "<td>$usuario_telef</td>";
                $tabla_filas .= "<td>$usuario_cbu</td>";    
                $parametros= "$usuario_cod,'$usuario_nom',$usuario_dni,$usuario_telef,'$usuario_cbu'";       
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#modificar\" onclick=\"editReg(".$parametros.")\"><i class=\"text-warning bi bi-pencil\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$usuario_cod.")\" ><i class=\"text-danger bi bi-trash\"></i></a></td>";
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
    <title>Usuarios</title>
    <script>
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
<h3 align="center">Administracion de Usuarios</h3>
<br>

<div class="">
    <button type="button" class="btn btn-success" data-bs-toggle="modal"  data-bs-target="#alta" <?php echo "$inhabilitado";?> >Agregar Usuario</button>
</div>

<br>
<h4 align="center">Usuarios</h4>

<table class="table table-hover" id="registros">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">DNI</th>
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



<!-- modal para nuevo registro -->

<div class="modal fade" id="alta" tabindex="-1" aria-labelledby="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese Datos de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_usuario.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="usuario_nom">Nombre:</label>
              <div class="col-sm-8">
              <input type="text" class="form-control" name="usuario_nom" id="usuario_nom" placeholder="" required>
            </div>
           </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="usuario_dni">DNI:</label>
              <div class="col-sm-8">
              <input type="number" class="form-control" name="usuario_dni" id="usuario_dni"laceholder="" required>
            </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="usuario_clave">Clave:</label>
              <div class="col-sm-8">
              <input type="password" class="form-control" name="usuario_clave" id="usuario_clave" placeholder="" required>
            </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="usuario_telef">Telefono:</label>
              <div class="col-sm-8">
              <input type="number" class="form-control" name="usuario_telef" id="usuario_telef" placeholder="" required>
            </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="usuario_cbu">CBU/Alias:</label>
              <div class="col-sm-8">
              <input type="text" class="form-control" name="usuario_cbu" id="usuario_cbu" placeholder="" required>
            </div>
           </div>
        </div>
          <div class="modal-footer">
            <button type="submit" name="Ausuario" id="Ausuario" class="btn btn-success">Guardar</button>
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
      <form action="../libreria/lib_usuario.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario_codE" id="usuario_codE">
        <div class="modal-body">
         
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="usuario_nomE">Nombre:</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" name="usuario_nomE" id="usuario_nomE" placeholder="" >
            </div>
           </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="usuario_dniE">DNI:</label>
              <div class="col-sm-9">
              <input type="number" class="form-control" name="usuario_dniE" id="usuario_dniE"laceholder=""  readonly="">
            </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="usuario_telefE">Telefono:</label>
              <div class="col-sm-9">
              <input type="number" class="form-control" name="usuario_telefE" id="usuario_telefE" placeholder="" >
            </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="usuario_cbuE">CBU/Alias:</label>
              <div class="col-sm-9">
              <input type="text" class="form-control" name="usuario_cbuE" id="usuario_cbuE" placeholder="" >
            </div>
           </div>
        </div>
          <div class="modal-footer">
            <button type="submit" name="Musuario" id="Musuario" class="btn btn-success">Modificar</button>
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
      <form action="../libreria/lib_usuario.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar el usuario? 
        </div>
          <div class="modal-footer">
            <input type="hidden" name="usuario_codB" id="usuario_codB">
            <button type="submit" name="Busuario" class="btn btn-success">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>



<script>
    function editReg(usuario_cod,usuario_nom,usuario_dni,usuario_telef,usuario_cbu){
        document.getElementById('usuario_codE').value = usuario_cod;
        document.getElementById('usuario_nomE').value =usuario_nom;
        document.getElementById('usuario_dniE').value =usuario_dni;
        document.getElementById('usuario_telefE').value =usuario_telef;
        document.getElementById('usuario_cbuE').value =usuario_cbu;
    }

    function delReg(usuario_cod){
        document.getElementById('usuario_codB').value = usuario_cod; 
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