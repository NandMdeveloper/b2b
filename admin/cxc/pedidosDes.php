<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$arr_pedidos=$obj_pedidos->get_ped_sql();

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headT.php'); ?>
<style>
  .modal-cxc{
  width: auto !important;
   width: 1600px !important;
  margin: 10px;
  }
  .modal-dialog {
    width: 1011px;
    margin: 30px auto;
}
  
</style>
<body>

    <?php require_once('../lib/php/common/menuT.php'); ?>

        <div id="content">
                          <div id="modal-cxc" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                         </div>

                    </div>
                  </div>
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos
                      <small>para aprobar a facturar</small> 
                      <a href="../excelporfacturar.php" class="fa fa-file-excel-o excel text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a></h1>

                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Aprobar Facturacion
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
                                    <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                      $sq="SELECT doc_num FROM pedidos_des WHERE doc_num=".$arr_pedidos[$i]['doc_num'];
                                      $fecha = date_format(date_create($arr_pedidos[$i]['fec_emis']->format('Y-m-d H:m:s')),'d/m/Y');
                                      $result=mysql_query($sq);
                                      $a=mysql_num_rows($result);
                                      if($a==0){ ?>
                                        <tr class="odd gradeX">
                                          <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                          <td class="text-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></td>
                                          <td> <span class="cliente-cxc btn btn-primary btn-xs"><?php echo $arr_pedidos[$i]['co_cli']; ?></span></td>
                                          <td><?php echo $arr_pedidos[$i]['co_ven']."-".$arr_pedidos[$i]['cli_des']; ?></td>
                                          <td><?php echo  $fecha; ?></td>
                                          <td><?php echo  utf8_encode($arr_pedidos[$i]['descrip']); ?></td>
                                          <td class="center">
                                            <form action="detallePedidoDes.php" method="POST">
                                              <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                            </form>
                                          </td>
                                        </tr>
                                      <?php }
                                    } ?>
                                    </tbody>
                                         <tfoot>
                                          <tr>
                                            <th style="text-align:right">Totales:</th>
                                            <th colspan="6" ><span style="float:left;"id ='Base'>0</span></th>
                                
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
        <script src="../../js/fc.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
    $("#dataTables-example").DataTable(
    {
      responsive: true,
      "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;  
                       var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$,\$.]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };

             Base = api.column( 1, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                         
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
    </script>
</body>

</html>
