<?php
include ('../libreria/conexion.php');
$compra_cod=$_GET['compra'];
// consulta datos de la venta
if($conexion=="si"){
    $query = "SELECT compra_cod,compra_fecha,compra_total,proveedor.proveedor_nom FROM compra,proveedor
              WHERE compra_cod=$compra_cod AND compra.proveedor_cod=proveedor.proveedor_cod
             ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $compra_cod = $datos['compra_cod'];
                $compra_fecha = $datos['compra_fecha'];
                $compra_total = $datos['compra_total'];
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


// CABECERA;
$pdf->Image('../imagenes/logobn.png',30,20,30);
$pdf->Ln(15);
$pdf->SetFont('Helvetica','',20);
$pdf->Cell(150,4,'Sanitarios El Obrero',3,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Helvetica','',15);
$pdf->Cell(150,4,'Detalle de la Compra',3,1,'C');

 
// DATOS FACTURA 
$pdf->SetFont('Helvetica','',12);

$pdf->Ln(1);
$pdf->Cell(60,4,"Num. Compra: $compra_cod",0,1,'');
$pdf->Cell(60,4,"Fecha: $compra_fecha",0,1,'');
$pdf->Cell(60,4,"Proveedor: $proveedor_nom",0,1,'');
$pdf->Ln(1);



// COLUMNAS
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(17, 5, 'Codigo', 1,0,'');
$pdf->Cell(70, 5, 'Descripcion',1,0,'');
$pdf->Cell(15, 5, 'Cant.',1,0,'');
$pdf->Cell(30, 5, 'Precio',1,0,'L');
$pdf->Cell(30, 5, 'Subtotal',1,0,'L');
$pdf->Ln(5);
$pdf->Cell(54,0,'','T');
$pdf->Ln(1);
 

//PRODUCTOS

//consulta datos del detalle de la venta
$fila="";
if($conexion=="si"){
    $query = "SELECT detallecompra.producto_cod,producto.producto_desc,cantidad,ingreso_precio,subtotal FROM detallecompra,producto
              WHERE compra_cod=$compra_cod AND detallecompra.producto_cod=producto.producto_cod
             ";


    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);

        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $producto_cod = $datos['producto_cod'];
                $producto_desc = $datos['producto_desc'];
                $cantidad = $datos['cantidad'];
                $ingreso_precio = $datos['ingreso_precio'];
                $subtotal = $datos['subtotal'];

                $pdf->SetFont('Helvetica', '', 12);
                $pdf->Cell(17, 5, "$producto_cod", 1,0,'C');
                $pdf->Cell(70, 5, "$producto_desc",1,0,'');
                $pdf->Cell(15, 5, "$cantidad",1,0,'C');
                $pdf->Cell(30, 5, "$ingreso_precio",1,0,'C');
                $pdf->Cell(30, 5, "$subtotal",1,0,'C');
                $pdf->Ln(5);
            }
        }
    }
}

 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(1);
$pdf->Ln(1);    
   
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(15, 5, 'TOTAL = ', 0);    
$pdf->Cell(13, 10, '', 0);
$pdf->Cell(15, 5,"$peso$compra_total",0,0,'R');
$pdf->Ln(4);

$pdf->Ln(1);    
   

$pdf->Output("compra:$compra_cod.pdf",'i');

?>