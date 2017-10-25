<?php

	require_once('../lib/conecciones.php');
	include("../lib/class/comision.class.php");
	include("../lib/class/reporte.class.php");

	$comision = new comision();
	
           

   
	$facturas = $comision->listadoFacturaComisionSaldoBasico2('2017-06-01','2017-06-30');
	//var_dump($facturas); exit();
	/*$fcobro = $comision->fechaCobroDocumento(4610);
	var_dump($fcobro);*/

	//exit();
/* ENTORNO DE PRUEBA DE DATA */
// $data = serialize($facturas); echo strlen($data) . " bytes";
echo "<link rel='stylesheet' href='prueba.css2'>";
	echo"<table width='100%'  class='w3-table-all'>
				<tr align='left'  class='w3-blue'>
					<th>DOC</th>
					<th>EMISION</th>		
					<th>DESPACHO</th>
					<th>RECEP</th>
					<th>VNC C</th>
					<th>COBRO</th>
					<th>CNEG</th>
					<th>DIAS C </th>
					<th>SEG</th>
					<th>CLI</th>
					<th>VEN</th>
					<th>COND</th>
					<th>BASE</th>
					<th>SALDO</th>
					<th>COMIS</th>
					<th>RESER</th>
					<th>lugar</th>
					<th>%</th>
					<th>%</th>

				</tr>
				<tr align='left'>
					<th colspan='12'>Cantidad: </th>

				</tr>
	";
	for($x=0;$x < count($facturas);$x++){
	# code...
		
		echo"<tr>";
			echo"<td>";
				echo utf8_encode($facturas[$x]['nro_orig']);
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['fec_emis'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['fecha_despacho'];
			echo"</td>";
			echo"<td align='right'><b>";
				echo $facturas[$x]['fecha_recibido'];
			echo"</b></td>";
			echo"<td align='right'>";
				echo $facturas[$x]['fec_venc_creada'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['fcobro'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['cneg'];
			echo"</td>";	
			echo"<td align='right'>";
				echo $facturas[$x]['diascalle'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_seg'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_cli'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['co_ven'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['cond'];
			echo"</td>";
	
			echo"<td align='right'>"; 
				echo number_format( $facturas[$x]['total_bruto'] , 2, ",", ".");
			echo"</td>";	
			echo"<td align='right'>";
				echo number_format($facturas[$x]['saldo'], 2, ",", ".");
			echo"</td>";
			echo"<td align='right'>";
				echo number_format($facturas[$x]['comision'], 2, ",", ".");
			echo"</td>";
			echo"<td align='right'>";
				echo  number_format($facturas[$x]['reserva'], 2, ",", ".");
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['porcentaje'];
			echo"</td>";
			echo"<td align='right'>";
				echo $facturas[$x]['corte'];
			echo"</td>";	
			echo"<td align='right'>";
				echo $facturas[$x]['idParametro'];
			echo"</td>";	
		echo"</tr>";
	
	}
/* FINALIZADO ENTORNO DE PRUEBA DE DATA */
	//exit();
?>
