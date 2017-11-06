<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7')
	header('Location: ../lib/php/common/logout.php');
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

<?php require_once('../lib/php/common/headT.php'); ?>

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
 				               case "q":
                                    echo "Pedidos Clientes Nuevos App";
                                break;
                                case "p":
                                    echo "Pedidos App PowerSales";
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
                                case "r": ?>
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
                                    case "r":
                                        $arr_pedidos=$obj_pedidos->get_pedi(2); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td class="center"><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <!-- <td><?php //echo $arr_pedidos[$i]['cli_des']; ?></td>-->
                                                <td class="center"><span class="cliente-cxc btn btn-primary btn-xs"><?php echo $arr_pedidos[$i]['co_cli']; ?></span></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['descrip']; ?></td>
                                                <td class="center">
                                                <form action="detallePedT.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "p":
                                        $arr_pedidos=$obj_pedidos->get_ped_app(1); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['descrip']; ?></td>
                                                <td class="center">
                                                <form action="detallePedidoApp.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "a":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(3); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){
                                                $fecha = date_format(date_create($arr_pedidos[$i]['fec_emis']),'d/m/Y');
                                         ?>
                                            <tr>
                                                <td><?php echo $arr_pedidos[$i]['doc_num_p']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="text-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></td>
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
                                    case "e":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(1); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num_p']; ?></td>
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
                                    case "l":
                                        $arr_pedidos=$obj_pedidos->get_pedidos(6); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                            $fecha = date_format(date_create($arr_pedidos[$i]['fecha_anulado']),'d/m/Y');
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['cli_des']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></td>
                                                <td class="center"><?php echo $fecha; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario_a']; ?></td>
                                                <td class="center">
                                                <form action="detallePedido.php" method="POST">
                                                    <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    break;
                                    case "n":
                                        $arr_pedidos=$obj_pedidos->get_pedidos_cn(8); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ 
                                            $fecha = date_format(date_create($arr_pedidos[$i]['fec_emis']),'d/m/Y');
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><strong><?php echo $arr_pedidos[$i]['rif']." </strong>-".$arr_pedidos[$i]['nombre_emp']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="text-right"><?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?></td>
                                                <td class="center"><?php echo $fecha; ?></td>
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
					case "q":
                                        $arr_pedidos=$obj_pedidos->get_ped_new_cli_el(1); ?>
                                        <?php for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['co_cli']; ?></td>
                                                <td><?php echo $arr_pedidos[$i]['nombre']; ?></td>
                                                <td class="center">Bs. F: <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['fec_emis']; ?></td>
                                                <td class="center"><?php echo $arr_pedidos[$i]['comentario']; ?></td>
                                                <td class="center">
                                                <form action="detallePedidoNA.php" method="POST">
                                                    <input type="hidden" name="co_cli" value="<?php echo $arr_pedidos[$i]['co_cli']; ?>"/>
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
                                        <tfoot>
                                          <tr>
                                            <th colspan="3" style="text-align:right">Totales:</th>
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
                <!-- /.col-lg-12 -->
        </div>
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
     <script src="../../bower_components/calendario/jquery-ui.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
        <script src="../../bower_components/jQuery/jquery.number.js"></script>
    <script src="../../bower_components/fc.js"></script>
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


        $('.cliente-cxc').click(function() {
            var co_cli = $(this).text();
            
            $.ajax({
            data: {"co_cli" : co_cli },
            type: "POST",
            url: "../controlclientes.php?opcion=cxccliente",
                success: function(data){
                    $('#modal-cxc .modal-content').empty();
                    $('#modal-cxc .modal-content').append(data);
              }
        });
            $("#modal-cxc").modal()
        });





    });
    </script>
</body>

</html>
