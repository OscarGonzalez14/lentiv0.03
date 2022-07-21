<table width="100%" class="table2" style="margin: 1px">

 <tr>
  <td class="td-data-opt" colspan="75" style="width: 75%;"><span class="data-opt"><b>&nbsp;Fecha: </b> <?php echo $dateTime;?></span></td>
  <td colspan="25" rowspan="3"  style="width: 25%; text-align: right;"><?php echo $code; ?><span class="data-opt"><?php echo $codigo;?>&nbsp;&nbsp;</span></td>
 </tr>
 <tr>
  <td class="td-data-opt" colspan="75" style="width: 75%;"><span class="data-opt"><b>&nbsp;Cliente: </b><?php echo $optica?></span></td>
 </tr>
 <tr>
  <td class="td-data-opt" colspan="75" style="width: 75%"><span class="data-opt"><b>&nbsp;Dirección: </b><?php echo $sucursal?></span></td>
 </tr>
 <tr>
 	<td style="width: 100%;color: white" colspan="100">.</td>
 </tr>
 <tr ><td colspan="50" style="width: 50%"></td>
 <td colspan="35" style="width: 35%;border-bottom: 0.5px solid white; color:white">I</td>
 <td colspan="15" style="width: 15%"></td></tr>


 <tr>
 <td class="td-data-opt" colspan="100" style="width: 100%"><span class="data-opt"><b>&nbsp;Paciente: </b> <?php echo ucwords(strtolower($paciente));?></span></td>
 </tr> 
 <tr ><td colspan="50" style="width: 50%"></td>
 <td colspan="35" style="width: 35%;border-bottom: 0.5px solid black"></td>
 <td colspan="15" style="width: 15%"></td></tr>
</table>

<br> <br>

<table class="table2 info-productos" width="100%">
	<thead style="font-size: 9px">
	<tr style="background:#e7e9eb">
      <th colspan="5" style="width: 5%;border: solid 1px white">CANT</th>
      <th colspan="50" style="width: 50%;border: solid 1px white">DESCRIPCION</th>
      <th colspan="10" style="width: 10%;border: solid 1px white">P.UNIT</th>
      <th colspan="10" style="width: 10%;border: solid 1px white">VTAS. NO SUJETAS</th>
      <th colspan="10" style="width: 10%;border: solid 1px white">VTAS. EXENTAS</th>
      <th colspan="15" style="width: 15%;border: solid 1px white;color: #007dc4;background: #d7ecfb;text-align: right;">VENTAS GRAVADAS</th>
    </tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="85" style="width: 85%;font-size: 13px;text-align: center;color: white">.</td>
			<td colspan="15" style="color: #007dc4;background: #d7ecfb;color: #d7ecfb">.</td>
		</tr>
		<tr style="padding: 5px">
			<td colspan="5" style="width: 5%;text-align: center" class="data-desc"><?php echo $n_ojos;?></td>
			<td colspan="50" style="width: 50%;text-transform: uppercase;font-size: 11px" class="data-desc"><?php echo $descripcion?></td>
			<td colspan="10" style="width: 10%;font-size: 12px" class="data-desc">$<?php echo number_format(($precio/2),2,".",",")?></td>
			<td colspan="10" style="width: 10%;" class="data-desc"></td>
			<td colspan="10" style="width: 10%;" class="data-desc"></td>
			<td colspan="15" style="width: 15%;color: #007dc4;background: #d7ecfb;text-align: right;font-size: 13px" class="data-desc">$<?php echo number_format($monto,2,".",",");?></td>
		</tr>
		<tr>
			<td colspan="85" style="width: 85%; padding: 2px;font-size: 12px;text-align: center;color: white">.</td>
			<td colspan="15" style="color: #007dc4;background: #d7ecfb;color: #d7ecfb">.</td>
		</tr>

		<tr style="margin-top: 5px">
			<td colspan="85" style="width: 85%; color: white">.</td>
			<td colspan="15" style="color: #007dc4;background: #d7ecfb;"></td>
		</tr>

		<tr style="margin-top: 5px">
			<td colspan="85" style="width: 85%; padding: 1px;font-size: 12px;text-align: center">

			<table class="table2 info-productos" width="100%" style="text-align: center; margin: 12px">
				<thead>
					<tr>
						<th colspan="10" style="width: 10%;" class="rx-table"></th>
						<th colspan="18" style="width: 18%" class="rx-table">Esf.</th>
						<th colspan="18" style="width: 18%" class="rx-table">Cil.</th>
						<th colspan="18" style="width: 18%" class="rx-table">Eje</th>
						<th colspan="18" style="width: 18%" class="rx-table">Add.</th>
						<th colspan="18" style="width: 18%" class="rx-table"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="10" style="width: 10%;" class="rx-table"><b>OD</b></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $od_esf;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $od_cil;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $od_eje;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $od_add;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $od_prisma;?></td>
					</tr>

				    <tr>
						<td colspan="10" style="width: 10%;" class="rx-table"><b>OI</b></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $oi_esf;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $oi_cil;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $oi_eje;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"><?php echo $oi_add;?></td>
						<td colspan="18" style="width: 18%" class="rx-table"></td>
					</tr>

				</tbody>
			</table>

			</td>
			<td colspan="15" style="color: #007dc4;background: #d7ecfb;"></td>
		</tr>
		
	</tbody>
