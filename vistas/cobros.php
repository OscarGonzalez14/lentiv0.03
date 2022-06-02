<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["usuario"]) and isset($_SESSION['id_usuario'])){
$cat_admin = $_SESSION["categoria"];

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
  
.buttons-excel{
    background-color: green !important;
    margin: 2px;
    max-width: 150px;
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
      <div class="container-fluid">
        <h1 style="font-size: 15px; text-align: center;padding: 3px"><u><b>CREDITOS Y COBROS</b></u></h1>

        <div class="col-md-12">
        <div class="card card-info collapsed-card">
          <div class="card-header">
              <h5 class="card-title" style="font-size: 16px;"> COMPROBANTES DE CREDITO FISCAL</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool btn-xs bg-secondary" data-card-widget="collapse" onClick="get_ccf_hoy();"><i class="far fa-calendar-check"></i> Hoy
                  </button>
                <button type="button" class="btn btn-tool btn-xs" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
              </div>
          </div>
            <div class="card-body">
            <style>
                .buttons-excel{background-color: #fff !important;margin: 2px;max-width: 150px;color: black;
                 border: solid 1px green;
                }
            </style>
            <button type="button" class="btn btn-tool bg-light btn-xs"><i class="fas fa-search"></i> Por fecha</button>
            <button type="button" class="btn btn-tool bg-light btn-xs"><i class="fas fa-search"></i> Por Rango</button><br>
           <table width="100%" class="table-hover table-bordered" id="datatable_ccf" data-order='[[ 0, "desc" ]]' style="margin-top: 3px">        
               <thead class="style_th bg-dark" style="color: white">
                 <th>Id</th>
                 <th>Correlativo</th>
                 <th>#Orden</th>
                 <th>Paciente</th>
                 <th>Optica</th>
                 <th>Sucursal</th>
                 <th>Monto</th>
                 <th>Fecha fect.</th>
                 <th>Acciones</th>
               </thead>
               <tbody class="style_th"></tbody>
             </table>
            </div>
        </div>
      </div>

      </div><!-- /.container-fluid -->
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
<script type="text/javascript" src="../js/finanzas/facturacion.js"></script>
<script type="text/javascript" src='../js/bootbox.min.js'></script>
<script type="text/javascript" src='../js/cleave.js'></script>

<script>
  function EnterEvent(){

    let validaEvent = $("#validate-event").val()
    let id_sucursal = $("#id_suc_fact").val();
    let key = event.keyCode;
    if (key==13 && id_sucursal != "" && validaEvent == "1") {
      dialogPrint();        
    }
  }
  window.onkeydown = EnterEvent;
</script>

  </footer>
  </div> <!--fin content wrapper-->
</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>