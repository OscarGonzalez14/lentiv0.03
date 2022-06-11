<?php 
require_once("../config/conexion.php");

class Creditos extends conectar {//inicio de la clase

	public function getCorrelativoCCF(){
		$conectar=parent::conexion();
    	parent::set_names();

    	$conectar= parent::conexion();
      	$sql= "select n_correlativo from creditos_fiscales order by id_ccf DESC limit 1;";
      	$sql=$conectar->prepare($sql);
      	$sql->execute();
      	return $sql->fetchColumn();
	}

	public function pagoMeMensual($fecha_registro,$hoy){
		$fecha_reg = new DateTime($fecha_registro);
		$fecha_act = new DateTime($hoy);

		$diff = $fecha_reg->diff($fecha_act);
		$contador = $diff->days;         
        $fecha_pago = "";

        
		if ($contador > 7) {
			$anio = date('Y', strtotime($hoy));
            $mes = date('m', strtotime($hoy));
			$fecha_pago = $anio."-".$mes."-"."30";
		}else{
			$mes_siguiente = date("Y-m-d",strtotime($hoy."+ 1 month"));		
			$anio_sig = date('Y', strtotime($mes_siguiente));
            $mes_sig = date('m', strtotime($mes_siguiente));
            $fecha_pago = $anio_sig."-".$mes_sig."-"."30";
		}

		return $fecha_pago;

	}

	public function pagoQuicenal($fecha_registro,$hoy){

	    $fecha_reg = new DateTime($fecha_registro);
		$fecha_act = new DateTime($hoy);
		
		$anio = date('Y', strtotime($hoy));
        $mes = date('m', strtotime($hoy));
        $dia = date('d', strtotime($hoy));

		$diff = $fecha_reg->diff($fecha_act);
		$contador = $diff->days;         
        $fecha_pago = "";

        $mes_siguiente = date("Y-m-d",strtotime($hoy."+ 1 month"));		
	    $anio_sig = date('Y', strtotime($mes_siguiente));
        $mes_sig = date('m', strtotime($mes_siguiente));

        if ($contador > 7 and ($dia >=1 and $dia <15) and $mes !="02"){//C1
        	/***** Se cobrara el 15 de  mes ******/
			$fecha_pago = $anio."-".$mes."-"."15";
        }elseif($contador > 7 and ($dia >=15 and $dia <30) and $mes != "02"){//C2
        	/**** se cobrara el 30 de mes *******/
			$fecha_pago = $anio."-".$mes."-"."30";
        }elseif($contador < 7 and ($dia >=1 and $dia <15) and $mes != "02"){//C3
        	/**** se cobrara el 30 de mes *******/
			$fecha_pago = $anio."-".$mes."-"."30";
        }elseif($contador < 7 and ($dia >=15 and $dia <30) and $mes != "02"){//C4
        	/**** se cobrara el 15 del siguente mes *******/
        	$fecha_pago = $anio_sig."-".$mes_sig."-"."15";
        }elseif(($dia==31 or $dia==30) and $mes != "02"){//C5
        	/**** se cobrara el 15 del siguente mes *******/
        	$fecha_pago = $anio_sig."-".$mes_sig."-"."15";
        }elseif($contador > 7 and ($dia >=1 and $dia <15) and $mes =="02"){//C6
        	$fecha_pago = $anio."-".$mes."-"."15";
        }elseif($contador > 7 and ($dia >=15 and $dia < 28) and $mes =="02"){//C7
        	$fecha_pago = $anio."-".$mes."-"."28";
        }elseif($contador < 7 and ($dia > 1 and $dia < 15) and $mes =="02"){//C8
        	$fecha_pago = $anio."-".$mes."-"."28";
        }elseif($contador < 7 and ($dia >= 15 and $dia < 28) and $mes =="02"){//C9
        	$fecha_pago = $anio_sig."-".$mes_sig."-"."15";
        }elseif(($dia==28 or $dia==29) and $mes == "02"){//10
        	/**** se cobrara el 15 del siguente mes *******/
        	$fecha_pago = $anio_sig."-".$mes_sig."-"."15";
        }
        return $fecha_pago;

    }

    ################## REGISTRAR CCF ################

