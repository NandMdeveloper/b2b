<?php 
	session_start();


	include('lib/class/cliente.class.php');
	include('lib/conecciones.php');
	$opcion = $_GET['opcion'];


	switch ($opcion) {
		case 'cxccliente':
			$var = $_POST;

			$co_cli = $var['co_cli'];
			$cliente = new cliente();
			$documentos = $cliente->getCXCCliente($co_cli,'2017-01-01','2017-09-26');
			$cliente = $cliente->getDatosCliente($co_cli);
			?>
			<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Documentos CXC: <small><?php echo $cliente[0]['cli_des']; ?></small></h4>
            </div>
             <div class="modal-body">
			<table  id='dataTables-example' class="table table-striped table-hover table-responsive">
				  <thead>
				    <tr>
				      <th>Doc</th>
				      <th>Tipo</th>
				      <th>Vendedor</th>
				      <th>Emision</th>
				      <th>Anulado</th>
				      <th class="text-right">Neto</th>
				      <th class="text-right">Saldo</th>
				    </tr>
				  </thead>

 				<tbody>
						<?php 
							$total = 0;
							$tsaldo = 0;

							foreach ($documentos as $d) {
							if (trim($d['1']) == "ADEL" or trim($d['1']) == "AJNA"
					            or trim($d['1']) == "N/CR" or trim($d['1']) == "AJNM"
					             or trim($d['1']) == "IVAN" or trim($d['1']) == "IVAP") {

					                $d['total_neto'] = $d['total_neto'] * -1;
					                $d['saldo'] = $d['saldo'] * -1;

          					  }   
							$total+=$d['total_neto'];
							$tsaldo+=$d['saldo'];
						 ?>
						<tr>
							<td><?php echo $d['0'] ?></td>
							<td><?php echo $d['1'] ?></td>
							<td><?php echo $d['co_ven'] ?></td>

							<td><?php echo $d['fec_emis']->format('Y-m-d'); ?></td>
							<td><?php echo $d['anulado'] ?></td>
							<td class="text-right"><?php echo number_format($d['total_neto'], 2, ",", "."); ?></td>
							<td class="text-right"><?php echo  number_format($d['saldo'], 2, ",", ".");  ?></td>
						</tr>
						<?php 
						
							}
						 ?>
						 <tr>
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
							<td  class="text-right"><?php echo  number_format($total, 2, ",", "."); ?></td>
							<td  class="text-right"><?php  echo number_format($tsaldo, 2, ",", "."); ?></td>
							
						</tr>
						 </tbody>
					</table>
					 </div>
					      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
		         <?php
			break;
		case 'clientesActuales':
			$var = $_POST;

			$co_ven = $var['co_ven'];
			$hasta = $var['hasta'];
			$tipo = $var['tipo'];
			$cliente = new cliente();

			$documentos = $cliente->getClientesActuales(null,null,$hasta,$co_ven);
			if ($tipo == "nuevos") {				
				$documentos = $cliente->getClientesNuevos(null,null,$hasta,$co_ven);
			}
			if ($tipo == "regulares") {
				
				$documentos = $cliente->getClientesRegulares(null,null,$hasta,$co_ven);
			}
		
			?>
			<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Clientes</small></h4>
            </div>
             <div class="modal-body">
			<table  id='dataTables-example' class="table table-striped table-hover table-responsive">
				  <thead>
				    <tr>
				      <th>RIF</th>
				      <th>CLIENTE</th>
				      <th>TELEFONO</th>
				      <th>EMAIL</th>
				    </tr>
				  </thead>

 				<tbody>
						<?php 
							$total = 0;
							$tsaldo = 0;
							if (count($documentos) > 0) {					
								foreach ($documentos as $d) {
								
								 ?>
								<tr>
									<td><?php echo $d['rif'] ?></td>
									<td><?php echo $d['cli_des'] ?></td>
									<td><?php echo $d['telefonos'] ?></td>

									<td><?php echo $d['email']?></td>
								</tr>
								<?php 
							
								}
							}else{
								 ?>
						 <tr>
							<td colspan="4" class="text-center"> Sin resultados</td>
							
						</tr>
							<?php 	
							}
						 ?>
						 
						 </tbody>
					</table>
					 </div>
					      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
		         <?php
			break;
		
		default:
			# code...
			break;
	}

 ?>