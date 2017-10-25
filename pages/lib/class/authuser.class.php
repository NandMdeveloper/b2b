<?php 
class class_authuser {

/*
TABLA	usuario
CAMPOS 	

id			identificados de los usuarios
uname		nombre del  usuario
passwd		clave o pasword de el usuario
team		equipo cosa que no se esta usando
level		level onivel del usuario esto tampoco se esta usando
status		status de actividad o nulidad del usuario esta mal usado
lastlogin	ultimo login
logincount	es un contados de visitas de este usuario
tipo
supervisor

*/

	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	
	
	//FUNCION DE BUSQUEDA DEL USUARIO MAS QUE TODO ESTE ES PARA LOS LOGEOS
	function get_authuser($uname='',$passwd='',$team='',$id='',$status='',$tipo='',$supervisor=''){
		
		$sQuery="SELECT * FROM usuario WHERE 1 = 1 ";
		if($id) {	$sQuery.=" AND id = '$id' ";	}
		if($status) {	$sQuery.=" AND status = '$status' ";	}
		if($uname) {	$sQuery.=" AND usuario = '$uname' ";	}
		if($passwd) { $passwd=md5($passwd);	$sQuery.=" AND clave = '$passwd' ";}
		if($tipo) {	$sQuery.=" AND tipo IN ($tipo) ";	}
		if($team) {	$sQuery.=" AND equipo IN ($team) ";	}
		if($supervisor) {	$sQuery.=" AND supervisor IN ($supervisor) ";	}
		$sQuery.="ORDER BY usuario";

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
	
	

	//LISTADO DE USUARIOS Y DATOS ADICIONALES
	function get_list_authuser($id=''){
		$sQuery="SELECT
					authuser.*,
					authuser_tipo.descripcion AS utdescripcion
				FROM
					authuser
					Inner Join authuser_tipo ON authuser.tipo = authuser_tipo.id
				WHERE
					1 = 1
				";
	   if($id) {	$sQuery.="AND authuser.id = '$id' ";	}
	   $sQuery.="ORDER BY
					authuser_tipo.descripcion ASC,
					authuser.nombre ASC ";


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


