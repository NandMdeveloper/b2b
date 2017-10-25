<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
if($_POST){
    $grupo=$_SESSION['grupo'];
    $co_art=$_POST['co_art'];
    $co_cli=$_SESSION["co_cli"];
    $fecha=date('Y-m-d');
    
    $qc = "SELECT * FROM reng_pedido_temp WHERE co_cli='$co_cli' AND co_art='$co_art';";
    $rc = @mysql_query($qc);
    $roc = mysql_fetch_array($rc);
    if(!empty($roc)){
        ?>
        <script type="text/javascript">alert("El producto ya fue seleccionado anteriormente...");window.location='inventariodetalle.php?grupo=<?php echo $grupo; ?>';</script>
        <?php
    }else{
        $sql="INSERT INTO reng_pedido_temp (co_cli, co_art, fecha) VALUES ('$co_cli', '$co_art', '$fecha');";
        $result=@mysql_query($sql);
        ?>
        <script type="text/javascript">window.location='inventariodetalle.php?grupo=<?php echo $grupo; ?>';</script>
        <?php
    }
}else{
    ?>
    <script type="text/javascript">alert("No se recibió ningun producto para agregar...");window.location='inventariodetalle.php?grupo=<?php echo $grupo; ?>';</script>
    <?php
}

?>
