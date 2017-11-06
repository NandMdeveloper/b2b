<?php
ini_set('display_errors', '1');
require_once("../lib/seg.php");
if($_SESSION['tipo']!='9') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/reporte.class.php");
include("../lib/class/comision.class.php");
$reporte = new reporte;//LLAMADO A LA CLASE DE PEDIDOS
$comision =  new comision();

/* INICIO - LLENADO DE DATOS */
$desde="2016-01-01";
$hasta="2017-12-31";

if(isset($_GET['desde'])){
  $desde = $_GET['desde'];
}
if(isset($_GET['hasta'])){
  $hasta = $_GET['hasta'];
}

$Historicouno = $comision->buscarHistoricouno($desde);

if (count($Historicouno)) {
  header("Location: comisioneshistorico.php?periodo=".$desde);
  $mensa = "Calculo de este rango de fecha se encuentra en historico del sistema";
        $comision->setMensajes('info',$mensa);
  exit();
}
$mDatos = $comision->listadoFacturaComisionSaldoBasico2($desde,$hasta);

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
        <a href="excelComision.php?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>" class="fa fa-file-excel-o excel" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a></h1>
            </div>
            <div class="col-lg-12">
                <?php
                    if(isset($_SESSION["msn-tipo"])){
                    $comision->getMensajes();
                    }
                  ?>
      <div class="row">
   <form action="comisionesactuales.php" method="GET" id="rango">
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
    </form>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Detalle Pedido
                              <i class="fa fa-calendar-times-o fa-1 text-danger" aria-hidden="true"></i>
                               Sin Fecha de cobro
                                  <i class="fa fa-truck fa-1 text-danger" aria-hidden="true"></i>
                                   Sin Fecha de recibo
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
                        <th>Cliente</th>
                        <th>Base</th>
                        <th>Saldo</th>
                        <th>Comision</th>
                        <th>Reserva</th>
                        <th>%</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $ttlBruto = 0;                          
                          $ttlIva = 0;
                          $ttlNeto = 0;

                          $ttlComision = 0;
                          $ttlReserva = 0;

                          $ttlConComisiones = 0;
                          $ttlSinComisiones = 0;

                           $ttlBrutofacturas = 0;      
                           $ttlIvafacturas = 0;      
                           $ttlNetofacturas = 0;      

                          $lineas = count($mDatos);
                          for($i=0;$i < $lineas; $i++){
                           $saldado = 0;
                              $cobros = 0;
                              $recibido = 0;

                              if( $mDatos[$i]['saldo'] == 0){
                                    $saldado = 1;
                              }
                            $ttlBruto+=$mDatos[$i]['total_bruto'];
                            $ttlIva+=$mDatos[$i]['monto_imp'];
                            $ttlNeto+=$mDatos[$i]['total_neto'];

                            $ttlComision+=$mDatos[$i]['comision'];
                            $ttlReserva+=$mDatos[$i]['reserva'];


                            if($mDatos[$i]['total_bruto'] >= 0){
                              $ttlBrutofacturas+=$mDatos[$i]['total_bruto'];  
                              $ttlIvafacturas+=$mDatos[$i]['monto_imp'];  
                              $ttlNetofacturas+=$mDatos[$i]['total_neto']; 
                            }


                            if (trim($mDatos[$i]['co_tipo_doc'])=='FACT') {  
                              

                              if ($mDatos[$i]['comision'] > 0) {
                                $ttlConComisiones++;
                              }else{
                                $ttlSinComisiones++;
                              }
                        ?>
                              <tr
                                      <?php 
                                    if($mDatos[$i]['editada']){
                                      ?>
                               class="info"
                                    <?php }?>>
                                <td>
                                   <div class="checkbox">
                                    <label>
                                      <input type="checkbox" name="documento[]" value="<?php echo $mDatos[$i]['nro_orig']; ?>">
                                    </label>
                                  </div>
                                  <?php echo $mDatos[$i]['nro_orig']; ?>
                                </td>
                                <td><?php echo $mDatos[$i]['co_ven']; ?></td>
                                <td>
                                  <?php echo $mDatos[$i]['co_cli']; ?>
                                 </td>
                                <td>
                                  <?php echo
                                   utf8_encode($mDatos[$i]['cli_des']); 
                                   ?>


                                  </td>
                                <td class="text-right"><?php echo number_format($mDatos[$i]['total_bruto'], 2, ",", "."); ?></td>
                                <td class="text-right">
                                  <?php 
                                  echo number_format($mDatos[$i]['saldo'], 2, ",", ".");
                                   ?></td>
                                  <td class="text-right"><?php echo number_format($mDatos[$i]['comision'], 2, ",", "."); ?></td>
                                  <td class="text-right"><?php echo number_format($mDatos[$i]['reserva'], 2, ",", "."); ?></td>
                                  <td class="text-center">
                                         <?php 
                                          if(!empty($mDatos[$i]['porcentaje'])){
                                             ?>
                                             <span class="badge pull-right ">
                                              <?php echo number_format($mDatos[$i]['porcentaje'], 1, ",", "."); ?>

                                            %</span>
                                             <?php 
                                           }
                                      ?>


                                      
                                  <?php                                 
                                    if(empty($mDatos[$i]['fcobro'])){
                                  ?>
                                  <i class="fa fa-calendar-times-o fa-1 text-danger pull-right mini-icon" aria-hidden="true"></i>
                                    <?php 
                                       
                                   }else {
                                    $cobros = 1;
                                  }                            
                                    if(empty($mDatos[$i]['fecha_recibido'])){
                                  ?>                                    
                                    <i class="fa fa-truck fa-1 text-danger pull-right mini-icon" aria-hidden="true"></i>
                                    
                                  <?php 
                                  }else{
                                    $recibido = 1;
                                  }
                               if($mDatos[$i]['comision'] <= 0){
                                 ?>
                                        <i class="fa fa-times-circle-o text-danger pull-right mini-icon" aria-hidden="true"></i>
                                 <?php
                               }
                                  ?>
                            

                                  </td>
                                <td> 
                                    <a href="comisionFactura.php?factura=<?php echo $mDatos[$i]['nro_orig']; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&saldado=<?php echo $saldado; ?>&cobros=<?php echo $cobros; ?>&recibido=<?php echo $recibido; ?>"  class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-eye"></i>  Ver</a> 

                                </td>
                              </tr>
                            <?php
                          }

                          }
                         ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th colspan="4" style="text-align:right">Totales:</th>
                        <th><span style="float:right;"id ='Base'>0</span></th>
                        <th><span style="float:right;"id ='Saldo'>0</span></th>
                        <th><span style="float:right;"id ='Comision'>0</span></th>
                        <th><span style="float:right;"id ='Reserva'>0</span></th>
                        <th></th>
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
        </div>  
         <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Resultados de comisiones
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body  text-center">
                            <button type="button" class="btn btn-info btn-lg modal-comision" data-toggle="modal">Modificar documentos seleccionados</button>
                        </div>
                    </div>

                </div>            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Modificar documentos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body text-center">
                               <button onclick="registrarComisionesUno('<?php echo $desde;  ?>','<?php echo $hasta;  ?>')" class="btn btn-success btn-lg text-center">Registrar a historico este rango de comisiones de cobro</button>
                        </div>
                    </div>
                </div>


    <!-- Modal -->
    <div id="modal-cambios" class="modal fade" role="dialog" >
      <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modulo de modificación</h4>
          </div>
          <div class="modal-body"  id='docs-modificar'>
             <table class="table table-striped table-hover ">
                <thead>
                  <tr>
                    <th class="text-center">Documento</th> 
                    <th class="text-center">Fecha Corbro</th>
                    <th class="text-center">% comision</th>
                    <th class="text-center">% reserva</th>        
                  </tr>
                </thead>
                <tbody>
                <tr>
                  <td colspan="5"> 
                    <button type="button" class="btn btn-success"  onclick="agregarDocumentosConCambios()">Modificar estos documentos</button>
                  </td>
                </tr>

              </tbody>
            </table> 
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
        <script src="../../bower_components/jQuery/jquery.number.js"></script>
    <script src="../../bower_components/fc.js"></script>
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example 1').DataTable({
                
                responsive: true,
        });

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

            Base = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Saldo = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
            Comision = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
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
            Base = parseFloat(Math.round(Base) / 100);
            Saldo = parseFloat(Math.round(Saldo) / 100);
            Comision = parseFloat(Math.round(Comision) / 100);
            Reserva = parseFloat(Math.round(Reserva) / 100);

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
