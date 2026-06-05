<?php
include ('../libreria/conexion.php');
$proveedor_cod=$_POST['proveedor_cod'];

// consulta datos de la venta
if($conexion=="si"){
    $query = "SELECT proveedor_cod,proveedor_nom FROM proveedor
              WHERE proveedor_cod=$proveedor_cod
             ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $proveedor_cod = $datos['proveedor_cod'];
                $proveedor_nom = $datos['proveedor_nom'];            
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
$pdf->Cell(150,4,'Nota de pedido',3,1,'C');


 
// DATOS FACTURA 
$pdf->SetFont('Helvetica','',12);

$pdf->Ln(1);
$pdf->Cell(60,4,"Fecha: $fecha_actual",0,1,'');
$pdf->Cell(60,4,"Proveedor: $proveedor_nom",0,1,'');
$pdf->Ln(1);



// COLUMNAS
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(17, 5, 'Codigo', 1,0,'');
$pdf->Cell(70, 5, 'Descripcion',1,0,'');
$pdf->Cell(15, 5, 'Cant.',1,0,'');
$pdf->Cell(23, 5, 'Cant. Min.',1,0,'');
$pdf->Cell(30, 5, 'Cant. Pedida',1,0,'');
$pdf->Ln(5);
$pdf->Cell(54,0,'','T');
$pdf->Ln(1);
 

//PRODUCTOS

//consulta datos del detalle de la venta
$fila="";
if($conexion=="si"){
    $query = "SELECT producto_cod,producto_desc,producto_cant,producto_cantmin,producto.proveedor_cod,proveedor.proveedor_nom FROM producto,proveedor
              WHERE producto.proveedor_cod=$proveedor_cod AND producto_cant<=producto_cantmin AND proveedor.proveedor_cod=producto.proveedor_cod
             ";


    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);

        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $cantidad = $datos['producto_cant'];
                $cantidadm = $datos['producto_cantmin'];
                

                $pdf->SetFont('Helvetica', '', 12);
                $pdf->Cell(17, 5, "$producto_cod", 1,0,'C');
                $pdf->Cell(70, 5, "$producto_desc",1,0,'L');
                $pdf->Cell(15, 5, "$cantidad",1,0,'C');
                $pdf->Cell(23, 5, "$cantidadm",1,0,'C');
                $pdf->Cell(30, 5, "",1,0,'L');
                $pdf->Ln(5);
            }
        }
    }
}

 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(1);
$pdf->Ln(1);    
   
// $pdf->SetFont('Helvetica', '', 12);
// $pdf->Cell(15, 5, 'TOTAL = ', 0);    
// $pdf->Cell(13, 10, '', 0);
// $pdf->Cell(15, 5,"$peso$compra_total",0,0,'R');
// $pdf->Ln(4);

$pdf->Ln(1);    
   

$pdf->Output("compra:$compra_cod.pdf",'i');

?>