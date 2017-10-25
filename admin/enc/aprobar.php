<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='2') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/log.class.php");
$obj_pedidos= new class_pedidos;
$obj_log= new class_log;
if($_POST){
	mysql_query('BEGIN');

	$id=$_POST["id"];
	$tipo_d=$_POST["tipo_d"];
	$tipo_p=$_POST["tipo_p"];
	$user=$_SESSION['usuario'];
	$fecha=date("Y-m-d H:i:s");

	$arr_pedidos=$obj_pedidos->get_pedidos_p($id);
	$arr_dp=$obj_pedidos->get_detalles_pedido($id);
	$arr_tipop=$obj_pedidos->get_tipoprecioart('',$tipo_d);

	$porcentaje=$arr_tipop[0]['porcentaje'];
	$co_precio=$arr_tipop[0]['co_precio'];
	$iva=12;
	$total_bg=0;
	$total_imp=0;
	$total_glob=0;

	for($i=0;$i<sizeof($arr_dp);$i++){
		$precio=$arr_dp[$i]['prec_vta'];
		$desc=($precio*$porcentaje)/100;
		$precio_new=$precio-$desc;
		$sub_total=$arr_dp[$i]['total_art']*$precio_new;
		$monto_imp=($sub_total*$iva)/100;
		$reng_neto=$sub_total+$monto_imp;
		$s="UPDATE pedidos_detalles SET co_precio='".$co_precio."', prec_vta=".$precio_new.", total_sub=".$sub_total.", monto_imp=".$monto_imp.", reng_neto=".$reng_neto." WHERE id=".$arr_dp[$i]['id'];
		$insert=@mysql_query($s);
		$total_bg+=$sub_total;
		$total_imp+=$monto_imp;
		$total_glob+=$reng_neto;
	}
	$a="UPDATE pedidos SET status=1, fecha_preap='".$fecha."', total_bruto=".$total_bg.", monto_imp=".$total_imp.", total_neto=".$total_glob.", co_cond='".$tipo_p."' WHERE doc_num=".$id;
	$insert2=@mysql_query($a);
	if($insert && $insert2){
		mysql_query('COMMIT');
		$obj_log->add_log($fecha, $user, "Coordinacion, preaprobacion del pedido Web #".$id." a Credito y Cobranzas");
		for($i=0;$i<sizeof($arr_dp);$i++){
    		$obj_log->add_log($fecha, $user, "Coordinacion, agrego el articulo ".$arr_dp[$i]['co_art'].", la cantidad de:".$arr_dp[$i]['total_art']." del pedido #".$id." a Credito y Cobranzas");
		}
		?> <script language="javascript" type="text/javascript">window.location="pedidos_pre.php";</script> <?php
	}else{
		mysql_query('ROLLBACK');
        ?> <script language="javascript" type="text/javascript">alert("Error de transaccion, intentelo nuevamente...");window.location="home.php";</script> <?php
	}
}else{
	?> <script language="javascript" type="text/javascript">alert("No se recibieron datos...");window.location="home.php";</script> <?php
}


?>
