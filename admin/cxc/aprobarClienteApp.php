<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

$status=strip_tags($_GET['status']);
$co_cli=$_REQUEST["id"];
$_SESSION["co_cli"]=$co_cli;
$pedido=$_SESSION["pedido"];
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
function get_cli_new_d($co_cli){
    $sQuery="SELECT * FROM tmcustomernew WHERE CustCode ='$co_cli'";
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
$arr_cn=get_cli_new_d($co_cli);
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/headT.php'); ?>
<body>
<?php require_once('../lib/php/common/menuT.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Mantenimiento de Cliente - Crédito y Cobranza</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Detalles del Cliente: <?php echo $co_cli; ?></strong>
                        </div>
                        
                        <!-- .panel-heading -->
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3 text-center">
                                    <label>Codigo</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Nombre</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Direccion</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Telefono</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Correo</label>
                                </div>
                            </div>
                            
                            <form action="mod_client_app.php" method="POST">
                            <?php for($i=0;$i<sizeof($arr_cn);$i++){ ?>
                                <div class="row list_pro_pedido_mod">
                                        <div class="col-xs-3"><input type="text" name="co_cli" value="<?php echo $arr_cn[$i]['CustCode']; ?>"/></div>
                                        <div class="col-xs-2"><?php echo $arr_cn[$i]['CustDesc']; ?></div>
                                        <div class="col-xs-2"><?php echo $arr_cn[$i]['CustDirF']; ?></div>
                                        <div class="col-xs-2"><?php echo $arr_cn[$i]['CustTele']; ?></div>
                                        <div class="col-xs-3"><?php echo $arr_cn[$i]['CustEmail']; ?></div>
                                        <input type="hidden" name="co_cli_old" value="<?php echo $arr_cn[$i]['CustCode']; ?>"/>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-xs-3">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check-circle"></i> Enviar</button>
                                </div>
                                <div class="col-xs-3">
                                    <a href="detallePedidoNA.php?id=<?php echo $pedido; ?>&co_cli=<?php echo $co_cli; ?>"><button type="button" class="btn btn btn-primary btn-block"><i class="fa fa-reply"></i> Regresar</button></a>
                                </div>
                            </div>
                            
                        </div>
                        <!-- .panel-body -->
                        
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
        </div>
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <script src='../../js/funciones.js'></script>
</body>

    
</html>
