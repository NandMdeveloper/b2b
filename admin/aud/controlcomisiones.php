<?php
	session_start();

	if ($_SESSION['tipo'] != 9 ) {
		header("Location: ../../index.php"); 
  		exit();
	}

	include('../lib/class/reporte.class.php');
	include('../lib/class/comision.class.php');
	include('../lib/conecciones.php');

	$opcion = $_GET['opcion'];

	switch ($opcion) {
		case "agregarcombo":
			//var_dump($_POST); exit();

			$productos = $_POST['tags'];

			$estatus = "Inactivo";
			$nombre = $_POST['nombre'];

			if(isset($_POST['estatus'])){
				$estatus = "Activo";
			}
			//se seleccionan solo los codigos de los productos
			$cod = explode("->",$productos);
			$codigos= array();

			for($x=0;$x < count($cod);$x++){
				$codigos[] =  substr($cod[$x], 0, 7);
			}

			//eliminammos valor no deseado del vector en este caso solo el primero(0)
			unset($codigos[0]);
			$comision =  new comision();

			//minimo se deben asignar 2 id de productos para crear un combo
			if(count($codigos)>1){

				$usuario=$_SESSION['user'];
				$msn = $comision->nuevoCombo($nombre,$estatus,$codigos,$usuario);

			}else{
				$comision->setMensajes('warning','Minimo son dos producto al crear un combo');

			}
			header("Location: comisionagregarcombo.php");

		break;
		case "agregarparametro":
			$campos = $_POST; 	
			//var_dump($campos); exit();

			$usuario = $_SESSION['user'];

			$comision =  new comision();
			$nombre = $_POST['nombre'];
			$limite1 = $_POST['limite1'];
			$limite2 = $_POST['limite2'];
			$limite3 = $_POST['limite3'];
			$porcentaje = $_POST['porcentaje'];
			$cuenta = $_POST['cuenta'];
			$tipo = $_POST['tipo'];
			$finicio = trim($_POST['finicio']);
			$ffinal = trim($_POST['ffinal']);

			if(!empty($nombre) and  !empty($cuenta) and !empty($tipo) and  !empty($finicio) and !empty($porcentaje)){
					$campos = $_POST;
					$comision->nuevoparametro($campos);

					$comision->add_log($usuario,"Agregar","Agrego el <strong>#parametro</strong> ".$campos['nombre']." En el periodo ".$campos['finicio']." ".$campos['ffinal']);

			}else{
				$comision->setMensajes('warning','llene todos los datos');
			}
			header("Location: comisonparametros.php?desde=".$finicio."&hasta=".$ffinal."");

		break;
		case "editarparametro":
			$campos = $_POST; //	var_dump($campos); exit();
			$usuario = $_SESSION['user'];
			$comision =  new comision();
			$nombre = $_POST['nombre'];
			$limite1 = $_POST['limite1'];

			$limite2 = $_POST['limite2'];
			$limite3 = $_POST['limite3'];

			$desde = $_POST['finicio'];
			$hasta = $_POST['ffinal'];

			$porcentaje = $_POST['porcentaje'];
			$cuenta = $_POST['cuenta'];
			$tipo = $_POST['tipo'];

			if(!empty($nombre) and  !empty($cuenta) and !empty($tipo)){
					$campos = $_POST;
					$comision->editarparametro($campos);

					$comision->add_log($usuario,"Edito","Edito el <strong>#parametro</strong>   " .$campos['id']."  " .$nombre." Tipo".$tipo.", cuenta:".$cuenta." En el periodo".$campos['finicio']." ".$campos['ffinal']);

			}else{
				$comision->setMensajes('warning','llene todos los datos');
			}
			header("Location: comisonparametroseditar.php?id=".$_POST['id']."&desde=".$desde."&hasta=".$hasta);

		break;
		case "eliminarparametro":
			$campos = $_GET; 	//var_dump($campos); exit();
			$usuario = $_SESSION['user'];
			$comision =  new comision();
		    $id=$_GET['id'];

		    $desde=trim($_GET['desde']);
		   $hasta=trim($_GET['hasta']);

					$campos = $_GET;
						//var_dump($campos); exit();
					$comision->eliminarparametros($campos);
		
			$comision->add_log($usuario,"Eliminar","Elimino el <strong>#parametro</strong>   ".$campos['id']." En el periodo".$campos['desde']." ".$campos['hasta']);
			
			header("Location: comisonparametros.php?desde=".$desde."&hasta=".$hasta);


		break;
		case "agregarcomision":

			//var_dump($_POST); exit();

			$nombre = $_POST['nombre'];
			$estatus = $_POST['estatus'];
			$tipo = $_POST['tipo'];
			$porcentaje = $_POST['porcentaje'];
			$campo = $_POST['campo'];
			$campo2 = $_POST['campo2'];
			$campo3 = $_POST['campo3'];
			$permanente = 0;

			$numerico1 = 0;
			$numerico2 = 0;
			$numerico3 = 0;
			$combo = 1;

			$finicio = null;
			$fsalir = null;

			$cond1 = null;
			$cond2 = null;
			$cond3 = null;

			//fechas
			if(isset($_POST['finicio'])){
				$finicio= $_POST['finicio'];
			}
			if(isset($_POST['fsalir'])){
				$fsalir= $_POST['fsalir'];
			}

			if(isset($_POST['vinicial1'])){
				$vinicial1= $_POST['vinicial1'];
			}
			if(isset($_POST['vinicial2'])){
				$vinicial2= $_POST['vinicial2'];
			}
			if(isset($_POST['vinicial3'])){
				$vinicial3= $_POST['vinicial3'];
			}
			if(isset($_POST['cond1'])){
				$cond1= $_POST['cond1'];
			}
			if(isset($_POST['vfinal1'])){
				$vfinal1= $_POST['vfinal1'];
			}
			if(isset($_POST['vfinal2'])){
				$vfinal2= $_POST['vfinal2'];
			}
			if(isset($_POST['vfinal3'])){
				$vfinal3= $_POST['vfinal3'];
			}

			if(isset($_POST['cond2'])){
				$cond2= $_POST['cond2'];
			}

			if(isset($_POST['cond3'])){
				$cond3= $_POST['cond3'];
			}

			if(isset($_POST['combo'])){
				$combo= $_POST['combo'];
			}

			if(isset($_POST['permanente'])){
				$permanente= $_POST['permanente'];
					if($permanente="on"){
						$permanente = 1;
					}
			}

			if(isset($_POST['numerico1'])){
				$numerico1= $_POST['numerico1'];
					if($numerico1="on"){
						$numerico1 = 1;
					}
			}

			if(isset($_POST['numerico2'])){
				$numerico2= $_POST['numerico2'];
					if($numerico2="on"){
						$numerico2 = 1;
					}
			}

			if(isset($_POST['numerico3'])){
				$numerico3= $_POST['numerico3'];
					if($numerico3="on"){
						$numerico3 = 1;
					}
			}
			$datos = array(
				"cmsTipo_id"=> $tipo,
				"nombre"=> $nombre,
				"inicio"=> $finicio,
				"final"=> $fsalir,
				"cmsCombo_id"=> $combo,
				"permanente"=> $permanente,
				"estatus"=> $estatus,
				"porcentaje"=> $porcentaje,
				"campo"=> $campo,
				"cond1"=> $cond1,
				"cond2"=> $cond2,
				"cond3"=> $cond3,
				"vinicial1"=> $vinicial1,
				"vinicial2"=> $vinicial2,
				"vinicial3"=> $vinicial3,
				"numerico1"=> $numerico1,
				"numerico2"=> $numerico2,
				"numerico3"=> $numerico3,
				"campo2"=> $campo2,
				"campo3"=> $campo3
			);
			$comision =  new comision();
			$msn = $comision->nuevaComision($datos);

			$url = $_SERVER['HTTP_REFERER'];
			//var_dump($msn);
			header("Location: comisioneditar.php");
		break;
		case "editarcomision":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->editarComision($campos,$campos['idcomision']);
			header("Location: comisioneditar.php?idcomi=".$campos['idcomision']);
		break;
		case "asignar":
			$campos = $_GET;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->getAsignar($campos['id_comision'],$campos['co_ven']);
			header("Location: comisionvendedor.php?co_ven=".$campos['co_ven']);
		break;
		case "agregargerenteventa":
			$campos = $_POST;
			$comision =  new comision();
			$msn = $comision->nuevagerenteVentas($campos);
			header("Location: comisionagregargerenteventa.php");
		break;
		case "agregargerenteregional":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->nuevagerenteregional($campos);
			header("Location: comisionagregargerenteregional.php");
		break;
		case "agregarMetaClave":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->nuevametaClave($campos);
			header("Location: comisionMetaClave.php");
		break;
		case "editargerenteregional":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->editarrenteregional($campos);
			header("Location: comisionagregargerenteReditar.php?id=".$campos['idg']);
		break;
		case "asignarZona":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->asignarZona($campos);
			header("Location: comisionagregargerenteReditar.php?id=".$campos['idgerente']);
		break;
		case "quitarZona":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->quitarZona($campos['gerenteregional_id'],$campos['id']);
			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Eliminar","gerente: ".$campos['idgerente']." Region".$campos['zona']." ".$campos['idregion']);

			}
			header("Location: comisionagregargerenteReditar.php?id=".$campos['idgerente']);
		break;
		case "agregarregion":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->nuevaRegion($campos);
			header("Location: comisionregion.php");
		break;
		case "agregarMetaRegional":
			$campos = $_POST;
			$comision =  new comision();
			$msn = $comision->nuevaMetaRegional($campos);
			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Agregar","Meta regional: ".$campos['desde']." ".$campos['hasta']." ".$campos['presupuesto']);

			}
			header("Location: comisionMetaRegion.php");
		break;
		case "agregarMetaVendedor":
			$campos = $_POST;
			// var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->nuevaMetaVendedor($campos);

			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Agregar","Meta vendedor: ".$campos['desde']." ".$campos['hasta']." ".$campos['presupuesto']);

			}
			header("Location: comisionMetaVendedor.php");
		break;
		case "editarMetaRegional":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->editarMetaRegional($campos);
			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Editar","Meta regional: ".$campos['desde']." ".$campos['hasta']." ".$campos['presupuesto']);
			}
			header("Location: comisionMetaRegionEditar.php?id=".$campos['idm']);
		break;
		case "editarMetaVendedor":
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->editarMetaVendedor($campos);
			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Editar","Meta vendedor: ".$campos['desde']." ".$campos['hasta']." ".$campos['presupuesto']." ".$campos['idm']);
			}
			header("Location: comisionMetaVendEditar.php?id=".$campos['idm']);
		break;
		case "editarregion":
			//$reporte = new reporte;
			$campos = $_POST;
			//var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->editarRegion($campos);

			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Edito","comisionEditarregion: editp: ".$campos['idr']." ".$campos['nombre']);
			}
			header("Location: comisionEditarregion.php?id=".$campos['idr']);
		break;
		case "gerenteventaeditar":
			//$reporte = new reporte;
			$campos = $_POST;
			$comision =  new comision();
			$msn = $comision->editarGerenteVentas($campos);

			if ($msn['error']=='no') {
				$usuario = $_SESSION['user'];
				$comision->add_log($usuario,"Edito","comisionagregargerenteVeditar: editp: ".$campos['idr']." ".$campos['nombre']);
			}
			header("Location: comisionagregargerenteVeditar.php?id=".$campos['id']);
		break;	
		case "editarMetaClave":
			$usuario=$_SESSION['user'];			
			$campos = $_POST;
			//var_dump($campos); exit();
			
			$comision =  new comision();
			$msn = $comision->editarMetaClave($campos);
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Edicion","comisionMetaClaveEdit.php: presupuesto: ".$campos['presupuesto']." ".$campos['estatus']);

			}
			header("Location: comisionMetaClaveEdit.php?id=".$campos['idm']);
		break;
		case "registrarFacturas":
			$usuario=$_SESSION['user'];			 
			$campos = $_POST;
			
			$comision =  new comision();
			$facturas = $comision->listadoFacturaComisionSaldoBasico2($campos['desde'],$campos['hasta']);
			$msn = $comision->registrarComisionesUno($campos['desde'],$campos['hasta'],$facturas);
			echo json_encode($msn);
			
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Guardar","registrarFacturas: facturas con comision fecha: ".$campos['desde']." ".$campos['hasta']);

			}
			//header("Location: comisionMetaClaveEdit.php?id=".$campos['idm']);
		break;
		case "registrarGVentasmes":
			$usuario=$_SESSION['user'];			
			$campos = $_POST;
			
			$comision =  new comision();
			$msn = $comision->registrarComisionesGerentesVentas(05);

			
			echo json_encode($msn);
			
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Guardar","registrarGVentasmes: registro: ".$msn['cantidad']." gerentes de venta para fecha: ".$msn['desde']." - ".$msn['hasta']);

			}
		
			//header("Location: comisionMetaClaveEdit.php?id=".$campos['idm']);
		break;
		case "registrarGregionalesMes":
			$usuario=$_SESSION['user'];			
			$campos = $_POST;

			$mes = date("m",strtotime($campos['desde']));

			$comision =  new comision();
			$msn = $comision->registrarGerentesRegionales($mes);

					
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Guardar","registrarGregionalesMes: registro: ".$msn['cantidad']." gerentes de venta para fecha: ".$msn['desde']." - ".$msn['hasta']);

			}
		header("Location: comisionagregargerenteregional.php");
		break;
		case "registrarVededoresMetasMes":
			$usuario=$_SESSION['user'];			
			$campos = $_POST;
			
			$comision =  new comision();
			$msn = $comision->registrarVededoresMetas(05);

			
			//echo json_encode($msn); exit();
			echo var_dump($msn); exit();
			
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Guardar","registrarGregionalesMes: registro: ".$msn['cantidad']." gerentes de venta para fecha: ".$msn['desde']." - ".$msn['hasta']);
			}		
		break;
		case "copiarParametros":
			$usuario=$_SESSION['user'];			
			$campos = $_POST;
			//echo var_dump($campos); exit();
			$comision =  new comision();
			$msn = $comision->copiarParametros($campos['fdesde'],$campos['fhasta'],$campos['Adesde'],$campos['Ahasta']);
			
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"copiar","Copio: <strong>#parametro</strong>: ".$msn['cantidad']."  fecha: ".$campos['Adesde']." - ".$campos['Ahasta']." <strong>a</strong> ".$campos['fdesde']." - ".$campos['fhasta']);
			}	
			header("Location: comisonparametros.php?desde=".$campos['fdesde']."&hasta=".$campos['fhasta']);	
		break;
		case "agregarperiodo":
			$usuario=$_SESSION['user'];		
			$campos = $_POST;
			
			$comision =  new comision();
			$msn = $comision->agregarPeriodo($campos);

			//echo var_dump($campos); exit();

			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Guardar","comisionActividad: ".$campos['co_ven']."  fecha: ".$campos['desde']." - ".$campos['hasta']." -> ".$campos['tipo']." -> ".$campos['estatus']);
			}
		header("Location: comisionActividad.php");	
		break;
		case "eliminarCambio":

			$id = $_GET['id'];
			$documento = $_GET['documento'];
			//var_dump($documento); exit();
			$usuario=$_SESSION['user'];		
			$campos = $_POST;
			
			$comision =  new comision();
			$msn = $comision->setEliminarCambio($id,$documento);
			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Eliminar".$id,"elimino");
			}
				//echo $_SERVER["HTTP_REFERER"]; exit();
		header("Location: ".$_SERVER["HTTP_REFERER"]);	
		break;
		case "editarPeriodo":
			$usuario=$_SESSION['user'];		
			$campos = $_POST;

			$comision =  new comision();
			$msn = $comision->editarPeriodo($campos);

			//echo var_dump($campos); exit();

			if ($msn['error']=='no') {
				$comision->add_log($usuario,"Editar","comisionActividad: ".$campos['co_ven']."  fecha: ".$campos['desde']." - ".$campos['hasta']." -> ".$campos['tipo']." -> ".$campos['estatus']);
			}
		header("Location: comisionActividadEditar.php?id=".$campos['id']."&desde=".$campos['desde']."&hasta=".$campos['desde']);	
		break;
		case "agregarActividadesUsuarios":
			//exit();
			$mes = $_GET['mes'];
			if (empty($mes)) {
     			$mes = date("m");
   			}
		$comision =  new comision();
        $ultimoDia = $comision->getUltimoDiaMes(date("Y"),$mes);
        $ultimoDiaMes = date("Y")."-".$mes."-".$ultimoDia;
        $primerDiaMes = date("Y")."-".$mes."-01";

        $sel="select co_ven from saVendedor";
          $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }
        sqlsrv_free_stmt($result);

		$conn = conectarServ(1);
        for ($i=0; $i < count($datos); $i++) {         	
        	$sqlBus = "SELECT * FROM `cmsvendedoresactividad` 
        	WHERE `co_ven` = '".trim($datos[$i]["co_ven"])."' 
        	and month(desde)=month('".$primerDiaMes."') and 
        	year(desde) = year('".$primerDiaMes."') ORDER BY `desde` DESC";

        	echo $sqlBus."<br>";
        	 $rsb = mysqli_query($conn,$sqlBus) or die(mysqli_error($conn));
        	 if (mysqli_num_rows($rsb) == 0) {
        	 // Insertamos actividade del mes 
					$in="INSERT INTO `cmsvendedoresactividad`
					(`id`, `co_ven`, `desde`,
					`hasta`, `tipo`, `estatus`,
					`creado`, `fech_emi`, `modificado`,
					`fech_mod`, `region`) VALUES 
					(null,'".$datos[$i]["co_ven"]."','".$primerDiaMes."',
					'".$ultimoDiaMes."','Vendedor','Activo',
					'Sistema', CURRENT_TIME(),'Sistema',
					CURRENT_TIME(),0);";
					$rs = mysqli_query($conn,$in) or die(mysqli_error($conn));
					echo $in;  echo "<br>";
        	 } 

		}
		break;

	case "calle": 
		$fecha1 = new DateTime('2017-06-27');
     	$fecha2 = new DateTime('2017-06-30');

       	$fecha = $fecha2->diff($fecha1);
        $diferencia = $fecha->format('%a');

        $cneg = 10;

     	if ($fecha1 < $fecha2) {
     		$diferencia = $diferencia *-1;
     	}

     	$diasCalle = $diferencia + $cneg; 


        echo $diasCalle; 
	break;
	case "cobros": 


		break;
		case 'arbitrario':
			$var  = $_POST['docs'];
			$var = substr($var, 0, -2);	
			$documentos = explode("<>", $var);
			
			$datos = array();
			for ($i=0; $i < count($documentos); $i++) { 
				if($i==0){

					$datos[$i] =  $documentos[$i];	
				}else{
					$datos[$i] = substr($documentos[$i], 1, -1);	
				}
			}
			if (count($datos > 0)) {
				$comision =  new comision();
				$msn = $comision->agregarCambiosComision($datos);	
				echo json_encode($msn);
			}
		break;
		case 'procedimiento':
		   $conn = conectarSQlSERVER(); 

		   $myparams['sCo_Cli_d'] = "1711010";
			$myparams['sCo_Cli_h'] = "1711010";
			$myparams['dFecha_Emis_d'] = "2017-01-01";

		   $procedure_params = array(
			array(&$myparams['sCo_Cli_d'], SQLSRV_PARAM_IN),
			array(&$myparams['sCo_Cli_h'], SQLSRV_PARAM_IN),
			array(&$myparams['dFecha_Emis_d'], SQLSRV_PARAM_IN)
			);

		   $sel = "EXEC  home.dbo.RepDocumentoCXCxCliente @sCo_Cli_d = ?, @sCo_Cli_h = ?, @dFecha_Emis_d = ?";
		     
		     $stmt = sqlsrv_prepare($conn, $sel, $procedure_params);
		     if( !$stmt ) {
				die( print_r( sqlsrv_errors(), true));
				}
						     $doc = array();
						          $x = 0;
						     if(sqlsrv_execute($stmt)){
						          //$result=sqlsrv_query($conn,$sel);
						          while($row=sqlsrv_fetch_array($stmt)) {          
						              foreach($row as $key=>$value) {
						                $doc[$x][$key]=$value;
						              }

						              $x++;           
						          }
						      }
		         ?>
					<table>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>


						<?php 
							$total = 0;

							foreach ($doc as $d) {
							if (trim($d['1']) == "ADEL" or trim($d['1']) == "AJNA"
					            or trim($d['1']) == "N/CR" or trim($d['1']) == "AJNM"
					             or trim($d['1']) == "IVAN" or trim($d['1']) == "IVAP") {

					                $d['total_neto'] = $d['total_neto'] * -1;

          					  }   
							$total+=$d['total_neto'];
						 ?>
						<tr>
							<td><?php echo $d['0'] ?></td>
							<td><?php echo $d['1'] ?></td>
							<td><?php echo $d['co_ven'] ?></td>
							<td><?php echo $d['co_cli']  ?></td>
							<td><?php echo $d['fec_emis']->format('Y-m-d'); ?></td>
							<td><?php echo $d['fec_venc']->format('Y-m-d'); ?></td>
							<td><?php echo $d['7'] ?></td>
							<td><?php echo $d['total_neto'] ?></td>
							<td><?php echo $d['saldo'] ?></td>
						</tr>
						<?php 
						
							}
						 ?>
						 <tr>
							<td colspan="9"><?php echo $total ?></td>
							
						</tr>
					</table>
		         <?php
		break;
		case "com2":
			$desde = '2017-06-01';
			$hasta = '2017-06-30';
		?>
				<table width="100%">
					<tr>
						<td colspan="6"><?php echo $hasta; ?></td>							
					</tr>
					<tr>
						<td>REGION</td>
						<td>CO_VEN</td>
						<td>VEN_DES</td>
						<td>PRESUPUESTO</td>
						<td>VENTAS</td>
						<td>REALIZACION</td>
						<td>PORCENTAJE</td>
						<td>COBROS</td>
						<td>COMISION</td>							
					</tr>
				
		<?php
			$comision =  new comision();
			$nComisiones = $comision->getComisiones2total($desde,$hasta);
			for ($i=0; $i < count($nComisiones); $i++) { 
				?>
					<tr>
						<td><?php echo $nComisiones[$i]['nombreregion'] ?></td>
						<td><?php echo $nComisiones[$i]['co_ven'] ?></td>
						<td><?php echo $nComisiones[$i]['ven_des'] ?></td>
						<td><?php echo number_format($nComisiones[$i]['presupuesto'], 2, ",", ".") ?></td>
						<td><?php echo number_format($nComisiones[$i]['ventas'], 2, ",", ".") ?></td>
						<td align='right'><?php echo number_format($nComisiones[$i]['realizacion'], 2, ",", ".") ?> %</td>
						<td align='right'><?php echo number_format($nComisiones[$i]['porcentaje'], 2, ",", ".") ?> %</td>
						<td align='right'><?php echo number_format($nComisiones[$i]['cobros'], 2, ",", ".") ?> %</td>
						<td align='right'><?php echo number_format($nComisiones[$i]['comision'], 2, ",", ".") ?> %</td>					
					</tr>
				<?php
		
			}
					?>
		
				</table>
		<?php  
	
		break;
		case "muestra":
			$campos = $_POST;
			if ($campos['tipo'] == "ventas") {
				header("Location: comisionesventas.php?periodo=".$campos['desde']."&hasta=".$campos['hasta']);	
			}
			if ($campos['tipo'] == "cobros") {
				header("Location: comisionesactuales.php?desde=".$campos['desde']."&hasta=".$campos['hasta']);	
			}
	
		break;
	}

?>
