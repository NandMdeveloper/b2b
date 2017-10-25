<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

$status=strip_tags($_GET['status']);
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/headE.php'); ?>
<body>
<?php require_once('../lib/php/common/menuE.php'); ?>
    <div id="content">
        <div class="col-lg-12">
            <h1 class="page-header">Pedidos</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <?php switch($status){
                    case "e":
                        echo "Pedidos en Espera";
                    break;
                    case "r":
                        echo "Pedidos Pre-Aprobados";
                    break;
                    case "a":
                        echo "Pedidos Aprobados";
                    break;
                    case "c":
                        echo "Pedidos Confirmados";
                    break;
                    case "d":
                        echo "Pedidos Despachados";
                    break;
                    case "l":
                        echo "Pedidos Anulados";
                    break;
                    case "v":
                        echo "Pedidos Eventuales";
                    break;
                    default:
                        echo "Historico de Pedidos";
                    break;
                } ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <?php switch($status){
                                default: ?>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Monto Total</th>
                                        <th>Fecha Realizado</th>
                                        <th>Opciones</th>         
                                    </tr>
                                <?php break;
                            } ?>
                            </thead>
                            <tbody>
                                <?php switch($status){
                                    case "e":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(1); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "r":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(2); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "a":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(3); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "c":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(4); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "d":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(5); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "l":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(6); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "v":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(7); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    default:
                                        $arr_pedidos=$obj_pedidos->get_pedidos(); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                } ?>
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
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

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
