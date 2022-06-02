function init(){
  listar_ordenes();
}

function alerts(icono, titulo){
  Swal.fire({
    position: 'top-center',
    icon: icono,
    title: titulo,
    showConfirmButton: true,
    timer: 20500
  });
}

var Toast = Swal.mixin({
  toast: true,
  position: 'top',
  showConfirmButton: false,
  timer: 2000
});

/////////////// SELECCIONAR SUCURSAL //////////
$(document).ready(function(){
  $("#optica_orden").change(function () {         
    $("#optica_orden option:selected").each(function () {
     let optica = $(this).val();
     $.post('../ajax/ordenes.php?op=sucursales_optica',{optica:optica}, function(data){
      $("#optica_sucursal").html(data);
    });            
   });
  })
});


function create_barcode(){  

  let codigo = $('#codigoOrden').val();

  $.ajax({
    url:"../ajax/ordenes.php?op=crear_barcode",
    method:"POST",
    data:{codigo:codigo},
    cache: false,
    dataType:"json",
    error:function(data){
      setTimeout("guardar_orden();",1500);  
    },
    success:function(data){
      console.log(data)
    }
  });///fin ajax
}

/***********************************************************
/////////////////////  GUARDAR ORDEN ///////////////////////
/***********************************************************/
function saveOrder(){

    let odesferasf_orden = $("#odesferasf_orden").val();
    let oiesferasf_orden = $("#oiesferasf_orden").val();

    let esf_od = parseFloat(odesferasf_orden);
    let esfera_d = odesferasf_orden.toUpperCase();
    let esf_oi = parseFloat(oiesferasf_orden);
    let esfera_i = oiesferasf_orden.toUpperCase();

   
    let od_esf_chk = true;
    let oi_esf_chk = true;
    if (isNaN(esf_od) == false || esfera_d == 'NEUTRO' ||  esfera_d == 'PL' || esfera_d == "PLANO"  || esfera_d =="N" || esfera_d =="NO TOCAR" || esfera_d =="NO HACER" || esfera_d == "BALANCE") {
      od_esf_chk; 
    }else{
     od_esf_chk = false;
     Toast.fire({icon: 'error',title: 'OD esfera es incorrecto.'}); return false;
    }

    if (isNaN(esf_oi) == false || esfera_i == 'NEUTRO' ||  esfera_i == 'PL' || esfera_i == "PLANO"  || esfera_i =="N" || esfera_i =="NO TOCAR" || esfera_i =="NO HACER" || esfera_i == "BALANCE") {
      od_esf_chk; 
    }else{
     oi_esf_chk = false;
     Toast.fire({icon: 'error',title: 'OI esfera es incorrecto.'}); return false;
    }
    
    if (od_esf_chk && oi_esf_chk) {
    
    let precio = document.getElementById("p_venta_final").value;
    document.getElementById("cod_orden_cont").innerHTML = "";

      if (precio > 0){
        let tipo_lente = $("input[type='radio'][name='tipo_lente']:checked").val();
        let marcaVs = $("input[type='radio'][name='checksvs']:checked").val();
        let tratamiento = $("input[type='checkbox'][name='chk_tratamientos']:checked").val();
        let chk_antiR = $("input[type='radio'][name='chk_antiR']:checked").val();
        let checkbox_ar = document.getElementById('arblack');
        let check_state_ar = checkbox_ar.checked;
        chk_antiR == undefined ? chk_antiR = '':chk_antiR=' + Ar Blue Uv';
        check_state_ar ? check_state_ar = "Si" : check_state_ar = "No";
        tratamiento == undefined ? tratamiento = "Ninguno" : tratamiento = tratamiento;
        console.log(`tipo_lente ${tipo_lente} marcaVs ${marcaVs} tratamiento ${tratamiento} chk_antiR ${chk_antiR} check_state_ar ${check_state_ar}`) 
        document.getElementById("det-tipo-lente").innerHTML=tipo_lente;
        document.getElementById("det-tipo-marca").innerHTML=marcaVs;
        document.getElementById("det-tipo-trat").innerHTML=tratamiento+chk_antiR;
        document.getElementById("det-arf").innerHTML=check_state_ar;
      }else{
        alerts('error','Debe seleccionar lente + marca de lente + tratamiento o Antirreflejante');return false;
      }
       //document.getElementById('print_etiqueta').style.display="none";
      $("#contenedor").modal("show");
      $('#contenedor').on('shown.bs.modal', function() {
      $('#contenedor_orden').val("");
      $('#contenedor_orden').focus();
    });

}   

}

