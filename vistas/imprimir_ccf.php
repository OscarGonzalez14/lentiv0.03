<?php ob_start();
use Dompdf\Dompdf;
use Dompdf\Options;

require_once '../dompdf1_2/autoload.inc.php';
require_once ('../config/conexion.php');
require_once ('../modelos/Despachos.php');
require_once("../helpers/convert_to_text.php");
date_default_timezone_set('America/El_Salvador'); 
$hoy = date("d-m-Y");
$dateTime= date("d-m-Y H:i:s");
require_once ('../modelos/Reporteria.php');
$reporteria = new Reporteria();

$codigo = $_POST["codigo_ord"];
$paciente = $_POST["paciente_ord"];
$id_optica = $_POST["id_optica_ord"];
$id_sucursal= $_POST["id_sucursal_ord"];

$data_optica = $reporteria->getDataOpticaFact($id_optica,$id_sucursal);
$data_ord = $reporteria->getDataOrdenFacturacion($codigo,$paciente);
$data_rx = $reporteria->getDataRxFact($codigo,$paciente);


foreach ($data_optica as $key) {
	$optica = $key["nombre"];
	$sucursal = $key["direccion"];
	$telefono = $key["telefono"];
	$nit = $key["nit"];
	$nrc = $key["nrc"];
	$giro = $key["giro"];
	$contribuyente = $key["contribuyente"];
}

foreach ($data_ord as $key => $value) {
	$paciente = $value["paciente"];
	$tipo_lente = $value["tipo_lente"];
	$trat_orden = $value["trat_orden"];
	$marca = $value["marca"];
	$ar = $value["antirreflejante"];
	$precio = $value["precio"];
}

foreach ($data_rx as $k) {
	$od_esf = $k["odesferas"];
	$od_cil = $k["odcindros"];
	$od_eje = $k["odeje"];
	$od_add = $k["odadicion"];
	$od_prisma = $k["odprisma"];
	$oi_esf = $k["oiesferas"];
	$oi_cil = $k["oicindros"];
	$oi_eje = $k["oieje"];
	$oi_add = $k["oiadicion"];
	$oi_prisma = $k["oiprisma"];

}

$ar =="Si" ? $anti_r = "AR Black Diamond" : $anti_r ="";
$descripcion = $tipo_lente." - ".strtolower($trat_orden." - ".$marca." - ".$anti_r);

$n_ojos = 2;

foreach ($data_rx as $value) {
	$esf_d = strtoupper($value["odesferas"]);
	$esf_i = strtoupper($value["oiesferas"]);
	if($esf_d == "NO TOCAR" or $esf_d == "NO HACER"){
 		$n_ojos=$n_ojos-1;
	}
    if($esf_i == "NO TOCAR" or $esf_i == "NO HACER"){
 		$n_ojos= $n_ojos-1;
	}
}

$n_ojos==2 ? $monto = $precio : $monto=$precio/2;
$iva = $monto*0.13;
$subtotal = $monto+$iva;
if ($contribuyente=="Si") {
	$retencion = $monto*0.01;
	$totales = $subtotal-$retencion;
}else{
	$retencion = 0.00;
	$totales = $subtotal-0;
}

require "vendor/autoload.php";
$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
$code = $Bar->getBarcode($codigo, $Bar::TYPE_CODE_128,'1','30');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>.::Imprimir CCF::.</title>
	<style>
		html{
      	margin-top: 8px;
        margin-left: 0px;
        margin-right:20px; 
        margin-bottom: 0px;
    }
    body{
  		font-family: Helvetica, Arial, sans-serif;
	}

	.data-opt{
		font-size: 13px;
		
	}

	.data-desc{
		font-size: 14px;

		
	}

	.td-data-opt{
		border-left: 0.5px solid black;
		padding: 2px
	}

	.table2 {
       border-collapse: collapse;
    }

    .sep{
      background-color: #fff;
      padding: 0;
      margin: 80px;
    }


	.rx-table{
		border: solid 1px white;
	}
	
	.data-montos{
		font-size: 12px
	}
	.border-montos{
		border-bottom: solid 1px #BEBEBE;
		padding: 2px;
	}
	</style>
    </head>
	<div style="height: 820px; margin-top: 70px">

		<table width="100%" style="margin-left: 15px">

		<tr>
			<td class="original-cliente" colspan="44" style="width: 44%;margin-left: 60px !important">
				<?php require("../helpers/plantilla_ccf.php")?>
			</td><!--original-cliente-->
			<td colspan="12" style="width: 12%;color:white">HHH</td>
			<td class="duplicado-emisor" colspan="44" style="width: 44%;margin-left: 60px !important;margin-right: 2px">
				<?php require("../helpers/plantilla_ccf.php")?>
			</td><!--duplicado-emisor-->
		</tr>

	    </table>

	</div>

	<div>
	
	<table width="100%" style="margin-left: 15px">
		<tr>
			<td class="original-cliente" colspan="44" style="width: 44%;margin-left: 5px !important">
				<?php require("../helpers/plantilla_ccf.php")?>
			</td><!--original-cliente-->
			<td colspan="12" style="width: 12%;color:white">HHH</td>
			<td class="duplicado-emisor" colspan="50" style="width: 50%;margin-left: 10px !important;margin-right: 10px">
				<?php require("../helpers/plantilla_ccf.php")?>
			</td><!--duplicado-emisor-->
		</tr>
	    </table>

	</div>

	
<body>
	
</body>
</html>

<?php
$salida_html = ob_get_contents();

  //$user=$_SESSION["id_usuario"];

ob_end_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($salida_html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('tabloid', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();
$dompdf->stream('document', array('Attachment'=>'0'));
?>

