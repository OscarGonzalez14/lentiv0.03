function listarCobrosRango(fecha){
    dtTemplateCobros("datatable_listar_cobros","obtener_creditos_rango",fecha)
  }
  function dtTemplateCobros(table,route,...Args){
      console.log(Args); 
      tabla = $('#'+table).DataTable({      
      "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip',//Definimos los elementos del control de tabla
      buttons: [     
        'excelHtml5',
      ],
  
      "ajax":{
        url:"../ajax/creditos.php?op=" + route,
        type : "POST",
        data: {argumentos:Args},
        dataType : "json",       
        error: function(e){
        console.log(e.responseText);
      },           
      },
  
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": 25,//Por cada 10 registros hace una paginación
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

    listarCobrosRango(fecha);
}