<?php
require_once("lib/seg.php");
require_once('lib/conex.php');
conectar();

$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
if($_POST){
    $nombre_d=strip_tags($_POST['nombre_d']);
    $rif=strip_tags($_POST['riff']);
    $direccion=strip_tags($_POST['direccion']);
    $telefono=strip_tags($_POST['telefono']);
    $nombre_c=strip_tags($_POST['nombre_c']);
    $cedula=strip_tags($_POST['cedula']);
    $telefono_c=strip_tags($_POST['telefono_c']);
    $correo=strip_tags($_POST['correo']);
    $fecha=date("Y-m-d H:i:s");

    if(!empty($nombre_d) && !empty($rif) && !empty($direccion) && !empty($telefono) && !empty($nombre_c) && !empty($cedula) && !empty($telefono_c) && !empty($correo)){
        mysql_query("BEGIN");
        $sQuery=@mysql_query("SELECT cli_des FROM clientes WHERE rif='".mysql_real_escape_string($rif)."'");
        if($existe = @mysql_fetch_object($sQuery)){
            echo '<script type="text/javascript">alert("El Cliente '.$nombre_d.' ya forma parte de nuestros distribuidores...");window.location="evento.php"</script>';
        }else{
            $meter=@mysql_query('INSERT INTO cliente_evento (`id`, `rif`, `nombre_emp`, `direccion`, `telefono`, `persona_contacto`, `cedula`, `correo`, `telefono_c`, `fecha`) 
            VALUES (NULL,"'.mysql_real_escape_string($rif).'", "'.mysql_real_escape_string($nombre_d).'", "'.mysql_real_escape_string($direccion).'", "'.mysql_real_escape_string($telefono).'", "'.mysql_real_escape_string($nombre_c).'", "'.mysql_real_escape_string($cedula).'", "'.mysql_real_escape_string($correo).'", "'.mysql_real_escape_string($telefono_c).'", "'.mysql_real_escape_string($fecha).'")');
            if($meter){
                @mysql_query("INSERT INTO evento (id,rif,user,fecha,new) VALUES (NULL, '".$rif."', '".$user."', '".$fecha."', 's');");
                mysql_query("COMMIT");
                ?> <script type="text/javascript">window.location="evento.php";</script> <?php
            }else{
                mysql_query("ROLLBACK");
                ?> <script type="text/javascript">alert("Ocurrio un problema al registrarse, intentelo  nuevamente...");window.location="evento.php";</script> <?php
            }
        }
    }else{
        ?> <script type="text/javascript">alert("Los campos no pueden estar vacios...");window.location="evento.php";</script> <?php
    }
}else{
   ?> <script type="text/javascript">window.location="evento.php";</script> <?php
}  	
?>