var tratamientos = [];
$(document).on('click', '.items_tratamientos', function(){    
    let id_chk = $(this).attr("id");
    let value = $(this).attr("value");
    let checkbox = document.getElementById(id_chk);
    let check_state = checkbox.checked; 
    
    if (check_state) {
      tratamientos.push(value);
    }else{
     let indice = tratamientos.indexOf(value);
     if (indice > -1) {tratamientos.splice(indice,1)}
    }   

});


function guardar_orden(){

  let contenedor = $("#contenedor_orden").val();
  if(contenedor==""){
    alerts("error","La orden debe ser asignada a un contenedor");
    return false;
  }

  let pac = $("#paciente_orden").val();
  let paciente = pac.replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())))
  let observaciones = $("#observaciones_orden").val();
  let usuario = $("#id_usuario").val();
  let id_sucursal = $("#optica_sucursal").val();
  let id_optica = $("#optica_orden").val();
  let tipo_orden = "Laboratorio";
  let lentevs = $("#lentevs").val();
  let lentebf = $("#lentebf").val();
  let lentemulti = $("#lentemulti").val();
  // rx_orden
  let odesferasf_orden = $("#odesferasf_orden").val();
  let odcilindrosf_orden = $("#odcilindrosf_orden").val();
  let odejesf_orden = $("#odejesf_orden").val();
  let oddicionf_orden = $("#oddicionf_orden").val();
  let odprismaf_orden = $("#odprismaf_orden").val();
  let oiesferasf_orden = $("#oiesferasf_orden").val();
  let oicilindrosf_orden = $("#oicolindrosf_orden").val();
  let oiejesf_orden = $("#oiejesf_orden").val();
  let oiadicionf_orden = $("#oiadicionf_orden").val();
  let oiprismaf_orden = $("#oiprismaf_orden").val();
  // aros  
  let modelo = $("#modelo_aro_orden").val();
  let marca = $("#marca_aro_orden").val();
  let color = $("#color_aro_orden").val();
  let diseno = $("#diseno_aro_orden").val();
  let horizontal = $("#med_a").val();
  let diagonal = $("#med_b").val();
  let vertical = $("#med_c").val();
  let puente = $("#med_d").val();
  // alturas orden 
  let od_dist_pupilar = $("#dip_od").val();
  let od_altura_pupilar = $("#ap_od").val();
  let od_altura_oblea = $("#ao_od").val();
  let oi_dist_pupilar = $("#dip_oi").val();
  let oi_altura_pupilar = $("#ap_oi").val();
  let oi_altura_oblea = $("#ao_oi").val();
  let tipo_lente = $("#det-tipo-lente").html();  
  if (tipo_lente==undefined || tipo_lente==null || tipo_lente == "") {
    alerts('error','Debe seleccionar Lente');return false;
  } 
  let tratamiento_orden = $("#det-tipo-trat").html();
  if(tratamiento_orden == undefined || tratamiento_orden == null || tratamiento_orden == ""){
     alerts('error','Debe seleccionar tratamiento');return false;
  }

  let marca_trat = $("#det-tipo-marca").html();
  let antirreflejante = $("#det-arf").html();
  let categoria = $("#cat_orden").val();
  let precio = $("#p_venta_final").val();

  console.log(typeof odesferasf_orden);

    $.ajax({
    url:"../ajax/ordenes.php?op=registrar_orden",
    method:"POST",
    data:{'arrayTratamientos':JSON.stringify(tratamientos),'paciente':paciente,'observaciones':observaciones,'usuario':usuario,'id_sucursal':id_sucursal,
    'id_optica':id_optica,'tipo_orden':tipo_orden,'tipo_lente':tipo_lente,
    'odesferasf_orden':odesferasf_orden,'odcilindrosf_orden':odcilindrosf_orden,'odejesf_orden':odejesf_orden,'oddicionf_orden':oddicionf_orden,
    'odprismaf_orden':odprismaf_orden,'oiesferasf_orden':oiesferasf_orden,'oicilindrosf_orden':oicilindrosf_orden,'oiejesf_orden':oiejesf_orden,
    'oiadicionf_orden':oiadicionf_orden,'oiprismaf_orden':oiprismaf_orden,
    'modelo':modelo,'marca':marca,'color':color,'diseno':diseno,'horizontal':horizontal,'diagonal':diagonal,'vertical':vertical,'puente':puente,
    'od_dist_pupilar':od_dist_pupilar,'od_altura_pupilar':od_altura_pupilar,'od_altura_oblea':od_altura_oblea,'oi_dist_pupilar':oi_dist_pupilar,
    'oi_altura_pupilar':oi_altura_pupilar,'oi_altura_oblea':oi_altura_oblea,'tratamiento_orden':tratamiento_orden,'contenedor':contenedor,'marca_trat':marca_trat,'antirreflejante':antirreflejante,'categoria':categoria,'precio':precio},
    cache: false,
    success:function(data){
  
      if (data != 'Error') {
      clearElementsForm();   
      $("#datatable_ordenes").DataTable().ajax.reload(); 
      event.preventDefault()
      Swal.fire({
        title: 'Codigo: '+data,
        icon: 'info',
        html: '<u>'+paciente+'</u> ha sido registrad@ exitosamente',
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: true
      });

      }else{
      Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'Orden ya ha sido digitada',
        showConfirmButton: true,
        timer: 2500
      })
    }     
  }
  });//////FIN AJAX

}

