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
	function get_pedidos($status=''){
		 $res_array =  array();
		$sQuery="SELECT pedidos.*,clientes.cli_des,usuario.nombre FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli INNER JOIN usuario ON pedidos.co_ven = usuario.uname WHERE 1 = 1 ";
		if($status) {	$sQuery.=" AND  pedidos.`status`= $status ";	}
		$sQuery.="ORDER BY doc_num Desc";
        //echo ($sQuery);
		$result=mysql_query($sQuery) or die(mysql_error());
		$i=0;
		while($row=mysql_fetch_array($result)){
			foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
			}
			$i++;
		}
		return($res_array);
			
	}function get_pedi($status=''){
        $res_array =  array();
        $sQuery="SELECT pedidos.*,clientes.cli_des,usuario.nombre FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli INNER JOIN usuario ON pedidos.co_ven = usuario.uname WHERE 1 = 1 ";
        if($status) {   $sQuery.=" AND  pedidos.`status`= $status ";    }
        $sQuery.="ORDER BY doc_num";
        //echo ($sQuery);
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
function get_ped_new_cli_el($status=''){
    $sQuery="SELECT pedidos_app.*, tmcustomernew.*, usuario.nombre FROM pedidos_app INNER JOIN tmcustomernew ON pedidos_app.co_cli = tmcustomernew.CustCode INNER JOIN usuario ON pedidos_app.co_ven = usuario.uname WHERE pedidos_app.status= $status";
 //echo $sQuery;
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
	function get_ped_sql($id=''){
		 $res_array =  array();
	$conn = conectarSQlSERVER();
    $sel="SELECT saPedidoVenta.*, saCliente.cli_des FROM saPedidoVenta INNER JOIN saCliente ON saPedidoVenta.co_cli=saCliente.co_cli WHERE anulado=0 AND status=0  ";
    if($id) {	$sel.=" AND doc_num = '$id' ";	}
    $sel.=" Order By doc_num Desc;";
    $result=sqlsrv_query($conn,$sel);
    $i=0;
	while($row=sqlsrv_fetch_array($result)){
		foreach($row as $key=>$value){
			$res_array[$i][$key]=$value;
		}
		$i++;
	}
	return($res_array);
}
function get_pedido_ANP($id=''){
         $res_array =  array();
        $sQuery="SELECT pedidos_app.*,tmcustomernew.* FROM pedidos_app INNER JOIN tmcustomernew ON pedidos_app.co_cli = tmcustomernew.CustCode WHERE 1 = 1 ";
        if($id) {   $sQuery.=" AND  pedidos_app.doc_num= $id "; }
        //  echo ($sQuery);
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
function get_ped_det_sql($id=''){
	 $res_array =  array();
	$conn = conectarSQlSERVER();
    $sQuery="SELECT saPedidoVentaReng.*,saArticulo.art_des FROM saPedidoVentaReng
    INNER JOIN saArticulo ON saPedidoVentaReng.co_art = saArticulo.co_art WHERE 1 = 1";
    if($id) {	$sQuery.=" AND doc_num = '$id' ";	}
        $sQuery.="ORDER BY reng_num ASC ";
        $result=sqlsrv_query($conn,$sQuery);
    	$i=0;
		while($row=sqlsrv_fetch_array($result)){
			foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
			}
		$i++;
	}
	return($res_array);
}
function get_pd_d($id){
	 $res_array =  array();
        $sQuery="SELECT * FROM pedidos_detalles_des WHERE doc_num = $id";
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
    function get_dat($id=''){
        $sQuery="SELECT pedidos_des.*,clientes.ciudad,clientes.cli_des,vendedor.ven_des FROM pedidos_des INNER JOIN clientes ON pedidos_des.co_cli = clientes.co_cli INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven WHERE 1 = 1 ";
            if($id){ $sQuery.=" AND doc_num = '$id' ";      }
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
    function get_ped_desp_F($id=''){
    	 $res_array =  array();
        $sQuery="SELECT
	pedidos_des.id,
	pedidos_des.doc_num,
	pedidos_des.co_cli,
	pedidos_des.co_ven,
	pedidos_des.total_neto,
	pedidos_des.comentario,
	pedidos_des.fecha_facturado,
	pedidos_des.factura,
	vendedor.ven_des,
(SELECT cli_des FROM clientes WHERE clientes.co_cli=pedidos_des.co_cli) as cli_des
FROM
	pedidos_des
INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven
WHERE
	STATUS = 2 ";
				if(isset($_SESSION["desde"])){
						$desde =  $_SESSION["desde"];
						$hasta =  $_SESSION["hasta"];
						
						unset($_SESSION['desde']);
						unset($_SESSION['hasta']);
						
						$sQuery.= " and fecha_facturado BETWEEN '".$desde."' and '".$hasta."' ";
					}else{
						 $sQuery.= " and  fecha_facturado  >= DATE_SUB(CURDATE(), INTERVAL 25 DAY)";
						}
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
	function get_ped_desp_G($st='',$sup=''){
    		$sQuery="SELECT pedidos_des.*,(SELECT cli_des FROM clientes WHERE clientes.co_cli=pedidos_des.co_cli) AS cli_des,vendedor.ven_des FROM pedidos_des INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven WHERE 1 = 1 ";
    	if($st) {   $sQuery.=" AND pedidos_des.`status` = $st ";    }
    	if($sup) {  $sQuery.=" AND pedidos_des.co_ven IN (SELECT uname FROM usuario WHERE supervisor='$sup')";    }
	$sQuery.=" ORDER BY doc_num DESC";
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
    function get_ped_desp_D($id=''){
    	 $res_array =  array();
        $sQuery="SELECT
				pedidos_des.id,
				pedidos_des.doc_num,
				pedidos_des.co_cli,
				pedidos_des.co_ven,
				pedidos_des.total_neto,
				pedidos_des.comentario_d,
				pedidos_des.fecha_despacho,
				pedidos_des.factura,
				vendedor.ven_des,
			(SELECT cli_des FROM clientes WHERE clientes.co_cli=pedidos_des.co_cli) as cli_des
			FROM
				pedidos_des
			INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven
			WHERE
				STATUS = 3 ";

					if (isset($_SESSION["desde"])) {
						$desde =  $_SESSION["desde"];
						$hasta =  $_SESSION["hasta"];
						
						unset($_SESSION['desde']);
						unset($_SESSION['hasta']);
						
						$sQuery.= " and fecha_despacho BETWEEN '".$desde."' and '".$hasta."' ";
					} else { 
						 $sQuery.= " and fecha_facturado  >= DATE_SUB(CURDATE(), INTERVAL 25 DAY)";
						}
		            if($id){ $sQuery.=" AND doc_num = '$id' ";      }

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

    function get_ped_desp_R($id=''){
		
		  
        $sQuery="SELECT
				pedidos_des.id,
				pedidos_des.doc_num,
				pedidos_des.descrip,
				pedidos_des.co_cli,
				pedidos_des.co_ven,
				pedidos_des.total_neto,
				pedidos_des.comentario_r,
				pedidos_des.fecha_recibido,
				pedidos_des.factura,
				vendedor.ven_des,
			(SELECT cli_des FROM clientes WHERE clientes.co_cli=pedidos_des.co_cli) as cli_des
			FROM
				pedidos_des
			INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven
			WHERE
				STATUS = 4";


			if(isset($_SESSION["desde"])){
				$desde =  $_SESSION["desde"];
				$hasta =  $_SESSION["hasta"];
				
				unset($_SESSION['desde']);
				unset($_SESSION['hasta']);
				
				$sQuery.= " and  fecha_recibido BETWEEN '".$desde."' and '".$hasta."' ";
			}else{
				 $sQuery.= " and  fecha_facturado  >= DATE_SUB(CURDATE(), INTERVAL 25 DAY)";
				}
	
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
function get_ped_desp($id=''){
        $sQuery="SELECT
	pedidos_des.id,
	pedidos_des.doc_num,
	pedidos_des.co_cli,
	pedidos_des.co_ven,
	pedidos_des.total_neto,
	pedidos_des.descrip,
	pedidos_des.fecha_aprobado,
	pedidos_des.factura,
	pedidos_des.imp,
	pedidos_des.anulado,
	vendedor.ven_des,
(SELECT cli_des FROM clientes WHERE clientes.co_cli=pedidos_des.co_cli) as cli_des,
(SELECT ciudad FROM clientes WHERE clientes.co_cli=pedidos_des.co_cli) as ciudad
FROM
	pedidos_des
INNER JOIN vendedor ON pedidos_des.co_ven = vendedor.co_ven
WHERE
	STATUS = 1 and pedidos_des.anulado= 0";
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
	function get_pedidos_cn($status=''){
		
		$sQuery="SELECT pedidos.*,cliente_evento.rif,pedidos_tipos.tipo,cliente_evento.nombre_emp,usuario.nombre FROM pedidos INNER JOIN cliente_evento ON pedidos.co_cli = cliente_evento.rif INNER JOIN pedidos_tipos ON pedidos.doc_num = pedidos_tipos.doc_num INNER JOIN usuario ON pedidos.co_ven = usuario.uname WHERE 1 = 1 ";
		if($status) {	$sQuery.=" AND  pedidos.`status`= $status ";	}
		$sQuery.=" ORDER BY doc_num";
        //echo ($sQuery);
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
	function get_ped_new_cli_c($status='',$sup=''){
    $sQuery="SELECT pedidos_app.*, tmcustomernew.*, usuario.nombre FROM pedidos_app INNER JOIN tmcustomernew ON pedidos_app.co_cli = tmcustomernew.CustCode INNER JOIN usuario ON pedidos_app.co_ven = usuario.uname WHERE pedidos_app.status= $status AND tmcustomernew.SellCode
 IN (SELECT uname FROM usuario WHERE supervisor='$sup')";
 //echo $sQuery;
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
	function get_pedido($id=''){
		
		$sQuery="SELECT pedidos.*,clientes.cli_des FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli WHERE 1 = 1 ";
		if($id) {	$sQuery.=" AND  pedidos.doc_num= $id ";	}
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
    function get_pedido_app($id=''){
        
        $sQuery="SELECT pedidos.*,clientes.cli_des FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli WHERE 1 = 1 ";
        if($id) {   $sQuery.=" AND  pedidos.doc_num= $id "; }
        //  echo ($sQuery);
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
	function get_pedido_N($id=''){
		
		$sQuery="SELECT pedidos.*,cliente_evento.nombre_emp FROM pedidos INNER JOIN cliente_evento ON pedidos.co_cli = cliente_evento.rif WHERE 1 = 1 ";
		if($id) {	$sQuery.=" AND  pedidos.doc_num= $id ";	}
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
        $sQuery="SELECT pedidos.*,clientes.direc FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli WHERE 1 = 1 ";
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
    function get_detalles_pedido_app($id=''){
        $sQuery="SELECT * FROM pedidos_detalles WHERE 1 = 1 ";
       if($id) {    $sQuery.=" AND doc_num = '$id' ";   }

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
    clientes.co_ven,clientes.direc,clientes.telefonos,clientes.rif,usuario.nombre
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
pedidos.total_neto,pedidos.comentario,pedidos.fecha_anulado,pedidos.fec_emis,usuario.nombre
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
    $sQuery="SELECT pedidos.*,tmcustomernew.CustDesc,tmcustomernew.CustDirF,tmcustomernew.CustRIF,tmcustomernew.CustTele,tmcustomernew.CustEmail,tmcustomernew.SellCode,tmcustomernew.CustRespons,usuario.nombre
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
    $sQuery="SELECT pedidos_detalles.id,pedidos_detalles.reng_num,pedidos_detalles.doc_num,pedidos_detalles.co_art,pedidos_detalles.des_art,
    pedidos_detalles.co_alma,pedidos_detalles.total_art,pedidos_detalles.co_precio,pedidos_detalles.prec_vta,pedidos_detalles.total_sub,
    pedidos_detalles.porc_desc,pedidos_detalles.monto_desc,pedidos_detalles.tipo_imp,pedidos_detalles.porc_imp,pedidos_detalles.monto_imp,
    pedidos_detalles.reng_neto,pedidos_detalles.total_dev,pedidos_detalles.monto_dev,pedidos_detalles.anulado,pedidos_detalles.UniCodPrincipal,art.art_des
    FROM pedidos_detalles
    INNER JOIN art ON pedidos_detalles.co_art = art.co_art WHERE 1 = 1";
    if($id) {	$sQuery.=" AND doc_num = '$id' ";	}
        $sQuery.="ORDER BY reng_num ASC ";
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
function get_ped_det_app($id=''){
    $sQuery="SELECT pedidos_detalles.*,art.art_des FROM pedidos_detalles INNER JOIN art ON pedidos_detalles.co_art = art.co_art WHERE 1 = 1";
    if($id) {	$sQuery.=" AND doc_num = '$id' ";	}
        $sQuery.="ORDER BY reng_num ASC ";
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
function get_condpago($id='',$id_w=''){
    $sQuery="SELECT * FROM condpago WHERE 1 = 1";
    if($id) {	$sQuery.=" AND activo = '$id' ";	}
    if($id_w) {	$sQuery.=" AND id_w = '$id_w' ";	}
        $result=mysql_query($sQuery) or die(mysql_error());
        //echo ($sQuery).'<br>';
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
function get_ped_app($st='',$sup=''){
    $sQuery="SELECT pedidos.*,clientes.cli_des,usuario.nombre FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli INNER JOIN usuario ON pedidos.co_ven = usuario.uname WHERE 1 = 1 ";
    //var_dump($sQuery);
    if($st) {	$sQuery.=" AND pedidos.`status` = $st ";	}
    if($sup) {	$sQuery.=" AND pedidos.co_ven IN (SELECT uname FROM pedidos WHERE supervisor='$sup')";	}
    $result=mysql_query($sQuery) or die(mysql_error());
    $i=0;
    $res_array = array();
    while($row=mysql_fetch_array($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
        }
        $i++;
    }
    return($res_array);
}
function get_ped_c($st='',$sup=''){
    $sQuery="SELECT pedidos.*,clientes.cli_des,usuario.nombre FROM pedidos INNER JOIN clientes ON pedidos.co_cli = clientes.co_cli INNER JOIN usuario ON pedidos.co_ven = usuario.uname WHERE 1 = 1 ";
    if($st) {	$sQuery.=" AND pedidos.`status` = $st ";	}
    if($sup) {	$sQuery.=" AND pedidos.co_ven IN (SELECT uname FROM usuario WHERE supervisor='$sup')";	}
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


