<?php 
require_once("../config/conexion.php");

class Creditos extends conectar {//inicio de la clase

	public function getCorrelativoComprobantes($documento){
		$conectar=parent::conexion();
    	parent::set_names();
        //$tabla = $documento =='factura' ? "facturas" : "creditos_fiscales";
		if($documento =='factura'){
			$tabla = "facturas";
			$order = "id_factura";
		}else{
			$tabla = "creditos_fiscales";
			$order = "id_ccf";
		}
    	$conectar= parent::conexion();
      	$sql= "select n_correlativo from $tabla order by $order DESC limit 1;";
      	$sql=$conectar->prepare($sql);
      	$sql->execute();
      	//return $sql->fetchColumn();
		return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	

    ################## REGISTRAR CCF ################

	public function registrarComprobante($codigo,$paciente,$id_optica,$id_sucursal,$monto_orden,$dia_de_pago,$fecha_registro,$metodo_cobro,$id_orden,$id_usuario,$documento){
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
        $abono = 0;
		$sql = "insert into creditos values(null,?,?,?,?,?,?,?,?,?,?,?,?,?);";
		$sql = $conectar->prepare($sql);
		$sql->bindValue(1, $documento);
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
		$sql->bindValue(12, $abono);
		$sql->bindValue(13, $id_orden);
		$sql->execute();

		$correlativo_ccf = $this->getCorrelativoComprobantes($documento);
		if(is_array($correlativo_ccf)==true and count($correlativo_ccf)>0){
			foreach($correlativo_ccf as $v){
				$n_credito = $v["n_correlativo"];
			}
			$correlativo = (int)$n_credito + (int)1;

		}else{
			$correlativo = "1";
		}
		 
		//Comprobar correlativo 
        $tabla = $documento =='factura' ? "facturas" : "creditos_fiscales";
		
        $sql4 = "select *from $tabla where codigo_orden = ?;";
		$sql4 = $conectar->prepare($sql4);
		$sql4->bindValue(1, $codigo);
        $sql4->execute();
		$resultado_corr = $sql4->fetchAll(PDO::FETCH_ASSOC);
        
		if(is_array($resultado_corr)==true and count($resultado_corr)==0){
        $estado_ccf ="Sin cancelar";
		$sql2 = "insert into $tabla values(null,?,?,?,?,?,?,?,?);";
		$sql2 = $conectar->prepare($sql2);
		$sql2->bindValue(1, $correlativo);
		$sql2->bindValue(2, $codigo);
		$sql2->bindValue(3, $monto_orden);
		$sql2->bindValue(4, $hoy);
		$sql2->bindValue(5, $hora);
		$sql2->bindValue(6, $id_optica);
		$sql2->bindValue(7, $id_usuario);
		$sql2->bindValue(8, $estado_ccf);
		$sql2->execute();
		
		}

		//Registrar Accion
        $accion = $documento == 'factura' ? "Registro factura" : "Registra CCF";
		$obs = "CCF No.: ".strtoupper($correlativo);
		$sql3 = "insert into acciones_orden values(null,?,?,?,?,?);";
    	$sql3 = $conectar->prepare($sql3);
    	$sql3->bindValue(1, $codigo);
    	$sql3->bindValue(2, $hoy." ".$hora);
    	$sql3->bindValue(3, $accion);
    	$sql3->bindValue(4, $obs);
    	$sql3->bindValue(5, $id_usuario);
    	$sql3->execute();

		if ($sql->rowCount() > 0 &&  $sql2->rowCount() > 0){			
			$data = ['msj'=>'okcomprobante','correlativo'=>$correlativo,'fecha_pago'=> date("d-m-Y",strtotime($diaPago))];			
		}else{
			$data = ['msj'=>$_POST];
		}
		echo json_encode($data);	
	}

	/************************ LISTAR CREDITOS FISCALES DIARIOS ***************************/
	public function getCffDiarios(){
		$conectar=parent::conexion();
    	parent::set_names();

		$sql = "select cf.id_ccf,cf.n_correlativo,cf.codigo_orden,cf.fecha,cf.fecha,cf.hora,cf.monto,o.paciente,op.nombre from creditos_fiscales as cf inner join orden as o on cf.codigo_orden=o.codigo inner join optica as op on op.id_optica=cf.id_optica limit 1000;";
		$sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getFacturasDiarios(){
		$conectar=parent::conexion();
    	parent::set_names();
		$sql = "select f.id_factura,f.n_correlativo,f.codigo_orden,f.fecha,f.hora,f.estado,o.nombre,od.paciente,f.monto from facturas as f INNER join optica as o on f.id_optica=o.id_optica INNER join orden as od on od.codigo=f.codigo_orden order by f.id_factura DESC limit 1000;";
		$sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
	}

	/*********LISTAR FACTURAS DIARIAS   *********/

	public function getCreditosMensuales(){
		$conectar=parent::conexion();
    	parent::set_names();

		$sql = "select o.nombre,o.limite_credito,sum(c.saldo) as acumulado,MIN(`fecha_fact`) AS min_fac, TIMESTAMPDIFF(DAY,MIN(`fecha_fact`),NOW()) as transc,o.id_optica from optica as o INNER join creditos as c on o.id_optica=c.id_optica where o.metodo_cobro='Mensual' group by c.id_optica HAVING sum(c.saldo) > 0;";
		$sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCreditosGneral($optica){
        $id_optica = implode("", $optica);
        $conectar=parent::conexion();
    	parent::set_names();

        $sql = "SELECT c.id_credito,cf.n_correlativo,c.monto,o.paciente,o.codigo,o.id_optica,o.id_sucursal,op.nombre,s.direccion,c.estado,c.fecha_pago,c.saldo,cf.hora,cf.fecha,c.fecha_fact,c.hora_fact,TIMESTAMPDIFF(DAY,c.`fecha_fact`,NOW()) as dias,c.abono,c.id_orden FROM creditos as c INNER join creditos_fiscales as cf on c.codigo_orden=cf.codigo_orden inner join orden as o on cf.codigo_orden=o.codigo inner join optica as op on op.id_optica=c.id_optica INNER JOIN sucursal_optica as s on c.id_sucursal=s.id_sucursal where  c.id_optica=? and c.saldo > 0 order by c.id_credito ASC;";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $id_optica);
		$sql->execute();
		return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        
    }

}//Fin clase

//$creditos = new Creditos();
//$creditos->pagoMeMensual();


///////////////////////CREDITOS CON MORA
//SELECT fecha_fact,(TIMESTAMPDIFF(DAY,`fecha_fact`,NOW())) AS transc FROM creditos where (TIMESTAMPDIFF(DAY,`fecha_fact`,NOW()) > 0);
//SELECT `id_optica`,fecha_fact,max(TIMESTAMPDIFF(DAY,`fecha_fact`,NOW())) AS transc FROM creditos where (TIMESTAMPDIFF(DAY,`fecha_fact`,NOW()) > 0 ) GROUP by `id_optica`;