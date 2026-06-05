<?php
include ('../libreria/conexion.php');
$venta_cod=$_GET['venta'];
// consulta datos de la venta
if($conexion=="si"){
    $query = "SELECT venta.venta_cod,venta_fecha,venta_total,cliente.cliente_nom,usuario.usuario_nom,nota_resto FROM venta
        INNER JOIN cliente
        ON venta.cliente_cod=cliente.cliente_cod
        INNER JOIN usuario
        ON venta.usuario_cod=usuario.usuario_cod
        WHERE venta.venta_cod=$venta_cod
    ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){

                $venta_cod = $datos['venta_cod'];
                $venta_fecha = $datos['venta_fecha'];
                $venta_total = $datos['venta_total'];
                $cliente_nom = $datos['cliente_nom'];
                $usuario_nom = $datos['usuario_nom'];
                $nota_resto = $datos['nota_resto'];
            }
        }
    }
}




// CONFIGURACIÓN PREVIA
require('../fpdf/fpdf.php');
$peso="$";//simbolo peso
$pdf = new FPDF('P','mm',array(58,200)); // Tamaño tickt 80mm x 150 mm (largo aprox)
$pdf->SetMargins(0,1,0);
$pdf->SetAutoPageBreak(true,1); 
$pdf->AddPage();


// CABECERA
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(60,4,'Sanitarios El Obrero',3,1,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(60,4,'H. Guzman 221',0,1,'L');
$pdf->Cell(60,4,'388 - 4233906',0,1,'L');
$pdf->Cell(60,4,'elobrero03@gmail.com',0,1,'L');
$pdf->Cell(60,4,'CUIT: 20-08192201-3',0,1,'L');
$pdf->Ln(1);
$pdf->Cell(45,0,'','T');
$pdf->Ln(0);
 
// DATOS FACTURA        
$pdf->Ln(1);
$pdf->Cell(60,4,"Num. Venta: $venta_cod",0,1,'');
$pdf->Cell(60,4,"Fecha: $venta_fecha",0,1,'');
$pdf->Cell(60,4,"Usuario: $usuario_nom",0,1,'');
$pdf->Cell(60,4,"Cliente: $cliente_nom",0,1,'');
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
    $query = "SELECT producto.producto_desc,cantidad,detalleventa.producto_precio,subtotal FROM detalleventa,producto
        WHERE venta_cod=$venta_cod AND detalleventa.producto_cod=producto.producto_cod
        ";


    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);

        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_desc = $datos['producto_desc'];
                $cantidad = $datos['cantidad'];
                $producto_precio = $datos['producto_precio'];
                $subtotal = $datos['subtotal'];
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->Cell(100, 5, "$producto_desc", 0,1,'');
                $pdf->Cell(15, 5, "$cantidad   x ",0,0,'');
                $pdf->Cell(13, 5,"$peso$producto_precio = ", 0,0,'');
                $pdf->Cell(15, 5,"$peso$subtotal",0,0,'R');
                $pdf->Ln(5);
                $total=$total+$subtotal;
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
$pdf->Cell(20, 5,"$peso$total",0,0,'R');
$pdf->Ln(4);
$pdf->Cell(10, 5, 'Desc. = ', 0);    
$pdf->Cell(13, 10, '', 0);
$pdf->Cell(20, 5,"$peso$nota_resto",0,0,'R');
$pdf->Ln(4);
$pdf->Cell(10, 5, 'A pagar = ', 0);    
$pdf->Cell(13, 10, '', 0);
$pdf->Cell(20, 5,"$peso$venta_total",0,0,'R');

$pdf->Ln(4);
$pdf->Ln(2);
$pdf->Cell(45,0,'','T');
$pdf->Ln(1);    
   
// PIE DE PAGINA
$pdf->SetFont('Helvetica', '', 8);
$pdf->Ln(1);
$pdf->Cell(50,3,'GRACIAS POR SU COMPRA! ',0,1,'L');

$pdf->Cell(50,3,'EL PERIODO DE',0,1,'L');

$pdf->Cell(50,3,'DEVOLUCIONES ES 24HS.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Ln(1);
$pdf->Output("ticket:$venta_cod.pdf",'i');

?>