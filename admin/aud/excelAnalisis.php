<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	require_once dirname(__FILE__) . '\PHPExcel.php';
	require_once('../lib/conecciones.php');
	include("../lib/class/reporte.class.php");

	$reporte= new reporte;//LLAMADO A LA CLASE DE PEDIDOS
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	$desde="2016-01-01";
	$hasta="2017-12-31";

	if(isset($_GET['desde'])){
		$desde = $_GET['desde'];
	}
	if(isset($_GET['hasta'])){
		$hasta = $_GET['hasta'];
	}
	$vencidos=$reporte->getvencimiento($desde,$hasta,null);

	$cantidad = count($vencidos);

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("PowerSales")
					 ->setLastModifiedBy("Javier Rodriguez")
					 ->setTitle("Office 2007 XLSX ")
					 ->setSubject("Office 2007 XLSX ")
					 ->setDescription("Analisis de Vencimiento PowerSales")
					 ->setKeywords("office 2007 openxml php")
					 ->setCategory("Resultado");

	//titulos
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


	// titulos
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A2', "COD VEN");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('B2', "VENDEDOR");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('C2', "ZONA");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('D2', "EMISIÓN");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "VENCIMIENTO");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "FECHA EMISION");


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "DESPACHO");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "RECIBIDO");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "VENCIMIENTO");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "FECHA RECEPCION");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "DIAS");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "CONDICION");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('K2', "Nro. DOCUMENTO");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('L2', "DOCUMENTO");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('M2', "SEGMENTO");
	$objPHPExcel->setActiveSheetIndex(0) ->setCellValue('N2', "COD CLI");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "CLIENTE");
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "BRUTO");
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "IVA");
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "NETO");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "VENCIDO >21");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "VENCIDO 15-21");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', "VENCIDO 8-14");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', "VENCIDO 7-1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', "VENCIDO HOY");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2', "A VENCER 1-7");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', "A VENCER 8-14");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W2', "A VENCER 15-21");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X2', "A VENCER >21");

	//anchos de columnas
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);

	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(19);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(32);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(70);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(17);
	//$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(17);


	$lineas = count($vencidos);
	$z = 0;
	for($i=0;$i < $lineas; $i++){

		$feEmision = $reporte->fechaNormal($vencidos[$i]['fec_emis']->format('Y-m-d H:i:s'));
		$feVencimiento = $reporte->fechaNormal($vencidos[$i]['fec_venc']->format('Y-m-d H:i:s'));

		//ingreso de datos
		$nsaldo = $vencidos[$i]['saldo'];

		$monto = $vencidos[$i]['total_neto'];
		$bruto = $vencidos[$i]['total_bruto'];
		$iva = $vencidos[$i]['monto_imp'];

		//$iva = $bruto * 0.12;

		$nrecibido="";
		if(trim($vencidos[$i]['co_tipo_doc']) == "ADEL" or trim($vencidos[$i]['co_tipo_doc']) == "AJNA"
		or trim($vencidos[$i]['co_tipo_doc']) == "N/CR" or trim($vencidos[$i]['co_tipo_doc']) == "AJNM"
		 or trim($vencidos[$i]['co_tipo_doc']) == "IVAN" or trim($vencidos[$i]['co_tipo_doc']) == "IVAP"
			or trim($vencidos[$i]['co_tipo_doc']) == "N/DB"){
				
				if(trim($vencidos[$i]['co_tipo_doc']) == "N/DB"){
					$nsaldo=$vencidos[$i]['saldo'];
				}else{
					$nsaldo = $vencidos[$i]['saldo'] * -1;
				}
				$bruto = $bruto * -1;
				$iva = $iva * -1;
				$monto = $monto * -1;
				$nrecibido = $feVencimiento['fecha'];

		}
		$pos = 3 + $i;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $vencidos[$i]['co_ven']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos, utf8_encode($vencidos[$i]['vendedor']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pos, $vencidos[$i]['zona']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pos, $feEmision['fecha']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, $feVencimiento['fecha']);

		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pos, $feVencimiento['fecha']);
		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, $feVencimiento['fecha']);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$pos, $vencidos[$i]['diasEmisionVencimiento']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$pos, $vencidos[$i]['condicion']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$pos, (int)$vencidos[$i]['nro_doc']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$pos, utf8_encode($vencidos[$i]['descrip']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$pos, (int)$vencidos[$i]['co_prov']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$pos,utf8_encode($vencidos[$i]['prov_des']) );
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$pos, $bruto);
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$pos, $iva);
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$pos, $monto);
		if ($vencidos[$i]['co_seg']==000004){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$pos,utf8_encode('CUENTAS CLAVES') );
		}elseif ($vencidos[$i]['co_seg']==000005){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$pos,utf8_encode('TRADICIONAL') );
		}
		// Vencidos
		if($vencidos[$i]['diferencia'] < 0 and $vencidos[$i]['diferencia'] !="N"){
			$neg=$vencidos[$i]['diferencia']*-1;
			if($neg>21){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$pos, $nsaldo);
			}elseif ($neg>14 && $neg<=21) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$pos, $nsaldo);
			}elseif ($neg>7 && $neg<=14) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$pos, $nsaldo);
			}elseif ($neg>0 && $neg<=7) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$pos, $nsaldo);
			}
		}elseif ($vencidos[$i]['diferencia'] == 0  and $vencidos[$i]['diferencia'] !="N") {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$pos, $nsaldo);
		}
		elseif ($vencidos[$i]['diferencia']>0 && $vencidos[$i]['diferencia']<=7 and $vencidos[$i]['diferencia'] !="N") {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$pos, $nsaldo);
		}elseif ($vencidos[$i]['diferencia']>7 && $vencidos[$i]['diferencia']<=14 and $vencidos[$i]['diferencia'] !="N") {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$pos, $nsaldo);
		}elseif ($vencidos[$i]['diferencia']>14 && $vencidos[$i]['diferencia']<=21 and $vencidos[$i]['diferencia'] !="N") {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$pos, $nsaldo);
		}elseif ($vencidos[$i]['diferencia']>21 or $vencidos[$i]['diferencia'] =="N") {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$pos, $nsaldo);
		}
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$pos, $vencidos[$i]['dias']);
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$pos, $nsaldo);

		////////////////////////////////////////
		$fdespacho = $reporte->DespachoRecibo(trim((int)$vencidos[$i]['nro_doc']));
		if($fdespacho['fecha_despacho'] != 0){
	
			$nfdespacho = $fdespacho['fecha_despacho']." 00:00:00";
			$fedespacho = $reporte->fechaNormal($nfdespacho);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pos, $fedespacho['fecha']);

			if($fdespacho['fecha_recibido'] != 0){
				$nfecha = $fdespacho['fecha_recibido']." 00:00:00";
				$nfrecibido = $reporte->fechaNormal($nfecha);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pos, $nfrecibido['fecha']);
			}
		}else{

			if (!empty($nrecibido)) { 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pos, $nrecibido);
			}
		}
		$fnVencimiento = "";
		if ($vencidos[$i]['fecha_vencimiento'] != 0) {
			# code...
				$fnVencimiento = date_format(date_create($vencidos[$i]['fecha_vencimiento']),'d/m/Y');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$pos, $fnVencimiento);
		}

				//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$pos, $vencidos[$i]['fecha_vencimiento']);
				//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$pos, $vencidos[$i]['diferencia']);


		/*$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				'N3',
				'=SUM(I3:K3)'
			);*/

	}


