<style>	
.imprimir{
    background: white;
    margin-right: 200px;
    margin-left: 200px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 20px;
    max-width: 1000px;
}
.imprimir table{
    max-width: 960px;
}
</style>	

<script>
function printDiv() {
          var objeto=document.getElementById('imprimir'); 
   
   //obtenemos el objeto a imprimir
          var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
          ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
          ventana.document.close();  //cerramos el documento
          window.print();
          window.close();
        }

</script>

<div class="imprimir" id="imprimir">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css" media="print">

  <div class="titulo">HOJA DE SERVICIOS INFORMATICOS</div>
  <table>
    <tr>
      <th>
        <font style=" text-decoration: underline;">DATOS DEL USUARIO</font><br>
        <strong>Usuario: </strong><br>
        <strong>Nombre del Responsable: </strong><br>
        <strong>Proveedor del Servicio: </strong><br>
        <strong>Área Solicitante: </strong><br>
      </th>
      <th>
        <font style=" text-decoration: underline;">DATOS DEL REPORTE</font><br>
        <strong>Número de Orden: </strong><br>
        <strong>Fecha de Registro: </strong><br>
        <strong>Hora de Registro: </strong><br>
        <strong>Reportó: </strong><br>
      </th>
    </tr>
    <tr>
      <th>

        <font style=" text-decoration: underline;">CARACTERÍSTICAS DEL EQUIPO</font><br>
        <strong>Marca: </strong>
        <strong>Modelo: </strong><br>
        <strong>Número de Serie: </strong>
        <strong>Inventario: </strong><br>
      </th>
      <th>
        <font style=" text-decoration: underline;">DESCRIPCIÓN DE LA FALLA O PROBLEMA</font><br>
        <strong>Descripción detallada del problema: </strong> <br>
    </tr>
    <tr>
      <th>
        <font style=" text-decoration: underline;">STATUS GENERAL</font><br>
        <strong>Estado del Reporte: </strong><br>
        <strong>¿El problema tuvo solución?: </strong>
        <font style="text-transform: uppercase;"></font><br>
        <strong>Fecha de Finalización: </strong><br>
        <strong>Hora de Finalización: </strong><br>
      </th>
      <th>
        <font style=" text-decoration: underline;">ACTIVIDADES</font><br>
        <strong>Actividad realizada: </strong><br><br>
        <strong>Nombre del Prestador de Servicio: </strong><br>
      </th>
    </tr>
    <tr>
      <th>
        <font style=" text-decoration: underline;">EVALUACIÓN DEL SERVICIO</font><br>
        <strong>La Calidad del Servicio Otorgado por el Departamento de Soporte Técnico fue: </strong>
        <br>
        <strong>El Nivel de Atención Otorgado por el Departamento de Soporte Técnico fue: </strong>
        <br>
        <strong>El Nivel Profesional para que el Departamento de Soporte Técnico solucionará el problema fue: </strong>
        <br>
        <strong>El Tiempo de Respuesta en que el Departamento de Soporte Técnico lo atendió fue: </strong>
        <br>
        <strong>Evaluación General del Reporte: </strong>

      </th>
    </tr>

  </table>
  <div class="firma">________________________________________<br>FIRMA DE CONFORMIDAD DEL USUARIO
  </div>
</div>

<button onclick="printDiv()">Imrpimir</button>