function validar_est_orden(){
  alerts("error", "La orden debe ser recibida");
}

function printEtiqueta(){
  let n_etiqueta = $("#cod_orden_cont").html();
  let paciente = $("#paciente_orden").val();
  let id_sucursal = $("#optica_sucursal").val();
  let id_optica = $("#optica_orden").val();
  generate_barcode_print(n_etiqueta,paciente,id_sucursal,id_optica)
}


function generate_barcode_print(codigo,paciente,id_sucursal,id_optica,fecha,usuario){
  console.log(fecha+" - "+usuario)
  var form = document.createElement("form");
  form.target = "print_popup";
  form.method = "POST";
  form.action = "barcode_orden_print.php";
  
  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "paciente";
  input.value = paciente;
  form.appendChild(input);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "codigo";
  input.value = codigo;
  form.appendChild(input);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "id_optica";
  input.value = id_optica;
  form.appendChild(input);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "id_sucursal";
  input.value = id_sucursal;
  form.appendChild(input);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "fecha";
  input.value = fecha;
  form.appendChild(input);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "usuario";
  input.value = usuario;
  form.appendChild(input);

  let alto = (parseInt(window.innerHeight) / 4);
  let ancho = (parseInt(window.innerWidth) / 4);
  let x = parseInt((screen.width - ancho) / 2);
  let y = parseInt((screen.height - alto) / 2);

  document.body.appendChild(form);//"width=600,height=500"
  window.open("about:blank","print_popup",`
    width=${ancho}
    height=${alto}
    top=${y}
    left=${x}`);
  form.submit();
  document.body.removeChild(form);

}



function listar_ordenes(){
    tabla_ordenes= $('#datatable_ordenes').DataTable({      
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [     
      'excelHtml5',
    ],

    "ajax":{
      url:"../ajax/ordenes.php?op=get_ordenes",
      type : "POST",
      dataType : "json",
      //data:{},           
      error: function(e){
      console.log(e.responseText);
    },           
    },

        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 15,//Por cada 10 registros hace una paginación
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
       
          }

         }, //cerrando language

          //"scrollX": true

    });

  }


