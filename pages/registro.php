<?php
require_once('funciones.php');
conectar();

$nombre_d=strip_tags($_POST['nombre_d']);
$rif=strip_tags($_POST['rif']);
$direccion=strip_tags($_POST['direccion']);
$telefono=strip_tags($_POST['telefono']);
$nombre_c=strip_tags($_POST['nombre_c']);
$cedula=strip_tags($_POST['cedula']);
$telefono_c=strip_tags($_POST['telefono_c']);
$correo=strip_tags($_POST['correo']);
$fecha=date('Y-m-d');

if(!empty($nombre_d) && !empty($rif) && !empty($direccion) && !empty($telefono) && !empty($nombre_c) && !empty($cedula) && !empty($telefono_c) && !empty($correo)){
    mysql_query("BEGIN");
    $sQuery=@mysql_query("SELECT name1 FROM clientes_sap WHERE kna1_stc1='".mysql_real_escape_string($rif)."'");
    if($existe = @mysql_fetch_object($sQuery)){
      
          echo '<script type="text/javascript">alert("El distribuidor '.$nombre_d.' ya forma parte de nuestros distribuidores...");window.location="login.html"</script>';
	
    }else{
        $meter=@mysql_query('INSERT INTO cliente_potencial (`id`, `rif`, `nombre_emp`, `direccion`, `telefono`, `persona_contacto`, `cedula`, `correo`, `telefono_c`, `fecha`) 
            VALUES (NULL,"'.mysql_real_escape_string($rif).'", "'.mysql_real_escape_string($nombre_d).'", "'.mysql_real_escape_string($direccion).'", "'.mysql_real_escape_string($telefono).'", "'.mysql_real_escape_string($nombre_c).'", "'.mysql_real_escape_string($cedula).'", "'.mysql_real_escape_string($correo).'", "'.mysql_real_escape_string($telefono_c).'", "'.mysql_real_escape_string($fecha).'")');
        if($meter){
            mysql_query("COMMIT");
            $para = "mercadeo@cyberlux.com.ve";//Email al que se enviará
            $asunto = "Registro Distribuidor Nuevo";//Puedes cambiar el asunto del mensaje desde aqui
            //Este sería el cuerpo del mensaje
            $mensaje = "
		<h2>El siguiente distribuidor se ha Registrado en la Página Web B2B</h2><br>
                <h2>Datos del Distribuidor</h2><br>
		<table border='1' cellspacing='3' cellpadding='2'>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Nombre:</strong></td>
			<td width='80%' align='left'>$nombre_d</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Rif:</strong></td>
			<td width='80%' align='left'>$rif</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Teléfono:</strong></td>
			<td width='80%' align='left'>$telefono</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Dirección:</strong></td>
			<td width='80%' align='left'>$direccion</td>
		  </tr>
		</table>
                <h2>Datos Persona de Contacto</h2><br>
		<table border='1' cellspacing='3' cellpadding='2'>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Nombre:</strong></td>
			<td width='80%' align='left'>$nombre_c</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Cédula:</strong></td>
			<td width='80%' align='left'>$cedula</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Teléfono:</strong></td>
			<td width='80%' align='left'>$telefono_c</td>
		  </tr>
		  <tr>
			<td width='30%' align='left' bgcolor='#f0efef'><strong>Correo:</strong></td>
			<td width='80%' align='left'>$correo</td>
		  </tr>
		</table>";
	
                //Cabeceras del correo
                $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
                $headers .= "X-Mailer: PHP5\n";
                $headers .= 'MIME-Version: 1.0' . "\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
	
                //Comprobamos que los datos enviados a la función MAIL de PHP estén bien y si es correcto enviamos
                $bool=mail($para, $asunto, $mensaje, $headers);
                /////////////////////////////////////////////////////////////////////////////////////
                $para2 = $correo;
                $asunto2 = "Registro B2B Cyberlux de Venezuela";
                $mensaje2 = "<h2>Usted se ha registrado satisfactoriamente en la página web B2B de Cyberlux de Venezuela</h2><br>
                <h3>Sus datos seran procesados y a la brevedad posible sera contactado por uno de nuestro personal para validar dicha información.</h3><br>
                <br>
                <p>Le damos gracias por querer formar parte de nuestra grandiosa y prestigiosa cartera de distribuidores a nivel nacional.
                </p>";
                //Cabeceras del correo
                $headers2 = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
                $headers2 .= "X-Mailer: PHP5\n";
                $headers2 .= 'MIME-Version: 1.0' . "\n";
                $headers2 .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
	
                //Comprobamos que los datos enviados a la función MAIL de PHP estén bien y si es correcto enviamos
                $bool2=mail($para2, $asunto2, $mensaje2, $headers2);
                if($bool && $bool2){
                    
                }else{
                    
                }
                ?>
                <script type="text/javascript">alert("Se ha registrado exitosamente...");window.location="login.html";</script>
                <?php
                }else{
                    mysql_query("ROLLBACK");
                    ?>                
                    <script type="text/javascript">alert("Ocurrio un problema al registrarse, intentelo  nuevamente...");window.location="login.html";</script>
                    <?php
                }
        }
}else{
   ?>                
   <script type="text/javascript">alert("Los campos no pueden estar vacios...");window.location="login.html";</script>
   <?php
}

    	
?>
