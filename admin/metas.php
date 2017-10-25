<?php
function conectar()
{
        //$con = mysql_connect('localhost', 'root', 'localhost');
        $con = mysql_connect('localhost', 'power_db', '#hGbkWpdeSD;');
    //$con = mysql_connect('192.168.0.127', 'root', 'ph2016..');
        //$con = mysql_connect('192.168.0.128', 'root', 'prohome2016');
        //$con = mysql_connect('localhost', 'grupopro_user', '#hGbkWpdeSD;');
    //mysql_select_db('grupopro_pow', $con);
        mysql_select_db('b2bfc', $con);
        mysql_set_charset('utf8');
}
conectar();

function get_art(){
    $sQuery="SELECT co_art, co_lin, monto, stock FROM art WHERE stock >0";
    $result=mysql_query($sQuery) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
        }
	$i++;
    }
    return($res_array);
}
function get_coord(){
    $sQuery="SELECT uname FROM usuario  WHERE  tipo = 2 AND status = 1";
    $result=mysql_query($sQuery) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
	}
	$i++;
    }
    return($res_array);
}
function get_vende(){
    $sQuery="SELECT uname, supervisor  FROM usuario WHERE tipo = 1 AND status = 1 AND supervisor is not null";
    $result=mysql_query($sQuery) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
	}
	$i++;
    }
    return($res_array);
}
function add_meta_art($mes='',$ano='',$co_art='',$stock=''){
    $query = "INSERT INTO meta_art (mes,ano,co_art,existen) VALUES ('$mes','$ano','$co_art','$stock')";
    $result=mysql_query($query) or die(mysql_error());
    $new_pet_id = mysql_insert_id();
    return $new_pet_id;
}
function add_meta_art_coord($mes='',$ano='',$co_art='',$co_lin='',$monto='',$co_coord=''){
    $query = "INSERT INTO meta_art_coord (mes,ano,co_art,co_lin,monto,co_coord) VALUES ('$mes','$ano','$co_art','$co_lin','$monto','$co_coord')";
    $result=mysql_query($query) or die(mysql_error());
    $new_pet_id = mysql_insert_id();
    return $new_pet_id;
}
function add_meta_art_vende($mes='',$ano='',$co_art='',$co_lin='',$monto='',$co_coord='',$co_ven='',$stock=''){
    $query = "INSERT INTO meta_art_vende (mes,ano,co_art,co_lin,monto,co_coord,co_ven,asignada) VALUES ('$mes','$ano','$co_art','$co_lin','$monto','$co_coord','$co_ven','$stock')";
    $result=mysql_query($query) or die(mysql_error());
    $new_pet_id = mysql_insert_id();
    return $new_pet_id;
}
function get_cant_registros($tabla,$where){
    $sQuery="SELECT * FROM $tabla WHERE $where";
    $result=mysql_query($sQuery) or die(mysql_error());
    $i=0;
    while($row=mysql_fetch_array($result)){
        foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
	}
	$i++;
    }
    return($res_array);
}    
$mes = date('m');
$ano = date('Y');
$arr_art=get_art(); 
if (sizeof($arr_art)<=0){
  echo '<script type="text/javascript">alert("No hay articulos disponibles");window.location="inventario.php";</script>';
}else{ 
  for($k0=0;$k0<sizeof($arr_art);$k0++){
    $r0 = get_cant_registros('meta_art',"mes = '".$mes."' AND ano = '".$ano."' AND co_art = '".$arr_art[$k0]['co_art']."'" );
    if (sizeof($r0)<=0){
        add_meta_art($mes,$ano, $arr_art[$k0]['co_art'], $arr_art[$k0]['stock']);
    }
  }
  $arr_coord=get_coord();          
  for($c=0;$c<sizeof($arr_coord);$c++){
    for($k=0;$k<sizeof($arr_art);$k++){
        $rr = get_cant_registros('meta_art_coord',"mes = '".$mes."' AND ano = '".$ano."' AND co_art = '".$arr_art[$k]['co_art']."' AND co_coord = '".$arr_coord[$c]['uname']."'" );
        if (sizeof($rr)<=0){
            add_meta_art_coord($mes,$ano, $arr_art[$k]['co_art'],$arr_art[$k]['co_lin'],$arr_art[$k]['monto'],$arr_coord[$c]['uname']);//NUEVA META DETALLE
        }
      }
    }
  $arr_vend=get_vende();        
  for($c=0;$c<sizeof($arr_vend);$c++){
    for($k=0;$k<sizeof($arr_art);$k++){
     $rrv = get_cant_registros('meta_art_vende',"mes = '".$mes."' AND ano = '".$ano."' AND co_art = '".$arr_art[$k]['co_art']."' AND co_ven = '".$arr_vend[$c]['uname']."'" );
     if (sizeof($rrv)<=0){ 
       add_meta_art_vende($mes,$ano, $arr_art[$k]['co_art'],$arr_art[$k]['co_lin'],$arr_art[$k]['monto'],$arr_vend[$c]['supervisor'],$arr_vend[$c]['uname'],$arr_art[$k]['stock']);//NUEVA META DETALLE
        }
      }
    }
    echo '<script type="text/javascript">alert("Metas del mes '.$mes.' y Año '.$ano.' han sido creadas");</script>';
  }
?>
