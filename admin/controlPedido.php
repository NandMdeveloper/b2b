<?php
session_start();
ini_set('display_errors', '1');
$opcion = $_GET['opcion'];
include("lib/class/pedidos.class.php");
require_once('lib/conex.php');
include("lib/class/log.class.php");
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
	case 'detPedidoReversar':

		$id = $_POST['documento'];
		
		$arr_dp=$obj_pedidos->get_pd_d($id);
		$arr_dat=$obj_pedidos->get_dat($id);
		?>
	
             
                  
               
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <div class="col-sm-4"><h5 class="box-title"><strong>Pedido # <?php echo $id. '| Factura #' .utf8_encode( $arr_dat[0]['factura']); ?></strong></h5></div>     <div class="col-sm-4"><h5 class="box-title"><strong>Cliente: <?php echo $arr_dat[0]['co_cli'].'-'.utf8_encode($arr_dat[0]['cli_des']); ?></strong></h5></div>
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

<ul class="nav nav-tabs">
  <li class="active"><a href="#entregado" data-toggle="tab" aria-expanded="false">Entregado</a></li>
  <li class=""><a href="#modificar" data-toggle="tab" aria-expanded="true">Modificar</a></li>
  <li class=""><a href="#reversar" data-toggle="tab" aria-expanded="true">Reversar</a></li>
  <li class=""><a href="#anular" data-toggle="tab" aria-expanded="true">Anular</a></li>
  
    </ul>
  </li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in " id="entregado">
     <div class="panel-heading">
                            <h5> <strong>Entregado al cliente</strong></h5>

                        </div>
                            
                                <form class="form-inline" action="" method="POST">
                                 
                                      <label for="fecha">Fecha de Recibido: </label>
                                      <input type="date" name="fecha_old" class="form-control" value="<?php echo $as=date("d-m-Y"); ?>" required/>
                                      <label for="comentario">Comentario: </label>
                                      <input type="textarea" name="comentario" class="form-control" value="" required/>
                                     <label><button name="id" type="button" class="btn btn-primary btn-block mod" value="<?php echo $id; ?>"onclick='anular_pedido(this.form,this.value,"aprobar" )'>
                                     <i class="fa fa-check-circle"></i> Enviar</button></label>
                                  
  
                                </form>
                    </div>
  <div class="tab-pane fade " id="modificar">
 <div class="panel-heading">
                            <h5> <strong>Modificar fecha de despacho</strong></h5>

                        </div>                            
                          
                        
                           <form class="form-inline" action="" method="POST">
                                  <label for="fecha">Fecha Despacho: </label>
                  <input type="date" name="fecha_old" class="form-control" value="<?php echo $arr_dat[0]['fecha_despacho']; ?>" readonly required/>
                  <label for="fecha">Fecha Despacho Nueva: </label>
                  <input type="date" name="fecha_new" class="form-control" value="" required/>
                                    <label> <button name="id" type="button" class="btn btn-primary btn-block mod" value="<?php echo $id; ?>"onclick='anular_pedido(this.form,this.value,"modificar" )'>
                                     <i class="fa fa-cog"></i> Modificar fecha</button></label>
                                 
                           </form>
                         </div>
 <div class="tab-pane fade " id="reversar">
 <div class="panel-heading">
                            <h5> <strong>Reversar despacho</strong></h5>

                        </div>                            
                          
                        
                           <form class="form-inline" action="" method="POST">
                         
                                     <label for="fecha">Fecha Despacho: </label>
                                      <input type="date" name="fecha_old" class="form-control" value="<?php echo $arr_dat[0]['fecha_despacho']; ?>" readonly required/>
                                        <label for="comentario">Motivo de Reversion: </label>
                                      <input type="textarea" name="comentario" id="comentario" class="form-control" value="" required/>
                                    <label> <button name="id" type="button" class="btn btn-primary btn-block mod" value="<?php echo $id; ?>"onclick='anular_pedido(this.form,this.value,"reversar" )'>
                                     <i class="fa fa-cog"></i> Reversar para despachar </button></label>
                                 
                           </form>
                         </div>
                          <div class="tab-pane fade " id="anular">
                              <div class="panel-heading">
                            <h5> <strong>Anular Pedido</strong></h5>

                        </div>                            
                          
                        
                           <form class="form-inline" method="POST">
                                     <label for="comentario">Motivo de la Anulacion: </label>
                                      <input type="textarea" name="comentario" id="comentario" class="form-control" value="" required/>
                                      <input type="hidden" name="fecha_old" class="form-control" value="<?php echo $arr_dat[0]['fecha_despacho']; ?>"/>
                                    <label> <button name="id" type="submit" class="btn btn-primary btn-block " value="<?php echo $id; ?>" onclick='anular_pedido(this.form,this.value,"anular")'>
                                     <i class="fa fa-ban"></i>Anular</button></label>
                                 
                           </form>
                         </div>
                      </div>
                      
                    </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
              
                     
        <?php
		break;
      case 'procesar_accion':
