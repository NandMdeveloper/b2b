<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');

include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$comision =  new comision();
$reporte =  new reporte();

$usuario=$_SESSION['user'];

if (isset($_GET['desde'])) {
  $desde = $_GET['desde'];
  $hasta = $_GET['hasta'];
} else {

  $mes = date("m");
  $ultimoDia = $comision->getUltimoDiaMes(date("Y"),$mes);
  $hasta = date("Y")."-".$mes."-".$ultimoDia;
  $desde = date("Y")."-".$mes."-01";
}
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuA.php'); ?>

        <div id="content">

          <div class="col-lg-12">
           <h1>
        Agregar
        <small>Gerente regional</small>
            </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>

      <div class="row">
          <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">Crear gerente regional</div>
                <div class="panel-body">
                					<form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=agregargerenteregional">
					  <fieldset>
            <div class="form-group">
              <label for="select" class="col-lg-4 control-label">Vendedor</label>
              <div class="col-lg-8">
                <select class="form-control nombreGerente select-vendedor" id="co_ven" required="" name="co_ven">
                  <option value=""></option>
                  <option value="VACANTE">VACANTE</option>
                  <?php
                    $regiones_sel= $comision->getvendedores(null);
                    for($y=0;$y < count($regiones_sel); $y++){
                      ?>
                        <option value="<?php echo $regiones_sel[$y]['co_ven'] ?>">
                          <?php echo $regiones_sel[$y]['ven_des'] ?></option>
                      <?php

                    }
                   ?>

                </select>
                <br>
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-4 control-label">Gerente ventas</label>
              <div class="col-lg-8">
                  <?php
                    $gerente = $comision->getGerentesVenta(null);
                  ?>
                <select class="form-control" id="select" required=""  name="gerente">
                  <option value=""></option>
                  <?php

                    for($y=0; $y < count($gerente['datos']); $y++){
                   ?>
                  <option value="<?php  echo $gerente['datos'][$y]['id']?>">
                   
                    <?php  echo $gerente['datos'][$y]['nombre']?>
                     <?php  echo $gerente['datos'][$y]['apellido']?>
                       
                     </option>
                  <?php
                    }
                   ?>
                </select>
                <br>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-4 control-label">Región</label>
              <div class="col-lg-8">
                <select class="form-control" id="select" required="" name="region">
                  <option value=""></option>
                  <?php
                    $regiones_sel= $comision->getRegiones(null);
                    for($y=0;$y < count($regiones_sel); $y++){
                      ?>
                        <option value="<?php echo $regiones_sel[$y]['id'] ?>"><?php echo utf8_encode($regiones_sel[$y]['nombre']) ?></option>
                      <?php

                    }
                   ?>

                </select>
                <br>
              </div>
            </div>
				<div class="form-group">
              <label class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-4">
                <div class="radio">
                  <label>
                    <input name="estatus" id="estatus" value="Activo" checked="" type="radio">
                    Activo
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input name="estatus" id="estatus" value="Cancelado" checked="" type="radio">
                    Cancelado
                  </label>
                </div>
              </div>

            </div>
						<div class="form-group">
						  <div class="col-lg-10 col-lg-offset-2">
							<button type="reset" class="btn btn-default">Cancelar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						  </div>
						</div>
					  </fieldset>
					</form>
       		 </div>
        </div>
        </div>
        <div class="col-xs-4">
          
					<div class="alert alert-dismissible alert-info">
					  <strong>Datos</strong> agregue los datos necesarios para crear el gerente </a>.
					</div>
					<div class="alert alert-dismissible alert-info">
					  <strong>Estatus</strong> Estado del gerente</a>.
					</div>
					<div class="alert alert-dismissible alert-info">
					  <strong>Gerente de ventaas</strong> seleccionar gerente a la cual es subordinado el gerente regional</a>.
					</div>
        </div>
      </div>

      </div>
          <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">lista de actividades</div>
                    <div class="panel-body">
                        <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title"></h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">                                 
                                <table id="dataTables-example" class="table table-bordered table-striped">
       
                    
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Región</th>
                        <th>Estado</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $gerentes = $comision->getGerentesRegional(null);

                          for($i=0;$i<sizeof($gerentes['datos']);$i++){

                            ?>
                              <tr>
                                <td><?php echo $gerentes['datos'][$i]['id']; ?></td>
                                <td>
                                  <?php echo utf8_encode($gerentes['datos'][$i]['ven_des']); ?> 
                                 </td>
                                <td><?php echo  utf8_encode($gerentes['datos'][$i]['region']) ; ?></td>
                                <td class="text-center"><?php echo $gerentes['datos'][$i]['estado']; ?></td>
                                <td>
                                  <form action="comisionagregargerenteReditar.php?id" method="get">
                                      <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $gerentes['datos'][$i]['id']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                  </form>
                                </td>

                              </tr>
                            <?php
                          }
                         ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Región</th>
                        <th>Estado</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                                </div>
                                <!-- /.box-body -->
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
         $('.select-vendedor').select2();
    });
    </script>
</body>

</html>
