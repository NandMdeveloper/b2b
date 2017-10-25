<?php
require_once("../lib/seg.php");
require_once("../lib/conecciones.php");
require_once ('PHPExcel.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

function get_ped_desp_G(){
	$conn = conectarServ();
    $sQuery="SELECT pedidos_des.*,vendedor.ven_des, (SELECT cli_des FROM clientes where clientes.co_cli=pedidos_des.co_cli) AS cli_des FROM pedidos_des INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven WHERE 1 = 1 ";
    //if($sup) {  $sQuery.=" AND pedidos_des.co_ven IN (SELECT usuario FROM usuario WHERE supervisor='$sup')";    }
    $sQuery.=" ORDER BY doc_num DESC";
    //if($desde) { $sQuery.=" AND pedidos_des.fec_emis>='$desde' AND pedidos_des.fec_emis<='$hasta'" }
    $result=mysqli_query($conn,$sQuery);
    //echo $sQuery;
    $i=0;
    while($row=mysqli_fetch_assoc($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
        }
        $i++;
    }
    return($res_array);
}

//$usuario=$_SESSION['usuario'];
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
//var_dump($arr_pedidos);

/*if($_POST["fecha_d"]){
	$desde=$_POST["fecha_d"];
}else{
	$desde="2016-01-01";
}
if($_POST["fecha_h"]){
	$hasta=$_POST["fecha_h"];
}else{
	$hasta="2017-12-31";
}*/
$arr_pedidos=get_ped_desp_G();
//$vencidos=$reporte->getvencimiento($desde,$hasta,null);

//$cantidad = count($arr_pedidos);

// Set document properties
$objPHPExcel->getProperties()->setCreator("B2BFC")
	->setLastModifiedBy("Edgar Pérez")
	->setTitle("Office 2007 XLSX ")
	->setSubject("Office 2007 XLSX ")
	->setDescription("Pedidos Pro-Acce")
	->setKeywords("office 2007 openxml php")
	->setCategory("Resultado");

	//titulos
$styleArray = array(
	'font' => array(
		'bold' => true,
		'size'  => 10,
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

	// titulos
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', "PEDIDO")
	->setCellValue('B2', "FACTURA")
	->setCellValue('C2', "VENDEDOR")
	->setCellValue('D2', "CLIENTE")
	->setCellValue('E2', "TOTAL NETO")
	->setCellValue('F2', "ESTATUS")
	->setCellValue('G2', "EMISION")
	->setCellValue('H2', "FACTURADO")
	->setCellValue('I2', "DESPACHADO")
	->setCellValue('J2', "RECIBIDO");

	//anchos de columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

$lineas = count($arr_pedidos);

for($i=0;$i<sizeof($arr_pedidos);$i++){
	$pos = 3 + $i;
	$fech = explode(" ",$arr_pedidos[$i]['fec_emis']);
	$st='';
	if($arr_pedidos[$i]['status']==1){
		$st='A FACTURAR';
	}elseif ($arr_pedidos[$i]['status']==2) {
		$st='FACTURADO';
	}elseif ($arr_pedidos[$i]['status']==3) {
		$st='DESPACHADO';
	}elseif ($arr_pedidos[$i]['status']==4) {
		$st='RECIBIDO';
	}elseif ($arr_pedidos[$i]['status']==5) {
		$st='ANULADO';
	}
	$fec_em=date_format(date_create($fech[0]), 'd/m/Y');
	$fec_factura='';
	$fec_despa='';
	$fec_recib='';
	if(!empty($arr_pedidos[$i]['fecha_facturado'])){
		$fec_factura=date_format(date_create($arr_pedidos[$i]['fecha_aprobado']), 'd/m/Y');
	}
	if(!empty($arr_pedidos[$i]['fecha_despacho'])){
		$fec_despa=date_format(date_create($arr_pedidos[$i]['fecha_despacho']), 'd/m/Y');
	}
	if(!empty($arr_pedidos[$i]['fecha_recibido'])){
		$fec_recib=date_format(date_create($arr_pedidos[$i]['fecha_recibido']), 'd/m/Y');
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos, $arr_pedidos[$i]['doc_num'])
		->setCellValue('B'.$pos, $arr_pedidos[$i]['factura'])
		->setCellValue('C'.$pos, utf8_encode($arr_pedidos[$i]['ven_des']))
		->setCellValue('D'.$pos, utf8_encode($arr_pedidos[$i]['cli_des']))
		->setCellValue('E'.$pos, $arr_pedidos[$i]['total_neto'])
		->setCellValue('F'.$pos, $st)
		->setCellValue('G'.$pos, $fec_em)
		->setCellValue('H'.$pos, $fec_factura)
		->setCellValue('I'.$pos, $fec_despa)
		->setCellValue('J'.$pos, $fec_recib);
}

$lasuma = $lineas-1;

$objPHPExcel->getActiveSheet()->getStyle('E3:E'.$lasuma)->getNumberFormat()->setFormatCode('#,##0.00');

//filtrado de informacion
$objPHPExcel->getActiveSheet()->setAutoFilter('A2:J'.$lineas);
$objPHPExcel->getActiveSheet()->freezePane( 'A3');

// Nombre la hoja de calculo
$objPHPExcel->getActiveSheet()->setTitle('Pedidos Pro-Acce');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=PedidosProAcce.xlsx"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit();
?>
