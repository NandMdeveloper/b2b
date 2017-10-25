<?php
	ini_set('display_errors', 1);
	require("../PHPMailer/PHPMailerAutoload.php");
	require("lib/class/correo.class.php");
	require("lib/conecciones.php");

	$opcion = $_GET['opcion'];

	switch ($opcion) {
		case 'infofactura':
			
			$fcMail = new correo();
			$documentos = $fcMail->getfacturasParaEmail();
			foreach ($documentos as $documento) {
				$nombre = 	ucwords(strtolower($documento['ven_des']));
				$destino = 	strtolower($documento['correo']);
				
				$df = $fcMail->detalleFactura($documento['doc_num']);
				$fec_emis = date_format(date_create($df["cabezera"][0]['fec_emis']->format('Y-m-d')),'d/m/Y');
				$cli_des = str_replace('\'', '', $df["cabezera"][0]['cli_des']);
				
					$body = "<!DOCTYPE html>
								<html>
								<head>
									<title>Factura</title>
								</head>
								<body  style=\'font-size:14px\'>
								<table width=\'100%\' border=0>			
									  <tr>
									    <td>
									    	<b style=\'color:#384291;\'>FACTURA</b> #". $df["cabezera"][0]['doc_num']."
									    </td>
									   <td colspan=3><b style=\'color:#384291;\'>EMISION: </b>".$fec_emis."</td>
									   
									
									    <td rowspan=2 colspan=5  style=\'text-align: left;\'>
									    	<img src=\'http://200.71.189.252/fcmail/proventas-logotipo-512.png\' height=\'120\' width=\'120\'  style=\'text-align: left;\'>
									    </td>
									  </tr>
									  <tr>
									    <td><b style=\'color:#384291;\'>PEDIDO</b> #</td>
									       <td colspan=3><b style=\'color:#384291;\'>CONDICION: </b>".$df["cabezera"][0]['co_cond']."</td> 
									  </tr>
									<tr>
										<td colspan=6><b style=\'color:#384291;\'>&nbsp;</td>
									</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>
									COD / CLIENTE: </b> (". $df["cabezera"][0]['co_cli'].") ".$cli_des."
									</td>
								</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>TELEFONO: </b> ". $df["cabezera"][0]['tel_cliente']."</td>
								</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>RIF: </b> ". $df["cabezera"][0]['clirif']."</td>
								</tr>
								<tr><td colspan=6><b style=\'color:#384291;\'>VENDEDOR: </b>(". $df["cabezera"][0]['co_ven'].") ". $df["cabezera"][0]['ven_des']."</td>
								</tr>
									<tr>
										<td colspan=6><b style=\'color:#384291;\'>TELEFONO: </b> ". $df["cabezera"][0]['telefonos']."</td>
									</tr>
									<tr>
										<td colspan=6>&nbsp;</td>
									</tr>
									<tr>
										<th style=\'color:#384291;  text-align: left;\'>CO ART</th>
										<th style=\'color:#384291; text-align: left;\'>ARTICULO</th>
										<th style=\'color:#384291; text-align: left;\'>UNIDAD</th>
										<th style=\'color:#384291; text-align: right;\'>CANT</th>
										<th style=\'color:#384291; text-align: right;\'>NETO</th>
									</tr>
									<tr>";
									$total = 0;
										foreach ($df["cuerpo"] as $articulo) { 
											$total+= $articulo['reng_neto'];
											$unidad =  number_format($articulo['total_art'], 0, ",", ".");
											$neto =  number_format($articulo['reng_neto'], 2, ",", ".");
											$art_des = str_replace('\'', '', $articulo['art_des']);
											$body.="<tr >
														<td >".$articulo['co_art']."</td>
														<td>".$art_des."</td>
														<td>".$articulo['co_uni']."</td>
														<td style=\'text-align: right;\'>".$unidad."</td>
														<td style=\'text-align: right;\'>".$neto."</td>
													</tr>";
										}
										$total =  number_format($total, 2, ",", ".");
										$body.="	<tr>
														<td colspan=6 style=\'border-bottom:1px solid black;\'></td>
													</tr
													<tr>
														<td colspan=4></td>
														<td style=\'text-align: right;\'>".$total."</td>
													</tr>
													<tr>
														<td colspan=6>&nbsp;</td>
													</tr>
													<tr> 
													<td>
													<img height=\'80px\' src=\'http://200.71.189.252/fcmail/reciclar.png\' width=\'80px\' /></td> 
													<td   colspan=4><b><span style=\'color: darkgreen; font-family: &quot;arial&quot; , &quot;helvetica&quot; , sans-serif; font-size: x-small;\'>Antes de imprimir este correo electrónico, piense bien si es necesario hacerlo: El medio ambiente es cuestión de todos.</span></b></td></tr>
											</table>
										</body>
										</html>";
				
				$datos = array(				
					'From' =>"facturas@grupopro.com.ve",
					'FromName' =>$nombre,
					'destino'=> $destino,
					'Subject'=> "Detalle de Factura #".$documento['doc_num'],
					'tipo'=> "Detalle de Factura",
					'body'=> $body,
					'doc_num'=> $documento['doc_num'],
					'co_ven'=> $documento['co_ven']
				);
				$cor = $fcMail->setEmailDetalles($datos);
	
			}
			break;
		
		case 'enviarFacturas':

			$fcMail = new correo();
			$correos = $fcMail->getMasivos();
			
			foreach ($correos['datos'] as $correo) {
				$datos_enviar = array(
					'destino' => $correo['destino'],
					'Subject' =>  $correo['titulo'],
					'body' => $correo['cuerpo'],
					'de' => $correo['de'],
					'FromName' => $correo['nombre']
				);
				$enviado = $fcMail->enviar($datos_enviar);
				if ($enviado==1) {
					$fcMail->setEstadoMasivo(1,$correo['documento']);
				}				

			}

			break;
	}




