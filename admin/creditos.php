<?php
require_once("seg.php");
require_once('funciones.php');
conectar();
$status=strip_tags($_GET['status']);
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('headC.php'); ?>

<body>

    <?php require_once('menuC.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Mantenimiento de Créditos Activos</h1>
                </div>
                <!-- /.col-lg-12 -->
            <div class="row">
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
                                            <th>Número Pedido</th>
                                            <th>Cliente</th>
                                            <th>Monto Total</th>
                                            <th>Fecha Realizado</th>
                                            <th>Reactivar Crédito</th>         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                $query = "SELECT * FROM creditos_bloqueo WHERE status='1'";
                                                $result = @mysql_query($query);
                                                while ($row = mysql_fetch_array($result)) {
                                                    $query2 = "SELECT name1 FROM clientes_sap WHERE kna1_kunnr='".$row['cod_cliente']."'";
                                                    $result2 = @mysql_query($query2);
                                                    $row2 = mysql_fetch_array($result2);
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$row["id_pedido"].'</td>
                                                        <td>'.$row2["name1"].'</td>
                                                        <td class="center">'.number_format($row["monto"], 2, ",", ".").'</td>
                                                        <td class="center">'.$row["fecha"].'</td>
                                                        <td class="center"><form action="mcredito.php" method="POST"><button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$row["id"].'">Reactivar</button></form></td>
                                                        </tr>';
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
        </div>
        <!-- /#page-wrapper -->


    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

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
