<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');

include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$reporte = new reporte;//LLAMADO A LA CLASE DE PEDIDOS
$comision =  new comision();
$usuario=$_SESSION['user'];

/* RANGO DEL MES ACTUAL */
$mes = date("m");
$ultimoDia = $comision->getUltimoDiaMes(date("Y"),$mes);
$hasta = date("Y")."-".$mes."-".$ultimoDia;
$desde = date("Y")."-".$mes."-01";

if(isset($_GET['desde'])){
$desde = $_GET['desde'];
}
if(isset($_GET['hasta'])){
$hasta = $_GET['hasta'];
}

                $totalgeneralPresupuesto = 0;
                $totalgeneralventas = 0;

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuA.php'); ?>

        <div id="content">
            <br>
       <form action="comisionesRegiones.php" method="GET" id="rango">
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
  if(isset($hasta)){
?>
<div class="col-xs-6">

  <div class="col-xs-12 text-right lead">
    <?php

      $nDesde = $reporte->fechaNormalizada($desde.=" 00:00:00");
      $nHasta = $reporte->fechaNormalizada($hasta.=" 00:00:00");

     echo $nDesde['fecha']; ?>
     <i class="fa fa-arrow-right" aria-hidden="true">  </i>
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
    <?php
      $totaloficina = $comision->facturaVendedorFecha('010',$desde,$hasta);
       
      
       $var = $comision->mensajesRequerimientos($desde,$hasta);
    ?>
		  <div class="col-xs-12 comisiones">
            <div class="panel panel-default lead">
              <div class="panel-heading">Presupuesto General  <strong><span class="pull-right lead text-info ntotalporcentaje" ></span></strong></div>
              <div class="panel-body ">            
                    <table class="table table-striped table-hover ">
                          <thead>
                            <tr>
                              <th></th>
                              <th class="text-right">PRESUPUESTO</th>
                              <th class="text-right">PARTICIPACIÓN</th>
                              <th class="text-right">FACTURADO</th>
                              <th class="text-right">ALCANCE</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr> 
                              <td>TOTAL CANAL TRADICIONAL</td>
                              <td class="text-right"><span class="ntotalgeneral"></span></td>
                              <td class="text-right"><span class="nparticipaciontradicional"></span>  %</td>

                               <td class="text-right"><span class="ntotalventas"></span></td> 
                              <td class="text-right"><span class="ntotalporcentajetradicional" ></span></td>
                            </tr>
                          
                            <tr>
                              <td>TOTAL CANAL CUENTAS CLAVES</td> 
                              <td class="text-right"><span class="ntotalPresupuestoClaves"></span></td>
                              <td class="text-right"><span class="nparticipacionclave"></span>  %</td>
                              <td class="text-right"><span class="ntotalCuentasClaves"></span></td>
                              <td class="text-right"><span class="nalcanceClave"></span></td> 
                            </tr>
                            <tr>
                              <td>TOTAL PRO-HOME</td> 
                              <td class="text-right"><b><span class="ntotalPresupuestoProhome"></span></b></td>
                              <td class="text-right">100 %</td>
                              <td class="text-right"><b><span class="ntotalProhome"></span></b></td>
                              <td class="text-right"><span class="nporcantaleTotalProHome"></span></td> 
                            </tr>
                             <tr class="info">
                              <td>VENTAS POR OFICINA</td>
                              <td class="text-right"></td>
                              <td class="text-right"> </td>
                              <td class="text-right">
                                <?php echo  number_format($totaloficina['monto_base'], 2, ",", "."); ?>
                              </td>
                              <td> </td>
                            </tr> 
                             <tr>
                              <td>TOTAL VENTAS PRO-HOME</td> 
                              <td class="text-right"></td>
                              <td class="text-right"></td>
                              <td class="text-right"><b><span class="ntotalVentasProhome"></span></b></td> 
                              <td class="text-right"> </td>
                            </tr>
                           
                          </tbody>
                        </table> 
                     </div>
                </div>
            </div>
		
		
	<!-- Resumen de regiones ventas y presupuesto -->	    
     <div class="container-fluid">
              <?php

                $totalgeneralPresupuesto = 0;
                $totalgeneralventas = 0;

                /* BUSCAMOS LAS REGIONES  BUSCAMOS LAS REGIONES  BUSCAMOS LAS REGIONES */
                /* BUSCAMOS LAS REGIONES  BUSCAMOS LAS REGIONES  BUSCAMOS LAS REGIONES */

                $regiones = $comision->getRegiones(null);
				
                 for ($r=0; $r < count($regiones) ; $r++) {
                  
                  $zonas = array();
                  $vendedores = array();
                  $totales = array();

                  $eltotal = 0;
                  $presupuestoregional = 0;
                  $porcentajeTotal = 0;
                  $nombregerente = "<br>";
                  
                  /* BUSCAR GERENTES DE REGION EN ESTE PERIODO DE TIEMPO */
                         
                   
                $gerentes = $comision->getGerenteHasta($regiones[$r]['id'],$desde,$hasta);
                $zonas = $comision->getZonasGerernte($regiones[$r]['id']);

                $vendedores = $comision->getvededoresZona($zonas);
                $totales = $comision->getTotalVendoresZona($vendedores,$desde,$hasta);

                     /* BUSCAMOS LOS TOTALES DE CADA REGION BUSCAMOS LOS TOTALES DE CADA REGION */

                      if($totales){

                        for ($x=0; $x < count($totales) ; $x++) {
                         
                          /* PRESUPUESTOS DE VENDEDORES PRESUPUESTOS DE VENDEDORES  */
                          $meta = $comision->getMetasVendedores($totales[$x]['co_ven'],null,$desde,$hasta);
                          $fact = $comision->facturaVendedorFecha($totales[$x]['co_ven'],$desde,$hasta);

                          $porcentaje = 0;
                          if ( $meta[0]['presupuesto'] > 0) {
                            $porcentaje = ($fact['monto_base'] * 100) / $meta[0]['presupuesto'];
                          }
                          $eltotal+=$fact['monto_base'];
                          $presupuestoregional+=$meta[0]['presupuesto'];
                        }

                        $vacantes = $comision->vendedoresVacantes($zonas,$desde,$hasta);
                          
                          for ($x=0; $x < count($vacantes) ; $x++) {
                            $presupuestoregional+=$vacantes[$x]['presupuesto'];
                          }

                        

                        if (!$eltotal==0 and $presupuestoregional>0) {
                         $porcentajeTotal = ($eltotal * 100) / $presupuestoregional;
                        }

                    }                                         
                           
              ?>
			  <div class="col-xs-4">
				<div class="panel panel-default lead">
				  <div class="panel-heading">
					  <b><?php echo utf8_encode($regiones[$r]['nombre']); ?> </b>  
						<span class="pull-right lead"> 
						  <?php echo number_format($porcentajeTotal, 2, ",", ".");  ?>%
						</span>
						<p  data-toggle="tooltip" data-placement="top" title="" data-original-title="Presupuesto"><i class="fa fa-line-chart text-success" aria-hidden="true"></i>
						  <?php echo number_format($presupuestoregional, 2, ",", "."); ?>
						</p>
					</div>
		 
                <div class="panel-body" style="width:100%; height:200px; overflow: auto;">  
                   
                 <?php 
                  
                    for ($g=0; $g < count($gerentes); $g++){ 
						$n_eltotal = 0;
                      $fecha1 = new DateTime($gerentes[$g]['desde']);
                      $fecha2 = new DateTime($desde);

                      if ($fecha1 > $fecha2) {
                        $f_desde = date("Y-m-d", strtotime($gerentes[$g]['desde']));
                      }else{
                         $f_desde = date("Y-m-d", strtotime($desde));
                      }

                      $fecha1 = new DateTime($gerentes[$g]['hasta']);
                      $fecha2 = new DateTime($hasta);

                     if ($fecha1 < $fecha2) {
                        $f_hasta  = date("Y-m-d", strtotime($gerentes[$g]['hasta']));
                      }else{
                         $f_hasta = date("Y-m-d", strtotime($hasta));
                      }

                      $tot_ven_fecha = $comision->getTotalVendoresZona($vendedores,$f_desde,$f_hasta);
                      if($tot_ven_fecha){
                        
                        for ($x=0; $x < count($tot_ven_fecha) ; $x++) {
                         
                          /* PRESUPUESTOS DE VENDEDORES PRESUPUESTOS DE VENDEDORES  */
                          $fact = $comision->facturaVendedorFecha($tot_ven_fecha[$x]['co_ven'],$f_desde,$f_hasta);
        
                          $n_eltotal+=$fact['monto_base'];
                        }

                

                    }
                  ?>
                    <h4><?php echo $gerentes[$g]['ven_des']; ?> 
                      <small>
                      </small>
                    </h4>                    
                
                  <p  data-toggle="tooltip" data-placement="bottom" title="Ventas Actuales" data-original-title="Ventas Actuales"><i class="fa fa-calculator text-info" aria-hidden="true"></i>  
                    <?php echo number_format($n_eltotal, 2, ",", ".");  ?> 
                   </p>
                     <?php
                    } 
                 ?>
              </div>
            </div>
          </div>
  <?php
 
 /* 
  Datos totalizados para mostrar ocultos luego copiarlos a la cabezera
  para evitar re lectura de datos.
 */
    $totalgeneralPresupuesto += $presupuestoregional;
    $totalgeneralventas += $eltotal;
    $porcentajetotal = 0;
   
    if($totalgeneralPresupuesto > 0){ 
        $porcentajetotal = ($totalgeneralventas * 100) / $totalgeneralPresupuesto;
    }
    }
  ?>    
  <div class="col-xs-4">
            <div class="panel panel-default lead">
              <div class="panel-heading">
                  <b>Cuentas claves</b>  
                    <span class="pull-right lead"> 
                     <span class="nalcanceClave"></span>
                    </span>
                    <p  data-toggle="tooltip" data-placement="top" title="" data-original-title="Presupuesto"><i class="fa fa-line-chart text-success" aria-hidden="true"></i>
                      <span class="ntotalPresupuestoClaves"></span>
                    </p>
                </div>
     
                <div class="panel-body" style="width:100%; height:100px; overflow: auto;">        
                
                  <p  data-toggle="tooltip" data-placement="bottom" title="Ventas Actuales" data-original-title="Ventas Actuales"><i class="fa fa-calculator text-info" aria-hidden="true"></i>  
                    <span class="ntotalCuentasClaves"></span>
                   </p>
                   
              </div>
            </div>
          </div>
	</div>
	<!-- Fin Resumen de regiones ventas y presupuesto -->	    
		<!-- Paneles de vendedores y region  -->
			<div class="col-xs-12">
				  <div class="panel with-nav-tabs panel-default">
					  <div class="panel-heading">
							<ul class="nav nav-tabs">
							  <?php
      							  /* TABS de regiones  TABS de regiones  TABS de regiones */
      							  /* TABS de regiones  TABS de regiones  TABS de regiones */
      							  $regiones = $comision->getRegiones(null);
      							  for ($r=0; $r < count($regiones) ; $r++) {
        								  if ($r==0) {
        								  ?>
        									  <li class="active"><a href="#reg<?php echo $regiones[$r]['id']; ?>" data-toggle="tab"><?php echo utf8_encode($regiones[$r]['nombre']); ?></a></li>
        								  <?php
        								}else{
        								  ?>
        									  <li><a href="#reg<?php echo $regiones[$r]['id']; ?>" data-toggle="tab"><?php echo utf8_encode($regiones[$r]['nombre']); ?></a></li>
        								  <?php

        								}
      							  }
							 ?>
							 <li><a href="#regCC" data-toggle="tab">Cuentas claves</a></li>
							</ul>
					  </div>
					  <div class="panel-body">
						  <div class="tab-content">
							<?php
							  for ($i=0; $i < count($regiones); $i++){
								if ($i==0) {
								?>
								   <div class="tab-pane fade in active" id="reg<?php echo $regiones[$i]['id']; ?>">
									 <?php
									/* datos del gerente de region */
									$mensaje = "Sin gerente asignado <a href='comisionagregargerenteregional.php' class='btn btn-success btn-xs'> Asignar gerente</a>";

									$zonas = array();
									$vendedores = array();
									$totales = array();

									$eltotal = 0;
									$presupuestoregional = 0;
                                    //echo $regiones[$i]['id'];
                                    $gerente_zona = $comision->getGerenteRegion($regiones[$i]['id'],$desde,$hasta);
                                

									 if(count($gerente_zona) > 0){
										 $zonas = $comision->getZonasGerernte($gerente_zona[0]['cmsRegion_id']);
										
										$mensaje = "Sin zonas asignadas <a href='comisionagregargerenteReditar.php?id=".$gerente_zona[0]['id']."' class='btn btn-success btn-xs'> Asignar zonas</a>";
										 $vendedores = $comision->getvededoresZona($zonas);                                
										 $totales = $comision->getTotalVendoresZona($vendedores,$desde,$hasta);

									 }
									 ?>
										<table class="table table-striped table-hover ">
												<thead>
												  <tr>
													<th>Código vendedor</th>
													<th>Nombre</th>
													<th>Zona</th>
													<th class="text-right">Presupuesto</th>
													<th class="text-right">Venta</th>
													<th class="text-right">Meta alcanzada</th>
												  </tr>
												</thead>
												<tbody>
												  <?php
												  if($totales){
												  for ($x=0; $x < count($totales) ; $x++) {
													$fact = $comision
													->facturaVendedorFecha($totales[$x]['co_ven'],$desde,$hasta);
													$meta = $comision
													->getMetasVendedores($totales[$x]['co_ven'],null,$desde,$hasta);

													$porcentaje = 0;
													if ($meta[0]['presupuesto'] > 0) {
													  $porcentaje = ($fact['monto_base'] * 100) / $meta[0]['presupuesto'];
													}
													$eltotal+=$fact['monto_base'];
													$presupuestoregional+=$meta[0]['presupuesto'];
													?>
												  <tr>
													<td><?php echo $totales[$x]['co_ven']?></td>
													<td><?php echo $totales[$x]['ven_des']?></td>
													<td><?php echo $totales[$x]['zona']?></td>
													<td class="text-right">                                            
													  <?php echo number_format($meta[0]['presupuesto'], 2, ",", "."); ?>
													</td>
													<td class="text-right">
														<?php echo number_format($fact['monto_base'], 2, ",", "."); ?>
														
													   <?php //echo number_format($totales[$x]['bruto'], 2, ",", "."); ?>
													</td>
													<td class="text-right">
													  <?php echo number_format($porcentaje, 2, ",", "."); ?>%
													</td>
												  </tr>
												  <?php
												  }
												  // Buscamos los vendedores VACANTES y su presupuesto
												  $vacantes = $comision->vendedoresVacantes($zonas,$desde,$hasta);
												 for ($x=0; $x < count($vacantes) ; $x++) {
												  
												   $presupuestoregional+=$vacantes[$x]['presupuesto'];
												  ?>
												  <tr>
													<td><?php echo $vacantes[$x]['id']?></td>
													<td><?php echo $vacantes[$x]['co_ven']?></td>
													<td><?php echo $vacantes[$x]['zona']?></td>
													<td class="text-right"><?php echo number_format($vacantes[$x]['presupuesto'], 2, ",", "."); ?></td>
													<td class="text-right"><?php echo number_format(0, 2, ",", "."); ?></td>
													<td class="text-right"><?php echo number_format(0, 2, ",", "."); ?>%</td>
												  </tr> 
												  <?php
												 }

												  $porcentajeTotal=0;
												  if (!$eltotal==0 and $presupuestoregional> 0) {
												   $porcentajeTotal = ($eltotal * 100) / $presupuestoregional;
												  }
												  ?>
												  <tr>
													<td colspan="3"  class="text-right"><b>Total</b></td>
													<td  class="text-right text-info">
													  <?php echo number_format($presupuestoregional, 2, ",", ".");?>
														
													  </td>
													<td class="text-right text-info"><?php echo number_format($eltotal, 2, ",", ".");?></td>
													<td class="text-right text-info">
													  <?php echo number_format($porcentajeTotal, 2, ",", ".");?> %
													
												   </td>
												  </tr>
												  <?php
												}else{
												   ?>
												   <tr>
													 <td colspan="6"><?php echo $mensaje; ?></td>
												   </tr>
												   <?php } ?>
												</tbody>
											  </table>
									 </div>
								<?php
							  }else{
								?>
								  <div class="tab-pane fade" id="reg<?php echo $regiones[$i]['id']; ?>">
								 
									<?php
								   /* datos del gerente de region */
								   $mensaje = "Sin gerente asignado
								   <a href='comisionagregargerenteregional.php' class='btn btn-success btn-xs'>
								   <i class='fa fa-user-circle' aria-hidden='true'></i> Asignar gerente</a>";

								   $zonas = array();
								   $vendedores = array();
								   $totales = array();

									$eltotal = 0;
									$presupuestoregional = 0;

                                  

									//$gerente_zona = $comision->getGerenteRegion(trim($regiones[$i]['id']),$desde,$hasta);
									 $gerente_zona = $comision->getGerenteHasta($regiones[$i]['id'],$desde,$hasta);
									
                                    if(count($gerente_zona) > 0){
                                        
                                        $zonas = $comision->getZonasGerernte($gerente_zona[0]['region']);
                                        $mensaje = "Sin zonas asignadas <a href='comisionagregargerenteReditar.php?id=".$gerente_zona[0]['id']."' class='btn btn-success btn-xs'> Asignar zonas</a>";
                                        $vendedores = $comision->getvededoresZona($zonas);
                                        $totales = $comision->getTotalVendoresZona($vendedores,$desde,$hasta);
                                        
									}
									?>
									 <table class="table table-striped table-hover ">
										   <thead>
											 <tr>
											   <th>Código vendedor</th>
											   <th>Nombre</th>
											   <th>Zona</th>
											   <th class="text-right">Presupuesto</th>
												  <th class="text-right">Venta</th>
												  <th class="text-right">Meta alcanzada</th>
											 </tr>
										   </thead>
											 <tbody>
											   <?php

											   if(count($totales)>0){
											   for ($x=0; $x < count($totales) ; $x++) {
												 $meta = $comision->getMetasVendedores($totales[$x]['co_ven'],null,$desde,$hasta);
													$fact = $comision->facturaVendedorFecha($totales[$x]['co_ven'],$desde,$hasta);

												 $porcentaje = 0;
												 if ($meta[0]['presupuesto'] > 0) {
												   $porcentaje = ($fact['monto_base'] * 100) / $meta[0]['presupuesto'];
												 }
												 $eltotal+=$fact['monto_base'];
												  $presupuestoregional+=$meta[0]['presupuesto'];
												 ?>
												 <tr>
												   <td><?php echo $totales[$x]['co_ven']?></td>
												   <td><?php echo $totales[$x]['ven_des']?></td>
												   <td><?php echo $totales[$x]['zona']?></td>
												   <td class="text-right text-info">
													<?php echo number_format($meta[0]['presupuesto'], 2, ",", "."); ?>
													  
													</td>
												   <td class="text-right text-info">
													<?php echo number_format($fact['monto_base'], 2, ",", "."); ?>
												   
													<?php// echo number_format($totales[$x]['bruto'], 2, ",", "."); ?>
													  
													</td>
												   <td class="text-right text-info">
													<?php echo number_format($porcentaje, 2, ",", "."); ?>%
												  </td>
												 </tr>
											   <?php
												  

												 }
												// Buscamos los vendedores VACANTES y su presupuesto
												 $vacantes = $comision->vendedoresVacantes($zonas,$desde,$hasta);
												$vacantes = $comision->vendedoresVacantes($zonas,$desde,$hasta);
												 for ($x=0; $x < count($vacantes) ; $x++) {
												  
												   $presupuestoregional+=$vacantes[$x]['presupuesto'];
												  ?>
												  <tr>
													<td><?php echo $vacantes[$x]['id']?></td>
													<td><?php echo $vacantes[$x]['co_ven']?></td>
													<td><?php echo $vacantes[$x]['zona']?></td>
													<td class="text-right"><?php echo number_format($vacantes[$x]['presupuesto'], 2, ",", "."); ?></td>
													<td class="text-right"><?php echo number_format(0, 2, ",", "."); ?></td>
													<td class="text-right"><?php echo number_format(0, 2, ",", "."); ?>%</td>
												  </tr> 
												  <?php
												 }
												  $porcentajeTotal=0;
												  if (!$eltotal==0 and $presupuestoregional>0) {
												   $porcentajeTotal = ($eltotal * 100) / $presupuestoregional;
												  }
											   
											   ?>
												  <tr>
													<td colspan="3"  class="text-right"><b>Total</b></td>
													<td  class="text-right">
													  <?php echo number_format($presupuestoregional, 2, ",", ".");?>
														
													  </td>
													<td class="text-right"><?php echo number_format($eltotal, 2, ",", ".");?></td>
													<td class="text-right">
													  <?php echo number_format($porcentajeTotal, 2, ",", ".");?> %
													
												   </td>
												  </tr>
											   <?php
											 }else{
												?>
												<tr>
												  <td colspan="6"><?php echo $mensaje; ?></td>

												</tr>
												<?php } ?>

											 </tbody>
										   </table>
								  </div>
								  <div class="tab-pane fade" id="regCC">
										<?php 
													/* cuentas claves */
													$totalCuentasClaves = 0;
													$totalPresupuestoClaves = 0;
													$porcentajeClaveTotal = 0;
										?>
										<table class="table table-striped table-hover ">
										<thead>
											 <tr>
											   <th>Código vendedor</th>
											   <th>Nombre</th>
												  <th class="text-right">Presupuesto</th>
												  <th class="text-right">Venta</th>
												  <th class="text-right">Meta alcanzada</th>
											 </tr>
										   </thead>
										   <?php
										   $claves = $comision->getCuentasClaves('01',null);
												//$claves = $comision->getTotalCuentasClaves('01',$desde,$hasta,null);
												 for ($x=0; $x < count($claves) ; $x++) {  
												 
												  $presupuesto_ven = 0;
												  $monto = $comision
												  ->getMetasClaves($claves[$x]['co_ven'],null,$desde,$hasta); 
												$factura = $comision->facturaVendedorFecha($claves[$x]['co_ven'],$desde,$hasta);   

													  
												  $totalCuentasClaves+=$factura['baseFactura'];

												  if(count($monto)>0){
													$totalPresupuestoClaves+=$monto[0]['presupuesto'];
													$presupuesto_ven =  $presupuesto_ven = 0;;
												  }
																						
												  $porcentajeClave=0;

												  if ($presupuesto_ven > 0) {
												   $porcentajeClave = ($factura['baseFactura'] * 100) / $monto[0]['presupuesto'];
												  }
												  ?>
												  <tr>
													<td><?php echo $claves[$x]['co_ven']?></td>
													<td><?php echo $claves[$x]['ven_des']?></td>
																						
													<td  class="text-right">
													   <?php echo number_format( $presupuesto_ven, 2, ",", "."); ?>
													</td>
													 <td class="text-right">
													  <?php echo number_format($factura['baseFactura'], 2, ",", "."); ?>
													 </td>  
													 <td class="text-right text-info">
													  <?php echo number_format($porcentajeClave, 2, ",", "."); ?> %                                               
													</td>
												  </tr> 
												  <?php
												 }
												 $clavesVacantes = $comision->clavesVacantes($desde,$hasta);
												 
												 for ($x=0; $x < count($clavesVacantes); $x++) { 
												  $totalPresupuestoClaves+=$clavesVacantes[$x]['presupuesto'];  
												   ?>
												  <tr>
													<td></td>
													<td><?php echo $clavesVacantes[$x]['co_ven']?></td>
																						
													<td  class="text-right">
													  <?php echo number_format($clavesVacantes[$x]['presupuesto'], 2, ",", "."); ?>
													</td>
													 <td class="text-right">
													  <?php echo number_format(0, 2, ",", ".");?>
													 </td>  
													 <td class="text-right text-info">
													  <?php echo number_format(0, 2, ",", ".");?>                                         
													</td>
												  </tr> 
												  <?php
												 }

												 if ($totalPresupuestoClaves > 0) {
												   $porcentajeClaveTotal = ($totalCuentasClaves * 100) / $totalPresupuestoClaves;
												  }
										   ?>
											  <tr>
													<td colspan="2"  class="text-right"><b>Total</b></td>
													<td  class="text-right">
													 <?php echo number_format($totalPresupuestoClaves, 2, ",", ".");?>
													   
													 </td>
													<td  class="text-right">
													  <?php echo number_format($totalCuentasClaves, 2, ",", ".");?>
														
													  </td>
													   <td class="text-right text-info">
														<?php echo number_format($porcentajeClaveTotal, 2, ",", ".");?> %
														
													  </td>
												
													
												  </tr>
											 <tbody>
												 </tbody>
										   </table>
									</div>
							  <?php
							  }
							  }
							 ?>




						  </div>

					  </div>
				  </div>
				  <?php
					$totalProhome = $totalCuentasClaves + $totalgeneralventas;
					$totalVentasProhome = $totalProhome + $totaloficina['monto_base'];
					$totalPresupuestoProhome = $totalPresupuestoClaves + $totalgeneralPresupuesto;
					
					$participaciontradicional = 0;
					$participacionclave = 0;
					$alcanceClave = 0;
					$porcantaleTotalProHome = 0;

					if ($totalPresupuestoProhome > 0) {
					 $participaciontradicional = ($totalgeneralPresupuesto/$totalPresupuestoProhome    ) * 100;
					}
					if ($totalPresupuestoProhome > 0) {
					 $participacionclave = ($totalPresupuestoClaves/$totalPresupuestoProhome ) * 100;
					}
				  if ($totalPresupuestoClaves > 0) {
					$alcanceClave = ($totalCuentasClaves / $totalPresupuestoClaves) * 100 ;
					}
					if($totalPresupuestoProhome > 0){
					$porcantaleTotalProHome = ($totalProhome / $totalPresupuestoProhome) * 100 ;
							  }
				  ?>
		<p class="hidden totalgeneral"> <?php echo number_format($totalgeneralPresupuesto, 2, ",", "."); ?></p>
		<p class="hidden totalventas"><?php echo number_format($totalgeneralventas, 2, ",", "."); ?></p>
		<p class="hidden totalporcentajetradicional"><?php echo number_format($porcentajetotal, 2, ",", "."); ?> %</p>
		<p class="hidden alcanceClave"><?php echo number_format($alcanceClave, 2, ",", "."); ?> %</p>

		<p class="hidden porcantaleTotalProHome"><?php echo number_format($porcantaleTotalProHome, 2, ",", "."); ?> %</p>

		<p class="hidden totalcuentasClaves"> <?php echo number_format($totalCuentasClaves, 2, ",", "."); ?></p>
		<p class="hidden totalProhome"> <?php echo number_format($totalProhome, 2, ",", "."); ?></p>
		<p class="hidden totalVentasProhome"> <?php echo number_format($totalVentasProhome, 2, ",", "."); ?></p>

		<p class="hidden participaciontradicional"> <?php echo number_format($participaciontradicional, 2, ",", "."); ?></p>
		<p class="hidden participacionclave"> <?php echo number_format($participacionclave, 2, ",", "."); ?></p>
		<p class="hidden totalPresupuestoClaves"> <?php echo number_format($totalPresupuestoClaves, 2, ",", "."); ?></p>

		<p class="hidden totalPresupuestoProhome"> <?php echo number_format($totalPresupuestoProhome, 2, ",", "."); ?></p>

		<?php 
		  //$prueba = $comision->facturaVendedorFecha('57',$desde,$hasta); var_dump($prueba);

		//$reporte->add_log($usuario,"Visualizacion","comisionesRegiones.php fecha: desde:".$desde." hasta ".$hasta." - Facturado:".$totalVentasProhome." - total ProHome: ".$totalProhome);
		?>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<!-- /.col -->
			  </div>		
            
        </div>
		<!-- content -->
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
