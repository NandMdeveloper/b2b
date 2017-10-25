<?php
 ini_set('display_errors', '1');
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
		include("../lib/class/cliente.class.php");


		$cliente= new cliente;
		//echo $comision->porcentaje(200,5); exit();

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		/* INICIO - LLENADO DE DATOS */
		$desde="2017-01-01";
		$hasta="2017-12-31";
		$zona="";


		if(isset($_GET['desde'])){
			$desde = $_GET['desde'];
		}
		if(isset($_GET['hasta'])){
			$hasta = $_GET['hasta'];
		}

		if(isset($_GET['zona'])){
			$zona = $_GET['zona'];
		}
		/* Pedidos con fecha de despacho en tabla despachos_des*/
		$mDatos = $cliente->getClientescartera($zona,null,$hasta);



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



		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Info");
		$objPHPExcel->getActiveSheet()->getComment('A1')->setAuthor('PowerSales ');
		/*titulos
		 Número	Emisión 	Venc.	Desp	Recepc	Vcto	Cobro	C.Neg.
		 Días Calle	Cliente		Vend	Cond.Pag	Monto Base	I.V.A.	 Neto	Saldo
		 */
	

		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A2', "CO_VEN");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B2', "VENDEDOR");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "ZONA");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "CARTERA DE CLIENTES");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "CLIENTES NUEVOS");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('F2', "CLIENTES REGULARES");
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('G2', "ACTIVACION");

		//anchos de columnas
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(19);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);

		$lineas = count($mDatos);
		for($i=0;$i < $lineas; $i++){
			//ingreso de datos
			$pos = 3 + $i;       

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $mDatos[$i]['co_ven']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos, utf8_encode($mDatos[$i]['ven_des']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pos, utf8_encode($mDatos[$i]['zon_des']));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pos, $mDatos[$i]['clientes']);
	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, $mDatos[$i]['clientemes']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, $mDatos[$i]['carteraActiv']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pos, $mDatos[$i]['porc']);

		
		}
		$suma = $lineas + 3;
	$hasta = $suma - 1;

	//filtrado de informacion
	$objPHPExcel->getActiveSheet()->setAutoFilter('A2:G'.$lineas);
	$objPHPExcel->getActiveSheet()->freezePane( 'A3');
$objPHPExcel->getActiveSheet()->getStyle('G3:G'.$lineas)->getNumberFormat()->setFormatCode('#,##0.00');

	// Nombre la hoja de calculo
	$nombre =  $desde." a ".$hasta;
	$objPHPExcel->getActiveSheet()->setTitle($nombre);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="B2B - Cartera Cliente.xlsx"');
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
