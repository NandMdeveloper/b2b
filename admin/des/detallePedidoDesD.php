<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$id=$_REQUEST["id"]; 
$_SESSION["pedido"]=$id;

$arr_dp=$obj_pedidos->get_pd_d($id);
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
                          <div class="col-sm-2"><h5 class="box-title"><strong>Pedido <?php echo $id; ?></strong></h5></div>
              <div class="col-sm-3"><h5 class="box-title"><strong>Cliente: <?php echo $co_cli.'-'.utf8_encode($cli_des); ?></strong></h5></div>
              <div class="col-sm-3"><h5 class="box-title"><strong>Ciudad: <?php echo $ciudad; ?></strong></h5></div>
              <div class="col-sm-4"><h5 class="box-title"><strong>Vendedor: <?php echo $co_ven.'-'.$ven_des; ?></strong></h5></div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                      <tr>
                                        <th>N°</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total-Neto</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<sizeof($arr_dp);$i++){ ?>
                                      <tr>
                                        <td><?php echo $arr_dp[$i]['reng_num']; ?></td>
                                        <td><?php echo $arr_dp[$i]['co_art']."-".utf8_encode($arr_dp[$i]['art_des']); ?></td>
                                        <td><?php echo $arr_dp[$i]['total_art']." ".$arr_dp[$i]['co_uni']; ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_dp[$i]['prec_vta'], 2, ",", "."); ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_dp[$i]['reng_neto'], 2, ",", "."); ?></td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <div class="col-xs-3">
                    <button name="id" type="button" class="btn btn-primary btn-block desp" data-id="<?php echo $id; ?>"><i class="fa fa-check-circle"></i> Entregado</button>
                </div>
                <div class="col-xs-3">
                                    <button type="button" class="btn btn-primary btn-block mod" data-id="<?php echo $id; ?>"><i class="fa fa-cog"></i> Modificar</button>
                                </div>
                <div class="col-xs-3">
                                    <button type="button" class="btn btn-primary btn-block anul" data-id="<?php echo $id; ?>"><i class="fa fa-ban"></i> Anular</button>
                                </div>
                <div class="col-xs-3">
                    <button type="button" class="btn btn btn-primary btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                </div>
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
    <script>
      $('.desp').on('click',function(){
    var id = $(this).data('id');
        eliminar=confirm("¿Procesar recibido por el cliente?");
        if (eliminar)
            window.location.href = "aprobarR.php?codigo="+id;
    });
</script>
<script>
      $('.anul').on('click',function(){
    var id = $(this).data('id');
        eliminar=confirm("¿Realmente desea anular este pedido?");
        if (eliminar)
            window.location.href = "anularR.php?id="+id;
    });
</script>
<script>
      $('.mod').on('click',function(){
    var id = $(this).data('id');
        eliminar=confirm("¿Realmente desea modificar este pedido?");
        if (eliminar)
            window.location.href = "modificarD.php?id="+id;
    });
</script>
</body>

</html>