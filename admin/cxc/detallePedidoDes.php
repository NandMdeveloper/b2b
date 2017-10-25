<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
//require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
//conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$id=$_REQUEST["id"]; 
$_SESSION["pedido"]=$id;

$arr_detalles_pedido=$obj_pedidos->get_ped_det_sql($id);
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headT.php'); ?>
<body>
<?php require_once('../lib/php/common/menuT.php'); ?>
            <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Aprobar Facturacion</h1>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Detalle Pedido
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                      <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total-Neto</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<sizeof($arr_detalles_pedido);$i++){ ?>
                                      <tr>
                                        <td><?php echo $arr_detalles_pedido[$i]['co_art']."-".utf8_encode($arr_detalles_pedido[$i]['art_des']); ?></td>
                                        <td><?php echo number_format($arr_detalles_pedido[$i]['total_art'])." ".$arr_detalles_pedido[$i]['co_uni']; ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_detalles_pedido[$i]['prec_vta'], 2, ",", "."); ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_detalles_pedido[$i]['reng_neto'], 2, ",", "."); ?></td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <div class="col-xs-3">
                                  <button name="id" type="button" class="btn btn-primary btn-block desp" data-id="<?php echo $id; ?>"><i class="fa fa-check-circle"></i> Aprobar Despacho</button>
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
      $('.desp').on('click',function(){
  var id = $(this).data('id');
        eliminar=confirm("¿Realmente desea aprobar a despacho este pedido?");
        if (eliminar)
            window.location.href = "aprobarDes.php?codigo="+id;
    });
</script>
</body>

</html>