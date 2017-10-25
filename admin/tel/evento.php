<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();

$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
if($_POST){
    $rif=$_POST["rif"];
    $sql=@mysql_query("SELECT clientes.cli_des,clientes.co_ven,clientes.direc,clientes.telefonos,clientes.rif,clientes.email,clientes.ciudad,vendedor.ven_des FROM clientes INNER JOIN vendedor ON clientes.co_ven = vendedor.co_ven WHERE clientes.rif = '$rif'");
    if(mysql_num_rows($sql) == 1){
        $cliente=mysql_fetch_array($sql);
        ?>
        <!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
    <div id="content">
        <div class="col-lg-12">
            <h1 class="page-header">Clientes</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="box box-info">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" role="form" action="visita.php" method="POST">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Empresa: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['cli_des']; ?></label>
                                    <label class="col-xs-2 control-label">Rif: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['rif']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Dirección: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['direc']; ?></label>
                                    <label class="col-xs-2 control-label">Ciudad: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['ciudad']; ?></label>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Teléfono: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['telefonos']; ?></label>
                                    <label class="col-xs-2 control-label">Correo Electrónico: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['email']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Vendedor: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['co_ven']."-".$cliente['ven_des']; ?></label>
                                    <input type="hidden" name="id" value="<?php echo $cliente['rif']; ?>">
                                    <!--<div class="col-xs-6 col-sm-2">
                                        <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-check-circle"></i> Registrar Visita</button>
                                    </div>-->
								</div>
								<div class="form-group">
                                    <div class="col-xs-6 col-sm-2">
                                        <button type="button" class="btn btn-info btn-sm btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
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
<?php
    }else{
        $sql2=@mysql_query("SELECT * FROM cliente_evento WHERE rif='$rif'");
        if(mysql_num_rows($sql2) == 1){
            $cliente=mysql_fetch_array($sql2);
        ?>
        <!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
    <div id="content">
        <div class="col-lg-12">
            <h1 class="page-header">Clientes</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="box box-info">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" role="form" action="visita.php" method="POST">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Empresa: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['nombre_emp']; ?></label>
                                    <label class="col-xs-2 control-label">Rif: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['rif']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Dirección: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['direccion']; ?></label>
                                    <label class="col-xs-2 control-label">Teléfono: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['telefono']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Correo Electrónico: </label>
                                    <label class="col-xs-4 text-left"><?php echo $cliente['correo']; ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $cliente['rif']; ?>">
                                    <!--<div class="col-xs-6 col-sm-2">
                                        <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-check-circle"></i> Registrar Visita</button>
                                    </div>-->
                                    <div class="col-xs-6 col-sm-2">
                                        <button type="button" class="btn btn-info btn-sm btn-block" onClick='javascript:history.go(-1);'><i class="fa fa-reply"></i> Regresar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
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
<?php
        }else{
            ?> <script type="text/javascript">alert("Cliente no registado, proceda a realizar el registro...");window.location="evento.php";</script> <?php
        }
    }
}else{
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
    <div id="content">
        <div class="col-lg-12">
            <h1 class="page-header">Clientes</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="box box-info">
                        
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" role="form" action="evento.php" method="POST">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputConsulta" class="col-xs-4 control-label">Consulta de Cliente: </label>
                                    <div class="col-xs-5">
                                        <input class="form-control" placeholder="Rif" name="rif" type="text" title="Ejemplo: J000000000" pattern="^[JGV][0-9]{9}$" autofocus required>
                                    </div>
                                    <div class="col-xs-3">
                                        <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-check-circle"></i> Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                    <hr>
                    <h3>Registro de Cliente Nuevo: </h3>
                    <form class="form-horizontal" role="form2" action="reg.php" method="POST">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Nombre del Distribuidor" name="nombre_d" type="text" value="" required>
                                </div>
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Rif" name="riff" type="text" title="Ejemplo: J000000000" pattern="^[JGV]{1}[0-9]{9}$" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <select class="form-control" name="agenteR" required><option value="0">Agente de Retención:</option><option value="1">SI</option><option value="2">NO</option></select>
                                </div>
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Teléfono" name="telefono" type="text" title="Ejemplo: 0000-0000000" pattern="^[0-9]{4}[-][0-9]{7}$" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <textarea name="direccion" class="form-control" rows="3" placeholder="Dirección Fiscal" required></textarea>
                                </div>
                                <div class="col-sm-5">
                                    <textarea name="direccionD" class="form-control" rows="3" placeholder="Dirección Despacho" required></textarea>
                                </div>
                            </div>
                            <hr>
                            <h3>Persona de Contacto</h3>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Nombre" name="nombre_c" type="text" value="" required>
                                </div>
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Cédula" name="cedula" type="text" title="Ejemplo: V-00000000" pattern="^[PEV][-][0-9]{8}$" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Teléfono" name="telefono_c" type="text" title="Ejemplo: 0000-0000000" pattern="^[0-9]{4}[-][0-9]{7}$" required>
                                </div>
                                <div class="col-sm-5">
                                    <input class="form-control" placeholder="Correo Electrónico" name="correo" type="text" title="Ejemplo: abc@abc.com" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-lg-3">
                                    <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-check-circle"></i> Enviar</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
<?php } ?>