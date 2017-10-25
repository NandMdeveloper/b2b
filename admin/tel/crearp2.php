<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();

$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Crear Pedido</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <form role="form" id='Form' name="Form" action="procesarP.php" method="POST">
                        <!-- /.panel-heading -->
                        <div class="row">
                            <div class="col-xs-12"><h3>Clientes: </h3>
                                <select id="cliente" name="cliente" class="selectpicker" data-size="6" data-live-search="true" title="Seleccione Cliente..." data-style="btn-warning" data-width="100%" required>
                                    <optgroup label="Regulares">
                                <?php
                                    $query5 = "SELECT clientes.co_cli,clientes.cli_des FROM clientes WHERE 1 = 1";
                                    $result5 = @mysql_query($query5);
                                    while ($row5 = mysql_fetch_array($result5)) {
                                        echo '<option value="'.$row5["co_cli"].'">'.$row5["cli_des"].'</option>';
                                    }
                                ?>
                                    </optgroup>
                                    <optgroup label="Nuevos">
                                <?php
                                    $query6 = "SELECT cliente_evento.rif,cliente_evento.nombre_emp FROM cliente_evento WHERE 1 = 1";
                                    $result6 = @mysql_query($query6);
                                    while ($row6 = mysql_fetch_array($result6)) {
                                        echo '<option value="'.$row6["rif"].'">'.$row6["nombre_emp"].'</option>';
                                    }
                                ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-xs-12"><h3>Productos: </h3>
                                <select id="productos" name="productos[]" class="selectpicker" data-size="6" data-live-search="true" title="Seleccione los productos..." data-style="btn-warning" data-width="100%" multiple required>
                                <?php
                                    $query7 = "SELECT art.co_art,art.art_des,art.monto,art.stock FROM art WHERE art.stock > 0";
                                    $result7 = @mysql_query($query7);
                                    while ($row7 = mysql_fetch_array($result7)) {
                                        echo '<option value="'.$row7["co_art"].'" data-subtext="'.$row7["monto"].' Bs.F. | Stock:'.$row7["stock"].' ">'.$row7["co_art"].' | '.$row7["art_des"].'</option>';
                                    }
                                ?>
                                    </select>
                                    <hr>
                                    <div class="col-xs-6 col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check-circle"></i> Procesar</button>
                                    </div>
                                    <div class="col-xs-6 col-sm-2">
                                    <button type="button" class="btn btn btn-info btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                                    </div>
                            </div>
                    <!-- /.panel -->
                    </div>
                </form>
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