$obj_log= new class_log;

$user=$_SESSION["user"];

       $pedido=$_REQUEST["documento"];
       $tipo=$_REQUEST["tipo"];
   if($tipo=="anular"){
           $anular=$_REQUEST["coment"];

	      $sel= "UPDATE pedidos_des SET status=5,anulado=1, comentario='revesad$anular' where doc_num='$pedido'";
      $hecho =0;

      $rs = mysql_query($sel) or die(mysql_error());

       $proceso = array(
          "msn" => "Operacion no realizada",
          "hecho" => 0
        );

        if($rs){
           $proceso = array(
          "msn" => "Operacion  realizada",
          "hecho" => 1
          );
        }
        $obj_log->add_log_n(date('Y-m-d H:i:s'), $user, 'Pedido # '.$pedido.' | Anulado por el motivo: '.$anular);
        echo json_encode($proceso);
    }
    elseif ($tipo=="reversar"){
       $anular=$_REQUEST["coment"];
       $fechaanterior=$_REQUEST["fechades"];


        $sel= "UPDATE pedidos_des SET status=2, comentario='$anular' where doc_num='$pedido'";
      $hecho =0;

      $rs = mysql_query($sel) or die(mysql_error());

       $proceso = array(
          "msn" => "Operacion no realizada",
          "hecho" => 0
        );

        if($rs){
           $proceso = array(
          "msn" => "Operacion  realizada",
          "hecho" => 1
          );
        }
       $obj_log->add_log_n(date('Y-m-d H:i:s'), $user, 'Pedido # '.$pedido.' | Pedido reversado de la fecha:'.$fechaanterior.' | por el motivo: '.$anular);
        echo json_encode($proceso);
      }
      elseif ($tipo=="modificar"){

        $fechanueva=$_REQUEST["fechanew"];
        $fechaanterior=$_REQUEST["fechades"];
        
      $sq="UPDATE pedidos_des SET fecha_despacho='$fechanueva' WHERE doc_num = '$pedido'";
      $hecho =0;

      $rs = mysql_query($sq) or die(mysql_error());

       $proceso = array(
          "msn" => "Operacion no realizada",
          "hecho" => 0
        );

        if($rs){
           $proceso = array(
          "msn" => "Operacion  realizada",
          "hecho" => 1
          );
        }
        $obj_log->add_log_n(date('Y-m-d H:i:s'), $user, 'Pedido # '.$pedido.' | Fecha Despacho Modificada old:'.$fechaanterior.' | new: '.$fechanueva);
        echo json_encode($proceso);
        }
      elseif ($tipo=="aprobar"){

        $fechaanterior=$_REQUEST["fechades"];
          $anular=$_REQUEST["coment"];
        $sq="UPDATE pedidos_des SET status=4,comentario_r='$anular',fecha_recibido='$fechaanterior' WHERE doc_num = '$pedido'";
        $rs=mysql_query($sq);

       $proceso = array(
          "msn" => "Operacion no realizada",
          "hecho" => 0
        );

        if($rs){
           $proceso = array(
          "msn" => "Operacion  realizada",
          "hecho" => 1
          );
        }
        $obj_log->add_log_n(date('Y-m-d H:i:s'), $user, 'Pedido # '.$pedido.' | Fecha recibido por el cliente:'.$fechaanterior);
         
        echo json_encode($proceso);
      }
		break;
}