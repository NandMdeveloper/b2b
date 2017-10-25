<?php 
class class_usuario_tipo {

/*
TABLA	usuario_tipo
CAMPOS 	id,descripcion
*/
	
	
	function get_usuario_tipo($id=''){
		$sQuery="SELECT * FROM usuario_tipo WHERE 1 = 1 ";
		if($id) {	$sQuery.="AND id = '$id' ";	}
	//	echo $sQuery;
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
	
	function add_usuario_tipo($descripcion)
	{
		$query = "INSERT INTO usuario_tipo (descripcion) 
				  VALUES ('$descripcion')";
		$result=mysql_query($query);
		$new_pet_id = mysql_insert_id();
		return $new_pet_id;
	}
	
	
	function update_usuario_tipo($id,$descripcion)
	{
		$query = "UPDATE usuario_tipo SET descripcion='$descripcion' 
				  WHERE  id = '$id'";
		$result=mysql_query($query);
		return $result;
	}
	
	
	function delete_usuario_tipo($id)
	{
		$query = "DELETE FROM  usuario_tipo WHERE id = '$id'";
		$result=mysql_query($query);
	}
	
	
	
	
}
?>
