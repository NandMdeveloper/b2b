<?php
		/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
		date_default_timezone_set('America/Caracas');

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
		$mDatos = $comision->listadoFacturaComisionVentas($desde,$hasta);
		$cantidad = count($mDatos);
		//$comision->dump($mDatos); exit();
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

		$fec_desde = date_format(date_create($desde),'d/m/Y');
		$fec_hasta = date_format(date_create($hasta),'d/m/Y');


		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A1', "Calculos de ".$fec_desde." al ".$fec_hasta);

		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A2', "NÚMERO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B2', "TIPO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('C2', "EMISIÓN");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('D2', "DESPACHO");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('E2', "RECIBIDO");

		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('F2', "COVEN");

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "VENDEDOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "COD");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "CLIENTE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "SEGMENTO");

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "ZONA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "BASE");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "IMP");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "NETO");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "COMISION");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "PORCENTAJE");

		//anchos de columnas
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);

		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);

		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);


		$lineas = count($mDatos);
		for($i=0;$i < $lineas; $i++){
			//ingreso de datos
			$pos = 3 + $i;
			$nro_orig = str_pad(trim($mDatos[$i]['doc_num']),  6, "0", STR_PAD_LEFT); 

			$fec_emis = "";
			if (is_object($mDatos[$i]['fec_emis'])) {
				$fec_emis = date_format(date_create($mDatos[$i]['fec_emis']->format("Y-m-d")),'d/m/Y');
			}else{
				$fec_emis = date_format(date_create($mDatos[$i]['fec_emis']),'d/m/Y');

			}
 			

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $nro_orig);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos, $mDatos[$i]['tipodoc']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pos, $fec_emis);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pos, $mDatos[$i]['fecha_despacho']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, $mDatos[$i]['fecha_despacho']);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, $mDatos[$i]['covendedor']);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pos, utf8_encode($mDatos[$i]['ven_des']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$pos, $mDatos[$i]['co_cli']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$pos, utf8_encode($mDatos[$i]['cli_des']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$pos, $mDatos[$i]['seg_des']);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$pos, $mDatos[$i]['zon_des']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$pos, $mDatos[$i]['total_bruto']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$pos, $mDatos[$i]['monto_imp']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$pos, $mDatos[$i]['total_neto']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$pos, $mDatos[$i]['comision']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$pos, $mDatos[$i]['porcentaje']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$pos, $mDatos[$i]['factura']);

		}
	//filtrado de informacion
	$objPHPExcel->getActiveSheet()->setAutoFilter('A2:P'.$lineas);
	$objPHPExcel->getActiveSheet()->freezePane( 'A3');

	$lasuma = $lineas - 1;
	$suma = $lineas + 3;
	$hasta = $suma - 1;

	$objPHPExcel->getActiveSheet()->getStyle('O3:O'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('N3:N'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('L3:L'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('M3:M'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'L'.$suma,
			'=SUM(L3:L'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'M'.$suma,
			'=SUM(M3:M'.$hasta.')'
		);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'N'.$suma,
			'=SUM(N3:N'.$hasta.')'
		);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'O'.$suma,
			'=SUM(O3:O'.$hasta.')'
		);
/* ALINEAMIENTO FORZADO DE COLUMNAS*/
$objPHPExcel->getActiveSheet()
        ->getStyle('A3:A'.$hasta)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()
        ->getStyle('B3:B'.$hasta)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	//#.##0,00
	$objPHPExcel->getActiveSheet()->getStyle('L'.$suma.':O'.$suma)->applyFromArray($estilofactura);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estilofactura);
	$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$suma.':O'.$suma)->getNumberFormat()->setFormatCode('#,##0.00');
	// Nombre la hoja de calculo
	$objPHPExcel->getActiveSheet()->setTitle("Comisiones");

	// agregar otra hoja para paramtros usados ese mes
		
	$objPHPExcel->createSheet();
    $sheet = $objPHPExcel->setActiveSheetIndex(1);
    $sheet->setTitle("Parametros");
 	$sheet->setCellValue('A3', " Listado de parametros");
    $sheet = $objPHPExcel->setActiveSheetIndex(0);

    $impreso = date("j/m/Y  g:i a");
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Comisiones por Ventas Pro-Acce '.$impreso.'.xlsx"');
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
