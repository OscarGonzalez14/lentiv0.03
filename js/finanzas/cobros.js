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
      },*/ 
    },
  
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": 2000,//Por cada 10 registros hace una paginación
        "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
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
    let id_orden = item.dataset.idorden;
    let obj = {
      correlativo : correlativo,
      montoccf : montoccf,
      codigo : codigo,
      abonos : abonos,
      id_orden : id_orden,
      id_optica : item.dataset.idoptica,
      id_sucursal : item.dataset.idsucursal
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
let id_usuario = document.getElementById("id_usuario").value;
let forma_cobro =  $("input[type='radio'][name='forma-cobro']:checked").val(); 
let n_trans = document.getElementById("doc-abono").value;
let banco_cobro = document.getElementById("banco-cobro").value;
let id_optica = document.getElementById("id-optica").value;

if(monto == ""){ Toast.fire({icon: 'error',title: 'Especificar monto'}); return false;}

if(forma_cobro=="" || forma_cobro==null || forma_cobro==undefined){ Toast.fire({icon: 'error',title: 'Forma de cobro es un campo obligatorio.'}); return false;}

if((forma_cobro=="Transferencia" || forma_cobro=="Cheque" || forma_cobro=="Tarjeta Credito") && (banco_cobro == "" || n_trans == "")){
  Toast.fire({icon: 'error',title: 'Numero de transacción o Banco no sido seleccionado.'}); return false;
}

if(monto > total_saldos){
  Toast.fire({icon: 'error',title: 'El abono excede el total de creditos.'}); 
  return false;
}
  $.ajax({
  url:"../ajax/cobros.php?op=registrar_cobros",
  method:"POST",
  data : {'arrayccf':JSON.stringify(arrayccf),'monto':monto,'id_usuario':id_usuario,'forma_cobro': forma_cobro,'n_trans': n_trans,'banco_cobro': banco_cobro,'id_optica':id_optica},
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
    //$("#datatable_listar_cobros").DataTable().ajax.reload(); 
    const abonos_comp = data.abonos_completos;
    console.log(abonos_comp)
    for(var i = 0; i < abonos_comp.length; i++){
      let id_orden = abonos_comp[i];
      document.getElementById(id_orden).style.textDecoration = "line-through green";
    }

    const abonos_parc = data.abonos_parciales;
    for(var j = 0; j < abonos_parc.length; j++){
      let id_ordenp = abonos_parc[j];
      document.getElementById(id_ordenp).style.textDecoration = "line-through orange";
    }
  }
  });
}

function historialAbonos(){
  let id_optica = document.getElementById("id-optica").value;
  $("#resumen-abonos").modal();
  dtTemplateCobros("datatable_resumen_cobros","resumen_cobros",id_optica)
  
}

function verDetRecibo(id_optica,recibo,nombre){
  $("#detalle-recibo").modal();
  document.getElementById("title-cobros-recibo").innerHTML= `Recibo: ${recibo}     *     Optica: ${nombre}`;
  dtTemplateCobros("datatable_det_recibos","detalle_recibos",recibo,id_optica)
}
initCobros();