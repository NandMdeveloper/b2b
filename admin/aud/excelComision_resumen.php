<?php
		/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		date_default_timezone_set('Europe/London');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		/** Include PHPExcel */
		require_once dirname(__FILE__) . '\PHPExcel.php';
		require_once('../lib/conecciones.php');
		//UPDATE `psdb`.`pedidos_des` SET `fecha_recibido` = '0000-00-00' WHERE `pedidos_des`.`fecha_recibido` = NULL;
		include("../lib/class/reporte.class.php");
			include("../lib/class/comision.class.php");

		$comision= new comision;
		$reporte= new reporte;
		//echo $comision->porcentaje(200,5); exit();

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		/* INICIO - LLENADO DE DATOS */
		$desde="2016-01-01";
		$hasta="2017-12-31";

		if(isset($_GET['desde'])){
			$desde = $_GET['desde'];
		}
		if(isset($_GET['hasta'])){
			$hasta = $_GET['hasta'];
		}
		/* Pedidos con fecha de despacho en tabla despachos_des*/
		$mDatos = $comision->listadoFacturaComisionSaldoBasico2($desde,$hasta);
		$documentos = array();

		for ($i=0; $i < count($mDatos) ; $i++) { 
			if ((trim($mDatos[$i]['co_tipo_doc'])=='FACT' or trim($mDatos[$i]['co_tipo_doc'])=='N/CR' or trim($mDatos[$i]['co_tipo_doc'])=='N/DB') and $mDatos[$i]['comision'] != 0 ) {
				$nro_orig = str_pad($mDatos[$i]['nro_orig'],  6, "0", STR_PAD_LEFT); 
				$documentos[]  = array(
					'nro_orig' => $nro_orig,
					'co_tipo_doc' => $mDatos[$i]['co_tipo_doc'],
					'co_ven' => $mDatos[$i]['co_ven'],
					'vendedor' => utf8_encode($mDatos[$i]['vendedor']),
					'co_cli' => $mDatos[$i]['co_cli'],
					'cli_des' => utf8_encode($mDatos[$i]['cli_des']),
					'total_bruto' => $mDatos[$i]['total_bruto'],
					'monto_imp' =>  $mDatos[$i]['monto_imp'],
					'total_neto' =>  $mDatos[$i]['total_neto'],
					'comision' =>  $mDatos[$i]['comision'],
					'reserva' =>  $mDatos[$i]['reserva'],
					'porcentaje' =>  $mDatos[$i]['porcentaje']

					);

			}
		}

		$cantidad = count($mDatos);

		$objPHPExcel->getProperties()->setCreator("PowerSales")
						 ->setLastModifiedBy("Javier rodriguez")
						 ->setTitle("Office 2007 XLSX ")
						 ->setSubject("Office 2007 XLSX ")
						 ->setDescription("Comisiones modelo 1")
						 ->setKeywords("office 2007 openxml php")
						 ->setCategory("Resultado");


		$styleArray = array(
			'font' => array(
				'bold' => true,
				'size'  => 10,
			)
		);
		$estilofactura = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '3C8DBC'),
			)
		);
		$estiloHaber = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '4DA3D9'),
			)
		);
		$estiloDebe = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '585858'),
			)
		);

		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('k2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($styleArray);


		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Info");
		$objPHPExcel->getActiveSheet()->getComment('A1')->setAuthor('PowerSales '.$desde.' a '.$hasta);
		/*titulos
		 Número	Emisión 	Venc.	Desp	Recepc	Vcto	Cobro	C.Neg.
		 Días Calle	Cliente		Vend	Cond.Pag	Monto Base	I.V.A.	 Neto	Saldo
		 */
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A2', "NÚMERO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B2', "DOCUMENTO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('C2', "CO_VEN");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('D2', "VENDEDOR");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('E2', "CO_CLI");

		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('F2', "CLIENTE");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('G2', "BASE");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('H2', "IMPUESTO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('I2', "NETO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('J2', "COMISION");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('K2', "RESERVA");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('L2', "%");


		//anchos de columnas
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);

		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(55);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);


		$lineas = count($documentos);
		for($i=0;$i < $lineas; $i++){
			//ingreso de datos
			$pos = 3 + $i;
	

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $documentos[$i]['nro_orig']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos, $documentos[$i]['co_tipo_doc']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pos, $documentos[$i]['co_ven']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pos, $documentos[$i]['vendedor']);
	

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, (int)$documentos[$i]['co_cli']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, $documentos[$i]['cli_des']);

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pos, $documentos[$i]['total_bruto']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$pos, $documentos[$i]['monto_imp']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$pos, $documentos[$i]['total_neto']);
			
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$pos, $documentos[$i]['comision']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$pos, $documentos[$i]['reserva']);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$pos, $documentos[$i]['porcentaje']);
			
		}
	//filtrado de informacion
	$objPHPExcel->getActiveSheet()->setAutoFilter('A2:L'.$lineas);
	$objPHPExcel->getActiveSheet()->freezePane( 'A3');

	$lasuma = $lineas - 1;
	$suma = $lineas + 3;
	$hasta = $suma - 1;

	$objPHPExcel->getActiveSheet()->getStyle('G3:G'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('H3:H'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('I3:I'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('J3:J'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('K3:K'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'G'.$suma,
			'=SUM(G3:G'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'H'.$suma,
			'=SUM(H3:H'.$hasta.')'
		);	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'I'.$suma,
			'=SUM(I3:I'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'J'.$suma,
			'=SUM(J3:J'.$hasta.')'
		);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'K'.$suma,
			'=SUM(K3:K'.$hasta.')'
		);


/* ALINEAMIENTO FORZADO DE COLUMNAS*/
$objPHPExcel->getActiveSheet()
        ->getStyle('A3:A'.$hasta)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
$objPHPExcel->getActiveSheet()
        ->getStyle('E3:E'.$hasta)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);    


	//#.##0,00
	$objPHPExcel->getActiveSheet()->getStyle('G'.$suma.':K'.$suma)->applyFromArray($estilofactura);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$suma.':K'.$suma)->getNumberFormat()->setFormatCode('#,##0.00');
	// Nombre la hoja de calculo
	$nombre =  $desde." a ".$hasta;
	$objPHPExcel->getActiveSheet()->setTitle($nombre);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Comisiones Pro Home-resumen.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Fri, 17 Mar 2017 08:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
