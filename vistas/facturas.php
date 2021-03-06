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
        <h1 style="font-size: 15px; text-align: center;padding: 3px"><u><b>EMISION DE FACTURAS</b></u></h1>
        <div class="row">
          <div class="col-sm-2">
            <input type="search" class="form-control" id="codigo-orden-fact" onchange="getDataOrdenFact('factura')">
          </div>
          <div class="col-sm-1">
            
          </div>
          <div class="col-sm-1">
            
          </div>
          <div class="col-sm-2">
            
          </div>
        </div>
        <br>
        <section>
          <input type="hidden" id="id_optica_fact" class="data-fct"><input type="hidden" id="id_suc_fact" class="data-fct">
          <table class="table-bordered shadow-sm p-3 mb-2 bg-white rounded" width="100%" style="text-align: center;"><!--Info sucursal-->
          <table class="table-bordered shadow-sm p-3 mb-2 bg-white rounded" width="100%" style="text-align: center;"><!--Info sucursal-->
            <tr class="bg-primary">
              <td colspan="25" style="width: 25%">Paciente</td>
              <td colspan="25" style="width: 25%">Optica</td>
              <td colspan="20" style="width: 20%">Tipo lente</td>
              <td colspan="15" style="width: 15%">Monto</td>
              <td colspan="15" style="width: 15%"><i class="fas fa-print"></i> Imprimir</td>
            </tr>
            <tr>
              <td colspan="25" id="det_pac_orden" style="padding: 5px;width: 25%"></td>
              <td colspan="25" id="det_orden_optica" style="padding: 5px;width: 25%" class="data-fact-inner"></td>
              <td colspan="20" id="det_lente_ord" style="padding: 5px;width: 20%" class="data-fact-inner"></td>
              <td colspan="15" style="padding: 5px;width: 15%">$<span id="monto_orden" class="data-fact-inner"> </span></td>
              <td colspan="15" id="det_trats_lente_ordx" style="padding: 5px;width: 15%"><button type="button" class="btn btn-sm btn-outline-primary btn-flat" onClick="printFacturacion('ccf');"> CCF</button>
            </tr>   
          </table>        
        </section>


        <div class="col-md-12">
        <div class="card card-info">
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
           <table width="100%" class="table-hover table-bordered" id="datatable_factura" data-order='[[ 0, "desc" ]]' style="margin-top: 3px">        
               <thead class="style_th bg-dark" style="color: white">
                 <th>Id</th>
                 <th>Correlativo</th>
                 <th>#Orden</th>
                 <th>Paciente</th>
                 <th>Optica</th>
                 <th>Monto</th>
                 <th>Fecha fact.</th>
                 <th>Estado</th>
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
    <input type="hidden" id="id_orden" class="data-fct">
    <input type="hidden" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>">
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