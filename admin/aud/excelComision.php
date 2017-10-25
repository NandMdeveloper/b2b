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
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B2', "EMISIÓN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "VENCIMIENTO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "DESPACHO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "RECEPCIÓN");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('F2', "VCTO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('G2', "COBRO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "C.NEG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "DÍAS CALLE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "COD");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "CLIENTE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "VEND");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "COND.PAG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "MONTO BASE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "I.V.A.");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "NETO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "SALDO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', "COMISION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', "RESERVA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', "PORCENTAJE");

		//anchos de columnas
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);

		$lineas = count($mDatos);
		for($i=0;$i < $lineas; $i++){
			//ingreso de datos
			$pos = 3 + $i;
			$nro_orig = str_pad($mDatos[$i]['nro_orig'],  6, "0", STR_PAD_LEFT); 
			$dato = $mDatos[$i]['fVcto'];
			if(strlen($mDatos[$i]['fVcto'])==4 and !empty($mDatos[$i]['fVcto'])){
				$dato = str_pad($mDatos[$i]['fVcto'],  6, "0", STR_PAD_LEFT); 

			}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $nro_orig);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos, $mDatos[$i]['fec_emis']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pos, $mDatos[$i]['fec_venc']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pos, $mDatos[$i]['fecha_despacho']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, $mDatos[$i]['fecha_recibido']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, $dato );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pos, $mDatos[$i]['fcobro']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$pos, $mDatos[$i]['dias_cred']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$pos, $mDatos[$i]['diascalle']);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$pos, (int)$mDatos[$i]['co_cli']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$pos, utf8_encode($mDatos[$i]['cli_des']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$pos, $mDatos[$i]['co_ven']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$pos, $mDatos[$i]['cond']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$pos, $mDatos[$i]['total_bruto']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$pos, $mDatos[$i]['monto_imp']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$pos, $mDatos[$i]['total_neto']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$pos, $mDatos[$i]['saldo']);

		
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$pos, $mDatos[$i]['comision']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$pos, $mDatos[$i]['reserva']);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$pos, $mDatos[$i]['porcentaje']);
		}
	//filtrado de informacion
	$objPHPExcel->getActiveSheet()->setAutoFilter('A2:T'.$lineas);
	$objPHPExcel->getActiveSheet()->freezePane( 'A3');

	$lasuma = $lineas - 1;
	$suma = $lineas + 3;
	$hasta = $suma - 1;

	$objPHPExcel->getActiveSheet()->getStyle('N3:N'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('O3:O'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('P3:P'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('Q3:Q'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('R3:R'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('S3:S'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'N'.$suma,
			'=SUM(N3:N'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'O'.$suma,
			'=SUM(O3:O'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'P'.$suma,
			'=SUM(P3:P'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'Q'.$suma,
			'=SUM(Q3:Q'.$hasta.')'
		);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'R'.$suma,
			'=SUM(R3:R'.$hasta.')'
		);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'S'.$suma,
			'=SUM(S3:S'.$hasta.')'
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
$objPHPExcel->getActiveSheet()
        ->getStyle('F3:F'.$hasta)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);




	//#.##0,00
	$objPHPExcel->getActiveSheet()->getStyle('N'.$suma.':S'.$suma)->applyFromArray($estilofactura);
	$objPHPExcel->getActiveSheet()->getStyle('N'.$suma.':S'.$suma)->getNumberFormat()->setFormatCode('#,##0.00');
	// Nombre la hoja de calculo
	$nombre =  $desde." a ".$hasta;
	$objPHPExcel->getActiveSheet()->setTitle($nombre);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Comisiones-Pro Acce.xlsx"');
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
