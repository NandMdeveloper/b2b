<?php
		session_start();

	if ($_SESSION['tipo'] != 9 ) {
		header("Location: ../../index.php"); 
  		exit();
	}
		include('../lib/conecciones.php');
	    include('../lib/class/usuario.class.php');

	$opcion = $_GET['opcion'];
switch ($opcion) {
/*recoge los datos de el formulario y los envia a la class para hacer la insercion del  nuevo usuario*/
case "agregarusuario":
			$campos = $_POST; 	
			
            $usuarios =  new usuario();
			 $registrousuario = $_POST['usuario'];
             $clave = $_POST['contraseña'];
             $nombre = $_POST['nombre'];
             $apellido = $_POST['apellido'];
             $equipo = $_POST['equipo'];
             $sucursal = $_POST['sucursal'];
             $tipo =$_POST['tipo'];
             $supervisor = $_POST['supervisor'];
             $estatus = $_POST['estatus'];
             $email = $_POST['email'];
            // var_dump($campos); exit();

			if(!empty($nombre) and  !empty($registrousuario) and !empty($tipo) ){
					$campos = $_POST;
					$usuarios->nuevousuario($campos);
					$user = $_SESSION['user'];
				/*envia el historico para inserta en la base de datos la accion con el usuario que la realizo*/
					//$usuarios->add_log(date("Y-m-d h:i:sa"),$user,"Creo el Usuario ".$registrousuario);
			}else{
				$usuarios->setMensajes('warning','llene todos los datos');
				
					
			}
			header("Location: usuarioshome.php");
        break;
        /*recoge los datos de el formulario y los envia a la class para hacer la edicion  del   usuario seleccionado*/
        case "editarusuario":
			$campos = $_POST; //	var_dump($campos); exit();

			$usuarios=  new usuario();
			 $id = $_POST['id'];
		 $registrousuario = $_POST['usuario'];
             $clave = $_POST['contraseña'];
             $nombre = $_POST['nombre'];
             $apellido = $_POST['apellido'];
             $equipo = $_POST['equipo'];
             $sucursal = $_POST['sucursal'];
             $tipo =$_POST['tipo'];
             $supervisor = $_POST['supervisor'];
             $estatus = $_POST['estatus'];
             $email = $_POST['email'];


			if(!empty($nombre) and !empty($tipo)){
					$campos = $_POST;
					$usuarios->editarusuario($campos);
						$user = $_SESSION['usuario'];
						/*envia el historico para inserta en la base de datos la accion con el usuario que la realizo*/
					//$usuarios->add_log(date("Y-m-d h:i:sa"),$user,"Edito el usuario ".$registrousuario);
			}else{
				$usuarios->setMensajes('warning','llene todos los datos');
			}
			header("Location: usuarioshome.php?id=".$_POST['id']);

		break;
		   case "Eliminarusuario":
			$campos = $_GET; 	
			$usuarios=  new usuario();
			 $id = $_GET['id'];
		     $registrousuario=$_GET['uname'];
		     $tipo=$_GET['tipo'];
			 $campos = $_GET;
			 //var_dump($campos); exit();
			 $usuarios->eliminarusuario($campos);
			$user = $_SESSION['user'];
						/*envia el historico para inserta en la base de datos la accion con el usuario que la realizo*/
					//$usuarios->add_log(date("Y-m-d h:i:sa"),$user,"Elimino el usuario ".$registrousuario);
			header("Location: usuarioshome.php?id=".$_GET['id']);

		break;
        case "prueba":
        
/*$user_agent = $_SERVER['HTTP_USER_AGENT'];


function getPlatform($user_agent) {
$plataformas = array(
'Windows 10' => 'Windows NT 10.0+',
'Windows 8.1' => 'Windows NT 6.3+',
'Windows 8' => 'Windows NT 6.2+',
'Windows 7' => 'Windows NT 6.1+',
'Windows Vista' => 'Windows NT 6.0+',
'Windows XP' => 'Windows NT 5.1+',
'Windows 2003' => 'Windows NT 5.2+',
'Windows' => 'Windows otros',
'iPhone' => 'iPhone',
'iPad' => 'iPad',
'Mac OS X' => '(Mac OS X+)|(CFNetwork+)',
'Mac otros' => 'Macintosh',
'Android' => 'Android',
'BlackBerry' => 'BlackBerry',
'Linux' => 'Linux',
);
foreach($plataformas as $plataforma=>$pattern){
if (eregi($pattern, $user_agent))
return $plataforma;
}
return 'Otras';
}

$SO = getPlatform($user_agent);

echo "La plataforma con la que estás visitando esta web es: ".$SO;
*/
		break;
	}

?>