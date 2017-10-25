<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='3') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$arr_pedidos=$obj_pedidos->get_ped_desp();

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headC.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuC.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos
                      <small>en Pre-Despacho</small></h1>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Pedidos En Pre-Despacho
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                      <tr>
                                        <th>Id</th>
                                        <th>Total Neto</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Fecha</th>
                                        <th>Observaciones</th>
                                        <th>Opciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                      <tr class="odd gradeX">
                                        <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                        <td><?php echo $arr_pedidos[$i]['co_cli'].'-'.utf8_encode($arr_pedidos[$i]['cli_des']); ?></td>
                                        <td><?php echo $arr_pedidos[$i]['co_ven'].'-'.$arr_pedidos[$i]['ven_des']; ?></td>
                                        <td><?php echo $arr_pedidos[$i]['fecha_aprobado']; ?></td>
                                        <td><?php echo  utf8_encode($arr_pedidos[$i]['descrip']); ?></td>
                                        <td class="center">
                                          <form action="detallePedidoDesA.php" method="POST">
                                            <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                          </form>
                                        </td>
                                      </tr>
                                    <?php } ?>
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
