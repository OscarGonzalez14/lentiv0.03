<?php

require_once("../config/conexion.php");

class Cobros extends conectar{

    private function registraAccionCobros($codigo,$accion,$observacion,$id_usuario){
    $conectar=parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador');$hoy = date("d-m-Y H:i:s");
    $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $codigo);
    $sql->bindValue(2, $hoy);
    $sql->bindValue(3, $accion);
    $sql->bindValue(4, $observacion);
    $sql->bindValue(5, $id_usuario);
    $sql->execute();
    }

    public function getCreditosRango($argumentos){
        //$fecha = implode("", $argumentos[0]);
        $fechas = explode("/", $argumentos[0]);
        $inicio = $fechas[0];
        $fin = $fechas[1]; //echo "Inicio: ".date("Y-m-d",strtotime($inicio))."Fin: ".$fin;

        $conectar=parent::conexion();
    	parent::set_names();

        $sql = "SELECT c.id_credito,cf.n_correlativo,c.monto,o.paciente,o.codigo,op.nombre,s.direccion,c.estado,c.fecha_pago,c.saldo,cf.hora,cf.fecha,c.fecha_fact,c.hora_fact,TIMESTAMPDIFF(DAY,c.`fecha_fact`,NOW()) as dias FROM creditos as c INNER join creditos_fiscales as cf on c.codigo_orden=cf.codigo_orden inner join orden as o on cf.codigo_orden=o.codigo inner join optica as op on op.id_optica=c.id_optica INNER JOIN sucursal_optica as s on c.id_sucursal=s.id_sucursal where c.fecha_fact BETWEEN ? AND ? and c.id_optica=?;";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, date("Y-m-d",strtotime($inicio)));
		$sql->bindValue(2, date("Y-m-d",strtotime($fin)));
        $sql->bindValue(3, $argumentos[1]);
		$sql->execute();
		return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($argumentos);
    }

    public function registrarCobro($arrayccf,$montoAct){
        $conectar=parent::conexion();
    	parent::set_names();

        $monto_act = $montoAct;
        $data_abonos_obj = array();
        $data_abonos_obj = json_decode($arrayccf);
        $completos = 0;
        $parciales =0;
        foreach($data_abonos_obj as $k=>$v){
            $monto = $v->montoccf;
            $correlativo = $v-> correlativo;
            $codigo = $v->codigo;
            $abonos = $v->abonos;
            if($monto_act >= $monto){
                /*================ Si monto actual > costo de orden se cancela la cuenta =============*/
                $sum_abono = $abonos+$monto; 
                $sql = "update creditos set saldo = '0', estado = 'Cancelado', abono = ? where codigo_orden = ?;";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1,$sum_abono);
                $sql->bindValue(2,$codigo);
                $sql->execute();
                $monto_act = $monto_act - $monto;
                $completos++;
                $this->registraAccionCobros($codigo,"Abono","Cancelacion",1);
            }elseif($monto_act < $monto and $monto_act > 0){
                $saldo = ($monto) - ($monto_act);
                $abono = $monto_act;
                $sum_abono = $abonos+$abono; 
                $sql_u = "update creditos set saldo = ? , estado = 'Parcial', abono= ? where codigo_orden = ?;";
                $sql_u = $conectar->prepare($sql_u);
                $sql_u->bindValue(1,number_format($saldo,2,".",","));
                $sql_u->bindValue(2,$sum_abono);
                $sql_u->bindValue(3,$codigo);
                $sql_u->execute();
                $monto_act = $monto_act - $abono;
                $parciales++;
                $this->registraAccionCobros($codigo,"Abono","Abono parcial",1);
            }
            
        }
         
        $msjs = ['completos'=>"Se han realizado <span style='color: #1b837d'><b>$completos </b></span>abonos completos", 'parciales'=>"Se han realizado <span style='color: #0e2227'><b>$parciales </b></span>abonos parciales" ];
        echo json_encode($msjs);
    }
    
}