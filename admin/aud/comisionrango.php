<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$arr_pedidos=$obj_pedidos->get_ped_sql();
  $comision =  new comision();
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
                    <small>Calculo</small>

                  </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
                           <form action="controlcomisiones.php?opcion=muestra" method="POST" id="rango">
                                 <div class="col-md-6">
                                  <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                      <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                                      <input name="desde" type="text" class="form-control fecha"   placeholder="Inicio" aria-describedby="sizing-addon3" required>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                      <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                                      <input name="hasta" type="text" class="form-control fecha"  placeholder="Cierre" aria-describedby="sizing-addon3">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                       <div class="col-md-4">
                                         <div class="radio">
                                            <label>
                                              <input name="tipo" id="tipo" value="ventas" type="radio"  checked="">
                                              Ventas
                                            </label>
                                              <label>
                                              <input name="tipo" id="tipo" value="cobros" type="radio">
                                              Cobros
                                            </label>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                         <div class="form-group">
                                          <div class="col-lg-10 col-lg-offset-2">
                                            <button type="submit" class="btn btn-success">Calcular</button>
                                          </div>
                                        </div>
                                       </div>
                                        <div class="col-md-4">
                                          <div class="col-xs-3">
                                          <div class="input-group input-group-sm">
                                           <button type="button" class="btn btn-info pill-right"  data-toggle="modal" data-target="#modal-verhistoricos"> <i class="fa fa-clock-o" aria-hidden="true"></i>
                                              Ver historico </button>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                        <br>
                                </form>
                            <div class="col-xs-12">
                              <br>
                              <div class="alert alert-dismissible alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Seleccionar</strong> Un rango de fecha a consultar.
                              </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        <!-- /.col -->
                          </div>





                </div>
                <!-- /.col-lg-12 -->
        </div>
        <div id="modal-verhistoricos" class="modal fade" role="dialog" >
          <div class="modal-dialog  modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Historicos registrados</h4>
              </div>
              <div class="modal-body"  id='docs-modificar'>
              <div class="row">
          
                    <?php   $comision->getHistoricounoXMes(); ?>
                 
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
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
