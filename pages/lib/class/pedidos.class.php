<?php 
class class_pedidos {

/*
TABLA	pedidos
CAMPOS 	

*/

	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	//FUNCION DE BUSQUEDA DE PEDIDOS
	function get_pedi($status='',$co_cli=''){
    $sql="SELECT pedidos.*,pedidos_tipos.tipo FROM pedidos INNER JOIN pedidos_tipos ON pedidos.doc_num = pedidos_tipos.doc_num WHERE 1 = 1 ";
    if($status) {   $sql.=" AND pedidos.`status` = $status ";    }
    if($co_cli) {    $sql.=" AND pedidos.co_cli = $co_cli ";    }
    $sql.=" ORDER BY pedidos.doc_num ASC";
    $result=mysql_query($sql) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
        }
        $i++;
    }
    return($res_array);
}

	function get_pedidos($id='',$status=''){
		
		$sQuery="SELECT pedidos.*,clientes.cli_des FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli WHERE 1 = 1 ";
		if($id) {	$sQuery.=" AND doc_num = '$id' ";	}
        if($status) {	$sQuery.=" AND  pedidos.`status`= $status ";	}
		$sQuery.=" ORDER BY doc_num";
        //	echo ($sQuery);
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
        function get_pedidos_p($id=''){
        $sQuery="SELECT pedidos.id,pedidos.doc_num,pedidos.doc_num_p,pedidos.descrip,pedidos.co_cli,pedidos.co_tran,pedidos.co_mone,pedidos.co_ven,pedidos.co_cond,pedidos.fec_emis,
                pedidos.fec_venc,pedidos.fec_reg,pedidos.anulado,pedidos.`status`,pedidos.n_control,pedidos.tasa,pedidos.porc_desc_glob,pedidos.monto_desc_glob,pedidos.porc_reca,
                pedidos.monto_reca,pedidos.total_bruto,pedidos.monto_imp,pedidos.total_neto,pedidos.saldo,pedidos.dir_ent,pedidos.comentario,pedidos.impfisfac,pedidos.fecha_anulado,
                clientes.direc FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli WHERE 1 = 1 ";
            if($id){ $sQuery.="AND doc_num = '$id' ";      }
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
	
	

	//DETALLES DEL PEDIDO SOLICITADO
	function get_detalles_pedido($id=''){
		$sQuery="SELECT * FROM pedidos_detalles WHERE 1 = 1 ";
	   if($id) {	$sQuery.=" AND doc_num = '$id' ";	}

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
	
	//FUNCION QUE CUENTA LOS USUARIOS DE UN SUPERVISOR O COORDINADOR X
	function get_total_ven($tipo='',$supervisor='',$uname=''){
		
		$sQuery="SELECT uname,nombre FROM authuser WHERE status=1 ";
		if($tipo) {	$sQuery.=" AND tipo IN ($tipo) ";	}
		if($supervisor) {	$sQuery.=" AND supervisor IN ($supervisor) ";	}
		if($uname) {	$sQuery.=" AND uname IN ($uname) ";	}
		 $sQuery.="ORDER BY supervisor,uname ";
	 //echo ($sQuery).'<br>';
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
function get_ped($id='',$status=''){
    $sQuery="SELECT pedidos.id,pedidos.doc_num,pedidos.doc_num_p,pedidos.descrip,pedidos.co_cli,pedidos.co_tran,pedidos.co_mone,pedidos.co_ven,pedidos.co_cond,
    pedidos.fec_emis,pedidos.fec_venc,pedidos.fec_reg,pedidos.anulado,pedidos.`status`,pedidos.n_control,pedidos.tasa,pedidos.porc_desc_glob,
    pedidos.monto_desc_glob,pedidos.porc_reca,pedidos.monto_reca,pedidos.total_bruto,pedidos.monto_imp,pedidos.total_neto,pedidos.saldo,pedidos.dir_ent,
    pedidos.comentario,pedidos.impfisfac,pedidos.fecha_anulado,pedidos.fecha_aprobado,clientes.cli_des,clientes.tipo_cli,clientes.limite,clientes.deuda,clientes.co_zon,
    clientes.co_ven,clientes.direc,clientes.telefonos,clientes.rif,usuario.nombre,usuario.apellido
    FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli INNER JOIN usuario ON pedidos.co_ven = usuario.usuario WHERE 1 = 1";
    if($id) {	$sQuery.=" AND id = '$id' ";	}
    if($status) {	$sQuery.=" AND  status= $status ";	}
    //$sQuery.="ORDER BY id;";
    //echo ($sQuery).'<br>';
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
function get_ped_anulados(){
    $sQuery="SELECT pedidos.id,pedidos.doc_num,pedidos.co_cli,pedidos.co_ven,pedidos.total_bruto,pedidos.monto_imp,
pedidos.total_neto,pedidos.comentario,pedidos.fecha_anulado,pedidos.fec_emis,usuario.nombre,usuario.apellido
FROM pedidos
INNER JOIN usuario ON pedidos.co_ven = usuario.usuario
WHERE pedidos.`status` = 3";
    //echo ($sQuery).'<br>';
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
function get_ped_new_cli($id='',$status=''){
    $sQuery="SELECT pedidos.id,pedidos.doc_num,pedidos.doc_num_p,pedidos.descrip,pedidos.co_cli,pedidos.co_tran,pedidos.co_mone,pedidos.co_ven,pedidos.co_cond,pedidos.fec_emis,
        pedidos.fec_venc,pedidos.fec_reg,pedidos.anulado,pedidos.`status`,pedidos.n_control,pedidos.tasa,pedidos.porc_desc_glob,pedidos.monto_desc_glob,pedidos.porc_reca,
        pedidos.monto_reca,pedidos.total_bruto,pedidos.monto_imp,pedidos.total_neto,pedidos.saldo,pedidos.dir_ent,pedidos.comentario,pedidos.impfisfac,pedidos.fecha_anulado,
        tmcustomernew.CustDesc,tmcustomernew.CustDirF,tmcustomernew.CustRIF,tmcustomernew.CustTele,tmcustomernew.CustEmail,tmcustomernew.SellCode,tmcustomernew.CustRespons,
        usuario.nombre,usuario.apellido
        FROM pedidos INNER JOIN tmcustomernew ON pedidos.co_cli = tmcustomernew.CustCode INNER JOIN usuario ON pedidos.co_ven = usuario.usuario WHERE 1 = 1";
    if($id) {	$sQuery.=" AND id = '$id' ";	}
    if($status) {	$sQuery.=" AND  status= $status ";	}
    $sQuery.="ORDER BY id";
    //echo ($sQuery).'<br>';
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
function get_ped_det($id=''){
    $sQuery="SELECT * FROM pedidos_detalles WHERE 1 = 1";
    if($id) {	$sQuery.=" AND doc_num = '$id' ";	}
        $sQuery.=" ORDER BY reng_num ASC ";
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
function get_tipoprecioart($id='',$id_w=''){
    $sQuery="SELECT * FROM tipoprecioart WHERE 1 = 1";
    if($id) {	$sQuery.=" AND activo = '$id' ";	}
    if($id_w) {	$sQuery.=" AND id_w = '$id_w' ";	}
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
function get_renglon($id=''){
    $sQuery="SELECT * FROM pedidos_detalles WHERE 1 = 1";
    if($id) {	$sQuery.=" AND id = '$id' ";	}
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
	
	////////---------------------------------------------------------/////////
	
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


