<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
$pedido=$_REQUEST["id"];

?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Detalle Pedidos - Telemarketing</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Agregar Productos al pedido # <?php echo $pedido; ?>
                        </div>
                        <!-- /.panel-heading -->
                            <div class="col-xs-12">
                                <form role="form" action="procesar.php" method="POST">
                                    <select id="productos" name="productos[]" class="selectpicker" data-size="6" data-live-search="true" title="Seleccione los productos..." data-style="btn-warning" data-width="100%" multiple required>
                                <?php
                                    $query5 = "SELECT art.co_art,art.art_des,art.monto,art.stock FROM art WHERE art.stock > 0";
                                    $result5 = @mysql_query($query5);
                                    while ($row5 = mysql_fetch_array($result5)) {
                                        echo '<option value="'.$row5["co_art"].'" data-subtext="'.$row5["monto"].' Bs.F. | Stock:'.$row5["stock"].' ">'.$row5["co_art"].' | '.$row5["art_des"].'</option>';
                                    }
                                ?>
                                    </select>
                                    <hr>
                                    <div class="col-xs-2">
                                    <input type="hidden" name="pedido" value="<?php echo $pedido; ?>" />
                                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-check-circle"></i> Procesar</button>
                                    </div>
                                    <div class="col-xs-2">
                                   <button type="button" class="btn btn btn-primary btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                                </div>
                                </form>
                            </div>
                    <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

        </div>
        <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../bower_components/raphael/raphael-min.js"></script>
    <script src="../../bower_components/morrisjs/morris.min.js"></script>
    <script src="../../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <script src="../../dist/js/bootstrap-select.js"></script>

</body>

</html>
