<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

$status=strip_tags($_GET['status']);
$pedido = $_REQUEST['id'];
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headT.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuT.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Detalle Pedidos - Crédito y Cobranza</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Detalle del Pedido # <?php echo $pedido; ?> </strong>
                        </div>
                        
                        <!-- .panel-heading -->
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                <?php
                                    /*$qr = 'SELECT archivo FROM archivo_pedidos where id_pedido='.$pedido;
                                    $rr = @mysql_query($qr);
                                    echo "<label>Comprobantes de Pago: </label>";
                                    while ($ror = mysql_fetch_array($rr)) {
                                        echo '<a href="../pages/'.$ror[0].'" target="_blank"><img src="../image/depositop.png" width="2%"/></a>';
                                    }*/
                                ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 text-center">
                                    <label>Producto</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Cantidad</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Precio</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Sub-Total</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Observaciones</label>
                                </div>
                            </div>
                            
                            <?php
                            $t=0;
                            $arr_dp=$obj_pedidos->get_ped_det($pedido); ?>
                            <?php for($i=0;$i<sizeof($arr_dp);$i++){ ?>
                                <div class="row list_pro_pedido_mod">
                                        <div class="col-xs-3"><input type="text" class="form-control text-center" value="<?php echo $arr_dp[$i]['co_art']."-".$arr_dp[$i]['art_des']; ?>" readonly/>
                                        <input type="hidden" name="codigo<?php echo $t; ?>" id="codigo<?php echo $t; ?>" value="<?php echo $arr_dp[$i]['co_art']; ?>"/>
                                        </div>
                                        <div class="col-xs-2"><input type="text" class="form-control text-right" value="<?php echo $arr_dp[$i]['total_art']." ".$arr_dp[$i]['UniCodPrincipal']; ?>" readonly/>
                                        <input type="hidden" name="cantidad<?php echo $t; ?>" id="cantidad<?php echo $t; ?>" value="<?php echo $arr_dp[$i]['total_art']; ?>"/>
                                        </div>
                                        <div class="col-xs-2"><input type="text" class="form-control text-right" value="<?php echo number_format($arr_dp[$i]['prec_vta'], 2, ",", "."); ?>" readonly/>
                                        <input type="hidden" name="precio<?php echo $t; ?>" id="precio<?php echo $t; ?>" value="<?php echo $arr_dp[$i]['prec_vta']; ?>"/>
                                        </div>
                                        <div class="col-xs-2"><input type="text" class="form-control text-right" value="<?php echo number_format($arr_dp[$i]['total_sub'], 2, ",", "."); ?>" readonly />
                                        <input type="hidden" id="subtotal<?php echo $t; ?>" name="subtotal<?php echo $t; ?>" value="<?php echo number_format($arr_dp[$i]['total_sub'], 2, ",", "."); ?>"/>
                                        </div>
                                        <div class="col-xs-3"><?php echo $arr_dp[$i]['des_art']; ?></div>
                                </div>
                            <?php
                            $t++; 
                            }
                            $arr_pedidos=$obj_pedidos->get_pedido($pedido);
                            for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                            <br>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input type="text" id="total" name="total" class="form-control" value="<?php echo number_format($arr_pedidos[$i]['total_bruto'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>IVA 12%:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="iva" name="iva" class="form-control" value="<?php echo number_format($arr_pedidos[$i]['monto_imp'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total Neto:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="totalN" name="totalN" class="form-control" value="<?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                            <hr>
                            <?php } ?>
                            <form role="form" action="anularPedT.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $pedido; ?>"/>
                            <div class="row">
                                <div class="col-xs-3 ">
                                   <label>Observaciones:</label>
                                </div>
                            </div>
                            <div class="row">
                            <textarea name="observaciones" class="form-control" rows="4" required></textarea>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-3 text-center">
                                   <a href="detallePedT.php?id=<?php echo $pedido; ?>"><button type="button" class="btn btn-primary btn-block">Regresar</button></a>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <button type="submit" class="btn btn-danger btn-block" >Anular Pedido</button>
                                </div>
                                
                            </div>
                            </form>
                        </div>
                        <!-- .panel-body -->
                        
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <script src='../js/funciones.js'></script>
</body>

    
</html>
