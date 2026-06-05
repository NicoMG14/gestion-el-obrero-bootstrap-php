<?php
include ('../libreria/conexion.php');
$nota_cod=$_GET['nota'];
// consulta datos de la nota de credito
if($conexion=="si"){
    $query = "SELECT nota_cod,nota_fecha,nota_total,nota_estado,usuario.usuario_nom FROM notadecredito,usuario
              WHERE nota_cod=$nota_cod AND notadecredito.usuario_cod=usuario.usuario_cod
             ";
    if ($resultado = mysqli_query($link, $query)){
        $rowcont = mysqli_num_rows($resultado);
        if($rowcont > 0){
            while ($datos=mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
                $nota_cod = $datos['nota_cod'];
                $nota_fecha = $datos['nota_fecha'];
                $nota_total = $datos['nota_total'];
                $usuario_nom = $datos['usuario_nom'];
                $nota_estado = $datos['nota_estado'];
                if ($nota_estado==1){
                    $nota_estado="Activo";
                }else{
                    $nota_estado="Inactivo";
                }
            }
        }
    }
}



// CONFIGURACIÓN PREVIA
require('../fpdf/fpdf.php');
$peso="$ ";//simbolo peso
$pdf = new FPDF('P','mm',array(58,200)); // Tamaño tickt 80mm x 150 mm (largo aprox)
$pdf->SetMargins(0, 1 , 0);
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
$pdf->Cell(60,4,"Nota de C.: $nota_cod",0,1,'');
$pdf->Cell(60,4,"Fecha: $nota_fecha",0,1,'');
$pdf->Cell(60,4,"Usuario: $usuario_nom",0,1,'');
$pdf->Cell(60,4,"Estado: $nota_estado",0,1,'');
$pdf->Ln(1);
$pdf->Cell(45,0,'','T');
$pdf->Ln(1);


 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA

   
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(10, 5, 'TOTAL = ', 0);    
$pdf->Cell(13, 10, '', 0);
$pdf->Cell(20, 5,"$peso$nota_total",0,0,'R');
$pdf->Ln(4);
$pdf->Ln(2);
$pdf->Cell(45,0,'','T');
$pdf->Ln(1);    
   
// PIE DE PAGINA
$pdf->SetFont('Helvetica', '', 8);
$pdf->Ln(1);

$pdf->Cell(50,3,'LA NOTA DE CREDITO',0,1,'L');
$pdf->Cell(50,3,'NO TIENE VENCIMIENTO',0,0,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Cell(50,3,'.',0,1,'L');
$pdf->Ln(1);
$pdf->Output("nota:$nota_cod.pdf",'i');

?>