<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();
$nombreE = $_SESSION["nombre"];
$pedido = $_POST["pagar"];
$_SESSION["pedido"]=$pedido;
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$co_ven=$_SESSION["co_ven"];
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pedidos Cyberlux Distribuidores</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../css/tema.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<SCRIPT> 
obligatorio=["tipo", "archivo"];
textoObligatorio=["Tipo de pago", "Comprobante de Pago"]; 
function comprobar(este){
    for(a=0;a<obligatorio.length;a++){
        if(este.elements[obligatorio[a]].value==""){
            alert("Por favor, define el "+textoObligatorio[a]); 
            este.elements[obligatorio[a]].focus(); 
            return false;
        }
    }
    return true; 
}
</SCRIPT>
<body>

    <?php require_once('lib/php/common/menu.php'); ?>
        <div id="content">
            
                <div class="col-lg-12">
                    <h1 class="page-header">Pagar</h1>
                </div>
                <!-- /.col-lg-12 -->
            
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Adjunte sus Comprobantes de Pago para el Pedido # <?php echo $pedido; ?> 
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <form role="form" name="subir" action="imagenpf.php" method="POST" enctype="multipart/form-data">
				
                                    <div class="form-group">
                                        <label >Tipo de Pago de Pedido</label>
                                    </div>
                                <div class="btn-group typePago" data-toggle="buttons">
                                    <label class="btn btn-primary">
                                        <input type="checkbox" autocomplete="off" name="tipo[]" value="Transferencia">Transferencia
                                    </label>
                                    <label class="btn btn-primary">
                                        <input type="checkbox" autocomplete="off" name="tipo[]" value="Deposito">Depósito
                                    </label>
                                    <label class="btn btn-primary">
                                        <input type="checkbox" autocomplete="off" name="tipo[]" value="Saldo a favor">Saldo a Favor
                                    </label>
                                    </div>
                                        
                                        <div class="form-group text-center">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="6000000" />
                                            <label for="pedido" >Comprobante de Pago de Pedido</label>
                                            <h5 class="text-center">Tamaño máximo por archivo: 5M</h5>
                                            <input name="archivo[]" class="multi form-control" type="file" id="archivo" placeholder="Adjunte Imagen" >
                                        </div>
                                    
                                    <div class="text-center">
					<button type="submit" class="btn btn-success">Enviar</button>
                                    </div>
					
                            </form>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            
        </div>
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../dist/js/jquery.MultiFile.js" type="text/javascript"></script>
    
</body>

    
</html>
