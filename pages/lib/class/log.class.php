<?php 
class class_log {
    function add_log($fecha,$user,$accion){
	$query = "INSERT INTO log_data_pow (id,fecha,user,accion)";
	$query .= "  VALUES (NULL,'$fecha','$user','$accion')";
	$res=mysql_query($query);
        return $res;
    }
}
?>


