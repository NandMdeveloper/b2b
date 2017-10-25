<?php
require_once("seg.php");
require_once('funciones.php');
conectar();
$status=strip_tags($_GET['status']);
$pedido = $_REQUEST['id'];
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('headT.php'); ?>

<body>

    <?php require_once('menuT.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Detalle Pedidos - Tesoreria</h1>
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
                                    $qr = 'SELECT archivo FROM archivo_pedidos where id_pedido='.$pedido;
                                    $rr = @mysql_query($qr);
                                    echo "<label>Comprobantes de Pago: </label>";
                                    while ($ror = mysql_fetch_array($rr)) {
                                        echo '<a href="../pages/'.$ror[0].'" target="_blank"><img src="../image/depositop.png" width="2%"/></a>';
                                    }
                                ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 text-center">
                                    <label>Código</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Precio</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Cantidad</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Sub-Total</label>
                                </div>
                                
                            </div>
                            
                            <?php
                            $t=0;
                            $q = 'SELECT * FROM reng_pedido where fact_num='.$pedido;
                            $r = @mysql_query($q);
                            while ($ro = mysql_fetch_array($r)) {
                                echo '<div class="row list_pro_pedido_mod">
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control text-center" name="codigo'.$t.'" id="codigo'.$t.'" value="'.$ro["co_art"].'" readonly/>
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" class="form-control text-right" name="precio'.$t.'" id="precio'.$t.'" value="'.number_format($ro["prec_vta"], 2, ",", ".").'" readonly/>
                                        </div>
                                        <div class="col-xs-3">';
                                        ?>
                                            <input type="text" name="<?php echo 'cantidad'.$t; ?>" class="form-control text-center" id="<?php echo 'cantidad'.$t; ?>" value="<?php echo $ro["total_art"]; ?>" readonly/>
                                        <?php
                                        echo '</div>
                                                <div id="sub" class="col-xs-3">';
                                        ?>
                                                    <input type="text" id="<?php echo 'subtotal'.$t; ?>" name="<?php echo 'subtotal'.$t; ?>" class="form-control text-right" value="<?php echo number_format($ro["reng_neto"], 2, ",", "."); ?>" readonly />
                                        <?php
                                        echo '</div></div>';
                                        $t++;
                            }
                            $q2 = 'SELECT * FROM pedidos where fact_num='.$pedido;
                            $r2 = @mysql_query($q2);
                            $ro2 = mysql_fetch_array($r2);
                            ?>
                            <hr>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input type="text" id="total" name="total" class="form-control" value="<?php echo number_format($ro2["tot_bruto"], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>IVA 12%:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="iva" name="iva" class="form-control" value="<?php echo number_format($ro2["iva"], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total Neto:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="totalN" name="totalN" class="form-control" value="<?php echo number_format($ro2["tot_neto"], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                            <hr>
                            <form role="form" action="aprobarPedT.php" method="POST">
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
                                   <a href="detallePedT.php?id=<?php echo $pedido; ?>"><button type="button" class="btn btn-info">Regresar</button></a>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <button type="submit" class="btn btn-success" >Aprobar Pedido</button>
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
