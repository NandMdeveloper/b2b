<?php
require_once("lib/seg.php");
require_once('lib/conex.php');
conectar();
$para=strip_tags($_GET['para']);
$_SESSION["para"] = $para;
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

    <title>Pedidos FC Distribuidores</title>

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

    <?php require_once('menu.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Mensajeria</h1>
                </div>
                <!-- /.col-lg-12 -->
           
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php
                            switch($para){
                                case "t":
                                    echo "Mensaje para el Departamento de Telemarketing";
                                break;
                                
                            }
                            ?>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <form role="form" action="enviandomensaje.php" method="POST">
                                <label>Asunto:</label>
                                <input type="text" name="asunto" class="form-control" id="asunto" placeholder="Escribe el asunto de tu mensaje..." required>
                                <label>Mensaje:</label>
                                <textarea name="mensaje" class="form-control" rows="6" required></textarea>
                                <button type="submit" class="btn btn-default">Enviar Mensaje</button>
                                <button type="reset" class="btn btn-default">Limpiar</button>
                            </form>
                        </div>
                        <!-- .panel-body -->
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
    
</body>

    
</html>
