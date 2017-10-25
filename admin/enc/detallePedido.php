<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='2') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

$status=strip_tags($_GET['status']);
$pedido = $_REQUEST['id'];
$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
$arr_tipop=$obj_pedidos->get_tipoprecioart(1);
$arr_condp=$obj_pedidos->get_condpago(1);
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/headC.php'); ?>
<body>
<?php require_once('../lib/php/common/menuG.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Detalle Pedidos - Gerencia de Ventas</h1>
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
                                <div class="col-xs-3 text-center">
                                    <label>Producto</label>
                                </div>
                                <div class="col-xs-2 text-center">
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
                            
                            <?php
                            $arr_dp=$obj_pedidos->get_ped_det_app($pedido); ?>
                            <?php for($i=0;$i<sizeof($arr_dp);$i++){ ?>
                                <div class="row list_pro_pedido_mod">
                                        <div class="col-xs-3"><?php echo $arr_dp[$i]['co_art']."-".$arr_dp[$i]['art_des']; ?></div>
                                        <div class="col-xs-2"><?php echo $arr_dp[$i]['total_art']." ".$arr_dp[$i]['UniCodPrincipal']; ?></div>
                                        <div class="col-xs-2">Bs. F: <?php echo number_format($arr_dp[$i]['prec_vta'], 2, ",", "."); ?></div>
                                        <div class="col-xs-2">Bs. F: <?php echo number_format($arr_dp[$i]['total_sub'], 2, ",", "."); ?></div>
                                        <div class="col-xs-3"><?php echo $arr_dp[$i]['des_art']; ?></div>
                                </div>
                            <?php }
                            $arr_pedidos=$obj_pedidos->get_pedido_app($pedido); ?>
                            <br>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input type="text" id="total" name="total" class="form-control" value="<?php echo number_format($arr_pedidos[0]['total_bruto'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>IVA 12%:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="iva" name="iva" class="form-control" value="<?php echo number_format($arr_pedidos[0]['monto_imp'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 .col-md-push-4 text-right"><label>Total Neto:</label></div>
                                    <div class="col-md-4 .col-md-pull-8">
                                        <input id="totalN" name="totalN" class="form-control" value="<?php echo number_format($arr_pedidos[0]['total_neto'], 2, ",", "."); ?>" readonly/>
                                    </div>
                                </div>
                            <hr>
                            <div class="row">
                              <div class="col-xs-6">
                                <label>Seleccione tipo de descuento: </label>
                                <select id="tipo_d" name="tipo_d" class="selectpicker" data-size="10" data-width="auto" required>';
                                  <?php for($i=0;$i<sizeof($arr_tipop);$i++){ ?>
                                    <option value="<?php echo $arr_tipop[$i]['id_w']; ?>" ><?php echo $arr_tipop[$i]['descripcion']; ?></option>
                                  <?php } ?>
                                </select>
                                </div>
                                <div class="col-xs-6">
                                <label>Seleccione condición de pago: </label>
                                <select id="tipo_p" name="tipo_p" class="selectpicker" data-size="10" data-width="auto" required>';
                                  <?php for($j=0;$j<sizeof($arr_condp);$j++){ ?>
                                    <option value="<?php echo $arr_condp[$j]['cond']; ?>" ><?php echo $arr_condp[$j]['descripcion']; ?></option>
                                  <?php } ?>
                                </select>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-3">
                                    <button name="id" type="button" class="btn btn-primary btn-block aprPed" data-id="<?php echo $pedido; ?>"><i class="fa fa-check-circle"></i> Pre-Aprobar</button>
                                </div>
                                <div class="col-xs-3">
                                    <button name="idss" type="button" class="btn btn-primary btn-block delPed" data-id="<?php echo $pedido; ?>"><i class="fa fa-times-circle"></i> Anular</button>
                                </div>
                                <div class="col-xs-3 text-center">
                                   <button type="button" class="btn btn btn-primary btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
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
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <script src='../../js/funciones.js'></script>
    <script>
      $('.aprPed').on('click',function(){
        var id = $(this).data('id');
        var tipo_d = String($('#tipo_d option:selected').val());
        var tipo_p = String($('#tipo_p option:selected').val());
        eliminar=confirm("¿Desea pre-aprobar este pedido?");
        if (eliminar)
            window.location.href = "aprobarPed.php?id="+id+"&tipo_d="+tipo_d+"&tipo_p="+tipo_p;
    });
    </script>
    <script>
      $('.delPed').on('click',function(){
  var id = $(this).data('id');
        eliminar=confirm("¿Desea eliminar este pedido?");
        if (eliminar)
            window.location.href = "anularPed.php?codigo="+id;
    });
    </script>
</body>

    
</html>
