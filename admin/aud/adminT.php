<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

$status=strip_tags($_GET['status']);
$nombre=$_SESSION["nombre"];
//$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>
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
            <div id="modal-pedido" class="modal fade" role="dialog">
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
    <?php require_once('../lib/php/common/menuA.php'); ?>

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
                            <?php 
                            $total = 0;
                            switch($status){
                                    case "r":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(2); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){
                                            $total+= $arr_pedidos[$i]['total_neto'];
                                             $fecha = date_format(date_create($arr_pedidos[$i]['fec_emis']),'d/m/Y');
                                         ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="text-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $fecha; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario']; ?></td>
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
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                                $total+= $arr_pedidos[$i]['total_neto'];
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num_p']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                   <td class="center">
                                                    
                                                    <b><span class="pull-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></span></b>

                                                    </td>
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
                                    case "l":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(6); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                                $total+= $arr_pedidos[$i]['total_neto'];
                                                 $fecha = date_format(date_create($arr_pedidos[$i]['fecha_anulado']),'d/m/Y');
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="text-center"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></td>
                                                <td class="center"><?php echo $fecha; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario_a']; ?></td>
                                                <td class="center">
                                                <button name="id" type="submit"   class="btn btn-primary btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>" onclick="ver_detalles_pedido(this.value)"><i class="fa fa-eye"></i> Ver</button>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "n":
                                        $arr_pedidos=$obj_pedidos->get_pedidos_cn(8); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){
                                                $total+= $arr_pedidos[$i]['total_neto'];
                                            ?> 
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['rif']."-".$arr_pedidos[$i]['nombre_emp']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                   <td class="center">
                                                    
                                                    <b><span class="pull-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></span></b>

                                                    </td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario']; ?></td>
                                                <td class="center">
                                                <form action="detallePedidoN.php" method="POST">
                                                    <input type="hidden" name="co_cli" value="<?php echo $arr_pedidos[$i]['rif']; ?>"/>
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    default:
                                        $arr_pedidos=$obj_pedidos->get_pedidos(); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                                $total+= $arr_pedidos[$i]['total_neto'];
                                                $fecha = date_format(date_create($arr_pedidos[$i]['fec_emis']),'d/m/Y');
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                 <td class="text-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></b>

                                                    </td>
                                                <td class="center"><?php echo  $fecha; ?></td>
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
                                        <tfoot>
                                          <tr>
                                            <th  colspan="3" style="text-align:right">Totales:</th>
                                            <th colspan="4" ><span style="float:left;"id ='Base'>0</span></th>                                
                                          </tr>
                                        </tfoot>
                                </table>
                            </div>
                            
                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
                <div class="col-md-12">
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
                                    echo "Historico de Pedidos";
                                break;
                            }
                            ?>                 </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table>
                                <tr class="lead">
                                    <td><b>Total: </b></td>
                                    <td>Bs. F: <b><?php echo number_format($total, 2, ",", "."); ?></b></td>
                               
                                </tr>
                            </table>
                            
                        </div>

                        <!-- /.panel-body -->

                    </div>

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
        
        $("#dataTables-example").DataTable( {
          responsive: true,
          "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;  
                           var intVal = function ( i ) {
                    return typeof i === 'string' ? i.replace(/[\$,\$.]/g, '')*1 : typeof i === 'number' ?  i : 0;
                };

                 Base = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
                             
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
          url: "../controlPedido.php?opcion=detPedidoAnulado",
          beforeSend: function() {
              
               $('#modal-pedido .modal-body').html('<div class="text-center"><img src="../../image/preload.gif" class="text-center"/></div>');
           },
            success: function(data){             
              
              $('#modal-pedido .modal-body').html(data);
              
            }
        });
        $("#modal-pedido").modal();  

    }
    </script>
</body>

</html>
