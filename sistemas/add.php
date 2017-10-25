<?php
//$con = mysql_connect('localhost', 'root', 'localhost');
$con = mysql_connect('localhost', 'root', '');
//mysql_select_db('psdb_bk', $con);
mysql_select_db('b2bfc', $con);
function get_pedidos_nuevos(){
		$res_array = array();
		$sQuery="SELECT * FROM wttorder";
		$sQuery.=" WHERE OrderSincStatus = 1 ";
		$result=mysql_query($sQuery) or die(mysql_error());
		$i=0;
		while($row=mysql_fetch_array($result)){
			foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
			}
			$i++;
		}
		return($res_array);
}
function get_pedidos_detalles($id){
		$res_array = array();
		$sQuery="SELECT * FROM wttorderd";
		$sQuery.=" WHERE OrderIdW=$id AND OrderItemSincStatus = 1 ";
		$result=mysql_query($sQuery) or die(mysql_error());
		$i=0;
		while($row=mysql_fetch_array($result)){
			foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
			}
			$i++;
		}
		return($res_array);
}
function add_pedidos_nuevos($doc_num,$co_ven,$descrip,$co_cli,$status,$fecha_emis,$total_bruto,$total_neto,$monto_imp,$OrderNumberTax){
		
		$query = "INSERT INTO pedidos_app (doc_num,co_ven,descrip,co_cli,status,fec_emis,total_bruto,total_neto,monto_imp,OrderNumberTax) 
				  VALUES ($doc_num,'$co_ven','$descrip','$co_cli',$status,'$fecha_emis',$total_bruto,$total_neto,$monto_imp,$OrderNumberTax)";
		$result=mysql_query($query);
		return $result;
}
function add_pedidos_detalles($reng_num,$doc_num,$co_art,$des_art,$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,$uniCodPrincipal){
		
		$query = "INSERT INTO pedidos_detalles_app (reng_num,doc_num,co_art,des_art,total_art,prec_vta,total_sub,monto_imp,reng_neto,UniCodPrincipal) 
				  VALUES ($reng_num,$doc_num,'$co_art','$des_art',$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,'$uniCodPrincipal')";
		$result=mysql_query($query);
		return $result;
}
function add_log($fecha,$user,$accion){
	$query = "INSERT INTO log_data_pow (id,fecha,user,accion)";
	$query .= "  VALUES (NULL,'$fecha','$user','$accion')";
	$result=mysql_query($query);
	return $result;
}
function update_pedidos_nuevos($id){
	$query = " UPDATE wttorder SET  OrderSincStatus=2 ";
	$query .= "  WHERE  OrderIdW = $id";
	$result=mysql_query($query);
	return $result;
}
function update_pedidos_detalles($id,$UnitCodeMain){
        $query = " UPDATE wttorderd SET  OrderItemSincStatus=2, UnitCodeMain = '".$UnitCodeMain."'";
        $query .= "  WHERE  OrderDIdIntern = $id";
        $result=mysql_query($query);
        return $query;
}
$mes = date('m');
$ano = date('Y');

//$qq="UPDATE wttorderd, tmitem SET wttorderd.UnitCodeMain = tmitem.ItemUnit WHERE wttorderd.ItemCode = tmitem.ItemCode";
//mysql_query($qq);
$arr_pedidos_nuevos=get_pedidos_nuevos();
for($i=0;$i<sizeof($arr_pedidos_nuevos);$i++){
    $id=$arr_pedidos_nuevos[$i]['OrderIdW'];
    $co_ven=$arr_pedidos_nuevos[$i]['UserCode'];
    $descrip=$arr_pedidos_nuevos[$i]['OrderDesc'];
    $co_cli=$arr_pedidos_nuevos[$i]['CustCode'];
    $status=$arr_pedidos_nuevos[$i]['OrderStatus'];
    $fecha_emis=$arr_pedidos_nuevos[$i]['OrderDateDocu'];
    $sub_total=$arr_pedidos_nuevos[$i]['OrderTotalSub'];
    $total_neto=$arr_pedidos_nuevos[$i]['OrderTotal'];
    $monto_imp=$arr_pedidos_nuevos[$i]['OrderTotalTax'];
    $OrderNumberTax=$arr_pedidos_nuevos[$i]['OrderNumberTax'];
    $insert=add_pedidos_nuevos($id,$co_ven,$descrip,$co_cli,1,$fecha_emis,$sub_total,$total_neto,$monto_imp,$OrderNumberTax);
    if($insert){
        $udp=update_pedidos_nuevos($id);
        $fecha=date("Y-m-d H:i:s");
        add_log($fecha, 'Administrador', 'Insercion del pedidos '.$id.' desde la tabla wttorder a pedidos');
    }
    $arr_pedidos_detalles=get_pedidos_detalles($id);
    for($j=0;$j<sizeof($arr_pedidos_detalles);$j++){
    	 $qq="select tmitem.ItemUnit  from tmitem where ItemCode = '".$arr_pedidos_detalles[$j]['ItemCode']."'";
		$result = mysql_query($qq);
		$row = mysql_fetch_array($result);
        $id_d=$arr_pedidos_detalles[$j]['OrderDIdIntern'];
        $id_pedido=$arr_pedidos_detalles[$j]['OrderIdW'];
        $co_art=$arr_pedidos_detalles[$j]['ItemCode'];
        $des_art=$arr_pedidos_detalles[$j]['OrderItemDesc'];
        $total_art=$arr_pedidos_detalles[$j]['OrderItemQuantity'];
        $prec_vta=$arr_pedidos_detalles[$j]['OrderItemPrec1'];
        $total_sub=$arr_pedidos_detalles[$j]['OrderItemSub'];
        $reng_neto=$arr_pedidos_detalles[$j]['OrderItemTotal'];
        $monto_imp=$arr_pedidos_detalles[$j]['OrderItemTax'];
        $uniCodPrincipal=$row[0];
        $insert_d=add_pedidos_detalles($j+1,$id_pedido,$co_art,$des_art,$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,$uniCodPrincipal);
        if($insert_d){
            $udp=update_pedidos_detalles($id_d,$uniCodPrincipal);
            $fecha=date("Y-m-d H:i:s");
            add_log($fecha, 'Administrador', 'Insercion de detalles del pedido '.$id.' desde la tabla wttorderd a pedidos_detalles');
        }
    }
}
$fecha=date("Y-m-d H:i:s");
add_log($fecha, 'Administrador', 'Ejecucion del archivo add.php');
$pp="UPDATE meta_art_vende,art  SET meta_art_vende.asignada = art.stock WHERE meta_art_vende.mes = $mes AND meta_art_vende.ano = $ano AND meta_art_vende.co_art = art.co_art AND meta_art_vende.asignada <> art.stock ";
mysql_query($pp);
$ppq="UPDATE meta_art_vende,art  SET meta_art_vende.monto = art.monto WHERE meta_art_vende.mes = $mes AND meta_art_vende.ano = $ano AND meta_art_vende.co_art = art.co_art AND meta_art_vende.monto <> art.monto ";
mysql_query($ppq);
?>