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
$gerente = $comision->getGerentesRegional($id);
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
                <div class="panel-heading">Editar gerente regional</div>
                <div class="panel-body">
                						<form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=editargerenteregional">
					  <input type="hidden" name="idg" value="<?php  echo $gerente['datos'][0]['id']?>">
            <fieldset>
		            <div class="form-group">
              <label for="select" class="col-lg-4 control-label">Vendedor</label>
              <div class="col-lg-8">
                      <?php 
                      $desVendedor = $comision->getvendedores($gerente['datos'][0]['co_ven']);
                      
                      ?>

                <select class="form-control nombreGerente" id="co_ven" required="" name="co_ven">
                  <option value="<?php echo $gerente['datos'][0]['co_ven']; ?>">
                    <?php echo $desVendedor[0]['ven_des']; ?>
                  </option>
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
                    $gerRegional = $comision->getGerentesVenta($gerente['datos'][0]['gerenteventa_id']);
                    $gerentess = $comision->getGerentesVenta(null);
                    ?>
                <select class="form-control" id="select" required=""  name="gerente">
                  <option  value="<?php  echo $gerRegional['datos'][0]['id']?>"><?php echo utf8_encode($gerRegional['datos'][0]['nombre']." ".$gerRegional['datos'][0]['apellido']); ?></option>
                  <?php
                    for($y=0; $y < count($gerentess['datos']); $y++){
                   ?>
                      <option value="<?php  echo $gerentess['datos'][$y]['id']; ?>"><?php echo utf8_encode($gerentess['datos'][$y]['nombre']." ".$gerentess['datos'][$y]['apellido']); ?></option>
                  <?php
                    }
                   ?>
                </select>
                <br>
              </div>
            </div>
            <div class="form-group">
              <?php
                $region_actual = $comision->getRegiones($gerente['datos'][0]['cmsRegion_id']);
                ?>
              <label for="select" class="col-lg-4 control-label">Región</label>
              <div class="col-lg-8">
                <select class="form-control" id="select" required="" name="region">

                  <option value="<?php echo  $region_actual[0]['id'] ?>"><?php echo utf8_encode($region_actual[0]['nombre']) ?></option>
                  <?php
                    $regiones_sel= $comision->getRegiones(null);
                    for($y=0;$y < count($regiones_sel); $y++){
                      ?>
                        <option value="<?php echo $regiones_sel[$y]['id'] ?>"><?php echo $regiones_sel[$y]['nombre'] ?></option>
                      <?php

                    }
                   ?>
                </select>
                <br>
              </div>
            </div>
				<div class="form-group">
              <label class="col-lg-2 control-label">Estado</label>
              <?php

                $chka = "";
                $chki = " checked='checked'";
                if($gerente['datos'][0]['estado']=="Activo"){
                  $chka = "checked";
                  $chki = "";
                }else{
                  $chka = "";
                  $chki = "checked";

                }
               ?>
              <div class="col-lg-4">
                <div class="radio">
                  <label>
                    <input name="estado" id="estado" value="Activo" <?php echo $chka; ?> type="radio">
                    Activo
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input name="estado" id="estado" value="Inactivo" <?php echo $chki; ?> type="radio">
                    Inactivo
                  </label>
                </div>
              </div>

            </div>
						<div class="form-group">
						  <div class="col-lg-10 col-lg-offset-2">
							<button type="reset" class="btn btn-default">Cancelar</button>
              <button type="submit" class="btn btn-success">Editar</button>
						  </div>
						</div>
					  </fieldset>
					</form>	
					          <div class="well">
            <form class="form-horizontal" method="post" action="controlcomisiones.php?opcion=asignarZona">
              <fieldset>
                <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Zona</label>

                <input type="hidden" name="idgerente" value="<?php  echo $gerente['datos'][0]['id']?>">
                <input type="hidden" name="idregion" value="<?php echo  $region_actual[0]['id'] ?>">
                <div class="col-lg-6">
                    <?php
                      $zona = $comision->getZonas(null);
                      ?>
                  <select class="form-control" id="select" required=""  name="zona">
                  <?php
                      for($y=0; $y < count($zona); $y++){
                     ?>
                    <option value="<?php  echo $zona[$y]['zon_des']?>"><?php  echo $zona[$y]['zon_des']?></option>
                    <?php
                      }
                     ?>
                  </select>
                  </div>
                    <div class="col-lg-4">
                      <button type="submit" class="btn btn-primary">Agregar</button>

                     <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
              Vendedores
          </button>
                  </div>


              </div>
              </fieldset>
            </form>
            <table class="table table-striped table-hover ">
              <thead>
                <tr>
                  <th>Zona</th>
                </tr>
              </thead>
              <tbody>
                 <?php
                 $zonasCod = array();
                   $gerentes= $comision->getZonasgerente($region_actual[0]['id']);
                   if (sizeof($gerentes) > 0) {
                     for($i=0;$i < sizeof($gerentes); $i++){
                      $zonasCod[] = $gerentes[$i]['zona'];
                       ?>
                         <tr>
                           <td>
                             <?php echo $gerentes[$i]['zona']; ?>
                           </td>
                           <td>
                             <form action="controlcomisiones.php?opcion=quitarZona" method="post">
                                  <input type="hidden" value="<?php echo $gerentes[$i]['id']; ?>" name="id">
                                  <input type="hidden" value="<?php echo $gerente['datos'][0]['id']?>" name="idgerente">
                                 <button name="gerenteregional_id" type="submit" class="btn btn-danger btn-sm " value="<?php echo $gerentes[$i]['cmsRegion_id']; ?>"><i class="fa fa-trash"></i></button>
                             </form>
                           </td>
                         </tr>
                       <?php
                     }
                   } else {
                    ?>
                    <tr>
                      <td colspan="2">
                        Sin zonas asignadas
                      </td>
                    </tr>
                    <?php
                   }
                  ?>
              </tbody>
            </table>
          </div>		
                  <div id="myModal" class="modal fade " role="dialog">
            <div class="modal-dialog modal-lg">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Vendedores para: <?php echo $region_actual[0]['nombre'] ?></h4>
                </div>
                <div class="modal-body">
                  <p>
                    <?php
                    $vendedores = array();
                      if(count($zonasCod) > 0){ 
                        $vendedores = $comision->getvededoresZona($zonasCod);
                      }
                     
                     ?>
                     <div class="box">
                        <div class="box-header">
                          <h3 class="box-title"></h3>
                        </div>
                        <div class="box-body">
                          <div class="box-body">
                            <table id="tablaPQ" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>Nombre</th>
                                  <th>Región</th>
                              
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  if (count($vendedores) > 0) {
                                        for($i=0;$i < sizeof($vendedores); $i++){
                                      ?>
                                      <tr>
                                        <td><?php echo $vendedores[$i]['co_ven']?></td> 
                                        <td><?php echo $vendedores[$i]['ven_des']?></td>
                                        <td><?php echo $vendedores[$i]['zon_des']?></td> 
                                  
                                       </tr>
                                      <?php
                                    }
                                  } else {
                                   ?>
                                      <tr>
                                        <td>Sin vendedores</td>
                                        <td></td>
                                        <td></td>
                                  
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
                                </tr>
                                </tfoot>
                              </table>
                        </div>
                      </div>
                    <!-- /.box -->
                  </div>
                  </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>	
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
