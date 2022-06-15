let Toast = Swal.mixin({
  toast: true,
  position: 'top-center',
  showConfirmButton: false,
  timer: 3000
});


function initCobros(){
  console.log("Reinciando js...")
}

function ProofCobros(table,route,...Args){

  $.ajax({
    url:"../ajax/cobros.php?op="+route,
    method:"POST",
    data : {Args:Args},
    cache:false,
    dataType: "html",
    success:function(data){
      console.log(data)
    }
  });
}

function getCuentasMensuales(){
  dtTemplateCobros("dt_cobros_mensuales","listar_creditos_mensuales","0");
}


function listarCobrosRango(fecha,optica){
  dtTemplateCobros("datatable_listar_cobros","obtener_creditos_rango",fecha,optica)
}

function listarCobrosGeneral(id_optica){
  dtTemplateCobros("datatable_listar_cobros","obtener_creditos_general",id_optica)
}

function dtTemplateCobros(table,route,...Args){

      tabla = $('#'+table).DataTable({      
      "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip',//Definimos los elementos del control de tabla
      buttons: [     
        'excelHtml5',
      ],
  
      "ajax":{
        url:"../ajax/cobros.php?op="+ route,
        type : "POST",
        data: {Args:Args},
        dataType : "json",
         
        error: function(e){
        console.log(e.responseText);
      },      
      /*success: function(result) {
        console.log(result.aaData)
    },  */ 
    },
  
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": 100,//Por cada 10 registros hace una paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
        "language": { 
        "sProcessing":     "Procesando...",       
        "sLengthMenu":     "Mostrar _MENU_ registros",       
        "sZeroRecords":    "No se encontraron resultados",       
        "sEmptyTable":     "Ningún dato disponible en esta tabla",       
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",       
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",       
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",    
        "sInfoPostFix":    "",       
        "sSearch":         "Buscar:",       
        "sUrl":            "",       
        "sInfoThousands":  ",",       
        "sLoadingRecords": "Cargando...",       
        "oPaginate": {       
            "sFirst":    "Primero",       
            "sLast":     "Último",       
            "sNext":     "Siguiente",       
            "sPrevious": "Anterior"       
        },   
        "oAria": {       
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",       
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"   
        }}, //cerrando language
    });

     
}
var arrayccf = [];
function getValuesCcf(){
  arrayccf = [];
  $("#modal-abonos").modal();
  let spans = document.getElementsByClassName("correlativos-ccf");
  for(let i=0; i<spans.length; i++){
    let id = spans[i].id;
    let item = document.getElementById(id);
    let correlativo = item.dataset.spans;
    let montoccf = item.dataset.montoccf;
    let codigo = item.dataset.codigo;
    let abonos = item.dataset.abonos;
    let obj = {
      correlativo : correlativo,
      montoccf : montoccf,
      codigo : codigo,
      abonos : abonos
    }
    arrayccf.push(obj);
  }
  console.log(arrayccf);
/*sumar valores de objetos*/
let total_abonos = arrayccf.reduce((sum, value) => ( sum + parseFloat(value.montoccf)), 0);
  document.getElementById("totales-saldo").value = total_abonos;
}


$(document).ready(function(){
    $("#optica-cobro").change(function () {         
      $("#optica-cobro option:selected").each(function () {
       let id_optica = $(this).val();         
       $.ajax({
        url:"../ajax/opticas.php?op=listar_sucursales_optica_id",
        method:"POST",
        data : {id_optica:id_optica},
        cache:false,
        dataType:"json",
        success:function(data){
            listarSucursalesCobro(data);
        }
      });
    });
  })
});

function listarSucursalesCobro(data){
    $("#sucursal-cobro").empty();
    $("#sucursal-cobro").select2({
        data: data
    })
}

function filtrarFechas(fecha){
    let optica = document.getElementById("optica-cobro").value;
    let sucursales = document.getElementById("sucursal-cobro").value;

    listarCobrosRango(fecha,optica);
}


function verDetCobrosOptica(id_optica,nombre){
  console.log(id_optica);
  $("#modal-det-cobros").modal();
  $('input[name="daterange"]').daterangepicker({
    locale: {
      format: 'DD-MM-YYYY',
              separator: " hasta "

        }
  }, function(start, end, label) {
    let fecha = start.format('DD-MM-YYYY') + '/' + end.format('DD-MM-YYYY');   
    //filtrarFechas(fecha)
  });

  document.getElementById("id-optica").value = id_optica;
  document.getElementById("title-cobros-gen").innerHTML = nombre;
  let optica = document.getElementById("id-optica").value;
  listarCobrosGeneral(optica);

}

function registrarCobro(){
let monto = parseFloat($("#monto-abono").val());
let total_saldos = parseFloat(document.getElementById("totales-saldo").value);

console.log(typeof monto , typeof total_saldos)

if(monto > total_saldos){
  Toast.fire({icon: 'error',title: 'El abono excede el total de creditos.'}); 
  return false;
}
  $.ajax({
  url:"../ajax/cobros.php?op=registrar_cobros",
  method:"POST",
  data : {'arrayccf':JSON.stringify(arrayccf),'monto':monto},
  cache:false,
  dataType:"json",
  success:function(data){
    console.log(data);   
    Swal.fire({
      title: '<span style="font-size:15px">Cobro realizado exitosamente!</span>',
      icon: 'success',
      html:
        '<span>'+data.completos+'</span><br>' +
        '<span>'+data.parciales+'</span> ',
      showCloseButton: true,
      focusConfirm: true,
      confirmButtonText: '<i class="fa fa-print"></i> Imprimir recibo de abono!'
    })
    ///Actualizar Datatables!!
    $("#modal-abonos").modal('hide');
    $("#datatable_listar_cobros").DataTable().ajax.reload(); 

  }
  });
}
initCobros();