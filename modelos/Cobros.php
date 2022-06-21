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
    
    private function registrarAbono($codigo,$monto,$abonos,$saldo,$recibo,$n_doc,$hoy,$hora,$id_orden,$id_optica,$id_sucursal,$id_usuario,$corr_recibo){
        $conectar=parent::conexion();
    	parent::set_names();
        
        $sql2 = "insert into abonos values(null,?,?,?,?,?,?,?,?,?,?,?,?);";
        $sql2 = $conectar->prepare($sql2);
        $sql2->bindValue(1, $codigo);
        $sql2->bindValue(2, $monto);
        $sql2->bindValue(3, $abonos);
        $sql2->bindValue(4, $saldo);
        $sql2->bindValue(5, $recibo);
        $sql2->bindValue(6, $n_doc);
        $sql2->bindValue(7, $hoy);
        $sql2->bindValue(8, $hora);
        $sql2->bindValue(9, $id_optica);
        $sql2->bindValue(10, $id_sucursal);
        $sql2->bindValue(11, $id_usuario);
        $sql2->bindValue(12, $id_orden);
        $sql2->execute();

        $sql = "insert into detalle_recibo values(null,?,?,?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $n_doc);
        $sql->bindValue(2, $id_optica);
        $sql->bindValue(3, $id_sucursal);
        $sql->bindValue(4, $id_orden);
        $sql->bindValue(5, $monto);
        $sql->bindValue(6, $corr_recibo);
        $sql->execute();
    }
    
    public function validaExisteCorr($corr){
        $conectar=parent::conexion();
        parent::set_names();
        $sql = "select n_recibo from recibos where n_recibo = ?;";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$corr);
        $sql->execute();
        return $resultado=$sql->fetchAll();       
    }   
    public function getCorrelativoRecibo(){
        $conectar= parent::conexion();
        $sql= "select n_recibo from recibos order by id_recibo DESC limit 1;";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchColumn();
    }

    public function registrarCobro($arrayccf,$montoAct,$id_usuario,$corr,$forma_cobro,$n_trans,$banco_cobro,$id_optica){
        $conectar=parent::conexion();
    	parent::set_names();
        date_default_timezone_set('America/El_Salvador');$hoy = date("Y-m-d"); $hora = date("H:i:s");
        $monto_act = $montoAct;
        $data_abonos_obj = array();
        $data_abonos_obj = json_decode($arrayccf);
        $completos = 0;
        $parciales =0;
        $abonos_comp = array();
        $abonos_parc = array();
        $rcb = "insert into recibos values(null,?,?,?,?,?,?,?,?,?);";
        $rcb = $conectar->prepare($rcb);
        $rcb->bindValue(1, $corr);
        $rcb->bindValue(2, $montoAct);
        $rcb->bindValue(3, $hoy);
        $rcb->bindValue(4, $hora);
        $rcb->bindValue(5, $id_optica);
        $rcb->bindValue(6, $id_usuario);
        $rcb->bindValue(7, $forma_cobro);
        $rcb->bindValue(8, $n_trans);
        $rcb->bindValue(9, $banco_cobro);
        $rcb->execute();
        
        foreach($data_abonos_obj as $k=>$v){
            $monto = $v->montoccf;
            $correlativo = $v-> correlativo;
            $codigo = $v->codigo;
            $abonos = $v->abonos;
            $id_orden = $v->id_orden;
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
                $this->registrarAbono($codigo,$monto,$abonos,"0",$corr,$correlativo,$hoy,$hora,$id_orden,$v->id_optica,$v->id_sucursal,$id_usuario,$corr);
                $this->registraAccionCobros($codigo,"Abono - Recibo: ".$corr,"Cancelacion",1);
                array_push($abonos_comp, $codigo);
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
                $this->registrarAbono($codigo,$monto,$abonos,$saldo,$corr,$correlativo,$hoy,$hora,$id_orden,$v->id_optica,$v->id_sucursal,$id_usuario,$corr);
                $this->registraAccionCobros($codigo,"Abono - Recibo: ".$corr,"Abono parcial",$id_usuario);
                array_push($abonos_parc, $codigo);
            }
            
        }      
         
       $msjs = ['completos'=>"Se han realizado <span style='color: #1b837d'><b>$completos </b></span>abonos completos", 'parciales'=>"Se han realizado <span style='color: #0e2227'><b>$parciales </b></span>abonos parciales",'correlativo'=>$corr,"abonos_completos"=>$abonos_comp,"abonos_parciales"=>$abonos_parc];
       echo json_encode($msjs);

       //echo json_encode()
    }

    public function getResumenCobro($id_optica){
        $conectar=parent::conexion();
    	parent::set_names();   
        
        $sql = "select r.id_recibo, r.n_recibo,r.id_optica,o.nombre,r.monto,r.fecha,r.hora,r.forma_pago,r.num_transaccion,r.banco,u.usuario,u.codigo_emp from optica as o INNER join recibos as r on o.id_optica=r.id_optica INNER join usuarios as u on r.id_usuario=u.id_usuario where r.id_optica = ?;";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1,(int)$id_optica);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetalleRecibo($n_recibo,$id_optica){
        $conectar=parent::conexion();
    	parent::set_names();
        $sql = "SELECT a.id_abono,a.correlativo_recibo,a.fecha,a.hora,s.direccion,o.paciente,o.codigo,a.n_doc,a.monto_orden,a.abonos_ant,a.saldo from abonos as a INNER JOIN orden as o on a.id_orden=o.id_orden inner join sucursal_optica as s on s.id_sucursal=a.id_sucursal where a.correlativo_recibo=? and a.id_optica=?;";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1,$n_recibo);
        $sql->bindValue(2,$id_optica);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
}