	public function registrarCCF($codigo,$paciente,$id_optica,$id_sucursal,$monto_orden,$dia_de_pago,$fecha_registro,$metodo_cobro){
	    $conectar=parent::conexion();
    	parent::set_names();

        date_default_timezone_set('America/El_Salvador');
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        /***************  Se valida el metodo de pago ***********/
		if ($metodo_cobro=="Mensual") {
			$diaPago = date("Y-m-d",strtotime($hoy."+ 1 month"));
		}elseif($metodo_cobro == "Quincenal"){
			$diaPago = date("Y-m-d",strtotime($hoy."+ 15 days"));
		}elseif($metodo_cobro=="Semanal"){
			$diaPago = date("Y-m-d",strtotime($hoy."+ 7 days"));
		}

        $tipo_credito = "";
        $estado = "Pendiente";
        $id_usuario = 1;

		$sql = "insert into creditos values(null,?,?,?,?,?,?,?,?,?,?,?);";
		$sql = $conectar->prepare($sql);
		$sql->bindValue(1, $tipo_credito);
		$sql->bindValue(2, $monto_orden);
		$sql->bindValue(3, $hoy);
		$sql->bindValue(4, $hora);
		$sql->bindValue(5, $diaPago);
		$sql->bindValue(6, $codigo);
		$sql->bindValue(7, $estado);
		$sql->bindValue(8, $id_optica);
		$sql->bindValue(9, $id_sucursal);
		$sql->bindValue(10, $id_usuario);
		$sql->bindValue(11, $monto_orden);
		$sql->execute();

		$correlativo_ccf = $this->getCorrelativoCCF();
		$corr = substr($correlativo_ccf,4,20);
        $correlativo = "ccf-".((int)$corr)+1;
        $estado_ccf ="Sin cancelar";
		$sql2 = "insert into creditos_fiscales values(null,?,?,?,?,?,?,?,?);";
		$sql2 = $conectar->prepare($sql2);
		$sql2->bindValue(1, $correlativo);
		$sql2->bindValue(2, $codigo);
		$sql2->bindValue(3, $monto_orden);
		$sql2->bindValue(4, $hoy);
		$sql2->bindValue(5, $hora);
		$sql2->bindValue(6, $id_sucursal);
		$sql2->bindValue(7, $id_usuario);
		$sql2->bindValue(8, $estado_ccf);
		$sql2->execute();

		//$sql2 = "insert into "

		if ($sql->rowCount() > 0 &&  $sql2->rowCount() > 0){
			
			$data = ['msj'=>'ccfreg','correlativo'=>$correlativo,'fecha_pago'=> date("d-m-Y",strtotime($diaPago))];
			
		}else{
			$data = ['msj'=>'ccferror'];
		}
		echo json_encode($data);	
	}

	/************************ LISTAR CREDITOS FISCALES DIARIOS ***************************/
	public function getCffDiarios(){
		$conectar=parent::conexion();
    	parent::set_names();

		$sql = "SELECT cf.id_ccf,cf.n_correlativo,cf.codigo_orden,cf.fecha,cf.fecha,cf.hora,cf.monto,o.paciente,s.direccion,op.nombre from creditos_fiscales as cf inner join orden as o on cf.codigo_orden=o.codigo inner join sucursal_optica as s on s.id_sucursal=cf.id_sucursal INNER join optica as op on op.id_optica=s.id_optica;";
		$sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCreditosMensuales(){
		$conectar=parent::conexion();
    	parent::set_names();

		$sql = "select o.nombre,o.limite_credito,sum(c.monto) as acumulado,MIN(`fecha_fact`) AS min_fac, TIMESTAMPDIFF(DAY,MIN(`fecha_fact`),NOW()) as transc,o.id_optica from optica as o INNER join creditos as c on o.id_optica=c.id_optica where o.metodo_cobro='Mensual' group by c.id_optica;";
		$sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCreditosGneral($optica){
        $id_optica = implode("", $optica);

        $conectar=parent::conexion();
    	parent::set_names();

        $sql = "SELECT c.id_credito,cf.n_correlativo,c.monto,o.paciente,o.codigo,op.nombre,s.direccion,c.estado,c.fecha_pago,c.saldo,cf.hora,cf.fecha,c.fecha_fact,c.hora_fact,TIMESTAMPDIFF(DAY,c.`fecha_fact`,NOW()) as dias FROM creditos as c INNER join creditos_fiscales as cf on c.codigo_orden=cf.codigo_orden inner join orden as o on cf.codigo_orden=o.codigo inner join optica as op on op.id_optica=c.id_optica INNER JOIN sucursal_optica as s on c.id_sucursal=s.id_sucursal where  c.id_optica=? order by dias DESC;";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $id_optica);
		$sql->execute();
		return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($argumentos);
    }

}//Fin clase

//$creditos = new Creditos();
//$creditos->pagoMeMensual();


///////////////////////CREDITOS CON MORA
//SELECT fecha_fact,(TIMESTAMPDIFF(DAY,`fecha_fact`,NOW())) AS transc FROM creditos where (TIMESTAMPDIFF(DAY,`fecha_fact`,NOW()) > 0);
//SELECT `id_optica`,fecha_fact,max(TIMESTAMPDIFF(DAY,`fecha_fact`,NOW())) AS transc FROM creditos where (TIMESTAMPDIFF(DAY,`fecha_fact`,NOW()) > 0 ) GROUP by `id_optica`;