<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
header("Refresh: 300; URL='pedidosDesA.php'");
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$arr_pedidos=$obj_pedidos->get_ped_desp();
$tot=0;
?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headD.php'); ?>

<body>
     <style>
  .modal-cxc{
  width: auto !important;
   width: 1600px !important;
  margin: 10px;
  }
  .modal-dialog {
    width: 1300px;
    margin: 30px auto;
}
  
</style>


    <?php require_once('../lib/php/common/menuD.php'); ?>
  <div id="modal-cxc" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
          <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalles de Pedido</h4>
      </div>
      <div class="modal-body">
        <p>Cargando...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>

      </div>
    </div>

        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Pedidos
                      <small>para facturar</small></h1>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Pedidos para Facturar
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                      <tr>
                                        <th>Id</th>
                                        <th>Total Neto</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
                                        <th>Fecha Aprob.</th>
                                        <th>Observaciones</th>
										<th>Comentario</th>
                                        <th>Opciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<sizeof($arr_pedidos);$i++){
                                    $class=""; 
                                     if($arr_pedidos[$i]['imp']!=0){ $class="text-danger"; } ?>
                                      <tr class="odd gradeX <?php echo $class;?>">
                                        <td><?php echo $arr_pedidos[$i]['doc_num']; ?></td>
                                        <td class="text-right">
                                            <?php echo number_format($arr_pedidos[$i]['total_neto'], 2, ".", ","); ?>
                                                
                                            </td>
                                        <td><?php echo $arr_pedidos[$i]['co_cli'].'-'.utf8_encode($arr_pedidos[$i]['cli_des']); ?></td>
                                        <td><?php echo $arr_pedidos[$i]['co_ven'].'-'.$arr_pedidos[$i]['ven_des']; ?></td>
                                        <td><?php echo date_format(date_create($arr_pedidos[$i]['fecha_aprobado']), 'd/m/Y'); ?></td>
										<td><?php echo utf8_encode($arr_pedidos[$i]['descrip']); ?></td>
                                        <td><?php echo utf8_encode($arr_pedidos[$i]['ciudad']); ?></td>
                                        <td class="center"><span class="btn-group">
                                    <button name="id" type="submit"   class="btn btn-primary btn-xs btn-block pedido-entregado" value="<?php echo $arr_pedidos[$i]['doc_num']; ?>"><i class="fa fa-eye"></i> Ver</button>
                                    
                                    <?php if($class==''){ ?>
                                    <button name="id" type="button" class="btn btn-warning btn-xs imp" data-id="<?php echo $arr_pedidos[$i]['doc_num']; ?>" ><i class="fa fa-check-circle"></i> Imp</button> <?php } ?>
                                    </span>
                                        </td>
                                      </tr>
                                    <?php 
                                    $tot=$tot+$arr_pedidos[$i]['total_neto'];
                                    } ?>
                                    </tbody>
                                  <tfoot>
                                  <tr>
                                    <th colspan="2" style="text-align:right">Totales:</th>
                                    <th colspan="6" ><span style="float:left;"id ='Saldo'>0</span></th>
                                
                                  </tr>
                                  </tfoot>
                                </table>
                                <strong><?php echo "Total Bs. F: ".number_format($tot, 2, ",", "."); ?></strong>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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
                aLengthMenu: [
        [-1,25,50,100],
        ["Todo",25,50,100]
      ],
       "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;  
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[\$.\$,]/g, '')*1 : typeof i === 'number' ?  i : 0;
            };

           Saldo = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
       
            //Base = parseFloat(Base);

            Saldo = parseFloat(Math.round(Saldo) / 100);


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
            // Update footer
            $('#Saldo').html(Saldo.formatMoney(2,'.',','));
          
        },
        });
    });
    </script>
    <script>
      $('.desp').on('click',function(){
  var id = $(this).data('id');
        eliminar=confirm("¿Realmente desea facturar este pedido?");
        if (eliminar)
            window.location.href = "aprobarF.php?codigo="+id;
    });
</script>
<script>
      $('.imp').on('click',function(){
  var id = $(this).data('id');
        eliminar=confirm("¿Realmente desea imprimir este pedido?");
        if (eliminar)
            window.location.href = "imp.php?codigo="+id;
    });
</script>
<script>
      $('.det').on('click',function(){
  var id = $(this).data('id');
        window.location.href = "detallePedidoDesA.php?id="+id;
    });
</script>
<script>

      $('.pedido-entregado').click(function() {
        var vista = "facturar";
        var documento = $(this).val();  
       
          $.ajax({
          data: {"documento" : documento,"vista": vista},
          type: "POST",
          url: "../controlPedido.php?opcion=detPedidoReversar",
           beforeSend: function() {
              
               $('#modal-cxc .modal-body').html('<div class="text-center"><img src="../../image/preload.gif" class="text-center"/></div>');
           },
            success: function(data){
              $('#modal-cxc .modal-body').html(data);
            }
        });
        $("#modal-cxc").modal()
      });


function anular_pedido(elform,documento,tipo,estatus){
  // alert(estatus);
 eliminar=confirm("¿Desea procesar esta accion ?");
        if (eliminar){

    if (tipo=="modificar") {
      var fech_old = elform.fecha_old.value;  
      var fech_new = elform.fecha_new.value;
      console.log(moment(fech_old).format('DD/MM/YYYY'));
      console.log(moment(fech_new).format('DD/MM/YYYY'));
              //alert(fech_old);
    }
        if (tipo=="facturar"){
          var factura= elform.factura.value;
          var coment = elform.comentario.value; 
      } else {
           var coment = elform.comentario.value; 
           var fech_old = elform.fecha_old.value;
           console.log(moment(fech_old).format('DD/MM/YYYY'));  
           } 
          $.ajax({
          data: {"documento" : documento,"coment":coment,"tipo":tipo,"fechades":fech_old,"fechanew":fech_new,"estatus":estatus,"factura":factura},
          type: "POST",
          url: "../controlPedido.php?opcion=procesar_accion",
            success: function(data){
             // alert(data);
             $('#dataTables-example').DataTable().row().fnReloadAjax().draw();
            }
        });
        $("#modal-cxc").modal('hide');
    }
};



        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
</body>

</html>
