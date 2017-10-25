<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$id=$_REQUEST["codigo"];
$arr_dat=$obj_pedidos->get_dat($id);
$co_cli=$arr_dat[0]['co_cli'];
$cli_des=$arr_dat[0]['cli_des'];
$co_ven=$arr_dat[0]['co_ven'];
$ven_des=$arr_dat[0]['ven_des'];
$factura=$arr_dat[0]['factura'];
$ciudad=$arr_dat[0]['ciudad'];
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headD.php'); ?>
<body>
<?php require_once('../lib/php/common/menuD.php'); ?>
            <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos Despachados</h1>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Detalle Pedido
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="col-sm-3"><h5 class="box-title"><strong>Pedido <?php echo $id; ?></strong></h5></div>
              <div class="col-sm-4"><h5 class="box-title"><strong>Cliente: <?php echo $co_cli.'-'.utf8_encode($cli_des); ?></strong></h5></div>
              <div class="col-sm-2"><h5 class="box-title"><strong>Ciudad: <?php echo $ciudad; ?></strong></h5></div>
              <div class="col-sm-3"><h5 class="box-title"><strong>Vendedor: <?php echo $co_ven.'-'.$ven_des; ?></strong></h5></div>
                            <div class="dataTable_wrapper">
                                <form class="form-inline" action="aprobarRec.php" method="POST">
                                  <div class="row">
                                  <div class="col-xs-12">
                                    <div class="form-group">
                                      <label for="fecha">Fecha de Recibido: </label>
                                      <input type="date" name="fecha" class="form-control" value="<?php echo $as=date("d-m-Y"); ?>" required/>
                                      <label for="comentario">Comentario: </label>
                                      <input type="textarea" name="comentario" class="form-control" value="" required/>
                                    </div>
                                  </div>
                                  </div>
                                  <hr>
                                  <div class="col-xs-3">
                                      <button name="id" type="submit" class="btn btn-primary btn-block" value="<?php echo $id; ?>"><i class="fa fa-check-circle"></i> Enviar</button>
                                  </div>
                                  <div class="col-xs-3">
                                      <a href="detallePedidoDesD.php?id=<?php echo $id; ?>"><button type="button" class="btn btn btn-primary btn-block"><i class="fa fa-reply"></i> Regresar</button></a>
                                  </div>
                                </form>
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