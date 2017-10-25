<?php 
class class_vendedor {

/*
TABLA	vendedor
CAMPOS 	co_ven,descrip,campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8

co_ven		codigo identificador del vendedor
descrip		contiene el nombre
campo1		en algunos contiene el nombre de profit
campo2		campo de profit ALMACEN
campo3		campo de profit
campo4		campo de profit
campo5		campo de profit
campo6		campo de profit
campo7		campo de profit
campo8		campo de profit

*/

	//////////////////////////////////////////////////////////////////////////
	////////////////////////SELECTS SECTION///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	//FUNCION DE BUSQUEDA DEL VENDEDORES
	function get_vendedor($co_ven='',$team='',$supervisor=''){
		$sQuery="SELECT * FROM vendedor WHERE 1 = 1 ";
		if($co_ven) {	$sQuery.=" AND co_ven = '$co_ven' ";	}
		if($co_ven) {	$sQuery.=" AND co_ven = '$co_ven' ";	}
		if($supervisor) {	$sQuery.=" AND supervisor = '$supervisor' ";	}
		$sQuery.=" ORDER BY  descrip ";	
	//die($sQuery);
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
	function get_list_vendedor($id=''){
		$sQuery="SELECT
					vendedor.*,
					vendedor_tipo.descripcion AS utdescripcion
				FROM
					vendedor
					Inner Join vendedor_tipo ON vendedor.tipo = vendedor_tipo.id
				WHERE
					1 = 1
				";
	   if($id) {	$sQuery.="AND vendedor.id = '$id' ";	}
	   $sQuery.="ORDER BY
					vendedor_tipo.descripcion ASC,
					vendedor.nombre ASC ";


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
	
	function add_vendedor($nombre,$apellido,$login,$pass,$tipo,$status,$email)
	{
		$query = "INSERT INTO vendedor (nombre,apellido,login,pass,email,tipo,status) 
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
	function update_vendedor($id,$in_count)
	{
		$query = "UPDATE vendedor SET lastlogin = NOW() , logincount = '$in_count' 
				  WHERE  id = '$id'";
		//die($query);
		$result=mysql_query($query);
		return $result;
	}
	
	function update_clave_vendedor($id='',$pass='',$pass_old='')
	{
		$query = " UPDATE vendedor SET  pass='$pass' ";
		$query .= "  WHERE  id = '$id' AND pass='$pass_old'";
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
	
	function desactivar_vendedor($id)
	{
		$query = "UPDATE vendedor set status=0 WHERE id = $id'";
		$result=mysql_query($query);
		return $result;
	}
	function delete_vendedor($id)
	{
		$query = "DELETE FROM  vendedor WHERE id = '$id'";
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


