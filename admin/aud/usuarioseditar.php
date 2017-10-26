<?php 
ini_set('display_errors', '1');
require_once("../lib/seg.php");
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
include("../lib/class/usuario.class.php");
$usuarios= new usuario ();

$usuario=$_SESSION['user'];
if (isset($_GET['id'])) {
  $id=$_GET['id'];
}else{
$id=$_POST['id'];

}
$edituser = $usuarios->detalledeusuarios($id);

?>
<?php require_once '../lib/php/common/headA.php'; ?>
<?php require_once '../lib/php/common/menuA.php'; ?>
<!-- Content Wrapper. Contains page content -->
  <link rel="stylesheet" href="dist/css/jquery.tagit.css">

 <div id="content">

          <div class="col-lg-12">
      <h1>
        Editar Usuarios
       
      </h1>
        </div>
                <div class="col-lg-12">
     
          <?php
                ?>
         <br>
              <br>
            
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                </div>
            <!-- /.box-header -->
            <div class="box-body">
        <div class="col-xs-8">
          <form class="form-horizontal" method="POST" action="controlusuario.php?opcion=editarusuario">
            <fieldset>
            <legend>Datos Usuario </legend>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Usuario</label>
              <div class="col-lg-4">
                       <input class="form-control " condicion="1" name="usuario" id="usuario" placeholder="Nuevo usuario" type="text"  value="<?php echo utf8_encode($edituser[0]['uname']); ?>" disabled>
                       <input class="form-control" name="id"  id="id"  type="hidden"   value="<?php echo $edituser[0]['id']; ?>">
              </div>
              
              <label for="inputEmail" class="col-lg-2 control-label">Contraseña</label>
              <div class="col-lg-4">
                       <input class="form-control "  name="contraseña"  id="contraseña" placeholder="Contraseña" type="password"  >
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
              <div class="col-lg-4">
                       <input class="form-control " condicion="1" name="nombre" id="nombre"  placeholder="Nombre" type="text"  required value="<?php echo utf8_encode($edituser[0]['nombres'] ); ?>">
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Apellido</label>
                   <div class="col-lg-4">
              <input class="form-control " condicion="1" name="apellido" id="apellido" placeholder="Apellido" type="text" required value="<?php echo utf8_encode($edituser[0]['apellido']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Supervisor</label>
              <div class="col-lg-4">
              <input class="form-control"  condicion="1" name="supervisor"  id="supervisor" placeholder="Supervisor" type="text"   value="<?php echo utf8_encode($edituser[0]['supervisor']); ?>">
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Sucursal</label>
              <div class="col-lg-4">
              <input class="form-control " condicion="1" name="sucursal"  id="sucursal" placeholder="Sucursal" type="text"  required value="<?php echo utf8_encode($edituser[0]['sucursal']); ?>">
              </div>
            </div>
            <div class="form-group">
           <label for="select" class="col-lg-2 control-label" >Equipo</label>
              <div class="col-lg-4">
                <select class="form-control" name="equipo" required>
                   <?php if ($usuario=="manuel" ) {?>
                  <option value="<?php echo utf8_encode($edituser[0]['team']); ?>"><?php echo utf8_encode($edituser[0]['team']); ?></option>
                  <option value="Vendedor">Vendedor</option>
                  <option value="Ventas">Ventas</option>
                  <option value="Telemarketing">Telemarketing</option>

                   <?php }else{?>
                   <option value="<?php echo utf8_encode($edituser[0]['team']); ?>"><?php echo utf8_encode($edituser[0]['team']); ?></option>
                  <option value="Vendedor">Vendedor</option>
                  <option value="Ventas">Ventas</option>
                  <option value="Coordinador">Coordinador</option>
                  <option value="cxc">Cuentas por cobrar</option>
                  <option value="Auditoria">Auditoria</option>
                  <option value="Telemarketing">Telemarketing</option>
                  <option value="Despacho">Despacho</option>
                  <option value="Distribuidor">Distribuidor</option>
                  <option value="Eventual">Eventual</option>
                <?php }?>
                </select>
              </div>
              <label for="select" class="col-lg-2 control-label" >Tipo</label>
              <div class="col-lg-4">
                <select class="form-control" name="tipo" required>
                <?php if ($usuario=="manuel" ) {?>
                  <option value="<?php echo utf8_encode($edituser[0]['tipo']); ?>"><?php echo utf8_encode($edituser[0]['descripcion']); ?></option>
                  <option value="1">Vendedor</option>
                  <option value="12">Ventas</option>
                  <option value="11">Telemercadeo</option>
                   <?php }else{?>
                  <option value="<?php echo utf8_encode($edituser[0]['tipo']); ?>"><?php echo utf8_encode($edituser[0]['descripcion']); ?></option>
                  <option value="1">Vendedor</option>
                  <option value="2">Coordinador</option>
                  <option value="3">Gerente de Ventas</option>
                  <option value="4">Administrador</option>
                  <option value="5">Sistemas</option>
                  <option value="6">Facturacion</option>
                  <option value="7">Gerencia de mercadeo</option>
                  <option value="8">Presidencia</option>
                  <option value="9">Auditoria</option>
                  <option value="10">Eventual</option>
                  <option value="11">Telemercadeo</option>
                  <option value="12">Ventas</option>

                   <?php }?>
                </select>
              </div>
            </div>
            <div class="form-group">
             <label for="select" class="col-lg-2 control-label" >Estatus</label>
              <div class="col-lg-4">
                <select class="form-control" name="estatus" required>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
          
                </select>
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Correo</label>
              <div class="col-lg-4">
              <input class="form-control" name="email"  id="email" placeholder="Correo electronico" type="text"  required value="<?php echo utf8_encode($edituser[0]['email']); ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
              <button type="reset" class="btn btn-default">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="cargar">Editar</button>
              </div>
            </div>
            </fieldset>
          </form>
        </div>
        <div class="col-xs-4">
          <div class="alert alert-dismissible alert-success">
            <strong>Datos </strong> agrege los datos que desee editar de este usuario </a>.
          </div>
            <div class="alert alert-dismissible alert-success">
            <strong>Contraseña </strong> si no desea cambiar la contraseña deje este campo en blanco </a>.
          </div>
        </div>
        <!-- /.box-body -->
        </div>
          </div>
          <!-- /.box -->
        </div>
     
        <div class="col-xs-12">
      <?php 
      $listausuarios = $usuarios->getusuarioslista();
     
    ?>
    </div>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de Usuarios</div>
                    <div class="panel-body">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
               <thead>
                  <tr>
                      <th>Id</th>
                      <th>Usuario</th>
                      <th>Nombre</th>
                      <th>Supervisor</th>
                      <th>Tipo Usuario</th>
                      <th>Correo</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
              <tbody>
                   <?php
                    
                  foreach ($listausuarios as $listausuario) {
                    ?>
                        <tr>
                          

                          <td> <?php echo $listausuario['id_usuario']; ?></td>
                          <td><?php echo utf8_encode($listausuario['uname']);?></td>
                          <td><?php echo utf8_encode($listausuario['nombre']); ?></td>
                          <td><?php echo utf8_encode($listausuario['supervisor']); ?></td>
                          <td><?php echo utf8_encode ($listausuario['descripcion']); ?></td>
                          <td><?php echo utf8_encode ($listausuario['email']); ?></td>
                         
                          <td>
                            <form action="usuarioseditar.php" method="POST">
                            
                                <button name="id" type="submit" class="btn btn-primary btn-xs btn-block" value="<?php echo $listausuario['id_usuario']; ?>"><i class="fa fa-eye"></i> Ver</button>
                            </form>
                          </td>

                        <td>
                             
                            <a class="btn btn-danger fa fa-trash-o link-borrar" href="controlusuario.php?opcion=Eliminarusuario&id=<?php echo $listausuario['id_usuario']; ?>&usuario=<?php echo utf8_encode($listausuario['uname']);?>&tipo=<?php echo $listausuario['tipo']; ?>">
                            </td>
 
                        </tr>
                      <?php
                    }
                   ?>
             </tbody>
                  <tfoot>
                  <tr>
                  
                      <th>Id</th>
                      <th>Usuario</th>
                      <th>Nombre</th>
                      <th>Supervisor</th>
                      <th>Tipo Usuario</th>
                      <th>Correo</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                  </tr>
                  </tfoot>

                </table>
            </div>
</table> 
 </div>


  
  <!-- /.content-wrapper -->

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
        $('#example1').DataTable({
                responsive: true
        });
    });
    </script>
</body>

</html>