<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$comision =  new comision();

$periodo=date("Y-m-d");

if(isset($_GET['periodo'])){
  $periodo = $_GET['periodo'];
}
if(isset($_GET['documento'])){
  $documento = $_GET['documento'];
}

$documentos = $comision->getSaldos($periodo,null,null);
//$comision->dump($documentos); exit();
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
                    <small>Saldos</small>

                  </h1>
                </div>
                <div class="col-lg-12">
               
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
                  <div class="col-md-6">
                 <form action="comisionsaldos.php" method="GET" id="rango">    
                    <div class="col-md-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input name="periodo" type="text" class="form-control hasta" condicion="1" placeholder="Cierre" aria-describedby="sizing-addon3">
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
                             Lista documentos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                        <table id="dataTables-example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>DOC</th>
                        <th>TIPO</th>
                        <th>CO_CLI</th>
                        <th>CLIENTE</th>
                        <th>CO_VEN</th>
                        <th>VENDEDOR</th>
                        <th>BASE</th>
                        <th>IVA</th>
                        <th>SALDO</th>
                   
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $lineas = count($documentos);
                          foreach ($documentos as $factura) {
                           
                        ?>
                              <tr>
                                <td>
                                  <?php echo $factura['documento']; ?>                            
                                </td>
                                <td><?php echo $factura['tipodoc']; ?></td>
                                <td>
                                  <?php echo $factura['co_cli']; ?>
                                 </td>
                                <td>
                                  <?php echo  utf8_encode($factura['cli_des']);  ?>
                                </td>
                                <td>
                                  <?php echo $factura['co_ven']; ?>
                                 </td>
                                <td>
                                  <?php echo  utf8_encode($factura['ven_des']);  ?>
                                </td>
                                
                                <td class="text-right">
                                  <?php 
                                  echo number_format($factura['base'], 2, ".", ",");
                                   ?></td>
                               
                                  <td class="text-right"><?php echo number_format($factura['iva'], 2, ".", ","); ?></td>
                                  <td class="text-right"><?php echo number_format($factura['saldo'], 2, ".", ","); ?></td>
                     
                      
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
                        <th><span style="float:right;"id ='Reserva'>0</span></th>
               
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

    $("#dataTables-example").DataTable(
    {
      responsive: true,
      "aLengthMenu": [[25, 50, 75, 100,200,-1], [25, 50, 75, 100,200,"Todo"]],
           "processing": true,
           "responsive": true,
            "scrollX": true,
           "language":{
              "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

           }
      ,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;  
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$,\$.]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };

           
            Saldo = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Comision = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Reserva = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
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
            Reserva = parseFloat(Math.round(Reserva) / 100);

            //Base = formatNumber.new(Base.toFixed(2));

            // Update footer
           
            $('#Saldo').html(Saldo.formatMoney(2,'.',','));
            $('#Comision').html(Comision.formatMoney(2,'.',','));
            $('#Reserva').html(Reserva.formatMoney(2,'.',','));          
        },
    });
    });
    </script>
</body>

</html>
