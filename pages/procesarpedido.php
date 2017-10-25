<?php
require_once("seg.php");
require_once('funciones.php');
conectar();

$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$lista_precio=$_SESSION["lista_precio"];
$co_ven=$_SESSION["co_ven"];
$hora=date('H:i:s');
$fecha=date('Y-m-d');
if(!empty($_POST['productos'])){
$query="INSERT INTO pedidos (fact_num,co_cli,fec_emis,descrip,co_ven,hora,co_sucu,origen,tipo_pedido) VALUES (default,'".$co_cli."','".$fecha."','0','".$co_cli."','$hora','01','w','ZP02')";
$result = @mysql_query($query);
$ult_id=mysql_insert_id();
if($result){
    $sql = "INSERT INTO pedidos_tes (id,id_pedido,co_cli,cliente,co_ven,fecha,fecha_dis,status,fecha_des) VALUES (NULL,'".$ult_id."','".$co_cli."','".$nombre."','".$co_cli."','".$fecha."',NULL,'0',NULL);";
    $r = @mysql_query($sql);
    $i=0;
    foreach($_POST['productos'] as $producto){
        $query2 = "SELECT KONP_KBETR FROM pre_listaprecio WHERE A501_MATNR='".$producto."';";
        $result2 = @mysql_query($query2);
        $row = mysql_fetch_array($result2);
        $consulta_treng_ped="INSERT INTO treng_ped (fact_num,co_art,prec_vta,reng_num,co_alma) VALUES ('".$ult_id."','".$producto."','".$row["KONP_KBETR"]."','".($i+1)."','NPT');";
        $consulta_reng_ped="INSERT INTO reng_ped (fact_num,co_art,prec_vta,reng_num,co_alma) VALUES ('".$ult_id."','".$producto."','".$row["KONP_KBETR"]."','".($i+1)."','NPT');";
        $consulta_reng_pedido="INSERT INTO reng_pedido (fact_num,co_art,prec_vta,reng_num,co_alma,status) VALUES ('".$ult_id."','".$producto."','".$row["KONP_KBETR"]."','".($i+1)."','NPT','0');";
        $re = @mysql_query($consulta_treng_ped);
        $res = @mysql_query($consulta_reng_ped);
        $resp = @mysql_query($consulta_reng_pedido);
        $i++;
    }
    $a="jrodriguez@cyberlux.com.ve";
    $asunto="Nuevo Pedido Web Distribuidor";
    $mensaje = "
	<h2>Nuevo Pedido Web del Distribuidor ".$nombre."</h2><br>
	<br>
	<table border='1' cellspacing='3' cellpadding='2'>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Nombre del Distribuidor:</strong></td>
			<td width='80%' align='left'>".$nombre."</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Código Distribuidor:</strong></td>
			<td width='80%' align='left'>".$co_cli."</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Pedido Web Número:</strong></td>
			<td width='80%' align='left'>".$ult_id."</td>
		  </tr>
	</table>
	";
    $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
    $headers .= "X-Mailer: PHP5\n";
    $headers .= 'MIME-Version: 1.0' . "\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
    $bool=mail($a, $asunto, $mensaje, $headers);
    if($bool){
        
    }else{
        
    }
    ?>
       <script type="text/javascript">alert("Su pedido ha sido creado exitosamente...");window.location="pedidosDistribuidor.php?status=e";</script>
    <?php
}else{
    ?>                
       <script type="text/javascript">alert("Ocurrio un problema al crear su pedido, intentelo  nuevamente...");window.location="procesarcar.php";</script>
    <?php
}
}else{
    ?>                
       <script type="text/javascript">alert("Los campos estan vacios, intentelo nuevamente...");window.location="procesarcar.php";</script>
    <?php
}
?>
