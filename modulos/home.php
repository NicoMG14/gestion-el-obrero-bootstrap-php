<?php
  session_start();
  if (!isset($_SESSION['usuario_dni'])) {
    header("Location:login.php");
    session_destroy();
    exit();
  }
?>
<!DOCTYPE html >
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="keywords" content="HTML5, CSS, Javascript">
    <link href="../css/bootstrap.css" rel="stylesheet" >
    <link href="../css/bootstrap_icons/bootstrap-icons.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/sha1.js"></script>
		<title>Bienvenido</title>
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
<h1 align="center">Bienvenido/a <?php echo $_SESSION['usuario_nom']?> a Sanitarios El Obrero</h1>

<div class="d-flex justify-content-center">
    <img  src="../imagenes/logo3.png " width="1200" height="600" alt="">
</div>

</div>
	</body>
</html>
