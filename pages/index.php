<?php 
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pedidos FC Distribuidores</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../css/estilo.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" action="registro.php" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Datos del Distribuidor</h4>
                </div>
                <div class="modal-body">
                    
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Nombre del Distribuidor" name="nombre_d" type="text" value="" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Rif" name="rif" type="text" title="Ejemplo: J000000000" pattern="^[JGV][0-9]{9}$" required>
                            </div>
                            <div class="form-group">
                                <textarea name="direccion" class="form-control" rows="3" placeholder="Dirección" required></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Teléfono" name="telefono" type="text" title="Ejemplo: 0000-0000000" pattern="^[0-9]{4}[-][0-9]{7}$" required>
                            </div>
                            <hr width="85%"/>
                            <div class="text-center"><label><em>Persona de Contacto</em></label></div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Nombre" name="nombre_c" type="text" value="" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Cédula" name="cedula" type="text" title="Ejemplo: V-00000000" pattern="^[PEV][-][0-9]{8}$" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Teléfono" name="telefono_c" type="text" title="Ejemplo: 0000-0000000" pattern="^[0-9]{4}[-][0-9]{7}$" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Correo Electrónico" name="correo" type="text" title="Ejemplo: abc@abc.com" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" value="" required>
                            </div>
                        </fieldset>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-info" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline btn-success">Enviar</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="container">
        
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                
                    <div class="panel-body">
                        <div class="alert alert-info text-center">
                           Si quiere distribuir nuestros productos registrese <button class="btn btn-outline btn-success btn-xs" data-toggle="modal" data-target="#myModal">aquí</button>
                        </div>
                     </div>
                        <!-- .panel-body -->
                 
                    <!-- /.panel -->
             </div>
                <!-- /.col-lg-8 -->
        
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Inicie Sesión</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="lib/php/common/login.php" method="POST">
                            <fieldset>
                            
                                <div class="form-group">
                                    <input class="form-control" placeholder="Rif" name="rif" type="text" title="Ejemplo: J000000000" pattern="^[JGV][0-9]{9}$" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="pass" type="password" value="" required>
                                </div>
                                
                                <button type="submit" class="btn btn-outline btn-success btn-lg btn-block">Entrar</button>                               
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <script src="../js/scripts.js"></script>

</body>

</html>
