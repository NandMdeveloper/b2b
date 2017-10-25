<?php
//$con = mysql_connect('localhost', 'root', 'localhost');
$con = mysql_connect('localhost', 'power_db', '#hGbkWpdeSD;');
//mysql_select_db('psdb_bk', $con);
mysql_select_db('b2bfc', $con);
function get_colector(){
		$sQuery="SELECT * FROM ttcollection";
		$sQuery.=" WHERE TSSincStatus = 1 ";
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
function get_doc(){
		$sQuery="SELECT * FROM ttcollectiondoc";
		$sQuery.=" WHERE TSSincStatus = 1 ";
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
function get_pagos(){
		$sQuery="SELECT * FROM ttcollectionpayment";
		$sQuery.=" WHERE TSSincStatus = 1 ";
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
function add_colector($CollectionIdW,$CollectionIdA,$UserCode,$CustCode,$CollectionDate,$CollectionTotalDoc,$CollectionTotalPayment,$CollectionStatus,$CollectionNote,$tssit,$TSSincStatus,$DateCrea,$TSSITas){
		$query = "INSERT INTO ttcollection_w (CollectionIdW,CollectionIdA,UserCode,CustCode,CollectionDate,CollectionTotalDoc,CollectionTotalPayment,CollectionStatus,CollectionNote,tssit,TSSincStatus,DateCrea,TSSITas) 
                VALUES ($CollectionIdW,$CollectionIdA,'$UserCode','$CustCode','$CollectionDate',$CollectionTotalDoc,$CollectionTotalPayment,$CollectionStatus,'$CollectionNote','$tssit',$TSSincStatus,'$DateCrea','$TSSITas')";
                echo "Query 1: ".$query."<br>";
		$result=mysql_query($query);
		return $result; }
function add_doc($CollectionIdDocIntern,$CollectionIdW,$CollectionIdA,$UserCode,$CustCode,$DocNumber,$DocControl,$DocType,$DocOrig,$DocOrigNumber,$DocAmount,$DocDiscount,$DocRetention,$DocAmountTotal,$DocStatus,$DocNote,$tssit,$TSSincStatus,$TSSITas){
		$query = "INSERT INTO ttcollectiondoc_w (CollectionIdDocIntern,CollectionIdW,CollectionIdA,UserCode,CustCode,DocNumber,DocControl,DocType,DocOrig,DocOrigNumber,DocAmount,DocDiscount,DocRetention,DocAmountTotal,DocStatus,DocNote,tssit,TSSincStatus,TSSITas) 
		VALUES ($CollectionIdDocIntern,$CollectionIdW,$CollectionIdA,'$UserCode','$CustCode','$DocNumber','$DocControl','$DocType','$DocOrig',$DocOrigNumber,$DocAmount,$DocDiscount,$DocRetention,$DocAmountTotal,$DocStatus,'$DocNote','$tssit',$TSSincStatus,'$TSSITas')";
                echo "Query 2: ".$query."<br>";
		$result=mysql_query($query);
		return $result; }
function add_pagos($CollectionPaymentIdIntern,$CollectionIdW,$CollectionIdA,$UserCode,$CustCode,$BankCode,$TypeTransCode,$TransNumber,$TransDate,$TransAmount,$TransNote,$TransStatus,$tssit,$TSSincStatus,$TSSITas){
		$query = "INSERT INTO ttcollectionpayment_w (CollectionPaymentIdIntern,CollectionIdW,CollectionIdA,UserCode,CustCode,BankCode,TypeTransCode,TransNumber,TransDate,TransAmount,TransNote,TransStatus,tssit,TSSincStatus,TSSITas) 
		VALUES ($CollectionPaymentIdIntern,$CollectionIdW,$CollectionIdA,'$UserCode','$CustCode','$BankCode','$TypeTransCode','$TransNumber','$TransDate',$TransAmount,'$TransNote',$TransStatus,'$tssit',$TSSincStatus,'$TSSITas')";
                echo "Query 3: ".$query."<br>";
		$result=mysql_query($query);
		return $result; }
function add_log($fecha,$user,$accion){
	$query = "INSERT INTO log_data_pow (id,fecha,user,accion)";
	$query .= "  VALUES (NULL,'$fecha','$user','$accion')";
        echo "Query log: ".$query."<br>";
	$result=mysql_query($query);
	return $result; }
$arr_colector=get_colector();
for($i=0;$i<sizeof($arr_colector);$i++){
        $CollectionIdW=$arr_colector[$i]['CollectionIdW'];
	$CollectionIdA=$arr_colector[$i]['CollectionIdA'];
	$UserCode=$arr_colector[$i]['UserCode'];
	$CustCode=$arr_colector[$i]['CustCode'];
	$CollectionDate=$arr_colector[$i]['CollectionDate'];
	$CollectionTotalDoc=$arr_colector[$i]['CollectionTotalDoc'];
	$CollectionTotalPayment=$arr_colector[$i]['CollectionTotalPayment'];
	$CollectionStatus=$arr_colector[$i]['CollectionStatus'];
	$CollectionNote=$arr_colector[$i]['CollectionNote'];
        $tssit=$arr_colector[$i]['tssit'];
	$TSSincStatus=$arr_colector[$i]['TSSincStatus'];
	$DateCrea=$arr_colector[$i]['DateCrea'];
	$TSSITas=$arr_colector[$i]['TSSITas'];
	$insert=add_colector($CollectionIdW,$CollectionIdA,$UserCode,$CustCode,$CollectionDate,$CollectionTotalDoc,$CollectionTotalPayment,
                $CollectionStatus,$CollectionNote,$tssit,$TSSincStatus,$DateCrea,$TSSITas);
	if($insert){
		$fecha=date("Y-m-d H:i:s");
        add_log($fecha, 'Administrador', 'Insercion desde la tabla ttcollection a ttcollection_w');
	}
}
$arr_doc=get_doc();
for($j=0;$j<sizeof($arr_doc);$j++){
	$CollectionIdDocIntern=$arr_doc[$j]['CollectionIdDocIntern'];
	$CollectionIdW=$arr_doc[$j]['CollectionIdW'];
        $CollectionIdA=$arr_doc[$j]['CollectionIdA'];
	$UserCode=$arr_doc[$j]['UserCode'];
	$CustCode=$arr_doc[$j]['CustCode'];
	$DocNumber=$arr_doc[$j]['DocNumber'];
	$DocControl=$arr_doc[$j]['DocControl'];
	$DocType=$arr_doc[$j]['DocType'];
	$DocOrig=$arr_doc[$j]['DocOrig'];
	$DocOrigNumber=$arr_doc[$j]['DocOrigNumber'];
	$DocAmount=$arr_doc[$j]['DocAmount'];
        $DocDiscount=$arr_doc[$j]['DocDiscount'];
	$DocRetention=$arr_doc[$j]['DocRetention'];
	$DocAmountTotal=$arr_doc[$j]['DocAmountTotal'];
	$DocStatus=$arr_doc[$j]['DocStatus'];
	$DocNote=$arr_doc[$j]['DocNote'];
        $tssit=$arr_doc[$j]['tssit'];
	$TSSincStatus=$arr_doc[$j]['TSSincStatus'];
	$TSSITas=$arr_doc[$j]['TSSITas'];
	$insert_d=add_doc($CollectionIdDocIntern,$CollectionIdW,$CollectionIdA,$UserCode,$CustCode,$DocNumber,$DocControl,$DocType,$DocOrig,$DocOrigNumber,$DocAmount,$DocDiscount,$DocRetention,$DocAmountTotal,$DocStatus,$DocNote,$tssit,$TSSincStatus,$TSSITas);
	if($insert_d){
		$fecha=date("Y-m-d H:i:s");
        add_log($fecha, 'Administrador', 'Insercion desde la tabla ttcollectiondoc a ttcollectiondoc_w');
	}
}
$arr_pagos=get_pagos();
for($l=0;$l<sizeof($arr_pagos);$l++){
	$CollectionPaymentIdIntern=$arr_pagos[$l]['CollectionPaymentIdIntern'];
	$CollectionIdW=$arr_pagos[$l]['CollectionIdW'];
        $CollectionIdA=$arr_pagos[$l]['CollectionIdA'];
	$UserCode=$arr_pagos[$l]['UserCode'];
	$CustCode=$arr_pagos[$l]['CustCode'];
        $BankCode=$arr_pagos[$l]['BankCode'];
	$TypeTransCode=$arr_pagos[$l]['TypeTransCode'];
	$TransNumber=$arr_pagos[$l]['TransNumber'];
	$TransDate=$arr_pagos[$l]['TransDate'];
        $TransAmount=$arr_pagos[$l]['TransAmount'];
        $TransNote=$arr_pagos[$l]['TransNote'];
        $TransStatus=$arr_pagos[$l]['TransStatus'];
	$tssit=$arr_pagos[$l]['tssit'];
	$TSSincStatus=$arr_pagos[$l]['TSSincStatus'];
        $TSSITas=$arr_pagos[$l]['TSSITas'];
	$insert_p=add_pagos($CollectionPaymentIdIntern,$CollectionIdW,$CollectionIdA,$UserCode,$CustCode,$BankCode,$TypeTransCode,$TransNumber,$TransDate,
                $TransAmount,$TransNote,$TransStatus,$tssit,$TSSincStatus,$TSSITas);
	if($insert_p){
		$fecha=date("Y-m-d H:i:s");
        add_log($fecha, 'Administrador', 'Insercion desde la tabla ttcollectionpayment a ttcollectionpayment_w');
	}
}
$fecha=date("Y-m-d H:i:s");
add_log($fecha, 'Administrador', 'Ejecucion del archivo add_c.php');
?>