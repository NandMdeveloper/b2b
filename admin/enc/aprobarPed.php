<?php
//editado por: luis lopez el 31/10/2017
require_once("../lib/seg.php");
if($_SESSION['tipo']!='2') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;

function add_pedidos($idn,$co_ven,$descrip,$co_cli,$status,$fecha_emis,$total_bruto,$monto_imp,$total_neto,$OrderNumberTax){
    $query = "INSERT INTO pedidos (doc_num,co_ven,descrip,co_cli,status,fec_emis,total_bruto,monto_imp,total_neto,OrderNumberTax) 
				  VALUES ($idn,'$co_ven','$descrip','$co_cli',$status,'$fecha_emis',$total_bruto,$monto_imp,$total_neto,$OrderNumberTax)";
    $result=mysql_query($query);
    return $result;
}
function add_pedidos_detalles($reng_num,$doc_num,$co_art,$des_art,$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,$uniCodP,$co_precio){
    $query="INSERT INTO pedidos_detalles (reng_num,doc_num,co_art,des_art,total_art,prec_vta,total_sub,monto_imp,reng_neto,UniCodPrincipal,co_precio) 
				  VALUES ($reng_num,$doc_num,'$co_art','$des_art',$total_art,$prec_vta,$total_sub,$monto_imp,$reng_neto,'$uniCodP','$co_precio')";
    $result=mysql_query($query);
    return $result;
}
function update_pedidos_app($id,$idn){
    $query = "UPDATE pedidos_app SET status=2, doc_num_p=$idn";
    $query .= " WHERE doc_num = $id";
    $result=mysql_query($query);
    return $result;
}
function add_log($fecha,$user,$accion){
    $query = "INSERT INTO log_data_pow (id,fecha,user,accion)";
    $query .= " VALUES (NULL,'$fecha','$user','$accion')";
    $result=mysql_query($query);
    return $result;
}

if($_REQUEST['id']){
    $id = $_REQUEST['id'];
    $tipo_d = $_REQUEST['tipo_d'];
    $cond_pago = $_REQUEST['tipo_p'];
    $user=$_SESSION['usuario'];
    $fecha=date("Y-m-d H:i:s");

    $arr_pedidos=$obj_pedidos->get_pedido_app($id);
    $arr_dp=$obj_pedidos->get_detalles_pedido_app($id);
    $arr_tipop=$obj_pedidos->get_tipoprecioart('',$tipo_d);
    $porcentaje=$arr_tipop[0]['porcentaje'];
    $co_precio=$arr_tipop[0]['co_precio'];
    $iva=$arr_pedidos[0]["OrderNumberTax"];
    $total_bg=0;
    $total_imp=0;
    $total_glob=0;

    for($i=0;$i<sizeof($arr_dp);$i++){
        $precio=$arr_dp[$i]['prec_vta'];
        $desc=($precio*$porcentaje)/100;
        $precio_new=$precio-$desc;
        $sub_total=$arr_dp[$i]['total_art']*$precio_new;
        $monto_imp=($sub_total*$iva)/100;
        $reng_neto=$sub_total+$monto_imp;
        $s="UPDATE pedidos_detalles SET co_precio='".$co_precio."', prec_vta=".$precio_new.", total_sub=".$sub_total.", monto_imp=".$monto_imp.", reng_neto=".$reng_neto." WHERE id=".$arr_dp[$i]['id'];
        $insert=@mysql_query($s);
        $total_bg+=$sub_total;
        $total_imp+=$monto_imp;
        $total_glob+=$reng_neto;
    }

    $a="UPDATE pedidos SET status=2, fecha_preap='".$fecha."', total_bruto=".$total_bg.", monto_imp=".$total_imp.", total_neto=".$total_glob.", co_cond='".$cond_pago."' WHERE doc_num=".$id;
    $insert2=@mysql_query($a);

    if($insert && $insert2) {
        //mysql_query('COMMIT');
        add_log($fecha, $user, "Coordinacion, preaprobacion del pedido Web #" . $id . " a Credito y Cobranzas");
        for ($i = 0; $i < sizeof($arr_dp); $i++) {
            add_log($fecha, $user, "Coordinacion, agrego el articulo " . $arr_dp[$i]['co_art'] . ", la cantidad de:" . $arr_dp[$i]['total_art'] . " del pedido #" . $id . " a Credito y Cobranzas");
        }
    }
    ?>}  <script language="javascript" type="text/javascript">window.location="home.php?status=e";</script><?php
}else{
    ?> <script language="javascript" type="text/javascript">alert("No se recibieron datos...");window.location="home.php?status=e";</script> <?php
}

?>