</table>
<br><br><br>
<table class="table2 info-productos data-montos" width="100%">
	<tr>
		<td colspan="60" style="width: 60%"><b>SON</b>: <?php echo numletras(number_format($monto,2,".",","),$_moneda);?></td>
		<td colspan="40" style="width: 40%"></td>
	</tr>

	<tr>
		<td colspan="65" style="width: 65%"></td>
		<td colspan="20" style="width: 20%;text-align: right;" class="border-montos"><b>Sub Total: $</b></td>
		<td colspan="10" style="width: 15%;text-align: right;" class="border-montos">$<?php echo number_format($monto,2,".",",");?></td>
	</tr>
	<tr>
		<td colspan="65" style="width: 65%; background: black; text-align: center;color: white">OPERACIONES MAYORES A $400</td>
		<td colspan="20" style="width: 20%;text-align: right;" class="border-montos"><b>IVA retenido: $</b></td>
		<td colspan="10" style="width: 15%;text-align: right;" class="border-montos">$<?php echo "";?></td>
	</tr>

	<tr style="">
			<td colspan="65" width="65%"></td>

		<td colspan="20" style="width: 20%;text-align: right;" class="border-montos"><b></b></td>
		<td colspan="10" style="width: 15%;text-align: right;" class="border-montos"><?php echo "";?></td>
	</tr>

	<tr style="">
	<td colspan="10" style="width: 10%; text-align: left;font-size: 10px;border-left: 2px solid #004999"><b>&nbsp;RECIBIDO:</b></td>
		<td colspan="22" style="width: 22%;"></td>
		<td colspan="10" style="width: 10%; text-align: left;font-size: 10px;border-left: 2px solid #004999"><b>&nbsp;ENTREGADO:</b></td>
		<td colspan="23" style="width: 23%;"></td>

		<td colspan="20" style="width: 20%;text-align: right;" class="border-montos"><b></b></td>
		<td colspan="10" style="width: 15%;text-align: right;" class="border-montos"></td>
	</tr>

	<tr>
		<td colspan="10" style="width: 10%; text-align: left;font-size: 10px;border-left: 2px solid #004999"><b>&nbsp;DUI:</b></td>
		<td colspan="22" style="width: 22%;"></td>
		<td colspan="10" style="width: 10%; text-align: left;font-size: 10px;border-left: 2px solid #004999"><b>&nbsp;DUI:</b></td>
		<td colspan="23" style="width: 23%;"></td>
		<td colspan="20" style="width: 20%;text-align: right;" class="border-montos"><b>No Sujeto: $</b></td>
		<td colspan="10" style="width: 15%;text-align: right;" class="border-montos">$<?php echo "0.00"?></td>
	</tr>

	<tr>
		<td colspan="10" style="width: 10%; text-align: left;font-size: 10px;border-left: 2px solid #004999"><b>&nbsp;FIRMA:</b></td>
		<td colspan="22" style="width: 22%;"></td>
		<td colspan="10" style="width: 10%; text-align: left;font-size: 10px;border-left: 2px solid #004999"><b>&nbsp;FIRMA:</b></td>
		<td colspan="23" style="width: 23%;"></td>
		<td colspan="20" style="width: 20%;text-align: right;" class="border-montos"><b>Exento: $</b></td>
		<td colspan="10" style="width: 15%;text-align: right;" class="border-montos">$<?php echo "";?></td>
	</tr>

	<tr>
		<td colspan="65" style="width: 65%"></td>
		<td colspan="20" style="width: 20%;text-align: right;color: blue" class="border-montos"><b>Total: $</b></td>
		<td colspan="10" style="width: 15%;text-align: right;color: blue" class="border-montos">$<b><?php echo number_format($monto,2,".",",");?></b></td>
	</tr>
</table>

