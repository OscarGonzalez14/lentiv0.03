<!-- The Modal -->
<div class="modal" id="modal-det-cobros">
  <div class="modal-dialog" style="max-width: 95%;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background: #001f4f; padding:5px;color:white; text-align:center">
      <h4 class="modal-title  w-100 text-center position-absolute" id="title-cobros-gen" style='font-size:15px'></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      <div class="form-row" style="margin:3px">
        <div class="col-sm-4">
          <input type="text" class="form-control float-right" id="rango-cobro" name="daterange"  value="2000-05-05">
        </div>

        <div class=" form-group col-sm-2">
          <button type="button" class="btn btn-block btn-outline-light  btn-flat" data-toggle="modal" data-target="#filtrar-creditos" style="color:black" onClick="getValuesCcf()"><i class="	fas fa-hand-holding-usd" style="color:black"></i>Abonar</button>
        </div>     
        
        <div class=" form-group col-sm-2">
          <button type="button" class="btn btn-block btn-outline-light  btn-flat" data-toggle="modal" data-target="#filtrar-creditos" style="color:black" onClick="getValuesCcf()"><i class="fas fa-book" style="color:black"></i>Hist. abonos</button>
        </div>   
               
      </div>
      <input type="hidden" id='id-optica'>
      <table width="100%" class="table-hover table-bordered" id="datatable_listar_cobros" data-order='[[ 3, "desc" ]]' style="margin-top: 3px">        
               <thead class="style_th bg-dark" style="color: white">
                <!-- <th><label><input type="checkbox" id="select-all-cobrar-chk" class="form-check-label" onClick="selectOrdenesCobrar()"> Sel.</label></th> -->
                 <th>Doc.</th>
                 <th>Fecha fact.</th>
                 <th>Vencimiento</th>
                 <th>Dias</th>
                 <th>Paciente</th>
                 <th>Sucursal</th>
                 <th>Monto</th>
                 <th>Abono</th>
                 <th>Saldo</th>
                 <th>Totales</th>
               </thead>
               <tbody class="style_th"></tbody>
      </table>
    
    </div>

    </div>
  </div>
</div>