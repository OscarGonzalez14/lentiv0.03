<?php

require_once("../config/conexion.php");
//require_once('../vistas/side_bar.php');
class Pruebas extends Conectar{

	public function get_data_ar_green_term(){
		$conectar=parent::conexion();
    parent::set_names();

    $sql="select * from lente_terminado;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
	}

  public function permisos(){
    $conectar=parent::conexion();
    parent::set_names();

    $sql="select * from usuario_permiso where id_usuario=1;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataIn($arr){

    $conectar=parent::conexion();
    parent::set_names();

    $arreglo = implode(",", $arr);

    $sql="SELECT * FROM `orden` WHERE id_orden IN(?);";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$arreglo);
    $sql->execute();
    return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);

  }
}


$prueba = new Pruebas();

$data = $prueba->getDataIn([1,3]);

var_dump($data);
