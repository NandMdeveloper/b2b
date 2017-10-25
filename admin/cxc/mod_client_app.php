<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();

$co_cli=$_REQUEST["co_cli"];
$co_cli_old=$_REQUEST["co_cli_old"];
$id_cli=$_SESSION["co_cli"];

$q="SELECT * FROM clientes WHERE co_cli='".$co_cli."'";
$t=@mysql_query($q) or die(mysql_error());
$roc = mysql_fetch_array($t);
if(!empty($roc)){
    $query="UPDATE tmcustomernew SET CustCode='".$co_cli_old."-".$co_cli."', CustCode=1 WHERE CustCode='$id_cli'";
    @mysql_query($query) or die(mysql_error());
    $query2="UPDATE pedidos_app SET co_cli='$co_cli', status=1 WHERE co_cli='$co_cli_old'";
    @mysql_query($query2) or die(mysql_error());
    echo '<script type="text/javascript">window.location="adminT.php?status=r";</script>';
}else{
    echo '<script type="text/javascript">alert("Cliente no esta Creado en Profit...");window.location="aprobarCliente.php?id='.$id_cli.'";</script>';
}
?>
