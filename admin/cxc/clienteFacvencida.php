<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");

$reporte= new reporte;//LLAMADO A LA CLASE DE PEDIDOS
$usuario=$_SESSION['usuario'];
$coCliente = null;
if(isset($_GET['co_cliente'])){
	$coCliente = $_GET['co_cliente'];

}
	//$vencidos=$reporte->getvencimientoCliente($coCliente);
	$desde="2016-01-01";
	$hasta="2017-12-31";
	$vencidos=$reporte->getvencimiento($desde,$hasta,$coCliente);
	 $url = $_SERVER['HTTP_REFERER'];

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headT.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuT.php'); ?>
  <div class="content">
        <div id="content">
                <div class="col-lg-12">
                    <h1><a href="<?php echo $url; ?>"><span class="fa fa-undo" title="Regresar"></span></a>
					Analisis <?php echo utf8_encode($vencidos[0]['cli_des']); ?>
					<small>Vencimientos</small>
				  </h1>
                </div>
                <div class="col-lg-12">
                    <section class="content">
					  <div class="row">
						<div class="col-xs-12">
							<h2></h2>
						</div>

						<div class="col-xs-12">
							<div class="box">
							<div class="box-header">
							  <h3 class="box-title"></h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
							  <table id="example1" class="table table-bordered table-striped">
								<thead>
								<tr>
								  <th>Emisión</th>
								  <th>Vencimiento</th>
								  <th>Tipo</th>
								  <th>Número</th>
								  <th>Monto</th>
								  <th>Saldo</th>
								  <th>Dias</th>
								  <th></th>
								</tr>
								</thead>
								<tbody>
									<?php
									$total = 0;
									for($i=0;$i<sizeof($vencidos);$i++){
										 $class="";
										 $fechaEmision =  $reporte->fechaNormalizada($vencidos[$i]['fec_emis']->format('Y-m-d H:i:s'));
										 $fechaVenc =  $reporte->fechaNormalizada($vencidos[$i]['fec_venc']->format('Y-m-d H:i:s'));
										 /*if($vencidos[$i]['dias'] < 0){
												 $class=" class='text-danger'";

											}*/
										$total = $total + $vencidos[$i][7];
									?>
										  <tr <?php echo $class;?>>
												<td><?php echo $fechaEmision['fecha']; ?></td>
												<td><?php echo $fechaVenc['fecha']; ?></td>
												<td><?php echo $vencidos[$i]['descrip']; ?></td>
												<td class="text-right"><?php echo $vencidos[$i]['nro_doc']; ?></td>
												<td class="text-right"><?php echo number_format($vencidos[$i]['total_neto'], 2, ",", "."); ?></td>
												<td class="text-right"><?php echo number_format($vencidos[$i]['saldo'], 2, ",", "."); ?></td>
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
									<?php


									}
									$sal = $reporte->getSaldos($coCliente);
				?>

								</tbody>
								<tfoot>
								<tr>
								  <th>Emisión</th>
								  <th>Vencimiento</th>
								  <th>Tipo</th>
								  <th>Número</th>
								  <th>Cliente</th>
								  <th>Monto</th>
									<th>Saldo</th>
									<th>Dias</th>
								</tr>
								</tfoot>
							  </table>
							   <table class="table table-bordered table-striped">
								<!--<tr>
									<td class="text-right"><b>Factura cobradas: </b> </td>
									<td><?php //echo  number_format(($prueba)*-1, 2, ",", "."); ?></td>
								</tr>
								<tr>
									<td class="text-right"><b>Factura por cobrar: </b></td>
									<td class="text-left"> </td>
								</tr>
								<tr>
									<td class="text-right"><b>Nota de crédito: </b></td>
									<td class="text-left"><?php echo  number_format(($tncr), 2, ",", "."); ?></td>
								</tr>
								<tr>
									<td class="text-right"><b>Nota de débito: </b></td>
									<td class="text-left"><?php echo  number_format(($tndb), 2, ",", "."); ?></td>
								</tr>
								<tr>
									 <td class="text-right"><b>Cheques devueltos: </b></td>
									 <td class="text-left"><?php echo  number_format(($tcheq), 2, ",", "."); ?></td>
								</tr>
								<tr>
									 <td class="text-right"><b>Adelantos: </b></td>
									 <td class="text-left"><?php echo  number_format(($adelantos), 2, ",", "."); ?></td>
								</tr> -->
								<tr>

									 <td class="text-right"><b>Saldo: </b><?php echo number_format($sal['saldo'] , 2, ",", "."); ?></td>
								</tr>
							   </table>
							</div>
							<!-- /.box-body -->
						  </div>
						  <!-- /.box -->
						</div>
						<!-- /.col -->
					  </div>

					  <div class="row">
						<div class="col-xs-12">
							<h2></h2>
						</div>

						<div class="col-xs-12">
							<div class="box">
							<div class="box-header">
							  <h3 class="box-title"></h3>
							</div>

							<!--<div class="box-body">
								<img src="ppg.php?cliente=<?php echo $coCliente; ?>" class="img-responsive">
							</div> -->

						  </div>
						</div>
					  </div>
					</section>
                   
                </div>
                <!-- /.col-lg-12 -->
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
