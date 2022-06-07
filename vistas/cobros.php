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

        <div class="card card-info">
          <div class="card-header">
              <h5 class="card-title" style="font-size: 16px;"> COMPROBANTES DE CREDITO FISCAL</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool btn-xs bg-secondary"  onClick="get_ccf_hoy();"><i class="far fa-calendar-check"></i> Hoy
                  </button>
                
              </div>
          </div>
            <div style="margin: 0px !important">
            <style>
                .buttons-excel{background-color: #fff !important;margin: 2px;max-width: 150px;color: black;
                 border: solid 1px green;
                }
            </style>
          <div class="form-row" style="margin:3px">
          <div class=" form-group col-sm-3 select2-purple">
              <label for="ex3">Óptica</label>
              <select class="select2 form-control clear_input" id="optica-cobro" multiple="multiple" data-placeholder="Seleccionar optica" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">              
                <option value="0">Seleccione Optica</option>
                <?php
                for ($i=0; $i < sizeof($opti); $i++) { ?>
                  <option value="<?php echo $opti[$i]["id_optica"]?>"><?php echo strtoupper($opti[$i]["nombre"]);?></option>
                <?php  } ?>              
              </select>               
          </div>

          <div class=" form-group col-sm-4 select2-purple">
              <label for="ex3">Sucursal</label>
              <select class="select2 form-control clear_input" id="sucursal-cobro" multiple="multiple" data-placeholder="Seleccionar sucursal" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">              
                <option value="0">Seleccione sucursal</option>
              </select>               
          </div>

          <div class=" form-group col-sm-1">
              <label for="ex3">Filtrar</label>
              <button type="button" class="btn btn-block btn-dark" data-toggle="modal" data-target="#filtrar-creditos" onClick="resetDatePicker();"><i class="fas fa-search"></i></button>
          </div>

          <div class=" form-group col-sm-2">
              <label for="ex3">Abonar</label>
              <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#filtrar-creditos"><i class="	fas fa-hand-holding-usd"></i> Selecc.</button>
          </div>

          
          <div class=" form-group col-sm-2">
              <label for="ex3">Abono</label>
              <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#filtrar-creditos"><i class="	fas fa-hand-holding-usd"></i> Parcial</button>
          </div>

          </div><!--Fin form row-->
           <table width="100%" class="table-hover table-bordered" id="datatable_listar_cobros" data-order='[[ 0, "desc" ]]' style="margin-top: 3px">        
               <thead class="style_th bg-dark" style="color: white">
                 <th>Id</th>
                 <th><label><input type="checkbox" id="select-all-cobrar-chk" class="form-check-label" onClick="selectOrdenesCobrar()"> Sel.</label></th>
                 <th>#Orden</th>
                 <th>#Comprobante</th>
                 <th>Paciente</th>
                 <th>Optica</th>
                 <th>Sucursal</th>
                 <th>Monto</th>
                 <th>Estado</th>
                 <th>Saldo</th>
                 <th>Fecha Fact.</th>
                 <th>Fecha pago</th>
                 <th>Mora</th>
               </thead>
               <tbody class="style_th"></tbody>
             </table>
            </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.Modal FILTRAR CREDITOS -->
    <section>
         <!-- Modal -->
  <div class="modal fade" id="filtrar-creditos" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <div class="form-group">
        <label>Seleccionar rango:</label>
        <div class="input-group">
          <input type="text" class="form-control float-right" id="rango-cobro" name="daterange"  value="2000-05-05">
        </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
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
<script type="text/javascript" src="../js/finanzas/cobros.js"></script>
<script type="text/javascript" src='../js/bootbox.min.js'></script>
<script type="text/javascript" src='../js/cleave.js'></script>

<script>

function resetDatePicker(){
 // $("#rango-cobro").datepicker('setDate', "");​
 var today = new Date();

  $('input[name="daterange"]').daterangepicker({
    locale: {
      format: 'DD-MM-YYYY',
              separator: " hasta "

        }
  }, function(start, end, label) {
    let fecha = start.format('DD-MM-YYYY') + '/' + end.format('DD-MM-YYYY');
    filtrarFechas(fecha)
  });
}
</script>

  </footer>
  </div> <!--fin content wrapper-->
</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>


