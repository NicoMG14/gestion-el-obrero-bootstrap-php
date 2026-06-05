<?php
include ("libreria/conexion.php");
?>
<!DOCTYPE html >
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="keywords" content="HTML5, CSS, Javascript">
    <script src="js/bootstrap.bundle.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" >
    <script src="js/sha1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="web/layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
		<title>Sanitarios El Obrero</title>

    
	</head>

<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay padtop" style="background-image:url('web/images/obrero.png');"> 
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <header id="header" class="hoc clear">
    <div id="logo" class="fl_left"> 
      <!-- ################################################################################################ -->
      
        <a class="navbar-brand" href="index.php">
          <img src="web/images/logo1.png" class="img-fluid" alt="">
        </a>
      
      <!-- ################################################################################################ -->
    </div>
    <nav id="mainav" class="fl_right"> 
      <!-- ################################################################################################ -->
      <ul class="clear">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="modulos/weboferta.php">Ofertas</a></li>
        <li class=""><a class="drop" href="#">Productos</a>
          <ul>
            <li><a href="modulos/webagua.php">Accesorios de Agua</a></li>
            <li><a href="modulos/webgas.php">Accesorios de Gas</a></li>
            <li><a href="modulos/webluz.php">Accesorios de Electricidad</a></li>
            <li><a href="modulos/webherramienta.php">Herramientas</a></li>
            <li><a href="modulos/webpintura.php">Pinturas</a></li>
          </ul>
        </li>
        <li><a href="modulos/webcontacto.php">Contacto</a></li>
        <li>
          <a class="" href="modulos/home.php"><button type="button" class="btn btn-outline-success">Administracion</button></a>
        </li>
      </ul>
      <!-- ################################################################################################ -->
    </nav>
  </header>
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <div id="pageintro" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <article>
      <h3 class="heading">Sanitarios El Obrero</h3>
      <p>Posee una amplia variedad de productos para la construccion del hogar.</p>
    </article>
    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row1">
  <section id="ctdetails" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <ul class="nospace clear">
      <li class="one_quarter first">
        <div class="block clear"><a><i class="fas fa-phone"></i></a> <span><strong>Llámanos:</strong> 0388-4233906</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a><i class="fas fa-envelope"></i></a> <span><strong>Escríbenos:</strong> elobrero03@gmail.com</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a><i class="fas fa-clock"></i></a> <span><strong> Lunes a Sabados:</strong> 08.30 - 12.30 y 16.00 - 20.00pm</span></div>
      </li>
      <li class="one_quarter">
        <div class="block clear"><a><i class="fas fa-map-marker-alt"></i></a> <span><strong>Visítanos:</strong> Como llegar a <a href="https://www.google.com.ar/maps/place/Av.+Dr.+Horacio+Guzm%C3%A1n+221,+Y4600+San+Salvador+de+Jujuy,+Jujuy/@-24.194922,-65.3030227,19z/data=!3m1!4b1!4m5!3m4!1s0x941b0f4f38920981:0x2e509503600ea3fc!8m2!3d-24.1949232!4d-65.3024755" target="_blank">nuestra ubicación</a></span></div>
      </li>
    </ul>
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <section id="services">
      <div class="sectiontitle">
        <h3 class="heading">Nuestros Productos</h3>
        <p>Trabajamos con las mejores marcas</p>
      </div>

      


      <ul class="nospace group grid-3">
        <li class="one_third">
          <article>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/oferta.jpg" class="d-block w-100" style="width: 500px; height: 200px;">
    </div>
    
      <?php 
        $query = "SELECT oferta.producto_cod,producto.producto_foto FROM oferta,producto WHERE oferta.producto_cod = producto.producto_cod";
        if ($resultado = mysqli_query($link, $query)){
          $rowcont = mysqli_num_rows($resultado);
          if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto != '0'){
                  echo "
                  <div class='carousel-item'>
                  <img src='imagenes/$producto_foto' class='d-block w-100' style='width: 500px; height: 200px;'>
                  </div>";
                }   
            }
          }
        }
      ?>
    
  </div>
</div>
            <h6 class="heading">Ofertas</h6>
            <p>Las mejores ofertas del mercado. Aprovecha y ahorra! Sin duda la mejor compra que hará.</p>
            <footer><a href="modulos/weboferta.php">Vas Más &raquo;</a></footer>
          </article>
        </li>
        <li class="one_third">
          <article>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/accaguaa.jpg" class="d-block w-100" style="width: 500px; height: 200px;">
    </div>
    
      <?php 
        $query = "SELECT producto_foto FROM producto WHERE rubro_cod=12";
        if ($resultado = mysqli_query($link, $query)){
          $rowcont = mysqli_num_rows($resultado);
          if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto != '0'){
                  echo "
                  <div class='carousel-item'>
                  <img src='imagenes/$producto_foto' class='d-block w-100' style='width: 500px; height: 200px;'>
                  </div>";
                }   
            }
          }
        }
      ?>
    
  </div>
</div>

            <h6 class="heading">Accesorios de agua</h6>
            <p>Todo para la instalacion domiciliaria IPS, bronce y fusion, productos cloacáles, y fluviáles, griferías, piletas, mangueras.</p>
            <footer><a href="modulos/webagua.php">Ver Mas &raquo;</a></footer>
          </article>
        </li>

        <li class="one_third">
          <article>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/accgas.jpg" class="d-block w-100" style="width: 500px; height: 200px;">
    </div>
    
      <?php 
        $query = "SELECT producto_foto FROM producto WHERE rubro_cod=13";
        if ($resultado = mysqli_query($link, $query)){
          $rowcont = mysqli_num_rows($resultado);
          if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto != '0'){
                  echo "
                  <div class='carousel-item'>
                  <img src='imagenes/$producto_foto' class='d-block w-100' style='width: 500px; height: 200px;'>
                  </div>";
                }   
            }
          }
        }
      ?>
    
  </div>
