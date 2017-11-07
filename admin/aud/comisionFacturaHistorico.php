<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");

$reporte= new reporte;//LLAMADO A LA CLASE DE PEDIDOS
$comision= new comision;//LLAMADO A LA CLASE DE PEDIDOS

$usuario=$_SESSION['user'];
$nfactura = null;
if(isset($_GET['factura'])){
    $nfactura =  $_GET['factura'];
}

if(isset($_GET['desde'])){
    $desde = $_GET['desde'];
}
if(isset($_GET['hasta'])){
    $hasta = $_GET['hasta'];
}



//$cambios = $comision->getFacturaEditada($_GET['factura'],null);

$factura = $reporte->getDetallefactura($_GET['factura']);
$nfactura = $comision->getFacturaHistorico($_GET['factura']);
//var_dump($factura);exit();

$fec_emis = date_format(date_create($factura->fec_emis->format('Y-m-d')),'d/m/Y');
$fecha_venc = date_format(date_create($nfactura[0]['fecha_venc']),'d/m/Y');

$fecha_venc = date_format(date_create($nfactura[0]['fecha_venc']),'d/m/Y');
$facturaRecibido = "";
if ($nfactura[0]['fech_recepcion']) {
    $facturaRecibido =  date_format(date_create($nfactura[0]['fech_recepcion']),'d/m/Y');;
}

