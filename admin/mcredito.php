<?php
require_once("seg.php");
require_once('funciones.php');
conectar();
$id=$_POST["id"];

$sql="UPDATE creditos_bloqueo SET status='0' WHERE id=$id";
$result = @mysql_query($sql);
if($result){
    ?>                
       <script type="text/javascript">window.location="creditos.php";</script>
    <?php
}else{
    ?>                
       <script type="text/javascript">alert("Ocurió un error al reactivar crédito...");window.location="creditos.php";</script>
    <?php
}

?>
