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
				$df2= $fcMail->RepFormatoFacturaVenta($documento['doc_num']);
				$fec_emis2 = date_format(date_create($df2[0]['fec_emis']->format('Y-m-d')),'d/m/Y');
				$fec_venc2 = date_format(date_create($df2[0]['fec_venc']->format('Y-m-d')),'d/m/Y');
				$cli_des2 = str_replace('\'', '', $df2[0]['cli_des']);
                $body = "<!DOCTYPE html>
								<html>
								<head>
									<title>Factura</title>
								</head>
								<body  style=\'font-size:14px\'>
								<table width=\'100%\' border=0>			
									  <tr>
									    <td>
									    	<b style=\'color:#384291;\'>FACTURA: </b> #". $df2[0]['doc_num']."
									    </td>
									   </tr>
									   <tr>
									   <td><b style=\'color:#384291;\'>PEDIDO: </b> #".$df2[0]['num_doc']."</td>
									   </tr>
									   <tr>
									        <td>
									            <b style=\'color:#384291;\'>NUMERO DE CONTROL: </b> #".$df2[0]['n_control']."
									        </td>
                                            <td rowspan=2 colspan=5  style=\'text-align: rigth;\'>
                                                <img src=\'http://200.71.189.252/fcmail/proventas-logotipo-512.png\' height=\'120\' width=\'120\'  style=\'text-align: left;\'>
                                            </td>
                                       </tr>
									  </tr>
									  <tr>
									    <td colspan=3><b style=\'color:#384291;\'>EMISION: </b>".$fec_emis2."</td>
									  </tr>
									  <tr>  
									    <td colspan=3><b style=\'color:#384291;\'>VENCIMIENTO: </b>".$fec_venc2."</td> 
									  </tr>
									  <tr>
									    <td colspan=3><b style=\'color:#384291;\'>CONDICION: </b>".$df2[0]['cond_des']."</td> 
                                      </tr>
									<tr>
										<td colspan=6><b style=\'color:#384291;\'>&nbsp;</td>
									</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>
									COD / CLIENTE: </b> (". $df2[0]['co_cli'].") ".$cli_des2."
									</td>
								</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>RIF: </b> ". $df2[0]['rif']."</td>
								</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>DIRECCION </b> ". $df2[0]['direc1']."</td>
								</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>DIRECCION DE ENTREGA: </b> ". $df2[0]['dir_entrega']."</td>
								</tr>
								<tr>
									<td colspan=6><b style=\'color:#384291;\'>TELEFONO: </b> ". $df2[0]['telefonos']."</td>
								</tr>
								
								<tr><td colspan=6><b style=\'color:#384291;\'>VENDEDOR: </b>(". $df2[0]['co_ven'].") ".$df2[0]['ven_des']."</td>
								</tr>
									<tr>
										<td colspan=6><b style=\'color:#384291;\'>TELEFONO: </b>". $df2[0]['telf']." </td>
									</tr>
									<tr>
										<td colspan=6>&nbsp;</td>
									</tr>
								</table>
								<table width=\'100%\' border=0>
									<tr>
										<th style=\'color:#384291;  text-align: left;\' width=\'5%\' border=0>CO ART</th>
										<th style=\'color:#384291; text-align: left;\'  width=\'45%\'>ARTICULO</th>
										<th style=\'color:#384291; text-align: left;\'>MODELO</th>
										<th style=\'color:#384291; text-align: left;\'>UNIDAD</th>
										<th style=\'color:#384291; text-align: right;\'>CANT</th>
										<th style=\'color:#384291; text-align: right;\'>PRECIO</th>
										<th style=\'color:#384291; text-align: right;\'>NETO</th>
									</tr>
									<tr>";
                $total2 = 0;
                $monto_iva = 0;
                $reglones = 0;
                foreach ($df2 as $articulo) {
                    $reglones++;
                    $total2+= $articulo['reng_neto'];
                    $cantidad =  number_format($articulo['total_art'], 0, ",", ".");
                    $precio = number_format($articulo['prec_vta'], 2, ",", ".");
                    $neto =  number_format($articulo['reng_neto'], 2, ",", ".");
                    $art_des = str_replace('\'', '', $articulo['des_art']);
                    $monto_iva += $articulo['monto_imp'];
                    $body.="<tr >
														<td >".$articulo['co_art']."</td>
														<td>".$art_des."</td>
														<td>".$articulo['modelo']."</td>
														<td>".$articulo['co_uni']."</td>
														<td style=\'text-align: right;\'>".$cantidad."</td>
														<td style=\'text-align: right;\'>".$precio."</td>
														<td style=\'text-align: right;\'>".$neto."</td>
													</tr>";
                }
                $total_bruto = number_format($df2[0]['total_bruto'], 2, ",", ".");
                $monto_desc = number_format($df2[0]['monto_desc'], 2, ",", ".");
                $porc_iva = number_format($df2[0]['porc_imp'], 2, ",", ".");
                $total_iva = number_format($monto_iva, 2, ",", ".");
                $total_neto = number_format($df2[0]['total_neto'], 2, ",", ".");
                $body.="	</table>
	                                        <table width=\'100%\' border=0>
	                                                <tr>
														<td colspan=6 style=\'border-bottom:1px solid black;\'></td>
													</tr>
													<tr>
														<td colspan=4></td>
														<td style=\'text-align: right;\'><b style=\'color:#384291;\'>SUB-TOTAL: </b>".$total_bruto."</td>
														<td style=\'text-align: right;\'><b style=\'color:#384291;\'>RENGLONES: </b>".$reglones."</td>
													</tr>
													<tr>
														<td colspan=4></td>
														<td style=\'text-align: right;\'><b style=\'color:#384291;\'>DESCUENTO: </b>".$monto_desc."</td>
														<td style=\'text-align: right;\'><b style=\'color:#384291;\'>BULTOS: </b>".$df2[0]['campo1']."</td>
													</tr>
													<tr>
														<td colspan=4></td>
														<td style=\'text-align: right;\'><b style=\'color:#384291;\'>I.V.A. ".$porc_iva."%:  </b>".$total_ivas."</td>
													</tr>
													<tr>
														<td colspan=4></td>
														<td style=\'text-align: right;\'><b style=\'color:#384291;\'>TOTAL A PAGAR:  </b>".$total_neto."</td>
													</tr>
													<tr>
														<td colspan=6>&nbsp;</td>
													</tr>
													<tr> 
													    <td>
													        <img height=\'80px\' src=\'http://200.71.189.252/fcmail/reciclar.png\' width=\'80px\' /></td> 
													    <td   colspan=4><b><span style=\'color: darkgreen; font-family: &quot;arial&quot; , &quot;helvetica&quot; , sans-serif; font-size: x-small;\'>Antes de imprimir este correo electrónico, piense bien si es necesario hacerlo: El medio ambiente es cuestión de todos.</span></b></td>
                                                    </tr>
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




