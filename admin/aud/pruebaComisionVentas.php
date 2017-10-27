<?php

	require_once('../lib/conecciones.php');
	include("../lib/class/comision.class.php");
	include("../lib/class/reporte.class.php");

	$comision = new comision();
	
           

   
	$facturas = $comision->listadoFacturaComisionVentas('2017-09-01','2017-10-02');
	//var_dump($facturas); exit();
	/*$fcobro = $comision->fechaCobroDocumento(4610);
	var_dump($fcobro);*/

	//exit();
/* ENTORNO DE PRUEBA DE DATA */
// $data = serialize($facturas); echo strlen($data) . " bytes";
echo "<link rel='stylesheet' href='prueba.css'>";
	echo"<table width='100%'  class='w3-table-all'>
				<tr align='left'  class='w3-blue'>
					<th>DOC</th>
					<th>EMISION</th>		
					<th>CO_VEN</th>
					<th>VENDEDOR</th>
					<th>CO_CLI</th>
					<th>CLIENTE</th>
					<th>MONTO</th>
					<th>SEG</th>
					<th>SEG</th>
					<th>ZON</th>
					<th>ZON</th>
					<th>DIAS</th>
					<th>COND</th>
					<th>COND</th>
					<th>COMIS</th>
					<th>cal_comision</th>
					<th>porcentaje</th>

				</tr>
				<tr align='left'>
					<th colspan='12'>Cantidad: </th>

				</tr>
	";
	for($x=0;$x < count($facturas);$x++){
	# code...
		
		echo"<tr>";
			echo"<td>";
				echo utf8_encode($facturas[$x]['doc_num']);
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['fec_emis']->format("Y-m-d");
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['covendedor'];
			echo"</td>";
			echo"<td align='right'><b>";
				echo $facturas[$x]['ven_des'];
			echo"</b></td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_cli'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_cli'];
			echo"</td>";
			echo"<td align='right'>"; 
				echo number_format( $facturas[$x]['total_bruto'] , 2, ",", ".");
			echo"</td>";	
			echo"<td align='right'>";
				echo $facturas[$x]['co_seg'];
			echo"</td>";	
			echo"<td align='right'>";
				echo $facturas[$x]['seg_des'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_zon'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['zon_des'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['dias_cred'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_cond'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['cond_des'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['comision'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['cal_comision'];
			echo"</td>";	
			echo"<td align='right'>";
				echo $facturas[$x]['porcentaje'];
			echo"</td>";	
		echo"</tr>";
	
	}
/* FINALIZADO ENTORNO DE PRUEBA DE DATA */
	//exit();
?>
