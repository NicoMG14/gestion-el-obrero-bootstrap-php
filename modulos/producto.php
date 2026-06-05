<?php
session_start();
  if (!isset($_SESSION['usuario_nom'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }

include ("../libreria/conexion.php");

$m=$_GET['m'];
$mensaje="";
$p=$_GET['p'];

if ($m=="nomed"){
   $mensaje="¡La cantidad de los productos por UNIDAD no pueden llevar decimales!";
   echo "<script> alert('".$mensaje."'); </script>";
   $mensaje="";
}

if (is_numeric($p)){
    echo "<script> var detalle=true; </script>";
  }

$tabla_filas="";
$fila_class=" class='table-active'";
if($conexion=="si"){
    $query = "SELECT fecha_mod,producto_cod,producto_desc,producto_precio,producto_cant,producto_cantmin,producto_med,producto_foto,producto.proveedor_cod,proveedor.proveedor_nom,producto.rubro_cod,rubro.rubro_desc FROM producto
INNER JOIN proveedor
ON producto.proveedor_cod = proveedor.proveedor_cod
INNER JOIN rubro
ON producto.rubro_cod = rubro.rubro_cod
ORDER BY producto_cod ASC
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
                $producto_med = $datos['producto_med'];
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto=='0'){
                  $producto_foto = 'Sin archivo';
                }else{
                  $producto_foto= $datos['producto_foto'];
                }
                $proveedor_nom = $datos['proveedor_nom'];
                $rubro_desc = $datos['rubro_desc'];
                $proveedor_cod = $datos['proveedor_cod'];
                $rubro_cod = $datos['rubro_cod'];
                if($fila_class==" class='table-active'"){
                    $fila_class="";
                }else{
                    $fila_class=" class='table-active'";
                }
                // continuar desde aquí
                $tabla_filas .= "<tr $fila_class>";
                //$tabla_filas .= "<td>$id</td>";
                $tabla_filas .= "<td>$fecha_mod</td>";
                $tabla_filas .= "<td>$producto_cod</td>";
                $tabla_filas .= "<td><a href=\"producto.php?p=$producto_cod\">$producto_desc</a></td>";
                $tabla_filas .= "<td>$producto_precio</td>";
                $tabla_filas .= "<td>$producto_cant</td>";
                $tabla_filas .= "<td>$producto_cantmin</td>";
                $tabla_filas .= "<td>$producto_med</td>";
                $tabla_filas .= "<td>$producto_foto</td>";
                $tabla_filas .= "<td>$proveedor_nom</td>";
                $tabla_filas .= "<td>$rubro_desc</td>";     
                // parametros para modificar
                $parametros= "$producto_cod,'$producto_foto','$producto_desc',$producto_precio,$producto_cant,$producto_cantmin,'$producto_med',$proveedor_cod,$rubro_cod";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#modificar\" onclick=\"editReg(".$parametros.")\"><i class=\"text-warning bi bi-pencil\"></i></a></td>";
                $tabla_filas .= "<td><a href=\"\" data-bs-toggle=\"modal\" data-bs-target=\"#baja\" onclick=\"delReg(".$producto_cod.")\"><i class=\"text-danger bi bi-trash\" ></i></a></td>";
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
    <link rel="stylesheet" type="text/css" href="../css/select2.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../datatables/datatables.min.js"></script>
    <script src="../js/select2.js"></script>
    <title>Productos</title>
    
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
<br>
</br>

<div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#alta">Agregar Producto</button>
    <button type="button" class="btn btn-primary" onclick="location.href='presupuesto.php'">Emitir Presupuesto</button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inventario">Control de Inventario</button>
</div>

<br>
<h4 align="center">Productos</h4>

<div class="table-responsive">
    <table  id="registros" class="table table-hover">
        <thead>
        <tr class="table-type">
            <th scope="col">Fecha de Modificacion</th>
            <th scope="col">Codigo</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Precio</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Cantidad Minima</th>
            <th scope="col">Medida</th>
            <th scope="col">Foto</th>
            <th scope="col">Proveedor</th>
            <th scope="col">Rubro</th>
            <th scope="col">Modificar</th>
            <th scope="col">Borrar</th>
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

<div class="modal fade" id="inventario" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i>Control de Inventario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../generadorpdf/pdfinventario.php" method="post" enctype="multipart/form-data" target="_blank">
        <div class="modal-body">

           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="rubro_cod">Rubro:</label>
              <div class="col-sm-8">
                <select name="rubro_cod" id="rubro_cod" class="form-select" aria-label="Default select example" required style="width: 100%;">
                     <option value="">Seleccione rubro</option>
                      <?php
                        $query = mysqli_query($link, "SELECT rubro_cod,rubro_desc FROM rubro")
                          or die(mysqli_error($link));
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option value="'.$valores[rubro_cod].'">'.$valores[rubro_desc].'</option>';
                        }
                      ?>
                </select>
              </div>
           </div>
        
          </div>
          <div class="modal-footer">
            <button type="submit" name="rubro" class="btn btn-success">Ver</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal para nuevo registro -->

<div class="modal fade" id="alta" tabindex="-1" aria-labelledby="modalaltaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese datos de Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="../libreria/lib_producto.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          
           <div class="row mb-3">           
            <label class="col-sm-4 col-form-label" for="fecha_mod">Fecha:</label>
              <div class="col-sm-8">
                <input type="datetime" class="form-control" name="fecha_mod" id="fecha_mod" value="<?= $fecha_actual?>"placeholder="" readonly="" >
              </div>
           </div>
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_foto">Foto:</label>
              <div class="col-sm-8">
               
                <input type="file" step="" class="form-control" name="producto_foto" id="producto_foto" placeholder="Seleccione archivo">
              </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_desc">Descripcion:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="producto_desc" id="producto_desc" placeholder="Ingrese descripcion" required >
              </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_precio">Precio:</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="producto_precio" id="producto_precio" step="0.01" placeholder="Ingrese precio" required>
              </div>
           </div>
           
          <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_cant">Cantidad:</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" class="form-control" name="producto_cant" id="producto_cant" placeholder="Ingrese cantidad" required>
              </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_cantmin">Cantidad Minima:</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" class="form-control" name="producto_cantmin" id="producto_cantmin" placeholder="Ingrese cantidad minima" required>
              </div>
           </div>

           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_med">Medida:</label>
              <div class="col-sm-8">
                <select name="producto_med" id="producto_med" class="form-select" aria-label="Default select example" required >
                     <option value="">Seleccione medida</option>
                     <option value="Unidad">Unidad</option>
                     <option value="Metro">Metro</option>
                     <option value="Kilogramo">Kilogramo</option>
                     <option value="Litro">Litro</option>
                </select>
              </div>
           </div>           
          

           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="proveedor_cod">Proveedor:</label>
              <div class="col-sm-8">
                <select name="proveedor_cod" id="proveedor_cod" class="form-select" aria-label="Default select example" required >
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
             <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="rubro_cod">Rubro:</label>
              <div class="col-sm-8">
                <select name="rubro_cod" id="rubro_cod" class="form-select" aria-label="Default select example" required>
                     <option value="">Seleccione rubro</option>
                      <?php
                        $query = mysqli_query($link, "SELECT rubro_cod,rubro_desc FROM rubro")
                          or die(mysqli_error($link));
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option value="'.$valores[rubro_cod].'">'.$valores[rubro_desc].'</option>';
                        }
                      ?>
                </select>
              </div>
           </div>
        
          </div>
          <div class="modal-footer">
            <button type="submit" name="Aproducto" class="btn btn-success">Guardar</button>
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
      <form action="../libreria/lib_producto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="producto_codE" id="producto_codE">

        <div class="modal-body">
            <div class="row mb-3">
                  <label class="col-sm-4 col-form-label" for="fecha_modE">Fecha:</label>
                 <div class="col-sm-8">
                  <input type="datetime" class="form-control" name="fecha_modE" id="fecha_modE" value="<?= $fecha_actual?>"placeholder="" readonly="" >
                 </div>
            </div>

            <div class="row mb-3" style="height: 81px;">
              <label class="col-sm-4 col-form-label" for="producto_fotoE">Foto:</label>
              <div class="col-sm-8">
               
                <input type="file" step="" class="form-control" name="producto_fotoE" id="producto_fotoE" placeholder="Seleccione archivo" style="height: 45%;">
                <input class="form-control" type="text" name="producto_fotoee" id="producto_fotoee" readonly style="height: 1%;">
              </div>
           </div>

           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_descE">Descripcion:</label>
             <div class="col-sm-8">
              <input type="text" class="form-control" name="producto_descE" id="producto_descE" placeholder="" required>
            </div>
           </div>
           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_precioE">Precio:</label>
             <div class="col-sm-8">
              <input type="number" class="form-control" name="producto_precioE" id="producto_precioE" step="0.01" placeholder="" required>
           </div>
         </div>
          <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_cantE">Cantidad:</label>
             <div class="col-sm-8">
              <input type="number" step="0.01" class="form-control" name="producto_cantE" id="producto_cantE" placeholder="" required>
            </div>
           </div>
          <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_cantminE">Cantidad Minima:</label>
             <div class="col-sm-8">
              <input type="number" step="0.01" class="form-control" name="producto_cantminE" id="producto_cantminE" placeholder="" required>
            </div>
           </div>


           <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="producto_medE">Medida:</label>
              <div class="col-sm-8">
                <select name="producto_medE" id="producto_medE" class="form-select" aria-label="Default select example" required >
                     <option value="">Seleccione medida</option>
                     <option value="Unidad">Unidad</option>
                     <option value="Metro">Metro</option>
                     <option value="Kilogramo">Kilogramo</option>
                     <option value="Litro">Litro</option>
                </select>
              </div>
           </div> 
                
  
            <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="proveedor_codE">Proveedor:</label>
              <div class="col-sm-8">
                <select name="proveedor_codE" id="proveedor_codE" class="form-select" aria-label="Default select example" required >
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
           
             <div class="row mb-3">
              <label class="col-sm-4 col-form-label" for="rubro_codE">Rubro:</label>
              <div class="col-sm-8">
              <select name="rubro_codE" id="rubro_codE" class="form-select" aria-label="Default select example" required>
                   <option value="">Seleccione rubro</option>
                    <?php
                      $query = mysqli_query($link, "SELECT rubro_cod,rubro_desc FROM rubro")
                        or die(mysqli_error($link));
                      while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="'.$valores[rubro_cod].'">'.$valores[rubro_desc].'</option>';
                      }
                    ?>
              </select>
            </div>
           </div>
        </div>
          <div class="modal-footer">
            <button type="submit" name="Mproducto" id="Mproducto" class="btn btn-success">Modificar</button>
            <button type="button" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
    </div>
     
  </div>
