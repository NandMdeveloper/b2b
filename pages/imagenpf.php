<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
$pedido = $_SESSION["pedido"];
$fecha_a=  date('Y-m-dHis');
$tipo=implode(" - ",$_POST["tipo"]);

$i=0;
if(isset($_FILES['archivo'])){
    foreach ($_FILES['archivo']['error'] as $key => $error){
        if ($error == UPLOAD_ERR_OK) {
            $ruta = "images/pedidos/".$fecha_a.$_FILES['archivo']['name'][$i];
            move_uploaded_file($_FILES['archivo']['tmp_name'][$i],$ruta) or die("Ocurrio un problema al intentar subir el archivo.");
            $insert=("INSERT INTO archivo_pedidos (id, id_pedido, archivo) VALUES (NULL, $pedido, '$ruta')");
            $sql=@mysql_query($insert);
        }
        $i++;
    }
    $sql="INSERT INTO pedidos_condp (id,doc_num,cond_pago) VALUES (NULL,'$pedido','$tipo')";
    mysql_query($sql) or die(mysql_error());
}
?>
    <script type="text/javascript">
        window.location="pedidos.php?status=r";
    </script>
<?php
?>