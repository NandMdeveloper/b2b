        <?php 

$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$boton=$_POST['enviar'];
//echo $usuario."  -- ".$clave." - ".$boton;
if ($boton=="enviar" and $clave=="CX@20112" and $usuario=="admin"){

    
        $conexion = mysql_connect("186.24.0.226", "root", "localhost");
        mysql_select_db("b2b_cyb", $conexion);

mysql_query("BEGIN", $conexion);
if ($_POST['creditos']=="creditos"){

        $nombre_fichero = "creditos.txt";
if (file_exists($nombre_fichero)==false){
              mysql_query("ROLLBACK", $conexion);
	      die('ARCHIVO '.$nombre_fichero.' NO EXISTE');
          }
        $gestor = fopen($nombre_fichero, "r");
        $contenido = fread($gestor, filesize($nombre_fichero));
            $arreglo = explode("\n", $contenido);
            $resultado = Array();
            $resEmp = mysql_query("delete from creditos", $conexion) or die(mysql_error());
                foreach($arreglo as $linea){
                    $d = explode("|", $linea);
                    $query = "INSERT INTO creditos (id, cod_cliente, limite, fila) VALUES (null,'".str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<"),
        ' ',$d[0])."','".$d[1]."',0);";
echo "<br>".$query;
                    $resEmp = mysql_query($query, $conexion) or die(mysql_error());
                 }
                     echo "<h2>Creditos Ingresados</h2><hr>";
                 fclose($gestor);

mysql_query("COMMIT", $conexion);
}
}
        ?>
<html> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Subir Creditos Clientes</title>
        <style type="text/css">
            body{
                background-color:  #EBE79E;
            }
            .tr{
                background-color: #118cb7;
            }
            .tr1{
                background-color: #b1cf7e;

            }
            .redondear{
                border: 1px;
       background: url('images/fondo_az.png') repeat;         
      moz-border-radius: 2em;
     -webkit-border-radius: 2em;
     border-radius: 2em;
            }
        </style>
    </head>
    <body>
                <div style="width:100px;">
            <img src="images/es_data.png" alt="SAP">
        </div>
        
	<form name="form1" method="post" action="creditos.php">
        <table border="1" class="redondear" style="border-collapse: collapse;">
<tr class="tr">
<td>
    <b>Usuario:</b>
</td>
<td><input type="text" name="usuario" id="usuario"></td>
</tr>
<tr class="tr1">
<td>
    <b>Clave:</b>
</td>
<td><input type="password" name="clave" id="clave"></td>
</tr>
	</table>
            <br>
            <div style="margin-left: 10px;width: 500px;padding: 20px;" class="redondear">
            <table>
                <tr>
                    <td colspan="2"><h3>Descargar Data Creditos &DDotrahd; EASYSALE</h3></td>
                </tr>
                <tr align="center">
                    <td style="color:white;"><b>Operacion</b></td>
                    <td style="color:white;"><b>Seleccionar</b></td>
                </tr>
                <tr align="left">
                    <td>Descargar Créditos Clientes</td>
                    <td><input type="checkbox" name="creditos" id="creditos" value="creditos" /> </td>
                </tr>
                   <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="enviar" value="enviar" />
                    </td>
                </tr> 
            </table>
            </div>
        </form>
        <hr>
        <div style="width: 100%;height: 30px;background-color: silver; padding-top: 5px;" align="center">
            <b>|Departamento de Sistemas|</b>
        </div>
    </body>
</html>
