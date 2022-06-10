<?php

require_once("../config/conexion.php");

class Cobros extends conectar{

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


    
}