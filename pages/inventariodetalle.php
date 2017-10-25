<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
$grupo=strip_tags($_GET['grupo']);
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$co_ven=$_SESSION["co_ven"];
$_SESSION["grupo"]=$grupo;
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

    <?php require_once('lib/php/common/menu.php'); ?>
        <div id="content">
                <div class="col-lg-6">
                    <h1 class="page-header">Productos Disponibles</h1>
                </div>
                <div class="col-lg-6">
                    <br><img class="img-responsive" src="../image/cintillo.gif" width="100%" /><br>
                </div>
            <div class="col-lg-12">
                <!-- /.col-lg-12 -->
                <?php
                $query = "SELECT * FROM art WHERE 1 = 1 AND art.co_lin = $grupo AND art.stock > 0 AND art.monto > 0";
                $result2 = @mysql_query($query);
                if (mysql_num_rows($result2)>=1){
                    echo $btnRturn;
                    echo '<div class="panel panel-default panel-products-mod2">';
                    while ($row2 = mysql_fetch_array($result2)) {
                        $qc = "SELECT * FROM reng_pedido_temp WHERE co_cli='$co_cli' AND co_art='".$row2['co_art']."';";
                        $rc = @mysql_query($qc);
                        $roc = mysql_fetch_array($rc);
                        echo '<div class="col-lg-4 col-sm-4 col-xs-6">
                                <div class="panel panel-default panel-product-mod-detalle">
                                    <div class="panel-heading">
                                        <div class="row">
                                            '.$row2["art_des"].'
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div rel="tooltip" data-original-title="DESCRIPCION: '.$row2["art_des"].' &nbsp; &nbsp; |&nbsp; &nbsp;  PRECIO: '.number_format($row2["monto"], 2, ",", ".").' Bs.F">';
                                    $url="../image/productos/".$row2["co_art"].".jpg";
                                    if(file_exists($url)){
                                        echo '<img class="col-xs-12 img-responsive" src="../image/productos/'.$row2["co_art"].'.jpg"/>
                                        </div>'; 
                                    }else{
                                        switch($grupo){
                                            case "1":
                                                echo '<img class="col-xs-12 img-responsive" src="../image/bombas.jpeg"/></div>';
                                            break;
                                            case "2":
                                                echo '<img class="col-xs-12 img-responsive" src="../image/bombas.jpeg"/></div>';
                                            break;
                                            case "3":
                                                echo '<img class="col-xs-12 img-responsive" src="../image/bombas.jpeg"/></div>';
                                            break;
                                        }
                                    }
                                    echo '<div class="monto-product-mod"><span>Bs.F: </span>'.number_format($row2["monto"], 2, ",", ".").'</div>
                                    <div class="row">';
                                    if(!empty($roc)){ 
                                        echo '<div class="alert alert-info alert-add-prod" role="alert"> Producto ya esta en el carrito </div>';
                                    }else{
                                        echo '<form role="form" action="addcar.php" method="POST">
                                        <input type="hidden" name="co_art" value="'.$row2["co_art"].'">
                                            <button type="submit" class="add-prod btn btn-lg btn-block btn-success" alt="Agregar al Carrito">Agregar <i class="fa fa-shopping-cart"></i></button>';
                                        echo '</form>';
                                    }
                                    echo'</div>
                                </div>
                            </div> 
                        </div>';
                        }  
                    echo '</div>';
                    }else{
                        echo '<div class="alert alert-warning" role="alert"> Productos no disponibles </div>';
                    }  
                    echo $btnRturn;
                ?>
        </div>
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
    <script>
$( document ).ready(function () {
    $("*[rel=tooltip]").tooltip();
});
</script>
</body>

    
</html>