</div>

<!-- modal detalle-->

<div class="modal fade" id="detalle" tabindex="-1" aria-labelledby="modalbajaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i>Detalle de producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      
        <div class="modal-body">
                  
          <?php
          $query="SELECT producto_cod,producto_desc,producto_precio,producto_cant,producto_med,producto_foto,proveedor.proveedor_nom,rubro.rubro_desc FROM producto,proveedor,rubro where producto_cod=$p AND producto.proveedor_cod=proveedor.proveedor_cod AND producto.rubro_cod=rubro.rubro_cod";
          $resultado=mysqli_query($link,$query);
          $datos=mysqli_fetch_assoc($resultado);
          $producto_cod=$datos['producto_cod'];
          $producto_desc=$datos['producto_desc'];
          $producto_precio=$datos['producto_precio'];
          $producto_cant=$datos['producto_cant'];
          $producto_med=$datos['producto_med'];
          $producto_foto=$datos['producto_foto'];
          $proveedor_nom=$datos['proveedor_nom'];
          $rubro_desc=$datos['rubro_desc'];
          echo "
                <div class=\"col\">
                    <div class=\"card text-black bg-secondary mb-3\" >
                       <img src=\"../imagenes/".$producto_foto."\" class=\"card-img-top\" alt=\"...\" style=\"height:230px\">
                       <div class=\"text-end text-dark d-flex justify-content-end align-items-center m-2\">
                         <span class=\"rounded bg-light p-2 fs-5\">$".$producto_precio."</span>
                       </div>
                     <div class=\"card-body\">
                         <h5>Codigo: ".$producto_cod."</h5>
                         <h5>Descripcion: ".$producto_desc."</h5>
                         <h5>Cantidad: ".$producto_cant."</h5>
                         <h5>Medida: ".$producto_med."</h5>
                         <h5>Proveedor: ".$proveedor_nom."</h5>
                         <h5>Rubro: ".$rubro_desc."</h5>
                      </div>
                    </div>
              </div>";

          ?>
              
        </div>
     
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
      <form action="../libreria/lib_producto.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
           Desea eliminar este producto? 
          </div>
          <div class="modal-footer">
            <input type="hidden" name="producto_codB" id="producto_codB">
            <button type="submit" name="Bproducto" class="btn btn-success">Eliminar</button>
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

    function editReg(producto_cod,producto_foto,producto_desc,producto_precio,producto_cant,producto_cantmin,producto_med,proveedor_cod,rubro_cod){
        $('#producto_codE').val(producto_cod);
        $('#producto_fotoee').val(producto_foto);
        $('#producto_descE').val(producto_desc);
        $('#producto_precioE').val(producto_precio);
        $('#producto_cantE').val(producto_cant);
        $('#producto_cantminE').val(producto_cantmin);
        $('#producto_medE').val(producto_med);
        $('#proveedor_codE').val(proveedor_cod);
        $('#rubro_codE').val(rubro_cod);
    }
    
    if (detalle==true){
      $( document ).ready(function() {
       $('#detalle').modal('toggle')
      });
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
