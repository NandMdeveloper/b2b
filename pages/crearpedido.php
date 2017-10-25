<?php
require_once("seg.php");
require_once('funciones.php');
conectar();

$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$lista_precio=$_SESSION["lista_precio"];
$co_ven=$_SESSION["co_ven"];
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

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="../dist/css/bootstrap-select.css">

</head>

<body>

    <?php require_once('menu.php'); ?>
        <!-- /#wrapper -->
        <div id="content">
            
                <div class="col-lg-12">
                    <h1 class="page-header">Crear Pedido</h1>
                </div>
                <!-- /.col-lg-12 -->
            
            <!-- /.row -->
            
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Seleccione los productos para su pedido
                        </div>
                        <!-- /.panel-heading -->
                        <div class="row">
                            <div class="col-xs-12">
                                <form role="form" action="procesarpedido.php" method="POST">
                                    <select id="productos" name="productos[]" class="selectpicker" data-size="6" data-live-search="true" title="Seleccione los productos..." data-style="btn-warning" data-width="100%" multiple>
                                    <?php
                                        
                                        $query = "SELECT m.mara_matnr, m.makt_makt, p.KONP_KBETR FROM silva_cyber.material AS m INNER JOIN silva_cyber.pre_listaprecio AS p ON m.mara_matnr=p.A501_MATNR";
                                        $result = @mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            echo '<option value="'.$row["mara_matnr"].'" data-subtext="'.$row["KONP_KBETR"].' Bs.F.">'.$row["mara_matnr"].' | '.$row["makt_makt"].'</option>';
                                        }
                                    ?>
                                    </select>
                                    <button type="submit" class="btn btn-default">Procesar Pedido</button>
                                    <button type="reset" class="btn btn-default">Limpiar</button>
                                </form>
                            </div>
                        </div>
                    <!-- /.panel -->
                    </div>
                
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>

        

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <script src="../dist/js/bootstrap-select.js"></script>

</body>

</html>
