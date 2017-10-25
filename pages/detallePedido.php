<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
include("lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

$nombreE = $_SESSION["nombre"];
$pedido = $_REQUEST['id'];
$co_cli=$_SESSION["co_cli"];
$p_sta=$_SESSION["p_sta"];
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
                    <h1 class="page-header">Detalle Pedidos</h1>
                </div>
                <!-- /.col-lg-12 -->
           
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Detalle del Pedido # <?php echo $pedido; ?> </strong>
                        </div>
                        
                        <!-- .panel-heading -->
                        
                        <div class="panel-body">
						<div class="row">
                                <div class="col-xs-12">
                                <?php
                                    $qr = 'SELECT archivo FROM archivo_pedidos where id_pedido='.$pedido;
                                    $rr = @mysql_query($qr);
									if($rr){
										echo "<label>Comprobantes de Pago: </label>";
										while ($ror = mysql_fetch_array($rr)) {
											echo '<a href="../pages/'.$ror[0].'" target="_blank"><img src="../image/depositop.png" width="2%"/></a>';
										}
									}
                                    
                                ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <label>Producto</label>
                                </div>
                                <div class="col-xs-1 text-center">
                                    <label>Cantidad</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Precio</label>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <label>Sub-Total</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Observaciones</label>
                                </div>
                            </div>
                            <div class="list_productos_mod">
                            <?php
                            $arr_dp=$obj_pedidos->get_ped_det($pedido); ?>
                            <?php for($i=0;$i<sizeof($arr_dp);$i++){ ?>
                                <div class="row list_pro_pedido_mod">
                                        <div class="col-xs-4"><?php echo $arr_dp[$i]['co_art']."-".$arr_dp[$i]['des_art']; ?></div>
                                        <div class="col-xs-1"><?php echo $arr_dp[$i]['total_art']." ".$arr_dp[$i]['UniCodPrincipal']; ?></div>
                                        <div class="col-xs-2">Bs. F: <?php echo number_format($arr_dp[$i]['prec_vta'], 2, ",", "."); ?></div>
                                        <div class="col-xs-2">Bs. F: <?php echo number_format($arr_dp[$i]['total_sub'], 2, ",", "."); ?></div>
                                        <div class="col-xs-3"></div>
                                </div>
                            <?php }
                            $arr_pedidos=$obj_pedidos->get_pedidos($pedido);
                            for($i=0;$i<sizeof($arr_pedidos);$i++){ ?>
                            <br>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input type="text" id="total" name="total" class="form-control" value="<?php echo number_format($arr_pedidos[$i]['total_bruto'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>IVA 12%:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="iva" name="iva" class="form-control" value="<?php echo number_format($arr_pedidos[$i]['monto_imp'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total Neto:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="totalN" name="totalN" class="form-control" value="<?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                            <hr>
								<?php
                                if($p_sta=='e'){
                                    $q3 = 'SELECT * FROM pedidos where doc_num='.$pedido;
                                    $r3 = @mysql_query($q3);
                                    $ro3 = mysql_fetch_array($r3);
                                ?>
                                <div class="row">
                                    <div class="col-xs-3 ">
                                        <label>Observaciones:</label>
                                    </div>
                                </div>
                                <div class="row">
                                <textarea class="form-control" rows="4" readonly><?php echo $ro3["comentario"]; ?></textarea>
                                </div>
                                <?php }
                                } ?>
								<hr>
                                <div class="row">
                                    <div class="col-xs-3 ">
                                        <button type="button" class="btn btn btn-success btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                                    </div>
                                </div>
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
    
    <script src='../js/funciones.js'></script>
</body>

    
</html>
