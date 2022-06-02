<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["usuario"])){
$cat_admin = $_SESSION["categoria"];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
<?php require_once("links_plugin.php");
 require_once('../modales/nueva_optica.php');
 require_once('../modales/nueva_sucursal.php');
 ?>
<style>
  
.buttons-excel{
    background-color: green !important;
    margin: 2px;
    max-width: 150px;
}

.list-group-item:hover{
  border: solid 1px #B8B8B8;
  color: black;
}

.list-group-horizontal .list-group-item
{
  display: inline-block;
}

.list-group-item:hover{
  background-color: #212534;
  color: white;
}

.list-group-horizontal .list-group-item:first-child
{
  border-top-right-radius:0;
  border-bottom-left-radius:4px;
}
.list-group-horizontal .list-group-item:last-child
{
  border-top-right-radius:4px;
  border-bottom-left-radius:0;
  border-right-width: 1px;
}
.hide{
  visibility: hidden;
}
</style>

</head>
<body class="hold-transition sidebar-mini layout-fixed" style='font-family: Helvetica, Arial, sans-serif;'>
	<div class="wrapper">
<!-- top-bar -->
  <?php require_once('top_menu.php');?>
  <!-- /.top-bar -->

  <!-- Main Sidebar Container -->
  <?php require_once('side_bar.php');?>
  <!--End SideBar Container-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
      <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['codigo_emp']?>"/>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION["usuario"];?>"/>
     <div class="card-body" style="margin-top: 0px solid red;color: black !important">

        <a data-toggle="modal" data-target="#nueva_optica" data-backdrop="static" data-keyboard="false" id="nueva_optica" class="btn btn-app" style="color: black;border: solid #0275d8 1px;">
          <i class="fas fa-eye" style="color:green"></i> REGISTRAR OPTICA
        </a>

        <a data-toggle="modal" data-target="#nueva_sucursal_optica" onClick="get_correlativo_sucursal();" data-backdrop="static" data-keyboard="false" id="nueva_sucursal" class="btn btn-app" style="color: black;border: solid #0275d8 1px;">
          <i class="fas fa-folder-plus" style="color:#08088A"></i> AGREGAR SUCURSAL
        </a>
    </div> 
      <div class="card card-dark card-outline" style="margin: 2px;">
        <h5 style="text-align: center; font-size: 14px" align="center" class="bg-info">SUCURSALES OPTICAS </h5>
       <table width="100%"  style="text-align:center;" class="table-hover table-bordered" id="dt_sucursales_opti" data-order='[[ 0, "desc" ]]' style="max-height:2px;">        
         <thead class="style_th bg-dark" style="color: white">
           <th style="text-align:center;width:10%;">Código</th>
           <th style="text-align:center;width:20%;">Óptica</th>
           <th style="text-align:center;width:10%;">Teléfono</th>
           <th style="text-align:center;width:30%;">Dirección</th>
           <th style="text-align:center;width:10%;">Acciones</th>
         </thead>
         <tbody></tbody>
       </table>
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-----------------MODAL OPCION SEMANA------>
<div class="modal fade" id="semana_opcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <span style="padding: 3px; font-size: 13px">SELECIONAR DIA DE COBRO</span>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 3px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

    <div class="container">
      <ul class="list-group list-group-horizontal">
        <li class="list-group-item" onClick="seleccionarDia('Lunes')">LUN.</li>
        <li class="list-group-item" onClick="seleccionarDia('Martes')">MAR.</li>
        <li class="list-group-item" onClick="seleccionarDia('Miercoles')">MIE.</li>
        <li class="list-group-item" onClick="seleccionarDia('Jueves')">JUE.</li>
        <li class="list-group-item" onClick="seleccionarDia('Viernes')">VIE.</li>
        <li class="list-group-item" onClick="seleccionarDia('Sabado')">SAB.</li>
      </ul>
    </div>

    </div>
    </div>
  </div>
</div>
<!----------------- FIN MODAL OPCION SEMANA------>




<!-----------------MODAL OPCION FECHA ESPECIFICA------>
<div class="modal fade" id="fecha_especifica_opcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <span style="padding: 3px; font-size: 13px">SELECIONAR FECHA DE COBRO</span>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 3px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

    <div class="container" style="display: flex;align-items: center;justify-content: center;">
      <section>
      <ul class="list-group list-group-horizontal">
        <li class="list-group-item" onClick="seleccionarFecha('1')"><span class="hide">1</span>1</li>
        <li class="list-group-item" onClick="seleccionarFecha('2')"><span class="hide">1</span>2</li>
        <li class="list-group-item" onClick="seleccionarFecha('3')"><span class="hide">1</span>3</li>
        <li class="list-group-item" onClick="seleccionarFecha('4')"><span class="hide">1</span>4</li>
        <li class="list-group-item" onClick="seleccionarFecha('5')"><span class="hide">1</span>5</li>
        <li class="list-group-item" onClick="seleccionarFecha('6')"><span class="hide">1</span>6</li>
        <li class="list-group-item" onClick="seleccionarFecha('7')"><span class="hide">1</span>7</li>
        <li class="list-group-item" onClick="seleccionarFecha('8')"><span class="hide">1</span>8</li>
        <li class="list-group-item" onClick="seleccionarFecha('9')"><span class="hide">1</span>9</li>
        <li class="list-group-item" onClick="seleccionarFecha('10')">10</li>
      </ul>

      <ul class="list-group list-group-horizontal">
        <li class="list-group-item" onClick="seleccionarFecha('11')">11</li>
        <li class="list-group-item" onClick="seleccionarFecha('12')">12</li>
        <li class="list-group-item" onClick="seleccionarFecha('13')">13</li>
        <li class="list-group-item" onClick="seleccionarFecha('14')">14</li>
        <li class="list-group-item" onClick="seleccionarFecha('15')">15</li>
        <li class="list-group-item" onClick="seleccionarFecha('16')">16</li>
        <li class="list-group-item" onClick="seleccionarFecha('17')">17</li>
        <li class="list-group-item" onClick="seleccionarFecha('18')">18</li>
        <li class="list-group-item" onClick="seleccionarFecha('19')">19</li>
        <li class="list-group-item" onClick="seleccionarFecha('20')">20</li>
      </ul>

      <ul class="list-group list-group-horizontal">
        <li class="list-group-item" onClick="seleccionarFecha('21')">21</li>
        <li class="list-group-item" onClick="seleccionarFecha('22')">22</li>
        <li class="list-group-item" onClick="seleccionarFecha('23')">23</li>
        <li class="list-group-item" onClick="seleccionarFecha('24')">24</li>
        <li class="list-group-item" onClick="seleccionarFecha('25')">25</li>
        <li class="list-group-item" onClick="seleccionarFecha('26')">26</li>
        <li class="list-group-item" onClick="seleccionarFecha('27')">27</li>
        <li class="list-group-item" onClick="seleccionarFecha('28')">28</li>
        <li class="list-group-item" onClick="seleccionarFecha('29')">29</li>
        <li class="list-group-item" onClick="seleccionarFecha('30')">30</li>
      </ul>
      </section>
    </div>

    </div>
    </div>
  </div>
</div>
<!----------------- FIN MODAL OPCION FECHA ESPECIFICA------>

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
<script type="text/javascript" src='../js/opticas.js'></script>
<script type="text/javascript" src='../js/bootbox.min.js'></script>
<script type="text/javascript" src='../js/cleave.js'></script>

  </footer>
  </div> <!--fin content wrapper-->
</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>