<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
$para=strip_tags($_GET['para']);
$_SESSION["para"] = $para;
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$co_ven=$_SESSION["co_ven"];
$a = "SELECT * FROM reng_pedido_temp WHERE co_cli='$co_cli';";
$b = @mysql_query($a);
$d=  mysql_num_rows($b);
$_SESSION["cont"] = $d;
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
            
                <div class="col-lg-12">
                    <h1 class="page-header">Procesar Pedido</h1>
                </div>
                <!-- /.col-lg-12 -->
            
            
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <?php
                        if($d!=0){
                        ?>
                        <div class="panel-heading">
                            Productos Agregados a su Pedido
                        </div>
                        <?php }else{ ?>
                        <div class="panel-heading">
                            Sin Productos
                        </div>
                        <?php } ?>
                        <!-- .panel-heading -->
                        <?php
                        if($d!=0){
                        ?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 col-xs-4 col-lg-6 text-center">
                                    <label>Descripción</label>
                                </div>
                                <div class="col-sm-2 col-xs-3 col-lg-2 text-right">
                                    <label>Precio</label>
                                </div>
                                <div class="col-sm-2 col-xs-1 col-lg-2 text-center">
                                    <label>Cantidad</label>
                                </div>
                                <div class="col-sm-2 col-xs-4 col-lg-2 text-right">
                                    <label>Sub-Total</label>
                                </div>
                            </div>
                            <form role="form" class="list_productos_mod" name="car" action="pedido.php" method="POST">
                                <?php
                                $t=0;
                                for($i=0;$i<$d;$i++){
                                    while($c = mysql_fetch_array($b)){
                                        $q = "SELECT art.art_des,art.monto FROM art WHERE art.co_art ='".$c['co_art']."'";
                                        $r = @mysql_query($q);
                                        while ($ro = mysql_fetch_array($r)) {
                                            echo '<div id="pd'.$t.'" class="row list_pro_pedido_mod">
                                                <div class="col-sm-6 col-xs-4 col-lg-6">
                                                    <div style="position: relative; display: table; border-collapse: separate">
                                                        <span style="position: relative; font-size: 0; white-space: nowrap; display: table-cell; vertical-align: middle;">'; ?>
                                                        <button type="button" class="btn btn-danger delPedido" data-id="<?php echo $c['co_art']; ?>" style="position: relative;" title="Quitar"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            <?php echo '</span> 
                                                        <input type="text" size="80" class="form-control descrip" name="descripcion'.$t.'" id="descripcion'.$t.'" value="'.$ro["art_des"].'" readonly/>
                                                        <input type="hidden" class="form-control" name="codigo'.$t.'" id="codigo'.$t.'" value="'.$c['co_art'].'"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-3 col-lg-2">
                                                    <input type="text" class="form-control text-right"  value="'.number_format($ro["monto"], 2, ",", ".").'" readonly/>
                                                    <input type="hidden" name="precio'.$t.'" id="precio'.$t.'" value="'.$ro["monto"].'" />
                                                </div>
                                                <div class="col-sm-2 col-xs-1 col-lg-2">';
                                                ?>
                                                    <input type="text" name="<?php echo 'cantidad'.$t; ?>" title="Solo Números" class="form-control text-right" value="" id="<?php echo 'cantidad'.$t; ?>" onChange="subcalculo('<?php echo $t; ?>');" autocomplete="off" placeholder="0" required/>
                                                <?php
                                            echo '</div>
                                                <div id="sub" class="col-sm-2 col-xs-4 col-lg-2">';
                                                ?>
                                                    <input type="text" id="<?php echo 'subtotal'.$t; ?>" name="<?php echo 'subtotal'.$t; ?>" class="form-control text-right" value="0" readonly />
                                                <?php
                                            echo '</div>
                                            </div>';
                                            $t++;
                                            $_SESSION["posicion"] = $t;
                                        }
                                    }
                                } ?>
                                <br>
                                <div class="row">
                                    <div class="col-xs-8 .col-xs-push-4 text-right"><label>Total:</label></div>
                                    <div class="col-xs-4 .col-xs-pull-8">
                                        <strong>
                                            <input type="text" id="total" name="total" class="form-control text-right" value="0" readonly/>
                                        </strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-8 .col-xs-push-4 text-right"><label>IVA 12%:</label></div>
                                    <div class="col-xs-4 .col-xs-pull-8">
                                        <strong>
                                            <input type="text" id="iva" name="iva" class="form-control text-right" value="0" readonly/>
                                        </strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-8 .col-xs-push-4 text-right"><label>Total Neto:</label></div>
                                    <div class="col-xs-4 .col-xs-pull-8">
                                        <strong>
                                            <input type="text" id="totalN" name="totalN" class="form-control text-right" value="0" readonly/>
                                        </strong>
                                    </div>
                                </div>
                                <div class="row col-xs-12">
                                    <div class="typePago btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <input type="radio" name="tipo_pago" id="contado" value="contado" autocomplete="off" cheked/> CONTADO
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="tipo_pago" id="credito" value="credito" autocomplete="off"/> CREDITO
                                        </label>
                                    </div>     
                                </div>
                                <button type="submit" class="btn btn-success">Procesar</button>
                            </form>
                        </div>
                        <!-- .panel-body -->
                        <?php
                        }else{
                            
                        } ?>
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
    
    <script src='../js/funciones.js'></script>
    
</body>

    
</html>
