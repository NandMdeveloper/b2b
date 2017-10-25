<?php
		/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		date_default_timezone_set('Europe/London');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		/** Include PHPExcel */
		require_once dirname(__FILE__) . '\PHPExcel.php';
		require_once('/lib/conecciones.php');
		//UPDATE `psdb`.`pedidos_des` SET `fecha_recibido` = '0000-00-00' WHERE `pedidos_des`.`fecha_recibido` = NULL;
		include("/lib/class/pedidos.class.php");


		$cliente= new class_pedidos;
		//echo $comision->porcentaje(200,5); exit();

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		/* INICIO - LLENADO DE DATOS */
		$desde="2016-01-01";
		$hasta="2017-12-31";
		$zona="";
		$co_ven="";

		if(isset($_GET['desde'])){
			$desde = $_GET['desde'];
		}
		if(isset($_GET['hasta'])){
			$hasta = $_GET['hasta'];
		}
		if(isset($_GET['co_ven'])){
			$co_ven = $_GET['co_ven'];
		}
		if(isset($_GET['zona'])){
			$zona = $_GET['zona'];
		}
		/* Pedidos con fecha de despacho en tabla despachos_des*/
		$mDatos = $cliente->get_ped_sql();



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
				'color' => array('rgb' => 'D55C19'),
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
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A2', "ID");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B2', "NETO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "CODIGO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "CLIENTE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "FECHA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "OBSERVACION");

		//anchos de columnas
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);

		$lineas = count($mDatos);
		for($i=0;$i < $lineas; $i++){
			//ingreso de datos
			$pos = 3 + $i;
		  $nfech =  date_format($mDatos[$i]['fec_emis'], 'd/m/Y');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $mDatos[$i]['doc_num']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos, utf8_encode($mDatos[$i]['total_neto']));
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pos, $mDatos[$i]['co_cli']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pos, utf8_encode($mDatos[$i]['cli_des']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, $nfech);	

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, utf8_encode($mDatos[$i]['descrip']));
		
		}
	//filtrado de informacion
	$objPHPExcel->getActiveSheet()->setAutoFilter('A2:F'.$lineas);
	$objPHPExcel->getActiveSheet()->freezePane( 'A3');

	$lasuma = $lineas - 1;
	$suma = $lineas + 3;
	$hasta = $suma - 1;

	$objPHPExcel->getActiveSheet()->getStyle('B3:B'.$suma)->getNumberFormat()->setFormatCode('#,##0.00');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'B'.$suma,
			'=SUM(B3:B'.$hasta.')'
		);



		$objPHPExcel->getActiveSheet()
        ->getStyle('B3:B'.$hasta)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('B'.$suma.':B'.$suma)->applyFromArray($estilofactura);
	// Nombre la hoja de calculo
	$nombre =  $desde." a ".$hasta;
	$objPHPExcel->getActiveSheet()->setTitle($nombre);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Por aprobacion  Pro-ACCE.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Fri, 17 Mar 2017 08:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	ob_end_clean();
	$objWriter->save('php://output');
	exit;
?>
