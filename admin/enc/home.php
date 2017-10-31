<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='2') header('Location: ../lib/php/common/logout.php');
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

<?php require_once('../lib/php/common/headC.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuG.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos</h1>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php
                            switch($status){
                                case "n":
                                    echo "Pedidos Clientes Nuevos";
                                break;
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
                                default:
                                    echo "Pedidos en Espera";
                                break;
                            }
                            ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <?php switch($status){
                                case "l": ?>
                                    <tr>
                                        <th>N°</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Total</th>
                                        <th>Fecha Anulado</th>
                                        <th>Comentario</th>
                                        <th>Opciones</th>         
                                    </tr>
                                <?php break;
                                case "e": ?>
                                    <tr>
                                        <th>N°</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th>Comentario</th>
                                        <th>Opciones</th>         
                                    </tr>
                                <?php break;
                                case "n": ?>
                                    <tr>
                                        <th>N°</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th>Comentario</th>
                                        <th>Opciones</th>         
                                    </tr>
                                <?php break;
                                default: ?>
                                    <tr>
                                        <th>N°</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th>Comentario</th>
                                        <th>Opciones</th>         
                                    </tr>
                                <?php break;
                            } ?>
                            </thead>
                            <tbody>
                            <?php switch($status){
                                    case "e":
                                        $arr_pedidos=$obj_pedidos->get_ped_app(9,$user); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['descrip']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "r":
                                        $arr_pedidos=$obj_pedidos->get_ped_c(2,$user); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['descrip']; ?></td>
                                                <td class="center">
                                                <form action="detallePedidoP.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "a":
                                        $arr_pedidos=$obj_pedidos->get_ped_c(3,$user); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num_p']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario']; ?></td>
                                                <td class="center">
                                                <form action="detallePedidoP.php" method="POST">
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
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fecha_anulado']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario_a']; ?></td>
                                                <td class="center">
                                                <form action="detallePedidoP.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "n":
                                        $arr_pedidos=$obj_pedidos->get_ped_new_cli_c(1,$user); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['co_cli']."-".$arr_pedidos[$i]['descrip']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <input type="hidden" name="co_cli" value="<?php echo $arr_pedidos[$i]['rif']; ?>"/>
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    default:
                                        $arr_pedidos=$obj_pedidos->get_ped_app(1,$user); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario']; ?></td>
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
