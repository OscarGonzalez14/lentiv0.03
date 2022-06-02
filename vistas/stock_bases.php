<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["usuario"])){

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
<?php require_once("links_plugin.php"); 
 require_once('../modelos/Productos.php');
 require_once('../modales/warehouseIncome/modalIngresoBasevs.php');
 require_once('../modales/warehouseIncome/modalIngresosFlaptop.php');
 require_once('../modales/new_barcode_lentes.php');
 require_once('../modales/warehouseIncome/modalCrearTablaBase.php'); 
 require_once('../modelos/Stock.php');
 $marcas = ['Divel', 'Essilor'];
 require_once '../modelos/Stock.php';
 $stock = new Stock();

 date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H-i-s");
 ?>
<style>
  .buttons-excel{
    background-color: green !important;
    margin: 2px;
    max-width: 150px;
  }

  .stilot1{
    border: 1px solid black;
    padding: 5px;
    font-size: 12px;
    font-family: Helvetica, Arial, sans-serif;
    border-collapse: collapse;
    text-align: center;
  }

  .stilot2{
    border: 1px solid black;
    text-align: center;
    font-size: 11px;
    font-family: Helvetica, Arial, sans-serif;
  }
  .stilot3{
    text-align: center;
    font-size: 11px;
    font-family: Helvetica, Arial, sans-serif;
  }

  #table2 {
    border-collapse: collapse;
  }

  .filasb:hover {
    background-color: lightyellow;
  }

</style>

  <script src="../plugins/exportoExcel.js"></script>
  <script src="../plugins/keymaster.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed" style='font-family: Helvetica, Arial, sans-serif;'><div class="wrapper">
<!-- top-bar -->
  <?php 
  require_once("../modelos/Pruebas.php");
  $productos = new Productos();  
  require_once('top_menu.php')?>

  <?php require_once('side_bar.php');   
  ?>
  <div class="content-wrapper">

    <button class="btn btn-sm btn-outline-info btn-flat" data-toggle="modal" data-target="#newTableBaseVs"><i class="fas fa-table" style="border-radius: 3px"></i> CREAR TABLA</button>
    <section class="content" style="border: #D0D0D0 2px solid;border-radius: 5px;margin-top: 2px">
      <h5 style="padding: 2px;text-align: center;font-size: 16px;border-radius: 3px;font-weight: bold">BASES VISIÓN SENCILLA</h5>
      <input type="hidden" id="tipo_lente_code">
      <div class="row" style="margin-top: 3px">
        <?php
        $i=0;
        foreach ($marcas as $val) { 
         ($i % 2 == 0) ? $color='info': $color='primary';
         ($i % 2 == 0) ? $borde='#5bc0de': $borde='#0275d8';
        ?>
          <div class="col-md-12">
          <div class="card card-<?php echo $color;?> collapsed-card" style="border: solid 1px <?php echo $borde;?>">
          <div class="card-header">
              <h5 class="card-title" style="font-size: 16px"><?php echo ($i+1)." - BASES VISIÓN SENCILLA ".strtoupper($val);?></h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" onClick="get_dataTableBase('<?php echo 'base'.$val;?>','<?php echo $val;?>');" id="expandir"><i class="fas fa-plus"></i>
                  </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
              </div>
          </div>
            <div class="card-body">
            <table id="<?php echo 'base'.$val;?>" width="100%" class="table-bordered" style="margin-top: 0px;font-size:14px">
              
            </table>
            </div>
        </div>
      </div>
        <?php $i++; } ?>
      </div>
    </section>
    <br>
    <section class="content" style="border: #8EB7C7 2px solid;border-radius: 5px;margin-top: 2px">
    <h5 style="padding: 2px;text-align: center;font-size: 16px;border-radius: 3px;font-weight: bold">BASES FLAPTOP</h5>
      <?php 
        $j=0;
        foreach ($marcas as $m) {
          $tablas_base = $stock->getTablesBasesFlaptop($m);
          foreach ($tablas_base as $t) { 
           ($j % 2 == 0) ? $color='dark': $color='primary';
           ($j % 2 == 0) ? $borde='#5bc0de': $borde='#0275d8';
           ?>
           <!--TABLAS BASES BIFIOCAL-->
          <div class="col-md-12">
          <div class="card card-<?php echo $color;?> collapsed-card" style="border: solid 1px <?php echo $borde;?>">
            <div class="card-header">
              <h5 class="card-title" style="font-size: 16px"><?php echo ($j+1)." ".strtoupper($t["titulo"]." ".$m);?></h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" onClick="get_dataTableBasesFtop('<?php echo $t["id_tabla_base"];?>','<?php echo "contenft".$t["id_tabla_base"];?>','<?php echo $t["marca"];?>','<?php echo $t["diseno"];?>');"><i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" onClick="addBase('<?php echo $t["id_tabla_base"];?>','<?php echo $t["marca"];?>','<?php echo $t["diseno"];?>','<?php echo strtoupper($t["titulo"]);?>')"><i class="fas fa-plus-circle"></i></button> 
                </div>
            </div>
            <div class="card-body" id="<?php echo 'contenft'.$t["id_tabla_base"];?>"></div>
          </div>
          </div>
           <!--FIN TABLAS BASES BIFIOCAL-->
          <?php $j++; } ?>
          <?php
        } ?>
    </section> 
       
  <!----------- MODAL AGREGAR BASES ------------>

  <div class="modal" id="newBase">
  <div class="modal-dialog" style="max-width: 35%">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title stilot3" style="font-size: 12px;" id="title-table-base"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <div style="margin: auto;display: block">
            <label for="">Agregar base</label>
            <input type="number" class="form-control" id="name_base_tb" style="margin: auto;">
          </div>
      </div>
      <input type="hidden" id="id_tabla_base_new">
      <input type="hidden" id="marca_base_new">
      <input type="hidden" id="diseno_base_new">

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="registrarNuevaBaseAtabla()"><i class="fas fa-save"></i> Agregar</button>
      </div>

    </div>
  </div>