///////////////LIMPIAR CAMPOS NUEVA ORDEN LAB//////////
$(document).on('click', '#new_order', function(){
    tratamientos = [];
    //document.getElementById("reg_orden").style.display = "block";
    let element = document.getElementsByClassName("clear_orden_i");
    for(i=0;i<element.length;i++){
      let id_element = element[i].id;
      document.getElementById(id_element).value = "";
   }

  $(".modal-header").on("mousedown", function(mousedownEvt) {
    let $draggable = $(this);
    let x = mousedownEvt.pageX - $draggable.offset().left,
        y = mousedownEvt.pageY - $draggable.offset().top;
    $("body").on("mousemove.draggable", function(mousemoveEvt) {
    $draggable.closest(".modal-dialog").offset({
    "left": mousemoveEvt.pageX - x,
      "top": mousemoveEvt.pageY - y
    });
    });
    $("body").one("mouseup", function() {
      $("body").off("mousemove.draggable");
    });
    $draggable.closest(".modal").one("bs.modal.hide", function() {
        $("body").off("mousemove.draggable");
    });
  });
  
  ///////////////////////////// UNCHECKED RADIO /////////////////
  let check_box = document.getElementsByClassName("check_clear");
   for(j=0;j<check_box.length;j++){
    let id_check = check_box[j].id;
    document.getElementById(id_check).disabled = false;
    document.getElementById(id_check).checked = false;
  }

});

////////////////ocultar input OTROS TRATAMIENTOS
$(document).on('click', '.new_order_class', function(){
  document.getElementById("otros_trat").style.display = "none";
});

function chk_otros_tratamientos(){
 var isChecked = document.getElementById('chk_trat').checked;
 if (isChecked) {
  document.getElementById("otros_trat").style.display = "block";
  document.getElementById("tratamientos_section").style.display = "none";
}else{
  document.getElementById("otros_trat").style.display = "none";
  document.getElementById("tratamientos_section").style.display = "flex";
}

}

$(document).on('click', '.ident', function(){
  let id_item = $(this).attr("id");
  alert(id_item)
});

var det_orden = [];
function get_dets_orden(){
  let cod_orden_act = $("#cod_orden_current").val();
    /////////GET DATA ORDEN /////////////
    $.ajax({
      url:"../ajax/ordenes.php?op=get_data_oden",
      method:"POST",
      data : {cod_orden_act:cod_orden_act},
      cache:false,
      dataType:"json",
      success:function(data){
        if(data != 'error'){
        $("#cod_det_orden_descargo").html(data.codigo);
        $("#pac_orden_desc").html(data.paciente);
        $("#optica_orden_suc").html(data.optica);
        $("#sucursal_optica_orden").html(data.sucursal);
        $("#tipo_lente_ord").html(data.tipo_lente);
        $("#trat_multi_orden").html(data.trat_orden);
        $("#obs_orden").val(data.observaciones);
        $("#id_optica_desc").val(data.id_optica);
        $("#id_sucursal_desc").val(data.id_sucursal);

        document.getElementById("cod_orden_current").readOnly = true
        $('#cod_lente_inv').val("");
        $('#cod_lente_inv').focus();

      }else{
        alerts_productos("error","Orden no existe!!"); 
        $('#cod_orden_current').val("");       
        $('#cod_orden_current').focus();
        var z = document.getElementById("error_sound_desc"); 
        z.play();
        return false;
      }
      }
    });
/*============   editar capos de descargo   ===========*/
$(document).on('click', '.edit_field_desc', function(){    
    let id_campo = $(this).attr("name"); 
    document.getElementById(id_campo).readOnly = false;   
});
/////////////////  GET DATA RX FINAL  ////////////////

  $.ajax({
    url:"../ajax/ordenes.php?op=get_rxfinal_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
     console.log(data);
     $("#esf_od").html(data.odesferas);
     $("#cil_od").html(data.odcindros);
     $("#eje_od").html(data.odeje);
     $("#adi_od").html(data.odadicion);
     $("#pri_od").html(data.odprisma);

     $("#esf_oi").html(data.oiesferas);
     $("#cil_oi").html(data.oicindros);
     $("#eje_oi").html(data.oieje);
     $("#adi_oi").html(data.oiadicion);
     $("#pri_oi").html(data.oiprisma);
   }
 });

  /////////// GET DATA ALTURA PUPILAR /////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_altdist_oden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
     $("#od_dip").html(data.od_dist_pupilar);
     $("#od_ap").html(data.od_altura_pupilar);
     $("#od_ao").html(data.od_altura_oblea);
     $("#oi_dip").html(data.oi_dist_pupilar);
     $("#oi_ap").html(data.oi_altura_pupilar);
     $("#oi_ao").html(data.oi_altura_oblea);

   }
 });
  /////////////////////  GET DATA AROS ORDEN ////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_aros_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      $("#mod_aro_orden").html(data.modelo);
      $("#marca_aro_orden").html(data.marca);
      $("#color_aro_orden").html(data.color);
      $("#dis_aro_orden").html(data.diseno);
      $("#hor_aro_orden").html(data.horizontal);
      $("#diagonal_aro_orden").html(data.diagonal);
      $("#vertical_aro_orden").html(data.vertical);
      $("#puente_aro_orden").html(data.puente);

    }
  });
  
}
var history_order = [];
function detOrdenes(cod_orden_act){
  console.log('Funciona');
  $("#detalle_orden").modal('show');
  $.ajax({
    url:"../ajax/ordenes.php?op=get_data_oden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){

      $("#det_cod_orden").html(data.codigo);
      $("#det_pac_orden").html(data.paciente);
      $("#det_orden_optica").html(data.optica);
      $("#suc_orden_optica").html(data.sucursal);
      $("#det_lente_ord").html(data.tipo_lente);
      $("#det_trats_lente_ord").html(data.trat_orden);
      $("#obs_orden").val(data.observaciones);
      $("#det_marca_lente_ord").html(data.trat_orden);
    }
});

  /////////////////GET DATA RX FINAL   

  $.ajax({
    url:"../ajax/ordenes.php?op=get_orden_rxfinal",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){

     $("#det_esfera_od").html(data.odesferas);
     $("#det_cil_od").html(data.odcindros);
     $("#det_eje_od").html(data.odeje);
     $("#det_add_od").html(data.odadicion);
     $("#det_prisma_od").html(data.odprisma);

     $("#det_esfera_oi").html(data.oiesferas);
     $("#det_cil_oi").html(data.oicindros);
     $("#det_eje_oi").html(data.oieje);
     $("#det_add_oi").html(data.oiadicion);
     $("#det_prisma_oi").html(data.oiprisma);

   }
 });

