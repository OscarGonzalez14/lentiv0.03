<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["usuario"]) and isset($_SESSION['id_usuario'])){
$cat_admin = $_SESSION["categoria"];

require_once("../modelos/Opticas.php");
$optica = new Opticas();
$opti=$optica->obtener_opticas();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
<?php require_once("links_plugin.php");

 ?>
<style>
  
.buttons-excel{background-color: #fff !important;margin: 2px;max-width: 150px;color: black;
                 border: solid 1px green;
                }
body{
  font-family: Helvetica, Arial, sans-serif;

}
.swal2-deny{
  background-color: #088da5 !important;
  padding: 0.375rem 0.75rem;
  font-size: 1rem; 
}

.swal2-title{
  font-family: Helvetica, Arial, sans-serif;
  font-size: 20px;
  color: #468499
}

</style>

</head>
<body class="hold-transition sidebar-mini layout-fixed" style='font-family: Helvetica, Arial, sans-serif;'>
	<div class="wrapper">
<!-- top-bar -->
  <?php require_once('top_menu.php');?>
  <!-- Main Sidebar Container -->
  <?php require_once('side_bar.php');?>
  <!--End SideBar Container-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">


    <div class="card card-warning card-outline" style="margin: 2px;margin-top: 0px !important">
      <h5 style="text-align: center; font-size: 16px" align="center" class="bg-dark">CUENTAS POR COBRAR</h5>
      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="margin-top: 0px !important">
        <li class="nav-item"  onClick="getCuentasMensuales()">
          <a class="nav-link" style="background:  #F5FCFF;cursor:pointer;"><i class="fas fa-hand-holding-usd" style="color: black" onClick="getCuentasMensuales()"></i> Mensual</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" style="background:  #F5FCFF;cursor:pointer;"><i class="fas fa-hand-holding-usd" style="color: black" onClick="getCuentasMensuales()"></i> Quincenal</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" style="background:  #F5FCFF;cursor:pointer;"><i class="fas fa-hand-holding-usd" style="color: black" onClick="getCuentasMensuales()"></i> Semanal</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" style="background:  #F5FCFF;cursor:pointer;"><i class="fas fa-hand-holding-usd" style="color: black" onClick="getCuentasMensuales()"></i> Contado</a>
        </li>        

    </div>


    <div class="container-fluid">
      <table width="100%" class="table-hover table-bordered" id="dt_cobros_mensuales" data-order='[[ 0, "desc" ]]' style="margin-top: 3px">        
        <thead class="style_th bg-dark" style="color: white">
          <th>Optica</th>
          <th>Limite credito</th>
          <th>Acumulado</th>
          <th>Ultima Factura</th>
          <th>Trancurridos</th>
          <th>Detalles</th>
        </thead>
        <tbody class="style_th"></tbody>
      </table>         
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.Modal FILTRAR CREDITOS -->
    
    <section>
 
  <?php require_once("../modales/modal_detalle_cobros.php");?>
  
    </section>
    <!-- /.content -->
    <input type="hidden" id="codigo_orden_fact" value="0" class="data-fct">
    <input type="hidden" id="dia_de_pago" class="data-fct">
    <input type="hidden" id="fecha_registro" class="data-fct">
    <input type="hidden" id="metodo_cobro" class="data-fct">
   </div>

  <footer class="main-footer">
    <strong>2021 Lenti || <b>Version</b> 1.0</strong>
     &nbsp;All rights reserved.
    <div class="float-right d-none d-sm-inline-block">      
    </div>
</div>
    <?php 
require_once("links_js.php");
?>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $(".select2").select2({
    maximumSelectionLength: 1
});
})  
</script>
<script type="text/javascript" src="../js/finanzas/cobros.js"></script>
<script type="text/javascript" src='../js/bootbox.min.js'></script>
<script type="text/javascript" src='../js/cleave.js'></script>

<script>

function resetDatePicker(){
 // $("#rango-cobro").datepicker('setDate', "");​
 var today = new Date();


}
</script>

  </footer>

</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>


