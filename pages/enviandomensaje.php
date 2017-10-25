<?php
require_once("lib/seg.php");
require_once('lib/conex.php');
conectar();
$para=$_SESSION["para"];
$asunto=$_POST["asunto"];
$mensaje=$_POST["mensaje"];
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$lista_precio=$_SESSION["lista_precio"];
$co_ven=$_SESSION["co_ven"];
$de="b2b@cyberlux.com.ve";

switch($para){
    case "t":
       $a="sistemas@cyberlux.com.ve";
    break;
    case "m":
       $a="sistemas@cyberlux.com.ve";
    break;
    case "c":
       $a="sistemas@cyberlux.com.ve";
    break;
    case "d":
       $a="ebastidas@cyberlux.com.ve";
    break;
    case "s":
        $a="eperez@cyberlux.com.ve";
    break; 
}
$headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
$headers .= "X-Mailer: PHP5\n";
$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
$bool=mail($a, $asunto, $mensaje, $headers);
if($bool){
    ?>
       <script type="text/javascript">window.location="home.php";</script>
    <?php
}else{
    ?>                
       <script type="text/javascript">alert("Ocurrio un problema al enviar su mensaje, intentelo nuevamente...");window.location="home.php";</script>
    <?php
}


?>