</div>
            <h6 class="heading">Accesorios de gas</h6>
            <p>Compra seguro! Ofrecemos productos en epoxi y fusion, aprobado y verificado para su correcta instalacion.</p>
            <footer><a href="modulos/webgas.php">Ver Mas &raquo;</a></footer>
          </article>
        </li>

        <li class="one_third">
          <article>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/accluz.jpeg" class="d-block w-100" style="width: 500px; height: 200px;">
    </div>
    
      <?php 
        $query = "SELECT producto_foto FROM producto WHERE rubro_cod=14";
        if ($resultado = mysqli_query($link, $query)){
          $rowcont = mysqli_num_rows($resultado);
          if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto != '0'){
                  echo "
                  <div class='carousel-item'>
                  <img src='imagenes/$producto_foto' class='d-block w-100' style='width: 500px; height: 200px;'>
                  </div>";
                }   
            }
          }
        }
      ?>
    
  </div>
</div>
            <h6 class="heading">Accesorios de electricidad</h6>
            <p>Los mejores precios en cables homologados, productos homeplast, no lo encontrarás en otro lugar.</p>
            <footer><a href="modulos/webluz.php">Ver Mas &raquo;</a></footer>
          </article>
        </li>

        <li class="one_third">
          <article>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/accherramienta.jpg" class="d-block w-100" style="width: 500px; height: 200px;">
    </div>
    
      <?php 
        $query = "SELECT producto_foto FROM producto WHERE rubro_cod=15";
        if ($resultado = mysqli_query($link, $query)){
          $rowcont = mysqli_num_rows($resultado);
          if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto != '0'){
                  echo "
                  <div class='carousel-item'>
                  <img src='imagenes/$producto_foto' class='d-block w-100' style='width: 500px; height: 200px;'>
                  </div>";
                }   
            }
          }
        }
      ?>
    
  </div>
</div>
            <h6 class="heading">Herramientas</h6>
            <p>Encontra las mejores herramientas de marcas nacionales e importadas, fabricadas para uso intensivo o del hogar.</p>
            <footer><a href="modulos/webherramienta.php">Ver mas &raquo;</a></footer>
          </article>
        </li>

        <li class="one_third">
          <article>
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imagenes/accpintura.jpg" class="d-block w-100" style="width: 500px; height: 200px;">
    </div>
    
      <?php 
        $query = "SELECT producto_foto FROM producto WHERE rubro_cod=16";
        if ($resultado = mysqli_query($link, $query)){
          $rowcont = mysqli_num_rows($resultado);
          if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_foto = $datos['producto_foto'];
                if ($producto_foto != '0'){
                  echo "
                  <div class='carousel-item'>
                  <img src='imagenes/$producto_foto' class='d-block w-100' style='width: 500px; height: 200px;'>
                  </div>";
                }   
            }
          }
        }
      ?>
    
  </div>
</div>
            <h6 class="heading">Pinturas</h6>
            <p>Los mejores productos para la decoracion del hogar. Pinturas latex, sinteticas, impermeables e impregnantes.</p>
            <footer><a href="modulos/webpintura.php">Ver Mas &raquo;</a></footer>
          </article>
        </li>
      </ul>
    </section>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="bgded overlay" style="background-image:url('images/demo/backgrounds/01.png');">
  <section class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <article id="points" class="group">
      <div class="two_third first">
        <h6 class="heading">Nosotros</h6>
        <p>Sanitarios El Obrero, tuvo su origen en el año 1997, empezando con la venta de accesorios para instalacion sanitaria y gas. Con el tiempo fuimos incorporando nuevos rubros, los cuales hoy forman una amplia y surtida línea de productos.
        <br>
        En la actualidad, poseemos una gran variedad de productos a la venta, entre los que se incluyen los rubros de luz, bulonería, cerrajería, repuestera, construccion, pinturas y de servicios entre otros.</p>
        <h6 class="heading">Ser un comercio ejemplar implica:</h6>
        <ul class="nospace group">
          <li><span>1</span> Buena relacion con los clientes</li>
          <li><span>2</span> Mejorar cada día</li>
          <li><span>3</span> Servicio de exelencia</li>
          <li><span>4</span> Brindar productos eficientes y eficaces</li>
          <li><span>5</span> Ser detallistas líderes en el mercado</li>
          <li><span>6</span> Proveer soluciones</li>
          <li><span>7</span> Manejar un surtido inventario</li>
          <li><span>8</span> Ser reconocidos como distribuidores</li>
        </ul>
      </div>
      <div class="one_third last"><a class="imgover" href="#"><img src="images/demo/348x394.png" alt=""></a></div>
    </article>
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ############################################################################################### -->
    <p class="fl_left">2022 - Todos los derechos reservados <a href="https://www.facebook.com/SelObrero/" target="_blank">Sanitarios El Obrero</a></p>
    <p class="fl_right">Pagina diseñada por <a target="_blank" href="https://www.facebook.com/nicolo.giron/" target="_blank" >Giron Nicolas M.</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="web/layout/scripts/jquery.min.js"></script>
<script src="web/layout/scripts/jquery.backtotop.js"></script>
<script src="web/layout/scripts/jquery.mobilemenu.js"></script>

	</body>
</html>

