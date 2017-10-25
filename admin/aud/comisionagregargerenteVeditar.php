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
$id= $_GET['id'];
$gerente = $comision->getGerentesVenta($id);

$estado = $gerente['datos'][0]['estado'];

$chk_ac="";
$chk_can=" checked='checked'";
if($estado=="Activo"){
  $chk_ac=" checked='checked'";
  $chk_can="";
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
        Editar
        <small>Gerente ventas</small>
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
                <div class="panel-heading">Editar gerente</div>
                <div class="panel-body">
					<form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=agregargerenteventaeditar">
					  <input type="hidden" name='id' value="<?php echo $id; ?>">
					  <fieldset>
						<div class="form-group">
						  <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
						  <div class="col-lg-4">
							<input class="form-control" name="nombre"  id="nombre" placeholder="Nombre del gerente" type="text" required  pattern=".{3,25}" maxlength="25" value="<?php  echo $gerente['datos'][0]['nombre']?>" >
						  </div>
						  <label for="inputEmail" class="col-lg-2 control-label">Apellido</label>
						  <div class="col-lg-4">
							<input class="form-control" name="apellido"  id="apellido" placeholder="Apellido del gerente" type="text" required  pattern=".{3,25}" maxlength="25"  value="<?php  echo $gerente['datos'][0]['apellido']?>">
						  </div>
						</div>
				<div class="form-group">
              <label class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-4">
                <div class="radio">
                  <label>
                    <input name="estatus" id="estatus" value="Activo" <?php echo $chk_ac; ?> type="radio">
                    Activo
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input name="estatus" id="estatus" value="Cancelado" <?php echo $chk_can; ?> type="radio">
                    Cancelado
                  </label>
                </div>
              </div>

            </div>
						<div class="form-group">
						  <div class="col-lg-10 col-lg-offset-2">
							<button type="reset" class="btn btn-default">Cancelar</button>
							<button type="submit" class="btn btn-primary">Editar</button>
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
                <div class="panel-heading">lista de gerentes de ventas </div>
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
                        <th>Apellido</th>
                        <th>Estado</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $gerentes = $comision->getGerentesVenta(null);

                          for($g=0;$g < count($gerentes['datos']);$g++){

                            ?>
                              <tr>
                                <td><?php echo $gerentes['datos'][$g]['id']; ?></td>
                                <td><?php echo $gerentes['datos'][$g]['nombre']; ?></td>
                                <td><?php echo $gerentes['datos'][$g]['apellido']; ?></td>
                                <td class="text-center"><?php echo $gerentes['datos'][$g]['estado']; ?></td>

                                <td>
                                  <form action="comisionagregargerenteVeditar.php" method="get">
                                      <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $gerentes['datos'][$g]['id']; ?>"><i class="fa fa-eye"></i> Ver</button>
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
                        <th>Apellido</th>
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
    });
    </script>
</body>

</html>
