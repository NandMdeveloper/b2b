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
              Creación
              <small>presupuesto</small>
            </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
          <form action="comisionMetavendedor.php" method="GET" id="rango">
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
          <br>
          </form>
      <div class="row">
          <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-heading">Crear una meta para Vendedor</div>
                <div class="panel-body">
          <form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=agregarMetaVendedor">
            <fieldset>
            <?php
            $gRegionales = $comision->getvendedores(null);
            //var_dump($gRegionales);
             ?>
             <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Vendedor</label>
              <div class="col-lg-10">
                <select class="form-control vacante" name="co_ven" required>
                  <option></option>
                  <option value='VACANTE'>VACANTE</option>
                  <?php
                  for ($i=0; $i < count($gRegionales) ; $i++) {
                  ?>
                      <option value="<?php echo $gRegionales[$i]['co_ven']; ?>"><?php echo $gRegionales[$i]['ven_des']." (".$gRegionales[$i]['co_ven'].")"; ?></option>
                  <?php
                  }
                   ?>
                </select>
              </div>
            </div>
              <div class="form-group hidden" id="nzonas">
                <label for="select" class="col-lg-2 control-label">Zona</label>               
                <div class="col-lg-6">
                    <?php
                      $zona = $comision->getZonas(null);
                      ?>
                  <select class="form-control" id="zona" name="zona">
                    <option></option>
                  <?php
                      for($y=0; $y < count($zona); $y++){
                     ?>
                    <option value="<?php  echo $zona[$y]['zon_des']?>"><?php  echo $zona[$y]['zon_des']?></option>
                    <?php
                      }
                     ?>
                  </select>
                  </div>     
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Presupuesto</label>
              <div class="col-lg-10">
              <input class="form-control preciosforma" name="presupuesto"  id="presupuesto" placeholder="Presupuesto para la región" type="text" required  pattern=".{0,25}" maxlength="25" >
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Inicio</label>
              <div class="col-lg-3">
              <input class="form-control fecha" name="desde" id="desde" placeholder="Fecha inicio" type="text" required value="<?php echo  $desde ?>">
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Final</label>
              <div class="col-lg-3">
              <input class="form-control fecha" name="hasta" id="hasta" placeholder="Fecha de finalización 1" type="text" required  value="<?php echo  $hasta ?>">
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
            <strong>Datos</strong> agregue los datos necesarios para crear el presupuesto </a>.
          </div>
          <div class="alert alert-dismissible alert-info">
            <strong>Vacante</strong> si elige un presupuesto vancante no olvide seleccionar su zona </a>.
          </div>
        </div>
      </div>

      </div>
          <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">lista de presupuesto</div>
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
                        <th class="text-right">Presupuesto</th>
                        <th class="text-right">Modificado</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          $mtVendedores = $comision->getMetasVendedores(null,null,$desde,$hasta);
                          $totalPresupuesto = 0;

                          if(count($mtVendedores) > 1) {
                          
                            for($i=0;$i<sizeof($mtVendedores);$i++){
                              $nDesde = $comision->fechaNormalizada($mtVendedores[$i]['desde']);
                              $nHasta = $comision->fechaNormalizada($mtVendedores[$i]['hasta']);
                               $totalPresupuesto+=$mtVendedores[$i]['presupuesto'];
                              ?>
                                <tr>
                                  <td><?php echo $mtVendedores[$i]['id']; ?></td>
                                  <td>
                                    <?php
                                    if(!empty($mtVendedores[$i]['ven_des'])){
                                     echo $mtVendedores[$i]['ven_des']; 
                                    }else{
                                      echo "<b>VACANTE -</b> ".$mtVendedores[$i]['zona']; 

                                    }
                                  ?>
                                  </td>
                                  <td class="text-right">
                                    <?php echo number_format($mtVendedores[$i]['presupuesto'], 2, ",", "."); ?>
                                      
                                    </td>
                                  <td class="text-right"><?php echo $nDesde." <span class='text-info'> al </span> ".$nHasta; ?></td>
                                  <td>
                                   <a href="comisionMetaVendEditar.php?id=<?php echo $mtVendedores[$i]['id'];?>&hasta=<?php echo $hasta; ?>&desde=<?php echo $desde; ?>" class='btn btn-primary btn-xs btn-block'> Ver</a>
                         
                                  </td>

                                </tr> 
                              <?php
                            }

                          }
                         ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th></th>
                        <th class="text-right">Total: </th>
                        <th class="text-right">
                          <?php 
                               echo number_format($totalPresupuesto, 2, ",", ".");  
                          ?>
                        </th>
                        <th class="text-right">Modificado</th>
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
