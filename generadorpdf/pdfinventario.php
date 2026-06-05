<?php
session_start();
include ('../libreria/conexion.php');
$usuario_nom=$_SESSION['usuario_nom'];
$rubro_cod=$_POST['rubro_cod'];

if($conexion=="si"){
    $query = "SELECT rubro_cod,rubro_desc FROM rubro 
              WHERE rubro_cod=$rubro_cod
             ";

    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);

        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $rubro_desc = $datos['rubro_desc'];
            
            }
        }
    }
}

// CONFIGURACIÓN PREVIA
require('../fpdf/fpdf.php');
$peso="$ ";//simbolo peso
$pdf = new FPDF('P','mm','A4'); // Tamaño tickt 80mm x 150 mm (largo aprox)
$pdf->SetMargins(25, 10 , 25);
$pdf->SetAutoPageBreak(true,10); 
$pdf->AddPage();


// CABECERA

$pdf->Image('../imagenes/logobn.png',30,20,30);
$pdf->Ln(15);
$pdf->SetFont('Helvetica','',20);
$pdf->Cell(150,4,'Sanitarios El Obrero',3,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Helvetica','',15);
$pdf->Cell(150,4,'Control de inventario',3,1,'C');
$pdf->Ln(3);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(60,4,"Usuario: $usuario_nom",0,1,'');
$pdf->Cell(60,4,"Fecha: $fecha_actual",0,1,'');
$pdf->Cell(60,4,"Rubro: $rubro_desc",0,1,'');
$pdf->Ln(3);

 


// COLUMNAS
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(17, 5, 'Codigo', 1,0,'');
$pdf->Cell(70, 5, 'Descripcion',1,0,'');
$pdf->Cell(25, 5, "Medida",1,0,'L');
$pdf->Cell(25, 5, 'Cant.',1,0,'');
$pdf->Cell(26, 5, 'Cant. Fisica',1,0,'L');
$pdf->Ln(5);
$pdf->Cell(54,0,'','T');
$pdf->Ln(1);
 

//PRODUCTOS

//consulta datos del detalle de la venta
$fila="";
if($conexion=="si"){
    $query = "SELECT producto_cod,producto_desc,rubro.rubro_desc,producto_cant,producto_med FROM producto,rubro 
              WHERE producto.rubro_cod=$rubro_cod AND producto.rubro_cod=rubro.rubro_cod

              ORDER BY producto_cod ASC

             ";


    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);

        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $producto_cant = $datos['producto_cant'];
                $producto_med = $datos['producto_med'];

                $pdf->SetFont('Helvetica', '', 12);
                $pdf->Cell(17, 5, "$producto_cod", 1,0,'');
                $pdf->Cell(70, 5, "$producto_desc",1,0,'');
                $pdf->Cell(25, 5, "$producto_med",1,0,'L');
                $pdf->Cell(25, 5, "$producto_cant",1,0,'L');
                $pdf->Cell(26, 5, '',1,0,'L');
                $pdf->Ln(5);
            }
        }
    }
}

 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(1);
$pdf->Ln(1);    
   


$pdf->Ln(1);    
   

$pdf->Output("compra:$rubro_desc.pdf",'i');

?>