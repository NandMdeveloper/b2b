<?php
require_once("seg.php");
require_once('funciones.php');
conectar();
$co_cli=$_SESSION["co_cli"];
$codigo=$_REQUEST["codigo"];
$sql="DELETE FROM reng_pedido_temp WHERE co_art='$codigo' AND co_cli='$co_cli'";
$resp=@mysql_query($sql);
if($resp){
        ?>
        <script type="text/javascript">window.location='procesarcar.php';</script>
        <?php
}else{
        ?>
        <script type="text/javascript">alert("Ha ocurrido un error, intente eliminar el producto nuevamente por favor...");window.location='procesarcar.php';</script>
        <?php
}
?>
