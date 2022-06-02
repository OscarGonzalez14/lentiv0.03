function init(){
	listar_sucursales_optica();
	ocultar_btn_edit_sucursal();
}

function ocultar_btn_edit_sucursal(){
  document.getElementById("editar_suc").style.display = "none";
}

function ocultar_btn_guardar_sucursal(){
  document.getElementById("guardar_suc").style.display = "none";
}

function mostrar_btn_edit_sucursal(){
  document.getElementById("editar_suc").style.display = "block";
}

function mostrar_btn_guardar_sucursal(){
  document.getElementById("guardar_suc").style.display = "block";
} 

function guardar_optica(){
	let nom_optica=$("#nom_optica").val();
	let num_optica=$("#num_optica").val();
	let id_usuario=$("#id_usuario").val();
	
	if(nom_optica !="" && num_optica !=""){
		$.ajax({
			url:"../ajax/opticas.php?op=guardar_optica",
			method:"POST",
			data:{nom_optica:nom_optica,num_optica:num_optica,id_usuario:id_usuario},
			cache: false,
			dataType: "json",
			error:function(x,y,z){
				d_pacole.log(x);
				console.log(y);
				console.log(z);
			},
			success:function(data){
				console.log(data);	
				if(data=='error'){
					Swal.fire('Optica ya existe!','','error')
					return false;

				}else if (data=="ok") {
					Swal.fire('La optica ha sido creada!','','success')
					setTimeout ("explode();", 2000);
				}else{
					Swal.fire('Modificación ha sido un éxito!','','success')
					setTimeout ("explode();", 2000);
				}
			}
		});
	}
	Swal.fire('Debe llenar todos los campos!','','error')
}


function explode(){
    location.reload();
  }

///LISTAR OPTICAS INGRESADAS EN SISTEMA
  function listar_sucursales_optica(){

    $("#dt_sucursales_opti").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      dom: 'frti',
      //"buttons": [ "excel"],
      "searching": true,
      "ajax":
      {
        url: '../ajax/opticas.php?op=listar_sucursales_optica',
        type : "post",
        dataType : "json",        
        error: function(e){
          //console.log(e.responseText);  
        }
      },
      "language": {
        "sSearch": "Buscar:"
      }
    }).buttons().container().appendTo('#dt_sucursales_opti_wrapper .col-md-6:eq(0)');

  }

//DESIGNAR CODIGO INTERNO A SUCURSALES
function get_correlativo_sucursal(){
  $.ajax({
    url:"../ajax/opticas.php?op=get_correlativo_sucursal",
    method:"POST",
    data:{},
    cache:false,
    dataType:"json",
      success:function(data){
      console.log(data);
      $("#codigo_suc").val(data.correlativo);  
      }
    });
}

//LIMPIAR CAMPOS DE MODAL NUEVA SUCURSAL OPTICA
$(document).on('click', '#nueva_sucursal', function(){
   let elements = document.getElementsByClassName("clear_input");

    for(i=0;i<elements.length;i++){
      let id_element = elements[i].id;
      document.getElementById(id_element).value="";
    }
});

function guardar_sucursal(){

	let nom_sucursal=$("#nom_sucursal").val();
	let direccion=$("#dir_sucursal").val();	
	let telefono=$("#tel_sucursal").val();
	let correo=$("#correo_sucursal").val();
	let encargado=$("#encargado_sucursal").val();
	let usuario=$("#id_usuario").val();
	let codigo=$("#codigo_suc").val();
	let id_opt=$("#id_optica").val();
	let id_sucursal=$("#id_sucursal").val();
	let id_optica=id_opt.toString();
	let categoria = $("#categoria_suc").val();
	let fecha_cobro = $("#dia_de_cobro").val();
	let forma_pago = $("#forma_pago_suc").val();
	let nrc = $("#nrc_suc").val();
	let nit = $("#nit_sucursal").val();
	let metodo_cobro = $("#fecha_cobro").val();
	let contribuyente = $("#contrib_suc").val();
	let giro = $("#giro_suc").val();
    
    console.log(contribuyente)
    //if () {}

	if (direccion !="" && telefono !="" && encargado !=""){
	
		$.ajax({
			url:"../ajax/opticas.php?op=guardar_sucursal",
			method:"POST",
			data:{nom_sucursal:nom_sucursal,direccion:direccion,telefono:telefono,correo:correo,encargado:encargado,usuario:usuario,codigo:codigo,id_optica:id_optica,
				id_sucursal:id_sucursal,categoria:categoria,fecha_cobro:fecha_cobro,forma_pago:forma_pago,nrc:nrc,nit:nit,metodo_cobro:metodo_cobro,contribuyente:contribuyente,giro:giro},
			cache: false,
			dataType: "json",
			error:function(x,y,z){
				d_pacole.log(x);
				console.log(y);
				console.log(z);
			},
			success:function(data){
				console.log(data);	
				if(data=='error'){
					Swal.fire('Sucursal no se guardó!','','error')
					return false;
				}else if (data=="creado"){
					Swal.fire('La sucursal ha sido creada!','','success')
					$("#dt_sucursales_opti").DataTable().ajax.reload();
					}else{
					Swal.fire('Modificación fué un éxito!','','success')
					$("#dt_sucursales_opti").DataTable().ajax.reload();
				}
			}
		});
}else{
	Swal.fire('Llenar todos los campos, es importante ! :)','','error')
}

}

