<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$arr_pedidos=$obj_pedidos->get_ped_desp_D();

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headD.php'); ?>

    <body>
    <div id="modal-cxc" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detalles de Pedido</h4>        
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>

    </div>
  </div>
    <?php require_once('../lib/php/common/menuT.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos
                      <small>Despachados</small></h1>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Pedidos Despachados
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                      <tr>
                                        <th>Id</th>
                                        <th>Factura</th>
                                        <th>Total Neto</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Fecha</th>
                                        <th>Observaciones</th>
                                        <th>Opciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                            $fecha = date_format(date_create($arr_pedidos[$i]['fecha_despacho']),'d/m/Y');
                                        ?>
                                      <tr class="odd gradeX">
                                        <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                        <td><?php echo $arr_pedidos[$i]['factura']; ?></td>
                                        <td><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></td>
                                        <td><?php echo $arr_pedidos[$i]['co_cli'].'-'.$arr_pedidos[$i]['cli_des']; ?></td>
                                        <td><?php echo $arr_pedidos[$i]['co_ven'].'-'.$arr_pedidos[$i]['ven_des']; ?></td>
                                        <td><?php echo $fecha; ?></td>
                                        <td><?php echo  utf8_encode($arr_pedidos[$i]['descrip']); ?></td>
                                        <td class="center">
                                          <button name="id" type="submit"   class="btn btn-primary btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>" onclick="ver_detalles_pedido(this.value)"><i class="fa fa-eye"></i> Ver</button>
                                        </td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                                                          <tfoot>
                                          <tr>
                                            <th  colspan="2" style="text-align:right">Totales:</th>
                                            <th colspan="5" ><span style="float:left;"id ='Base'>0</span></th>
                                
                                          </tr>
                                          </tfoot>
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
                    responsive: true,
                    scrollX: true,
                    aLengthMenu: [
            [50,100,150,-1],
            [50,100,150,"Todo"]
          ],       
          "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;  
                           var intVal = function ( i ) {
                    return typeof i === 'string' ? i.replace(/[\$,\$.]/g, '')*1 : typeof i === 'number' ?  i : 0;
                };

                 Base = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                             
                Number.prototype.formatMoney = function(c, d, t){
                var n = this, 
                    c = isNaN(c = Math.abs(c)) ? 2 : c, 
                    d = d == undefined ? "." : d, 
                    t = t == undefined ? "," : t, 
                    s = n < 0 ? "-" : "", 
                    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
                    j = (j = i.length) > 3 ? j % 3 : 0;
                   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
                 };
                  Base = parseFloat(Math.round(Base) / 100);
                   $('#Base').html(Base.formatMoney(2,'.',','));
            }
        });
    });
      function ver_detalles_pedido(documento) {
                  
            $.ajax({
              data: {"documento" : documento},
              type: "POST",
              url: "../controlPedido.php?opcion=detPedidoDetalle",
              beforeSend: function() {
                  
                   $('#modal-cxc .modal-body').html('<div class="text-center"><img src="../../image/preload.gif" class="text-center"/></div>');
               },
                success: function(data){             
                  
                  $('#modal-cxc .modal-body').html(data);
                  
                }
            });
            $("#modal-cxc").modal();  

        }
    </script>
</body>

</html>