<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
$pedido=$_POST["pedido"];
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Detalle Pedidos - Telemarketing</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Agregando cantidades del pedido # <?php echo $pedido; ?></strong>
                        </div>
                        
                        <!-- .panel-heading -->
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-2 text-center">
                                    <label>Código</label>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <label>Producto</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Precio</label>
                                </div>
                                <div class="col-xs-3 text-center">
                                    <label>Cantidad</label>
                                </div>
                            </div>
                            <form role="form" action="agregandoPro.php" method="POST">
                            <?php 
                            $i=0;
                            foreach($_POST['productos'] as $producto){
                                $query2 = "SELECT art.art_des,art.monto FROM art WHERE art.co_art = '".$producto."';";
                                $result2 = @mysql_query($query2);
                                $row = mysql_fetch_array($result2);
                                echo '
                                    <div class="row">
                                        <div class="col-xs-2 text-center">
                                            <input type="text" id="total" name="codigo'.$i.'" class="form-control" value="'.$producto.'" readonly/>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <input type="text" id="total" name="desc'.$i.'" class="form-control" value="'.$row["art_des"].'" readonly/>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <input type="text" class="form-control" value="'.number_format($row["monto"], 2, ",", ".").'" readonly/>
                                                <input type="hidden" id="total" name="precio'.$i.'" value="'.$row["monto"].'"/>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <input type="text" id="total" name="cantidad'.$i.'" class="form-control" value="0" />
                                        </div>
                                    </div>
                                ';
                                $i++;
                                $_SESSION["posicion"] = $i;
                            }
                            ?>
                            
                            <input type="hidden" name="pedido" value="<?php echo $pedido; ?>" />
                            
                            <hr>
                            <div class="row">
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-info btn-block" ><i class="fa fa-check-circle"></i> Procesar</button>
                                </div>
                                <div class="col-xs-2">
                                   <button type="button" class="btn btn btn-primary btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                                </div>
                            </div>
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
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <script src='../../js/funciones.js'></script>
</body>

    
</html>
