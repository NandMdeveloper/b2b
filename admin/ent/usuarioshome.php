<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
include("../lib/class/usuario.class.php");
$usuario=$_SESSION['user'];
$usuarios = new usuario ();

?>
<!DOCTYPE html>
<html lang="es">

<?php require_once('../lib/php/common/headA.php'); ?>

<body>

    <?php require_once('../lib/php/common/menuC.php'); ?>
<!-- Content Wrapper. Contains page content -->


  <div id="content">

          <div class="col-lg-12">
      <h1>
        Usuarios

      </h1>
     
    <!-- Main content -->

   </div>
                <div class="col-lg-12">
     
        <?php
        if(isset($_SESSION["msn-tipo"])){
         $usuarios->getMensajes();
        }
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
          <form class="form-horizontal" method="POST" action="controlusuario.php?opcion=agregarusuario">
            <fieldset>
            <legend>Crear Nuevo Usuario </legend>
            <div class="form-group">
                  <label for="inputEmail" class="col-lg-2 control-label">Usuario</label>
              <div class="col-lg-4">
             <input class="form-control " condicion="1" name="usuario" id="usuario" placeholder="Nuevo usuario" type="text" required>
              </div>
              
              <label for="inputEmail" class="col-lg-2 control-label">Contraseña</label>
              <div class="col-lg-4">
                       <input class="form-control "  name="contraseña"  placeholder="Contraseña" type="password" required >
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
              <div class="col-lg-4">
                       <input class="form-control " condicion="1" name="nombre" id="nombre"  placeholder="Nombre" type="text" required>
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Apellido</label>
                   <div class="col-lg-4">
              <input class="form-control " condicion="1" name="apellido" id="apellido" placeholder="Apellido" type="text" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Supervisor</label>
              <div class="col-lg-4">
              <input class="form-control"  condicion="1" name="supervisor"  id="supervisor" placeholder="Supervisor" type="text" >
              </div>
              <label for="inputEmail" class="col-lg-2 control-label">Sucursal</label>
              <div class="col-lg-4">
              <input class="form-control " condicion="1" name="sucursal"  id="sucursal" placeholder="Sucursal" type="text" required>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label" >Equipo</label>
              <div class="col-lg-4">
                <select class="form-control" name="equipo" required>
                   <?php if ($usuario=="manuel" ) {?>
                  <option value=""></option>
                  <option value="Vendedor">Vendedor</option>
                  <option value="Ventas">Ventas</option>
                  <option value="Telemarketing">Telemarketing</option>

                   <?php }else{?>
                   <option value=""></option>
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
                  <option value=""></option>
                  <option value="1">Vendedor</option>
                  <option value="12">Ventas</option>
                  <option value="11">Telemercadeo</option>
                   <?php }else{?>
                   <option value=""></option>
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
              <input class="form-control" name="email"  id="email" placeholder="Correo electronitualco" type="text" >
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
              <button type="reset" class="btn btn-default">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="cargar">Crear</button>
              </div>
            </div>
            </fieldset>
          </form>
        </div>
        <div class="col-xs-4">
          <div class="alert alert-dismissible alert-success">
            <strong>Datos </strong> agregue los datos necesarios para crear el nuevo usuario 
          </div>
          <div class="alert alert-dismissible alert-success">
            <strong> Vendedor </strong> el Usuario de los vendedores son su mismo codigo de profit
          </div>
        </div>
        <!-- /.box-body -->
        </div>
          </div>
          <!-- /.box -->
        </div>

    <div class="col-lg-12">
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
            <?php 
                $ediciones =  $usuarios->getauditoriaUsuarios();  

                if (count($ediciones)) {
                
              ?>
                        <div class="col-md-12">
                          <h3 class="box-title">Auditoria <small>interna</small></h3>
                          <!-- The time line -->
                          <ul class="timeline">
                            <!-- timeline time label -->
                            <?php 
                                foreach ($ediciones as $ed) {
                                  $fe = explode(' ', $ed['fecha']);
                                  $fecha = $fe[0];
                                  $hora = $fe[1];
                             ?>
                             <li class="time-label">
                                  <span class="bg-red">
                                    <?php  echo $usuarios->fechaNormalizada($fecha); ?>
                                  </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                              <i class="fa fa-user bg-aqua"></i>

                              <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> <?php  echo $hora; ?></span>

                                <h3 class="timeline-header"><a href="#"><?php  echo  $ed['user']; ?></a> <?php  echo  $ed['tipo']; ?> Usuario </h3>

                                <div class="timeline-body">
                                  <?php 
                                  echo $ed['accion'];
                                 ?>
                                  </div>
                              </div>
                            </li>
                            <!-- END timeline item -->
                


                             <?php } ?>
                            <li>
                              <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                          </ul>
                        </div>
                        <!-- /.col -->
                  
            
              
        <?php 
    
          }
        ?>


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
