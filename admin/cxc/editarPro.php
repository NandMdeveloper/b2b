<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();

$id_art=$_REQUEST["codigo"];
$id=$_SESSION["pedido"];

$sql="SELECT pedidos_detalles.total_art, pedidos_detalles.prec_vta, art.art_des 
    FROM pedidos_detalles INNER JOIN art ON pedidos_detalles.co_art = art.co_art
    WHERE pedidos_detalles.id = $id_art";
$result=mysql_query($sql);
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
                            <strong>Modificando cantidad del producto <?php echo $art; ?> del pedido # <?php echo $id; ?></strong>
                        </div>
                        
                        <!-- .panel-heading -->
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <label>Producto</label>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <label>Precio</label>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <label>Cantidad</label>
                                </div>
                            </div>
                            <form role="form" action="editandoPro.php" method="POST">
                            <div class="row">
                            <?php while($row=mysql_fetch_array($result)){ ?>
                                <div class="col-xs-4 text-center">
                                    <input type="text" class="form-control" value="<?php echo $row['art_des']; ?>" readonly/>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <input type="text" class="form-control" value="Bs. F: <?php echo number_format($row['prec_vta'], 2, ",", "."); ?>" readonly/>
                                    
                                </div>
                                <div class="col-xs-4 text-center">
                                    <input type="text" id="total" name="total_art" class="form-control" value="<?php echo $row['total_art']; ?>" />
                                </div>
                                <input type="hidden" name="idArt" value="<?php echo $id_art; ?>"/>
                                <input type="hidden" name="precio" value="<?php echo $row['prec_vta']; ?>"/>
                                <input type="hidden" name="coArt" value="<?php echo $row['co_art']; ?>"/>
                                <input type="hidden" name="oldCant" value="<?php echo $row['total_art']; ?>"/>
                            <?php } ?>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-3 text-center">
                                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check-circle"></i> Aceptar</button>
                                </div>
                                <div class="col-xs-3 text-center">
                                   <button type="button" class="btn btn btn-primary btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
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
