<?php 
class class_metas {

/*
TABLA	meta
CAMPOS 	id,co_ven,mes,ano

TABLA	meta_detalle
CAMPOS 	id,id_meta,id_cat,piezas,piezasv,piezasp

//PARA LAS METAS TAMBIEN ES NECESARI LAS CATEGORIA DE ARTICULOS POR AHORA LO VAMOS A PONER AQUI
TABLA cat_art
CAMPOS co_cat,cat_des

*/
	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION clientes all//////////////////////
	//////////////////////////////////////////////////////////////////////////
	//FUNCION DE BUSQUEDA DEL METAS Y METAS DETALLES
	function get_metas_combinadas($metaId='',$co_ven='',$mes='',$ano='',$meta_detalleId='',$id_cat='',$piezas=''){
		$sQuery="SELECT meta.id AS metaId,meta.co_ven,meta.mes,meta.ano, meta_detalle.id AS meta_detalleId,meta_detalle.id_cat, meta_detalle.piezas, meta_detalle.piezasp, meta_detalle.piezasv 
				FROM meta
				Inner Join meta_detalle ON meta.id = meta_detalle.id_meta
				WHERE 1=1 ";
		if($metaId) {	$sQuery.=" AND meta.id = '$metaId' ";	}
		if($co_ven) {	$sQuery.=" AND meta.co_ven = '$co_ven' ";	}
		if($mes) {	$sQuery.=" AND meta.mes = '$mes' ";	}
		if($ano) {	$sQuery.=" AND meta.ano ='$ano' ";	}
		if($meta_detalleId) {	$sQuery.=" AND meta_detalle.id = $meta_detalleId ";	}
		if($id_cat) {	$sQuery.=" AND meta_detalle.id_cat = '$id_cat' ";	}
		$sQuery.=" ORDER BY meta.id, meta_detalle.id ";	
	//echo($sQuery).'<br>';
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
	
	//FUNCION DE BUSQUEDA DEL METAS
	function get_metas($id='',$co_ven='',$mes='',$ano=''){
		$sQuery="SELECT *
				FROM meta
				WHERE 1=1 ";
		if($id) {	$sQuery.=" AND id = '$id' ";	}
		if($co_ven) {	$sQuery.=" AND co_ven = '$co_ven' ";	}
		if($mes) {	$sQuery.=" AND mes = '$mes' ";	}
		if($ano) {	$sQuery.=" AND ano ='$ano' ";	}
		$sQuery.=" ORDER BY co_ven,mes ";	
	//echo($sQuery).'<br>';
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
	//FUNCION DE BUSQUEDA DEL METAS DETALLES
	function get_meta_detalle($id='',$id_meta='',$id_cat='',$piezas=''){
		$sQuery="SELECT *
				FROM meta_detalle
				WHERE 1=1 ";
		if($id) {	$sQuery.=" AND id = '$id' ";	}
		if($id_meta) {	$sQuery.=" AND id_meta = $id_meta ";	}
		if($id_cat) {	$sQuery.=" AND id_cat = '$id_cat' ";	}
		if($piezas) {	$sQuery.=" AND piezas ='$piezas' ";	}
		$sQuery.=" ORDER BY id ";	
	//echo($sQuery);
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
	//FUNCION DE BUSQUEDA DEL CATEGORIA DE ARTICULOS
	function get_cat_art(){
		$sQuery="SELECT * FROM linea WHERE 1 = 1 ";
		//if($co_cat) {	$sQuery.=" AND co_cat = '$co_cat' ";	}
		//if($cat_des) {	$sQuery.=" AND cat_des = $cat_des ";	}
		
		$sQuery.=" ORDER BY descripcion";	
	//die($sQuery);
        //echo "<br>".$sQuery;

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
	
	/*
		BUSCAMOS LOS ARTICULOS VENDIDOS PARA UN DETERMINADO VENDEDOR O GRUPO DE VENDEDORES EN UN 
		MES OSEA EN FUNCION DE CUMPLIMIENTO DE METAS LOS OBTENEMOS A UNA SUMA
	*/
		function getMetPedSum($co_art='',$co_ven='',$co_cli='',$ano='',$mes='',$campo=''){
		$sQuery="SELECT
					SUM(reng_ped.$campo) AS sumaArt
					FROM
					pedidos
					Inner Join reng_ped ON pedidos.fact_num = reng_ped.fact_num
					WHERE 1=1";
		if($mes) {	$sQuery.=" AND MONTH (pedidos.fec_emis)='$mes' ";	}
		if($ano) {	$sQuery.=" AND YEAR (pedidos.fec_emis)='$ano'  ";	}
		if($co_art) {	$sQuery.=" AND reng_ped.co_art IN ('$co_art') ";	}
		if($co_ven) {	$sQuery.=" AND pedidos.co_ven IN ('$co_ven') ";	}
		if($co_cli) {	$sQuery.=" AND pedidos.co_cli IN ('$co_cli') ";	}
		
   //     echo'<br><br>getMetPedSum:'.($sQuery).'<br>';
//        die();
			$result=mysql_query($sQuery) or die(mysql_error());
			$row=mysql_fetch_array($result);
			
			return($row['sumaArt']);
				
		}
	
	/*
		BUSCAMOS LOS ARTICULOS VENDIDOS PARA UN DETERMINADO VENDEDOR O GRUPO DE VENDEDORES EN UN 
		MES OSEA EN FUNCION DE CUMPLIMIENTO DE METAS LOS OBTENEMOS CON DATOS
	*/
	function getMetPedDAt($fact_num='',$co_ven='',$co_cli='',$ano='',$mes=''){
		$sQuery="SELECT
					pedidos.fact_num,
					pedidos.fec_emis,
					reng_ped.co_art,
					pedidos.co_ven,
					reng_ped.total_art
					FROM
					pedidos
					Inner Join reng_ped ON pedidos.fact_num = reng_ped.fact_num
					WHERE 1=1";
		if($mes) {	$sQuery.=" AND MONTH (pedidos.fec_emis)='$mes' ";	}
		if($ano) {	$sQuery.=" AND YEAR (pedidos.fec_emis)='$ano'  ";	}
		if($fact_num) {	$sQuery.=" AND reng_ped.co_art IN ($fact_num) ";	}
		if($co_ven) {	$sQuery.=" AND pedidos.co_ven IN ('$co_ven') ";	}
		if($co_cli) {	$sQuery.=" AND pedidos.co_cli IN ('$co_cli') ";	}
		//echo($sQuery);
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
		
	/*
		BUSCAMOS LOS ARTICULOS VENDIDOS PARA UN DETERMINADO VENDEDOR O GRUPO DE VENDEDORES EN UN 
		MES OSEA EN FUNCION DE CUMPLIMIENTO DE METAS LOS OBTENEMOS A UNA SUMA
	*/
		function getMetFacList($co_ven='',$co_cli='',$ano='',$mes=''){
		$sQuery="SELECT
					id_control_salida_detalle
					FROM
					control_salida_detalle
					WHERE 1=1";
		if($mes) {	$sQuery.=" AND MONTH (fec_emis)='$mes' ";	}
		if($ano) {	$sQuery.=" AND YEAR (fec_emis)='$ano'  ";	}
		if($co_ven) {	$sQuery.=" AND co_ven IN ('$co_ven') ";	}
		if($co_cli) {	$sQuery.=" AND co_cli IN ('$co_cli') ";	}
		$sQuery.=" GROUP BY id_factura ";
		//echo($sQuery.'aca');
		$result=mysql_query($sQuery) or die(mysql_error());
		$i=0;
		$strinResult='';
		while($row=mysql_fetch_array($result)){
			$strinResult.="'".$row['id_control_salida_detalle']."',";
		}
		$strinResult=substr ($strinResult, 0, - 1);
		return($strinResult);
				
		}
		
	/*
		BUSCAMOS LOS ARTICULOS VENDIDOS PARA UN DETERMINADO VENDEDOR O GRUPO DE VENDEDORES EN UN 
		MES OSEA EN FUNCION DE CUMPLIMIENTO DE METAS LOS OBTENEMOS A UNA SUMA
	*/
		function getMetFacTart($co_art='',$id_control_salida_detalle='',$campo=''){
		$sQuery="SELECT
				SUM($campo) AS sumasArt
				FROM
				con_sal_det_reng
				WHERE 1=1";
		if($id_control_salida_detalle) {	$sQuery.=" AND id_control_salida_detalle IN ($id_control_salida_detalle) ";	}
		if($co_art) {	$sQuery.=" AND co_art IN ($co_art)";	}
		
		//die($sQuery);
			$result=mysql_query($sQuery) or die(mysql_error());
			$row=mysql_fetch_array($result);
			
			return($row['sumasArt']);
				
		
				
		}
        //NUEVA RENE1410201101 //BUSCO EN TABLA YA EXISTENTE
		function getMetFacTart2($co_ven, $co_cat, $ano,$mes){
          
        $sQuery="SELECT Sum(total_art) AS sumasArt
                 FROM metas_periodo_fact
                 WHERE
                   metas_periodo_fact.co_ven='$co_ven' AND
                   metas_periodo_fact.co_cat='$co_cat' AND
                   metas_periodo_fact.ano='$ano' AND
                   metas_periodo_fact.mes='$mes'";
		//die($sQuery);
        //echo $sQuery.'---------------------<br>';
			$result=mysql_query($sQuery) or die(mysql_error());
			$row=mysql_fetch_array($result);
			return($row['sumasArt']);
		}
        
	
	

	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION clientes all//////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	
	
	

	
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	////////---------------------------------------------------------/////////
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////INSERTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	function add_clientes($nombre,$apellido,$login,$pass,$tipo,$status,$email)
	{
		$query = "INSERT INTO clientes (nombre,apellido,login,pass,email,tipo,status) 
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
	
	//FUNCION ACTUALIZA LOS DATOS DE LA META
	function udp_meta_detalle($id,$piezas)
	{
		$query = "UPDATE meta_detalle SET piezas = '$piezas' 
				  WHERE  id = '$id'";
		//echo($query);
		$result=mysql_query($query);
		return $result;
	}
	
	//FUNCION ACTUALIZA LOS DATOS DE LA META EN FUNCIOIN DE LAS PIEZAS PEDIDAS
	function udpMetaPiezasp($id,$piezasp)
	{
		$query = "UPDATE meta_detalle SET piezasp = '$piezasp' 
				  WHERE  id = '$id'";
		//die($query);
		$result=mysql_query($query);
		return $result;
	}
	
	//FUNCION ACTUALIZA LOS DATOS DE LA META EN FUNCIOIN DE LAS PIEZAS VENDIDAS
	function udpMetaPiezasv($id,$piezasv)
	{
		$query = "UPDATE meta_detalle SET piezasv = '$piezasv' 
				  WHERE  id = '$id'";
		//echo($query);
		$result=mysql_query($query);
		return $result;
	}
	
	

	//FUNCION ACTUALIZA LOS DATOS DE LA META
	function udpMetaBolivares($id,$bolivares)
	{
		$query = "UPDATE meta_detalle SET bolivares = '$bolivares' 
				  WHERE  id = '$id'";
	//	echo($query);
		$result=mysql_query($query);
		return $result;
	}
	
	//FUNCION ACTUALIZA LOS DATOS DE LA META EN FUNCIOIN DE LAS PIEZAS PEDIDAS
	function udpMetaBolivaresp($id,$bolivaresp)
	{
		$query = "UPDATE meta_detalle SET bolivaresp = '$bolivaresp' 
				  WHERE  id = '$id'";
		//die($query);
		$result=mysql_query($query);
		return $result;
	}
	
	//FUNCION ACTUALIZA LOS DATOS DE LA META EN FUNCIOIN DE LAS PIEZAS VENDIDAS
	function udpMetaBolivaresv($id,$bolivaresv)
	{
		$query = "UPDATE meta_detalle SET bolivaresv = '$bolivaresv' 
				  WHERE  id = '$id'";
		//echo($query);
		$result=mysql_query($query);
		return $result;
	}
	
	

	//////////////////////////////////////////////////////////////////////////
	////////////////////////UPDATES SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	////////---------------------------------------------------------/////////
	
	//////////////////////////////////////////////////////////////////////////
	////////////////////////DELETES SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	function desactivar_clientes($id)
	{
		$query = "UPDATE clientes set status=0 WHERE id = $id'";
		$result=mysql_query($query);
		return $result;
	}
	function delete_clientes($id)
	{
		$query = "DELETE FROM  clientes WHERE id = '$id'";
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

    
    //METAS RENE
    function getMetArt($ano='',$mes='',$categoria=''){
		$sQuery="SELECT art.co_art, art.art_des, meta_art.mes, meta_art.ano, meta_art.existen
                 FROM
                    meta_art
                    Inner Join art ON art.co_art = meta_art.co_art 
                    WHERE meta_art.mes ='".$mes."' AND  meta_art.ano ='".$ano."' ";
        if($categoria) {	$sQuery.=" AND art.co_lin ='$categoria' ";	}
        $sQuery.=" ORDER BY meta_art.co_art ";	
		//echo $sQuery."<br>";
        
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
        
                //SOLO CODIGO DEL COORDINADOR O COORDINADORES
       /* function getMetCoordGrup($ano='',$mes='',$supervisor=''){
		$sQuery=" SELECT authuser.uname, authuser.nombre, authuser.supervisor 
                  FROM meta_art_coord
            Inner Join material ON material.mara_matnr = meta_art_coord.co_art
            Inner Join grupo_articulos_sap ON grupo_articulos_sap.cod_art = material.mara_matkl
            Inner Join meta_art ON meta_art.mes = meta_art_coord.mes AND meta_art.ano = meta_art_coord.ano AND meta_art.co_art = meta_art_coord.co_art
            Inner Join authuser ON meta_art_coord.supervisor = authuser.uname
          WHERE
                   meta_art.ano =  '$ano' AND meta_art.mes = '$mes' ";
        
        if($supervisor) {	$sQuery.=" AND meta_art_coord.supervisor ='$supervisor' ";	}
        
        $sQuery.="  GROUP BY meta_art_coord.supervisor          
                    ORDER BY meta_art_coord.supervisor,meta_art_coord.co_art ";	
		//echo "<br>getMetCoordGrup:".$sQuery."<br>";
        //die();
        $result=mysql_query($sQuery) or die(mysql_error());
        $i=0;
        while($row=mysql_fetch_array($result)){
            foreach($row as $key=>$value){
                $res_array[$i][$key]=$value;
            }
            $i++;
        }
        return($res_array);
				
		}*/
function getMetCoord($ano='',$mes='',$co_coord='',$co_art=''){
    $sQuery="SELECT meta_art_coord.id, meta_art_coord.mes, meta_art_coord.ano, art.co_art, art.art_des, meta_art_coord.co_art, 
                        meta_art_coord.co_coord, meta_art_coord.asignada, meta_art_coord.actual 
                        FROM meta_art_coord 
                          Inner Join art ON art.co_art = meta_art_coord.co_art
                        WHERE meta_art_coord.mes ='".$mes."' AND  meta_art_coord.ano ='".$ano."' ";
        if($co_coord) {	$sQuery.=" AND meta_art_coord.co_coord ='$co_coord' ";	}
        if($co_art) {	$sQuery.=" AND meta_art_coord.co_art ='$co_art' ";	}
        $sQuery.=" ORDER BY meta_art_coord.co_coord, meta_art_coord.co_art ";
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
function getMetaArt($ano='',$mes='',$linea=''){
    $sQuery="SELECT art.co_art, art.art_des, meta_art.mes, meta_art.ano, meta_art.co_art, meta_art.existen
                 FROM
                    meta_art
                    Inner Join art ON art.co_art = meta_art.co_art 
                    WHERE meta_art.mes ='".$mes."' AND  meta_art.ano ='".$ano."' AND art.co_lin ='$linea' ";	
        $sQuery.=" ORDER BY meta_art.co_art ";
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
function getMetCoordGrup($ano='',$mes='',$supervisor=''){
    $sQuery=" SELECT usuario.usuario, usuario.nombre, usuario.supervisor 
                  FROM meta_art_coord
            Inner Join usuario ON meta_art_coord.co_coord = usuario.usuario
          WHERE meta_art_coord.ano =  '$ano' AND meta_art_coord.mes = '$mes' ";
        
        if($supervisor) {	$sQuery.=" AND meta_art_coord.co_coord ='$supervisor' ";	}
        
        $sQuery.="  GROUP BY meta_art_coord.co_coord          
                    ORDER BY meta_art_coord.co_coord,meta_art_coord.co_art ";
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

        /*function getMetCoord($ano='',$mes='',$supervisor='',$co_art=''){
		$sQuery="SELECT meta_art_coord.id, meta_art_coord.mes, meta_art_coord.ano, grupo_articulos_sap.cod_art, grupo_articulos_sap.descripcion_art, meta_art_coord.co_art, 
                        material.makt_makt,
                        meta_art_coord.supervisor, meta_art_coord.metaspasignadaC, meta_art_coord.metaspactualC, meta_art_coord.bolivares 
                        FROM meta_art_coord 
                          Inner Join material ON material.mara_matnr = meta_art_coord.co_art
                          Inner Join grupo_articulos_sap ON grupo_articulos_sap.cod_art = material.mara_matkl
                          Inner Join meta_art ON meta_art.mes = meta_art_coord.mes AND meta_art.ano = meta_art_coord.ano AND meta_art.co_art = meta_art_coord.co_art
                          
                        WHERE meta_art_coord.mes ='".$mes."' AND  meta_art_coord.ano ='".$ano."' ";
        if($supervisor) {	$sQuery.=" AND meta_art_coord.supervisor ='$supervisor' ";	}
        if($co_art) {	$sQuery.=" AND meta_art_coord.co_art ='$co_art' ";	}
        $sQuery.=" ORDER BY meta_art_coord.supervisor, meta_art_coord.co_art ";	
		//echo "<br>".$sQuery;
        $result=mysql_query($sQuery) or die(mysql_error());
        $i=0;
        while($row=mysql_fetch_array($result)){
            foreach($row as $key=>$value){
                $res_array[$i][$key]=$value;
            }
            $i++;
        }
        return($res_array);
				
		}*/

        //FUNCION ACTUALIZA LOS DATOS DE LA META ARTICULOS
	function udp_meta_art_coord($id,$piezas)
	{
		$query = "UPDATE meta_art_coord SET asignada = $piezas 
				  WHERE  id = '$id'";
		//echo "update coodinador".$query;
		$result=mysql_query($query);
		return $result;
	}
    	function get_metas_art($ano='',$mes=''){
		$sQuery="SELECT * FROM meta_art 
                WHERE ano = '$ano' AND mes = '$mes'";	
       // echo  $sQuery;
        
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
                         //DEVUELVE CANTIDAD DE VENDEDORES DE UNA COODINACION REGISTRADO EN LA META
        function getMetVendeGrupCantVende($ano='',$mes='',$supervisor='',$co_ven=''){
		$sQuery=" SELECT meta_art_vende.co_coord, meta_art_vende.co_ven 
                  FROM meta_art_vende
                       Inner Join meta_art_coord ON meta_art_vende.mes = meta_art_coord.mes AND meta_art_vende.ano = meta_art_coord.ano AND meta_art_vende.co_art = meta_art_coord.co_art
                        Inner Join meta_art ON meta_art_coord.mes = meta_art.mes AND meta_art_coord.ano = meta_art.ano AND meta_art_coord.co_art = meta_art.co_art
                  WHERE
                     meta_art_vende.co_coord <> '' AND
                    meta_art_vende.ano =  '$ano' AND meta_art_vende.mes = '$mes' ";
        
        if($supervisor) {	$sQuery.=" AND meta_art_vende.co_coord ='$supervisor' ";	}
	if($co_ven) {	$sQuery.=" AND meta_art_vende.co_ven ='$co_ven' ";	}
        
        $sQuery.="  GROUP BY meta_art_vende.co_ven          
                    ORDER BY meta_art_vende.co_coord,meta_art_vende.co_ven ";	
		//echo "<br>getMetVendeGrup:".$sQuery."<br>";
        //die();
        $result=mysql_query($sQuery) or die(mysql_error());
        $i=0;
        while($row=mysql_fetch_array($result)){
            foreach($row as $key=>$value){
                $res_array[$i][$key]=$value;
            }
            $i++;
        }
        return($res_array);
				
		}/*$sQuery="SELECT meta_art_vende.ano, meta_art_vende.mes, meta_art_vende.id, art.co_art, art.art_des, meta_art_vende.co_art, meta_art_coord.co_coord,
                  meta_art_coord.asignada, meta_art_vende.co_ven, meta_art_vende.asignada ,meta_art_vende.actual,
                  meta_art_vende.monto
                 FROM meta_art
                    Inner Join art ON  art.co_art=meta_art_vende.co_art art.co_art
                    Inner Join meta_art_coord ON meta_art_coord.mes = meta_art.mes AND meta_art_coord.ano = meta_art.ano AND meta_art_coord.co_art = meta_art.co_art
                    Inner Join meta_art_vende ON meta_art_vende.mes = meta_art_coord.mes AND meta_art_vende.ano = meta_art_coord.ano AND meta_art_vende.co_art = meta_art_coord.co_art AND meta_art_vende.co_coord = meta_art_coord.co_coord
           WHERE 1 = 1 ";
        if($id) {	$sQuery.=" AND meta_art_vende.id ='$id' ";	}
        if($ano) {	$sQuery.=" AND meta_art_vende.ano ='$ano' ";	}
        if($mes) {	$sQuery.=" AND meta_art_vende.mes ='$mes' ";	}
        if($co_ven) {	$sQuery.=" AND meta_art_vende.co_ven ='$co_ven' ";	}
        if($co_art) {	$sQuery.=" AND meta_art_vende.co_art ='$co_art' ";	}
        if($supervisor) {	$sQuery.=" AND meta_art_coord.co_coord ='$supervisor' ";	}
        $sQuery.=" ORDER BY meta_art_vende.co_coord,  meta_art_vende.co_ven, meta_art_vende.co_art ";*/
        
        
        function getMetVende($ano='',$mes='',$co_ven='',$co_art='',$supervisor='',$id=''){
            $sQuery="SELECT meta_art_vende.ano,meta_art_vende.mes,meta_art_vende.id,meta_art_vende.co_art,meta_art_coord.co_coord,meta_art_coord.asignada,
                meta_art_vende.co_ven,meta_art_vende.asignada,meta_art_vende.actual,art.co_art,art.art_des
                FROM art
                INNER JOIN meta_art ON meta_art.co_art = art.co_art
                INNER JOIN meta_art_coord ON meta_art_coord.mes = meta_art.mes AND meta_art_coord.ano = meta_art.ano AND meta_art_coord.co_art = meta_art.co_art
                INNER JOIN meta_art_vende ON meta_art_vende.mes = meta_art_coord.mes AND meta_art_vende.ano = meta_art_coord.ano AND meta_art_vende.co_art = meta_art_coord.co_art AND meta_art_vende.co_coord = meta_art_coord.co_coord
                WHERE 1=1 ";
        if($id) {	$sQuery.=" AND meta_art_vende.id ='$id' ";	}
        if($ano) {	$sQuery.=" AND meta_art_vende.ano ='$ano' ";	}
        if($mes) {	$sQuery.=" AND meta_art_vende.mes ='$mes' ";	}
        if($co_ven) {	$sQuery.=" AND meta_art_vende.co_ven ='$co_ven' ";	}
        if($co_art) {	$sQuery.=" AND meta_art_vende.co_art ='$co_art' ";	}
        if($supervisor) {	$sQuery.=" AND meta_art_coord.co_coord ='$supervisor' ";	}
        $sQuery.=" ORDER BY meta_art_vende.co_coord,  meta_art_vende.co_ven, meta_art_vende.co_art ";	
	//echo "<br>".$sQuery."<hr>";
//        die;
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
//        function getMetVende($ano='',$mes='',$co_ven='',$co_art='',$supervisor=''){
//		$sQuery="SELECT meta_art_vende.id,cat_art.co_cat, cat_art.cat_des, meta_art_vende.co_art, art.art_des, meta_art_coord.supervisor,
//                  meta_art_coord.metaspasignadaC, meta_art_vende.co_ven, meta_art_vende.metaspasignadaV ,meta_art_vende.metaspactualV,
//                  meta_art_vende.bolivares
//                 FROM art
//                    Inner Join cat_art ON art.co_cat = cat_art.co_cat
//                    Inner Join meta_art ON meta_art.co_art = art.co_art
//                    Inner Join meta_art_coord ON meta_art_coord.mes = meta_art.mes AND meta_art_coord.ano = meta_art.ano AND meta_art_coord.co_art = meta_art.co_art
//                    Inner Join meta_art_vende ON meta_art_vende.mes = meta_art_coord.mes AND meta_art_vende.ano = meta_art_coord.ano AND meta_art_vende.co_art = meta_art_coord.co_art AND meta_art_vende.supervisor = meta_art_coord.supervisor
//                 WHERE meta_art_vende.mes ='".$mes."' AND  meta_art_vende.ano ='".$ano."' ";
//        if($co_ven) {	$sQuery.=" AND meta_art_vende.co_ven ='$co_ven' ";	}
//        if($co_art) {	$sQuery.=" AND meta_art_vende.co_art ='$co_art' ";	}
//        if($supervisor) {	$sQuery.=" AND meta_art_coord.supervisor ='$supervisor' ";	}
//        $sQuery.=" ORDER BY meta_art_vende.supervisor,  meta_art_vende.co_ven, meta_art_vende.co_art ";	
//	//echo "<br>".$sQuery."<hr>";
////        die;
//        $result=mysql_query($sQuery) or die(mysql_error());
//        $i=0;
//        while($row=mysql_fetch_array($result)){
//            foreach($row as $key=>$value){
//                $res_array[$i][$key]=$value;
//            }
//            $i++;
//        }
//        return($res_array);
//		}
    //FUNCION ACTUALIZA LOS DATOS DE LA META ARTICULOS
	function udp_meta_art_vende($id,$piezas)
	{
		$query = "UPDATE meta_art_vende SET asignada = '$piezas' 
				  WHERE  id = '$id'";
		//echo "update vendedor".$query;
		$result=mysql_query($query);
		return $result;
	}
    
    
        	//FUNCION DE BUSQUEDA DEL METAS GROUP BY CAT
	function get_metas_categorias($co_ven='',$ano='', $mes='', $id_cat=''){
		$sQuery="SELECT meta_art_vende.co_ven, meta_art_vende.mes, meta_art_vende.ano, material.mara_matnr, SUM(meta_art_vende.metaspasignadaV) AS piezas
                  FROM meta_art_vende Inner Join material ON meta_art_vende.co_art = material.mara_matnr
                 GROUP BY material.mara_spart, meta_art_vende.ano, meta_art_vende.mes,meta_art_vende.co_ven
                 HAVING 1=1 ";

        if($co_ven) {	$sQuery.=" AND meta_art_vende.co_ven = '$co_ven' ";	}
        if($ano) {	$sQuery.=" AND meta_art_vende.ano ='$ano' ";	}
        if($mes) {	$sQuery.=" AND meta_art_vende.mes = '$mes' ";	}		
        if($id_cat) {	$sQuery.=" AND material.mara_spart = '$id_cat'";	}
       //echo($sQuery).'<br>';
       // die();
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
 
      	function getMetPedSumCat($lis_co_art='',$co_ven='',$co_cli='',$ano='',$mes='',$campo=''){
		$sQuery="SELECT
					SUM(reng_ped.$campo) AS sumaArt
					FROM
					pedidos
					Inner Join reng_ped ON pedidos.fact_num = reng_ped.fact_num
					WHERE 1=1";
		if($mes) {	$sQuery.=" AND MONTH (pedidos.fec_emis)='$mes' ";	}
		if($ano) {	$sQuery.=" AND YEAR (pedidos.fec_emis)='$ano'  ";	}
		if($lis_co_art) {	$sQuery.=" AND reng_ped.co_art IN ($lis_co_art) ";	}
		if($co_ven) {	$sQuery.=" AND pedidos.co_ven IN ('$co_ven') ";	}
		if($co_cli) {	$sQuery.=" AND pedidos.co_cli IN ('$co_cli') ";	}
		//die($sQuery);
			$result=mysql_query($sQuery) or die(mysql_error());
			$row=mysql_fetch_array($result);
			return($row['sumaArt']);
		}
        
        //METAS PPEDIDAS POR COORDINACION APUNTANDO A TABLA DE PEDIDOS 
        function getMetPedArtCoord($ano='',$mes='',$supervisor='',$co_art=''){
          $sQuery="SELECT Sum(reng_ped.total_art) AS sumaArt
                   FROM
                    pedidos
                    Inner Join reng_ped ON pedidos.fact_num = reng_ped.fact_num
                    Inner Join authuser ON authuser.uname = pedidos.co_ven
                   WHERE 1=1"; 
		if($mes) { $sQuery.=" AND MONTH (pedidos.fec_emis)='$mes' ";	}
		if($ano) { $sQuery.=" AND YEAR (pedidos.fec_emis)='$ano'  ";	}
        if($supervisor) { $sQuery.=" AND authuser.supervisor ='$supervisor'  ";	}
        if($co_art) { $sQuery.=" AND reng_ped.co_art='$co_art'  ";	}
		
        //echo "<br><br>".$sQuery."<br>";
        
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
    
}
?>