//filtrado de informacion
$objPHPExcel->getActiveSheet()->setAutoFilter('A2:X'.$lineas);
$objPHPExcel->getActiveSheet()->freezePane( 'A3');

$lasuma = $lineas-1;
$suma = $lineas+3;
$hasta = $suma - 1;

//$objPHPExcel->getActiveSheet()->getStyle('M3:M'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
//$objPHPExcel->getActiveSheet()->getStyle('N3:N'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('X3:X'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('P3:P'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('Q3:Q'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('R3:R'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('S3:S'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('T3:T'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('U3:U'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('V3:V'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('W3:W'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
//$objPHPExcel->getActiveSheet()->getStyle('X3:X'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
//$objPHPExcel->getActiveSheet()->getStyle('Y3:Y'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('I3:I'.$lasuma)->getNumberFormat()->setFormatCode('0');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'W'.$suma,
		'=SUM(W3:W'.$hasta.')'
	);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'P'.$suma,
		'=SUM(P3:P'.$hasta.')'
	);
/*$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'N'.$suma,
		'=SUM(N3:N'.$hasta.')'
	);*/
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
	); $objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'T'.$suma,
		'=SUM(T3:T'.$hasta.')'
	);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'U'.$suma,
		'=SUM(U3:U'.$hasta.')'
	);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'V'.$suma,
		'=SUM(V3:V'.$hasta.')'
	);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'X'.$suma,
		'=SUM(W3:X'.$hasta.')'
	);
/*$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'X'.$suma,
		'=SUM(X3:X'.$hasta.')'
	);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
		'Y'.$suma,
		'=SUM(Y3:Y'.$hasta.')'
	);*/
//#.##0,00
	//nEGRILLA DE LOS TITULOS
	$objPHPExcel->getActiveSheet()->getStyle('A1:X1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A2:X2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('O'.$suma.':W'.$suma)->applyFromArray($estilofactura);
$objPHPExcel->getActiveSheet()->getStyle('O'.$suma.':W'.$suma)->getNumberFormat()->setFormatCode('#,##0.00');
// Nombre la hoja de calculo
$objPHPExcel->getActiveSheet()->setTitle('Analisis vencimiento');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$hoyNombre = date('d-m-Y');
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="AnalisisVencimiento Pro-Acce '.$hoyNombre.'.xlsx"');
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