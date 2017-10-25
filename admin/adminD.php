<?php
require_once("seg.php");
require_once('funciones.php');
conectar();
$status=strip_tags($_GET['status']);
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('headD.php'); ?>

<body>

    <?php require_once('menuD.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php
                            switch($status){
                                case "c":
                                    echo "Pedidos Confirmados";
                                break;
                                case "d":
                                    echo "Pedidos Despachados";
                                break;
                                case "l":
                                    echo "Pedidos Anulados";
                                break;
                                default:
                                    echo "Historico de Pedidos";
                                break;
                            }
                            ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <?php
                                        switch($status){
                                            
                                            default:
                                                echo '<tr>
                                            <th>Número Pedido</th>
                                            <th>Cliente</th>
                                            <th>Monto Total</th>
                                            <th>Fecha Realizado</th>
                                            <th>Opciones</th>
                                            </tr>';
                                            break;
                                        }
                                        ?>
                                    </thead>
                                    <tbody>
                                        <?php
                                        switch($status){
                                            case "c":
                                                $query = "SELECT * FROM pedidos_tes WHERE status=1 AND confirmado=1 ORDER BY id_pedido DESC";
                                                $result = @mysql_query($query);
                                                while ($row = mysql_fetch_array($result)) {
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$row["id_pedido"].'</td>
                                                        <td>'.$row["cliente"].'</td>
                                                        <td class="center">'.number_format($row["total"], 2, ",", ".").'</td>
                                                            <td class="center">'.$row["fecha"].'</td>
                                                        <td class="center"><form action="detallePedD.php" method="POST">
                                                        <input type="hidden" name="co_cli" value="'.$row["co_cli"].'"/>
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$row["id_pedido"].'">Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "d":
                                                $query = "SELECT * FROM pedidos_tes WHERE status=2 ORDER BY id_pedido DESC";
                                                $result = @mysql_query($query);
                                                while ($row = mysql_fetch_array($result)) {
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$row["id_pedido"].'</td>
                                                        <td>'.$row["cliente"].'</td>
                                                        <td class="center">'.number_format($row["total"], 2, ",", ".").'</td>
                                                        <td class="center">'.$row["fecha"].'</td>
                                                        <td class="center"><form action="detallePD.php" method="POST"><button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$row["id_pedido"].'">Ver</button></form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "l":
                                                $query = "SELECT * FROM pedidos_tes WHERE status=3 ORDER BY id_pedido DESC";
                                                $result = @mysql_query($query);
                                                while ($row = mysql_fetch_array($result)) {
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$row["id_pedido"].'</td>
                                                        <td>'.$row["cliente"].'</td>
                                                        <td class="center">'.number_format($row["total"], 2, ",", ".").'</td>
                                                        <td class="center">'.$row["fecha"].'</td>
                                                        <td class="center"><form action="detallePD.php" method="POST"><button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$row["id_pedido"].'">Ver</button></form></td>
                                                        </tr>';
                                                }
                                            break;
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
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
    
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
</body>

</html>