</div>

<!-- MODAL EDITAR Y ELIMINAR BASES VS -->
<div class="modal modal-xs" tabindex="-1" id="editdelete_gradvs">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div><h5 style="text-align: center;font-size: 14px;text-transform: uppercase;">ACCIONES BASE <span id="tit-grad-basevs-edit"> </span></h5></div>
        <div><h5 style="text-align: center;font-size: 12px;text-transform: uppercase;"><b>BASE <span id="basevs-edit"> </span></b></h5></div>
        <div style="display: flex;justify-content: center;">
        <a class="btn btn-app" style="color: black;border: solid #5bc0de 1px;" onClick="EditarBaseVs()">          
          <i class="fas fa-edit" style="color: #5cb85c"></i> Editar
        </a>

        <a class="btn btn-app" style="color: black;border: solid #5bc0de 1px;" onClick="EliminarBaseVs()">          
          <i class="fas fa-trash" style="color: #d9534f"></i> Eliminar
        </a>
        </div>
        <input type="hidden" id="cod-grad-basevs-edit">
        <input type="hidden" id="id-basevs-edit">
        <input type="hidden" id="id-tabla-basevs-edit">
        <input type="hidden" id="id-marca-basevs-edit">
      </div>
    </div>
  </div>
</div>


<input type="hidden" id="id_usuario" value="<?php echo $_SESSION["id_usuario"]; ?>">
  </div>

<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>2021 Lenti || <b>Version</b> 1.0</strong>
   &nbsp;All rights reserved.
  <div class="float-right d-none d-sm-inline-block">      
</div>
<?php require_once("links_js.php"); ?>
<script type="text/javascript" src="../js/productos.js"></script>
<script type="text/javascript" src="../js/stock.js"></script>
</footer>
</div>
</body>
</html>
<?php } else{
  echo "Acceso denegado";
} ?>


