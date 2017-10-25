<?php 
class class_cobranza {


	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	function get_ttcollection_w($id){
		$sQuery="SELECT ttcollection_w.CollectionIdW,clientes.cli_des,ttcollection_w.CollectionTotalPayment,
                    ttcollection_w.UserCode,ttcollection_w.CustCode,ttcollection_w.CollectionDate,ttcollection_w.CollectionNote,
                    ttcollection_w.fecha_a,usuario.nombre,usuario.apellido
                    FROM ttcollection_w
                    INNER JOIN clientes ON ttcollection_w.CustCode = clientes.co_cli
                    INNER JOIN usuario ON ttcollection_w.UserCode = usuario.usuario
                    WHERE ttcollection_w.CollectionStatus = $id";
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
	function get_ttcollection_w_ap($id){
		$sQuery="SELECT * FROM ttcollection_w WHERE CollectionIdW = $id";
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
        function get_ttcollectionpayment_w($id='',$status=''){
		$sQuery="SELECT * FROM ttcollection_w WHERE 1 = 1 ";
		if($id) {	$sQuery.=" AND id = '$id' ";	}
                if($status) {	$sQuery.=" AND  status= $status ";	}
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
        function get_ttcollectiondoc_w($id='',$status=''){
		$sQuery="SELECT * FROM ttcollection_w WHERE 1 = 1 ";
		if($id) {	$sQuery.=" AND id = '$id' ";	}
                if($status) {	$sQuery.=" AND  status= $status ";	}
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

	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	function get_doc($id=''){
		$sQuery="SELECT ttcollectiondoc_w.DocNumber,ttcollectiondoc_w.DocAmount,ttcollectiondoc_w.DocDiscount,
                    ttcollectiondoc_w.DocRetention,ttcollectiondoc_w.DocAmountTotal
                    FROM ttcollectiondoc_w
                    WHERE ttcollectiondoc_w.CollectionIdW = $id";
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
	function get_doc_ap($id=''){
		$sQuery="SELECT * FROM ttcollectiondoc_w WHERE CollectionIdW = $id";
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
	function get_pago($id=''){
		$sQuery="SELECT tmbank.BankDescrip,tmtypetrans.TypeTransDescrip,ttcollectionpayment_w.TransNumber,
                    ttcollectionpayment_w.TransDate,ttcollectionpayment_w.TransAmount
                    FROM ttcollectionpayment_w
                    INNER JOIN tmbank ON ttcollectionpayment_w.BankCode = tmbank.BankCode
                    INNER JOIN tmtypetrans ON ttcollectionpayment_w.TypeTransCode = tmtypetrans.TypeTransCode
                    WHERE ttcollectionpayment_w.CollectionIdW = $id";
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
	function get_pago_ap($id=''){
		$sQuery="SELECT * FROM ttcollectionpayment_w WHERE CollectionIdW = $id";
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
	//////////////////////////////////////////////////////////////////////////
	////////////////////////INSERTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	function add_authuser($nombre,$apellido,$login,$pass,$tipo,$status,$email)
	{
		$query = "INSERT INTO authuser (nombre,apellido,login,pass,email,tipo,status) 
				  VALUES ('$nombre','$apellido','$login','$pass','$email','$tipo','$status')";
		$result=mysql_query($query);
		$new_pet_id = mysql_insert_id();
		return $new_pet_id;
	}
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////INSERTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	////////---------------------------------------------------------/////////
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////UPDATES SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	//FUNCION QUE CUENTA LAS VISITAS Y COLOCA EL ULTIMO LOGEO DEL USUARIO
	function update_authuser($id,$in_count)
	{
		$query = "UPDATE authuser SET lastlogin = NOW() , logincount = '$in_count' 
				  WHERE  id = '$id'";
		//die($query);
		$result=mysql_query($query);
		return $result;
	}
	
	function update_clave_authuser($id='',$pass='',$pass_old='')
	{
		$query = " UPDATE authuser SET  passwd='$pass' ";
		$query .= "  WHERE  id = '$id' AND passwd='$pass_old'";
	//die($query);	
		$result=mysql_query($query);
	//	die($result);
		return $result;
	}
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////UPDATES SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	////////---------------------------------------------------------/////////
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////DELETES SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	function desactivar_authuser($id)
	{
		$query = "UPDATE authuser set status=0 WHERE id = $id'";
		$result=mysql_query($query);
		return $result;
	}
	function delete_authuser($id)
	{
		$query = "DELETE FROM  authuser WHERE id = '$id'";
		$result=mysql_query($query);
	}
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////UPDATES SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	////////---------------------------------------------------------/////////
	
	//////////////////////////////////////////////////////////////////////////
	///////////////SPECIFIT AND GENERAL SECTION///////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////////
	///////////////SPECIFIT AND GENERAL SECTION///////////////////////////////
	//////////////////////////////////////////////////////////////////////////
}
?>



