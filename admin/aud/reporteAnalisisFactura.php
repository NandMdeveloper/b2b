<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");


$reporte= new reporte;//LLAMADO A LA CLASE DE PEDIDOS
$usuario=$_SESSION['user'];
$doc_num = null;
if(isset($_POST['doc_num'])){
	$doc_num = $_POST['doc_num'];
	$vencidos=$reporte->getCobroDocFactura($doc_num);
}

$factura=$reporte->getDetallefactura($doc_num);
	$class =" class='text-success'";
	if($factura->dias < 0 ){
			$class =" class='text-danger'";
	}

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuA.php'); ?>

        <div id="content">	
<br>		
			<div class="col-lg-12">
				<div class="panel panel-default">
				  <div class="panel-heading">Factura</div>
				  <div class="panel-body">
					  <h4> <?php echo $factura->cli_des; ?></h4>
					</div>
				</div>
			</div>
                  <section class="content">
					 
						<div class="col-xs-12">
						  <div class="panel panel-default">
							<div class="panel-heading">Detalles del factura <b>#<?php echo $factura->doc_num; ?></div>
								<div class="panel-body">
								  <div class="box">
									<!-- /.box-header -->
									<div class="box-body no-padding">
									  <table class="table table-striped">
										<tr>
										  <th>Descripción</th>
										  <th>Emisión</th>
										  <th>Vencimiento</th>
										  <th>Documento</th>
										  <th>Dias</th>
										</tr>
										<tr>
											<td><?php echo $factura->descrip; ?></td>
											<td><?php echo $factura->fec_emis->format('Y-m-d H:i:s'); ?></td>
											<td><?php echo $factura->fec_venc->format('Y-m-d H:i:s'); ?></td>
											<td><?php echo $factura->cond_des; ?></td>
											<td <?php echo $class;?>><b><?php echo $factura->dias; ?></b></td>
										</tr>
										<tr>
											<td class="text-right"><b>Total bruto: </b><?php echo number_format($factura->total_bruto, 2, ",", "."); ?></td>
											<td class="text-right"><b>Impuesto: </b><?php echo number_format($factura->monto_imp, 2, ",", "."); ?></td>
											<td class="text-right"><b>Neto: </b><?php echo number_format($factura->total_neto, 2, ",", "."); ?></td>
											<td class="text-right"  colspan="2"></td>
										</tr>
										<tr>
											<td>
												<span class="glyphicon glyphicon-phone text-info"></span>
												<?php echo $factura->telefonos; ?></td>
											<td colspan="2">
												<span class="glyphicon glyphicon-user glyphicon text-info"></span>
												<?php echo $factura->ven_des; ?></td>
											<td colspan="2">
											<span class="glyphicon glyphicon-map-marker text-info"></span>
											<?php echo $factura->direc1; ?></td>

										</tr>
									  </table>
									</div>
									<!-- /.box-body -->
								 </div>
						  </div>
						</div>
						  
						  <!-- /.box -->
						
						<!-- /.col -->
					  </div>
					  <div class="panel panel-default">
							<div class="panel-heading">  Documentos relacionados | Cobros</div>
								<div class="panel-body">
								<div class="col-xs-12">
							  <h2>
					 
						
					  </h2>
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
								  <th>Factura</th>
								  <th>Descripción</th>
								  <th>Documento</th>
								  <th>Monto</th>
								  <th>Iva</th>
								</tr>
								</thead>
								<tbody>
									<?php
									$total = 0;
									for($i=0;$i<sizeof($vencidos);$i++){
										 $class="";

										 if($vencidos[$i][1] < 0){
												 $class=" class='text-danger'";

											}

									?>
										  <tr <?php echo $class;?>>
												<td><?php echo $vencidos[$i]['doc_num']; ?></td>
											   <td><?php echo $vencidos[$i]['descrip']; ?></td>
												<td><?php echo $vencidos[$i]['tipodoc']; ?></td>
												<td class="text-right"><?php echo number_format($vencidos[$i]['mont_cob'], 2, ",", "."); ?></td>
												<td class="text-right"><?php echo number_format($vencidos[$i]['monto_retencion_iva'], 2, ",", "."); ?></td>

											</tr>
									<?php


									}

									?>

								</tbody>
								<tfoot>
								<tr>
								   <th>Factura</th>
									<th>Descripción</th>
									<th>Documento</th>
									<th>Monto</th>
									<th>Iva</th>
								</tr>
								</tfoot>
							  </table>
							</div>
							<!-- /.box-body -->
						  </div>
						  <!-- /.box -->
						</div>
						<!-- /.col -->
					  </div>
					  </div>
					  </div>

					</section>
                <!-- /.col-lg-12 -->
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
