<!DOCTYPE html >
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5, CSS, Javascript">
    <link href="../css/bootstrap.css" rel="stylesheet" >
    <link href="../css/bootstrap_icons/bootstrap-icons.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
    <title>Ingreso al sistema</title>
  </head>
  <body>
<div class="container">
<br>


<br>
<br>
<br>
<br>
<br>
<br>
<div class="row justify-content-center h-100 align-items-center">
<div class="card border-primary mb-3" align="" style="max-width: 15rem;">
  <div class="card-header">Ingrese datos de usuario</div>
  <div class="card-body">
  <form action="../libreria/lib_login.php" method="post" name="frmAcceso" id="frmAcceso">
   <div class="form-group">
   <label class="col-form-label mt-4" for="inputDefault"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">DNI:</font></font></label>
    <input type="text" class="form-control" placeholder="Ingrese DNI" id="usuario_dni" name="usuario_dni" required>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1" class="form-label mt-4"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Contraseña:</font></font></label>
      <input type="password" class="form-control" id="usuario_clave" name="usuario_clave" placeholder="Ingrese contraseña" required>
    </div>
    <br>
    <input type="submit" class="btn btn-success" name="btnIngresar" id="btnIngresar" value="Ingresar">
    <input type="button" class="btn btn-danger" name="btnAtras" id="btnAtras" value="Atras" onclick="location.href='../index.php'">
  </form>
  </div>
</div>
</div>

 
    <script>
      
    </script>
</div>
</body>
</html>