<?php ob_start();
use Dompdf\Dompdf;

require_once '../dompdf/autoload.inc.php';
require_once '../modelos/Reporteria.php';
require_once '../config/conexion.php';
$reportes = new Reporteria();
$paciente = $_POST["paciente"];
$id_optica = $_POST["id_optica"];
$id_sucursal = $_POST["id_sucursal"];
$fecha = $_POST["fecha"];
$usuario = $_POST["usuario"];
$codigo = $_POST["codigo"];
date_default_timezone_set('America/El_Salvador'); 
$hoy = date("d-m-Y H:i:s");
$conectar = new Conectar;
$mes = date("m");
$mes_act = $conectar->convertir($mes);

$fecha_eval = date("Y-m-d",strtotime($fecha));
$fecha_eval = date('l', strtotime($fecha_eval));

$dia = str_replace(
      array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
      array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'),$fecha_eval);
require "vendor/autoload.php";
$Bar = new Picqer\Barcode\BarcodeGeneratorSVG();
$code = $Bar->getBarcode($codigo, $Bar::TYPE_CODE_128,'3','45');
$optica_act = $reportes->get_optica_barcode($id_optica,$id_sucursal);

foreach ($optica_act as $key) {
  $optica = $key["nombre"]."-".$key["direccion"];
}
?>
<html lang="en" dir="ltr">
  <body>

    <table width="100%"> 
        <tr>
          <td>
            <div id="qrbox">
              <div style="margin: 0px;">
                <span style="font-size: 17px"><b>LENTI</b></span>&nbsp;&nbsp;<span><?php echo $codigo;?></span></span>&nbsp;&nbsp;<span><?php echo substr($mes_act,0,3)." ".substr($codigo,4,12);?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px;text-transform: uppercase;"><b><?php echo substr($dia, 0,3)?></b></span><br>
                <span style="font-size:11px;text-transform: uppercase;"><b><?php echo $paciente;?></span><br>
                <span style="font-size: 15px"><b><?php echo $optica;?></span>
                </div>
                <div><?php echo $code;?></div>
                <div style="font-size: 13px"><?php echo $fecha."   user-".$usuario;?>&nbsp;&nbsp;<span id="dia"></span></div>            
            </div>
          </td>
          <td>******</td>
          <td>
                      <div id="qrbox">
              <div style="margin: 0px;">
                <span style="font-size: 17px"><b>LENTI</b></span>&nbsp;&nbsp;<span><?php echo $codigo;?></span></span>&nbsp;&nbsp;<span><?php echo substr($mes_act,0,3)." ".substr($codigo,4,12);?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px;text-transform: uppercase;"><b><?php echo substr($dia, 0,3)?></b></span><br>
                <span style="font-size:14px;text-transform: uppercase;"><b><?php echo $paciente;?></span><br>
                <span style="font-size: 15px"><b><?php echo $optica;?></span>
                </div>
                <div><?php echo $code;?></div>
                <div style="font-size: 13px"><?php echo $fecha."   user-".$usuario;?>&nbsp;&nbsp;<span id="dia"></span></div>            
            </div>
          </td> 
        </tr>
    </table>  

    <div style="text-align: left; font-size: 10px;font-family: Helvetica, Arial, sans-serif;">

    </div>
<script>
    window.print();
    //window.close();
  </script> 
</body>
</html>
