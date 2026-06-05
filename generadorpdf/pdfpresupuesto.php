<?php
include ('../libreria/conexion.php');
// consulta datos de la venta


// CONFIGURACIÓN PREVIA
require('../fpdf/fpdf.php');
$peso="$ ";//simbolo peso
$pdf = new FPDF('P','mm',array(58,200)); // Tamaño tickt 80mm x 150 mm (largo aprox)
$pdf->SetMargins(0, 1 ,0);
$pdf->SetAutoPageBreak(true,1); 
$pdf->AddPage();


// CABECERA
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(60,4,'Sanitarios El Obrero',3,1,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(60,4,'H. Guzman 221',0,1,'L');
$pdf->Cell(60,4,'388 - 4233906',0,1,'L');
$pdf->Cell(60,4,'elobrero03@gmail.com',0,1,'L');
$pdf->Ln(1);
$pdf->Cell(45,0,'','T');
$pdf->Ln(0);
 
// DATOS FACTURA        
$pdf->Ln(1);
$pdf->Cell(60,4,"Presupuesto",0,1,'');
$pdf->Cell(60,4,"Fecha: $fecha_actual",0,1,'');
$pdf->Ln(1);
$pdf->Cell(45,0,'','T');
$pdf->Ln(0);


// COLUMNAS
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(60, 5, 'Descripcion', 0,1,'');
$pdf->Cell(7, 5, 'Cant.',0,0,'');
$pdf->Cell(13, 5, ' x Precio = ',0,0,'L');
$pdf->Cell(23, 5, 'Subtotal',0,0,'R');
$pdf->Ln(5);
$pdf->Cell(45,0,'','T');
$pdf->Ln(1);
 

//PRODUCTOS

//consulta datos del detalle de la venta
$fila="";
if($conexion=="si"){
    $query = "SELECT presupuesto.producto_cod,producto.producto_desc,producto.producto_precio,cantidad,subtotal FROM presupuesto,producto
            WHERE presupuesto.producto_cod=producto.producto_cod
        ";


    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);

        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $cantidad = $datos['cantidad'];
                $producto_precio = $datos['producto_precio'];
                $subtotal = $datos['subtotal'];
                $venta_total=$venta_total+$subtotal;

                $pdf->SetFont('Helvetica', '', 8);
                $pdf->Cell(100, 5, "$producto_desc", 0,1,'');
                $pdf->Cell(15, 5, "$cantidad x ",0,0,'');
                $pdf->Cell(13, 5,"$peso$producto_precio = ", 0,0,'');
                $pdf->Cell(15, 5,"$peso$subtotal",0,0,'R');
                $pdf->Ln(5);
            }
        }
    }
}

 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(1);
$pdf->Cell(45,0,'','T');
$pdf->Ln(1);    
   
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(10, 5, 'TOTAL = ', 0);    
$pdf->Cell(13, 10, '', 0);
$pdf->Cell(20, 5,"$peso$venta_total",0,0,'R');
$pdf->Ln(4);
$pdf->Ln(2);
$pdf->Cell(45,0,'','T');
$pdf->Ln(1);    
   
// PIE DE PAGINA
$pdf->SetFont('Helvetica', '', 8);
$pdf->Ln(1);
$pdf->Cell(50,3,'PRESUPUESTO VALIDO',0,1,'L');
$pdf->Cell(50,3,'HASTA 48 HS.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Ln(1);
$pdf->Output("presupuesto.pdf",'i');

?>