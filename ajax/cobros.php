<?php
require_once("../config/conexion.php");
require_once("../modelos/Cobros.php");
require_once("../modelos/Creditos.php");
$cobros = new Cobros();
$creditos = new Creditos();

switch ($_GET["op"]) {

    case 'obtener_creditos_rango':

        $data = $cobros->getCreditosRango($_POST["Args"]);
        $datos = Array();
        $saldo_acumulado = 0;
        
         foreach ($data as $row) {
            $sub_array = array();
            $sub_array[] = '<div style="text-align:center"><input type="checkbox" class="form-check-input ordenes_enviar_inabve" style="text-align: center" value="'.$row["codigo"].','.$row["monto"].'" id="n_item'.$cont.'"><span style="color:white">.</span></div>';
            $sub_array[] = $row["n_correlativo"];
            $sub_array[] =  date("d-m-Y", strtotime($row["fecha_fact"]))." ".$row["hora_fact"];
            $sub_array[] =  date("d-m-Y", strtotime($row["fecha_pago"]));   
            $sub_array[] = $row["dias"]." dias";
            $sub_array[] = $row["paciente"];  
            $sub_array[] = $row["codigo"]." - ".$row["nombre"];
            $sub_array[] = $row["direccion"];
            $sub_array[] = "$".number_format($row["monto"],2,".",",");  
            $sub_array[] = "0";
            $sub_array[] = $row["saldo"];
            $sub_array[] = $saldo_acumulado;
            $datos[] = $sub_array;
            $saldo_acumulado = $saldo_acumulado + $row["saldo"]; 
         }
    
         $results = array(
           "sEcho"=>1, //Información para el datatables
           "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
           "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
           "aaData"=>$datos);

           echo json_encode($results);         
        break;


        case 'listar_creditos_mensuales':      
                   
         $data = $creditos->getCreditosMensuales();

         $datos = Array();

         foreach ($data as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombre"];
            $sub_array[] = "$".number_format($row["limite_credito"]);
            $sub_array[] = "$".number_format($row["acumulado"],2,".",",");
            $sub_array[] = date("d-m-Y", strtotime($row["min_fac"]));  
            $sub_array[] = $row["transc"]." dias";
            $sub_array[] = '<button type="button"  class="btn btn-sm bg-light" onClick="verDetCobrosOptica('.$row['id_optica'].',\''.$row['nombre'].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';
            $datos[] = $sub_array;
         }

         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
            "aaData"=>$datos); 
         echo json_encode($results);         

         break;

         case 'obtener_creditos_general';
         $data = $creditos->getCreditosGneral($_POST["Args"]);
         $datos = Array();
         $saldo_acumulado = 0;
         $cont=0;
         
         foreach ($data as $row) {
            $saldo_acumulado = $saldo_acumulado + $row["saldo"];
             $sub_array = array();
             //$sub_array[] = '<div style="text-align:center"><input type="checkbox" class="form-check-input ordenes_enviar_inabve" style="text-align: center" value="'.$row["codigo"].','.$row["monto"].'" id="n_item'.$cont.'"><span style="color:white">.</span></div>';    
             $sub_array[] = "<span id='ccf".$cont."' class='correlativos-ccf' data-spans=".$row["n_correlativo"]." data-montoccf=".$row["saldo"]." data-codigo=".$row["codigo"]." data-abonos=".$row["abono"]." data-idorden=".$row["id_orden"]." data-idoptica=".$row["id_optica"]." data-idsucursal=".$row["id_sucursal"].">".$row["n_correlativo"]."</span>";
             $sub_array[] =  date("d-m-Y", strtotime($row["fecha_fact"]))." ".$row["hora_fact"];
             $sub_array[] =  date("d-m-Y", strtotime($row["fecha_pago"]));   
             $sub_array[] = $row["dias"];
             $sub_array[] = "<span id=".$row["codigo"].">".$row["codigo"]." - ".$row["paciente"]."</span>";  
             $sub_array[] = $row["direccion"];
             $sub_array[] = "$".number_format($row["monto"],2,".",",");  
             $sub_array[] = "$".number_format($row["abono"],2,".",",");
             $sub_array[] = "$".number_format($row["saldo"],2,".",",");
             $sub_array[] = "$".number_format($saldo_acumulado,2,".",",");
             $datos[] = $sub_array;             
             $cont++;
          }
     
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
            "aaData"=>$datos);
 
            echo json_encode($results); 
            break;

      case 'registrar_cobros':
        $correlativo = $cobros->getCorrelativoRecibo();
        $corr = substr($correlativo,3,20);
        $corr= "RL-".(int) $corr+1;
        
        $validaCorrelativo = $cobros->validaExisteCorr($corr);
        if (is_array($validaCorrelativo)==true and count($validaCorrelativo)==0 ){
        $cobros->registrarCobro($_POST["arrayccf"],$_POST["monto"],$_POST["id_usuario"],$corr,$_POST["forma_cobro"],$_POST["n_trans"],$_POST["banco_cobro"],$_POST["id_optica"]);
        }else{
         echo json_encode("Error");
        }
         break;

      case "resumen_cobros":
         $id_optica = implode("",$_POST["Args"]);
         $cobros = $cobros->getResumenCobro($id_optica);
         foreach ($cobros as $row) {
            $sub_array = array();
             $sub_array[] = $row["id_recibo"];
             $sub_array[] = $row["n_recibo"];
             $sub_array[] = $row["nombre"];
             $sub_array[] = "$".number_format($row["monto"],2,".",",");  
             $sub_array[] =  date("d-m-Y", strtotime($row["fecha"]))." ".$row["hora"];
             $sub_array[] = $row["codigo_emp"]."-".$row["usuario"];
             $sub_array[] = $row["forma_pago"];
             $sub_array[] = $row["num_transaccion"];
             $sub_array[] = $row["banco"];
             $sub_array[] = '<button type="button"  class="btn btn-sm bg-light"><i class="fa fa-eye" aria-hidden="true" style="color:blue" onClick="verDetRecibo('.$row['id_optica'].',\''.$row['n_recibo'].'\',\''.$row['nombre'].'\')"></i></button>';
             $datos[] = $sub_array;             
             
          }
     
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
            "aaData"=>$datos);
 
            echo json_encode($results); 
            break;
         break;

         case "detalle_recibos":
            $args = implode(",",$_POST["Args"]);
            $argumentos = explode(",",$args);
            $det = $cobros->getDetalleRecibo($argumentos[0],$argumentos[1]);
            foreach ($det as $row) {
               $sub_array = array();
               $abono_act = ($row["monto_orden"])-($row["saldo"]);
                $sub_array[] = $row["id_abono"];
                $sub_array[] = $row["codigo"];
                $sub_array[] = $row["correlativo_recibo"];
                $sub_array[] = $row["direccion"];
                $sub_array[] = $row["paciente"];
                $sub_array[] = $row["n_doc"];
                $sub_array[] = "$".number_format($row["monto_orden"],2,".",",");
                $sub_array[] = "$".number_format($abono_act,2,".",",");    
                $sub_array[] =  date("d-m-Y", strtotime($row["fecha"]))." ".$row["hora"];
                $sub_array[] = "$".number_format($row["saldo"],2,".",",");
                $datos[] = $sub_array;             
                
             }
        
            $results = array(
               "sEcho"=>1, //Información para el datatables
               "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
               "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
               "aaData"=>$datos);
    
               echo json_encode($results); 
               break;
            break;

}