$fcobro = "";
if ($nfactura[0]['fech_cobro']) {
    $fcobro =  date_format(date_create($nfactura[0]['fech_cobro']),'d/m/Y');;
}
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuA.php'); ?>

        <div id="content">
            <div class="col-lg-12">
               <h3>
                    Factura <?php echo $factura->cli_des; ?>
                    <small>Detalles</small>
                   </h3>
            </div>
            <div class="col-lg-12">
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
      <div class="row">

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                Detalles del factura <b>#<?php echo $factura->doc_num; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                        <table class="table table-striped">
                <tr>
                  <th>Descripción</th>
                  <th>Emisión</th>
                  <th>Vencimiento</th>
                  <th>Documento</th>
                </tr>
                <tr>
                    <td><?php echo $factura->descrip; ?></td>
                    <td><?php echo $fec_emis; ?></td>
                    <td><?php echo $fecha_venc; ?></td>
                    <td><?php echo $factura->cond_des; ?></td>
                </tr>
                <tr>
                    <td class="text-right"><b>Total bruto: </b><?php echo number_format($factura->total_bruto, 2, ",", "."); ?></td>
                    <td class="text-right"><b>Impuesto: </b><?php echo number_format($factura->monto_imp, 2, ",", "."); ?></td>
                    <td class="text-right"><b>Neto: </b><?php echo number_format($factura->total_neto, 2, ",", "."); ?></td>
                    <td class="text-right"  colspan="2"></td>
                </tr>
                <tr>
                <td>
                    <span class="glyphicon glyphicon-phone text-info"></span>
                    <?php echo $factura->telefonos; ?></td>
                <td colspan="2">
                    <span class="glyphicon glyphicon-user glyphicon text-info"></span>
                    <?php echo $factura->ven_des; ?></td>
                <td colspan="2">
                <span class="glyphicon glyphicon-map-marker text-info"></span>
                <?php echo $factura->direc1; ?></td>

                </tr>
            </table>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                </div>    
            </div>
        </div> 

        <?php
        $aFactura = array($_GET['factura']);
     
    


          // var_dump($parametros);


             ?>         
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Totales comisión
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                <table  class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th class="text-right">Ultimo Cobro</th>
                          <th class="text-right">Recepcion</th>
                          <th class="text-right">comision</th>
                          <th class="text-right">Reserva</th>
                        </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-right lead">
                                <?php
                                if (isset($fcobro)) {
                                 echo $fcobro ;
                                }
                                ?>
                            </td>               
                            <td class="text-right lead">
                                <?php
                                if (isset($facturaRecibido)) {           
                                     echo $facturaRecibido ;
                                }
                                ?>
                            </td>
                            <td class="text-right lead">
                                <?php echo number_format($nfactura[0]['comision'], 2, ",", "."); ?> 
                                 <small class="label label-info"><?php echo $nfactura[0]['porcentaje']  ?> %</small>
                            </td>
                            <td class="text-right lead">
                                <?php echo number_format($nfactura[0]['reserva'], 2, ",", "."); ?>
                            </td>
                            </tr>

                         
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>comision</th>
                                <th>Reserva</th>
                            </tr>
                        </tfoot>
                      </table>
                        </div>
                    </div>
                </div> 
                        <?php
                            $ncobros = array();
                           
                                $ncobros = $comision->cobrosfactura2($factura->doc_num,$factura->co_cli);
                        
                            $tabla ="";
                                if(count($ncobros) > 0){
                                        $tabla ="example1";
                                }
                             ?>     
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Documentos relacionados Cobros 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table id="<?php echo $tabla; ?>" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>COBRO</th>
                                        <th>DOCUMENTO</th>
                                        <th class="text-right">MONTO</th>
                                        <th>FECHA</th>
                                        <th>Descripción</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                            <?php

                                            if(count($ncobros) > 0){
                                                ?>

                                                <?php
                                                $total = 0;
                                            for($i=0;$i<sizeof($ncobros);$i++){
                                                

                                                 $class="";

                                                 if($ncobros[$i][1] < 0){
                                                         $class=" class='text-danger'";

                                                    }

                                            ?>
                                            <tr <?php echo $class;?>>
                                                        <td><?php echo $ncobros[$i]['cob_num']; ?></td>
                                                        <td><?php echo $ncobros[$i]['nro_doc']; ?></td>
                                                     <td class="text-right">
                                                        <?php echo number_format($ncobros[$i]['cargo'], 2, ",", "."); ?></td>
                                                        <td>
                                                            <?php echo $ncobros[$i]['fecha']->format('Y-m-d'); ?>
                                                        </td>
                                                        <td><?php echo $ncobros[$i]['deta']; ?></td>
                                                        <td><?php echo $ncobros[$i]['tipo_mov']; ?></td>

                                                </tr>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <tr>
                                                        <td colspan="4">Sin documentos</td>
                                                </tr>
                                            <?php

                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                <th>COBRO</th>
                                        <th>DOCUMENTO</th>
                                        <th class="text-right">MONTO</th>
                                        <th>FECHA</th>
                                        <th>Descripción</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                        </div>
                    </div>
                </div>
            <?php 
                    $ediciones =  $comision->getauditoriaDocumento($_GET['factura']); 
                    if (count($ediciones)) {
                    
                ?>                   
                                <div class="container">
                                        <div class="col-md-12">
                                            <h3 class="box-title">Auditoria <small>interna</small></h3>
                                          <!-- The time line -->
                                          <ul class="timeline">
                                            <!-- timeline time label -->
                                            <?php 
                                                    foreach ($ediciones as $ed) {
                                                        $fe = explode(' ', $ed['fecha']);
                                                        $fecha = $fe[0];
                                                        $hora = $fe[1];
                                             ?>
                                             <li class="time-label">
                                                  <span class="bg-red">
                                                    <?php  echo  $comision->fechaNormalizada($fecha); ?>
                                                  </span>
                                            </li>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <li>
                                              <i class="fa fa-user bg-aqua"></i>

                                              <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> <?php  echo $hora; ?></span>

                                                <h3 class="timeline-header"><a href="#"><?php  echo  $ed['usuario']; ?></a> Edito comision</h3>

                                                <div class="timeline-body">
                                                    <?php 
                                                    echo $ed['detalle'];
                                                 ?>
                                                  </div>
                                              </div>
                                            </li>
                                            <!-- END timeline item -->
                                


                                             <?php } ?>
                                            <li>
                                              <i class="fa fa-clock-o bg-gray"></i>
                                            </li>
                                          </ul>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                        
                            
                <?php 
        
                    }
                ?>

        <div id="myModal" class="modal fade in">
            <div class="modal-dialog">
                <div class="modal-content">
     
                    <div class="modal-header">
                        
                        <h4 class="modal-title">Calculo en desarrollo</h4>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Esta ventana se cerrara al culminar el proceso</h4>
                        <img src="../../image/preload.gif">
                    </div>
                    <div class="modal-footer">
                    </div>
     
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dalog -->
        </div><!-- /.modal -->
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
     <script src="../../bower_components/calendario/jquery-ui.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
        <script src="../../bower_components/jquery/jquery.number.js"></script>
    <script src="../../bower_components/fc.js"></script>
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
</body>

</html>
