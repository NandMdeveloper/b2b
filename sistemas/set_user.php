<?php
if($_POST){
    $con = mysql_connect('localhost', 'power_db', '#hGbkWpdeSD;');
    @mysql_select_db('b2bfc', $con);
    
    $usuario=$_POST["usuario"];
    $pass=$_POST["pass"];
    $team=$_POST["team"];
    $tipo=$_POST["t_usuario"];
    $nombre=$_POST["nombre"];
    $email=$_POST["email"];
    unset($_POST);
    $hash=password_hash($pass, PASSWORD_DEFAULT);
    $sql="INSERT INTO usuario (id,uname,passwd,team,status,logincount,tipo,nombre,email,intent) VALUES (default,'".$usuario."','".$hash."','".$team."','1',0,'".$tipo."','".$nombre."','".$email."',0)";
    @mysql_query($sql);
    ?> <script language="javascript" type="text/javascript">window.location="set_user.php";</script> <?php
}else{

//$hash=password_hash("rasmuslerdorf", PASSWORD_DEFAULT);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Creación de usuarios - Admin</title>

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
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-body">
                        <form role="form" action="set_user.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="usuario" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="pass" type="password" value="" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Team" name="team" type="text" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Tipo Usuario" name="t_usuario" type="text" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Nombre" name="nombre" type="text" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text" required>
                                </div>
                                <button type="submit" class="btn btn-outline btn-success btn-lg btn-block">Enviar</button>                               
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
<?php
}
?>