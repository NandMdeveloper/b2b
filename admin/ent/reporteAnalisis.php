<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='3') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$arr_pedidos=$obj_pedidos->get_ped_sql();

$reporte= new reporte;//LLAMADO A LA CLASE DE PEDIDOS
$usuario=$_SESSION['usuario'];
$orden=null;


$desde="2016-01-01";
$hasta="2017-12-31";

if(isset($_GET['desde'])){
$desde = $_GET['desde'];
}
if(isset($_GET['hasta'])){
$hasta = $_GET['hasta'];
}
$vencidos = $reporte->getvencimiento($desde,$hasta,null);
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headC.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuC.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Analisis
                      <small>Vencimiento</small>
<a href="excelAnalisis.php?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>" target="_blanck" class="fa fa-file-excel-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a>

				</h1>

                </div>
				
                <div class="col-lg-12">
					 <form action="reporteAnalisis.php" method="GET" id="rango">
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
				</div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Aprobar Facturacion
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                      <tr>
                                   <th>Emisi&oacute;n</th>
              				<th>Vencimiento</th>
             				 <th>Condici&oacute;n</th>
              				<th>Factura</th>
              				<th>Nro. Documento</th>
              				<th>Monto</th>
					<th>Saldo</th>
              				<th>Dias</th>
								<th></th>     
                                      </tr>
                                    </thead>
                                    <tbody>
                                    	                    <?php


					$totalNeto = 0;
					$resto = 0;

					$totalSaldo = 0;
					for($i=0;$i<sizeof($vencidos);$i++){
						 $class="";

						 if($vencidos[$i]['dias'] < 0){
								$class=" class='text-danger'";
								}
							$fechaEmision =  $reporte->fechaNormalizada($vencidos[$i]['fec_emis']->format('Y-m-d H:i:s'));
							$fechaVencimiento =  $reporte->fechaNormalizada($vencidos[$i]['fec_venc']->format('Y-m-d H:i:s'));
						?>
          <tr <?php echo $class;?>>
              <td>
								<?php  echo $fechaEmision['fecha']; ?>
							</td>
            <td>
							<?php echo $fechaVencimiento['fecha'];?>
						</td>
              <td>
								<?php echo  $vencidos[$i]['condicion']; ?>
							</td>
              <td>
							<?php
								echo $vencidos[$i]['nro_doc'];
								?>
							</td>
              <td>
							<span class="cliente-oculto"><?php echo utf8_decode($vencidos[$i]['prov_des']); ?></span>
							<a href="clienteFacvencida.php?co_cliente=<?php echo $vencidos[$i]['co_prov']; ?>"  aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo utf8_decode($vencidos[$i]['cli_des']); ?>">
							<?php
							echo $vencidos[$i]['co_prov'];

							$nsaldo = $vencidos[$i]['saldo'];
							$neto = $vencidos[$i]['total_neto'] ;

							if(trim($vencidos[$i]['co_tipo_doc']) == "ADEL" or trim($vencidos[$i]['co_tipo_doc']) == "AJNA"
							or trim($vencidos[$i]['co_tipo_doc']) == "N/CR" or trim($vencidos[$i]['co_tipo_doc']) == "AJNM"
							 or trim($vencidos[$i]['co_tipo_doc']) == "IVAN"
								or trim($vencidos[$i]['co_tipo_doc']) == "IVAP"){

									$nsaldo = $vencidos[$i]['saldo'] * -1;
									$neto = $vencidos[$i]['total_neto'] * -1;
							}
							 $totalNeto = $totalNeto + ($neto);
							 $totalSaldo = $totalSaldo + ($nsaldo);
							?>
							</a>
						</td>
              <td class="text-right"><?php echo number_format($neto, 2, ",", "."); ?></td>
                <td class="text-right">

						<?php

							echo number_format($nsaldo, 2, ",", ".");
							?>
					</td>
					  <td><?php echo $vencidos[$i]['dias']; ?></td>
            <td class="center">
							<?php
								if(trim($vencidos[$i]['co_tipo_doc'])=="FACT"){
							?>
                <form action="reporteAnalisisFactura.php" method="POST">
                    <button name="doc_num" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $vencidos[$i]['nro_doc']; ?>"><i class="fa fa-eye"></i> Ver</button>
                </form>
								<?php
							}
								?>
            </td>
                        </tr>
                <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
    <div class="col-xs-12">
        <div class="box">
        <div class="box-header">
          <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
<!--
							<tr>
							<td class="text-right">
									<b>Monto neto :  </b>
									<?php
										echo number_format($totalNeto , 2, ",", ".");
									?>
								</td>

							 </tr>

								<tr>
								  <td class="text-right">

									<b>Saldo Seleccionado:  </b>
									<?php
										echo number_format($totalSaldo , 2, ",", ".");
									?>
								  </td>
								</tr>
							-->
								<tr>
								  <td class="text-right">
									<b>Saldo total Actual:  </b>
									<?php
									$sal = $reporte->getSaldos(null);
										echo number_format($sal['saldo'] , 2, ",", ".");

									?>
								  </td>
								</tr>


            </thead>

          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
        </div>
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script src="../../js/jquery-ui.min2.js"></script>
    <script src="../../js/fc.js"></script>
    
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

