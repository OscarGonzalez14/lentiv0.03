
function init_fact(){
  $('#codigo-orden-fact').val("");
  $('#codigo-orden-fact').focus();
  
}

///////////////////////// TEMPLATE DATATABLE /////////////
function get_ccf_hoy(){
  dtTemplate("datatable_ccf","listar_ccf_diarios")
}
function dtTemplate(table,route){
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

function alertsFacturacion(icono, titulo){
  Swal.fire({
    position: 'top-center',
    icon: icono,
    title: titulo,
    showConfirmButton: true,
    timer: 2500
  });
}

function getDataOrdenFact(){
	let cod_orden_act = document.getElementById("codigo-orden-fact").value;
	$.ajax({
    url:"../ajax/ordenes.php?op=get_data_oden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      if (data=='error') {
    	alertsFacturacion("error", "Error codigo de orden"); return false
      }else{
      	$("#codigo_orden_fact").val(data.codigo);
        $("#id_optica_fact").val(data.id_optica);
        $("#id_suc_fact").val(data.id_sucursal);
      	$("#det_pac_orden").html(data.paciente);
      	$("#det_orden_optica").html(data.optica+" - "+data.sucursal);
      	$("#det_lente_ord").html(data.tipo_lente);   
      	$("#monto_orden").html(data.precio);
        $("#validate-event").val("1");
        $("#dia_de_pago").val(data.fecha_cobro);
        $("#fecha_registro").val(data.fecha_registro);
        $("#metodo_cobro").val(data.metodo_cobro);
        confirmaRegistro();
      }         
    }
});
  
}

function confirmaRegistro(){
      let paciente = $("#det_pac_orden").html();
      Swal.fire({
      title: 'Confirmar registro de CCF',
      icon: 'success',
      html: 'Paciente: <b>'+ paciente +'</b>',
      showCancelButton: false,
      focusConfirm: true,
      confirmButtonText:'<i class="fa fa-print"></i> Imprimir!',
      }).then((result) => {
      if (result.isConfirmed) {
        registraCCF();
       //printFacturacion("ccf");
      }
    })
}

function printFacturacion(doc){
	let codigo = $("#codigo_orden_fact").val();
	let paciente = $("#det_pac_orden").html();
  let id_optica = $("#id_optica_fact").val();
  let id_sucursal = $("#id_suc_fact").val();

  doc == 'factura' ? act = 'imprimir_fact' : act = 'imprimir_ccf.php';

  if (paciente !="" && id_optica !="") {

	  const formulario = document.createElement("form");
	  formulario.target = "print_popup";
    formulario.method = "POST";
    formulario.action = act;

    var input = document.createElement("input");
  	input.type = "hidden";
  	input.name = "codigo_ord";
  	input.value = codigo;
  	formulario.appendChild(input);

  	var input = document.createElement("input");
  	input.type = "hidden";
  	input.name = "paciente_ord";
  	input.value = paciente;
  	formulario.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "id_optica_ord";
    input.value = id_optica;
    formulario.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "id_sucursal_ord";
    input.value = id_sucursal;
    formulario.appendChild(input);

  	document.body.appendChild(formulario);//"width=600,height=500"
    let alto = (parseInt(window.innerHeight) / 2);
    let ancho = (parseInt(window.innerWidth) / 2);
    let x = parseInt((screen.width - ancho));
    let y = parseInt((screen.height - alto));
    window.open("about:blank","print_popup",`
      width=${ancho}
      height=${alto}
      top=${y}
      left=${x}`);
  	formulario.submit();
  	document.body.removeChild(formulario);
    clearDataFact()

  }else{
    alertsFacturacion("error", "Codigo vacio")
  }

}

function clearDataFact(){
  let dataFactInner = document.getElementsByClassName('data-fact-inner');
  let dataFactValue = document.getElementsByClassName('data-fct');
  for(i=0;i<dataFactValue.length;i++){
    let id_element = dataFactValue[i].id;
    document.getElementById(id_element).value = "";
  }

  for(i=0;i<dataFactInner.length;i++){
    let id_element_i = dataFactInner[i].id;
    document.getElementById(id_element_i).innerHTML = "";
  }

  $('#codigo-orden-fact').val("");
  $('#codigo-orden-fact').focus();
  $("#datatable_ccf").DataTable().ajax.reload(); 

}


function registraCCF(){  
  let codigo = $("#codigo_orden_fact").val();
  let paciente = $("#det_pac_orden").html();
  let id_optica = $("#id_optica_fact").val();
  let id_sucursal = $("#id_suc_fact").val();
  let monto_orden = $("#monto_orden").html();
  let dia_de_pago = $("#dia_de_pago").val();
  let fecha_registro = $("#fecha_registro").val();
  let metodo_cobro = $("#metodo_cobro").val();
  /*======== SE REGISTRA CCF========*/
   $.ajax({
      url:"../ajax/creditos.php?op=registrarCCF",
      method:"POST",
      data : {codigo:codigo,paciente:paciente,id_optica:id_optica,id_sucursal:id_sucursal,monto_orden:monto_orden,dia_de_pago:dia_de_pago,fecha_registro:fecha_registro,metodo_cobro:metodo_cobro},
      cache:false,
      dataType:"json",
      success:function(data){
        console.log(data.msj)
        if(data.msj=='ccfreg'){
          printFacturacion('ccf');
        }else{
          Swal.fire('Ha ocurrido un error!','verificar que orden no ha sido facturada anteriormente!','error');
          clearDataFact();
        }
        
      }
    });
   
}



function printCCF(data,paciente){
      Swal.fire({
      title: 'CCF registrado existosamente',
      icon: 'success',
      html: 'Paciente: <b>'+ paciente +'</b><br>' + 
      'Correlativo: <b>'+ data.correlativo +'</b><br>' +
       'Fecha de pago: <b>'+ data.fecha_pago +'</b><br>',
      showCancelButton: false,
      focusConfirm: true,
      confirmButtonText:'<i class="fa fa-print"></i> Imprimir!',
      }).then((result) => {
      if (result.isConfirmed) {
       printFacturacion("ccf");
      }
    })
}

init_fact()