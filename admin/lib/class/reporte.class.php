<?php
	class reporte {
		public $inicioAnio = "";

	public function getinicioAnio(){
		$anio = date("Y");
		$this->inicioAnio = $anio."-01-01";
		return $this->inicioAnio;

	}
		function add_log($user,$tipo,$accion){
		$conn = conectarServ(1);
		$query = "
		INSERT INTO cmsLog (id,usuario,tipo,detalle,fecha)";
		$query .= "  VALUES (NULL,'$user','$tipo','$accion',NOW())";
		$res=mysqli_query($conn,$query);	
	}
	public function cobrosDeClientes($fecha){
			$conn = conectarSQlSERVER();
			$ini = $this->getinicioAnio();

			$sel="select
					CB.co_ven,
					CD.fe_us_in,
					TD.co_tipo_doc,
					TD.descrip,
					CD.mont_cob,
					CLI.co_cli,
					CLI.cli_des,
					CD.cob_num
				from
				saCobroDocReng as CD
				INNER JOIN saCobro AS CB ON CB.cob_num = CD.cob_num
				INNER JOIN saCliente AS CLI ON CLI.co_cli = CB.co_cli
				INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = CD.co_tipo_doc
				where CD.fe_us_in > '".$ini."'
				and TD.co_tipo_doc IN('N/CR', 'CHEQ','ADEl','FACT','N/DB')";


			$i=0;

			$res_array = array();

			$result=sqlsrv_query($conn,$sel);
			while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;
				}
				$i++;
			}
			return($res_array);
		}
	public function getCondicion($nro_doc){
		$conn = conectarSQlSERVER();
		$cond = "--";

		$sel="select CP.cond_des from saFacturaVenta as FV
		INNER JOIN saCondicionPago as CP ON CP.co_cond = FV.co_cond
		where FV.doc_num = '".$nro_doc."'";
		$result=sqlsrv_query($conn,$sel);
		$row=sqlsrv_fetch_array($result);
		$cond = $row[0];
		return $cond;
	}
	public function cobrosDeFactura($nro_doc){
			$conn = conectarSQlSERVER();
			$sel="select
						TD.co_tipo_doc,
						TD.descrip,
						CD.mont_cob,
						CD.fe_us_in,
						CD.cob_num
					from
					saCobroDocReng as CD
					INNER JOIN saCobro AS CB ON CB.cob_num = CD.cob_num
					INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = CD.co_tipo_doc
					where CD.nro_doc ='".$nro_doc."'";
			$i=0;

			$res_array = array();

			$result=sqlsrv_query($conn,$sel);
			while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;

				}
				$i++;
			}
			return($res_array);
		}
	public function getSaldos($co_cliente){
		$conn = conectarSQlSERVER();
		$sel="
		-- Add the RepDocumentoCXCxNumero
	  SELECT
	          DC.nro_doc, DC.co_tipo_doc,
	          DC.co_ven, DC.co_cli,
	          DC.anulado, DC.otros1,
	          DC.otros2,
	          DC.otros3, DC.total_neto / ( CASE WHEN NULL IS NULL THEN 1
	                                ELSE DC.tasa
	                           END ) * ( CASE WHEN DC.anulado = 1 THEN 0
	                                          ELSE 1
	                                     END ) AS total_neto,
	          DC.saldo / ( CASE WHEN NULL IS NULL THEN 1
	                ELSE DC.tasa
	           END ) * ( CASE WHEN DC.anulado = 1 THEN 0
	                          ELSE 1
	                     END ) AS saldo,
	          DC.tasa,
	          DC.total_bruto,
	          DC.monto_imp,
						 P.cli_des,
	          TP.descrip,
	          TP.tipo_mov
	        FROM
	            saDocumentoVenta AS DC
	            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
	            LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc";

							if(!empty($co_cliente)){
							 $sel.=" where  P.co_cli='".$co_cliente."' ";

						 }
						 $sel.=" ORDER BY DC.co_tipo_doc";

							$i=0;
							$res_array = array();

							$NCR = array();
							$ADEL = array();
							$AJNA = array();
							$AJNM = array();

							$AJPA = array();
							$AJPM = array();
							$CHEQ = array();
							$FACT = array();

							$IVAN = array();
							$IVAP = array();
							$NDB = array();

							$result=sqlsrv_query($conn,$sel);
							while($row=sqlsrv_fetch_array($result)){
									if(trim($row['co_tipo_doc']) == "ADEL"){
										if($row[9]==0){
											$ADEL[] = $row[9];
										}else{
											$ADEL[] = $row[9]*-1;
										}
									}

									if(trim($row['co_tipo_doc']) == "AJNA"){

										if($row[9]==0){
											$AJNA[] = $row[9];
										}else{
											$AJNA[] = $row[9]*-1;
										}

									}

									if(trim($row['co_tipo_doc']) == "N/CR"){

										if($row[9]==0){
											$NCR[] = $row[9];
										}else{
											$NCR[] = $row[9]*-1;
										}

									}

									if(trim($row['co_tipo_doc']) == "AJNM"){

										if($row[9]==0){
											$AJNM[] = $row[9];
										}else{
											$AJNM[] = $row[9]*-1;
										}

									}

									if(trim($row['co_tipo_doc']) == "AJPA"){

										if($row[9]==0){
											$AJPA[] = $row[9];
										}else{
											$AJPA[] = $row[9];
										}
									}
									if(trim($row['co_tipo_doc']) == "AJPM"){

										if($row[9]==0){
											$AJPM[] = $row[9];
										}else{
											$AJPM[] = $row[9];
										}

									}
									if(trim($row['co_tipo_doc']) == "CHEQ"){

										if($row[9]==0){
											$CHEQ[] = $row[9];
										}else{
											$CHEQ[] = $row[9];
										}

									}
									if(trim($row['co_tipo_doc']) == "FACT"){

										if($row[9]==0){
											$FACT[] = $row[9];
										}else{
											$FACT[] = $row[9];
										}

									}
									if(trim($row['co_tipo_doc']) == "IVAN"){

										if($row[9]==0){
											$IVAN[] = $row[9];
										}else{
											$IVAN[] = $row[9]*-1;
										}
									}
									if(trim($row['co_tipo_doc']) == "IVAP"){

										if($row[9]==0){
											$IVAP[] = $row[9];
										}else{
											$IVAP[] = $row[9]*-1;
										}
									}
									if(trim($row['co_tipo_doc']) == "N/DB"){

										if($row[9]==0){
											$NDB[] = $row[9];
										}else{
											$NDB[] = $row[9];
										}
									}
									foreach($row as $key=>$value){
										$res_array[$i][$key]=$value;
									}
									$i++;
							}

							$saldos = array();

							$ADEL = array_sum($ADEL);
							$AJNA = array_sum($AJNA);
							$AJNM = array_sum($AJNM);

							$AJPA = array_sum($AJPA);
							$AJPM = array_sum($AJPM);
							$CHEQ = array_sum($CHEQ);
							$FACT = array_sum($FACT);

							$IVAN = array_sum($IVAN);
							$IVAP = array_sum($IVAP);
							$NCR = array_sum($NCR);
							$NDB = array_sum($NDB);

							$saldo = $ADEL+ $AJNA+ $AJNM + $AJPA + $AJPM+ $CHEQ + $FACT + $IVAN + $IVAP + $NCR+ $NDB ;
							$saldos = array(
								"ADEL"=>$ADEL,
								"AJNA"=>$AJNA,
								"AJNM"=>$AJNM,
								"AJPA"=>$AJPA,

								"AJPM"=>$AJPM,
								"CHEQ"=>$CHEQ,
								"FACT"=>$FACT,
								"IVAN"=>$IVAN,

								"IVAP"=>$IVAP,
								"NCR"=>$NCR,
								"NDB"=>$NDB,
								"saldo"=>$saldo
							);
							sqlsrv_free_stmt($result);
							return $saldos;


	}
	public function getvencimiento($desde,$hasta,$co_cliente){
		$conn = conectarSQlSERVER();

		$hoy = date("Y-m-d");
		$sel_saldo ="
		SELECT
	          DC.nro_doc,
	           DC.co_tipo_doc,
	          DC.co_ven,
	           DC.co_cli,
	          DC.anulado, 
	          DC.otros1,
	          DC.otros2,
	          DC.otros3, 
						DC.total_neto / ( CASE WHEN NULL IS NULL THEN 1
	                                ELSE DC.tasa
	                           END ) * ( CASE WHEN DC.anulado = 1 THEN 0
	                                          ELSE 1
	                                     END ) AS total_neto,
	          DC.saldo / ( CASE WHEN NULL IS NULL THEN 1
	                ELSE DC.tasa
	           END ) * ( CASE WHEN DC.anulado = 1 THEN 0
	                          ELSE 1
	                     END ) AS saldo,
	          DC.tasa,
	          DC.total_bruto,
	          DC.monto_imp,
						P.cli_des,
						P.co_seg,
	          DC.nro_doc,
	          DC.nro_orig,
	          TP.tipo_mov,
	          TP.descrip,
						DC.fec_emis,
						DC.fec_venc,
						P.cli_des as prov_des,
						P.co_cli as co_prov,
						DATEDIFF(DAY, DC.fec_emis, DC.fec_venc) as diasEmisionVencimiento,
						DATEDIFF(DAY, GETDATE(), DC.fec_venc) as dias,
						ven.ven_des as vendedor,
						ZN.zon_des as zona

	        FROM
	            saDocumentoVenta AS DC
	            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
	            INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
	            INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
	            LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
							where saldo > 0
							";
							if(!empty($hasta)){
							 $sel_saldo.=" and DC.fec_venc between '".$desde."' and '".$hasta."' ";

						 }
							if(!empty($co_cliente)){
							 $sel_saldo.=" and P.co_cli='".$co_cliente."' ";

						 }
				$sel_saldo.=" ORDER BY
						 DC.co_tipo_doc";
			$pedidos = $this->listaPedidosBasico(null,$desde,$hasta);
			  /* FACTURAS QUE ES ESTAN CON FECHA DE RECEPCION */
	        for ($i=0; $i < count($pedidos) ; $i++) { 
	           $nfacturas[] = (int)$pedidos[$i]['factura'];
	        }

			$i=0;
			$res_array = array();
			$result=sqlsrv_query($conn,$sel_saldo);

			while($row=sqlsrv_fetch_array($result)){

				$idRegistroFacura = "";   
				$f = trim($row['nro_doc']);
				$f = (int)$f;
				
				$idRegistroFacura = array_search($f,$nfacturas);   
				$f_r = "";
				$fecha_vencimiento = "";
				$diferencia = "N";
				$recibido = "N";
				 if (!empty($idRegistroFacura)) {
					$cneg = $row['diasEmisionVencimiento'];
	             	$facturaRecibido = $pedidos[$idRegistroFacura];      

	             	$fec_recibido = "";

	              	if ($facturaRecibido['fecha_recibido']) {	
						$recibido = $facturaRecibido['fecha_recibido'];
	              		$fec_recibido = date_create($facturaRecibido['fecha_recibido']);
		              	date_add($fec_recibido, date_interval_create_from_date_string($cneg.' days'));
		             	$fecha_vencimiento =  date_format($fec_recibido, 'Y-m-d');

		             	$fecha1 = new DateTime($fecha_vencimiento);
		             	$hoy = new DateTime(date("Y-m-d"));
	                
	                   	
	                   	$fecha = $fecha1->diff($hoy);
	                    $diferencia = $fecha->format('%a');  

	                    if ($fecha1 < $hoy) {
	                      $diferencia = $diferencia *-1;
	                    }
	              	};
	                        
	           }

				$cond = $this->getCondicion($row['nro_doc']);

				foreach($row as $key=>$value){
							$res_array[$i][$key]=$value;
							$res_array[$i]['condicion'] = $cond;
							$res_array[$i]['fecha_vencimiento'] = $fecha_vencimiento;
							$res_array[$i]['diferencia']=$diferencia;
							$res_array[$i]['recibido']=$recibido;
					}
					$i++;
				}
			sqlsrv_free_stmt($result);
			//var_dump($result);
			return($res_array);
		}
    /* LISTA BASICA DE FACTURAS CON FECHA DE DESPACHO Y RECIBIDO */
    public function listaPedidosBasico($co_ven,$finicio,$ffinal) {
        $sel ="SELECT DATEDIFF(fec_venc , fec_emis) AS cneg,

         pedidos_des.* FROM `pedidos_des`
        WHERE factura IS NOT NULL ";

         $conn =  conectarServ(1);
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
         $pedidos  = array();
         $i=0;
            while($row=mysqli_fetch_array($rs)) {          
            foreach($row as $key=>$value) {              
                    $pedidos[$i][$key]=$value;
                 
            }
            $i++;
        }
        return $pedidos;
    }
	public function facturatotales($idcliente,$estatus){ //estatus de la factura

		$ar= "";
		for($x=0;$x < count($estatus); $x++){
			$ar.="'".$estatus[$x]."',";

		}
		$ar = substr($ar, 0, -1);

		$conn = conectarSQlSERVER();
		$sel ="select  sum(total_neto) as neto, sum(total_bruto) as bruto,
				sum(monto_imp) as impuesto
				 from saFacturaVenta
				 where co_cli='".$idcliente."' and status IN(".$ar.")
				 group by co_cli";

		$result=sqlsrv_query($conn,$sel);
		$rs = sqlsrv_fetch_object($result);

		$montos = array(
			"neto"=>0,
			"bruto"=>0,
			"impuesto"=>0
		);

		if($rs){
			$montos = array(
				"neto"=>$rs->neto,
				"bruto"=>$rs->bruto,
				"impuesto"=>$rs->impuesto
			);

		}
		return $montos;
	}
	public function chequesDevueltos($idcliente,$num_doc){

		$conn = conectarSQlSERVER();
		$sel ="select  sum(mont_doc) as mont_doc from saChequeDevueltoVenta
				 where co_cli='".$idcliente."'";

		if($num_doc!=null){
			$sel.=" and mont_doc=".$mont_doc."";

		}

		$sel.="group by co_cli";

		$result=sqlsrv_query($conn,$sel);
		$rs = sqlsrv_fetch_object($result);
			$montos = array(
				"num_doc"=>null,
				"mont_doc"=>0
			);

		if($rs){
			$montos = array(
				"num_doc"=>$num_doc,
				"mont_doc"=>$rs->mont_doc
			);

		}

		return $montos;
	}
	public function saldofatura($num_doc){

		$conn = conectarSQlSERVER();
		$sel ="select
					DV.saldo
					from
						saDocumentoVenta as DV
						where DV.nro_doc='".$num_doc."'";

		$result=sqlsrv_query($conn,$sel);
		$rs = sqlsrv_fetch_object($result);

		$montos = array(
			"num_doc"=>null,
			"saldo"=>0
		);

		if($rs){
			$montos = array(
				"num_doc"=>$num_doc,
				"saldo"=>$rs->saldo
			);
		}

		return $montos;
	}
	public function getvencimientoCliente($idcliente){
			$conn = conectarSQlSERVER();

			$sel ="
			SELECT
			        DC.nro_doc, DC.co_tipo_doc,
			        DC.co_ven, DC.co_cli,
			        DC.anulado, DC.otros1,
			        DC.otros2,
			        DC.otros3, DC.total_neto / ( CASE WHEN NULL IS NULL THEN 1
			                              ELSE DC.tasa
			                         END ) * ( CASE WHEN DC.anulado = 1 THEN 0
			                                        ELSE 1
			                                   END ) AS total_neto,
			        DC.saldo / ( CASE WHEN NULL IS NULL THEN 1
			              ELSE DC.tasa
			         END ) * ( CASE WHEN DC.anulado = 1 THEN 0
			                        ELSE 1
			                   END ) AS saldo,
			        DC.tasa,
			        DC.total_bruto,
			        DC.monto_imp,
			        DC.nro_doc,
			         P.cli_des,
			        TP.descrip,
			        TP.tipo_mov,
							DC.fec_emis,
							DC.fec_venc,
							DATEDIFF(DAY, DC.fec_emis, DC.fec_venc) as diasEmisionVencimiento,
							DATEDIFF(DAY, GETDATE(), DC.fec_venc) as dias

			      FROM
			          saDocumentoVenta AS DC
			          INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
			          LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
			          where DC.co_cli='".$idcliente."'
			      ORDER BY
			          DC.co_tipo_doc";
					/* 0979002  0101055*/

			$res_array=array();
			$i=0;
			$result=sqlsrv_query($conn,$sel);
			while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;
				}
				$i++;
			}
			return($res_array);
		}
	public function getCobroDocReng($nro_doc){
		$conn = conectarSQlSERVER();

		$sel ="select count(nro_doc) as cantidad
		from saCobroDocReng  where nro_doc='".$nro_doc."'";
		$result=sqlsrv_query($conn,$sel);
		$row=sqlsrv_fetch_array($result);

		$cant = $row[0];
		return($cant);
	}
	public function getCobroDocFactura($nro_doc){
			$conn = conectarSQlSERVER();

			$sel ="select
					CLI.cli_des,
					FV.doc_num,
					FV.co_cli,
					FV.descrip,
					FV.fec_emis,
					FV.fec_venc,
					CD.mont_cob,
					CD.monto_retencion_iva,
					TD.descrip  as tipodoc,
					DATEDIFF(DAY, GETDATE(), FV.fec_venc) as dias
				 from
				saCobroDocReng AS CD
				INNER JOIN saFacturaVenta as FV ON FV.doc_num = CD.nro_doc
				INNER JOIN saCliente  as CLI ON FV.co_cli = CLI.co_cli
				INNER JOIN saTipoDocumento  as TD ON TD.co_tipo_doc = CD.co_tipo_doc
				where CD.nro_doc = '".$nro_doc."'";

			$i=0;
			$res_array = array();

			$result=sqlsrv_query($conn,$sel);
			while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;
				}
				$i++;
			}
			return($res_array);
		}
	public function CobroFacturaTotal($nro_doc){
			$conn = conectarSQlSERVER();

			$sel ="select
					sum (CD.mont_cob) as monto
				from
				saCobroDocReng AS CD
				INNER JOIN saFacturaVenta as FV ON FV.doc_num = CD.nro_doc
				INNER JOIN saCliente  as CLI ON FV.co_cli = CLI.co_cli
				INNER JOIN saTipoDocumento  as TD ON TD.co_tipo_doc = CD.co_tipo_doc
				where CD.nro_doc = '".$nro_doc."'";

			$i=0;
			$monto = 0;

			$result=sqlsrv_query($conn,$sel);
			$row=sqlsrv_fetch_array($result);
			$monto = $row[0];

			return($monto);
		}

	public function getDetallefactura($nro_doc){
			$conn = conectarSQlSERVER();

			$sel ="select
					CLI.cli_des,
					FV.doc_num,
					FV.co_cli,
					FV.descrip,
					FV.fec_emis,
					FV.fec_venc,
					FV.total_bruto,
					FV.monto_imp,
					FV.total_neto,
					CP.cond_des,
					VEN.ven_des,
					VEN.co_ven,
					VEN.telefonos,
					VEN.direc1,

					DATEDIFF(DAY, GETDATE(), FV.fec_venc) as dias
				 from
				saFacturaVenta AS FV
				INNER JOIN saCliente AS CLI ON CLI.co_cli = FV.co_cli
				INNER JOIN saVendedor  AS VEN ON VEN.co_ven = FV.co_ven
				INNER JOIN saCondicionPago  AS CP ON CP.co_cond = FV.co_cond
				where FV.doc_num = '".$nro_doc."'";
			//echo $sel;
			$result=sqlsrv_query($conn,$sel);
			$row=sqlsrv_fetch_object($result);

			return($row);
		}
	public function fechaNormalizada($fecha){

		$fechaTiempo = array(
			"fecha"=>"No Aplica",
			"hora"=>""
		);
		if($fecha!='0'){
			$partes = explode(" ",$fecha);
			$meses = array("",
			"Ene","Feb","Mar","Abr",
			"May","Jun","Jul","Ago",
			"Sep","Oct","Nov","Dic");

			$fechas = explode("-",$partes[0]);
			$mes= intval($fechas[1]);
			$nuevaFecha = $fechas[2]." ".$meses[$mes]." ".$fechas[0];
			$tiempo =  explode(":",$partes[1]);
			$horario = " AM";
			$hora = $tiempo[0];

			if($tiempo[0] > 12){
				$horario = " PM";
				$hora = $tiempo[0] - 12;
			}
			$nuevaHora = $hora.":".$tiempo[1].":".$tiempo[2]."".$horario;

			$fechaTiempo = array(
				"fecha"=>$nuevaFecha,
				"hora"=>$nuevaHora
			);
		}
		return $fechaTiempo;
	}
	public function cobro($co_cli,$co_tipo_doc,$nro_doc){
		$conn = conectarSQlSERVER();

		$sel="select sum(CD.mont_cob) as mont_cob
				from saCobro as CB
				INNER JOIN saCobroDocReng AS CD ON CB.cob_num = CD.cob_num
				where CB.co_cli='".$co_cli."' ";

		if($co_tipo_doc != null){
			$sel.="and CD.co_tipo_doc='".$co_tipo_doc."' ";
		}

		if($nro_doc != null){
			$sel.="and CD.nro_doc='".$nro_doc."' ";
		}

		$sel.="group by CB.co_cli ";

		$i=0;

		$res_array = array();
		$result=sqlsrv_query($conn,$sel);
		$linea= sqlsrv_fetch_array($result);

		return $linea;
	}
	public function fechaNormal($fecha){

		$fechaTiempo = array(
			"fecha"=>"No Aplica",
			"hora"=>""
		);

		if($fecha!='0'){
			$partes = explode(" ",$fecha);


			$fechas = explode("-",$partes[0]);

			$mes= intval($fechas[1]);
			$nuevaFecha = $fechas[2]."/".$fechas[1]."/".$fechas[0];

			$tiempo =  explode(":",$partes[1]);

			$horario = " AM";
			$hora = $tiempo[0];

			if($tiempo[0] > 12){
				$horario = " PM";
				$hora = $tiempo[0] - 12;
			}
			$nuevaHora = $hora.":".$tiempo[1].":".$tiempo[2]."".$horario;

			$fechaTiempo = array(
				"fecha"=>$nuevaFecha,
				"hora"=>$nuevaHora
			);
		}
		return $fechaTiempo;
	}
	/* vuelve fecha de despacho y recibo */
	public function fechaDespachoRecibo($co_fac){
		  $conn = conectarServ(1);
		$sel="
		SELECT * FROM `pedidos_des`
			WHERE `factura`='".$co_fac."'";
			$rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
			$datos = mysqli_fetch_array($rs);

			return $datos;
	}
	/* vuelve fecha de despacho y recibo vencimiento */
	public function DespachoRecibo($co_fac){
		  $conn = conectarServ(1);
		$sel="
		SELECT fecha_despacho,fecha_recibido FROM `pedidos_des`
			WHERE `factura`='".$co_fac."'";


			$res_array = array(
				'fecha_despacho'=>0,
				'fecha_recibido'=>0
			);

			$result = mysqli_query($conn,$sel) or die(mysqli_error($conn));
			$row=mysqli_fetch_array($result);

			$res_array = array(
				'fecha_despacho'=>$row[0],
				'fecha_recibido'=>$row[1]
			);

			return $res_array;
	}
	/* vuelve fecha de despacho y recibo para vencimiento*/
	function saldoCliente($cliente){
		$ini = $this->getinicioAnio();
		$conn = conectarSQlSERVER();
		$sel="SELECT * FROM(
		select top 100
			DV.co_tipo_doc as tipo,
			TD.descrip as tipoNombre,
			DV.nro_doc as documento,
			DV.co_cli as coCliente,

			DV.fec_reg as fecha,
			DV.total_neto as monto2,
			'debe' as n
		from saDocumentoVenta as DV
		INNER JOIN saCliente   AS CLI ON DV.co_cli = CLI.co_cli
		INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = DV.co_tipo_doc
		where DV.co_cli='".$cliente."' and  DV.fec_emis > '".$ini."'

	) t1
	UNION
	SELECT * FROM(
		select top 100
			CD.co_tipo_doc as tipo,
			TD.descrip as tipoNombre,
			CD.nro_doc as documento,
			CB.co_cli as coCliente,

			CB.fe_us_in as fecha,
			CD.mont_cob as monto2,
			'haber' as n
		from saCobro as CB
		INNER JOIN saCobroDocReng   AS CD ON CD.cob_num = CB.cob_num
		INNER JOIN saCliente AS CLI ON CB.co_cli = CLI.co_cli
		INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = CD.co_tipo_doc
		where CB.co_cli='".$cliente."' and  CD.fe_us_in > '".$ini."'

		order by CD.fe_us_in
	) t2
	";
	//echo $sel."<br>";
		$i=0;
		$debe = 0;
		$haber = 0;
		$res_array = array();
		$result=sqlsrv_query($conn,$sel);
		while($row=sqlsrv_fetch_array($result)){
			foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
			}
			$i++;
		}

		$lineas = count($res_array);

		for($i=0;$i < $lineas; $i++){
			if($res_array[$i]['n']=="debe"){
				if($res_array[$i]['tipo']=="N/CR"){
					$haber+=$res_array[$i]['monto2'];

				}else{
					$debe+=$res_array[$i]['monto2'];
				}
			}else{
				$haber+=$res_array[$i]['monto2'];

			}
		}
		$res_array =array(
			'debe'=>$debe,
			'haber'=>$haber,
			'saldo'=>$debe - $haber
		);
		return $res_array;
	}
	function habercliente($co_cli){
		$conn = conectarSQlSERVER();
		$monto = 0;
		$sel="select sum(cd.mont_cob) as monto from saCobroDocReng as cd
			 INNER JOIN saCobro  AS cb ON cd.cob_num = cb.cob_num
			where cb.co_cli='".$co_cli."'
			and cb.fe_us_in > '20170101'";


				$sel2="select sum(total_neto) as monto from saDocumentoVenta as cb
					where cb.co_cli='".$co_cli."' /* 0979002  0101055 1711015 1711023*/
					and cb.fe_us_in > '20170101'
					and cb.anulado = 0
					";
		$result=sqlsrv_query($conn,$sel);
		if($result){
			$row=sqlsrv_fetch_array($result);
			$monto = $row[0];
		}
		return $monto;


	}
	public function saldoUnaFactura($co_ven,$idfactura){

		$conn = conectarSQlSERVER();
		$sel="
		SELECT
				DC.nro_doc as factura,
				 DC.co_tipo_doc,
	DC.co_ven,
	 DC.co_cli,
	dbo.fechasimple(DC.fec_emis) as fec_emis,
	dbo.fechasimple(DC.fec_venc) as fec_venc,
	DC.anulado,
		DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
													ELSE DC.tasa
										 END ) * ( CASE WHEN DC.anulado = 1 THEN 0
																		ELSE 1
															 END ) AS total_neto,

				DC.saldo / ( CASE WHEN '' IS NULL THEN 1
											ELSE DC.tasa
								 END ) * ( CASE WHEN DC.anulado = 1 THEN 0
																ELSE 1
													 END ) AS saldo,
				DC.tasa,
				 DC.total_bruto,
				 P.cli_des,
				 TP.descrip,
				TP.tipo_mov,
				CP.dias_cred,
				FV.anulado,
				 CP.co_cond as cond,
				  CP.cond_des as condision,
					 dc.saldo AS saldo_tabla

		FROM
				saDocumentoVenta AS DC
				INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
				LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
				INNER JOIN saFacturaVenta AS FV ON FV.doc_num = DC.nro_doc
			 INNER JOIN saCondicionPago  AS CP ON CP.co_cond = FV.co_cond
		WHERE
			DC.nro_doc >= '".$idfactura."' AND  DC.nro_doc <= '".$idfactura."'

		ORDER BY
		DC.nro_doc";

		$result=sqlsrv_query($conn,$sel);
		$monto=0;
		$saldo = array();
		if($result){
			$row=sqlsrv_fetch_array($result);
			$saldo = array(
				"co_cli"=> $row['co_cli'],
				"cli_des"=> $row['cli_des'],
				"factura"=> $row['factura'],
				"cond"=> $row['cond'],
				"condision"=> $row['condision'],
				"saldo_tabla"=> $row['saldo_tabla'],
				"saldo"=> $row['saldo'],
				"dias_cred"=> $row['dias_cred'],
				"anulado"=> $row['anulado']
			);
		}
		sqlsrv_free_stmt($result);
		return $saldo;
	}
	function habercliente2($co_cli){
		$conn = conectarSQlSERVER();
		$monto = 0;
		$sel2="select sum(cd.mont_cob) as monto from saCobroDocReng as cd
			 INNER JOIN saCobro  AS cb ON cd.cob_num = cb.cob_num
			where cb.co_cli='".$co_cli."'
			and cb.fe_us_in > '20170101'";


				$sel="	select sum(cd.mont_cob) as monto  from saCobroDocReng as cd
	 INNER JOIN saCobro  AS cb ON cd.cob_num = cb.cob_num
	where cb.co_cli='".$co_cli."' /* 0979002  0101055 1711015 1711023 6921005*/
	and cd.fe_us_in > '20170101'
	and cd.co_tipo_doc!='N/CR'
	and cb.anulado = 0";
		$result=sqlsrv_query($conn,$sel);
		if($result){
			$row=sqlsrv_fetch_array($result);
			$monto = $row[0];
		}
		return $monto;


	}
	function debecliente($co_cli){
		$conn = conectarSQlSERVER();

		$sel="select

			sum(
				CASE
				 WHEN doc_orig ='N/CR' THEN total_neto
				  ELSE 0
			   END

			) as ncr,
			sum(
				CASE
				 WHEN doc_orig ='COBRO' THEN total_neto
				  ELSE 0
			   END

			) as cobro,
			sum(
				CASE
				 WHEN doc_orig ='FACT' THEN total_neto
				  ELSE 0
			   END

			) as fact,
			sum(
				CASE
				 WHEN doc_orig ='DEVO' THEN total_neto
				  ELSE 0
			   END

			) as devo
			from
			saDocumentoVenta as DV
			where DV.co_cli='".$co_cli."' /* 0979002  0101055 1711015 1711023 */
			and DV.fe_us_in > '20170101'
			group by DV.co_cli";
		$result=sqlsrv_query($conn,$sel);

		$monto = array(
			"fact" => 0,
			"devo" => 0,
			"ncr" => 0,
			"cobro" => 0
		);

		if($result){
			$row=sqlsrv_fetch_array($result);

			$monto["fact"] = $row['fact'];
			$monto["devo"] = $row['devo'];
			$monto["ncr"] = $row['ncr'];
			$monto["cobro"] = $row['cobro'];


		}
		return $monto;


	}
	function clienteDocVenta($co_cli,$co_tipo_doc,$apartir){
		$conn = conectarSQlSERVER();
		$monto = 0;

		if(!$apartir){
			$apartir = $this->getinicioAnio();

		}

		$sel="
			select sum(total_neto) as monto from saDocumentoVenta
			where co_cli='".$co_cli."'
			and co_tipo_doc='".$co_tipo_doc."'
			and  fe_us_in > '".$apartir."'";



		$result=sqlsrv_query($conn,$sel);
		if($result){
			$row=sqlsrv_fetch_array($result);
			$monto = $row[0];
		}
		return $monto;

	}
	public function cobroFactura($nro_doc){
		$conn = conectarSQlSERVER();
		$sel="select
		DV.fe_us_in,
		DV.nro_doc,
		DV.total_bruto 	,
		DV.nro_orig,
		TD.descrip

			from saDocumentoVenta as DV
			INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = DV.co_tipo_doc
			where DV.nro_orig='".$nro_doc."' /* 0979002  0101055 1711015 1711023 6921005*/
			order by DV.fe_us_in
			";

		$i=0;
		$res_array = array();

		$result=sqlsrv_query($conn,$sel);
		while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;
				}
				$i++;
			}

		return($res_array);

	}
	public function documentosVentasTodos(){
		$conn = conectarSQlSERVER();
		$sel="
SELECT * FROM(
				select top 100
					DV.co_tipo_doc as tipo,
					TD.descrip as tipoNombre,
					DV.nro_doc as documento,
					DV.co_cli as coCliente,
					CLI.cli_des as nombreCliente,
					DV.fec_reg as fecha,
					DV.total_bruto as monto,
					DV.total_neto as monto2,
					'venta' as n
				from saDocumentoVenta as DV
				INNER JOIN saCliente AS CLI ON DV.co_cli = CLI.co_cli
				INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = DV.co_tipo_doc
				where   DV.fec_emis > '20170101'
				 and DV.co_tipo_doc NOT IN('FACT')
			) t1
			UNION
			SELECT * FROM(
				select top 100
					CD.co_tipo_doc as tipo,
					TD.descrip as tipoNombre,
					CD.nro_doc as documento,
					CB.co_cli as coCliente,
					CLI.cli_des as nombreCliente,
					CB.fe_us_in as fecha,
					CD.mont_cob as monto,
					CD.mont_cob as monto2,
					'pago' as n
				from saCobro as CB
				INNER JOIN saCobroDocReng   AS CD ON CD.cob_num = CB.cob_num
				INNER JOIN saCliente AS CLI ON CB.co_cli = CLI.co_cli
				INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = CD.co_tipo_doc
				where CD.fe_us_in > '20170101'
				and CD.co_tipo_doc NOT IN('FACT')
				order by CD.fe_us_in
			) t2
			";

		$i=0;
		$res_array = array();

		$result=sqlsrv_query($conn,$sel);
		while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;
				}
				$i++;
			}

		return($res_array);
	}
	public function documentosVentas($Ncocliente){
		$conn = conectarSQlSERVER();
		$ini = $this->getinicioAnio();

		$sel="SELECT * FROM(
		select top 100
			DV.co_tipo_doc as tipo,
			TD.descrip as tipoNombre,
			DV.nro_doc as documento,
			DV.co_cli as coCliente,

			DV.fec_reg as fecha,
			DV.total_neto as monto2,
			'debe' as n, DV.doc_orig as origen
		from saDocumentoVenta as DV
		INNER JOIN saCliente   AS CLI ON DV.co_cli = CLI.co_cli
		INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = DV.co_tipo_doc
		where DV.co_cli='".$Ncocliente."' and  DV.fec_emis > '".$ini."'

	) t1
	UNION
	SELECT * FROM(
		select top 100
			CD.co_tipo_doc as tipo,
			TD.descrip as tipoNombre,
			CD.nro_doc as documento,
			CB.co_cli as coCliente,

			CB.fe_us_in as fecha,
			CD.mont_cob as monto2,
			'haber' as n, CD.nro_doc  as origen
		from saCobro as CB
		INNER JOIN saCobroDocReng   AS CD ON CD.cob_num = CB.cob_num
		INNER JOIN saCliente AS CLI ON CB.co_cli = CLI.co_cli
		INNER JOIN saTipoDocumento  AS TD ON TD.co_tipo_doc = CD.co_tipo_doc
		where CB.co_cli='".$Ncocliente."' and  CD.fe_us_in > '".$ini."'

		order by CD.fe_us_in
	) t2

	ORDER BY t1.fecha, t1.tipo
	";
