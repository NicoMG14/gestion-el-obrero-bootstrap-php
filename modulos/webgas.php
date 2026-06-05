<?php

include ("../libreria/conexion.php");
$indexmodelo=0;
if($conexion=="si"){
    $query="SELECT * FROM producto WHERE rubro_cod=13";
    if ($result=mysqli_query($link,$query)){
        $rowcont=mysqli_num_rows($result);
        if ($rowcont>0){
            while ($datos=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                if ($datos['producto_foto']!="0"){
                    $arraymodelo[$indexmodelo]['producto_cod']=$datos['producto_cod'];
                    $arraymodelo[$indexmodelo]['producto_desc']=$datos['producto_desc'];
                    $arraymodelo[$indexmodelo]['producto_precio']=$datos['producto_precio'];
                    $arraymodelo[$indexmodelo]['producto_foto']=$datos['producto_foto'];
                    $indexmodelo++;
                }
            }
            mysqli_free_result($result);
        }
    }
}
?>


<!DOCTYPE html >
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="keywords" content="HTML5, CSS, Javascript">
    <script src="../js/bootstrap.bundle.js"></script>
    <link href="../css/solar.css" rel="stylesheet">
    <script src="../js/sha1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../web/layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <title>Accesorios de Gas</title>

    
    </head>

<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay padtop" style="background-image:url('../web/images/obrero.png');"> 
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <header id="header" class="hoc clear">
    <div id="logo" class="fl_left"> 
      <!-- ################################################################################################ -->
      
        <a class="navbar-brand" href="../index.php">
          <img src="../web/images/logo1.png" class="img-fluid" alt="">
        </a>
      
      <!-- ################################################################################################ -->
    </div>
    <nav id="mainav" class="fl_right"> 
      <!-- ################################################################################################ -->
      <ul class="clear">
        <li><a href="../index.php">Inicio</a></li>
        <li><a href="weboferta.php">Ofertas</a></li>
        <li class=""><a class="drop" href="#">Productos</a>
          <ul>
            <li><a href="webagua.php">Accesorios de Agua</a></li>
            <li><a href="webgas.php">Accesorios de Gas</a></li>
            <li><a href="webluz.php">Accesorios de Electricidad</a></li>
            <li><a href="webherramienta.php">Herramientas</a></li>
            <li><a href="webpintura.php">Pinturas</a></li>
          </ul>
        </li>
        <li><a href="webcontacto.php">Contacto</a></li>
        <li>
          <a class="" href="home.php"><button type="button" class="btn btn-outline-success">Administracion</button></a>
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
 <div align="center">
        <h3>Accesorios de Gas</h3>
    </div>
    
     <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 my-5">
        <?php 

            for($i=0;$i<$indexmodelo;$i++){
                $producto_cod=$arraymodelo[$i]['producto_cod'];
                $producto_desc=$arraymodelo[$i]['producto_desc'];
                $producto_precio=$arraymodelo[$i]['producto_precio'];
                $producto_foto=$arraymodelo[$i]['producto_foto'];
                echo "
                <div class=\"col\">
                    <div class=\"card text-white bg-warning mb-3\" style=\"width: 20rem\">
                       <img src=\"../imagenes/".$producto_foto."\" class=\"card-img-top\" alt=\"...\" style=\"height:230px\">
                       <div class=\"text-end text-dark d-flex justify-content-end align-items-center m-2\">
                         <span class=\"rounded bg-light p-2 fs-5\">$".$producto_precio."</span>
                       </div>
                     <div class=\"card-body\">
                         <h10 class=\"card-title\">".Descripcion.":</h10>
                         <h5 class=\"card-text\">".$producto_desc."</h5>
                      </div>
                    </div>
              </div>";
            }
        ?> 
        
    </div>

    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
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
<script src="../web/layout/scripts/jquery.min.js"></script>
<script src="../web/layout/scripts/jquery.backtotop.js"></script>
<script src="../web/layout/scripts/jquery.mobilemenu.js"></script>

    </body>
</html>

