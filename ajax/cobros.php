<?php
require_once("../config/conexion.php");
require_once("../modelos/Cobros.php");

$cobros = new Cobros();

switch ($_GET["op"]) {

    case 'obtener_creditos_rango':
        $data = $cobros->getCreditosRango($_POST["argumentos"]);
        $data = Array();
    
         foreach ($data as $row) {
            $sub_array = array();
            $sub_array[] = $row["id_credito"];  
            $sub_array[] = $row["codigo"];
            $sub_array[] = $row["n_correlativo"];
            $sub_array[] = $row["paciente"];  
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["direccion"];
            $sub_array[] = "$".number_format($row["monto"],2,".",",");  
            $sub_array[] = $row["estado"];
            $sub_array[] = $row["saldo"];
            $sub_array[] =  date("d-m-Y", strtotime($row["fecha_pago"]))." ".$row["hora"];   
            $sub_array[] = '<button type="button"  class="btn btn-sm bg-light" onClick="ver_detalle_despachos()"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';
            $data[] = $sub_array;
         }
    
         $results = array(
           "sEcho"=>1, //Información para el datatables
           "iTotalRecords"=>count($data), //enviamos el total registros al datatable
           "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
           "aaData"=>$data);
         echo json_encode($results);

         
        break;

}