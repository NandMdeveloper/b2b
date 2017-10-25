<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$comision =  new comision();

$desde="2017-10-01";
$hasta="2017-12-31";

if(isset($_GET['periodo'])){
  $desde = $_GET['periodo'];
}
if(isset($_GET['hasta'])){
  $hasta = $_GET['hasta'];
}

$Historicouno = $comision->buscarHistoricouno($desde);
if (count($Historicouno)) {
  header("Location: comisioneshistorico.php?periodo=".$desde);
  $mensa = "Calculo de este rango de fecha se encuentra en historico del sistema";
        $comision->setMensajes('info',$mensa);
 
}

$documentos = $comision->listadoFacturaComisionVentas($desde,$hasta);


$datosrespuesta = count($documentos);

?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/headA.php'); ?>
<body>

    <?php require_once('../lib/php/common/menuA.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                         <h1>
                    Comisiones
                    <small>lista vendedores</small>

                  </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
                  <div class="col-md-6">
                 <form action="comisionesventas.php" method="GET" id="rango">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input name="periodo" type="text" class="form-control fecha"  condicion="1" placeholder="Inicio" aria-describedby="sizing-addon3" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input name="hasta" type="text" class="form-control hasta" condicion="1" placeholder="Cierre" aria-describedby="sizing-addon3">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="col-xs-3">
                      <div class="input-group input-group-sm">
                       <button type="button" class="btn btn-info pill-right"  data-toggle="modal" data-target="#modal-verhistoricos"> <i class="fa fa-clock-o" aria-hidden="true"></i>
                          Ver historico </button>
                      </div>
                    </div>
                  </div>
              <br>
              <br>
              <br>
              </form>

         <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Comisiones lista vendedores
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                        <table id="dataTables-example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Fact</th>
                        <th>Ven</th>
                        <th>Cod</th>
                        <th>Cliente</th>
                        <th>Base</th>
                        <th>Saldo</th>
                        <th>Comision</th>
                        <th>Reserva</th>
                        <th>%</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $lineas = count($Historicouno);
                          foreach ($Historicouno as $factura) {
                           
                        ?>
                              <tr
                               <?php 
                                    if($factura['covendedor']){
                                      ?>
                               class=""
                                    <?php }?>
                              >
                                <td>
                                  <?php echo $factura['doc_num']; ?>                             
                                    
                                  
                                </td>
                                <td><?php echo $factura['covendedor']; ?></td>
                                <td>
                                  <?php echo $factura['ven_des']; ?>
                                 </td>
                                <td>
                                  <?php echo
                                   utf8_encode($factura['cli_des']); 
                                   ?>
                                </td>
                                <td class="text-right"><?php echo  $factura['seg_des']; ?></td>
                                <td class="text-right">
                                  <?php 
                                  echo number_format($factura['total_bruto'], 2, ",", ".");
                                   ?></td>
                               
                                  <td class="text-right"><?php echo number_format($factura['comision'], 2, ",", "."); ?></td>
                                  <td class="text-center">
                                         <?php 
                                          if(!empty($factura['cal_comision'])){
                                             ?>
                                             <span class="badge pull-right ">
                                              <?php echo number_format($factura['porcentaje'], 1, ",", "."); ?>

                                            %</span>
                                             <?php 
                                           }
                                     ?>
                                </td>
                      
                              </tr>
                            <?php
                          }
                           ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Fact</th>
                        <th>Ven</th>
                        <th>Cod</th>
                        <th>Cliente</th>
                        <th>Base</th>
                        <th>Saldo</th>
                        <th>Comision</th>
                        <th>Reserva</th>
                        <th>%</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                </div>  
        
            </div>
                <!-- /.col-lg-12 -->
        </div>
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
