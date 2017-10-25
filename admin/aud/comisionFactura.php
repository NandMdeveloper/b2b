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
$cobros = $_GET['cobros'];
$recibido = $_GET['recibido'];
$saldado = $_GET['saldado'];


$cambios = $comision->getFacturaEditada($_GET['factura'],null);

$factura = $reporte->getDetallefactura($nfactura);
    if($factura->dias < 0 ){
            $class =" class='text-danger'";
    }
        $nComision = array(
            "comision"=> 0,
            "reserva"=> 0,
            "porcentaje"=> 0,
            "porcentajeR"=> 0,
            "calculado"=> 0,
            "cal_comision"=> 0,
            "cal_reserva"=> 0,
            "idParametro"=> 0,
            );


        $fechafactVencimiento = $factura->fec_venc->format('Y-m-d H:i:s');
        if ($cobros==1 and $recibido==1 and $saldado==1) {
            $parametros = array();

            $lista_parametros_desfasados = array();
            $lista_parametros_desfasados = $comision->getParametros('2017-02-01','2016-12-31');
            $parametros_desfasados = $lista_parametros_desfasados[12]['datos'];

            $saldo = $reporte->saldoUnaFactura(trim($factura->co_ven),trim($_GET['factura']));      

            $facturaRecibido = $comision->fechaRecibidoFactura(intval($_GET['factura']));

             if (count($facturaRecibido) > 0) {
                    
                //$fcobro = $comision->fechaCobroDocumento($_GET['factura'],$desde,$hasta);    
                 $nfcobro = $comision->fechaCobrofactura($factura->co_cli,$_GET['factura'],$desde,$hasta); 
                 $fcobro = date_format(date_create($nfcobro),'d/m/Y');                

                $condiciones = $comision->condicionTipoDefactura($_GET['factura']);
                $cneg =  $condiciones['dias_cred'];
                $facturaRecibido   = $facturaRecibido[0]['fecha_recibido'];
                
                /* CREAMOS FECHA DE VENCIMIENTO SEGUN MODO DE CREDITO Y FECHA EMISION*/
                $fec_venc_creada = $factura->fec_emis->format('Y-m-d');
              
                $fec_venc_creada = date_create($fec_venc_creada);
                date_add($fec_venc_creada, date_interval_create_from_date_string($cneg.' days'));
                $fec_venc_creada = date_format($fec_venc_creada, 'Y-m-d');              

                $fec_recibido = date_create($facturaRecibido);
                
                date_add($fec_recibido, date_interval_create_from_date_string($cneg.' days'));
                $fVcto=  date_format($fec_recibido, 'd/m/Y');
                $nfVcto=  date_format($fec_recibido, 'Y-m-d');

                $fechafactVencimiento =$nfVcto;

                 /*SE CALCULAN LOS DIAS CALLE */
                    $diascalle = "?";
                    if (!empty($fcobro)) {
                        $fecha1 = new DateTime($nfVcto);
                        $fecha2 = new DateTime($nfcobro);
                        $fecha = $fecha1->diff($fecha2);
                        $diascalle =  $fecha->format('%a') + $condiciones['dias_cred'];                      
                    }
                $saldor = 0;
                $saldor = $comision->getSaldoReal(trim($_GET['factura']), $saldor,$desde,$hasta,$factura->co_cli);
                   
                    $datos = array(
                        'co_seg'=>$factura->co_seg,
                        'co_ven'=>$factura->co_ven,
                        'condicion'=>$saldo['cond'],
                        'saldo_factura'=> $saldor,
                        'diascalle'=> $diascalle,
                        'total_bruto'=>$factura->total_bruto,
                        'fVencimiento'=>$fVcto,
                        'fcobro '=>$fcobro,
                        'cneg '=>$cneg
                    );

                    $lista_parametros = array();
                    $lista_parametros = $comision->getParametros($desde,$hasta);

                    $mes_doc =  date("m", strtotime($factura->fec_emis->format('Y-m-d')));
                    $mes_doc = (int)$mes_doc;                                     
 
                    $cann = $lista_parametros[$mes_doc]['cortes'];

                if ($cann == 1) {
                    $parametros = $lista_parametros[$mes_doc]['datos'];
                    $entra = 1;
                }else{
                    
                    for ($l=0; $l <= count($cann) ; $l++) {                     

                        /* comparamos fecha */
                        $fecha_desde = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['desde']);
                        $fecha_hasta = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['hasta']);
                        $fecha_emision = new DateTime($factura->fec_emis->format('Y-m-d'));

                        if($fecha_emision >= $fecha_desde and  $fecha_emision <= $fecha_hasta){
                         $parametros = $lista_parametros[$mes_doc]['datos'][$l];
                         $entra = 1;
                        }
                    }                     
                }

                if(count($parametros) == 0){
                     $parametros = $parametros_desfasados;
                }
                //print_r($parametros);
            
                $nComision = $comision->calculoBasico2($datos,$parametros,null);
              }

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
                    <td><?php echo $factura->fec_emis->format('Y-m-d H:i:s'); ?></td>
                    <td><?php echo $factura->fec_venc->format('Y-m-d H:i:s'); ?></td>
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
                          <th class="text-right">Opcion</th>
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
                                     $facturaRecibido = date_format(date_create($facturaRecibido),'d/m/Y');             
                                     echo $facturaRecibido ;
                                }
                                ?>
                            </td>
                            <td class="text-right lead">
                                <?php echo number_format($nComision['comision'], 2, ",", "."); ?> 
                                 <small class="label label-info"><?php echo $nComision['porcentaje']  ?> %</small>
                            </td>
                            <td class="text-right lead">
                                <?php echo number_format($nComision['reserva'], 2, ",", "."); ?>
                                <small class="label label-info"><?php echo $nComision['porcentajeR']  ?> %</small>
                            </td>
                            </tr>

                                <?php if(count($cambios) > 0) {
                                    $comisionN = ($factura->total_bruto *  $cambios[0]['comision'] ) / 100;
                                    $reservaN = ($factura->total_bruto * $cambios[0]['reserva']) / 100 ;

                                    ?>
                             <tr>
                                <td class="text-right lead">
                                    <i class="fa fa-pencil-square-o pull-left" aria-hidden="true"></i>  

                                    <?php
                                    if (isset($cambios[0]['cobro'])) {
                                         $cobrado = date_format(date_create($cambios[0]['cobro']),'d/m/Y');             
                                         echo $cobrado ;
                                    }
                                    ?>
                                </td>
                            <td class="text-right lead">
                                
                            </td>
                            <td class="text-right lead">
                                            
                           <?php echo number_format($comisionN, 2, ",", "."); ?>
                           <small class="label label-info"><?php echo $cambios[0]['comision']  ?> %</small>
                            </td>
                            <td class="text-right lead">
                                
                            <?php echo number_format($reservaN, 2, ",", "."); ?> 
                                 <small class="label label-info"><?php echo $cambios[0]['reserva']  ?> %</small>
                            </td>
                            <td class="text-right lead">
                         <a href="controlcomisiones.php?opcion=eliminarCambio&id=<?php   echo $cambios[0]['id'];?>&documento=<?php   echo $_GET['factura'];?>" class="text-danger fa fa-trash-o link-borrar "></a>
                            </td>
                            </tr>
                            <?php } 


                            ?>
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
                            if($cobros==1){
                                $ncobros = $comision->cobrosfactura2($factura->doc_num,$factura->co_cli);
                            }
                           
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
        <script src="../../bower_components/jQuery/jquery.number.js"></script>
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
