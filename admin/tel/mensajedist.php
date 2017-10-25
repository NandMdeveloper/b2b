<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
$para=strip_tags($_GET['para']);
$_SESSION["para"] = $para;
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
                    <h1 class="page-header">Mensajeria</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php
                            switch($para){
                                case "t":
                                    echo "Mensaje para el Departamento de Tesoreria";
                                break;
                                case "c":
                                    echo "Mensaje para el Departamento de Contabilidad";
                                break;
                                case "d":
                                    echo "Mensaje para el Departamento de Despacho";
                                break;
                                case "s":
                                    echo "Mensaje para el Departamento de Sistemas";
                                break;
                            }
                            ?>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <form role="form" action="enviandomensaje.php" method="POST">
                                <label>Asunto:</label>
                                <input type="text" name="asunto" class="form-control" id="asunto" placeholder="Escribe el asunto de tu mensaje..." required>
                                <label>Mensaje:</label>
                                <textarea name="mensaje" class="form-control" rows="6" required></textarea>
                                <button type="submit" class="btn btn-default">Enviar Mensaje</button>
                                <button type="reset" class="btn btn-default">Limpiar</button>
                            </form>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            
            <!-- /.row -->
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
    
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    
</body>

</html>
