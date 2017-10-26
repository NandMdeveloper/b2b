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


        $sel_r ="SELECT usuario.id as id_usuario ,usuario.uname,usuario.nombre,usuario.sucursal,usuario.email,usuario.tipo, usuario.supervisor,usuario_tipo.id, usuario_tipo.descripcion FROM b2bfc.usuario, b2bfc.usuario_tipo where usuario.status=1 and usuario.tipo = usuario_tipo.id order by usuario.id";
          $conn = $this->getConMYSQL() ;
          $rs_r = mysqli_query($conn,$sel_r) or die(mysqli_error($conn));
          $f=0;
        while($linea=mysqli_fetch_array($rs_r)) {
          foreach($linea as $key=>$value) {
            $lista_usuarios[$f][$key]=$value;
            }
            $f++;
        }  
        //var_dump($lista_usuarios);exit();     
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
      $pass= password_hash($clave, PASSWORD_DEFAULT);
//var_dump($campos);exit();
      $conn = $this->getConMYSQL() ;
      /*validacion para evitar el registro de un usuario exitente*/
      $sQuery="SELECT `uname` FROM `usuario` where uname='$registrousuario' ";
      $result = mysqli_query($conn,$sQuery);
 
    if(mysqli_num_rows($result)>0){  
                   /*echo "este usuario ya existe "; exit();*/
              header("Location: usuarioshome.php");
              $usuarios->setMensajes('warning','Este usuario ya existe');
    }
    else
    {
 
      if (!empty($registrousuario) and !empty($clave) ) {     
             $sel = "INSERT INTO `usuario` set
             id= null,
           `uname`='".$registrousuario."',
          `passwd`='".$pass."',
          `status`='".$estatus."',
          `tipo`='".$tipo."',
          `team`='".$equipo."',
          `supervisor`='".$supervisor."',
          `nombre`='".$nombre." ".$apellido."',
          `nombres`='".$nombre."',
          `apellido`='".$apellido."',
          `sucursal`='".$sucursal."',
          `email`='".$email."'"; 
 //var_dump($sel);exit();
              $rs = mysqli_query($conn,$sel) or die(mysql_error());
             /*condicion solo insertar los usuarios tipo vendedor en el apk*/
              if ($tipo==1) {
               /*inserta el usuario en la tabla del apk*/
                 
                 $apk= "INSERT INTO `tmuser`set
             `UserId`= null,
           `UserCode`='".$registrousuario."',
          `UserPassword`='".$clave."',
          `UserName`='".$registrousuario."',
          `UserName2`=NULL,
          `UserLastName`=null,
          `UserLastName2`='0',
          `UserIdenCard`='0',
          `UserEmail`='0',
          `UserStatus`='".$estatus."',
          `UserBranchOfficeId`= '0',
          `UserLogErr`='0',
          `UserType`= '0',
          `UserNameOther`='0'";
                                     $insert = mysqli_query($conn,$apk)or die(mysql_error());
                  //var_dump($apk);exit();
                 if (mysqli_errno($conn)) {
                     $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
                     $this->setMensajes('danger',$mensa);
          }//if error de coneccion
          else{
             $msn = array(
            "error"=>"no");
             $this->setMensajes('success','Usuario Ingresado');
              $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Agrego","Creo el <strong>#usuario</strong> ".$registrousuario);  exit();  
                   }
      }//if tipo vendedor
      else {
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }
        else{
          $msn = array(
            "error"=>"no"

          );$this->setMensajes('success','Usuario Ingresado');
          $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Agrego","Creo el <strong>#usuario</strong> ".$registrousuario);
        
       }//error  conexion 
      }//else tipo vendedor
     }//if empety
    }//else validacion existe usuario
  }//funcion 
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
      $pass= password_hash($clave, PASSWORD_DEFAULT);
  if ( !empty($tipo))
  {
    if ( !empty($clave))
    {  
      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['user'];
        $sel="
          UPDATE `usuario` SET
         /*`uname`='/*.$registrousuario*/
          `passwd`='".$pass."',
          `status`='".$estatus."',
          `tipo`='".$tipo."',
          `team`='".$equipo."',
          `supervisor`='".$supervisor."',
          `nombre`='".$nombre." ".$apellido."',
          `nombres`='".$nombre."',
          `apellido`='".$apellido."',
          `sucursal`='".$sucursal."',
          `email`='".$email."' 
  
           WHERE id='".$id."' ";

    
        $rs = mysqli_query($conn,$sel);
      if ($tipo==1) {
           $apk="
          UPDATE `tmuser` SET
          
          `UserPassword`='".$clave."',
          `UserStatus`='".$estatus."',
          `UserName`=,
                     WHERE Userid='".$id."' ";
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }//if error conexion
        else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Usuario editado');
          $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Edito","Edito el <strong>#usuario</strong> con el id ".$id);
                  }//else error conexion
      }//if tipo vendedor
      else {
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }//if error conexion
        else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Usuario editado');
          $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Edito","Edito el <strong>#usuario</strong> con el id".$id);
        }//else error conexion
      }//else tipo vendedor
       }//if clave
      else {
          $conn = $this->getConMYSQL() ;
           $usuario=$_SESSION['user'];
            $sel="
          UPDATE `usuario` SET
         /*`uname`='/*.$registrousuario*/
                   `status`='".$estatus."',
          `tipo`='".$tipo."',
          `team`='".$equipo."',
          `supervisor`='".$supervisor."',
             `nombre`='".$nombre." ".$apellido."',
          `nombres`='".$nombre."',
          `apellido`='".$apellido."',
          `sucursal`='".$sucursal."',
          `email`='".$email."' 
  
           WHERE id='".$id."' ";


    
        $rs = mysqli_query($conn,$sel);
        if ($tipo==1) {
           $apk="
          UPDATE `tmuser` SET
                    `UserStatus`='".$estatus."',
          `UserName`='".$nombre."',
           WHERE Userid='".$id."' ";
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }//if error conexion
        else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Usuario editado');
         $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Edito","Edito el <strong>#usuario</strong> con el id".$id);
        }//else error conexion
      }//if tipo vendedor
      else {
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }//if error conexion
        else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Usuario editado');
          $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Edito","Edito el <strong>#usuario</strong> con el id".$id);
        }//else error conexion
      }//else tipo vendedor
       }//else clave
  }//if datos vacios 
  else {

        $this->setMensajes('warning','Debe llenar datos');
      }//else daots vacios
      return $msn;
}//funcion
public function eliminarusuario($campos) {
      //var_dump($campos); exit();
   $usuario = $_SESSION['user'];
      if ($usuario=="javier" OR $usuario=="njose" or $usuario=="jvera" ) { 
      $id = $campos['id'];
      $tipo = $campos['tipo'];
             $registrousuario= $campos['usuario'];
  $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['user'];
        $sel="
          UPDATE `usuario` SET
          `status`='0'
           WHERE id='".$id."' ";

    
        $rs = mysqli_query($conn,$sel);
       
         if ($tipo==1) {
        /*inserta el usuario en la tabla del apk*/
         
         $apk= "UPDATE  `tmuser` SET 
         `UserStatus`='0' 
         WHERE `UserCode`='".$registrousuario."' ";
         $rs = mysqli_query($conn,$apk);
         $this->setMensajes('danger','Usuario eliminado');
         $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Elimino","Elimino el <strong>#usuario</strong> ".$registrousuario);

    }else{
     $this->setMensajes('danger','Usuario eliminado');
     $this->add_log(date("Y-m-d h:i:sa"),$usuario,"Elimino","Elimino el <strong>#usuario</strong> ".$registrousuario);

    }  
       }else{
$mensa = "No tiene permisos para realizar esta accion"; 
          $this->setMensajes('danger',$mensa);
        }
    }  
    /*envia los datos del usuario a editar*/
 public function detalledeusuarios($id) {
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
    function add_log($fecha,$usuario,$tipo,$accion) {
      $conn = $this->getConMYSQL() ;
        $query = "
          INSERT INTO log_data_pow (id,fecha,user,tipo,accion) 
          VALUES (NULL,NOW(),'$usuario','$tipo','$accion')";
          //var_dump($query);exit();
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
   public function getauditoriaUsuarios() {
        
        $conn = $this->getConMYSQL(); 
        $sel ="SELECT * FROM `log_data_pow` WHERE `accion` LIKE '%#usuario%' 
        and month(fecha) = month(CURRENT_DATE)
        ORDER BY `id` DESC ";
  
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $facturas = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)) {
       
          foreach($row as $key=>$value) {
            $facturas[$i][$key]=$value;
          }
          $i++;
        }
        return $facturas;
   }
    public function fechaNormalizada($fecha){
      $fechaTiempo = array(
        "fecha"=>"No Aplica",
        "hora"=>""
      );
      if($fecha!='0'){
        $partes = explode(" ",$fecha);
        $meses = array("",
        "Ene","Feb","Mar","Abr",
        "May","Jun","Jul","Ago",
        "Sep","Oct","Nov","Dic");

        $fechas = explode("-",$partes[0]);
        $mes = intval($fechas[1]);
        $nuevaFecha = $fechas[2]." ".$meses[$mes]." ".$fechas[0];
      }
      return $nuevaFecha;
    }

  }

 ?>
