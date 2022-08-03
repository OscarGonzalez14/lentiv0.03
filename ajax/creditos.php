<?php
require_once("../config/conexion.php");
require_once("../modelos/Creditos.php");

$creditos = new Creditos();

switch ($_GET["op"]) {

case 'registrar_comprobante':
	$creditos->registrarComprobante($_POST["codigo"],$_POST["paciente"],$_POST["id_optica"],$_POST["id_sucursal"],$_POST["monto_orden"],$_POST["dia_de_pago"],$_POST["fecha_registro"],$_POST["metodo_cobro"],$_POST["id_orden"],$_POST["id_usuario"],$_POST["documento"]);

    break;

case 'listar_ccf_diarios':

    $datos = $creditos->getCffDiarios();
    $data = Array();

     foreach ($datos as $row) {
        $sub_array = array();
        $sub_array[] = $row["id_ccf"];  
        $sub_array[] = $row["n_correlativo"];
        $sub_array[] = $row["codigo_orden"];
        $sub_array[] = $row["paciente"];  
        $sub_array[] = $row["nombre"];
       // $sub_array[] = $row["direccion"];
        $sub_array[] = "$".number_format($row["monto"],2,".",",");  
        $sub_array[] =  date("d-m-Y", strtotime($row["fecha"]))." ".$row["hora"];   
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
  
    ///////////////////LISTAR FACTURAS 
    case 'listado_general_facturas':

      $datos = $creditos->getFacturasDiarios();
      $data = Array();
  
       foreach ($datos as $row) {
          if($row["estado"]=="Sin cancelar"){
            $color = "#ffc107";
            $icon = "fas fa-clock";
            
          }else{
            $color = "#42ba96";
            $icon = "far fa-check-circle";
          }
          $sub_array = array();
          $sub_array[] = $row["id_factura"];  
          $sub_array[] = $row["n_correlativo"];
          $sub_array[] = $row["codigo_orden"];
          $sub_array[] = $row["paciente"];  
          $sub_array[] = $row["nombre"];
          $sub_array[] = "$".number_format($row["monto"],2,".",",");  
          $sub_array[] =  date("d-m-Y", strtotime($row["fecha"]))." ".$row["hora"]; 
          $sub_array[] = '<span class="right badge badge-'.$color.'" style="font-size:12px;"><i class="'.$icon.'" style="color:'.$color.'"></i> '.$row["estado"].'</span>';
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