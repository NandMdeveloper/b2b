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
$id = $_GET['id'];
$reg = $comision->getRegiones($id);
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
        <small>región</small>
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
                <div class="panel-heading">Editar una región</div>
                <div class="panel-body">
					<form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=editarregion">
					  <fieldset>
						<div class="form-group">
						  <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
						  <div class="col-lg-10">
							<input class="form-control" name="nombre"  id="nombre" placeholder="Nombre para la región" type="text" required  pattern=".{5,25}" maxlength="25" value="<?php  ECHO $reg[0]['nombre']; ?>">
							<input name="idr" value="<?php  ECHO $reg[0]['id']; ?>" type="hidden">
						  </div>
						</div>
						<div class="form-group">
              <?php
              $chk = "";
              if($reg[0]['estatus']){
                    $chk = " checked='checked'";

              }

               ?>
						  <label for="inputEmail" class="col-lg-2 control-label">Estado</label>
						  <div class="col-lg-10">
                <div class="checkbox">
                  <label>
                  <input type="checkbox" id="estatus"  name="estatus" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="La comisión será permanente" <?php echo $chk; ?>> Activo
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
                        <th>Modificado</th>
                        <th>Estado</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $comisiones = $comision->getRegiones(null);

                          for($i=0;$i<sizeof($comisiones);$i++){
                              $st = " Inactivo";
                              if($comisiones[$i]['estatus']==1){
                                  $st = "Activo";

                              }

                            ?>
                              <tr>
                                <td><?php echo $comisiones[$i]['id']; ?></td>
                                <td><?php echo $comisiones[$i]['nombre']; ?></td>
                                <td><?php echo $comisiones[$i]['modificacion']; ?></td>
                                <td><?php echo $st; ?></td>
                                <td>
                                  <form action="comisionEditarregion.php" method="GET">
                                      <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $comisiones[$i]['id']; ?>"><i class="fa fa-eye"></i> Ver</button>
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
                        <th>Modificado</th>
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
