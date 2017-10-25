<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
 
$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$d=$_SESSION["posicion"];
$co_ven=$_SESSION["user"];
$email_u=$_SESSION["email"];
$email_s=$_SESSION["emailS"];

$total=$_POST["total"];
$tIva=$_POST["iva"];
$totalN=$_POST["totalN"];
$tipo_pago=$_POST["tipo_pago"];


//$iva=$total*0.12;
//$totalN=$total+$iva;
$fecha=date('Y-m-d H:i:s');

if($d>=1){
    $sq="SELECT email,cli_des FROM clientes WHERE co_cli='$co_cli'";
    $rst= @mysql_query($sq);
    if($ex= @mysql_fetch_object($rst)){
        $email=$ex->email;
        $cliente=$ex->cli_des;
        $st=1;
        $link='admin.php?status=e';
    }else{
        $sq2="SELECT correo,nombre_emp FROM cliente_evento WHERE rif='$co_cli'";
        $rst2= @mysql_query($sq2);
        $ex2= @mysql_fetch_object($rst2);
        $email=$ex2->correo;
        $cliente=$ex2->nombre_emp;
        $st=8;
        $link='admin.php?status=n';
    }
    $query="INSERT INTO pedidos (doc_num,doc_num_p,descrip,co_cli,co_ven,fec_emis,status,total_bruto,monto_imp,total_neto,comentario) VALUES (NULL,NULL,'".$tipo_pago."','".$co_cli."','".$co_ven."','".$fecha."','".$st."','".$total."','".$tIva."','".$totalN."','Pedido realizado por el usuario $nombre');";
    $result = @mysql_query($query);
    $ult_id=mysql_insert_id();
    if($result){
        $sql0="INSERT INTO pedidos_tipos (id,doc_num,tipo) VALUES (NULL,'".$ult_id."','".$tipo_pago."');";
        $r0 = @mysql_query($sql0);
        $mensaje0='<p>Distinguido cliente, gracias por preferirnos, el usuario de Televentas '.$nombre.' ha creado un pedido en su nombre, su información es la siguiente: </p><br>';
        $mensaje1='<p>Ha creado un nuevo pedido en nombre del cliente '.$cliente.' y la información del pedido es la siguiente: </p><br>';
        $mensaje='<h3>Pedido #'.$ult_id.'</h3><br><table><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>';
        for($i=0;$i<$d;$i++){
            $codigo=$_POST["codigo$i"];
            $descripcion=$_POST["descripcion$i"];
            $precio=$_POST["precio$i"];
            $cantidad=$_POST["cantidad$i"];
            $subtotal=$_POST["subtotal$i"];
            $unidad=$_POST["unidad$i"];
            $iva=($subtotal*12)/100;
            $tot=$subtotal+$iva;
            $reng_pedido="INSERT INTO pedidos_detalles (id,reng_num,doc_num,co_art,des_art,total_art,co_precio,prec_vta,total_sub,monto_imp,reng_neto,UniCodPrincipal) 
            VALUES (NULL,".($i+1).",'".$ult_id."','".$codigo."','','".$cantidad."','P1','".$precio."','".$subtotal."','".$iva."','".$tot."','".$unidad."');";
            $resp = @mysql_query($reng_pedido);
            $mensaje.='<tr><td>'.$descripcion.'</td><td>'.$precio.'</td><td>'.$cantidad.'</td><td>'.$subtotal.'</td></tr>';
        }
        $mensaje.='<tr><th colspan="3">Sub-Total</th><th>'.$total.'</th></tr>';
        $mensaje.='<tr><th colspan="3">Iva 12%</th><th>'.$tIva.'</th></tr>';
        $mensaje.='<tr><th colspan="3">Total Neto</th><th>'.$totalN.'</th></tr></table>';
        $sql1="INSERT INTO correos (id,de,para,asunto,mensaje) VALUES (NULL,'".$email_u."','".$email."','Creación de Pedido FC by Fauci','".$mensaje0.$mensaje."');";
        $r1 = @mysql_query($sql1);
        $sql2="INSERT INTO correos (id,de,para,asunto,mensaje) VALUES (NULL,'".$email_s."','".$email_u."','Creación de Pedido FC by Fauci','".$mensaje1.$mensaje."');";
        $r2 = @mysql_query($sql2);
        ?><script type="text/javascript">window.location="<?php echo $link; ?>";</script><?php 
    }else{
    ?>                
       <script type="text/javascript">alert("Ocurrio un problema al crear su pedido, intentelo  nuevamente...");window.location="procesarP.php";</script>
    <?php
    }
}else{
    ?>                
       <script type="text/javascript">alert("Los campos estan vacios, intentelo nuevamente...");window.location="procesarP.php";</script>
    <?php
}
?>


