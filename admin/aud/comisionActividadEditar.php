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

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}else{
  $mensa = "Debe seleccionar un periodo";
  $comision->setMensajes('info',$mensa);
  header("Location: comisionActividad.php");  
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
        <small>Actividad</small>
            </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
          <form action="comisionActividad.php" method="GET" id="rango">
           <div class="col-xs-6">
            <div class="col-xs-6">
              <div class="input-group input-group-sm">
                <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="desde" type="text" class="form-control fecha" placeholder="Inicio" aria-describedby="sizing-addon3" required>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="input-group input-group-sm">
                <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                <input name="hasta" type="text" class="form-control hasta" placeholder="Cierre" aria-describedby="sizing-addon3">
              </div>
            </div>
          
          </div>
          <br>
          <?php
            if(isset($_GET['hasta'])){
          ?>
          <div class="col-xs-6">

            <div class="col-xs-12 text-right lead">
              <?php
                $nDesde = $_GET['desde'];
                $nHasta = $_GET['hasta'];

                $nDesde = $reporte->fechaNormalizada($nDesde.=" 00:00:00");
                $nHasta = $reporte->fechaNormalizada($nHasta.=" 00:00:00");

               echo $nDesde['fecha']; ?>  <i class="fa fa-arrow-right" aria-hidden="true">  </i>
               <?php
                 echo $nHasta['fecha'];
               ?>

            </div>
          </div>
            <?php
            }
            ?>
                 <?php
        if(isset($_SESSION["msn-tipo"])){
        $comision->getMensajes();
        }
        $periodo = $comision->getPeriodos($id,null,null);
        $chk_a ="";
        $chk_i ="";
        if ($periodo[0]['estatus'] == "Activo") {
            $chk_a = " checked='checked' ";
        }
        if ($periodo[0]['estatus'] == "Inactivo") {
            $chk_i = " checked='checked' ";
        }
         
      ?>
          <br>
          </form>
      <div class="row">
          <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">Editar periodo</div>
                <div class="panel-body">
					<form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=editarPeriodo">
            <input type="hidden" name="id" value="<?php echo $periodo[0]['id'] ?>">
					  <fieldset>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Vendedor</label>
              <div class="col-lg-10">
                <select class="form-control nombreGerente  select-vendedor" id="co_ven" required="" name="co_ven">
                  <option value="<?php echo $periodo[0]['co_ven']; ?>"><?php echo $periodo[0]['ven_des']; ?></option>
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
              <label for="select" class="col-lg-2 control-label">Tipo</label>
              <div class="col-lg-10">
        
                <select class="form-control" id="tipo" name="tipo">
                  <option value="<?php echo $periodo[0]['tipo']; ?>"><?php echo $periodo[0]['tipo']; ?></option>
                  <option value="Vendedor">Vendedor</option>
                  <option value="Gerente">Gerente</option>
                </select>
                <br>
              </div>
            </div>
               <?php
               $region_actual ="Sin region";
               if ($periodo[0]['region'] > 0) {
                  $region_actual = $comision->getRegiones($periodo[0]['region']);
                  $region_actual = $region_actual[0]['nombre'];
               }
               
                ?>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Región</label>
              <div class="col-lg-10">
                <select class="form-control" id="select" required="" name="region">
                  <option value="<?php echo $periodo[0]['region']; ?>"><?php echo utf8_encode($region_actual) ?></option>
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
              <label for="inputEmail" class="col-lg-2 control-label">Inicio</label>
              <div class="col-lg-4">
              <input class="form-control fecha" name="desde"  id="desde" placeholder="Fecha inicio" type="text" value='<?php echo $periodo[0]['desde']; ?>'>
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Final</label>
              <div class="col-lg-4">
              <input class="form-control fecha" name="hasta"  id="hasta" placeholder="Fecha de finalización 1" type="text" value='<?php echo $periodo[0]['hasta']; ?>'>
              </div>
            </div>
				  <div class="form-group">
              <label class="col-lg-2 control-label">Estado</label>
              <div class="col-lg-4">
                <div class="radio">
                  <label>
                    <input name="estatus" id="estatus" value="Activo" <?php echo  $chk_a ?> type="radio">
                    Activo
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input name="estatus" id="estatus" value="Inactivo" <?php echo  $chk_i ?> type="radio">
                    Inactivo
                  </label>
                </div>
              </div>
            </div>

						<div class="form-group">
						  <div class="col-lg-10 col-lg-offset-2">
							<button type="reset" class="btn btn-default">Cancelar</button>
              <button type="submit" class="btn btn-primary">Editar periodo de actividad</button>
							<a href="comisionActividad.php"  class="btn btn-success">Crear nueva</a>
						  </div>
						</div>
					  </fieldset>
					</form>
       		 </div>
        </div>
        </div>
        <div class="col-xs-4">
          
					<div class="alert alert-dismissible alert-info">
					  <strong>Datos</strong> agregue los datos necesarios para crear el periodo </a>.
					</div>
					<div class="alert alert-dismissible alert-info">
					  <strong>Estado</strong> el estado el cual esta segun el periodo</a>.
					</div>
					<div class="alert alert-dismissible alert-info">
					  <strong>Periodos</strong> apartir de este el sistema tomara los periodos y funcion segun la actividad</a>.
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
                        <th>ID</th>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>TIPO</th>
                        <th>DESDE</th>
                        <th>HASTA</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $periodos = $comision->getPeriodos(null,$desde,$hasta);

                          for($i=0;$i<sizeof($periodos);$i++){
                                $desde = $comision->fechaNormalizada($periodos[$i]['desde']);
                                $hasta = $comision->fechaNormalizada($periodos[$i]['hasta']);
                                
                                $class="";
                              
                                if ($periodos[$i]['estatus']=="Inactivo") {
                                   $class="class='danger'";
                                }
                               
                            ?>
                              <tr  <?php echo $class; ?>>
                                <td><?php echo $periodos[$i]['id']; ?></td>
                                   <td>
                                  <?php echo utf8_encode($periodos[$i]['co_ven']); ?> 
                                 </td>
                                <td><?php echo utf8_encode($periodos[$i]['ven_des']); ?></td>    
                                <td><?php echo $periodos[$i]['tipo']; ?></td>                       
                                <td><?php echo $desde ; ?></td>
                                <td><?php echo $hasta; ?></td>
                                <td>
                                   <a href="comisionActividadEditar.php?id=<?php echo $periodos[$i]['id']; ?>&desde=<?php echo $periodos[$i]['desde']; ?>&hasta=<?php echo $periodos[$i]['hasta']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                </td>

                              </tr>
                            <?php
                          }
                         ?>
                      </tbody>
                      <tfoot>
                      <tr>
                         <th>ID</th>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>TIPO</th>
                        <th>DESDE</th>
                        <th>HASTA</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
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
    <script src="../../js/select2.min.js"></script>

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

         $('.select-vendedor').select2();
    });
    </script>
</body>

</html>
