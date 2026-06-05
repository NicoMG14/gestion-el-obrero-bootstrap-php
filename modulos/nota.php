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
    $query = "SELECT nota_cod,nota_fecha,nota_total,nota_estado,venta_cod,usuario.usuario_nom FROM notadecredito,usuario WHERE notadecredito.usuario_cod=usuario.usuario_cod ORDER BY nota_cod ASC";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $nota_cod = $datos['nota_cod'];
                $nota_fecha = $datos['nota_fecha'];
                $nota_total = $datos['nota_total'];
                $nota_estado = $datos['nota_estado'];
                if ($nota_estado==1){
                  $nota_estado='Activo';
                }else{
                  $nota_estado='Inactivo';
                }
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                $venta_cod = $datos['venta_cod'];
                $usuario_nom = $datos['usuario_nom'];
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$nota_cod</td>";
                $tabla_filas .= "<td>$nota_fecha</td>"; 
                $tabla_filas .= "<td>$nota_total</td>"; 
                $tabla_filas .= "<td>$nota_estado</td>"; 
                $tabla_filas .= "<td>$venta_cod</td>"; 
                $tabla_filas .= "<td>$usuario_nom</td>";   
                $parametros= "$nota_cod,'$nota_estado'";
                // $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#modificar\" onclick=\"editReg(".$parametros.")\"><i class=\"text-warning bi bi-pencil\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" onclick=\"window.open('../generadorpdf/pdfnota.php?nota=".$nota_cod."')\"><i class=\"text-primary bi bi-printer\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\"onclick=\"delReg(".$nota_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
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
    <title>Notas de Credito</title>
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
<h3 align="center">Administracion Notas de Credito</h3>
<br>


    <div>
    <form action="../libreria/lib_nota.php" method="post" enctype="multipart/form-data">
        <button type="submit" name="Anota" id="Anota" class="btn btn-success">Nueva Nota de Credito</button>
    </form>
    </div>
<br>

<h4 align="center">Notas de Credito Realizadas</h4>

<table class="table table-hover" id="registros">
  <thead>
    <tr>
      <th scope="col">Num. de Nota</th>
      <th scope="col">Fecha</th>
      <th scope="col">Total</th>
      <th scope="col">Estado</th>
      <th scope="col">Num. de Venta</th>
      <th scope="col">Usuario</th>
      <!-- <th scope="col">Editar</th> -->
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

<!-- modal para nuevo registro -->

<div class="modal fade" id="alta" tabindex="-1" aria-labelledby="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese Datos para Nota de Credito</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_nota.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          
           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="nota_fecha">Fecha:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="nota_fecha" id="nota_fecha" value="<?= $fecha_actual?>" readonly="" >
              </div>
           </div>


           <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="nota_total">Total:</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" name="nota_total" id="nota_total" step="0.01" placeholder="">
              </div>
           </div>

           <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="nota_estado">Estado:</label>
            <div class="col-sm-9">
             <select name="nota_estado" id="nota_estado" class="form-control">
               <option>Seleccion estado</option>
               <option value="1">Activo</option>
               <option value="0">Inactivo</option>
             </select>
            </div>
          </div>   

          <div class="row mb-3">
                <label class="col-sm-3 form-label" for="venta_cod">Venta:</label>
                <div class="col-sm-9">
                <select name="venta_cod" id="venta_cod" class="form-control">
                     <option>Seleccione Venta:</option>
                        <?php
                            $query = mysqli_query($link, "SELECT venta_cod FROM venta")
                              or die(mysqli_error($link));
                            while ($valores = mysqli_fetch_array($query)) {
                              echo '<option value="'.$valores[venta_cod].'">'.$valores[venta_cod].'</option>';
                            }
                        ?>
                        
                </select>
              </div>
            </div>
            
            <input type="hidden" name="usuario_cod" id="usuario_cod" value="0">
        
        </div>
          <div class="modal-footer">
            <button type="submit" name="Anota" class="btn btn-success">Guardar</button>
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
      <form action="../libreria/lib_nota.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="nota_codM" id="nota_codM">
        <div class="modal-body">
            
          <div class="row mb-3">
            <label class="col-sm-4 col-form-label" for="compra_estado">Estado:</label>
            <div class="col-sm-8">
             <select name="nota_estadoM" id="nota_estadoM" class="form-control" required>
               <option value="1">Activo</option>
               <option value="0">Inactivo</option>
             </select>
            </div>
          </div>   

        </div>
          <div class="modal-footer">
            <button type="submit" name="MMnota" id="MMnota" class="btn btn-success">Modificar</button>
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
      <form action="../libreria/lib_nota.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar la Nota de Credito? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="nota_codB" id="nota_codB">
            <button type="submit" name="Bnota" class="btn btn-danger">Eliminar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>


<script>
    function delReg(nota_cod){
        document.getElementById('nota_codB').value = nota_cod;
    }    
     function editReg(nota_cod,nota_estado){
        document.getElementById('nota_codM').value = nota_cod;
        if (nota_estado=="Activo"){
          nota_estado=1;
        }else{
          nota_estado=0;
        };
        document.getElementById('nota_estadoM').value = nota_estado;
    
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