﻿<?php 
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

    <title>Pedidos Fauci - Admin</title>

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
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading col-xs-hidden">
                        <h3 class="panel-title text-center">Inicio de Sesión Administrador</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="lib/php/common/login.php" method="POST">
                            <fieldset>
                            
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="usuario" type="text" autofocus required>
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