//echo $sel;
		$i=0;
		$res_array = array();

		$result=sqlsrv_query($conn,$sel);
		while($row=sqlsrv_fetch_array($result)){
				foreach($row as $key=>$value){
					$res_array[$i][$key]=$value;
				}
				$i++;
			}

		return($res_array);
	}
	public function getCobrosFactura($co_fac){
		/* ID de los cobros relacionados a la factura */
		$nco_fac = "";
		for($x=0;$x < count($co_fac); $x++){
			$nco_fac.="'".$co_fac[$x]."',";

		}
		$nco_fac = substr($nco_fac, 0, -1);
		$datos = array();

		$sel ="
		SELECT
				*
		FROM
				( SELECT
						P.cob_num,
						CASE WHEN ( TP.tipo_mov = 'CR'
												 AND DC.co_tipo_doc = 'ADEL'
												 AND PD.mont_cob > 0.00
											 )OR ( TP.tipo_mov = 'CR'
															AND DC.co_tipo_doc <> 'ADEL'
														) THEN PD.mont_cob
														ELSE 0.00
											 END * case when p.anulado=1 then 0 else 1 end AS abono,
												CASE WHEN ( TP.tipo_mov = 'CR'
																		 AND DC.co_tipo_doc = 'ADEL'
																		 AND PD.mont_cob = 0
																	 ) THEN DC.total_neto
																	ELSE ( CASE WHEN ( TP.tipo_mov = 'DE'
																										 AND DC.co_tipo_doc <> 'ADEL'
																									 ) THEN PD.mont_cob
																							ELSE 0.00
																				 END )
											END * case when p.anulado=1 then 0 else 1 end AS cargo,
						DC.total_neto,
						 DC.nro_doc,
						 P.co_cli as co_cli,
						PV.cli_des as cli_des,
						 DC.co_tipo_doc,
						 '' AS forma_pag,
							P.fecha,
							 NULL AS fecha_che,
								TP.tipo_mov,
						'P' AS TPAGO,
						 DC.doc_orig ,
						 p.anulado
					FROM
						saCobro AS P
						INNER JOIN saCobroDocReng AS PD ON P.cob_num = PD.cob_num
						INNER JOIN ( SELECT
														SUM(DC.total_neto) AS total_neto, DC.nro_doc, DC.co_tipo_doc, DC.co_cli, DC.doc_orig
												 FROM
														saDocumentoVenta AS DC
												 GROUP BY
														DC.co_cli, DC.co_tipo_doc, DC.nro_doc, DC.doc_orig
											 ) AS DC ON DC.nro_doc = PD.nro_doc
																	AND DC.co_tipo_doc = PD.co_tipo_doc
						INNER JOIN sacliente AS PV ON PV.co_cli = DC.co_cli
						INNER JOIN saTipoDocumento AS TP ON PD.co_tipo_doc = TP.co_tipo_doc
					UNION ALL
					SELECT
						P.cob_num, PT.mont_doc * case when p.anulado=1 then 0 else 1 end AS abono, 0.00 AS cargo, 0.00 AS total_neto, PT.num_doc AS nro_doc, P.co_cli as co_cli,
						PV.cli_des as cli_des, PT.forma_pag AS co_tipo_doc, PT.forma_pag, P.fecha, PT.fecha_che, '' AS tipo_mov,
						'N' AS TPAGO, '' AS doc_orig, P.anulado
					FROM
						saCobro AS P
						INNER JOIN saCobroTPReng AS PT ON ( PT.cob_num = P.cob_num )
						INNER JOIN saCliente AS PV ON PV.co_cli = p.co_cli

					) a
					where nro_doc in(".$nco_fac.")
		ORDER BY
				A.co_cli, A.fecha, A.fecha_che, A.cob_num";

					$conn = conectarSQlSERVER();

					$ids = array();
					$result = sqlsrv_query($conn,$sel);

						while($row=sqlsrv_fetch_array($result)){
							$ids[] = trim(trim($row[0]));
						}
						sqlsrv_free_stmt($result);

					if (count($ids) > 0) {
						$todoId= "";
						for($x=0;$x < count($ids); $x++){
							$todoId.="'".$ids[$x]."',";
						}
						$todoId = substr($todoId, 0, -1);

					$sel="
					SELECT
	            *
	        FROM
	            ( SELECT
	                P.cob_num,
	                CASE WHEN ( TP.tipo_mov = 'CR'
	                             AND DC.co_tipo_doc = 'ADEL'
	                             AND PD.mont_cob > 0.00
	                           )OR ( TP.tipo_mov = 'CR'
	                                  AND DC.co_tipo_doc <> 'ADEL'
	                                ) THEN PD.mont_cob
	                                ELSE 0.00
	                           END * case when p.anulado=1 then 0 else 1 end AS abono,
	                            CASE WHEN ( TP.tipo_mov = 'CR'
	                                         AND DC.co_tipo_doc = 'ADEL'
	                                         AND PD.mont_cob = 0
	                                       ) THEN DC.total_neto
	                                      ELSE ( CASE WHEN ( TP.tipo_mov = 'DE'
	                                                         AND DC.co_tipo_doc <> 'ADEL'
	                                                       ) THEN PD.mont_cob
	                                                  ELSE 0.00
	                                             END )
	                          END * case when p.anulado=1 then 0 else 1 end AS cargo,
	                DC.total_neto,
	                 DC.nro_doc,
	                 P.co_cli as co_cli,
	                PV.cli_des as cli_des,
	                 DC.co_tipo_doc,
	                 '' AS forma_pag,
	                  P.fecha,
	                   NULL AS fecha_che,
	                    TP.descrip,
	                'P' AS TPAGO,
	                 DC.doc_orig ,
	                 p.anulado
	              FROM
	                saCobro AS P
	                INNER JOIN saCobroDocReng AS PD ON P.cob_num = PD.cob_num
	                INNER JOIN ( SELECT
	                                SUM(DC.total_neto) AS total_neto, DC.nro_doc, DC.co_tipo_doc, DC.co_cli, DC.doc_orig
	                             FROM
	                                saDocumentoVenta AS DC
	                             GROUP BY
	                                DC.co_cli, DC.co_tipo_doc, DC.nro_doc, DC.doc_orig
	                           ) AS DC ON DC.nro_doc = PD.nro_doc
	                                      AND DC.co_tipo_doc = PD.co_tipo_doc
	                INNER JOIN sacliente AS PV ON PV.co_cli = DC.co_cli
	                INNER JOIN saTipoDocumento AS TP ON PD.co_tipo_doc = TP.co_tipo_doc
	              WHERE
	                   P.cob_num in (".$todoId.")
										 and DC.co_tipo_doc != 'FACT'
	              UNION ALL
	              SELECT
	                P.cob_num, PT.mont_doc * case when p.anulado=1 then 0 else 1 end AS abono, 0.00 AS cargo, 0.00 AS total_neto, PT.num_doc AS nro_doc, P.co_cli as co_cli,
	                PV.cli_des as cli_des, PT.forma_pag AS co_tipo_doc, PT.forma_pag, P.fecha, PT.fecha_che, '' AS tipo_mov,
	                'N' AS TPAGO, '' AS doc_orig, P.anulado
	              FROM
	                saCobro AS P
	                INNER JOIN saCobroTPReng AS PT ON ( PT.cob_num = P.cob_num )
	                INNER JOIN saCliente AS PV ON PV.co_cli = p.co_cli
	              WHERE  P.cob_num in (".$todoId.")
	              ) a
								ORDER BY A.co_cli, A.fecha, A.fecha_che, A.cob_num";


					$rs=sqlsrv_query($conn,$sel);

					$i=0;

					while($row=sqlsrv_fetch_array($rs)){
						foreach($row as $key=>$value){
							$datos[$i][$key]=$value;
						}
						$i++;
					}
					sqlsrv_free_stmt($rs);
				}

					return $datos;
	}
	public function getProductos(){
		$conn = conectarSQlSERVER();
		$sel="select co_art, fecha_reg, art_des from saArticulo";

		$res_array = array();

		$result=sqlsrv_query($conn,$sel);
		while($row=sqlsrv_fetch_array($result)){
			$nombre = trim(utf8_encode($row[2]));
			//$res_array[] = trim($row[0])."->".$nombre;
			$res_array[] = trim($nombre."->".$row[0]);
		}
		//$res_array = json_encode($res_array);
		return($res_array);
	}
	public function facturaMenosCobros($doc_num){
		/* Cobros de una factura */
		$conn = conectarSQlSERVER();
		$sel_cobros="select CD.cob_num from saCobro as C
		     INNER join saCobroDocReng as CD ON C.cob_num = CD.cob_num
		     where CD.nro_doc='".$doc_num."'";

			$idcobros = "";
			$i=0;
			$result=sqlsrv_query($conn,$sel_cobros);
			 while($row=sqlsrv_fetch_array($result)){
				 	$idcobros.="'".$row[0]."',";

			}
			$idcobros = substr($idcobros, 0, -1);

			/* Cobros detallados de facturas */
			$sel = "SELECT *
			 FROM
			     ( SELECT
			         P.cob_num, CASE WHEN ( TP.tipo_mov = 'CR'
			                                AND DC.co_tipo_doc = 'ADEL'
			                                AND PD.mont_cob > 0.00
			                              )
			                              OR ( TP.tipo_mov = 'CR'
			                                   AND DC.co_tipo_doc <> 'ADEL'
			                                 ) THEN PD.mont_cob
			                         ELSE 0.00
			                    END * case when p.anulado=1 then 0 else 1 end AS abono, CASE WHEN ( TP.tipo_mov = 'CR'
			                                              AND DC.co_tipo_doc = 'ADEL'
			                                              AND PD.mont_cob = 0
			                                            ) THEN DC.total_neto
			                                       ELSE ( CASE WHEN ( TP.tipo_mov = 'DE'
			                                                          AND DC.co_tipo_doc <> 'ADEL'
			                                                        ) THEN PD.mont_cob
			                                                   ELSE 0.00
			                                              END )
			                                  END * case when p.anulado=1 then 0 else 1 end AS cargo, DC.total_neto, DC.nro_doc, P.co_cli as co_cli,
			         PV.cli_des as cli_des, DC.co_tipo_doc, '' AS forma_pag, P.fecha, NULL AS fecha_che, TP.tipo_mov,
			         'P' AS TPAGO, DC.doc_orig , p.anulado
			       FROM
			         saCobro AS P
			         INNER JOIN saCobroDocReng AS PD ON P.cob_num = PD.cob_num
			         INNER JOIN ( SELECT
			                         SUM(DC.total_neto) AS total_neto, DC.nro_doc, DC.co_tipo_doc, DC.co_cli, DC.doc_orig
			                      FROM
			                         saDocumentoVenta AS DC
			                      GROUP BY
			                         DC.co_cli, DC.co_tipo_doc, DC.nro_doc, DC.doc_orig
			                    ) AS DC ON DC.nro_doc = PD.nro_doc
			                               AND DC.co_tipo_doc = PD.co_tipo_doc
			         INNER JOIN sacliente AS PV ON PV.co_cli = DC.co_cli
			         INNER JOIN saTipoDocumento AS TP ON PD.co_tipo_doc = TP.co_tipo_doc
			       WHERE
			         P.co_cli ='0101055'

			       UNION ALL
			       SELECT
			         P.cob_num, PT.mont_doc * case when p.anulado=1 then 0 else 1 end AS abono, 0.00 AS cargo, 0.00 AS total_neto, PT.num_doc AS nro_doc, P.co_cli as co_cli,
			         PV.cli_des as cli_des, PT.forma_pag AS co_tipo_doc, PT.forma_pag, P.fecha, PT.fecha_che, '' AS tipo_mov,
			         'N' AS TPAGO, '' AS doc_orig, P.anulado
			       FROM
			         saCobro AS P
			         INNER JOIN saCobroTPReng AS PT ON ( PT.cob_num = P.cob_num )
			         INNER JOIN saCliente AS PV ON PV.co_cli = p.co_cli
			       WHERE
			        P.co_cli ='0101055'
			     ) a
			where A.cob_num IN(".$idcobros.")
			 ORDER BY      A.co_cli, A.fecha, A.fecha_che, A.cob_num";
			 	$res_array = array();
		 		$result=sqlsrv_query($conn,$sel);
				while($row=sqlsrv_fetch_array($result)){
						foreach($row as $key=>$value){
							$res_array[$i][$key]=$value;
						}
						$i++;
					}

	}
	public function cobrosCliente($co_cli){
		$sel="SELECT
		     *
		 FROM
		     ( SELECT
		         P.cob_num, CASE WHEN ( TP.tipo_mov = 'CR'
		                                AND DC.co_tipo_doc = 'ADEL'
		                                AND PD.mont_cob > 0.00
		                              )
		                              OR ( TP.tipo_mov = 'CR'
		                                   AND DC.co_tipo_doc <> 'ADEL'
		                                 ) THEN PD.mont_cob
		                         ELSE 0.00
		                    END * case when p.anulado=1 then 0 else 1 end AS abono, CASE WHEN ( TP.tipo_mov = 'CR'
		                                              AND DC.co_tipo_doc = 'ADEL'
		                                              AND PD.mont_cob = 0
		                                            ) THEN DC.total_neto
		                                       ELSE ( CASE WHEN ( TP.tipo_mov = 'DE'
		                                                          AND DC.co_tipo_doc <> 'ADEL'
		                                                        ) THEN PD.mont_cob
		                                                   ELSE 0.00
		                                              END )
		                                  END * case when p.anulado=1 then 0 else 1 end AS cargo, DC.total_neto, DC.nro_doc, P.co_cli as co_cli,
		         PV.cli_des as cli_des, DC.co_tipo_doc, '' AS forma_pag, P.fecha, NULL AS fecha_che, TP.tipo_mov,
		         'P' AS TPAGO, DC.doc_orig , p.anulado
		       FROM
		         saCobro AS P
		         INNER JOIN saCobroDocReng AS PD ON P.cob_num = PD.cob_num
		         INNER JOIN ( SELECT
		                         SUM(DC.total_neto) AS total_neto, DC.nro_doc, DC.co_tipo_doc, DC.co_cli, DC.doc_orig
		                      FROM
		                         saDocumentoVenta AS DC
		                      GROUP BY
		                         DC.co_cli, DC.co_tipo_doc, DC.nro_doc, DC.doc_orig
		                    ) AS DC ON DC.nro_doc = PD.nro_doc
		                               AND DC.co_tipo_doc = PD.co_tipo_doc
		         INNER JOIN sacliente AS PV ON PV.co_cli = DC.co_cli
		         INNER JOIN saTipoDocumento AS TP ON PD.co_tipo_doc = TP.co_tipo_doc
		       WHERE
		         P.co_cli ='".$co_cli."'
		       UNION ALL
		       SELECT
		         P.cob_num, PT.mont_doc * case when p.anulado=1 then 0 else 1 end AS abono, 0.00 AS cargo, 0.00 AS total_neto, PT.num_doc AS nro_doc, P.co_cli as co_cli,
		         PV.cli_des as cli_des, PT.forma_pag AS co_tipo_doc, PT.forma_pag, P.fecha, PT.fecha_che, '' AS tipo_mov,
		         'N' AS TPAGO, '' AS doc_orig, P.anulado
		       FROM
		         saCobro AS P
		         INNER JOIN saCobroTPReng AS PT ON ( PT.cob_num = P.cob_num )
		         INNER JOIN saCliente AS PV ON PV.co_cli = p.co_cli
		       WHERE
		        P.co_cli ='".$co_cli."'
		     ) a
		 ORDER BY
		     A.co_cli, A.fecha, A.fecha_che, A.cob_num";

}

}
?>
