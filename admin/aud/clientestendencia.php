<?php
  ini_set('display_errors', '1');
require_once("../lib/seg.php");
$permiso = 0;
if($_SESSION['tipo']=='9' or $_SESSION['tipo']=='12') {
    $permiso = 1;
  }

if($permiso==0) {
  header('Location: ../lib/php/common/logout.php');

}
require_once('../lib/conex.php');
conectar();
require_once('../lib/conecciones.php');
include("../lib/class/cliente.class.php");
include("../lib/class/pedidos.class.php");
include("../lib/class/comision.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS
$comision= new comision;//LLAMADO A LA CLASE DE PEDIDOS
$cliente =  new cliente();

$desde="2017-01-01";
$hasta=date("Y-m-d");

$getzona="";
$zona="";
$tipo=2;


if(isset($_GET['desde'])){
  $desde = $_GET['desde'];
}
if(isset($_GET['hasta'])){
  $hasta = $_GET['hasta'];
}
if(isset($_GET['zona'])){
  $getzona = $_GET['zona'];

}
if(isset($_GET['tipo']) and !empty($_GET['tipo'])){
  $tipo = $_GET['tipo'];
}

$detalle_tipo = array(
  2 => 'Clientes Actuales',
  3 => 'Clientes nuevos',
  4 => 'Clientes regulares'

);
$cartera = array();

$cartera = $cliente->getClientescarteraTotales($getzona,null,$hasta);

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>

    <?php 
    if ($_SESSION['tipo']== 9) {
      require_once('../lib/php/common/menuA.php');
    }else{
      require_once('../lib/php/common/menuV.php');
    }
     ?>

        <div id="content">
                  <div class="col-lg-12">
                         <h1>
                    Clientes
                    <small>registros</small>
                        <a href="excelClienteActivos.php?zona=<?php echo $getzona ?>&desde=<?php echo $desde ?>&hasta=<?php echo $hasta ?>" class="fa fa-file-excel-o excel text-info" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="Descargar para Excel"></a>
                  </h1>
                </div>
                <div class="col-lg-12">
        <form action="clientestendencia.php" method="GET" id="rango">
              <label for="inputEmail" class="col-lg-3 control-label">Fecha de analisis de clientes</label>
              <div class="col-md-6">
                      <div class="form-group">
                    <div class="col-lg-4">
                      <select class="form-control" name="tipo" required="required">
                        <option></option>
                        <option value="2">Clientes Actuales</option>
                        <option value="3">Clientes Nuevos</option>
                        <option value="4">Clientes Regulares</option>
                      </select>
                  
                  </div>
                    <div class="input-group input-group-sm">
                      <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-calendar"></span></span>
                      <input name="hasta" type="text" class="form-control hasta" placeholder="Cierre" aria-describedby="sizing-addon3"  value="<?php echo $hasta ?>">
                    </div>
                </div>
                <br>
              </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $detalle_tipo[$tipo]; ?>
                        </div> 
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="myfirstchart" style="height: 350px;"></div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
        </div>
        <!-- /#page-wrapper -->
  <link rel="stylesheet" href="../../bower_components/morrisjs/morris.css">
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
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
   <script src="../../bower_components/raphael/raphael-min.js"></script>
<script src="../../bower_components/morrisjs/morris.min.js"></script>
 <script src="../../bower_components/fc.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(function () {
  // data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type myfirstchart

  var tipo = <?php echo $tipo ?>;
  Morris.Bar({
    element: 'myfirstchart',
    data: <?php echo json_encode($cartera, JSON_PRETTY_PRINT) ?>,
    xkey: 'zon_des',
    ykeys: [tipo],
    labels: ['Clientes'],
    barRatio: 0.4,
    xLabelAngle: 35,
    hideHover: 'auto',
     barColors: ["#DF7401", "#58FA82", "#58FA82", "#DF7401"],
  });
  /*
  Morris.Bar({
    element: 'myfirstchart',
    data: [
      {device: 'iPhone', geekbench: 136},
      {device: 'iPhone 3G', geekbench: 137},
      {device: 'iPhone 3GS', geekbench: 275},
      {device: 'iPhone 4', geekbench: 380},
      {device: 'iPhone 4S', geekbench: 655},
      {device: 'iPhone 5', geekbench: 1571}
    ],
    xkey: 'device',
    ykeys: ['geekbench'],
    labels: ['Geekbench'],
    barRatio: 0.4,
    xLabelAngle: 35,
    hideHover: 'auto'
  });*/



  $('.code-example').each(function (index, el) {
    eval($(el).text());
  });
});
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
</body>

</html>
