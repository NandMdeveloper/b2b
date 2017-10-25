<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
$status=strip_tags($_GET['status']);
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$_SESSION["p_sta"]=$status;

include("lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pedidos Cyberlux Distribuidores</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../css/tema.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?php require_once('lib/php/common/menu.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos</h1>
                </div>
                <!-- /.col-lg-12 -->
            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php
                            switch($status){
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
                                        <?php
                                        switch($status){
                                            case "r":
                                                echo '<tr>
                                            <th>Número Pedido</th>
                                            <th>Monto Total</th>
                                            <th>Fecha Realizado</th>
                                            <th>Cond. de Pago</th>
                                            <th>Pago</th>
                                            <th>Opciones</th>         
                                            </tr>';
                                            break;
                                            default:
                                                echo '<tr>
                                            <th>Número Pedido</th>
                                            <th>Monto Total</th>
                                            <th>Fecha Realizado</th>
                                            <th>Cond. de Pago</th>
                                            <th>Opciones</th>         
                                            </tr>';
                                            break;
                                        }
                                        ?>
                                    </thead>
                                    <tbody>
                                        <?php
                                        switch($status){
                                            case "e":
                                                $arr_ped=$obj_pedidos->get_pedi(1,$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>
                                                        <td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "r":
                                                $arr_ped=$obj_pedidos->get_pedi(2,$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    $querys = "SELECT * FROM archivo_pedidos WHERE doc_num=$arr_ped[$i]['doc_num']";
                                                    $results = @mysql_query($querys);
                                                    $rows = mysql_fetch_array($results);
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>';
                                                        if($arr_ped[$i]['doc_num']==$rows["doc_num"]){
                                                            echo '<td class="center"><button type="button" class="btn btn-info btn-xs btn-block disabled"><i class="fa fa-money"></i> Pagado</button></td>';
                                                        }else{
                                                            echo '<td class="center"><form action="pagar.php" method="POST">
                                                                <button name="pagar" type="submit" class="btn btn-info btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-money"></i> Pagar</button>
                                                                </form></td>';
                                                        }
                                                        echo '<td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "a":
                                                $arr_ped=$obj_pedidos->get_pedi(3,$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>
                                                        <td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "c":
                                                $arr_ped=$obj_pedidos->get_pedi(4,$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>
                                                        <td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "d":
                                                $arr_ped=$obj_pedidos->get_pedi(5,$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>
                                                        <td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            case "l":
                                                $arr_ped=$obj_pedidos->get_pedi(6,$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>
                                                        <td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
                                            default:
                                                $arr_ped=$obj_pedidos->get_pedi('',$co_cli);
                                                for($i=0;$i<sizeof($arr_ped);$i++){
                                                    echo '<tr class="odd gradeX">
                                                        <td>'.$arr_ped[$i]['doc_num'].'</td>
                                                        <td class="center">'.number_format($arr_ped[$i]['total_neto'], 2, ",", ".").'</td>
                                                        <td class="center">'.$arr_ped[$i]['fec_emis'].'</td>
                                                        <td class="center">'.$arr_ped[$i]['tipo'].'</td>
                                                        <td class="center"><form action="detallePedido.php" method="POST">
                                                        <button name="id" type="submit" class="btn btn-success btn-xs btn-block" value="'.$arr_ped[$i]['doc_num'].'"><i class="fa fa-eye"></i> Ver</button>
                                                        </form></td>
                                                        </tr>';
                                                }
                                            break;
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
