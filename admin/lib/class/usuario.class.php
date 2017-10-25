<?php
class usuario {
	    public  $servidor = 0; // 1 conecta servidor 134 0 servidor local 
   public function  getConMYSQL() {
     $conn = conectarServ($this->servidor);    
      return $conn;
    } 

     public function setMensajes($tipo,$mensaje) {
      $_SESSION["msn-tipo"]=$tipo;
      $_SESSION["msn-mensaje"]=$mensaje;
    }
/*genera la lista de todos los usuarios*/
	 public function getusuarioslista() {
        
        $lista_usuarios = array();


        $sel_r ="SELECT usuario.id as id_usuario ,usuario.usuario,usuario.nombre,usuario.apellido,usuario.sucursal, usuario.tipo,  usuario_tipo.id, usuario_tipo.descripcion FROM psdb.usuario, psdb.usuario_tipo where usuario.estatus=1 and usuario.tipo = usuario_tipo.id order by usuario.id";

        $conn = $this->getConMYSQL() ;
        $rs_r = mysqli_query($conn,$sel_r) or die(mysqli_error($conn));
       $f=0;
        while($linea=mysqli_fetch_array($rs_r)) {
            foreach($linea as $key=>$value) {
              $lista_usuarios[$f][$key]=$value;
            }
            $f++;
        }       
      return $lista_usuarios;
           
 }
 /*genera el registro de los nuevos usuarios*/
 public function nuevousuario($campos) {
$usuarios =  new usuario();
      $usuario=$_SESSION['user'];
      $registrousuario = $campos['usuario'];
      $clave = $campos['contraseña'];
      $nombre = $campos['nombre'];
      $apellido = $campos['apellido'];
      $equipo = $campos['equipo'];
      $sucursal = $campos['sucursal'];
      $tipo = $campos['tipo'];
      $supervisor = $campos['supervisor'];
      $estatus = $campos['estatus'];
      $email = $campos['email'];
      $pass= md5($clave);


    

      $conn = $this->getConMYSQL() ;
  /*validacion para evitar el registro de un usuario exitente*/
$sQuery="SELECT `usuario` FROM `usuario` where usuario='$registrousuario' ";
$result = mysqli_query($conn,$sQuery);
 
if(mysqli_num_rows($result)>0){  
/*echo "este usuario ya existe "; exit();*/
  header("Location: usuarioshome.php");
  $usuarios->setMensajes('warning','Este usuario ya existe');
}
else
{
 
   if (!empty($registrousuario) and !empty($clave) and !empty($tipo)) {     
         $sel = "INSERT INTO `usuario`
            (`id`,`usuario`,  `clave`,  `estatus`, `tipo`, `equipo`,  `supervisor`,   `nombre`, 
            `apellido`, `sucursal`, `correo`) 
 
            VALUES (null,'".$registrousuario."','".$pass."','".$estatus."','".$tipo."','".$equipo."','".$supervisor."','".$nombre."','".$apellido."','".$sucursal."','".$email."')";
         $rs = mysqli_query($conn,$sel);
        /*condicion solo insertar los usuarios tipo vendedor en el apk*/
         if ($tipo==1) {
        /*inserta el usuario en la tabla del apk*/
         
         $apk= "INSERT INTO `tmuser`(`Userid`,`UserCode`,`UserPassword`,`UserName`,`UserName2`,`UserLastName`,`UserLastName2`,`UserIdenCard`,`UserEmail`,`UserStatus`,`UserBranchOfficeId`,`UserLogErr`,`UserType`)

               VALUES (null,'".$registrousuario."','".$clave."','".$registrousuario."',NULL,null,'0','0','0','".$estatus."','0','0','0')";
                 $insert = mysqli_query($conn,$apk);
                 }else {


        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }
        else{
          $msn = array(
            "error"=>"no"

          );
          /*$this->add_log($usuario,"Agrego","usuario: ".$registrousuario." Tipo".$tipo.", contraseña:".$clave);
          $this->setMensajes('success','Usuario Ingresado');*/
       }
        }
        
}
      }
    }
    /*editas los  usuarios*/
    public function editarusuario($campos) {
      //var_dump($campos); exit();
      $id = $campos['id'];
   $usuario=$_SESSION['user'];
      $registrousuario = $campos['usuario'];
      $clave = $campos['contraseña'];
       $estatus = $campos['estatus'];
      $nombre = $campos['nombre'];
      $apellido = $campos['apellido'];
      $equipo = $campos['equipo'];
      $sucursal = $campos['sucursal'];
      $tipo = $campos['tipo'];
      $supervisor = $campos['supervisor'];
     
      $email = $campos['email'];
      $pass= md5($clave);
     if ( !empty($tipo))
     {
     
  $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="
          UPDATE `usuario` SET
          `usuario`='".$registrousuario."',
          `clave`='".$pass."',
          `estatus`='".$estatus."',
          `tipo`='".$tipo."',
          `equipo`='".$equipo."',
          `supervisor`='".$supervisor."',
          `nombre`='".$nombre."',
          `apellido`='".$apellido."',
          `sucursal`='".$sucursal."',
          `correo`='".$email."'
           WHERE id='".$id."' ";

    
        $rs = mysqli_query($conn,$sel);

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Usuario editado');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }
    public function eliminarusuario($campos) {
      //var_dump($campos); exit();
		
      $id = $campos['id'];
    $usuario=$_SESSION['usuario'];
     
  $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['user'];
        $sel="
          UPDATE `usuario` SET
          `estatus`='0'
           WHERE id='".$id."' ";

    
        $rs = mysqli_query($conn,$sel);
$this->setMensajes('Danger','Usuario eliminado');
        
    }  
    /*envia los datos del usuario a editar*/
 public function detalleddeusuarios($id) {
      $sel ="SELECT * FROM `usuario` WHERE `id` = ".$id."";
     

      $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $res_array = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)) {
          foreach($row as $key=>$value) {
            $res_array[$i][$key]=$value;
          }
          $i++;
        }

        return $res_array;

    }/*envia los mensajes*/
      public function getMensajes() {
      $msn = array(
        'tipo'=>$_SESSION["msn-tipo"],
        'msn'=>$_SESSION["msn-mensaje"]
      );
      ?>
      <div class="alert alert-dismissible alert-<?php echo $msn['tipo']; ?>">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Mensaje! </strong> <?php echo $msn['msn']; ?>
      </div>
      <?php
      unset($_SESSION['msn-tipo']);
      unset($_SESSION['msn-mensaje']);
    }
    /*hace el registro del historico de acciones crear usuario editar usuario*/
    function add_log($fecha,$user,$accion) {
      $conn = $this->getConMYSQL() ;
      	$query = "
      		INSERT INTO log_data_pow (id,fecha,user,accion)";
    	$query .= "  VALUES (NULL,NOW(),'$user','$accion')";
    	$res=mysqli_query($conn,$query) or die(mysqli_error($conn));
	
    }
function getInformation($SO,$login,$ip)
{ 
 // var_dump($SO,$login,$ip); exit();
   $conn = $this->getConMYSQL() ;
  
  $apk= "INSERT INTO `usuariosesion`(`id`,`usuario`,`fecha`,`ip`,`plataforma`)
  VALUES (null,'".$login."',CURRENT_TIME(),'".$ip."','".$SO."')";
  $insert = mysqli_query($conn,$apk);

}
  }

 ?>
