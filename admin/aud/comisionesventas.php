<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$comision =  new comision();

$desde="2017-10-01";
$hasta="2017-12-31";

if(isset($_GET['periodo'])){
  $desde = $_GET['periodo'];
}
if(isset($_GET['hasta'])){
  $hasta = $_GET['hasta'];
}

$Historicouno = $comision->buscarHistoricouno($desde);
if (count($Historicouno)) {
  header("Location: comisioneshistorico.php?periodo=".$desde);
  $mensa = "Calculo de este rango de fecha se encuentra en historico del sistema";
        $comision->setMensajes('info',$mensa);
 
}

$documentos = $comision->listadoFacturaComisionVentas($desde,$hasta);
//var_dump($documentos);

$datosrespuesta = count($documentos);

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
 <a href="excelComisionVentas.php?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>" class="fa fa-file-excel-o excel text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a>
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
                        <th>NUM</th>
                        <th>DOC</th>
                        <th>COVEN</th>
                        <th>VENDEDOR</th>
                        <th>CLIENTE</th>
                        <th>SEGMENTO</th>
                        <th>BASE</th>
                        <th>COMISION</th>
                        <th>%</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $lineas = count($documentos);
                          foreach ($documentos as $factura) {
                           
                        ?>
                              <tr
                               <?php 
                                    if($factura['covendedor']){
                                      ?>
                               class=""
                                    <?php }?>
                              >
                                <td>
                                  <?php echo $factura['doc_num']; ?>                             
                                 </td>
                                <td>
                                  <?php echo $factura['tipodoc']; ?>                             
                                 </td>
                                <td><?php echo $factura['covendedor']; ?></td>
                                <td>
                                  <?php echo $factura['ven_des']; ?>
                                 </td>
                                <td>
                                  <?php echo
                                   utf8_encode($factura['cli_des']); 
                                   ?>
                                </td>
                                <td class="text-right"><?php echo  $factura['seg_des']; ?></td>
                                <td class="text-right">
                                  <?php 
                                  echo number_format($factura['total_bruto'], 2, ".", ",");
                                   ?></td>
                               
                                  <td class="text-right"><?php echo number_format($factura['comision'], 2, ".", ","); ?></td>
                                  <td class="text-center">
                                         <?php 
                                          if(!empty($factura['cal_comision'])){
                                             ?>
                                             <span class="badge pull-right ">
                                              <?php echo number_format($factura['porcentaje'], 1, ".", ",."); ?>

                                            %</span>
                                             <?php 
                                           }
                                     ?>
                                </td>
                      
                              </tr>
                            <?php
                          }
                           ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th colspan="6" style="text-align:right">Totales:</th>
                        <th><span style="float:right;"id ='Saldo'>0</span></th>
                        <th><span style="float:right;"id ='Comision'>0</span></th>
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
"aLengthMenu": [[25, 50, 75, 100,200,-1], [25, 50, 75, 100,200,"Todo"]],
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;  
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$,\$.]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };

            Base = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Saldo = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Comision = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Reserva = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
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
           
            Saldo = parseFloat(Math.round(Saldo) / 100);
            Comision = parseFloat(Math.round(Comision) / 100);


            //Base = formatNumber.new(Base.toFixed(2));

            // Update footer
            $('#Base').html(Base.formatMoney(2,'.',','));
            $('#Saldo').html(Saldo.formatMoney(2,'.',','));
            $('#Comision').html(Comision.formatMoney(2,'.',','));
            $('#Reserva').html(Reserva.formatMoney(2,'.',','));          
        },
        });
    });
    </script>
</body>

</html>
