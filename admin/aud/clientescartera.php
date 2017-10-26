<?php
require_once("../lib/seg.php");
$permiso = 0;
if($_SESSION['tipo']=='9' or $_SESSION['tipo']=='12') {
    $permiso = 1;
  }
  
if($permiso==0) {
  header('Location: ../lib/php/common/logout.php');

}
require_once('../lib/conex.php');
conectar();
require_once('../lib/conecciones.php');
include("../lib/class/cliente.class.php");
include("../lib/class/pedidos.class.php");
include("../lib/class/comision.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$comision= new comision;//LLAMADO A LA CLASE DE PEDIDOS
$cliente =  new cliente();

$desde="2017-01-01";
$hasta=date("Y-m-d");

$getzona="";
$zona="";


if(isset($_GET['desde'])){
  $desde = $_GET['desde'];
}
if(isset($_GET['hasta'])){
  $hasta = $_GET['hasta'];
}
if(isset($_GET['zona'])){
  $getzona = $_GET['zona'];

}



$cartera = array();

$cartera = $cliente->getClientescartera($getzona,null,$hasta);

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>
  <style>
  .modal-cxc{
  width: auto !important;
   width: 1600px !important;
  margin: 10px;
  }
  .modal-dialog {
    width: 1011px;
    margin: 30px auto;
}
  
</style>
                <div id="modal-cxc" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                          <br>
                       </div>
                    </div>
                  </div>
    <?php 
    if ($_SESSION['tipo']== 9) {
      require_once('../lib/php/common/menuA.php');
    }else{
      require_once('../lib/php/common/menuV.php');
    }

     ?>

        <div id="content">
                  <div class="col-lg-12">
                         <h1>
                    Clientes
                    <small>registros</small>
<a href="excelClienteActivos.php?zona=<?php echo $getzona ?>&desde=<?php echo $desde ?>&hasta=<?php echo $hasta ?>" class="fa fa-file-excel-o excel text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a>
                  </h1>
                </div>
                <div class="col-lg-12">
        <form action="clientescartera.php" method="GET" id="rango">
              <label for="inputEmail" class="col-lg-3 control-label">Fecha de analisis de clientes</label>

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                      <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                      <input name="hasta" type="text" class="form-control hasta " placeholder="Cierre" aria-describedby="sizing-addon3"  value="<?php echo $hasta ?>" id="hasta">
                    </div>
                </div>
                <br>
                <br>
                <br>
              </div>
        
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Clientes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                   <table id="dataTables-example" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <th>co_ven</th>
                                            <th>vendedor</th>
                                            <th>zona</th>
                                            <th>Cartera de clientes</th>
                                            <th>Clientes Nuevos</th>
                                            <th>Clientes Regulares</th>
                                            <th>Activacion</th>
                                          </tr>
                                          </thead>
                                             <tbody>
                                                <?php

                                                  $ttlClientes = 0;                   
                                                  if(count($cartera) > 0){
                                                  foreach ($cartera as $clien) {                         
                                                 ?>
                                                      <tr id="<?php echo  trim($clien['co_ven']);?>">
                                                        <td><?php echo  $clien['co_ven'];?></td>
                                                        <td><?php echo  utf8_encode($clien['ven_des']);?></td>
                                                        <td><?php echo  $clien['zon_des'];?></td>
                                                        <td class="text-right" id="clientes">
                                                          <span class="ven-clientes-actuales label label-default">
                                                            <?php echo  $clien['clientes'];?>
                                                            </span>
                                                          </td>
                                                        <td class="text-right" id="nuevos">
                                                          <span class="ven-clientes-actuales  label label-info">
                                                          <?php echo  $clien['clientemes'];?>
                                                           </span>
                                                            
                                                          </td>          
                                                        <td class="text-right" id="regulares">
                                                          <span class="ven-clientes-actuales  label label-success">
                                                          <?php echo  $clien['carteraActiv'];?>
                                                           </span>
                                                            
                                                          </td>     
                                                        <td class="text-right"><?php echo number_format($clien['porc'], 2, ",", "."); ?> %</td>
                                                     </tr>
                                                    <?php
                                                  }
                                                }
                                                 
                                                 ?>
                                              </tbody>
                                        <tfoot>
                          
                          
                                  </tfoot>
                                </table>
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
        </div>
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
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="../../js/fc.js"></script>
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
