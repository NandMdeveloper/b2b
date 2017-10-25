<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
$cliente=$_POST["cliente"];
$_SESSION["co_cli"]=$cliente;

?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/headE.php'); ?>
<body>
<?php require_once('../lib/php/common/menuE.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Crear Pedido </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong></strong>
                        </div>
                        
                        <!-- .panel-heading -->
                        
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
                            foreach($_POST['productos'] as $producto){
                                $query2 = "SELECT art.art_des,art.monto FROM art WHERE art.co_art = '".$producto."';";
                                $result2 = @mysql_query($query2);
                                $row = mysql_fetch_array($result2);
                                echo '<div id="pd'.$t.'" class="row list_pro_pedido_mod">
                                                <div class="col-sm-6 col-xs-4 col-lg-6">
                                                    <div style="position: relative; display: table; border-collapse: separate">
                                                        <span style="position: relative; font-size: 0; white-space: nowrap; display: table-cell; vertical-align: middle;">'; ?>
                                                        <button type="button" class="btn btn-danger delPedido" data-id="<?php echo $producto; ?>" style="position: relative;" title="Quitar"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            <?php echo '</span> 
                                                        <input type="text" class="form-control hidden-xs descrip" name="descripcion'.$t.'" id="descripcion'.$t.'" value="'.$row["art_des"].'" readonly/>
                                                        <input type="hidden" class="form-control" name="codigo'.$t.'" id="codigo'.$t.'" value="'.$producto.'"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-3 col-lg-2">
                                                    <input type="text" class="form-control text-right"  value="'.number_format($row["monto"], 2, ",", ".").'" readonly/>
                                                    <input type="hidden" name="precio'.$t.'" id="precio'.$t.'" value="'.$row["monto"].'" />
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
                            ?>
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
