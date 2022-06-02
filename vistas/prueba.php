<?php
date_default_timezone_set('America/El_Salvador');
$fecha_reg = "2022-05-05";
$hoy = date("Y-m-d");
$dia_cobro = "Lunes";
$fecha_reg = new DateTime($fecha_reg);
$fecha_act = new DateTime($hoy);
$diff = $fecha_reg->diff($fecha_act);
$contador = $diff->days;   
echo  date('w', strtotime($hoy))."<br>";
echo $contador."<br>";
/*$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
//Resultado: Domingo 26 de Enero del 2020*/

$days = [];
for ($i = 0; $i <=7; $i++) {
    $dia_act = date("Y-m-d",strtotime($hoy."+ $i days"));   
    array_push($days, $dia_act);
}

function saber_dia($nombredia) {

$dia = DateTime::createFromFormat('Y-m-d', $nombredia)->format('Y-m-d');
$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
$fecha = $dias[date('w', strtotime($dia))];
$fechasf = date('N', strtotime($dia));
echo $fecha."<br>";

}

foreach ($days as $key) {
	saber_dia($key)."<br>";
}

print_r($days);
// ejecutamos la función pasándole la fecha que queremos