/////////////////// GET TRATAMIENTOS ORDEN ///////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_tratamientos_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      let trats = data.toString();     
      $("#det_trats_lente_ordx").html(trats);
      }
  });
/////////// GET DATA ALTURA PUPILAR /////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_altdist_oden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
     $("#det_dist_pup_od").html(data.od_dist_pupilar);
     $("#det_alt_pup_od").html(data.od_altura_pupilar);
     $("#det_alt_oblea_od").html(data.od_altura_oblea);
     $("#det_dist_pup_oi").html(data.oi_dist_pupilar);
     $("#det_alt_pup_oi").html(data.oi_altura_pupilar);
     $("#det_alt_oblea_oi").html(data.oi_altura_oblea);

   }
 });
  /////////////////////  GET DATA AROS ORDEN ////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_aros_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      $("#marca_det_ord").html(data.modelo);
      $("#modelo_det_ord").html(data.marca);
      $("#color_det_ord").html(data.color);
      $("#dis_det_ord").html(data.diseno);
      $("#hor_det_ord").html(data.horizontal);
      $("#diag_det_orden").html(data.diagonal);
      $("#vert_det_ord").html(data.vertical);
      $("#puente_det_ord").html(data.puente);
    }
  });

  /* GET ACIONES DE ORDEN */

  $.ajax({
    url:"../ajax/ordenes.php?op=get_acciones_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      $("#historial_orden_detalles").html("");
      let filas = '';
      for(var i=0; i<data.length; i++){
        filas = filas + "<tr id='fila"+i+"'>"+
        "<td colspan='15' style='width:15%''>"+data[i].fecha_hora+"</td>"+
        "<td colspan='25' style='width:25%''>"+data[i].usuario+"</td>"+
        "<td colspan='25' style='width:25%''>"+data[i].accion+"</td>"+
        "<td colspan='35' style='width:35%''>"+data[i].observaciones+"</td>"+
        "</tr>";
      }
      $("#historial_orden_detalles").html(filas);    
  }
  });
  
}

