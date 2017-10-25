<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Reporte de Ventas por Productos</h1>
                </div>
                <!-- /.col-lg-12 -->
            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Cantidad Vendida</th>
                                            <th>Monto Total</th>
                                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                $query = "SELECT mara_matnr FROM material";
                                                $result2 = @mysql_query($query);
                                                $rows=mysql_num_rows($result2);
                                                for($j=0;$j<=$rows;$j++){
                                                    while ($row = mysql_fetch_array($result2)) {
                                                    $query2 = "SELECT total_art, reng_neto FROM reng_pedido WHERE co_art='".$row['mara_matnr']."' AND status=0";
                                                    $result3 = @mysql_query($query2);
                                                    while($row2 = mysql_fetch_array($result3)){
                                                        $total_cant+=$row2["total_art"];
                                                        $total_bs+=$row2["reng_neto"];
                                                    }
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$row['mara_matnr'].'</td>
                                                        <td>'.$total_cant.'</td>
                                                        <td class="center">'.number_format($total_bs, 2, ",", ".").'</td>
                                                        </tr>';
                                                    $total_cant=0;
                                                    $total_bs=0;
                                                }
                                                }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            
            <!-- /.row -->
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
