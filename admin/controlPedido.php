<?php
$opcion = $_GET['opcion'];
include("lib/class/pedidos.class.php");
require_once('lib/conex.php');
conectar();
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
switch ($opcion) {
	case 'detPedidoDetalle':

		$id = $_POST['documento'];
		
		$arr_dp=$obj_pedidos->get_pd_d($id);
		$arr_dat=$obj_pedidos->get_dat($id);
		?>
	
             
                  
               
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <div class="col-sm-4"><h5 class="box-title"><strong>Pedido # <?php echo $id; ?> | Factura # <?php echo $arr_dat[0]['factura']; ?></strong></h5></div>
                          <div class="col-sm-4"><h5 class="box-title"><strong>Cliente: <?php echo $arr_dat[0]['co_cli'].'-'.utf8_encode($arr_dat[0]['cli_des']); ?></strong></h5></div>
                          <div class="col-sm-4"><h5 class="box-title"><strong>Vendedor: <?php echo $arr_dat[0]['co_ven'].'-'.$arr_dat[0]['ven_des']; ?></strong></h5></div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                      <tr>
                                        <th>N°</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total-Neto</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<sizeof($arr_dp);$i++){ ?>
                                      <tr>
                                        <td><?php echo $arr_dp[$i]['reng_num']; ?></td>
                                        <td><?php echo $arr_dp[$i]['co_art']."-".utf8_encode($arr_dp[$i]['art_des']); ?></td>
                                        <td><?php echo $arr_dp[$i]['total_art']." ".$arr_dp[$i]['co_uni']; ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_dp[$i]['prec_vta'], 2, ",", "."); ?></td>
                                        <td>Bs. F: <?php echo number_format($arr_dp[$i]['reng_neto'], 2, ",", "."); ?></td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                   
                    <!-- /.panel -->
               
               
        <?php
		break;
	
	default:
		# code...
		break;
}