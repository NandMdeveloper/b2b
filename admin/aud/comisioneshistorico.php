<?php
  require_once("../lib/seg.php");

  if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
  require_once('../lib/conex.php');
  require_once('../lib/conecciones.php');
  conectar();
  include("../lib/class/reporte.class.php");
  include("../lib/class/comision.class.php");

  $reporte = new reporte;//LLAMADO A LA CLASE DE PEDIDOS
  $comision =  new comision();
  $usuario=$_SESSION['user'];

  /* INICIO - LLENADO DE DATOS */
  $periodo="2017-06-01";
  if (isset($_GET['periodo'])) {
    $periodo = $_GET['periodo'];
  }

  $documentos = $comision->getHistoricodetalles($periodo);
  $datosrespuesta = count($documentos);

  // var_dump($documentos);
  // exit();

   $reporte->add_log($usuario,"Visualizacion","Ejecucion del archivo comisioneshistorico.php fecha:periodo ".$periodo." - resultado:".$datosrespuesta);

?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/headA.php'); ?>
<body>

    <?php require_once('../lib/php/common/menuA.php'); ?>

        <div id="content">
                <div class="col-lg-12">
                         <h1>
                    Comisiones
                    <small>lista vendedores</small>
        <a href="excelComisionHistorico.php?periodo=<?php echo $periodo; ?>" class="fa fa-file-excel-o excel text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a>
                  </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
                  <div class="col-md-6">
                 <form action="comisionesventas.php" method="GET" id="rango">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input name="periodo" type="text" class="form-control fecha"  condicion="1" placeholder="Inicio" aria-describedby="sizing-addon3" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input name="hasta" type="text" class="form-control hasta" condicion="1" placeholder="Cierre" aria-describedby="sizing-addon3">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="col-xs-3">
                      <div class="input-group input-group-sm">
                       <button type="button" class="btn btn-info pill-right"  data-toggle="modal" data-target="#modal-verhistoricos"> <i class="fa fa-clock-o" aria-hidden="true"></i>
                          Ver historico </button>
                      </div>
                    </div>
                  </div>
              <br>
              <br>
              <br>
              </form>

         <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Comisiones lista vendedores
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                        <table id="dataTables-example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Fact</th>
                        <th>Ven</th>
                        <th>Cod</th>
                        <th>COCli</th>
                        <th>Cliente</th>
                        <th>Base</th>
                        <th>Comision</th>
                        <th>Reserva</th>
                        <th>%</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                  <?php
         

                          $lineas = count($documentos);
                          for($i=0;$i < $lineas; $i++){
                          
                           
                          ?>
                              <tr>
                                <td>
                                  <?php echo $documentos[$i]['factura']; ?>                          
                                    
                                  
                                </td>
                                <td><?php echo $documentos[$i]['factura']; ?></td>
                                <td>
                                  <?php echo $documentos[$i]['co_vende']; ?>
                                 </td>
                                <td>
                                  <?php echo
                                   utf8_encode($documentos[$i]['co_cliente']); 
                                   ?>
                                </td>
                                <td>
                                  <?php echo
                                   utf8_encode($documentos[$i]['cli_des']); 
                                   ?>
                                </td>
                                <td class="text-right"><?php echo number_format($documentos[$i]['monto'], 2, ".", ","); ?></td>
                                  <td class="text-right"><?php echo number_format($documentos[$i]['comision'], 2, ".", ","); ?></td>
                                  <td class="text-right"><?php echo number_format($documentos[$i]['reserva'], 2, ".", ","); ?></td>
                                  <td class="text-center">
                                       
                                             <span class="badge pull-right ">
                                              <?php echo number_format($documentos[$i]['porcentaje'], 1, ".", ","); ?>

                                            %</span>
                                </td>
                                <td> 
                                    <a href="comisionFacturaHistorico.php?factura=<?php echo $documentos[$i]['factura']; ?>"  class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-eye"></i>  Ver</a>
                                    <?php
                                    // echo $documentos[$i]['fcobro']." (".$documentos[$i]['diascalle'].")";
                                     ?>
                                </td>
                              </tr>
                            <?php
                          

                          }
                         ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th colspan="5" style="text-align:right">Totales:</th>
                        <th><span style="float:right;"id ='Base'>0</span></th>
                        <th><span style="float:right;"id ='Comision'>0</span></th>
                        <th><span style="float:right;"id ='Reserva'>0</span></th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                </div>  
        
            </div>
                <!-- /.col-lg-12 -->
        </div>
              <!-- Modal verhistoricos -->
      <div id="modal-verhistoricos" class="modal fade" role="dialog" >
        <div class="modal-dialog  modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Historicos registrados</h4>
            </div>
            <div class="modal-body"  id='docs-modificar'>
            <div class="row">
        
                  <?php   $comision->getHistoricounoXMes(); ?>
               
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
                responsive: true,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;  
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$,\$.]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };

            Base = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
           
            Comision = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Reserva = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            //Base = formatNumber.new(Base.toFixed(2));
            Number.prototype.formatMoney = function(c, d, t){
            var n = this, 
                c = isNaN(c = Math.abs(c)) ? 2 : c, 
                d = d == undefined ? "." : d, 
                t = t == undefined ? "," : t, 
                s = n < 0 ? "-" : "", 
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
                j = (j = i.length) > 3 ? j % 3 : 0;
               return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
             };
            //Base = parseFloat(Base);
            Base = parseFloat(Math.round(Base) / 100);
            Comision = parseFloat(Math.round(Comision) / 100);
            Reserva = parseFloat(Math.round(Reserva) / 100);

            //Base = formatNumber.new(Base.toFixed(2));

            // Update footer
            $('#Base').html(Base.formatMoney(2,'.',','));
            $('#Comision').html(Comision.formatMoney(2,'.',','));
            $('#Reserva').html(Reserva.formatMoney(2,'.',','));          
        },
        });
    });
    </script>
</body>

</html>