//VER DATA EN MODAL EN MODAL DE EDITAR
function show_datos_sucursal(id_sucursal,codigo){

	$('#t_dinamico').html('EDITAR SUCURSAL');
  
		$.ajax({
		url:'../ajax/opticas.php?op=show_datos_sucursal',
		method:"POST",
		data:{id_sucursal:id_sucursal,codigo:codigo},
		cache:false,
		dataType:"json",
		success:function(data){	
		console.log(data);
		$("#id_optica").val(data.id_optica);
		$("#nom_sucursal").val(data.nombre_sucursal);
		$("#dir_sucursal").val(data.direccion);
		$("#tel_sucursal").val(data.telefono);
		$("#correo_sucursal").val(data.correo);
		$("#encargado_sucursal").val(data.encargado);
		$("#id_usuario").val(data.id_usuario);
		$("#codigo_suc").val(data.codigo);
		$("#id_sucursal").val(data.id_sucursal);
    }
	});
}

function eliminar_sucursal(id_sucursal){
	  
	bootbox.confirm("¿Está Seguro de eliminar esta sucursal", function(result){
    if(result){

	$.ajax({
		url:"../ajax/opticas.php?op=eliminar_sucursal",
		method:"POST",
		data:{id_sucursal:id_sucursal},
		dataType:"json",
		success:function(data)
		{
			console.log(data);
			if(data=="ok"){
				setTimeout ("Swal.fire('Sucursal eliminada existosamente','','success')", 100);
			}else if(data=="existe"){
				setTimeout ("Swal.fire('La sucursal posee orden','','error')", 100);
			}						//alert(data);
			$("#dt_sucursales_opti").DataTable().ajax.reload();
		}
	});

}
});//bootbox

}

///////////////////FECHA DE PAGO /////////////
$(document).ready(function(){
  $("#fecha_cobro").change(function () {         
    $("#fecha_cobro option:selected").each(function () {
      fecha_cobro = $(this).val();
      acciones_fecha_cobro(fecha_cobro);
    });
  })
});


function acciones_fecha_cobro(fecha_cobro){
	if (fecha_cobro=="Semanal") {
		$("#semana_opcion").modal();
	}else if(fecha_cobro=="Quincenal"){
		document.getElementById("fecha_cobro_selected").value="Cada 15 dias";
	    document.getElementById("dia_de_cobro").value = "15";
	}else if (fecha_cobro=="Mensual") {
		document.getElementById("fecha_cobro_selected").value="Cobro mensual";
		document.getElementById("dia_de_cobro").value = "30";
	}else if (fecha_cobro=="Especifica") {
		$("#fecha_especifica_opcion").modal();
	}
}

function seleccionarDia(dia){
	document.getElementById("fecha_cobro_selected").value="Cada "+dia;
	document.getElementById("dia_de_cobro").value = dia;
	$("#semana_opcion").modal("hide");

}

function seleccionarDia(dia){
	document.getElementById("fecha_cobro_selected").value="Cada "+dia;
	document.getElementById("dia_de_cobro").value = dia;
	$("#semana_opcion").modal("hide");
}

function seleccionarFecha(fecha){
	document.getElementById("fecha_cobro_selected").value="Cada "+fecha+" de mes";
	document.getElementById("dia_de_cobro").value = fecha;
	$("#fecha_especifica_opcion").modal("hide");

}

init();
