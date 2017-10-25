<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='2') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;

function add_pedidos($idn,$co_ven,$descrip,$co_cli,$status,$fecha_emis,$total_bruto,$monto_imp,$total_neto,$OrderNumberTax){
		$query = "INSERT INTO pedidos (doc_num,co_ven,descrip,co_cli,status,fec_emis,total_bruto,monto_imp,total_neto,OrderNumberTax) 
				  VALUES ($idn,'$co_ven','$descrip','$co_cli',$status,'$fecha_emis',$total_bruto,$monto_imp,$total_neto,$OrderNumberTax)";
		$result=mysql_query($query);
		return $result;
}
function add_pedidos_detalles($reng_num,$doc_num,$co_art,$des_art,$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,$uniCodP,$co_precio){
		$query="INSERT INTO pedidos_detalles (reng_num,doc_num,co_art,des_art,total_art,prec_vta,total_sub,monto_imp,reng_neto,UniCodPrincipal,co_precio) 
				  VALUES ($reng_num,$doc_num,'$co_art','$des_art',$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,'$uniCodP',$co_precio)";
		$result=mysql_query($query);
		return $result;
}
function update_pedidos_app($id,$idn){
	$query = "UPDATE pedidos_app SET status=2, doc_num_p=$idn";
	$query .= " WHERE doc_num = $id";
	$result=mysql_query($query);
	return $result;
}
function add_log($fecha,$user,$accion){
	$query = "INSERT INTO log_data_pow (id,fecha,user,accion)";
	$query .= " VALUES (NULL,'$fecha','$user','$accion')";
	$result=mysql_query($query);
	return $result;
}
if($_REQUEST['id']){
	$id = $_REQUEST['id'];
	$tipo_d = $_REQUEST['tipo_d'];
	$tipo_p = $_REQUEST['tipo_p'];
	$user=$_SESSION['usuario'];

	$arr_pedidos=$obj_pedidos->get_pedido_app($id);
	$arr_dp=$obj_pedidos->get_detalles_pedido_app($id);
	$arr_tipop=$obj_pedidos->get_tipoprecioart('',$tipo_d);
	$porcentaje=$arr_tipop[0]['porcentaje'];
	$co_precio=$arr_tipop[0]['co_precio'];
	$iva=$arr_pedidos[0]["OrderNumberTax"];	
	$total_bg=0;
	$total_imp=0;
	$total_glob=0;
	
	for($i=0;$i<sizeof($arr_pedidos);$i++){
		$ssql="SELECT doc_num FROM pedidos ORDER BY doc_num DESC LIMIT 1";
		$sel=@mysql_query($ssql);
		$ult_id=mysql_fetch_array($sel);
		$idn=$ult_id["doc_num"]+1;
		$descrip=$arr_pedidos[$i]['descrip'];
		$co_cli=$arr_pedidos[$i]['co_cli'];
		$co_ven=$arr_pedidos[$i]['co_ven'];
		$fec_emis=$arr_pedidos[$i]['fec_emis'];
		$total_bruto=$arr_pedidos[$i]['total_bruto'];
		$monto_imp=$arr_pedidos[$i]['monto_imp'];
		$total_neto=$arr_pedidos[$i]['total_neto'];
		$OrderNumberTax = $arr_pedidos[$i]['OrderNumberTax'];

		$precio=$arr_pedidos[$i]['total_bruto'];
		$desc=($precio*$porcentaje)/100;
		$total_bruto=$precio-$desc;
		$monto_imp=($total_bruto*$iva)/100;
		$total_neto=$total_bruto+$monto_imp;	


		$insert=add_pedidos($idn,$co_ven,$descrip,$co_cli,2,$fec_emis,$total_bruto,$monto_imp,$total_neto,$OrderNumberTax);
		if($insert){
			$udp=update_pedidos_app($id,$idn);
			$fecha=date("Y-m-d H:i:s");
        	add_log($fecha, $user, 'Insercion del pedido '.$id.'-'.$idn.' desde la tabla pedidos_app a pedidos');
        }
	}
	for($j=0;$j<sizeof($arr_dp);$j++){
		//$id_d=$arr_dp[$j]['id'];
		
		$reng_num=$arr_dp[$j]['reng_num'];
		$doc_num=$idn;
		$co_art=$arr_dp[$j]['co_art'];
		$des_art=$arr_dp[$j]['des_art'];
		$total_art=$arr_dp[$j]['total_art'];
		
		$prec_vta=$arr_dp[$j]['prec_vta'];
		$total_sub=$arr_dp[$j]['total_sub'];
		$monto_imp=$arr_dp[$j]['monto_imp'];
		$reng_neto=$arr_dp[$j]['reng_neto'];
		$uniCodP=$arr_dp[$j]['UniCodPrincipal'];


		$precio=$arr_dp[$j]['prec_vta'];
		$desc=($precio*$porcentaje)/100;
		$precio_new=$precio-$desc;
		$sub_total=$arr_dp[$j]['total_art']*$precio_new;
		$monto_imp=($sub_total*$iva)/100;
		$reng_neto=$sub_total+$monto_imp;

		echo "precio_new".$precio_new."<br>";
		echo "sub_total".$sub_total."<br>";
		echo "monto_imp".$monto_imp."<br>";

		$insert_d=add_pedidos_detalles($reng_num,$doc_num,$co_art,$des_art,$total_art,$precio_new,$sub_total,$monto_imp,$reng_neto,$uniCodP,$co_precio);
		if($insert_d){
			$fecha=date("Y-m-d H:i:s");
        	add_log($fecha, $user, 'Insercion de renglones del pedido '.$doc_num.' desde la tabla pedidos_detalles_app a pedidos_detalles');
		}
	}
	?>}  <script language="javascript" type="text/javascript">window.location="home.php?status=e";</script> <?php
}else{
	?> <script language="javascript" type="text/javascript">alert("No se recibieron datos...");window.location="home.php?status=e";</script> <?php
}

?>
