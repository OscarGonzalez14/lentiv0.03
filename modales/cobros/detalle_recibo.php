<!-- The Modal -->
<div class="modal" id="detalle-recibo">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-dark" style="padding:5px;color:white; text-align:center">
        <h4 class="modal-title  w-100 text-center position-absolute" id="title-cobros-recibo" style='font-size:15px'></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

      <!-- Modal body -->
      <div class="modal-body">
      <table width="100%" class="table-hover table-bordered" id="datatable_det_recibos" data-order='[[ 0, "desc" ]]' style="margin-top: 3px">        
        <thead class="style_th bg-primary" style="color: white">
          <th>ID abono</th>
          <th># Orden</th>
          <th># Rec.</th>
          <th>Sucursal</th>
          <th>Paciente</th>
          <th>Doc. fact.</th>
          <th>Monto orden</th>
          <th>Abono</th>
          <th>Fecha Abono</th>
          <th>Saldo</th>   
          </thead>
        <tbody class="style_th"></tbody>
      </table>
      </div>
    </div>
  </div>
</div>