/////VER DATOS DE UNA ORDEN /////
function ver_datos_orden(cod_orden_act){

  $("#nueva_orden_lab").modal('show');

  $.ajax({
    url:"../ajax/ordenes.php?op=get_datos_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      
      let lente = data.tipo_lente;
      if (lente == "Visión Sencilla"){
        document.getElementById("lentevs").checked=true;
      }else if(lente == "Bifocal"){
        document.getElementById("lentebf").checked=true;
      }else if(lente == "Multifocal"){
        document.getElementById("lentemulti").checked=true;
      }
      
  let base = data.trat_orden;
      if (base == "Alena"){
        document.getElementById("Alena").checked=true;
      }else if(base == "Aurora4D"){
        document.getElementById("Aurora 4D").checked=true;
      }else if(base == "Aurora A Claar"){
        document.getElementById("Aurora_a_clear").checked=true;
      }else if(base == "Gemini"){
        document.getElementById("Gemini").checked=true;
      }
      $("#correlativo_op").html(data.codigo);
      $("#paciente_orden").val(data.paciente);
      $("#optica_orden").val(data.id_optica);
      $("#optica_sucursal").val(data.id_sucursal);


      let items_orden = {
        codigo : data.codigo,
        paciente :data.paciente,
        id_optica: data.id_optica,
        id_sucursal: data.id_sucursal
      } 
      det_orden.push(items_orden);
    }
  });
  /////////////////GET DATA RX FINAL   

  $.ajax({
    url:"../ajax/ordenes.php?op=get_orden_rxfinal",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
     $("#odesferasf_orden").val(data.odesferas);
     $("#odcilindrosf_orden").val(data.odcindros);
     $("#odejesf_orden").val(data.odeje);
     $("#oddicionf_orden").val(data.odadicion);
     $("#odprismaf_orden").val(data.odprisma);

     $("#oiesferasf_orden").val(data.oiesferas);
     $("#oicolindrosf_orden").val(data.oicindros);
     $("#oiejesf_orden").val(data.oieje);
     $("#oiadicionf_orden").val(data.oiadicion);
     $("#oiprismaf_orden").val(data.oiprisma);

   }
 });

  /////////// GET DATA ALTURA PUPILAR /////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_datos_alturas_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
     $("#dip_od").val(data.od_dist_pupilar);
     $("#ap_od").val(data.od_altura_pupilar);
     $("#ao_od").val(data.od_altura_oblea);
     $("#dip_oi").val(data.oi_dist_pupilar);
     $("#ap_oi").val(data.oi_altura_pupilar);
     $("#ao_oi").val(data.oi_altura_oblea);

   }
 });
  /////////////////////  GET DATA AROS ORDEN ////
  $.ajax({
    url:"../ajax/ordenes.php?op=get_det_aros_orden",
    method:"POST",
    data : {cod_orden_act:cod_orden_act},
    cache:false,
    dataType:"json",
    success:function(data){
      $("#modelo_aro_orden").val(data.modelo);
      $("#marca_aro_orden").val(data.marca);
      $("#color_aro_orden").val(data.color);
      $("#diseno_aro_orden").val(data.diseno);
      $("#med_a").val(data.horizontal);
      $("#med_b").val(data.diagonal);
      $("#med_c").val(data.vertical);
      $("#med_d").val(data.puente);

    }
  });
  //////////////////GET DATA TRATAMIENTOS/////

}

function clearDataOrdenDesc(){

  $("#cod_orden_current").val("");
  $('#cod_orden_current').focus();

  let items_data_orden_desc = document.getElementsByClassName("data_orden_desc");
  for (var i = 0; i < items_data_orden_desc.length; i++) {
    items_data_orden_desc[i].innerHTML="";
  }
  
  $("#id_optica_desc").val("");
  $("#id_sucursal_desc").val("");

}

function clearElementsForm(){
    
    $('#paciente_orden').focus();    
    $("#contenedor").modal('hide');

    let element = document.getElementsByClassName("clear_orden_i");
    for(i=0;i<element.length;i++){
      let id_element = element[i].id;
      document.getElementById(id_element).value = "";
    }

    let check_box = document.getElementsByClassName("check_clear");
    for(j=0;j<check_box.length;j++){
      let id_check = check_box[j].id;
      document.getElementById(id_check).disabled = false;
      document.getElementById(id_check).checked = false;
    }
}




init();




