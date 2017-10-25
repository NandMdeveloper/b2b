<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
$status=strip_tags($_GET['status']);
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
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
                    <h1 class="page-header">Productos Disponibles</h1>
                </div>
                <!-- /.col-lg-12 -->
            
                <div id="panel-products">
                    <div class="panel-default col-xs-12">
                        
                            
                        
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <img class="img-responsive" src="../image/cintillo.gif" width="100%" />
                            <div class="panel-group">
                                <div class="panel panel-default panel-products-mod1">
                                   <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Partes Eléctricas</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=1"><img class="col-xs-12" src="../image/cat/pts_elec.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Correas</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=2"><img class="col-xs-12" src="../image/cat/correa.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Filtración y Esquemas de Combustión</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=3"><img class="col-xs-12" src="../image/cat/filtracion-y-combustion.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Transmisión y Potencia</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=4"><img class="col-xs-12" src="../image/cat/transmision-y-potencia.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Sistema de Suspensión</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=5"><img class="col-xs-12" src="../image/cat/sistema-de-suspension.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Sistema de Frenos</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=6"><img class="col-xs-12" src="../image/cat/sistema-de-frenos.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Partes Internas del Motor</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=7"><img class="col-xs-12" src="../image/cat/partes-internas-del-motor.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="col-xs-4">
                                                   <div class="panel panel-cx panel-product-mod">
                                                        <div class="panel-heading">Diesel</div>
                                                        <div class="panel-body">
                                                            <a href="inventariodetalle.php?grupo=8"><img class="col-xs-12" src="../image/cat/diesel.jpg"/></a>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="col-xs-4">
                                                   
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .panel-body -->
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
    
</body>

    
</html>
