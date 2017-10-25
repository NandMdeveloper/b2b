<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$comision =  new comision();
$reporte =  new reporte();
$usuario=$_SESSION['user'];


if (isset($_GET['id'])) {
  $id=$_GET['id'];
}else{
$id=$_POST['id'];

}
if (isset($_GET['desde'])) {
  $desde = $_GET['desde'];
  $hasta = $_GET['hasta'];
} else {
  $mes = date("m");
  $ultimoDia = $comision->getUltimoDiaMes(date("Y"),$mes);
  $desde = date("Y")."-".$mes."-".$ultimoDia;
  $hasta = date("Y")."-".$mes."-01";
}
$param = $comision->detalleUnparametro($id);
//var_dump($param);
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
              <small>parametros</small>
            </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
              <form action="comisonparametros.php" method="GET" id="rango">
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
              <br>
              <br>
          </form>
      <div class="row">
          <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">Editar prametros fijos</div>
                <div class="panel-body">
            <form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=editarparametro">
                      <fieldset>
                        <div class="form-group">
                          <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
                          <div class="col-lg-10">
                            <input class="form-control" name="nombre"  id="nombre" placeholder="Nombre para identificar el parametro" type="text" required value="<?php echo utf8_encode($param[0]['nombre']); ?>">
                            <input class="form-control" name="id"  id="id"  type="hidden"   value="<?php echo $param[0]['id']; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail" class="col-lg-2 control-label">Condición 1</label>
                          <div class="col-lg-4">
                                     <input class="form-control" name="limite1"  id="limite1" placeholder="Limite inicial al parametro" type="text" required  value="<?php echo $param[0]['limite1']; ?>">
                          </div>
              <label for="inputEmail" class="col-lg-2 control-label">Condición 2</label>
                               <div class="col-lg-4">
                            <input class="form-control" name="limite2"  id="limite2" placeholder="Limite al parametro" type="text" required value="<?php echo $param[0]['limite2']; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail" class="col-lg-2 control-label">Condición 3</label>
                          <div class="col-lg-4">
                            <input class="form-control" name="limite3"  id="limite3" placeholder="Limite al parametro" type="text" required value="<?php echo $param[0]['limite3']; ?>">
                          </div>
                          <label for="inputEmail" class="col-lg-2 control-label">Porcentaje</label>
                          <div class="col-lg-4">
                            <input class="form-control" name="porcentaje"  id="porcentaje" placeholder="Porcentaje" type="text" required value="<?php echo $param[0]['porcentaje']; ?>">
                          </div>
                        </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Cuenta</label>
              <div class="col-lg-4">
                <select class="form-control" name="cuenta">
                  <option value="<?php echo $param[0]['cuenta']; ?>"><?php echo $param[0]['cuenta']; ?></option>
                  <option value="Tradicional">Tradicional</option>
                  <option value="Clave">Clave</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
              <label for="select" class="col-lg-2 control-label">Tipo</label>
              <div class="col-lg-4">
                <select class="form-control" name="tipo">
                  <option value="<?php echo $param[0]['tipo']; ?>"><?php echo $param[0]['tipo']; ?></option>
                  <option value="Comision">Comision</option>
                  <option value="Reserva">Reserva</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Inicio</label>
              <div class="col-lg-4">
              <input class="form-control fecha" name="finicio"  id="finicio" placeholder="Fecha inicio" type="text" value="<?php echo $param[0]['desde']; ?>">
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Final</label>
              <div class="col-lg-4">
              <input class="form-control fecha" name="ffinal"  id="ffinal" placeholder="Fecha de finalización 1" type="text" value="<?php echo $param[0]['hasta']; ?>">
              </div>
            </div>
                        <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="cargar">Editar</button>
                          </div>
                        </div>
                      </fieldset>
                    </form>
        </div>
        </div>
        </div>
        <div class="col-xs-4">
          <div class="alert alert-dismissible alert-success">
            <strong>Datos </strong> agregue los datos necesarios para crear el combo de productos </a>.
          </div>
        </div>
      </div>
      </div>
           <div class="col-xs-12">
      <?php 
         $parametros = $comision->getParametrosEdicion($param[0]['desde'],$param[0]['hasta']);
        
        ?>
    </div>
          <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de Parametros</div>
                    <div class="panel-body">
                        <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title"></h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                 <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Cuenta</th>
                      <th>Tipo</th>
                      <th>Porcentaje</th>
                      <th>Cond 1</th>
                      <th>Cond 2</th>

                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
              <tbody>
                   <?php
                    
                  foreach ($parametros as $parametro) {

                    ?>
                        <tr>
                          <td><?php echo $parametro['id']; ?></td>
                          <td><?php echo utf8_encode($parametro['nombre']); ?></td>
                          <td><?php echo $parametro['cuenta']; ?></td>
                          <td><?php echo $parametro['tipo']; ?></td>
                          <td><?php echo $parametro['porcentaje']; ?></td>
                          <td><?php echo $parametro['limite1']; ?></td>
                          <td><?php echo $parametro['limite2']; ?></td>

                         <td>
                            <form action="comisonparametroseditar.php" method="POST">
                              <input type="hidden" value="<?php echo $desde; ?>" name="desde">
                              <input type="hidden" value="<?php echo $hasta; ?>" name="hasta">
                                <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $parametro['id']; ?>"><i class="fa fa-eye"></i> Ver</button>
                            </form>
                          </td>
                          <td>
                             
                            <a class="btn btn-danger fa fa-trash-o link-borrar" href="controlcomisiones.php?opcion=eliminarparametro&id=<?php echo $parametro['id']; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>" >
                          </a>
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
                    <th>Cuenta</th>
                    <th>Tipo</th>
                    <th>Porcentaje</th>
                    <th>Cond 1</th>
                    <th>Cond 2</th>

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
   <?php 
                $ediciones =  $comision->getauditoriaParametros();  

                if (count($ediciones)) {
                
              ?>
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

                                <h3 class="timeline-header"><a href="#"><?php  echo  $ed['usuario']; ?></a> <?php  echo  $ed['tipo']; ?> Parametro </h3>

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
                  
            
              
        <?php 
    
          }
        ?>
        <!-- /#page-wrapper -->
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
                  {
    "aLengthMenu": [[25, 50, 75, 100,200,-1], [25, 50, 75, 100,200,"Todo"]],
    "processing": true
}
        });
    });
    </script>
</body>

</html>
