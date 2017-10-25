<?php
  class comision {
    public $co_ven = null;
    public  $servidor = 1; // 1 conecta servidor 134 0 servidor local 

    public function  getConMYSQL(){
      $conn = conectarServ($this->servidor) ;    
      return $conn;
    }
    public function setMensajes($tipo,$mensaje){
      $_SESSION["msn-tipo"]=$tipo;
      $_SESSION["msn-mensaje"]=$mensaje;
    }
    public function copiarParametros($desde,$hasta,$Adesde,$Ahasta){
      $conn = $this->getConMYSQL() ;    
     $msn = array(
       'error'=>'si'
     );

      $bsql="SELECT * FROM `parametros` where desde >= '".$desde."' and hasta <= '".$hasta."' ";
      $rs = mysqli_query($conn,$bsql) or die(mysqli_error($conn));
      $cant = mysqli_num_rows($rs);
      if ($cant==0) {
      $bsql="SELECT * FROM `parametros` where desde >= '".$Adesde."' and hasta <= '".$Ahasta."' ";
      $rs = mysqli_query($conn,$bsql) or die(mysqli_error($conn));


        if (mysqli_errno($conn)) {

          $mensa = "Ocurrio un error en lectura de parametros".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);

        }else{

             $datos = array();
             $i=0;
             while($row=mysqli_fetch_array($rs)){
               foreach($row as $key=>$value){
                 $datos[$i][$key]=$value;
               }
               $i++;
             }

             $msn = array(
                  'error'=>'no'
                );

             $usuario=$_SESSION['usuario'];
             for ($x=0; $x < count($datos); $x++) { 

                  $in ="INSERT INTO `parametros`
                  (`id`, `nombre`, `cuenta`,
                  `tipo`, `limite1`, `limite2`,
                  `limite3`, `porcentaje`, `usuario`,
                  `usuarioModificacion`, `modificacion`, `creacion`, `desde`, `hasta`) VALUES 
                  (null,'".$datos[$x]['nombre']."','".$datos[$x]['cuenta']."',
                  '".$datos[$x]['tipo']."','".$datos[$x]['limite1']."','".$datos[$x]['limite2']."',
                  '".$datos[$x]['limite3']."','".$datos[$x]['porcentaje']."','".$usuario."',
                  '".$usuario."',CURRENT_TIME(),CURRENT_TIME(),'".$desde."','".$hasta."')";
                  $rs = mysqli_query($conn,$in) or die(mysqli_error($conn));

                   if (mysqli_errno($conn)) {
                   $mensa = "Ocurrio un error en escritura de parametros copiado ".mysqli_errno($conn).": ". mysqli_error($conn);
                   $this->setMensajes('danger',$mensa);
                  $msn = array(
                     'error'=>'si',
                     'mensaje'=>$mensa
                   );
                 }
             }
        }
      } else {

         $mensa = "Ya existe parametros para este rango de fechas";
          $this->setMensajes('warning',$mensa);
         $msn = array(
            'error'=>'si',
            'mensaje'=>$mensa
          );
         }
        return $msn;
    }
    public function getComision($id){
     

      $conn = $this->getConMYSQL() ;
        $sel="
        SELECT
        c.id as idcomision,
        c.nombre as ncomision,
        c.cmsTipo_id as idtipo,
        c.inicio,
        c.final,
        c.permanente,
        c.cmsCombo_id as idcombo,
        c.estatus,
        c.porcentaje,
        t.nombre,
        cb.descripcion as nombreCombo
         FROM `cmsbase` as c
         INNER JOIN cmstipo as  t ON t.id = c.cmsTipo_id
         INNER JOIN cmscombo as cb ON c.cmsCombo_id=cb.id
         WHERE c.`id`='".$id."'";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        $msn = array(
          'error'=>'si'
        );

        if (mysqli_errno($conn)) {

          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);

        }else{

          $datos = array();
          $i=0;
          while($row=mysqli_fetch_array($rs)){
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }

          $msn = array(
            'error'=>'no',
            'datos'=> $datos
          );

        }

        return $msn;

    }
    public function getGerentesVenta($id){
     

      $conn = $this->getConMYSQL() ;
        $sel="
        SELECT * FROM `cmsgerenteventa` ";

        if ($id) {
        $sel.=" WHERE `id` = '".$id."'";
        }
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        $msn = array(
          'error'=>'si'
        );

        if (mysqli_errno($conn)) {

          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);

        }else{

          $datos = array();
          $i=0;
          while($row=mysqli_fetch_array($rs)){
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }

          $msn = array(
            'error'=>'no',
            'datos'=> $datos
          );

        }

        return $msn;

    }
    public function getGerentesVenta_Actividad($co_ven,$desde,$hasta){
     

      $conn = $this->getConMYSQL() ;
        $sel="
       SELECT * FROM `cmsvendedoresactividad`
        WHERE tipo ='Gerente ventas' and desde >= '".$desde."' and hasta <= '".$hasta."' ";

        if ($co_ven) {
        $sel.=" and `co_ven` = '".$co_ven."'";
        }
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        $msn = array(
          'error'=>'si'
        );

        if (mysqli_errno($conn)) {

          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);

                $msn = array(
          'error'=>'si',
          'msn'=>$msn
        );

        }else{

          $datos = array();
          $i=0;
          while($row=mysqli_fetch_array($rs)){
           
            $desVendedor = $this->getvendedores($row['co_ven']);
            if (count($desVendedor)==0) {
               $nombre = "VACANTE";
            }else{
               $nombre = $desVendedor[0]['ven_des'];
            }
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
              $datos[$i]['ven_des']=$nombre;
            }
            $i++;
          }

          $msn = array(
            'error'=>'no',
            'datos'=> $datos
          );

        }

        return $msn;

    }
    public function getcalculosgerentes_Ventas($co_ven,$desde,$hasta){
        $sel="SELECT sum(monto) as base , sum(comision) as comision 
            FROM `cmshistorialuno` 
            where documento='FACT'
            and   month(periodo) = month('".$desde."')"

            ;
           if ($co_ven) {
               $sel.=" and co_vende='".$co_ven."'";
           }
             $datos = array();
          

          $i=0;
        $conn = $this->getConMYSQL() ;
          $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
          while($row=mysqli_fetch_array($rs)){     
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }

          return $datos;
    }
    public function getGerentesRegional2($id,$desde,$hasta){
     
      $conn = $this->getConMYSQL() ;

        $sel="select * from cmsvendedoresactividad as va 
          where va.tipo='Gerente' and va.desde>='".$desde."'
           and  va.hasta <='".$hasta."'  and co_ven!='VACANTE'";

        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        $msn = array(
          'error'=>'si'
        );

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $datos = array();
          $i=0;
          while($row=mysqli_fetch_array($rs)){

        
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }

          $msn = array(
            'error'=>'no',
            'datos'=> $datos
          );

        }

        return $msn;

    }
    public function getGerentesRegional($id){
     
      $conn = $this->getConMYSQL() ;
        $sel="
        SELECT GR.id as id,
          R.nombre as region,
          GR.estado,
          GR.co_ven,
          GR.gerenteventa_id,
          GR.cmsRegion_id,
          GR.co_ven
           FROM `cmsgerenteregional` as GR
        inner join cmsRegion as R on R.id=GR.cmsRegion_id ";

        if($id!=null){
        $sel.=" WHERE GR.id = '".$id."'";
        }
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        $msn = array(
          'error'=>'si'
        );

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $datos = array();
          $i=0;
          while($row=mysqli_fetch_array($rs)){

            $desVendedor = $this->getvendedores($row['co_ven']);
            if (count($desVendedor)==0) {
               $nombre = "VACANTE";
            }else{
               $nombre = $desVendedor[0]['ven_des'];

            }
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
              $datos[$i]['ven_des']= $nombre;
            }
            $i++;
          }

          $msn = array(
            'error'=>'no',
            'datos'=> $datos
          );

        }

        return $msn;

    }
    public function getMensajes(){
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
    
    public function editarrenteregional($campos){
        $msn = array(
          "error"=>"si"
        );
        /* Buscar si ya hay un gerente asignado */
     

      $conn = $this->getConMYSQL() ;
        $bs ="select * from cmsgerenteregional where cmsRegion_id='".$campos['region']."' ";
        $rs = mysqli_query($conn,$bs) or die(mysqli_error($conn));
         $cant = mysqli_num_rows($rs);
        $cant = 0;
        if ($cant==0) {
            if (!empty($campos['co_ven'])) {
              $co_ven = trim($campos['co_ven']);
              $apellido = trim(ucwords(strtolower(utf8_decode($campos['apellido']))));
               $sel ="
                UPDATE `cmsgerenteregional` SET
                `gerenteventa_id`='".$campos['gerente']."',
                `cmsRegion_id`='".$campos['region']."',
                `co_ven`='".$co_ven."',
                `estado`='".$campos['estado']."'
                 WHERE `id`='".$campos['idg']."'  ";
            
                 $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

                 if (mysqli_errno($conn)) {
                   $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
                   $this->setMensajes('danger',$mensa);
                 }else{
                   $msn = array(
                     "error"=>"no"
                   );
                   $this->setMensajes('success','Gerente modificado');
                 }
          }else{

              $this->setMensajes('warning','Debe llenar datos');
          }
        }else{
             $this->setMensajes('warning','Esta región ya tiene un gerente asignado');
          }
        return $msn;
    }    
    public function editarGerenteVentas($campos){
        $msn = array(
          "error"=>"si"
        );
        /* Buscar si ya hay un gerente asignado */
     

      $conn = $this->getConMYSQL() ; 
       
            if (!empty($campos['nombre'])) {
              $apellido = trim(ucwords(strtolower(utf8_decode($campos['apellido']))));
               $sel ="UPDATE `cmsgerenteventa`
                SET 
                `nombre` = '".$campos['nombre']."',
                `apellido` = '".$campos['apellido']."',
                 `estado` = '".$campos['estatus']."' 
                 WHERE `cmsgerenteventa`.`id` = ".$campos['id'].";";
            
                 $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

                 if (mysqli_errno($conn)) {
                   $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
                   $this->setMensajes('danger',$mensa);
                 }else{
                   $msn = array(
                     "error"=>"no"
                   );
                   $this->setMensajes('success','Gerente modificado');
                 }
          }else{

              $this->setMensajes('warning','Debe llenar datos');
          }
    
        return $msn;
    }
    public function editarRegion($campos){
      $msn = array(
        "error"=>"si"
      );
      if (!empty($campos['nombre'])) {
        $estado = 0;
        if(isset($campos['estatus'])){
  				$estado= $_POST['estatus'];
  					if($estado="on"){
  						$estado = 1;
  					}
  			}

     

      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="
        UPDATE `cmsregion` SET
        `nombre`='".$campos['nombre']."',
        `estatus`=$estado,
        `modificacion`=CURRENT_TIME(),
        `modificadopor`='".$usuario."'
         WHERE `id`='".$campos['idr']."' ";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Región Editada');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }
    public function nuevaRegion($campos){
      $msn = array(
        "error"=>"si"
      );
      if (!empty($campos['nombre']) and !empty($campos['estatus'])) {
        $estado = 0;
        if(isset($campos['estatus'])){
  				$estado= $_POST['estatus'];
  					if($estado="on"){
  						$estado = 1;
  					}
  			}
     

      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="

        INSERT INTO `cmsregion`(`id`, `nombre`, `estatus`, `registro`, `modificacion`, `hechopor`, `modificadopor`)
         VALUES (NULL,'".$campos['nombre']."','".$estado."',CURRENT_TIME(),CURRENT_TIME(),'".$usuario."','".$usuario."')";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Región ingresada');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }
    public function nuevaComision($cmsTipo_id,$nombre,$inicio,$final,$cmsCombo_id,$permanente,$estatus,$porcentaje){

      $msn = array(
        "error"=>"si"
      );

      if (!empty($nombre) and !empty($cmsTipo_id)) {
        $combo = 1;
        if ($cmsCombo_id>1) {
          $combo = $cmsCombo_id;
        }

     

      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="
        INSERT INTO `cmsbase`(`id`, `cmsTipo_id`, `nombre`, `inicio`, `final`, `cmsCombo_id`, `permanente`,`estatus`,`creacion`,`porcentaje`,`creador`)
                            VALUES (null,$cmsTipo_id,'$nombre','$inicio','$final',$combo,$permanente,'$estatus', CURRENT_TIME(),$porcentaje,'".$usuario."')";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Comisión ingresada');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }
    public function nuevagerenteVentas($datos){

      $msn = array(
        "error"=>"si"
      );

      $nombre = trim(ucwords(strtolower($datos['nombre'])));
      $apellido = trim(ucwords(strtolower($datos['apellido'])));

      if (!empty($nombre) and !empty($apellido)) {

     

      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="
      INSERT INTO `cmsgerenteventa`(`id`, `nombre`, `apellido`, `estado`, `registro`)
      VALUES (null,'".$nombre."','".$apellido."','".$datos['estatus']."',CURRENT_DATE())";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','gerente ingresado');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }

    public function nuevagerenteregional($datos){

      $msn = array(
        "error"=>"si"
      );

      $co_ven = trim(($datos['co_ven']));
      $gerente = trim($datos['gerente']);
      $region = trim($datos['region']);

      if (!empty($co_ven) and !empty($region)) {
     

      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="
          INSERT INTO `cmsgerenteregional`(`id`, `gerenteventa_id`, `cmsRegion_id`, `co_ven`, `estado`, `registro`)
          VALUES (null,'".$gerente."','".$region."','".$co_ven."','".$datos['estatus']."',CURRENT_DATE())

        ";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','gerente ingresado');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }    
    public function nuevametaClave($datos){
 
      $msn = array(
        "error"=>"si"
      );
      $co_ven = trim($datos['co_ven']);  
      $vacante = 0;
      if ($datos['co_ven'] == "VACANTE") {
        $vacante = 1;
        $co_ven = "VACANTE";  
      }
      
      $presupuesto =  $this->formato($datos['presupuesto']);
       $conn = $this->getConMYSQL() ;

      $bus = "
      SELECT * FROM `cmspresupuestoclave` 
      WHERE `co_ven` = '".$co_ven."' 
      AND `desde` >= '".$datos['desde']."'
       AND `hasta` <= '".$datos['hasta']."' and `vacante` = 0";
      
      // buscamos si es vacante
      if ($vacante == 1) {
        $bus = "
      SELECT * FROM `cmspresupuestoclave` 
      WHERE `vacante` = 1 AND `desde` >= '".$datos['desde']."'
       AND `hasta` <= '".$datos['hasta']."'";
      }

      $rs = mysqli_query($conn,$bus) or die(mysqli_error($conn));
      $cant = mysqli_num_rows($rs);
      //echo $bus; exit();

      if($cant==0){
          if (!empty($co_ven) and !empty($presupuesto)) {
            $usuario=$_SESSION['usuario'];
             
         
            $usuario=$_SESSION['usuario'];
            $sel="
            INSERT INTO `cmspresupuestoclave`(
            `id`, `co_ven`, 
            `presupuesto`, `desde`, `hasta`,
            `creadopor`, `vacante`, `fecha_emis`,
            `fecha_mod`, `modificado`) VALUES (
            null,'". $co_ven."',
            ".$presupuesto.",'".$datos['desde']."','".$datos['hasta']."',
            '".$usuario."',".$vacante.",CURRENT_TIME,
            CURRENT_TIME,'".$usuario."')";
            $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

            if (mysqli_errno($conn)) {
              $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
              $this->setMensajes('danger',$mensa);
            }else{
              $msn = array(
                "error"=>"no"
              );
              $this->setMensajes('success','Meta ingresada');
            }
          } else {

            $this->setMensajes('warning','Debe llenar datos');
          }
    }else{
      $this->setMensajes('warning','Ya fue asignado un presupuesto para esta cuenta y fecha');
      }
      return $msn;
    
    }
    public function getRegiones($region){
     

      $conn = $this->getConMYSQL() ;
        $sel="
        SELECT * FROM `cmsregion` where estatus = 1  ";

        if($region){
            $sel.= " and id='".$region."'";

        }
        $sel.= "  ORDER BY `cmsregion`.`nombre` ASC";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $datos = array();
        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $datos[$i][$key]=$value;
          }
          $i++;
        }
        return $datos;

    }
    public function getZonasgerente($gerente){
          $conn = $this->getConMYSQL() ;
        $sel="
        SELECT * FROM `cmszonagerencia` WHERE 	cmsRegion_id ='".$gerente."'";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $datos = array();
        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $datos[$i][$key]=$value;
          }
          $i++;
        }
        return $datos;

    }
    public function quitarZona($gerenteregional_id,$id){
     

      $conn = $this->getConMYSQL() ;
            $msn = array(
        "error"=>"si"
      );
        
      $sel="
        DELETE FROM `cmszonagerencia` WHERE `cmszonagerencia`.`id` = '".$id."' and cmsRegion_id='".$gerenteregional_id."'";


        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
           $msn = array(
                      "error"=>"no"
                    );
          $this->setMensajes('success','Zona desvinculada con éxito');
        }
        
        return  $msn;

    }
    public function asignarZona($campos){
      $msn = array(
        "error"=>"si"
      );

      if (!empty($campos['zona']) and !empty($campos['idregion'])) {
      
         $conn = $this->getConMYSQL() ;

         $usuario=$_SESSION['usuario'];
         //BUSCAMOS SI YA ESTA SIGNADA LA ZONA AL GERENTE
         $zona = trim($campos['zona']);
         $bsql="
         SELECT * FROM `cmszonagerencia`
         WHERE   `zona`='".$zona."' ";
         $rs = mysqli_query($conn,$bsql);
         $cant = mysqli_num_rows($rs);
         if ($cant==0) {
                  $sel="
                  INSERT INTO `cmszonagerencia`(`id`, `cmsRegion_id`, `zona`) VALUES (null,'".$campos['idregion']."','".$campos['zona']."')";
                  $rs = mysqli_query($conn,$sel);

                  if (mysqli_errno($conn)) {
                    $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
                    $this->setMensajes('danger',$mensa);
                  }else{
                    $msn = array(
                      "error"=>"no"
                    );
                    $this->setMensajes('success','Zona asignada');
                  }
                }else{
                  $this->setMensajes('warning','Ya esta zona esta asignada');
                }
        }else {
          $this->setMensajes('warning','Debe llenar datos');
        }

      return $msn;
    }
    public function nuevoparametro($campos){

      $usuario=$_SESSION['usuario'];

      $nombre = $campos['nombre'];
      $limite1 = $campos['limite1'];
      $limite2 = $campos['limite2'];

      $limite3 = $campos['limite3'];
      $porcentaje = $campos['porcentaje'];
      $cuenta = $campos['cuenta'];
      $tipo = $campos['tipo'];

      $finicio = $campos['finicio'];
      $ffinal = $campos['ffinal'];


      if (!empty($nombre) and !empty($cuenta) and !empty($tipo)) {      

      $conn = $this->getConMYSQL() ;

         $sel ="
            INSERT INTO `parametros`
            (`id`, `nombre`, `cuenta`,
            `tipo`, `limite1`, `limite2`,
            `limite3`, `porcentaje`, `usuario`,
            `usuarioModificacion`, `modificacion`, `creacion`, `desde`, `hasta`) VALUES 
            (null,'".$nombre."','".$cuenta."',
            '".$tipo."','".$limite1."','".$limite2."',
            '".$limite3."','".$porcentaje."','".$usuario."',
            '".$usuario."',CURRENT_TIME(),CURRENT_TIME(),'".$finicio."','".$ffinal."')";

         $rs = mysqli_query($conn,$sel);

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->add_log($usuario,"Agrego","Parametro: ".$nombre." Tipo".$tipo.", cuenta:".$cuenta);
          $this->setMensajes('success','Parametro  Ingresado');
        }

      }
    }
    public function editarparametro($campos){
      $id = $campos['id'];
      $nombre = utf8_decode($campos['nombre']);
      $limite1 = $campos['limite1'];

      $limite2 = $campos['limite2'];
      $limite3 = $campos['limite3'];
      $porcentaje = $campos['porcentaje'];
      $cuenta = $campos['cuenta'];
      $tipo = $campos['tipo'];
      $finicio = $campos['finicio'];
      $ffinal = $campos['ffinal'];
      $msn = array(
        "error"=>"si"
      );

      if (!empty($nombre) and !empty($cuenta) and !empty($tipo)) {
     

      $conn = $this->getConMYSQL() ;
        $usuario=$_SESSION['usuario'];
        $sel="
          UPDATE `parametros` SET
          `nombre`='".$nombre."',
          `cuenta`='".$cuenta."',
          `tipo`='".$tipo."',
          `limite1`='".$limite1."',
          `limite2`='".$limite2."',
          `limite3`='".$limite3."',
          `porcentaje`='".$porcentaje."',
          `usuarioModificacion`='".$usuario."',
          `modificacion`=CURRENT_TIME,
          `desde`='".$finicio."',
          `hasta`='".$ffinal."'
           WHERE id='".$id."' ";

        $rs = mysqli_query($conn,$sel);

        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
          $msn = array(
            "error"=>"no"
          );
          $this->setMensajes('success','Comisión editada');
        }
      } else {

        $this->setMensajes('warning','Debe llenar datos');
      }
      return $msn;
    }
    /* LOCALIZA Y CALCULO COMISION DE NCR Y NDB */
    public function getCalculoNCR_NDB($doc_num,$monto,$tipo,$desde,$hasta){
        /* 
            select distinct 'Devolucion' as tipo, dc.doc_num,dc.tipo_doc, dc.num_doc,fv.co_cli,cli.cli_des
            from saDevolucionClienteReng as dc 
            inner join saFacturaVenta as fv on dc.num_doc=fv.doc_num
            inner join saCliente  as cli on fv.co_cli=cli.co_cli
            where dc.doc_num in('000123','000124','000125','000126','000127',
            '000128','000129','000130','000131','000175','000189','000209')

       */
        $conn = conectarSQlSERVER(); 
        $calculo = array(
            'documento'=>$doc_num,
            'factura'=>0,
            'emision'=>0,
            'tipodoc'=>$tipo,
            'cobro'=>null,
            'diascalle'=>null,
            'comision'=>0,
            'comisonReserva'=>0,
            'porcentaje'=>0,
            'porcentaje_reserva'=>0
        );

        $bu = "select doc_orig from saDocumentoVenta where co_tipo_doc='".$tipo."' and nro_doc='".$doc_num."' ";
        
        $resb=sqlsrv_query($conn,$bu);
        $linea=sqlsrv_fetch_array($resb)  ;         
        $tipoNCR = trim($linea[0]);
                                                  
        if($tipoNCR == 'FACT'){

          /* BUSCA EN DOCUMENTOS DE VENTAS LAS NCR ( DEVOLUCIONES / ADMINISTRATIVAS ) */
            $sel ="
          SELECT
              'docuventa' AS TIPO_DOC, 'tipo' = 1, 
              CL.cli_des, CL.rif, CL.telefonos, CL.direc1, CL.direc2, VE.ven_des,
              DV.co_tipo_doc, DV.nro_doc, DV.co_cli, DV.co_ven, DV.co_mone, DV.tasa, DV.observa, DV.fec_emis, DV.fec_venc,
              CASE WHEN (DV.doc_orig = 'DEVO') THEN 'FACT' else DV.doc_orig end as doc_orig, 
              CASE WHEN (DV.doc_orig = 'DEVO') THEN (select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1) else DV.nro_orig end as nro_orig, 
               DV.n_control, DV.total_bruto, DV.monto_imp, DV.monto_desc_glob, DV.porc_desc_glob,
              DV.monto_reca, DV.porc_reca, ( DV.otros1 + DV.otros2 + DV.otros3 ) AS otros,
              CASE WHEN (DV.doc_orig = 'DEVO') THEN 
                  (select fec_emis from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 AND (doc_orig='FACT' OR doc_orig='NENT'))) 
              WHEN (DV.co_tipo_doc = 'N/CR') THEN
                  (select ISNULL(fec_emis, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig) 
              ELSE
                  null 
              END AS fec_emis_ori,
              CASE WHEN (DV.doc_orig = 'DEVO') THEN 
                  (select total_bruto from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 and (doc_orig='FACT' OR doc_orig='NENT'))) 
              WHEN (DV.co_tipo_doc = 'N/CR') THEN
                  (select ISNULL(total_bruto, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig) 
              ELSE 
                  null 
              END AS total_bruto_ori,
              CASE WHEN 
                  (DV.doc_orig = 'DEVO') THEN (select monto_imp from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 and (doc_orig='FACT' OR doc_orig='NENT'))) 
              WHEN (DV.co_tipo_doc = 'N/CR') THEN
                  (select ISNULL(monto_imp, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig) 
              ELSE    
                  null 
              END AS monto_imp_ori,
              CASE WHEN (DV.doc_orig = 'DEVO') THEN 
                  (select total_neto from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 and (doc_orig='FACT' OR doc_orig='NENT'))) 
              WHEN (DV.co_tipo_doc = 'N/CR') THEN
                  (select ISNULL(total_neto, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig) 
              ELSE
                  null 
              END AS total_neto_ori,
              CL.co_seg
          FROM
              saDocumentoVenta AS DV      
              INNER JOIN saCliente AS CL ON CL.co_cli = DV.co_cli            
               LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DV.co_tipo_doc             
              INNER JOIN saVendedor AS VE ON VE.co_ven = DV.co_ven
      
          WHERE
              DV.nro_doc = '".$doc_num."'          
              AND DV.co_tipo_doc = '".$tipo."'
            AND DV.anulado = 0 
              ORDER BY
          DV.nro_doc ASC";
         
          $doc = array();
          $x = 0;

          $result=sqlsrv_query($conn,$sel);
          while($row=sqlsrv_fetch_array($result)){          
              foreach($row as $key=>$value){
                $doc[$x][$key]=$value;
              }

              $x++;           
          }

        }
        if($tipoNCR=='DEVO'){

            $doc = array();

            $sel ="select distinct 'Devolucion' as tipo, dc.doc_num as nro_orig,dc.tipo_doc as doc_orig,
                    dc.num_doc,fv.co_cli,cli.cli_des,cli.co_seg,fv.co_ven,fv.total_bruto as total_bruto_ori
                     from saDevolucionClienteReng as dc 
                    inner join saFacturaVenta as fv on dc.num_doc=fv.doc_num
                    inner join saCliente  as cli on fv.co_cli=cli.co_cli
                    where dc.doc_num in('".$doc_num."')";

            $x = 0;

            $result=sqlsrv_query($conn,$sel);
            while($row=sqlsrv_fetch_array($result)){          
                foreach($row as $key=>$value){
                    $doc[$x][$key]=$value;
                }                  
                $x++;          
            }    

        }

        $parametros = array();
        $factura = array();
          

        if (isset($doc[0]['num_doc']) > 0){

            $nro_orig= trim($doc[0]['num_doc']);
            $doc_orig= trim($doc[0]['doc_orig']);

            $calculo['factura'] = $nro_orig;
      

            $co_seg= trim($doc[0]['co_seg']);
            $co_ven= trim($doc[0]['co_ven']);

            $total_bruto_ori= trim($doc[0]['total_bruto_ori']);
            $msn = "";


            $factura = $this->getFechaRecibidoFactura(intval($calculo['factura']));
         

            if(count($factura) > 0){
                $dt_factura = array();

                $sqf="select * from saFacturaVenta as fv where fv.doc_num = '".$nro_orig."'";
                $result2=sqlsrv_query($conn,$sqf);

                $i = 0;

                while($linea=sqlsrv_fetch_array($result2)){          
                    foreach($linea as $key=>$value){
                        $dt_factura[$i][$key]=$value;
                    }
                    $i++;           
                }

                $lista_parametros_desfasados = array();
                $lista_parametros_desfasados = $this->getParametros('2016-12-01','2016-12-31');
                $parametros_desfasados = $lista_parametros_desfasados[12]['datos'];

                $condiciones = $this->condicionTipoDefactura($nro_orig);          
                $cneg = $condiciones['dias_cred'];

                $fec_recibido = date_create($factura[0]['fecha_recibido']);
                date_add($fec_recibido, date_interval_create_from_date_string($cneg.' days'));
                $fecha_vencimiento =  date_format($fec_recibido, 'Y-m-d');
                  
                $lista_parametros = array();
                $lista_parametros = $this->getParametros($desde,$hasta);
                $saldor = $this->getSaldoReal($nro_orig,$dt_factura[0]['total_neto'],$desde,$hasta,$dt_factura[0]['co_cli']);

                $mes_doc =  date("m", strtotime($dt_factura[0]['fec_emis']->format('Y-m-d')));
                $mes_doc = (int)$mes_doc;
                $cann = 0;

                if(isset($lista_parametros[$mes_doc]['cortes'])) {
                    $cann = $lista_parametros[$mes_doc]['cortes'];
                }
                 
                if($cann > 0){

                    if ($cann == 1) {

                        $parametros = $lista_parametros[$mes_doc]['datos'];
                        $facturas[$i]['corte'] = "unico";
                        $entra = 1;

                    }else{
                              
                        for ($l=0; $l <   $cann  ; $l++) {    
                            /* comparamos fecha */
                            $fecha_desde = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['desde']);
                            $fecha_hasta = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['hasta']);
                            $fecha_emision = new DateTime($dt_factura[0]['fec_emis']->format('Y-m-d'));

                            if($fecha_emision >= $fecha_desde and $fecha_emision <= $fecha_hasta){
                               $parametros = $lista_parametros[$mes_doc]['datos'][$l];
                               $entra = 1;
                               $facturas[$i]['corte'] = $l;
                            }
                        }                             
                    }

                    if(isset($parametros['datos'][0]['desde'])){
                        unset($parametros['datos'][0]['desde'],$parametros['datos'][0]['hasta']);
                    }
                      
                    if(count($parametros) == 0){
                        $parametros = $parametros_desfasados;
                    }
                      
                      $saldoCero = $parametros[0];

                          $nfcobro = $this
                          ->fechaCobrofactura(trim($dt_factura[0]['co_cli']), $nro_orig,$desde,$hasta);
                          $fcobro = "";
                        if (!empty($nfcobro)) {
                           $fcobro = date_format(date_create($nfcobro),'d/m/Y');
                        }  

                          /*SE CALCULAN LOS DIAS CALLE */
                          $diascalle = "?";
                        if (!empty($fcobro)) {
                              //$fecha1 = new DateTime($facturaRecibido['fecha_recibido']);
                              $fecha1 = new DateTime($fecha_vencimiento);
                              $fecha2 = new DateTime($nfcobro);
                              $fecha = $fecha1->diff($fecha2);
                              $diascalle =  $fecha->format('%a') + $cneg;   

                              $datos = array(
                                'co_seg'=> $co_seg,
                                'co_ven'=> $co_ven,
                                'condicion'=>$condiciones['cond'],
                                'saldo_factura'=>0,
                                'diascalle'=> $diascalle,
                                'total_bruto'=>$dt_factura[0]['total_bruto'],
                                'fVencimiento'=>$fecha_vencimiento,
                                'fcobro'=>$fcobro,
                                'cneg'=> $cneg
                              );
                              
                              $nComision = $this->calculoBasico2($datos,$parametros); 

                              $comisionDoc = $this->porcentaje($monto,$nComision['porcentaje']);
                              $comisionDocreserva = $this->porcentaje($monto,$nComision['porcentajeR']);
                              
                              $calculo['factura'] = $nro_orig;
                              $calculo['tipodoc'] = $doc_num;
                              $calculo['cobro'] = $fcobro;

                              $calculo['diascalle'] = $diascalle;
                              $calculo['comision'] = $comisionDoc;
                              $calculo['comisonReserva'] = $comisionDocreserva;

                              $calculo['porcentaje'] = $nComision['porcentaje'];
                              $calculo['porcentaje_reserva'] = $nComision['porcentajeR'];                          

                        }else{
                            $msn = "Sin fecha de cobro para este periodo";
                        }
                    }else{
                          $msn = "Sin parametros de calculos en el sistema para ese periodo";
                    }
                }else{
                      $msn = "Sin fecha de recepion";
                }
        }
       
       return $calculo;
    }
    public function getParametrosEdicion($desde,$hasta){
        
        $lista_parametros = array();


        $sel_r ="SELECT * FROM `parametros` 
         where desde >= '".$desde."'  and  hasta   <=  '".$hasta."' ";    

        $conn = $this->getConMYSQL() ;
        $rs_r = mysqli_query($conn,$sel_r) or die(mysqli_error($conn));
       $f=0;
        while($linea=mysqli_fetch_array($rs_r)){
            foreach($linea as $key=>$value){
              $lista_parametros[$f][$key]=$value;
            }
            $f++;
        }       
      return $lista_parametros;
    }
    public function getFechaRecibidoFactura($factura){
        
        $Dfactura = array();
        $sel_r ="SELECT fecha_recibido,fecha_despacho 
        FROM `pedidos_des` WHERE `factura` = '".$factura."' ";    

        $conn = $this->getConMYSQL() ;
        $rs_r = mysqli_query($conn,$sel_r) or die(mysqli_error($conn));
       $f=0;
        while($linea=mysqli_fetch_array($rs_r)){
            foreach($linea as $key=>$value){
              $Dfactura[$f][$key]=$value;
            }
            $f++;
        }       
      return $Dfactura;
    }

    public function getParametrosCortes($desde,$hasta){
		


		$cortes = array();
		/* BUSCAMOS CORTES EN LOS PARAMETROS PARA UN RANGO DE FECHA */
		$bsql ="SELECT desde,hasta FROM `parametros` 
		where month(desde) =   month('".$desde."')  and YEAR(desde) =  YEAR('".$desde."')
		group by desde";
		

		 $conn = $this->getConMYSQL() ;
		$rsb = mysqli_query($conn,$bsql) or die(mysqli_error($conn));
		$f=0;
		while($linea=mysqli_fetch_array($rsb)){
			foreach($linea as $key=>$value){
			  $cortes[$f][$key]=$value;
			}
			$f++;
		}
			$c= 1;
			 foreach ($cortes as $corte) {
			 ?>
			  <div class="col-xs-3">
			 <div class="alert alert-dismissible alert-info ">
				<h4>Corte: <?php echo $c; ?> 
				<span class='pull-right'> 
					<a href='comisonparametros.php?desde=<?php echo $corte['desde']; ?>&hasta=<?php echo $corte['hasta']; ?>'>
					<i class="fa fa-eye" aria-hidden="true"></i>
					</a>
				</span></h4>
				 <?php   echo $this->fechaNormalizada($corte['desde'])." al ".$this->fechaNormalizada($corte['hasta']); ?>
			</div>
			</div>
			 <?php
			$c++;
		 }

	}
    public function getParametros($desde,$hasta){
        $mes =date("m", strtotime($desde)); 
        $mes = (int)$mes;

        $anio = date("Y", strtotime($desde)); 
        $anio = (int)$anio;

        $lista_parametros = array();

        for($x=0; $x < 12 ; $x++){ 

            $datos = array();
            /* BUSCAMOS CORTES EN LOS PARAMETROS PARA UN RANGO DE FECHA */
            $bsql ="SELECT * FROM `parametros` 
            where month(desde)=  ".$mes."   and YEAR(desde)= ".$anio." 

            group by desde";

            $conn = $this->getConMYSQL() ;
            $rsb = mysqli_query($conn,$bsql) or die(mysqli_error($conn));
            $can = mysqli_num_rows($rsb);

            $lista_parametros[$mes]['cortes'] = 0;  
            
            $cortes = array();

            if ($can > 1) {

                 $lista_parametros[$mes]['cortes'] = $can;                 

                 /* BUSCAMOS CADA CORTE Y LO INTEGRAMOS EN UN ARRAY PARA AJUNTAR PARAMETROS*/
                    $i=0;
                    while($row=mysqli_fetch_array($rsb)){
						
                        $r_desde = $row[12];
                        $r_hasta = $row[13];
				
						
                        $sel_r ="SELECT * FROM `parametros` 
                        where  desde  >='".$r_desde."' and  hasta  <= '".$r_hasta."'";    
                            
                        $rs_r = mysqli_query($conn,$sel_r) or die(mysqli_error($conn));                           
                            
                        $f=0;
                        while($linea=mysqli_fetch_array($rs_r)){
                            foreach($linea as $key=>$value){
                              $datos[$f][$key]=$value;
                            }
                            $f++;
                        }

                        $datos['desde'] = $r_desde;
                        $datos['hasta'] = $r_hasta;

                        $cortes[] = $datos;

                        $datos = array();
                    }
                    $lista_parametros[$mes]['datos'] =  $cortes;          

            }else{


                $lista_parametros[$mes]['cortes'] = 1;
                $sel ="SELECT * FROM `parametros` 
                where MONTH(desde) >='".$mes."' and MONTH(hasta) <= '".$mes."' 
                and YEAR(desde)=".$anio."";    
                
                $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
                
                $cant = mysqli_num_rows($rs);


                if($cant > 0) {
                    $i=0;
                    while($row=mysqli_fetch_array($rs)){
                        foreach($row as $key=>$value){
                          $datos[$i][$key]=$value;
                        }
                        $i++;
                    }
                } 

                $lista_parametros[$mes]['datos'] = $datos;          
            }

           
            $mes--;
            if($mes==0){
                $mes = 12;
                $anio--;
            }
        }

      return $lista_parametros;
    }
    public function editarComision($campos,$idcomision){
      $conn = $this->getConMYSQL() ;
      $permanente = 0;
      if(isset($campos['permanente'])){
				$permanente= $_POST['permanente'];
					if($permanente="on"){
						$permanente = 1;
					}
			}
      $sel="
      UPDATE `cmsbase` SET
       `cmsTipo_id`='".$campos['tipo']."',
       `nombre`='".$campos['nombre']."',
       `inicio`='".$campos['finicio']."',
       `final`='".$campos['fsalir']."',
       `cmsCombo_id`='".$campos['combo']."',
       `permanente`=".$permanente.",
       `estatus`='".$campos['estatus']."',
       `porcentaje`='".$campos['porcentaje']."'
        WHERE `id`='".$idcomision."'";

        $rs = mysqli_query($conn,$sel);
        $msn = array(
          'error'=>'si'
        );
        if (mysqli_errno($conn)) {
          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
          $this->setMensajes('danger',$mensa);
        }else{
            $this->setMensajes('success',"Comisión editada con éxito.");
          $msn = array(
            'error'=>'no'
          );
        }
        return $msn;
    }
    public function nuevoCombo($descripcion,$estado,$codigos,$creador){
     

      $conn = $this->getConMYSQL() ;

      mysqli_autocommit($conn,FALSE);
        $sel="
          INSERT INTO `cmscombo`(`id`, `descripcion`, `fecha`, `creador`, `estatus`)
            VALUES (null,'".$descripcion."',CURRENT_TIME(),'".$creador."','".$estado."')
        ";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        //Buscamos el id del combo recien creado

        $sel="
        SELECT id FROM `cmscombo` ORDER BY `cmscombo`.`id` DESC limit 1";
        $rs2 = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $combo = mysqli_fetch_array($rs2);

        //re ordenar vector de codigo
        //var_dump($codigos); exit();

        for($x=1;$x < count($codigos);$x++){
          $cd = $codigos[$x];
          $ins = "
          INSERT INTO `cmscombo_articulo`(`id`, `cmsCombo_id`, `co_art`) VALUES (null,".$combo[0].",'".$cd."')";
            $rs3 = mysqli_query($conn,$ins) or die(mysqli_error($conn));
        }
      mysqli_commit($conn);
    }

    public function gettipos(){
      $conn = $this->getConMYSQL() ;
      $sel = "SELECT * FROM `cmstipo` WHERE estatus='Activo' ORDER BY `cmstipo`.`nombre` ASC";
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

      $res_array = array();
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $res_array[$i][$key]=$value;
        }
        $i++;
      }
      return $res_array;
    }
    public function getvendedores($buscar){
        $conn = conectarSQlSERVER();

          $vendedores = array();
        $sel="
        select * from saVendedor ";
        if($buscar!=null){
          $sel.=" where co_ven  = '".$buscar."' ";
        }

        $sel.=" order by ven_des";

        $i=0;

        $result=sqlsrv_query($conn,$sel);
        while($row=sqlsrv_fetch_array($result)){
          foreach($row as $key=>$value){
            $vendedores[$i][$key]=$value;
          }
          $i++;
        }
          sqlsrv_free_stmt($result);
        return $vendedores;
    }
    public function getCliente($buscar){
      	$conn = conectarSQlSERVER();

	      $clientes = array();
        $sel="
        select * from saCliente  ";
        if($buscar!=null){
          $sel.=" where co_cli  = '".$buscar."' ";
        }

        $sel.=" order by cli_des";

        $i=0;

        $result=sqlsrv_query($conn,$sel);
        while($row=sqlsrv_fetch_array($result)){
          foreach($row as $key=>$value){
            $clientes[$i][$key]=$value;
          }
          $i++;
        }
          sqlsrv_free_stmt($result);
        return $clientes;
    }

    public function getcombos(){
     

      $conn = $this->getConMYSQL() ;
      $sel = "
      SELECT * FROM `cmscombo`
      WHERE estatus='Activo'
      AND id != 1 ORDER BY `cmscombo`.`descripcion` ASC";
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

      $res_array = array();
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $res_array[$i][$key]=$value;
        }
        $i++;
      }
      return $res_array;
    }

    public function getVendedor($co_ven){
      $conn = conectarSQlSERVER();

      $sel = "
      SELECT * FROM saVendedor WHERE co_ven='".$co_ven."' ";
      $i=0;
      $vendedor = array();
      $result=sqlsrv_query($conn,$sel);

      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $vendedor[$i][$key]=$value;
        }
        $i++;
      }
      return $vendedor;
    }

    public function mensaje($numero){
      $tipo = "success";
      $mensaje = array(
        1=>"Comisión creada con éxito",
        2=>"Error creada con éxito",
        3=>"Comisión creada con éxito"

      );
      if($numero > 10){
          $tipo = "warning";
      }

      if($numero > 20){
          $tipo = "danger";
      }
      ?>

      <?php
    }

    /* facturas totales de cuentas claves */
    public function getTotalCuentasClaves($segmento,$desde,$hasta,$co_ven){
      $sel = "
          select ven.co_ven,
            ven.ven_des,sum(total_bruto) as bruto
             from saVendedor as ven
          inner join saFacturaVenta as fv on ven.co_ven = fv.co_ven
          inner join saCliente as cli on cli.co_cli = fv.co_cli
          INNER JOIN saSegmento AS sg ON cli.co_seg=sg.co_seg
           where cli.co_seg = '".$segmento."'
            and fec_emis >='".$desde."' and fec_emis <='".$hasta."'";
            if ($co_ven) {
              $sel.=" and  ven.co_ven='".$co_ven."' ";
            }
            $sel.=" group by ven.co_ven,ven.ven_des ";
      $conn = conectarSQlSERVER();     

      $i=0;
      $totales = array();
      $result=sqlsrv_query($conn,$sel);

      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $totales[$i][$key]=$value;
        }
        $i++;
      }

      /* quitar de listo los que si tienen facturas en ese periodo */
         $cod_ven = "";
            for($x=0;$x < count($totales); $x++){
              $cod_ven.="'".$totales[$x]['co_ven']."',";
            }
            $cod_ven = substr($cod_ven, 0, -1);
      $sel2="
      select 
          DISTINCT
          ven.co_ven, ven.ven_des , 0 as bruto
          from saVendedor as ven 
          inner JOIN saCliente as cli ON cli.co_ven = ven.co_ven
          WHERE cli.co_seg = '".$segmento."'
           and ven.co_ven not in(".$cod_ven.")  ";

          
      $result=sqlsrv_query($conn,$sel2);

      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $totales[$i][$key]=$value;
        }
        $i++;
      }
      return $totales;
    }
    public function getCuentasClaves($segmento,$id){
     $sel = "
       SELECT DISTINCT
        ven.co_ven,
        ven.ven_des
      FROM saVendedor AS ven
      INNER JOIN saCliente AS cli ON cli.co_ven= ven.co_ven
      INNER JOIN saSegmento AS sg ON cli.co_seg=sg.co_seg
      INNER JOIN saZona  AS zn ON zn.co_zon= cli.co_zon
      where cli.co_seg = '".$segmento."'";
         
          if($id!=null){
            $sel.=" and ven.co_ven='".$id."' ";

          }
      $conn = conectarSQlSERVER();
     

      $i=0;
      $claves = array();
      $result=sqlsrv_query($conn,$sel);

      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $claves[$i][$key]=$value;
        }
        $i++;
      }


         $cuentasTradicionales = $this->getCuentasNoClaves('01',null);

         for ($i=0; $i < count($claves) ; $i++) { 
           $codClaves[] = $claves[$i]['co_ven'];
         }


         /* BORRAR DE CODIGOS DE CLAVES ALGUNOS QUE APAREZACN EN LOS TRADICIONALES*/
          for ($y=0; $y < count($cuentasTradicionales); $y++) { 
             $existe = array_search($cuentasTradicionales[$y]['co_ven'], $codClaves);
             if (!empty($existe)) {
               unset($claves[$existe]);
             }
          }

          /*re ordernar reorder */
         $claves=  array_values($claves);
      return $claves;
    }
    public function getCuentasNoClaves($segmento,$id){
     $sel = "
       SELECT DISTINCT
        ven.co_ven,
        ven.ven_des
      FROM saVendedor AS ven
      INNER JOIN saCliente AS cli ON cli.co_ven= ven.co_ven
      INNER JOIN saSegmento AS sg ON cli.co_seg=sg.co_seg
      INNER JOIN saZona  AS zn ON zn.co_zon= cli.co_zon
      where cli.co_seg != '".$segmento."'";
         
          if($id!=null){
            $sel.=" and ven.co_ven='".$id."' ";

          }
      $conn = conectarSQlSERVER();
     

      $i=0;
      $totales = array();
      $result=sqlsrv_query($conn,$sel);

      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $totales[$i][$key]=$value;
        }
        $i++;
      }
      return $totales;
    }
    public function getComisiones(){
     

      $conn = $this->getConMYSQL() ;
      $sel = "select CB.*,CT.nombre as tiponombre from cmsbase as CB
      INNER JOIN cmstipo AS CT ON CT.id = CB.cmsTipo_id ORDER BY `CB`.`creacion` DESC ";
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

      $res_array = array();
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $res_array[$i][$key]=$value;
        }
        $i++;
      }
      return $res_array;

    }

    public function getComisionesUsuario($co_ven){
     

      $conn = $this->getConMYSQL() ;
      $sel = "
      SELECT
        c.nombre as comision,
        t.nombre as tipo,
        a.estado
       FROM `cmsasignacion` as a
      inner join cmsbase as c ON c.id= a.cmsBase_id
      inner join cmstipo as t ON c.cmsTipo_id= t.id
      where
      a.co_ven='".$co_ven."'";
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

      $res_array = array();
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $res_array[$i][$key]=$value;
        }
        $i++;
      }
      return $res_array;
    }


    public function getAsignar($idcomision,$co_ven){
      $usuario=$_SESSION['usuario'];
      $conn = $this->getConMYSQL() ;
      /* BUSCAR SI YA TIENE LA COMISION */
      $sel ="
      SELECT count(cmsBase_id) as cant  FROM `cmsasignacion` WHERE `co_ven` = '".$co_ven."' AND cmsBase_id = '".$idcomision."' and estado='Activo'";
      $rs = mysqli_query($conn,$sel);
      //var_dump($rs); exit();

      $ln = mysqli_fetch_array($rs);
      if (!mysqli_errno($conn)) {
        if(intval($ln['cant']) == 0){
          $sel = "
              INSERT INTO `cmsasignacion`(`id`, `usuario`, `co_ven`, `cmsBase_id`, `ingreso`, `estado`)
              VALUES (null,'".$usuario."','".$co_ven."','".$idcomision."',CURRENT_DATE(),'Activo')";
              mysqli_query($conn,$sel) or die(mysqli_error($conn));
              $this->setMensajes('success',"Comisión asignada con éxito.");
              $msn = array(
              'error'=>'no'
              );
        }else{
            $msn = array(
              'error'=>'si'
            );
            $this->setMensajes('info',"Ya esta comisión se calculra para este Vendedor");
        }

    }else{
        $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);
    }
    return $msn;

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

    public function combosProductos(){
        $conn = $this->getConMYSQL() ;
          $sel = "
          select
            c.id,
            c.descripcion,
            c.estatus,
            c.fecha,
            c.creador,
             COUNT(c.id) as cant
             from cmscombo as c
            inner join cmscombo_articulo as ca ON c.id=ca.cmsCombo_id
            group by c.id
            ORDER BY `c`.`fecha` DESC
            ";
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $res_array = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
          }
          $i++;
        }
        return $res_array;
    }

    public function getZonas($id){
      $conn = conectarSQlSERVER();
      $sel="
      SELECT * FROM saZona";
      if ($id) {
        $sel.=" where co_zon ='".$id."'";
      }
      $sel.=" order by zon_des";

      $zona = array();
      $result=sqlsrv_query($conn,$sel);
      $i=0;
      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $zona[$i][$key]=$value;
        }
        $i++;
      }
      return $zona;
    }
    public function calculoTradicionalComicion($co_ven){
      //2X%zk}lHG*
      $conn = $this->getConMYSQL() ;
      $sel="
      SELECT
       pedidos_des.factura,
       pedidos_des.fec_venc,
       pedidos_des.fec_emis,
       DATEDIFF(fec_venc , fec_emis) AS cneg
       FROM `pedidos_des`
      where co_ven ='".$co_ven."'";

      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $res_array = array();
      $reporte = new reporte();

      $i=0;
      while($row=mysqli_fetch_array($rs)){
          $saldo = $reporte->saldoUnaFactura($co_ven,trim($row['factura']));
        foreach($row as $key=>$value){
          $res_array[$i][$key]=$value;
          $res_array[$i]['saldo'] = $saldo;
        }
        $i++;
      }
    //  var_dump($res_array); exit();
      for($x=0;$x < count($res_array);$x++){
        echo $res_array[$x]['factura']." ".$res_array[$x]['cneg']." ".
              $res_array[$x]['fec_venc']." ".$res_array[$x]['saldo']."<br>";
      }

    }
    /* fecha de cobro de un documento, permite calcular fecha de credito segun entrega*/
    public function fechaCobroDocumento($cob_num,$desde,$hasta){

      $cobro = "";

      if(!isset($cob_num) or $cob_num != null or $cob_num != ""){
	       $conn = conectarSQlSERVER();
          //$sel="select fe_us_in from saCobroDocReng where nro_doc='".$cob_num."'";
          $sel="
          SELECT
              PT.forma_pag,P.cob_num, P.fecha, P.co_cli, PV.cli_des, PT.forma_pag, PT.reng_num, P.anulado, p.co_mone, PT.num_doc,
              PT.cod_caja, C.descrip, PT.cod_cta, CB.num_cta, P.monto / ( CASE WHEN '' IS NULL THEN 1
                                                                               ELSE P.tasa
                                                                          END ) * CASE WHEN P.anulado = 1 THEN 0
                                                                                       ELSE 1
                                                                                  END AS monto,
              PT.mont_doc / ( CASE WHEN '' IS NULL THEN 1
                                   ELSE P.tasa
                              END ) * CASE WHEN P.anulado = 1 THEN 0
                                           ELSE 1
                                      END AS mont_doc, CASE WHEN PT.cod_caja IS NULL THEN PT.cod_cta
                                                            ELSE PT.cod_caja
                                                       END AS cuenta, CASE WHEN PT.cod_caja IS NULL THEN CB.num_cta
                                                                           ELSE C.descrip
                                                                      END AS descripcion, '' AS subtotal
          FROM
              saCobro AS P
              INNER JOIN saCobroDocReng AS PR ON P.cob_num = PR.cob_num
              INNER JOIN saCobroTPReng AS PT ON PR.cob_num = PT.cob_num
              INNER JOIN saCliente AS PV ON P.co_cli = PV.co_cli
              LEFT JOIN saCaja AS C ON PT.cod_caja = C.cod_caja
              LEFT JOIN saCuentaBancaria AS CB ON PT.cod_cta = CB.cod_cta
          WHERE

                PR.nro_doc = '".$cob_num."' 
                and PT.forma_pag IN('TP','CH')
                and P.fecha >='".$desde."'
                and P.fecha <='".$hasta."'
          GROUP BY
              P.cob_num, PT.reng_num, P.fecha, P.co_cli, P.co_sucu_in, PV.cli_des, PT.cod_cta, CB.num_cta, PT.cod_caja,
              C.descrip, PT.forma_pag, PT.num_doc, P.co_mone, P.monto, PT.mont_doc,
               P.anulado, P.tasa
          ORDER BY
              p.fecha";
          $result=sqlsrv_query($conn,$sel);

          while($row=sqlsrv_fetch_array($result)){
              $cobro = $row[2];
          }

        }
          return $cobro;
    }

    public function fechaRecibidoFactura($factura){
      $sel="
      SELECT *, DATEDIFF(fec_venc , fec_emis) AS cneg FROM `pedidos_des` WHERE
      `factura` = '".$factura."'
      ORDER BY `factura` DESC ";
      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $dFactura = array();
      $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $dFactura[$i][$key]=$value;
          }
            $i++;
          }
          return $dFactura;
    }
    /* LISTA BASICA DE FACTURAS CON FECHA DE DESPACHO Y RECIBIDO */
    public function listaPedidosBasico($co_ven,$finicio,$ffinal){
        $sel ="SELECT DATEDIFF(fec_venc , fec_emis) AS cneg,

         pedidos_des.* FROM `pedidos_des`
        WHERE factura IS NOT NULL ";

          $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
         $pedidos  = array();
         $i=0;
            while($row=mysqli_fetch_array($rs)){          
            foreach($row as $key=>$value){
              
                    $pedidos[$i][$key]=$value;
                 
            }
            $i++;
        }
        return $pedidos;
    }
    public function listaPedidos($co_ven,$finicio,$ffinal){

      $sel="
      SELECT *,

      DATEDIFF(fec_venc , fec_emis) AS cneg
       FROM `pedidos_des`
       where factura IS NOT NULL ";

      if($co_ven != null){
            $sel.=" and co_ven='".$co_ven."' ";
      }
      if($ffinal != null){
            $sel.=" and  fec_emis  between  '".$finicio."'  and  '".$ffinal."'";
      }
      $sel.=" ORDER BY `pedidos_des`.`factura` ASC";

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $pedidos = array();

      $i=0;

      $reporte = new reporte();
      while($row=mysqli_fetch_array($rs)){
        $saldo = $reporte->saldoUnaFactura(trim($row['co_ven']),trim($row['factura']));
        foreach($row as $key=>$value){
          if(trim($saldo['cli_des']) != ""){
                $pedidos[$i][$key]=$value;
                $pedidos[$i]["saldo"]=$saldo['saldo'];
                $pedidos[$i]["cli_des"]= utf8_encode($saldo['cli_des']);
                $pedidos[$i]["cond"]=$saldo['cond'];
                $pedidos[$i]["dias_cred"]=$saldo['dias_cred'];
              }
        }
        $i++;
      }
      $pedidos = array_values($pedidos);
      return $pedidos;
    }
    public function listadogerencias($gerencia,$finicio,$ffinal){

      //selecciono facturas con todos lo criterios
      $sel="
      SELECT *,

      DATEDIFF(fec_venc , fec_emis) AS cneg
       FROM `pedidos_des`
       where factura IS NOT NULL ";

      if($gerencia != null){
            $sel.=" and co_ven='".$gerencia."' ";
      }
      if($ffinal != null){
            $sel.=" and fec_emis between '".$finicio."' and '".$ffinal."'";
      }

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $pedidos = array();

      $i=0;

      $reporte = new reporte();
      while($row=mysqli_fetch_array($rs)){

        $saldo = $reporte->saldoUnaFactura(trim($row['co_ven']),trim($row['factura']));

        foreach($row as $key=>$value){
          if(trim($saldo['cli_des']) != "" and $saldo['saldo']==0){
                $pedidos[$i][$key]=$value;
                $pedidos[$i]["saldo"]=$saldo['saldo'];
                $pedidos[$i]["cli_des"]= utf8_encode($saldo['cli_des']);
                $pedidos[$i]["cond"]=$saldo['cond'];
                $pedidos[$i]["dias_cred"]=$saldo['dias_cred'];
              }
        }

        $i++;
      }
      $pedidos = array_values($pedidos);
      return $pedidos;
    }
    function porcentaje($cantidad,$porciento){
    //  $monto = $cantidad * $porciento/ 100 ;
      $monto = $porciento * $cantidad   / 100 ;
      return $monto;
    }
    public function detalleUnparametro($id){
      $sel ="
      SELECT * FROM `parametros` WHERE `id` = ".$id."
      ";
     

      $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $res_array = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $res_array[$i][$key]=$value;
          }
          $i++;
        }

        return $res_array;

    }
    function dias_transcurridos($fecha_i,$fecha_f){
      if (empty($fecha_i) or empty($fecha_f) ) {
      $dias = "?";
      } else {
        $dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
      	$dias 	= abs($dias);
        $dias = round($dias);
      }
    	return $dias;
    }
    //encuentra notas de credito de una factura - rep
    public function notasCreditoDeFacturas($factura,$desde,$hasta){
      $sql="
      with prueba as (
              SELECT top 500
                  'docuventa' AS TIPO_DOC,
                  'tipo' = 1, VE.ven_des,  DV.co_tipo_doc,
                   DV.nro_doc, DV.co_cli, CL.cli_des,
                   DV.co_ven, DV.fec_emis,DV.fec_venc,
                  CASE WHEN (DV.doc_orig = 'DEVO') THEN 'FACT' else DV.doc_orig  end as doc_orig,
                  CASE WHEN (DV.doc_orig = 'DEVO')
                    THEN (select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1)
                    else DV.nro_orig
                  end as nnro_orig,

                    DV.total_bruto,
                     DV.monto_imp,
                      DV.monto_desc_glob, DV.porc_desc_glob,
                  DV.monto_reca, DV.porc_reca, ( DV.otros1 + DV.otros2 + DV.otros3 ) AS otros,
                  CASE WHEN (DV.doc_orig = 'DEVO') THEN
                        (select fec_emis from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 AND (doc_orig='FACT' OR doc_orig='NENT')))
                      WHEN (DV.co_tipo_doc = 'N/CR') THEN
                        (select ISNULL(fec_emis, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig)
                      ELSE
                        null
                      END AS fec_emis_ori,
                            CASE WHEN (DV.doc_orig = 'DEVO') THEN
                        (select total_bruto from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 and (doc_orig='FACT' OR doc_orig='NENT')))
                      WHEN (DV.co_tipo_doc = 'N/CR') THEN
                        (select ISNULL(total_bruto, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig)
                      ELSE
                        null
                      END AS total_bruto_ori,
                            CASE WHEN
                        (DV.doc_orig = 'DEVO') THEN (select monto_imp from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 and (doc_orig='FACT' OR doc_orig='NENT')))
                      WHEN (DV.co_tipo_doc = 'N/CR') THEN
                        (select ISNULL(monto_imp, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig)
                      ELSE
                        null
                      END AS monto_imp_ori,
                            CASE WHEN (DV.doc_orig = 'DEVO') THEN
                        (select total_neto from saDocumentoVenta where nro_doc =(select num_doc from saDevolucionClienteReng where doc_num = DV.nro_orig and reng_num = 1 and (doc_orig='FACT' OR doc_orig='NENT')))
                      WHEN (DV.co_tipo_doc = 'N/CR') THEN
                        (select ISNULL(total_neto, null) from saDocumentoVenta where nro_doc = DV.nro_orig and co_tipo_doc= DV.doc_orig)
                      ELSE
                        null
                      END AS total_neto_ori
              FROM
                  saDocumentoVenta AS DV --INNER JOIN saDocumentoCompraReng AS DVR ON DVR.nro_doc = DV.nro_doc
                  INNER JOIN saCliente AS CL ON CL.co_cli = DV.co_cli

                   LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DV.co_tipo_doc

                  INNER JOIN saVendedor AS VE ON VE.co_ven = DV.co_ven

              WHERE
                 DV.anulado = 0 and (DV.co_tipo_doc='N/CR' or DV.co_tipo_doc='N/DB' or DV.co_tipo_doc='CHEQ')
                 and DV.fec_emis between '".$desde."' and '".$hasta."'
            ORDER BY
                  DV.nro_doc ASC
      )
      select * from prueba where nnro_orig='".$factura."'  ";
      $conn = conectarSQlSERVER();

      $notas = array();
      $i=0;

      $result=sqlsrv_query($conn,$sql);
      while($row=sqlsrv_fetch_array($result)){
        foreach($row as $key=>$value){
          $notas[$i][$key]=$value;
        }
        $i++;
      }
      sqlsrv_free_stmt($result);
      return $notas;

    }
      //public function calculoBasico($co_ven,$condicion,$saldo_factura,$diasCalle,$total_bruto,$fVencimiento,$fcobro,$cneg){
    public function calculoBasico2($datos,$parametros){
         $segClave = "01";
        //parametros iniciales para calculo
        /*comision tradicionales*/
        /* LOS INDICES ESTAN EN LA TABLA PARAMETROS DE COMISIONES */
       
        /* USUARIOS CLAVES*/
        $saldoCero = $parametros[0];
        $contadoPrepado = $parametros[1];
        
        $ReservacontadoPrepado = $parametros[4];
        
        $ClaveCom15 = $parametros[7];
        $ClaveRes15 = $parametros[11];

        $ClaveCom21 = $parametros[8];
        $ClaveRes21 = $parametros[12];

        $ClaveCom30 = $parametros[9];
        $ClaveRes30 = $parametros[13];

        $ClaveCom44 = $parametros[10];
        $ClaveRes44 = $parametros[14];

          /* USUARIOS TRADICINAL*/
        $TradicionalCom7 = $parametros[2];
        $Tradicionalres7 = $parametros[5];

        $TradicionalCom15 = $parametros[3];
        $Tradicionalres15 = $parametros[6];

        $TradicionalCom15 = $parametros[3];
        $Tradicionalres15 = $parametros[6];

        $TradicionalCom16 = $parametros[15];
        $Tradicionalres16 = $parametros[16];

        if (isset($parametros[17])) {
          $TradicionalCom17 = $parametros[17];
          $Tradicionalres17 = $parametros[18];
        }
 
       /* SABES SI ES VENDEDOR CLAVE | pendiente*/
        $comision = array(
            "comision"=> 0,
            "reserva"=> 0,
            "porcentaje"=> 0,
            "porcentajeR"=> 0,
            "calculado"=> 0,
        );

        if(floatval($datos['saldo_factura']) <= $saldoCero['limite1']){
   
            /* CUENTAS CLAVE  CUENTAS CLAVE */
            if(trim($datos['co_seg']) ==  $segClave){             
            if($comision['calculado'] == 0 and  $datos['diascalle'] <= $ClaveCom15['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$ClaveCom15['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$ClaveRes15['porcentaje']);
                  $comision['porcentaje'] = $ClaveCom15['porcentaje'];
                  $comision['porcentajeR'] = $ClaveRes15['porcentaje'];
                  $comision['calculado'] = 1;
              }
            
            if($comision['calculado'] == 0 and $datos['diascalle'] >= $ClaveCom21['limite1'] and $datos['diascalle'] <= $ClaveCom21['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$ClaveCom21['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$ClaveRes21['porcentaje']);
                  $comision['porcentaje'] = $ClaveCom21['porcentaje'];
                  $comision['porcentajeR'] = $ClaveRes21['porcentaje'];
                  $comision['calculado'] = 1;
              }  

            if($comision['calculado'] == 0 and $datos['diascalle'] >= $ClaveCom30['limite1'] and $datos['diascalle'] <= $ClaveCom30['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$ClaveCom30['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$ClaveRes30['porcentaje']);
                  $comision['porcentaje'] = $ClaveCom30['porcentaje'];
                   $comision['porcentajeR'] = $ClaveRes30['porcentaje'];
                  $comision['calculado'] = 1;
              }

            if($comision['calculado'] == 0 and $datos['diascalle'] >= $ClaveCom44['limite1'] and $datos['diascalle'] <= $ClaveCom44['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$ClaveCom44['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$ClaveRes44['porcentaje']);
                  $comision['porcentaje'] = $ClaveCom44['porcentaje'];
                  $comision['porcentajeR'] = $ClaveRes44['porcentaje'];
                  $comision['calculado'] = 1;
              }

            }else{
                // tradicional

                /* CONTADO */
                if(trim($comision['calculado']) == 0 and (trim($datos['condicion'])==trim('CONTAD') or trim($datos['condicion'])==trim('PREPA')) ){
                      if($datos['diascalle'] <= $contadoPrepado['limite2']){
                      $comision['comision'] = $this->porcentaje($datos['total_bruto'],$contadoPrepado['porcentaje']);
                      $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$ReservacontadoPrepado['porcentaje']);
                      $comision['porcentaje'] = $contadoPrepado['porcentaje'];
                      $comision['porcentajeR'] = $ReservacontadoPrepado['porcentaje'];
                      $comision['calculado'] = 1;
                    }
                }

                if($comision['calculado'] == 0 and $datos['diascalle'] >= $TradicionalCom7['limite1'] and $datos['diascalle'] <= $TradicionalCom7['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$TradicionalCom7['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$Tradicionalres7['porcentaje']);
                  $comision['porcentaje'] = $TradicionalCom7['porcentaje'];
                  $comision['porcentajeR'] = $Tradicionalres7['porcentaje'];
                  $comision['calculado'] = 1;
              }  
              if($comision['calculado'] == 0 and $datos['diascalle'] >= $TradicionalCom15['limite1'] and $datos['diascalle'] <= $TradicionalCom15['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$TradicionalCom15['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$Tradicionalres15['porcentaje']);
                  $comision['porcentaje'] = $TradicionalCom15['porcentaje'];
                  $comision['porcentajeR'] = $Tradicionalres15['porcentaje'];
                  $comision['calculado'] = 1;
              }

              if($comision['calculado'] == 0 and $datos['diascalle'] >= $TradicionalCom16['limite1'] and $datos['diascalle'] <= $TradicionalCom16['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$TradicionalCom16['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$Tradicionalres16['porcentaje']);
                  $comision['porcentaje'] = $TradicionalCom16['porcentaje'];
                   $comision['porcentajeR'] = $Tradicionalres16['porcentaje'];
                  $comision['calculado'] = 1;
              }
              if (isset($parametros[17])) {
                if($comision['calculado'] == 0 and $datos['diascalle'] >= $TradicionalCom17['limite1'] and $datos['diascalle'] <= $TradicionalCom17['limite2']){
                    $comision['comision'] = $this->porcentaje($datos['total_bruto'],$TradicionalCom17['porcentaje']);
                    $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$Tradicionalres17['porcentaje']);
                    $comision['porcentaje'] = $TradicionalCom17['porcentaje'];
                    $comision['porcentajeR'] = $Tradicionalres17['porcentaje'];
                    $comision['calculado'] = 1;
                }
              }

            }
        }
        return $comision;

    }
      //public function calculoBasico($co_ven,$condicion,$saldo_factura,$diasCalle,$total_bruto,$fVencimiento,$fcobro,$cneg){
    public function calculoBasico($datos){

        //parametros iniciales para calculo
        /*comision tradicionales*/

        $tradicional6 = $this->detalleUnparametro(4);
        $tradicional5 = $this->detalleUnparametro(5);
        $tradicional2 = $this->detalleUnparametro(6);

        /*reserva tradicionales*/
        $reserva6 = $this->detalleUnparametro(7);
        $reserva14 = $this->detalleUnparametro(8);
        $reserva15 = $this->detalleUnparametro(9);

        /* comision clave */
        $claveC015 = $this->detalleUnparametro(10);
        $claveC1621 = $this->detalleUnparametro(11);
        $claveC2230 = $this->detalleUnparametro(12);
        $claveC3144 = $this->detalleUnparametro(13);

        /* reserva clave */
        $claveR015 = $this->detalleUnparametro(14);
        $claveR1621 = $this->detalleUnparametro(15);
        $claveR2230 = $this->detalleUnparametro(16);
        $claveR3144 = $this->detalleUnparametro(17);

        $contado = $this->detalleUnparametro(4);
        $contadoR = $this->detalleUnparametro(7);

       $saldoCero = $this->detalleUnparametro(3);


        /* SABES SI ES VENDEDOR CLAVE | pendiente*/
        $comision = array(
            "comision"=> 0,
            "reserva"=> 0,
            "porcentaje"=> 0,
            "calculado"=> 0,
        );
          if(floatval($datos['saldo_factura']) <= $saldoCero[0]['limite1']){
            
            /* CUENTAS CLAVE  CUENTAS CLAVE */
            if(strpos($datos['co_ven'], "A") > 0){

              if(trim($comision['calculado']) == 0 and (trim($datos['condicion'])==trim('CONTAD') or $datos['condicion']==trim('PREPA')) ){
                  if($datos['diascalle'] <= $contado[0]['limite2']){
                    $comision['comision'] = $this->porcentaje($datos['total_bruto'],$contado[0]['porcentaje']);
                    $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$contadoR[0]['porcentaje']);
                    $comision['porcentaje'] = $contado[0]['porcentaje'];
                    $comision['calculado'] = 1;
                  }

              }
              if($comision['calculado'] == 0 and $datos['diascalle'] <= $claveC015[0]['limite1']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$claveC015[0]['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$claveR015[0]['porcentaje']);
                  $comision['porcentaje'] = $claveC015[0]['porcentaje'];
                  $comision['calculado'] = 1;
              }
              if($comision['calculado'] == 0 and $datos['diascalle'] >= $claveC1621[0]['limite1'] and $datos['diascalle'] < $claveC1621[0]['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$claveC1621[0]['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$claveR1621[0]['porcentaje']);
                  $comision['porcentaje'] = $claveC1621[0]['porcentaje'];
                  $comision['calculado'] = 1;
              }
              if($comision['calculado'] == 0 and $datos['diascalle'] >= $claveC2230[0]['limite1'] and $datos['diascalle'] < $claveC2230[0]['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$claveC2230[0]['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$claveR2230[0]['porcentaje']);
                  $comision['porcentaje'] = $claveC2230[0]['porcentaje'];
                  $comision['calculado'] = 1;
              }
              if($comision['calculado'] == 0 and $datos['diascalle'] >= $claveC3144[0]['limite1'] and $datos['diascalle'] <= $claveC3144[0]['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$claveC3144[0]['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$claveR3144[0]['porcentaje']);
                  $comision['porcentaje'] = $claveC3144[0]['porcentaje'];
                  $comision['calculado'] = 1;
              }
            }else{
              /*   cuentas tradicionales   */
              /*   CONTAD y PREPA | Pre pago contado 48 horas  */
              if((trim($datos['condicion']) == trim('CONTAD') or trim($datos['condicion']) == trim('PREPA')) and $comision['calculado'] == 0){
                  if($datos['diascalle'] <= $contado[0]['limite2']){
                    $comision['comision'] = $this->porcentaje($datos['total_bruto'],$contado[0]['porcentaje']);
                    $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$contadoR[0]['porcentaje']);
                    $comision['porcentaje'] = $contado[0]['porcentaje'];
                    $comision['calculado'] = 1;
                  }
              }

              if( $comision['calculado'] == 0 and $datos['diascalle'] <= $tradicional5[0]['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$tradicional5[0]['porcentaje']);
                    $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$reserva14[0]['porcentaje']);
                    $comision['porcentaje'] = $tradicional5[0]['porcentaje'];
                    $comision['calculado'] = 1;
              }
              if($comision['calculado'] == 0 and  $datos['diascalle'] >= $tradicional2[0]['limite1'] and $datos['diascalle'] <= $tradicional2[0]['limite2']){
                  $comision['comision'] = $this->porcentaje($datos['total_bruto'],$tradicional2[0]['porcentaje']);
                  $comision['reserva'] = $this->porcentaje($datos['total_bruto'],$reserva15[0]['porcentaje']);
                  $comision['porcentaje'] = $tradicional2[0]['porcentaje'];
                  $comision['calculado'] = 1;
              }
            }
          }
          return $comision;

    }
   public function buscar($array,$campo1,$campo2){
        
        $encontrado = array(
            'veces'=> 0,
            'posicion'=> ""
        );
        for ($x=0; $x < count($array); $x++) { 
            if ($array[$x]['nro_orig'] == $campo1) {    
                 if($array[$x]['co_tipo_doc'] == $campo2){
                        $encontrado['veces']++;
                        $encontrado['posicion'] = $x;
                        if ( $encontrado['veces'] > 1) {
                            break;
                        }
                       
                 }
            }

        
        }

        return $encontrado;
    }
    public function buscarEnMatriz($array, $matching,$pos) {
    
        $lugar = 0;
    foreach ($array as $item) {
        $is_match = true;
        foreach ($matching as $key => $value) {

            if (is_object($item)) {
                if (! isset($item->$key)) {
                    $is_match = false;
                    break;
                }
            } else {
                if (! isset($item[$key])) {
                    $is_match = false;
                    break;
                }
            }

            if (is_object($item)) {
                if ($item->$key != $value) {
                    $is_match = false;
                    break;
                }
            } else {
                if ($item[$key] != $value) {
                    $is_match = false;
                    break;
                } 
            }
        }

        if ($is_match) {
            $item['encontrado'] = "si";
            $item['lugar'] = $lugar;
            return $item;   
        }
        $lugar++;
    }
    return false;
}
    /**
     * [listadoFacturaComisionSaldoBasico2 description]
     * @param  Date $desde Fecha inicion
     * @param  Date $hasta Feha limite
     * @return Arry        facturas
     */         
    public function listadoFacturaComisionSaldoBasico2($desde,$hasta) {
      $facturas = array();

     /* SE CREA UNA UNION DE SELECT PARA TRAER PRIMERO LAS FACTURAS */
     /* SE CREA UNA UNION DE SELECT PARA TRAER PRIMERO LAS FACTURAS */

      $sel_saldo=" SELECT
            DC.nro_doc, 
         DC.co_tipo_doc, 
         DC.co_ven, 
         DC.co_cli, 
         dbo.fechasimple(DC.fec_emis) as fec_emis, 
         dbo.fechasimple(DC.fec_venc) as fec_venc, 
         DC.anulado,
      DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
       ELSE DC.tasa
      END ) * ( CASE WHEN DC.anulado = 1 THEN 0
         ELSE 1
      END ) AS total_neto, DC.saldo / ( CASE WHEN '' IS NULL THEN 1
         ELSE DC.tasa
    END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                   ELSE 1
              END ) AS saldo, DC.tasa, P.cli_des,
          TP.descrip, 
          TP.tipo_mov,
           DC.tasa,
            DC.total_bruto,
            DC.monto_imp,
            P.cli_des,
            DC.nro_doc,
            DC.nro_orig,
            TP.tipo_mov,
            TP.descrip,
            DC.fec_emis,
            DC.fec_venc,
            P.cli_des as prov_des,
            P.co_cli as co_prov,
            ven.ven_des as vendedor,
            ZN.zon_des as zona,
            P.co_seg
        FROM
            saDocumentoVenta AS DC
            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
            LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
            INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
            INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
        WHERE
            dbo.fechasimple(DC.fec_emis) >= '".$desde."'
            AND dbo.fechasimple(DC.fec_emis) <= '".$hasta."'
            and DC.anulado=0
            and DC.co_tipo_doc IN('FACT')
           UNION ALL 
         SELECT
            DC.nro_doc, 
         DC.co_tipo_doc, 
         DC.co_ven, 
         DC.co_cli, 
         dbo.fechasimple(DC.fec_emis) as fec_emis, 
         dbo.fechasimple(DC.fec_venc) as fec_venc, 
         DC.anulado,
      DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
       ELSE DC.tasa
      END ) * ( CASE WHEN DC.anulado = 1 THEN 0
         ELSE 1
      END ) AS total_neto, DC.saldo / ( CASE WHEN '' IS NULL THEN 1
         ELSE DC.tasa
    END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                   ELSE 1
              END ) AS saldo, DC.tasa, P.cli_des,
          TP.descrip, 
          TP.tipo_mov,
           DC.tasa,
            DC.total_bruto,
            DC.monto_imp,
            P.cli_des,
            DC.nro_doc,
            DC.nro_orig,
            TP.tipo_mov,
            TP.descrip,
            DC.fec_emis,
            DC.fec_venc,
            P.cli_des as prov_des,
            P.co_cli as co_prov,
            ven.ven_des as vendedor,
            ZN.zon_des as zona,
            P.co_seg
        FROM
            saDocumentoVenta AS DC
            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
            LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
            INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
            INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
        WHERE
            dbo.fechasimple(DC.fec_emis) >= '".$desde."'
            AND dbo.fechasimple(DC.fec_emis) <= '".$hasta."'
            and DC.anulado=0
            and DC.co_tipo_doc NOT IN('FACT') ";
     
          $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel_saldo);

        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
              $facturas[$i][$key]=$value;

              $facturas[$i]['comision']="X";
              $facturas[$i]['dias_cred'] = "";
              $facturas[$i]['fecha_recibido'] = "";
              $facturas[$i]['cneg'] = "";
              $facturas[$i]['porcentaje']=0;
              $facturas[$i]['diascalle']="";
              $facturas[$i]['porcentajeR']=0;

            }
            $i++;
        }
      sqlsrv_free_stmt($result);

      /* INGRESAR DOCUMENTOS ANTES DE LA FECHA INICIAL DEL RANGO QUE ESTEN CANCELNDOCE */
      /* SQL QUE BUSCA DOCUMENTOS ANTERIOR EMITIDOS ANTERIORES AL RANGO PERO COBRADOS DENTRO DEL MISMO*/

         $sel="SELECT
             A.*, B.*, 'Cliente' AS tipo_rep
         FROM
             ( SELECT   DISTINCT
                 DC.co_tipo_doc AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc,
                 DC.total_neto, 0.00 AS MONTO, DC.saldo, '' AS nro_fact, DC.nro_orig,
                 CASE WHEN TD.tipo_mov = 'DE' THEN DC.total_neto
                      ELSE 0.00
                 END AS tot_debe, ( CASE WHEN TD.tipo_mov = 'CR' THEN DC.total_neto
                                         ELSE 0.00
                                    END ) AS tot_haber, CASE WHEN DC.co_cli = B.co_cli THEN B.co_cli
                                                             ELSE DC.co_cli
                                                        END AS co_prov, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                 '' AS ORIG, DC.observa, '' AS n_pago
               FROM
                 saDocumentoVenta AS dc
                 INNER JOIN ( SELECT DISTINCT
                                 DC.co_tipo_doc, DC.nro_doc, E.co_cli,
                                 ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                   OR E.anulado IS NULL THEN 0
                                                              ELSE 1
                                                         END), 0.00) AS mont_cob,
                                 ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                   ELSE R.mont_cob
                                              END ) * CASE WHEN E.anulado = 1
                                                                OR E.anulado IS NULL THEN 0
                                                           ELSE 1
                                                      END), 0) AS mont_cob_sal
                              FROM
                                 saDocumentoVenta DC
                                 LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                 AND DC.nro_doc = R.nro_doc
                                                                 AND dc.anulado = 0
                                                               )
                                 LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                          AND E.anulado = 0
                                                        )                      
                                   
                              GROUP BY
                                 DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                            ) AS b ON ( dc.nro_doc = b.nro_doc
                                        AND b.co_tipo_doc = DC.co_tipo_doc
                                      )
                 INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                 INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
               WHERE
                 dbo.fechaSimple(dc.fec_emis) >= '$desde'
                   
                   AND  dbo.fechaSimple(dc.fec_emis) <= '$hasta'
           
                 AND DC.anulado = 0
                 AND DC.co_tipo_doc <> 'ADEL'
               UNION ALL
               SELECT DISTINCT
                 'PAGO' AS descrip, P.cob_num, DC.nro_doc, P.fecha AS fec_emis, DC.fec_venc, DC.co_tipo_doc,
                 DC.total_neto, P.monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                 CASE WHEN ( TP.tipo_mov = 'CR'
                             AND DC.co_tipo_doc <> 'ADEL'
                           ) THEN ( CASE WHEN P.fecha > '2017-04-30' THEN 0
                                         ELSE ISNULL(PR.mont_cob, 0)
                                    END )
                 END AS tot_debe, ( CASE WHEN ( TP.tipo_mov = 'DE'
                                                OR DC.co_tipo_doc = 'ADEL'
                                              ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                                            ELSE ISNULL(PR.mont_cob, 0)
                                                       END )
                                    END ) * CASE WHEN DC.co_tipo_doc = 'ADEL' THEN -1
                                                 ELSE 1
                                            END AS tot_haber, CASE WHEN DC.co_cli = P.co_cli THEN DC.co_cli
                                                                   ELSE P.co_cli
                                                              END AS co_prov, PV.cli_des AS prov_des, DC.co_mone,
                 DC.anulado,DC.nro_doc AS ORIG, DC.observa,
                 CASE WHEN P.fecha > '$hasta' THEN 'SI'
                 END AS n_pago
               FROM
                 saDocumentoVenta AS DC
                 INNER JOIN saCobroDocReng AS PR ON ( PR.nro_doc = DC.nro_doc
                                                      AND PR.co_tipo_doc = DC.co_tipo_doc
                                                      AND dc.anulado = 0
                                                    )
                 INNER JOIN saCobro AS P ON ( P.cob_num = PR.cob_num
                                              AND P.anulado = 0
                                            )
                 INNER JOIN saTipoDocumento AS TP ON DC.co_tipo_doc = TP.co_tipo_doc
                 INNER JOIN saCliente AS PV ON DC.co_cli = PV.co_cli
               WHERE
                 DC.anulado = 0
                 AND  p.fecha >= '$desde'
                 AND p.fecha <= '$hasta'                
               UNION ALL
               SELECT   DISTINCT
                 CASE WHEN td.descrip = 'ADELANTO' THEN 'ADEL'
                 END AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc, DC.total_neto,
                 0.00 AS monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                 CASE WHEN Td.tipo_mov = 'DE' THEN DC.total_neto
                      ELSE 0.00
                 END AS tot_debe, ( CASE WHEN Td.tipo_mov = 'CR' THEN DC.total_neto
                                         ELSE 0.00
                                    END ) AS tot_haber, DC.co_cli, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                 '' AS ORIG, DC.observa, '' AS n_pago
               FROM
                 saDocumentoVenta AS dc
                 INNER JOIN ( SELECT DISTINCT
                                 DC.co_tipo_doc, DC.nro_doc, E.co_cli AS co_prov,
                                 ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                   OR E.anulado IS NULL THEN 0
                                                              ELSE 1
                                                         END), 0.00) AS mont_cob,
                                 ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                   ELSE R.mont_cob
                                              END ) * CASE WHEN E.anulado = 1
                                                                OR E.anulado IS NULL THEN 0
                                                           ELSE 1
                                                      END), 0) AS mont_cob_sal
                              FROM
                                 saDocumentoVenta DC
                                 LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                 AND DC.nro_doc = R.nro_doc
                                                                 AND dc.anulado = 0
                                                               )
                                 LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                          AND E.anulado = 0
                                                        )
                           
                                  
                              GROUP BY
                                 DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                            ) AS b ON ( dc.nro_doc = b.nro_doc
                                        AND b.co_tipo_doc = DC.co_tipo_doc
                                      )
                 INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                 INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
               WHERE
               DC.anulado = 0
               AND DC.co_tipo_doc = 'ADEL'
               AND  dbo.fechaSimple(dc.fec_emis) >= '$desde'
               AND dbo.fechaSimple(dc.fec_emis) <= '$hasta'  
             ) A
             INNER JOIN ( SELECT
                             DC.co_cli AS PROV, ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, dbo.fechaSimple('$desde') - 1, '') ) AS SaldoInic,
                             ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, '$hasta', '') ) AS SaldoFinal
                          FROM
                             saDocumentoVenta DC
                          GROUP BY
                             DC.co_cli
                        ) B ON B.prov = A.co_prov
           where co_tipo_doc in('FACT','N/CR','N/DB') and fec_venc <='$desde'
         ORDER BY
             A.fec_venc, A.co_tipo_doc"; 

        $result=sqlsrv_query($conn,$sel);

        $idDocumentos = array();

        while($row=sqlsrv_fetch_array($result)){
             $idDocumentos[] = $row[2];
        }
      sqlsrv_free_stmt($result);

        $cod_doc = "";
            for($x=0;$x < count($idDocumentos); $x++){
              $cod_doc.="'".$idDocumentos[$x]."',";
            }     


    $cod_doc = substr($cod_doc, 0, -1);
       $sel_saldo=" SELECT
            DC.nro_doc, 
         DC.co_tipo_doc, 
         DC.co_ven, 
         DC.co_cli, 
         dbo.fechasimple(DC.fec_emis) as fec_emis, 
         dbo.fechasimple(DC.fec_venc) as fec_venc, 
         DC.anulado,
      DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
       ELSE DC.tasa
      END ) * ( CASE WHEN DC.anulado = 1 THEN 0
         ELSE 1
      END ) AS total_neto, DC.saldo / ( CASE WHEN '' IS NULL THEN 1
         ELSE DC.tasa
    END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                   ELSE 1
              END ) AS saldo, DC.tasa, P.cli_des,
          TP.descrip, 
          TP.tipo_mov,
           DC.tasa,
            DC.total_bruto,
            DC.monto_imp,
            P.cli_des,
            DC.nro_doc,
            DC.nro_orig,
            TP.tipo_mov,
            TP.descrip,
            DC.fec_emis,
            DC.fec_venc,
            P.cli_des as prov_des,
            P.co_cli as co_prov,
            ven.ven_des as vendedor,
            ZN.zon_des as zona,
            P.co_seg
        FROM
            saDocumentoVenta AS DC
            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
            LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
            INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
            INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
        WHERE
            DC.nro_doc IN(".$cod_doc.")";
         $result=sqlsrv_query($conn,$sel_saldo);

         $ids_fact = array();
         $ids_ncr = array();

         for ($s=0; $s < count($facturas); $s++) { 

            if (trim($facturas[$s]['co_tipo_doc']) == 'FACT') {
                 $ids_fact[] = trim((int)$facturas[$s]['nro_doc']);
            }  

            if (trim($facturas[$s]['co_tipo_doc']) == 'N/CR') {
                 $ids_ncr[] = trim((int)$facturas[$s]['nro_doc']);
            }
            
         }

        while($row=sqlsrv_fetch_array($result)){
            if(trim($row[1]) == 'FACT'){
                $existe = array_search(trim((int)$row[0]),$ids_fact);
               if ($existe==FALSE) {                
                    foreach($row as $key=>$value){
                      $facturas[$i][$key]=$value;
                      $facturas[$i]['comision']="X";
                      $facturas[$i]['dias_cred'] = "";
                      $facturas[$i]['fecha_recibido'] = "";
                      $facturas[$i]['cneg'] = "";
                      $facturas[$i]['porcentaje']=0;
                      $facturas[$i]['diascalle']="";
                      $facturas[$i]['porcentajeR']=0;
                    }
                    $i++;
                }
            }
            

            if(trim($row[1]) == 'N/CR'){
                $existe = array_search(trim((int)$row[0]),$ids_ncr);
               if ($existe==FALSE) {                
                    foreach($row as $key=>$value){
                      $facturas[$i][$key]=$value;
                      $facturas[$i]['comision']="X";
                      $facturas[$i]['dias_cred'] = "";
                      $facturas[$i]['fecha_recibido'] = "";
                      $facturas[$i]['cneg'] = "";
                      $facturas[$i]['porcentaje']=0;
                      $facturas[$i]['diascalle']="";
                      $facturas[$i]['porcentajeR']=0;

                    }
                    $i++;
                }
            }
        }
        /* ANALISIS VENCIMIENTO */
        $bsql ="SELECT
              DC.nro_doc,
               DC.co_tipo_doc,
              DC.co_ven,
               DC.co_cli,
              DC.anulado, 
              DC.otros1,
              DC.otros2,
              DC.otros3, 
                        DC.total_neto / ( CASE WHEN NULL IS NULL THEN 1
                                    ELSE DC.tasa
                               END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                                              ELSE 1
                                         END ) AS total_neto,
              DC.saldo / ( CASE WHEN NULL IS NULL THEN 1
                    ELSE DC.tasa
               END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                              ELSE 1
                         END ) AS saldo,
              DC.tasa,
              DC.total_bruto,
              DC.monto_imp,
                        P.cli_des,
              DC.nro_doc,
              DC.nro_orig,
              TP.tipo_mov,
              TP.descrip,
                        DC.fec_emis,
                        DC.fec_venc,
                        P.cli_des as prov_des,
                        P.co_cli as co_prov,
                        DATEDIFF(DAY, DC.fec_emis, DC.fec_venc) as diasEmisionVencimiento,
                        DATEDIFF(DAY, GETDATE(), DC.fec_venc) as dias,
                        ven.ven_des as vendedor,
                        ZN.zon_des as zona, P.co_seg

            FROM
                saDocumentoVenta AS DC
                INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
                INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
                LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
                            where saldo > 0 ";
         $result=sqlsrv_query($conn,$bsql);

         $ids_fact = array();
         $ids_ncr = array();

         for ($s=0; $s < count($facturas); $s++) { 

            if (trim($facturas[$s]['co_tipo_doc']) == 'FACT') {
                 $ids_fact[] = trim((int)$facturas[$s]['nro_orig']);
            }  

            if (trim($facturas[$s]['co_tipo_doc']) == 'N/CR') {
                 $ids_ncr[] = trim((int)$facturas[$s]['nro_orig']);
            }
            
         }
 
        while($row=sqlsrv_fetch_array($result)){

            if(trim($row[1]) == 'FACT'){
                $existe = array_search(trim((int)$row[0]),$ids_fact);
               if ($existe==FALSE) {                
                    foreach($row as $key=>$value){
                      $facturas[$i][$key]=$value;
                      $facturas[$i]['comision']="X";
                      $facturas[$i]['dias_cred'] = "";
                      $facturas[$i]['fecha_recibido'] = "";
                      $facturas[$i]['cneg'] = "";
                      $facturas[$i]['porcentaje']=0;
                      $facturas[$i]['diascalle']="";
                      $facturas[$i]['porcentajeR']=0;
                     
                    }
                    $i++;
                }
            }            

            if(trim($row[1]) == 'N/CR'){
                $existe = array_search(trim((int)$row[0]),$ids_ncr);
               if ($existe==FALSE) {                
                    foreach($row as $key=>$value){
                      $facturas[$i][$key]=$value;
                      $facturas[$i]['comision']="X";
                      $facturas[$i]['dias_cred'] = "";
                      $facturas[$i]['fecha_recibido'] = "";
                      $facturas[$i]['cneg'] = "";
                      $facturas[$i]['porcentaje']=0;
                      $facturas[$i]['diascalle']="";
                      $facturas[$i]['porcentajeR']=0;
                       $facturas[$i]['saldoreal'] =0;

                    }
                    $i++;
                }
            }
    }
    /* FACTURAS QUE SE VENCEN DENTRO DEL PERIODO */
    $sel_venc ="
      SELECT
              DC.nro_doc, 
               DC.co_tipo_doc, 
               DC.co_ven, 
               DC.co_cli, 
               dbo.fechasimple(DC.fec_emis) as fec_emis, 
               dbo.fechasimple(DC.fec_venc) as fec_venc, 
               DC.anulado,
            DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
             ELSE DC.tasa
            END ) * ( CASE WHEN DC.anulado = 1 THEN 0
               ELSE 1
            END ) AS total_neto, DC.saldo / ( CASE WHEN '' IS NULL THEN 1
               ELSE DC.tasa
          END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                         ELSE 1
                    END ) AS saldo, DC.tasa, P.cli_des,
                TP.descrip, 
                TP.tipo_mov,
                 DC.tasa,
                  DC.total_bruto,
                  DC.monto_imp,
                  P.cli_des,
                  DC.nro_doc,
                  DC.nro_orig,
                  TP.tipo_mov,
                  TP.descrip,
                  DC.fec_emis,
                  DC.fec_venc,
                  P.cli_des as prov_des,
                  P.co_cli as co_prov,
                  ven.ven_des as vendedor,
                  ZN.zon_des as zona,
                  P.co_seg
              FROM
                  saDocumentoVenta AS DC
                  INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                  LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
                  INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
                  INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
              WHERE
                dbo.fechasimple(DC.fec_venc) >= '".$desde."' AND dbo.fechasimple(DC.fec_venc) <= '".$hasta."'
                  and DC.anulado=0
                  and DC.co_tipo_doc IN('FACT')
                 UNION ALL 
               SELECT
                  DC.nro_doc, 
               DC.co_tipo_doc, 
               DC.co_ven, 
               DC.co_cli, 
               dbo.fechasimple(DC.fec_emis) as fec_emis, 
               dbo.fechasimple(DC.fec_venc) as fec_venc, 
               DC.anulado,
            DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
             ELSE DC.tasa
            END ) * ( CASE WHEN DC.anulado = 1 THEN 0
               ELSE 1
            END ) AS total_neto, DC.saldo / ( CASE WHEN '' IS NULL THEN 1
               ELSE DC.tasa
          END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                         ELSE 1
                    END ) AS saldo, DC.tasa, P.cli_des,
                TP.descrip, 
                TP.tipo_mov,
                 DC.tasa,
                  DC.total_bruto,
                  DC.monto_imp,
                  P.cli_des,
                  DC.nro_doc,
                  DC.nro_orig,
                  TP.tipo_mov,
                  TP.descrip,
                  DC.fec_emis,
                  DC.fec_venc,
                  P.cli_des as prov_des,
                  P.co_cli as co_prov,
                  ven.ven_des as vendedor,
                  ZN.zon_des as zona,
                  P.co_seg
              FROM
                  saDocumentoVenta AS DC
                  INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                  LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
                  INNER JOIN saVendedor AS ven ON DC.co_ven = ven.co_ven
                  INNER JOIN saZona AS ZN ON ven.co_zon = ZN.co_zon
              WHERE
                  dbo.fechasimple(DC.fec_venc) >= '".$desde."' AND dbo.fechasimple(DC.fec_venc) <= '".$hasta."'
                  and DC.anulado=0
                  and DC.co_tipo_doc NOT IN('FACT')";
          $result=sqlsrv_query($conn,$sel_venc);
         $facturas_vencidas = array();
         $t = 0;
          while($row=sqlsrv_fetch_array($result)){          
              foreach($row as $key=>$value){

                $facturas_vencidas[$t][$key]=$value;
                $facturas_vencidas[$t]['comision']="X";
                $facturas_vencidas[$t]['dias_cred'] = "";
                $facturas_vencidas[$t]['fecha_recibido'] = "";

                $facturas_vencidas[$t]['cneg'] = "";
                $facturas_vencidas[$t]['porcentaje']=0;
                $facturas_vencidas[$t]['diascalle']="";
                $facturas_vencidas[$t]['porcentajeR']=0;
              }
              $t++;           
        }

        /* BUSCAR FACTURAS FALTANTES QUE ESTEN EN PEDIDOS_DES*/
        $pedidos = $this->listaPedidosBasico(null,$desde,$hasta);
       
       /* FACTURAS QUE ES ESTAN CON FECHA DE RECEPCION */
        for ($i=0; $i < count($pedidos) ; $i++) { 
           $nfacturas[] = $pedidos[$i]['factura'];
        }
        /* Se generan las nuevas fechas de vencimiento segun su recepcion 
          y se filtran solo las que entren dentro del periodo
        */    
         
        for ($j=0; $j < count($facturas_vencidas) ; $j++) {             

            /* BUSCAMOS EN LA PRE CARGA SI EXISTE LA FACTURA CON FECHA RECIBIDO */
            $idRegistroFacura = array_search(trim($facturas_vencidas[$j]['nro_orig']),$nfacturas);             
            $condiciones = $this->condicionTipoDefactura($facturas_vencidas[$j]['nro_orig']);
          
            $cneg = $condiciones['dias_cred'];
           
            $fecha_vencimiento = $facturas_vencidas[$j]['fec_venc']->format('Y-m-d');
            $f_r = '2011-11-11';
           if(!empty($idRegistroFacura)){

               $facturaRecibido = $pedidos[$idRegistroFacura];                

                $f_r = $facturaRecibido['fecha_recibido'];
               $fec_recibido = date_create($facturaRecibido['fecha_recibido']);
                        
               date_add($fec_recibido, date_interval_create_from_date_string($cneg.' days'));
               $fecha_vencimiento =  date_format($fec_recibido, 'Y-m-d');

           }
            $desde_limite = new DateTime($desde." 00:00:00");
            $hasta_limite = new DateTime($hasta." 00:00:00");
            $entro = "NO";

            $doc_feha = new DateTime($fecha_vencimiento);

            if ($desde_limite <= $doc_feha and $hasta_limite >= $doc_feha) {
               /*$entro = "SI";*/
            }else{
               unset($facturas_vencidas[$j]);
            } 
      }
      $facturas_vencidas =  array_values($facturas_vencidas);

      $facturas = array_merge($facturas, $facturas_vencidas);      
      /* FIN INGRESAR DOCUMENTOS ANTES DE LA FECHA INICIAL DEL RANGO QUE ESTEN CANCELNDOCE */
  
     /* PARAMETROS ARBITRARIOS SI UNA FECHA NO COICIDE CON LOS PARAMETROS CARGADOS*/
        $lista_parametros_desfasados = array();
        $lista_parametros_desfasados = $this->getParametros('2016-12-01','2016-12-31');
        $parametros_desfasados = $lista_parametros_desfasados[12]['datos'];

        $lista_parametros = array();
        $lista_parametros = $this->getParametros($desde,$hasta);

        $gerentes = $this->getGerenteRegion(null,$desde,$hasta);

        /* VENDEDORES QUE NO PRODUCEN COMISIONES */
       // $gerentesregionales = $this->getGerentesRegional(null);
        $gerentesregionales = $this->getGerentesRegional2(null,$desde,$hasta);
        $vendedores_ex = array('','010');
        
        for ($i=0; $i < count($gerentesregionales['datos']) ; $i++) { 
          if(!empty($gerentesregionales['datos'][$i]['co_ven'])){ 
            $vendedores_ex[] = $gerentesregionales['datos'][$i]['co_ven'];
          }
        }
     
        for($i=0; $i < count( $facturas) ; $i++){
        $parametros = array();            

          if(trim($facturas[$i]['co_tipo_doc']) == "ADEL" or trim($facturas[$i]['co_tipo_doc']) == "AJNA"
            or trim($facturas[$i]['co_tipo_doc']) == "N/CR" or trim($facturas[$i]['co_tipo_doc']) == "AJNM"
             or trim($facturas[$i]['co_tipo_doc']) == "IVAN" or trim($facturas[$i]['co_tipo_doc']) == "IVAP"){

                $facturas[$i]['total_bruto'] = $facturas[$i]['total_bruto'] * -1;
                $facturas[$i]['monto_imp'] = $facturas[$i]['monto_imp'] * -1;
                $facturas[$i]['total_neto'] = $facturas[$i]['total_neto'] * -1;
                $facturas[$i]['saldo'] = $facturas[$i]['saldo'] * -1;

            }   

            $facturas[$i]['calcular'] = "NADA";
            $facturas[$i]['cneg']= ""; 
            $facturas[$i]['fVcto']= ""; 
            $facturas[$i]['noaplica']= 0; 

            $facturas[$i]['fcobro'] = ""; 
            $facturas[$i]['diascalle']= ""; 
            $facturas[$i]['cond']= ""; 

            $facturas[$i]['estado']= "X"; 
            $facturas[$i]['despacho']= ""; 

            $facturas[$i]['fecha_despacho']= ""; 
            $facturas[$i]['dias_cred']= ""; 

            $facturas[$i]['comision']=0; 
            $facturas[$i]['reserva'] = 0; 
            $facturas[$i]['porcentaje'] = 0; 
            $facturas[$i]['porcentajeR'] = 0; 

            $facturas[$i]['nro_orig'] = trim($facturas[$i]['nro_orig']);
            $facturas[$i]['co_tipo_doc'] = trim($facturas[$i]['co_tipo_doc']);

            $facturas[$i]['fec_emis'] = $facturas[$i]['fec_emis']->format('Y-m-d');
            $facturas[$i]['fec_venc'] = $facturas[$i]['fec_venc']->format('Y-m-d');
            $facturas[$i]['fec_venc_creada'] ="";
            $facturas[$i]['corte'] ="";

            /* SE BUSCA CONDICION */       

            // BUSCAMOS SI TIENE FECHA DE DESPACHO Y RECIBO 
            // BUSCAMOS SI TIENE FECHA DE DESPACHO Y RECIBO 
            
            $entra=0;

            if(trim($facturas[$i]['co_tipo_doc']) == 'FACT'){

                $saldor = $this->getSaldoReal(trim($facturas[$i]['nro_orig']),$facturas[$i]['total_neto'],$desde,$hasta,trim($facturas[$i]['co_cli']));

                $facturas[$i]['saldo'] = $saldor;

                $mes_doc =  date("m", strtotime($facturas[$i]['fec_emis']));
                $mes_doc = (int)$mes_doc;

                $cann = $lista_parametros[$mes_doc]['cortes'];
                if ($cann == 1) {
                    $parametros = $lista_parametros[$mes_doc]['datos'];
                    $facturas[$i]['corte'] = "unico";
                    $entra = 1;
                }else{
                    
                    for ($l=0; $l <  $cann ; $l++) {    
                      /* comparamos fecha */
                        $fecha_desde = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['desde']);
                        $fecha_hasta = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['hasta']);
                        $fecha_emision = new DateTime($facturas[$i]['fec_emis']);

                        if($fecha_emision >= $fecha_desde and $fecha_emision <= $fecha_hasta){
                             $parametros = $lista_parametros[$mes_doc]['datos'][$l];
                             $entra = 1;
                             $facturas[$i]['corte'] = $l;
                        }
                    }
                     
                }

                if(count($parametros) == 0){
                    $facturas[$i]['corte'] = 'NO';
                     $parametros = $parametros_desfasados;
                }

                /* ELIMINAMOS LOS PARAMETROS DE DESDE Y HASTA YA QUE NO SE USARAN */
                unset($parametros['datos'][0]['desde'],$parametros['datos'][0]['hasta']);

                $condiciones = $this->condicionTipoDefactura($facturas[$i]['nro_orig']);
                $facturas[$i]['cond']= $condiciones['cond'];  

                /* BUSCAMOS EN LA PRE CARGA SI EXISTE LA FACTURA CON FECHA RECIBIDO */
                $idRegistroFacura = array_search(trim($facturas[$i]['nro_orig']),$nfacturas);             

                 if(!empty($idRegistroFacura)){
                    $facturas[$i]['estado']="SALDO";

                    //SALDO INICIAL PARA CALCULAR
                    $saldoCero = $parametros[0];
                    $idvend = array_search(trim($facturas[$i]['co_ven']),$vendedores_ex); 

                    if($idvend == FALSE){
                         $facturas[$i]['noaplica']= 1; 
                    }
                       /* SE BUSCA ULTIM FECHA DE COBRO */            
                       $nfcobro = $this->fechaCobrofactura(trim($facturas[$i]['co_cli']), trim($facturas[$i]['nro_orig']),$desde,$hasta);
                        $fcobro = "";
                       if (!empty($nfcobro)) {
                         $fcobro = date_format(date_create($nfcobro),'d/m/Y');
                       }                                      
                                       
                        $facturas[$i]['dias_cred'] = $condiciones['dias_cred'];
                        $facturas[$i]['cneg'] =  $condiciones['dias_cred'];                        
                        $facturaRecibido = $pedidos[$idRegistroFacura]; 

                        $cneg = $condiciones['dias_cred'];
                        $facturas[$i]['cond']= $condiciones['cond'];  

                        /* CREAMOS FECHA DE VENCIMIENTO SEGUN MODO DE CREDITO Y FECHA EMISION*/
                        $facturas[$i]['fec_venc_creada'] = $facturas[$i]['fec_emis'];
                       
                        $fec_venc_creada = date_create($facturas[$i]['fec_venc_creada']);
                        date_add($fec_venc_creada, date_interval_create_from_date_string($cneg.' days'));
                         $facturas[$i]['fec_venc_creada'] = date_format($fec_venc_creada, 'Y-m-d');

                        $fec_recibido = date_create($facturaRecibido['fecha_recibido']);
                        
                        date_add($fec_recibido, date_interval_create_from_date_string($cneg.' days'));
                        $fVcto=  date_format($fec_recibido, 'd/m/Y');
                        $nfVcto=  date_format($fec_recibido, 'Y-m-d');

                        /*SE CALCULAN LOS DIAS CALLE */
                        $diascalle = "?";
                        if (!empty($fcobro)) {
                            //$fecha1 = new DateTime($facturaRecibido['fecha_recibido']);
                            $fecha1 = new DateTime($nfVcto);
                            $fecha2 = new DateTime($nfcobro);
                            $fecha = $fecha1->diff($fecha2);
                            $diascalle =  $fecha->format('%a') + $facturas[$i]['dias_cred'];                      
                        }
                        $fec_emis = strtotime( $facturas[$i]['fec_emis'] );
                        $fec_venc = strtotime( $facturas[$i]['fec_venc'] );
                        $fec_emis = date ("Y-m-d",$fec_emis );
                        $fec_venc = date ("Y-m-d",$fec_venc );

                        $fec_emis = date_format(date_create($fec_emis),'d/m/Y');
                        $fec_venc = date_format(date_create($fec_venc),'d/m/Y');

                        $facturas[$i]['fec_venc_creada'] =  date_format(date_create($facturas[$i]['fec_venc_creada']),'d/m/Y');

                        if($facturaRecibido['fecha_despacho']!="0000-00-00"){
                             $fec_desp = date_format(date_create($facturaRecibido['fecha_despacho']),'d/m/Y');
                             $facturas[$i]['fecha_despacho']= $fec_desp; 
                        }
                       
                        $fec_recip = date_format(date_create($facturaRecibido['fecha_recibido']),'d/m/Y');
                        $facturas[$i]['fecha_recibido']= $fec_recip; 
                        $facturas[$i]['diascalle']= $diascalle; 

                        $facturas[$i]['fec_emis']= $fec_emis;                       
                        $facturas[$i]['fec_venc']= $fec_venc; 

                        $facturas[$i]['fcobro']= $fcobro; 
                        $facturas[$i]['fVcto']= $fVcto;                         

                    if($facturas[$i]['saldo'] <= $saldoCero['limite1'] and $idvend == FALSE){

                        $facturas[$i]['estado']="Calcular";                       
                                 
                        $datos = array(
                          'co_seg'=> $facturas[$i]['co_seg'],
                          'co_ven'=> $facturas[$i]['co_ven'],
                          'condicion'=>$condiciones['cond'],
                          'saldo_factura'=>0,
                          'diascalle'=> $diascalle,
                          'total_bruto'=>$facturas[$i]['total_bruto'],
                          'fVencimiento'=>$facturas[$i]['fec_venc_creada'],
                          'fcobro'=>$fcobro,
                          'cneg'=> $condiciones['dias_cred']
                        );
                        
                        $nComision = $this->calculoBasico2($datos,$parametros);
                        $facturas[$i]['estado']="Calcular";             
                        $facturas[$i]['comision']=$nComision['comision']; 

                        $facturas[$i]['porcentaje']=$nComision['porcentaje']; 
                        $facturas[$i]['porcentajeR']=$nComision['porcentajeR']; 
                        $facturas[$i]['reserva']=$nComision['reserva'];                   
                    }else{
                        /* Saldo mayor a cero*/
                 
                    }
                }else{
                     $fec_emis = date_format(date_create($facturas[$i]['fec_emis']),'d/m/Y');
                      $fec_venc = date_format(date_create($facturas[$i]['fec_venc']),'d/m/Y');
                      $facturas[$i]['fec_emis'] =$fec_emis;
                      $facturas[$i]['fec_venc'] = $fec_venc;
                      $facturas[$i]['dias_cred'] = "";
                }                
            }else{
              /* DOCUMENTOS NO FACTURAS */
                 $fec_emis = date_format(date_create($facturas[$i]['fec_emis']),'d/m/Y');
                  $facturas[$i]['fec_emis'] =$fec_emis;
                  $facturas[$i]['fec_venc'] = "";
                  $facturas[$i]['dias_cred'] = "";
                  $facturas[$i]['fecha_despacho'] = trim($facturas[$i]['co_tipo_doc']);
                  $facturas[$i]['fecha_recibido'] = trim($facturas[$i]['nro_doc']);
                  $facturas[$i]['fec_venc_creada'] = trim($facturas[$i]['nro_orig']);
  
            }
      }

       for ($i=0; $i < count( $facturas) ; $i++){
            if(trim($facturas[$i]['co_tipo_doc']) == 'N/CR'){
          /*
                $com_ncr = $this->buscarFacturaNCR(trim($facturas[$i]['nro_orig']),'FACT',$facturas);

                if ($com_ncr['resultado']=='si') {

                  $factura_detalle = $facturas[$com_ncr['lugar']];
                    $facturas[$i]['porcentaje'] =  $factura_detalle['porcentaje'];
                    $facturas[$i]['diascalle'] =  $factura_detalle['diascalle'];
                  if (!empty(trim($factura_detalle['comision']))) {
                   
                    $comisionNCR = ($factura_detalle['porcentaje'] * $facturas[$i]['total_bruto']) / 100;

                    $comisionNCRR =  ($factura_detalle['porcentajeR'] * $facturas[$i]['total_bruto']) / 100;;

                    $facturas[$i]['comision'] =  $comisionNCR ;

                    $facturas[$i]['reserva'] =   $comisionNCRR ;
                    $facturas[$i]['porcentajeR'] =   $factura_detalle['porcentajeR'];
                   
                  }                
                }
                */  
                            
                $com_ncr = $this->getCalculoNCR_NDB(trim($facturas[$i]['fecha_recibido']),
                $facturas[$i]['total_bruto'],trim($facturas[$i]['co_tipo_doc']),$desde,$hasta);
                                    
                $facturas[$i]['fcobro'] =  $com_ncr['cobro'];
                $facturas[$i]['diascalle'] =  $com_ncr['diascalle'];
                $facturas[$i]['fec_venc'] =  $com_ncr['factura'];

                $facturas[$i]['comision'] = $com_ncr['comision'] ; 
                $facturas[$i]['porcentaje'] =  $com_ncr['porcentaje'];

                $facturas[$i]['reserva'] =   $com_ncr['comisonReserva'] ; 
                $facturas[$i]['porcentajeR'] =   $com_ncr['porcentaje_reserva'];    

            }
        }    

      for ($b=0; $b < count($facturas); $b++) { 
        $encontrado = $this->buscar($facturas,$facturas[$b]['nro_orig'],$facturas[$b]['co_tipo_doc']);
        $facturas[$b]['enc'] = $encontrado['veces'];
         $facturas[$b]['pos'] = $encontrado['posicion'];

        if ( $encontrado['veces'] > 1 and ($facturas[$b]['co_tipo_doc']=="N/CR" or $facturas[$b]['co_tipo_doc']=="FACT" )) {
           unset($facturas[$encontrado['posicion']]);
            $facturas=  array_values($facturas);
        }
      }

      /* MODIFICAR DOCUMENTO ORIGEN DE  N/CR*/
      $cant = count($facturas);
      for ($b=0; $b < $cant; $b++) { 
       // $facturas[$b]['fecha_recibido'] = "";
        if ($facturas[$b]['co_tipo_doc'] == "N/CR" and $facturas[$b]['fec_venc'] != 0) {
            $facturas[$b]['nro_orig'] = $facturas[$b]['fec_venc'];         
           
        }
        if ($facturas[$b]['co_tipo_doc'] == "N/CR" and $facturas[$b]['fec_venc'] == 0) {
            $facturas[$b]['nro_orig'] = 0;            
        }
      }
    
      return $facturas;
      /* FINAlizado - LLENADO DE DATOS */

    }
    public function condicionTipoDefactura($idfactura){

        $conn = conectarSQlSERVER();
        $sel="
        SELECT
            dbo.fechasimple(DC.fec_emis) as fec_emis,
            dbo.fechasimple(DC.fec_venc) as fec_venc,
            P.cli_des,
            TP.descrip,
            TP.tipo_mov,
            CP.dias_cred,
            CP.co_cond as cond,
            CP.cond_des as condision,
            ZN.zon_des as zona
        FROM
                saDocumentoVenta AS DC
                INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                INNER JOIN saVendedor  AS VEN ON DC.co_ven = VEN.co_ven
                INNER JOIN saZona  AS ZN ON VEN.co_zon=ZN.co_zon
                LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
                INNER JOIN saFacturaVenta AS FV ON FV.doc_num = DC.nro_doc
             INNER JOIN saCondicionPago  AS CP ON CP.co_cond = FV.co_cond
        WHERE
            DC.nro_doc >= '".$idfactura."' AND  DC.nro_doc <= '".$idfactura."'

        ORDER BY
        DC.nro_doc";

        $result=sqlsrv_query($conn,$sel);
        $monto=0;
        $saldo = array();
        if($result){
            $row=sqlsrv_fetch_array($result);
            $saldo = array(
                "cli_des"=> $row['cli_des'],
                "cond"=> $row['cond'],
                "condision"=> $row['condision'],
                "dias_cred"=> $row['dias_cred'],
                "zona"=> $row['zona']
            );
        }
        sqlsrv_free_stmt($result);
        return $saldo;
    }
    /* presupuesto region total*/
    public function getPresupuestoRegionalyVentas($zonas,$desde,$hasta) {
        $vendes = $this->getvededoresZona($zonas);

        $co_vens = "";
        for($x=0;$x < count($vendes); $x++){
           $co_vens.="'".$vendes[$x]['co_ven']."',";
        }

        $co_vens = substr($co_vens, 0, -1);

        $co_zonas = "";
        for($x=0;$x < count($zonas); $x++){
           $co_zonas.="'".$zonas[$x]."',";
        }

        $co_zonas = substr($co_zonas, 0, -1);

        $pres ="

    SELECT sum(presupuesto) as total FROM(
        SELECT * FROM `cmspresupuestovendedor` where co_ven in (".$co_vens.") and desde >='".$desde."'  and hasta >='".$hasta."'

        union all
        SELECT * FROM `cmspresupuestovendedor` where co_ven in ('VACANTE') and zona in(".$co_zonas.")
        and desde >='".$desde."'  and hasta >='".$hasta."'
        ) a
    ";
        $conn = $this->getConMYSQL() ;      
        $rs = mysqli_query($conn,$pres) or die(mysqli_error($conn));

        $linea=mysqli_fetch_array($rs);

        $datos = array(
            'total_presupuesto'=>0,
            'total_ventas'=>0
        );

        $total_presupuesto = $linea[0];
        $total_ventas = $this->facturaRegionFecha($co_vens,$desde,$hasta);
        $datos = array(
            'total_presupuesto'=>$total_presupuesto,
            'total_ventas'=>$total_ventas['monto_base']
        );
        return $datos;

    }
    /* presupuesto vendedor total*/
    public function getPresupuestoyVentasVendedor($co_ven,$desde,$hasta) {
        $vendes = $this->getvededoresZona($zonas);

        $pres ="
    SELECT sum(presupuesto) as total FROM(
        SELECT * FROM `cmspresupuestovendedor` where co_ven in (".$co_ven.") and desde >='".$desde."'  and hasta >='".$hasta."'

        union all
        SELECT * FROM `cmspresupuestovendedor` where co_ven in ('VACANTE') and zona in(".$co_zonas.")
        and desde >='".$desde."'  and hasta >='".$hasta."'
        ) a
    ";
        $conn = $this->getConMYSQL() ;      
        $rs = mysqli_query($conn,$pres) or die(mysqli_error($conn));

        $linea=mysqli_fetch_array($rs);

        $datos = array(
            'total_presupuesto'=>0,
            'total_ventas'=>0
        );

        $total_presupuesto = $linea[0];
        $total_ventas = $this->facturaRegionFecha($co_vens,$desde,$hasta);
        $datos = array(
            'total_presupuesto'=>$total_presupuesto,
            'total_ventas'=>$total_ventas['monto_base']
        );
        return $datos;

    }
    //Entrega listado de vendedores segun zona
    public function getvededoresZona($zonas) {

      $datos = array();
      if(count($zonas)>0){
        $cod_zonas = "";
        for($x=0;$x < count($zonas); $x++){
          $cod_zonas.="'".$zonas[$x]."',";
        }
        $cod_zonas = substr($cod_zonas, 0, -1);

        $sel = "select ven.co_ven,  ven.ven_des,  ven.co_zon,  zn.zon_des
         from saVendedor  as ven
        inner join saZona as zn on ven.co_zon = zn.co_zon
        where zn.zon_des in(".$cod_zonas.") order by zn.zon_des";

        $i=0;
        $conn = conectarSQlSERVER();
            $result=sqlsrv_query($conn,$sel);

            while($row=sqlsrv_fetch_array($result)){
                    foreach($row as $key=>$value){
                        $datos[$i][$key]=$value;
                    }
                    $i++;
                }
        sqlsrv_free_stmt($result);
      }
        return($datos);
    }
    public function getSaldoRealPrueba($no_doc,$total,$desde,$hasta) {

   
        $sel = "select sum(mont_cob) from saCobroDocReng as sc 
            inner join saCobro  as cd on cd.cob_num=sc.cob_num
             where sc.nro_doc='".$no_doc."' and  cd.anulado=0 and 
            sc.fe_us_in <= '".$hasta."'";
 

       
        $conn = conectarSQlSERVER();
            $result=sqlsrv_query($conn,$sel);

            while($row=sqlsrv_fetch_array($result)){
                   $cobros = $row[0];
                }
        sqlsrv_free_stmt($result);
         $saldor =  $total - $cobros;
        return $saldor;
    }
    public function getSaldoReal($no_doc,$total,$desde,$hasta,$co_cli) {
      /*
     SELECT
          *
      FROM
          ( SELECT
              '0' AS numero, Pa.fecha, P.co_cli AS co_prov, P.cli_des AS prov_des, P.rif, P.nit, P.fax, Pa.cob_num, Pa.co_mone, Pa.descrip, PR.reng_num AS reng_doc, PR.co_tipo_doc,
              PR.nro_doc, '' AS nro_fact, PR.mont_cob, '' AS forma_pag, '' AS num_doc, '' AS num_cta, NULL AS fecha_che,
              0.00 AS mont_doc, '' AS codigo, '' AS descripcion, '' AS co_ban, '' AS des_ban, TP.tipo_mov
            FROM
              saCobro AS Pa
              INNER JOIN saCobroDocReng AS PR ON PR.cob_num = Pa.cob_num
                                                 AND Pa.anulado = 0
              INNER JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = PR.co_tipo_doc
              INNER JOIN saCliente AS P ON P.co_cli = Pa.co_cli
            WHERE
               P.co_cli  ='2533083'    
            UNION ALL
            SELECT
              '1' AS numero, Pa.fecha, P.co_cli AS co_prov, P.cli_des AS prov_des, P.rif, P.nit, P.fax, Pa.cob_num, Pa.co_mone, Pa.descrip, PT.reng_num AS reng_doc, '' AS co_tipo_doc,
              '' AS nro_doc, '' AS nro_fact, 0.00 AS mont_cob, PT.forma_pag, PT.num_doc, C.num_cta, PT.fecha_che,
              PT.mont_doc, 
      case when Pt.forma_pag ='DP' then isnull(C.cod_cta, '') else  CJ.cod_caja  end AS codigo, 
      case when Pt.forma_pag ='DP' then isnull(C.num_cta, '') else CJ.descrip end AS descripcion, 
      case when pt.forma_pag= 'CH' then ISNULL(B.co_ban, '') else (case when PT.forma_pag='TJ' then ISNULL(TC.co_tar, '')end)end AS co_ban,
              case when pt.forma_pag ='CH' then ISNULL(B.des_ban, '') else (case when PT.forma_pag='TJ' then ISNULL(tc.des_tar, '')end)end AS des_ban, '' AS tipo_mov
            FROM
              saCobro AS Pa
              INNER JOIN saCobroTPReng AS PT ON Pa.cob_num = PT.cob_num
                                                AND Pa.anulado = 0
              LEFT JOIN saCuentaBancaria AS C ON C.cod_cta = PT.cod_cta
              LEFT JOIN saCaja AS CJ ON CJ.cod_caja = PT.cod_caja
              LEFT JOIN saBanco AS B ON PT.co_ban = B.co_ban
      LEFT JOIN saTarjetaCredito TC ON pt.co_tar=tc.co_tar
              INNER JOIN saCliente AS P ON P.co_cli = Pa.co_cli
            WHERE
             P.co_cli  ='2533083'  
            ) AS A
      ORDER BY
          A.cob_num, A.numero

       */
   
        $sel = "select sum(mont_cob) from saCobroDocReng as sc 
            inner join saCobro  as cd on cd.cob_num=sc.cob_num
             where sc.nro_doc='".$no_doc."'
      and  cd.co_cli='".$co_cli."' 
              and  cd.anulado=0 and 
            sc.fe_us_in <= '".$hasta."'";
       
       $sel1 = "select * from saCobroDocReng as sc 
            inner join saCobro  as cd on cd.cob_num=sc.cob_num
             where sc.nro_doc='".$no_doc."'
              and  cd.co_cli='".$co_cli."' 
              and  cd.anulado=0 and 
            sc.fe_us_in <= '".$hasta."'";
      // echo $sel."<br><br>";
       //echo $sel1."<br><br>";

        $conn = conectarSQlSERVER();
            $result=sqlsrv_query($conn,$sel);

            while($row=sqlsrv_fetch_array($result)){
                   $cobros = $row[0];
                }
        sqlsrv_free_stmt($result);
         $saldor =  $total - $cobros;
        return $saldor;
    }
    //ENTREGA COBRO DE ZONAS
    public function getCobrosZonas($zonas,$desde,$hasta) {
        $total = 0;
      $datos = array();



      if(count($zonas)>0){
		$conn = conectarSQlSERVER();
        $cod_zonas = "";
        for($x=0;$x < count($zonas); $x++){

            /* codigo zona */
            $nombre_zona = trim($zonas[$x]);
            $sq = "select co_zon from saZona where zon_des='".$nombre_zona."'";
            $result = sqlsrv_query($conn,$sq);
            $linea = sqlsrv_fetch_array($result);
            $cod_zonas.="'".$linea[0]."',";
        }
        $cod_zonas = substr($cod_zonas, 0, -1);

        $sel = "SELECT
            P.cob_num, P.fecha, P.co_cli, PV.cli_des, PT.forma_pag, PT.reng_num, P.anulado, p.co_mone, PR.num_doc,
            PT.cod_caja, C.descrip, PT.cod_cta, CB.num_cta, P.monto / ( CASE WHEN '' IS NULL THEN 1
                                                                             ELSE P.tasa
                                                                        END ) * CASE WHEN P.anulado = 1 THEN 0
                                                                                     ELSE 1
                                                                                END AS monto,
            PT.mont_doc / ( CASE WHEN '' IS NULL THEN 1
                                 ELSE P.tasa
                            END ) * CASE WHEN P.anulado = 1 THEN 0
                                         ELSE 1
                                    END AS mont_doc, CASE WHEN PT.cod_caja IS NULL THEN PT.cod_cta
                                                          ELSE PT.cod_caja
                                                     END AS cuenta, CASE WHEN PT.cod_caja IS NULL THEN CB.num_cta
                                                                         ELSE C.descrip
                                                                    END AS descripcion, '' AS subtotal
        FROM
            saCobro AS P
            INNER JOIN saCobroDocReng AS PR ON P.cob_num = PR.cob_num
            INNER JOIN saCobroTPReng AS PT ON PR.cob_num = PT.cob_num
            INNER JOIN saCliente AS PV ON P.co_cli = PV.co_cli
            LEFT JOIN saCaja AS C ON PT.cod_caja = C.cod_caja
            LEFT JOIN saCuentaBancaria AS CB ON PT.cod_cta = CB.cod_cta
        WHERE
           dbo.FechaSimple(P.fecha) >= '".$desde."'
             AND dbo.FechaSimple(P.fecha) <= '".$hasta."'            
            AND PV.co_zon IN(".$cod_zonas.")        
            AND  P.anulado =0

        GROUP BY
            P.cob_num, PT.reng_num, P.fecha, P.co_cli, P.co_sucu_in, PV.cli_des, PT.cod_cta, CB.num_cta, PT.cod_caja,
            C.descrip, PT.forma_pag, PR.num_doc, P.co_mone, P.monto, PT.mont_doc,
            P.anulado, P.tasa";

        $i=0;
        $conn = conectarSQlSERVER();
    		$result=sqlsrv_query($conn,$sel);

    		while($row=sqlsrv_fetch_array($result)){
    				foreach($row as $key=>$value){
    					$datos[$i][$key]=$value;
    				}
    				$i++;
    			}

        sqlsrv_free_stmt($result);
        $total = 0;
        for ($y=0; $y  < count($datos) ; $y++) { 
             $total+= $datos[$y]['mont_doc'];
        }
      }
  		return $total;
    }    
	
	//ENTREGA COBRO DE vendedores
    public function getCobrosVendedor($co_vens,$desde,$hasta) {
       
	   $total = 0;
		$datos = array();



      if(count($co_vens)>0){
		$conn = conectarSQlSERVER();
         $cod_ven = "";
            for($x=0;$x < count($co_vens); $x++){
              $cod_ven.="'".$co_vens[$x]['co_ven']."',";
            }
            $cod_ven = substr($cod_ven, 0, -1);
		
   

        $sel = "
	
        SELECT
            P.cob_num, P.fecha, P.co_cli, PV.cli_des, PT.forma_pag, V.co_ven, V.ven_des, PT.reng_num, P.anulado,
            p.co_mone, PR.num_doc, PT.cod_caja, C.descrip, PT.cod_cta, CB.num_cta,
            P.monto / ( CASE WHEN '' IS NULL THEN 1
                             ELSE P.tasa
                        END ) * CASE WHEN P.anulado = 1 THEN 0
                                     ELSE 1
                                END AS monto, PT.mont_doc / ( CASE WHEN '' IS NULL THEN 1
                                                                   ELSE P.tasa
                                                              END ) * CASE WHEN P.anulado = 1 THEN 0
                                                                           ELSE 1
                                                                      END AS mont_doc,
            CASE WHEN PT.cod_caja IS NULL THEN PT.cod_cta
                 ELSE PT.cod_caja
            END AS cuenta, CASE WHEN PT.cod_caja IS NULL THEN CB.num_cta
                                ELSE C.descrip
                           END AS descripcion, '' AS subtotal
        FROM
            saCobro AS P
            INNER JOIN saCobroDocReng AS PR ON P.cob_num = PR.cob_num
            INNER JOIN saCobroTPReng AS PT ON PR.cob_num = PT.cob_num
            INNER JOIN saCliente AS PV ON P.co_cli = PV.co_cli
            INNER JOIN saVendedor AS V ON v.co_ven = P.co_ven
            LEFT JOIN saCaja AS C ON PT.cod_caja = C.cod_caja
            LEFT JOIN saCuentaBancaria AS CB ON PT.cod_cta = CB.cod_cta
        WHERE        
           P.co_ven in(".$cod_ven.")
		   AND P.anulado=0
		   AND dbo.FechaSimple(P.fecha) >= '".$desde."'
                 
            AND dbo.FechaSimple(P.fecha) <= '".$hasta."'
  
        GROUP BY
            P.cob_num, PT.reng_num, P.fecha, P.co_cli, P.co_sucu_in, PV.cli_des, PT.cod_cta, CB.num_cta, PT.cod_caja,
            C.descrip, PT.forma_pag, PR.num_doc, P.co_mone, P.monto, PT.mont_doc,
            CASE WHEN P.co_mone = '' THEN 1
                 ELSE P.tasa
            END, P.anulado, P.tasa, V.co_ven, V.ven_des";

        $i=0;
        $conn = conectarSQlSERVER();
    		$result=sqlsrv_query($conn,$sel);

    		while($row=sqlsrv_fetch_array($result)){
    				foreach($row as $key=>$value){
    					$datos[$i][$key]=$value;
    				}
    				$i++;
    			}

        sqlsrv_free_stmt($result);
        $total = 0;
        for ($y=0; $y  < count($datos) ; $y++) { 
             $total+= $datos[$y]['mont_doc'];
        }
      }
  		return $total;
    }
    //Entrega listado de zonas de un gerente regional
    public function getZonasGerernte($region) {
      $datos = array();
      if(count($region)>0){
     

      $conn = $this->getConMYSQL() ;
        $sel ="
        SELECT zona FROM `cmszonagerencia`
         WHERE `cmsRegion_id` = '".$region."' ORDER BY `cmsRegion_id` ASC ";
          $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));


          $i=0;
          while($row=mysqli_fetch_array($rs)){

            $datos[] = $row['zona'];

            $i++;
          }
        }
          return($datos);
    }
    //Entrega listado de zonas de un gerente regional
    public function getTotalVendoresZona($vendedores,$inicio,$final){
        /* Zonas filtradas que no apareceran en los totales : 010*/     

         $datos = array();
        if(count($vendedores)>0){
          /* SE QUITAN LOS CODIGOS CLAVES EN LAS FACTURAS*/

          $cod_clave ="";
          $cuentasClaves = $this->getCuentasClaves('01',null);


          for($x=0;$x < count($cuentasClaves); $x++){
              $cod_clave.="'".$cuentasClaves[$x]['co_ven']."',";
            }
            $cod_clave = substr($cod_clave, 0, -1);

            $cod_ven = "";
            for($x=0;$x < count($vendedores); $x++){
              $cod_ven.="'".$vendedores[$x]['co_ven']."',";
            }
            $cod_ven = substr($cod_ven, 0, -1);

              $sel ="
              select ven.co_ven,sum(fc.total_bruto) as bruto,ven.ven_des, zn.zon_des as zona   from
              saVendedor as ven left join saFacturaVenta as fc
               on (ven.co_ven=fc.co_ven and fc.fec_emis >='".$inicio."' and fc.fec_emis <='".$final."' and fc.anulado=0)
                 inner join saZona as zn on ven.co_zon= zn.co_zon
              where ven.co_ven in (".$cod_ven.") 
              and ven.co_ven NOT IN(".$cod_clave.",'010')
              group by ven.co_ven,ven.ven_des,zn.zon_des
               order by ven.ven_des ";
         
                $datos = array();
                $i=0;
                $conn = conectarSQlSERVER();
                $result=sqlsrv_query($conn,$sel);

                while($row=sqlsrv_fetch_array($result)){
                    foreach($row as $key=>$value){
                      $datos[$i][$key]=$value;
                    }
                    $i++;
                  }
                sqlsrv_free_stmt($result);
          }
         
          return($datos);
    }  

    
    //Entrega listado de zonas de un gerente regional
    public function getGerenteRegion($region,$desde,$hasta){
        $conn = $this->getConMYSQL() ;

        /*  BUSCAMOS GERENTES ACTIVOS */
        $sel="SELECT * FROM cmsgerenteregional AS GR
            INNER JOIN cmsvendedoresactividad AS VA ON GR.co_ven=VA.co_ven
            INNER JOIN cmsregion AS r ON r.id=GR.cmsRegion_id
            where VA.estatus='Activo'
            and VA.tipo='Gerente' ";

        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));       

        $va = array();
        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $va[$i][$key]=$value;
          }
          $i++;
        }
        $res_array = array();

        if(count($va)>0){
          $cod_va = "";
          for($x=0;$x < count($va); $x++){
            $cod_va.="'".$va[$x]['co_ven']."',";
          }
          $cod_va = substr($cod_va, 0, -1);

          /* BUSCAMOS GERENTES DE LA REGION */
          $sel="SELECT * FROM `cmsgerenteregional` as gr where co_ven in(".$cod_va.")";
              if (!empty($region)) {
                  $sel.="  and  gr.`cmsRegion_id` = '".$region."'";
              }
                
          // $conn = conectarLocal('grupopro_cms');
          
            $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
            

            $i=0;
            while($row=mysqli_fetch_array($rs)){
              foreach($row as $key=>$value){
                $res_array[$i][$key]=$value;
              }
              $i++;
            }
          }
          return $res_array;
    }

    //formatea numero de "34.650,50" a "34650.50"
  public function formato($numero){
    $nNumero = trim($numero);
    $nNumero = str_replace(".", "", $numero);
    $nNumero = str_replace(",", ".", $nNumero);
    return $nNumero;
  }
  public function editarMetaRegional($campos){
    $presupuesto =  $this->formato($campos['presupuesto']);
    $sel="
      UPDATE `cmspresupuestoregional` SET
      `desde`='".$campos['desde']."',
      `hasta`='".$campos['hasta']."',
      `presupuesto`='".$presupuesto."',
      `fech_mod`=CURRENT_TIME() WHERE `id`='".$campos['idm']."'";
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel);
      $msn = array(
        'error'=>'si'
      );

      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);

      }else{
        $msn = array(
          'error'=>'no',
        );
        $this->setMensajes('success','Meta regional editada');
      }
      return $msn;
  }
  public function editarMetaVendedor($campos){
    $presupuesto =  $this->formato($campos['presupuesto']);
    $sel="
      UPDATE `cmspresupuestovendedor` SET
      `desde`='".$campos['desde']."',
      `hasta`='".$campos['hasta']."',
      `presupuesto`='".$presupuesto."',
      `fech_mod`=CURRENT_TIME() WHERE `id`='".$campos['idm']."'";
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel);
      $msn = array(
        'error'=>'si'
      );

      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);

      }else{
        $msn = array(
          'error'=>'no',
        );
        $this->setMensajes('success','Meta de vendedor editada');
      }
      return $msn;
  }  
  public function editarMetaClave($campos){
    $presupuesto =  $this->formato($campos['presupuesto']);
    $sel="
      UPDATE `cmspresupuestoclave` SET
      `desde`='".$campos['desde']."',
      `hasta`='".$campos['hasta']."',
      `presupuesto`='".$presupuesto."',
      `fecha_mod`=CURRENT_TIME() WHERE `id`='".$campos['idm']."'";
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel);
      $msn = array(
        'error'=>'si'
      );

      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);

      }else{
        $msn = array(
          'error'=>'no',
        );
        $this->setMensajes('success','Meta de clave editada');
      }
      return $msn;
  }
  function trim_value(&$value) 
{ 
    $value = trim($value); 
}
  public function registrarComisionesUno($desde,$hasta,$factura){

    $usuario = $_SESSION['usuario'];
    $registrados = 0;
    $conn = $this->getConMYSQL() ;

    for ($x=0; $x < count($factura) ; $x++) {

       if((trim($factura[$x]['co_tipo_doc']) == 'FACT' or trim($factura[$x]['co_tipo_doc']) == 'N/CR' or trim($factura[$x]['co_tipo_doc']) == 'N/DB')
         and $factura[$x]['comision'] != 'X'){          

          $fec_venc_creada="";
          $fec_emis="";
          $fcobro="";
          $diascalle= null ;
                
        
            if ( trim($factura[$x]['diascalle']) == '?') {
              $diascalle=null;
            }else{
              if (is_numeric($factura[$x]['diascalle'])) {
                $diascalle = $factura[$x]['diascalle'];
              }
            }
         
          if (!empty($factura[$x]['fec_venc_creada']) and strlen($factura[$x]['fec_venc_creada'])==10) {
            $fec_venc_creada = trim($factura[$x]['fec_venc_creada']);   
           $f = explode("/", $fec_venc_creada);
            $fec_venc_creada = $f[2]."-".$f[1]."-".$f[0];
          }

          if (!empty(trim($factura[$x]['fec_emis'])) and strlen($factura[$x]['fec_emis'])==10) {
            $fec_emis = trim($factura[$x]['fec_emis']);
            $f = explode("/", $fec_emis);
            $fec_emis = $f[2]."-".$f[1]."-".$f[0];
          }
          if (!empty(trim($factura[$x]['fcobro'])) and strlen($factura[$x]['fcobro'])==10) {
            $fcobro = trim($factura[$x]['fcobro']);
            $f = explode("/", $fcobro);
            $fcobro = $f[2]."-".$f[1]."-".$f[0];
         }

         $bus = "SELECT * FROM `cmshistorialuno`
          WHERE `factura` = '".trim($factura[$x]['nro_orig'])."' 
          and documento='".trim($factura[$x]['co_tipo_doc'])."'";
          
          $rs = mysqli_query($conn,$bus) or die(mysqli_error($conn));   
          $cant = mysqli_num_rows($rs);

          if($cant == 0){

            $sel="
            INSERT INTO `cmshistorialuno`(
              `id`,
              `factura`,
              `documento`,
              `co_vende`,
              `co_cliente`,
              `fecha_venc`,
              `fech_emision`,
              `fech_cobro`,
              `diascalle`,
              `monto`,
              `condicion`,
              `porcentaje`,
              `comision`,
              `reserva`,
              `estado`,
              `creador`,
              `fech_reg`,
              `modificador`,
              `fech_mod`,
              periodo) VALUES ( 
              null, 
              '".trim($factura[$x]['nro_orig'])."',
              '".trim($factura[$x]['co_tipo_doc'])."',
              '".trim($factura[$x]['co_ven'])."',
              '".trim($factura[$x]['co_cli'])."',
              '".$fec_venc_creada."',
              '".$fec_emis."',
              '".$fcobro."', 
              '".$diascalle."', 
              '".trim($factura[$x]['total_bruto'])."', 
              '".trim($factura[$x]['cond'])."', 
              '".trim($factura[$x]['porcentaje'])."',
              '".trim($factura[$x]['comision'])."',
              '".trim($factura[$x]['reserva'])."',
              'subido',
              '".$usuario."',
              CURRENT_TIME(),
              '".$usuario."',
              CURRENT_TIME(),
              '".$hasta."');";
            
              $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
              $registrados++;
          }
        }

      }
      $msn = array(
        'error'=>'si'
      );

      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);
        $msn = array(
          'mensa'=>$mensa." - ".$sel,
        );

      }else{
        $msn = array(
          'error'=>'no',
          'registrados'=>$registrados
        );
       // $this->setMensajes('success','Facturas Registradas');
      }
      
      return $msn;
  }
  public function nuevaMetaVendedor($campos){
      $presupuesto =  $this->formato($campos['presupuesto']);
      $usuario = $_SESSION['usuario'];
      // Buscamos si ya tiene un presupuesto dentro de ese rango de tiempo
      $bus="
      SELECT * FROM `cmspresupuestovendedor` 
      WHERE `desde` >= '".$campos['desde']."' AND `hasta` <= '".$campos['hasta']."'
       AND `co_ven` = '".$campos['co_ven']."' ORDER BY `id` DESC ";

      if(!empty($campos['zona'])){
        $bus="
        SELECT * FROM `cmspresupuestovendedor` 
        WHERE `desde` >= '".$campos['desde']."' AND `hasta` <= '".$campos['hasta']."'
         AND `zona` = '".$campos['zona']."' ORDER BY `id` DESC ";
      }
      

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$bus) or die(mysqli_error($conn));
     

      $msn = array(
        'error'=>'si'
      );
        $cant = mysqli_num_rows($rs);
         //echo  $cant; exit();
        if ($cant==0) {
            $zona = "";
            if(!empty($campos['zona'])){
              $zona=$campos['zona'];
            }
           $sel = "
            INSERT INTO cmspresupuestovendedor
            (`id`, `desde`, `hasta`, `presupuesto`, `creadopor`, `co_ven`, `fech_emis`, `fech_mod`, `zona`) VALUES
            (null,'".$campos['desde']."','".$campos['hasta']."',".$presupuesto.",'".$usuario."','".$campos['co_ven']."',CURRENT_TIME(),CURRENT_TIME(),'".$zona."')";
          

            $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
          if (mysqli_errno($conn)) {
            $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
            $this->setMensajes('danger',$mensa);

          }else{
            $msn = array(
              'error'=>'no',
            );
            $this->setMensajes('success','Meta pra vendedor agregada');
          }
        }else{

             $this->setMensajes('warning','Vendedor con presupuesto ya asignado para esta fecha');
        }

      return $msn;
  }
  public function nuevaMetaRegional($campos){
      $presupuesto =  $this->formato($campos['presupuesto']);
      $usuario = $_SESSION['usuario'];
      $sel = "
        INSERT INTO cmspresupuestoregional
        (`id`, `cmsgerenteregional_id`, `desde`, `hasta`, `presupuesto`, `creadopor`, `fech_emis`, `fech_mod`) VALUES
        (null,'".$campos['region']."','".$campos['desde']."','".$campos['hasta']."',".$presupuesto.",'".$usuario."',CURRENT_TIME(),CURRENT_TIME())
      ";
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $msn = array(
        'error'=>'si'
      );

      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);

      }else{
        $msn = array(
          'error'=>'no',
        );
        $this->setMensajes('success','Meta regional agregada');
      }
      return $msn;
  }
  function getMetasRegionales($region,$idmeta,$desde,$hasta){
    $sel="
    SELECT pr.id, pr.desde, pr.hasta, pr.presupuesto, gr.nombre, gr.apellido,r.nombre as zona,r.id as co_zona
    FROM `cmspresupuestoregional` as pr
    inner join cmsgerenteregional as gr on gr.id =pr.cmsgerenteregional_id
    inner join cmsregion as r on gr.cmsRegion_id = r.id ";

    if($desde != null){
      $sel.=" where desde >='".$region."' and hasta <='".$hasta."'";
    }
    if($region!=null){
      $sel.=" and cmsgerenteregional_id='".$region."'";
    }
    if($idmeta!=null){
      $sel.=" and pr.id='".$idmeta."'";
    }
      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $regiones = array();

      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $regiones[$i][$key]=$value;
        }
        $i++;
      }

      return $regiones;
  }
  function getMetasVendedores($vendedor,$idmeta,$desde,$hasta){
    $sel="
    SELECT * FROM cmspresupuestovendedor as pv
    ";

    if($desde != null){
      $sel.=" where MONTH(pv.desde) >= MONTH('".$desde."') and MONTH(pv.hasta) <= MONTH('".$hasta."')";
    }
    if($vendedor!=null){
      $sel.=" and pv.co_ven='".$vendedor."'";
    }
    if($idmeta!=null){
      $sel.=" and pv.id='".$idmeta."'";
    }
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $regiones = array(
        0=>array('presupuesto'=>0)
      );

      $i=0;
      while($row=mysqli_fetch_array($rs)){
        $gRegionales = $this->getvendedores($row['co_ven']);
        $detalle = "";
        if(count($gRegionales)>0){
          $detalle = $gRegionales[0]['ven_des'];
        }

        foreach($row as $key=>$value){
          $regiones[$i][$key]=$value;
          $regiones[$i]["ven_des"]=  $detalle;
        }
        $i++;
      }

      return $regiones;
  } 
  function mensajesRequerimientos($desde,$hasta){
    
    $requerimientos = array();
    $conn = $this->getConMYSQL();

    $sel="SELECT * FROM `cmspresupuestoclave` 
    WHERE MONTH(`desde`)=MONTH('".$desde."') AND YEAR(`desde`)=YEAR('".$desde."')";
    
    $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
    $cant = mysqli_num_rows($rs);
    if($cant==0){
      $requerimientos[]['msn'] = "Se requiere <b>ingresar presupuesto claves</b> en este periodo para hacer los cálculos";

    }
    $sel="SELECT * FROM cmspresupuestovendedor 
WHERE MONTH(`desde`)=MONTH('".$desde."') AND YEAR(`desde`)=YEAR('".$desde."')";
    
    $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
    $cant = mysqli_num_rows($rs);
    if($cant==0){
      $requerimientos[]['msn'] = "Se requiere <b>ingresar presupuesto de vendedores</b> en este periodo para hacer los cálculos";

    }

    $sel="SELECT * FROM `cmsvendedoresactividad` 
  WHERE `desde` = '".$desde."' AND `hasta` = '".$hasta."' AND `tipo` = 'Gerente' ";
    
    $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
    $cant = mysqli_num_rows($rs);
    if($cant==0){
      $requerimientos[]['msn'] = "Se requiere <b>ingresar actividad </b> en este periodo de gerentes ";

    }
    $sel="SELECT zg.zona,r.* FROM `cmszonagerencia` as zg right join cmsregion as r on r.id = zg.cmsRegion_id";
    
    $rsr = mysqli_query($conn,$sel) or die(mysqli_error($conn));
    $cant = mysqli_num_rows($rsr);
  $regiones = array();
  
      while($row=mysqli_fetch_array($rsr)){    
      if($row[0]==null){
        $regiones[]=$row[2];
        
      }
     
      }
  $cant = count($regiones);
    if($cant > 0){
    $nRegiones = "";
    for($i=0; $i < $cant;$i++){
      $nRegiones.=$regiones[$i].",";
      
    }
      $requerimientos[]['msn'] = "<p>Hay <b> ".$cant." Regiones</b> sin zonas asignadas: ".$nRegiones.".</p> 
    <p>- Ingrese a Gerentes regionales, edite y asigne zonas</p>";
  }
    ?>
<div class="col-sm-12">
    <?php
    for ($i=0; $i < count($requerimientos); $i++) { 
      # code...
    
    ?>
    <div class="alert alert-dismissible alert-warning">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
     
      <p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
          <?php echo $requerimientos[$i]['msn']; ?>
      </p>
    </div>
    <?php
  }
      ?>
</div>
    <?php
  }
  function getMetasClaves($co_ven,$idmeta,$desde,$hasta){
    
    $sel="
    SELECT * FROM cmspresupuestoclave as pc
    ";

    if($desde != null){
      $sel.=" where MONTH(pc.desde) >=MONTH('".$desde."') and MONTH(pc.hasta) <= MONTH('".$hasta."')";
    }
    if($co_ven!=null){
      $sel.=" and pc.co_ven='".$co_ven."'";
    }
    if($idmeta!=null){
      $sel.=" and pc.id='".$idmeta."'";
    }
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $regiones = array(

        );

      $i=0;
      while($row=mysqli_fetch_array($rs)){    

        foreach($row as $key=>$value){
          $regiones[$i][$key]=$value;
        }
        $i++;
      }

      return $regiones;
  }
  function vendedoresVacantes($zonas,$desde,$hasta){
     $cod_zonas = "";
        for($x=0;$x < count($zonas); $x++){
          $cod_zonas.="'".$zonas[$x]."',";
        }
        $cod_zonas = substr($cod_zonas, 0, -1);
        $sel="
        SELECT * FROM `cmspresupuestovendedor`        
         WHERE `desde` >= '".$desde."' AND `hasta` <= '".$hasta."'
        AND `co_ven` = 'VACANTE' AND `zona` IN (".$cod_zonas.") ORDER BY `co_ven` ASC ";
      $vendedores = array();
     

      $conn = $this->getConMYSQL() ;
              $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $vendedores[$i][$key]=$value;
        }
        $i++;
      }

      return $vendedores;

  }  
  function clavesVacantes($desde,$hasta){

        $sel="
        SELECT * FROM `cmspresupuestoclave` 
        WHERE `co_ven` = 'VACANTE' 
        AND `desde` >= '".$desde."' 
        AND `hasta` <= '".$hasta."' 
        AND `vacante` = 1 ORDER BY `fecha_mod` DESC ";
     
      $vendedores = array();
     

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $vendedores[$i][$key]=$value;
        }
        $i++;
      }

      return $vendedores;

  }
  function historicoTotalesRegion($desde,$hasta){

        $sel="
       SELECT r.nombre,gr.co_ven, sum(hd.presupuesto) as presupuesto, sum(hd.ventas) as ventas FROM `cmshistorialdos` as hd 
      inner join cmshistorialgregional as gr on gr.co_ven= hd.co_grofit
      inner join cmsregion as r on r.id= gr.cmsRegion_id
      where hd.desde = '".$desde."' and hd.hasta = '".$hasta."'
      group by  r.nombre,gr.co_ven";
     
      $gerentes = array();

      $conn = $this->getConMYSQL() ;
      $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $gerentes[$i][$key]=$value;
        }
        $i++;
      }

      return $gerentes;

  }
  function add_log($user,$tipo,$accion){
     

      $conn = $this->getConMYSQL() ;
		$query = "
		INSERT INTO cmsLog (id,usuario,tipo,detalle,fecha)";
		$query .= "  VALUES (NULL,'$user','$tipo','$accion',NOW())";
		$res=mysqli_query($conn,$query) or die(mysqli_error($conn));
	}

  public function cobrosfactura2($nro_doc,$co_cli){
    $sel ="
      
        SELECT
            *
        FROM
            ( SELECT
                P.cob_num, CASE WHEN ( TP.tipo_mov = 'CR'
                                       AND DC.co_tipo_doc = 'ADEL'
                                       AND PD.mont_cob > 0.00
                                     )
                                     OR ( TP.tipo_mov = 'CR'
                                          AND DC.co_tipo_doc <> 'ADEL'
                                        ) THEN PD.mont_cob
                                ELSE 0.00
                           END * case when p.anulado=1 then 0 else 1 end AS abono, CASE WHEN ( TP.tipo_mov = 'CR'
                                                     AND DC.co_tipo_doc = 'ADEL'
                                                     AND PD.mont_cob = 0
                                                   ) THEN DC.total_neto
                                              ELSE ( CASE WHEN ( TP.tipo_mov = 'DE'
                                                                 AND DC.co_tipo_doc <> 'ADEL'
                                                               ) THEN PD.mont_cob
                                                          ELSE 0.00
                                                     END )
                                         END * case when p.anulado=1 then 0 else 1 end AS cargo, DC.total_neto, DC.nro_doc, P.co_cli as co_cli,
                PV.cli_des as cli_des, DC.co_tipo_doc, '' AS forma_pag, P.fecha, NULL AS fecha_che, TP.tipo_mov,
                'P' AS TPAGO, DC.doc_orig , p.anulado, P.descrip as deta
              FROM
                saCobro AS P
                INNER JOIN saCobroDocReng AS PD ON P.cob_num = PD.cob_num
                INNER JOIN ( SELECT
                                SUM(DC.total_neto) AS total_neto, DC.nro_doc, DC.co_tipo_doc, DC.co_cli, DC.doc_orig
                             FROM
                                saDocumentoVenta AS DC
                             GROUP BY
                                DC.co_cli, DC.co_tipo_doc, DC.nro_doc, DC.doc_orig
                           ) AS DC ON DC.nro_doc = PD.nro_doc
                                      AND DC.co_tipo_doc = PD.co_tipo_doc
                INNER JOIN sacliente AS PV ON PV.co_cli = DC.co_cli
                INNER JOIN saTipoDocumento AS TP ON PD.co_tipo_doc = TP.co_tipo_doc
              WHERE
                P.co_cli = '$co_cli'   
           
              UNION ALL
              SELECT
                P.cob_num, PT.mont_doc * case when p.anulado=1 then 0 else 1 end AS abono, 0.00 AS cargo, 0.00 AS total_neto, PT.num_doc AS nro_doc, P.co_cli as co_cli,
                PV.cli_des as cli_des, PT.forma_pag AS co_tipo_doc, PT.forma_pag, P.fecha, PT.fecha_che, '' AS tipo_mov,
                'N' AS TPAGO, '' AS doc_orig, P.anulado, P.descrip as deta
              FROM
                saCobro AS P
                INNER JOIN saCobroTPReng AS PT ON ( PT.cob_num = P.cob_num )
                INNER JOIN saCliente AS PV ON PV.co_cli = p.co_cli
              WHERE
                P.co_cli = '$co_cli'          
           
            ) a
            where nro_doc='$nro_doc'
        ORDER BY
            A.co_cli, A.fecha, A.fecha_che, A.cob_num";


        $datos = array();
        $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }
        sqlsrv_free_stmt($result);
        // echo $sel;
        return $datos;
  }
  public function cobrosfactura($nro_doc){
    $sel ="
            SELECT
            'Cobro' AS tipo, A.*
            FROM
              ( SELECT DISTINCT
              DC.co_cli AS co_prov, 
              P.cli_des AS prov_des, 
              DC.co_tipo_doc, 
              DC.nro_doc, 
              DC.anulado, 
              dbo.fechasimple(DC.fec_emis) as fec_emis,
              dbo.fechasimple(DC.fec_venc) as fec_venc, 
              DC.observa, ( DC.TOTAL_NETO - B.mont_cob_sal ) * ( CASE WHEN TD.tipo_mov = 'DE' THEN 1
              ELSE -1
              END ) AS saldo, 0.00 AS mont_cob,
              '' AS cob_num, '' AS Fec_pag, '' AS anulado_pago, '' AS fecha_Pag, '' AS fecha_emision,
              DC.total_neto * ( CASE WHEN TD.tipo_mov = 'DE' THEN 1
              ELSE -1
              END ) AS total_neto, DC.co_sucu_in, TD.tipo_mov, DC.nro_orig, DC.doc_orig, DC.co_mone,
              DC.tasa, '' AS forma_pag, '' AS num_doc, 'SI' AS pago_adel,
            TD.descrip as tipodoc
            FROM
            saDocumentoVenta AS dc
            INNER JOIN ( SELECT DISTINCT
            DC.co_tipo_doc, DC.nro_doc,
            ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
            OR E.anulado IS NULL THEN 0
            ELSE 1
            END), 0.00) AS mont_cob,
            ISNULL(SUM(( CASE WHEN E.fecha > '' THEN 0
            ELSE R.mont_cob
            END ) * CASE WHEN E.anulado = 1
            OR E.anulado IS NULL THEN 0
            ELSE 1
            END), 0) AS mont_cob_sal
            FROM
            saDocumentoVenta DC
            LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
            AND DC.nro_doc = R.nro_doc
            AND dc.anulado = 0
            )
            LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
            AND E.anulado = 0
            )
            GROUP BY
            DC.co_tipo_doc, DC.nro_doc
            ) AS b ON ( dc.nro_doc = b.nro_doc
            AND b.co_tipo_doc = DC.co_tipo_doc
            )
            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
            INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
            WHERE
            DC.anulado = 0
            AND DC.nro_doc >= '".$nro_doc."'
            AND DC.nro_doc <= '".$nro_doc."'
 

            UNION ALL
            SELECT  DISTINCT
              DC.co_cli AS co_prov, P.cli_des AS prov_des, par.co_tipo_doc, DC.nro_doc, DC.anulado, DC.fec_emis,
              DC.fec_venc, DC.observa, 0 AS saldo, par.mont_cob / ( CASE WHEN Pa.co_mone = DC.co_mone THEN 1
              ELSE DC.tasa
              END ) AS mont_cob, Pa.cob_num, pa.Fecha AS Fec_pag,
              pa.anulado AS anulado_pago, dbo.FechaSimple(pa.fecha) AS fecha_pag,
              dbo.FechaSimple(DC.fec_venc) AS fecha_emision, DC.total_neto * ( CASE WHEN TD.tipo_mov = 'DE' THEN 1 ELSE -1
              END ) AS total_neto, DC.co_sucu_in,
              TD.tipo_mov, DC.nro_orig, DC.doc_orig, DC.co_mone, DC.tasa, '' AS forma_pag, '' AS num_doc,
              CASE WHEN Par.cob_num IS NULL THEN 'SI'
              ELSE 'NO'
              END pago_adel,
            TD.descrip as tipodoc
            FROM
            saDocumentoVenta AS DC
            INNER JOIN saCobroDocReng AS PaR ON ( PaR.nro_doc = DC.nro_doc
            AND PaR.co_tipo_doc = DC.co_tipo_doc
            AND dc.anulado = 0
            )
            INNER JOIN saCobro AS Pa ON ( Pa.cob_num = PaR.cob_num
            AND Pa.anulado = 0
            )
            INNER JOIN saTipoDocumento AS Td ON DC.co_tipo_doc = Td.co_tipo_doc
            INNER JOIN saCliente AS P ON DC.co_cli = P.co_cli
            WHERE
            DC.anulado = 0
            AND  DC.nro_doc >= '".$nro_doc."'
            AND  DC.nro_doc <= '".$nro_doc."'


            ) A ORDER BY A.fec_emis, A.co_tipo_doc, A.nro_doc ";


        $datos = array();
        $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
              $datos[$i][$key]=$value;
            }
            $i++;
          }
        sqlsrv_free_stmt($result);
        // echo $sel;
        return $datos;
  }
  function getUltimoDiaMes($elAnio,$elMes) {
    return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
  }
  /* REGISTRAR GERENTES DE VENTES EN RANGO DE FECHA ESPECIFICA */
  public function registrarComisionesGerentesVentas($mes){
    $usuario=$_SESSION['usuario'];
    if (empty($mes)) {
      $mes = date("m");
    }
$conn = $this->getConMYSQL() ;
    /* BUSCAMOS SI EXISTEN LOS GERENTES DE VENTAS EN ESTE MES  */
      $bu ="
        SELECT * FROM `cmshistorialgventas`
         WHERE MONTH(`desde`)= ".$mes."";
        $rs = mysqli_query($conn,$bu) or die(mysqli_error($conn));
        $cant = mysqli_num_rows($rs);
    $msn = array(
        "error"=>"si"
      );
      if ($cant ==0) {
 
        $ultimoDia = $this->getUltimoDiaMes(date("Y"),$mes);
        $ultimoDiaMes = date("Y")."-".$mes."-".$ultimoDia;
        $primerDiaMes = date("Y")."-".$mes."-01";

        /* HUBICAMOS GERENTES DE LA FECHA */
        $sel = "SELECT * FROM `cmsgerenteventa` WHERE `estado` = 'Activo' ";
          
          $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
          
          $gerentes = array();

          $i=0;
          while($row=mysqli_fetch_array($rs)){
            foreach($row as $key=>$value){
              $gerentes[$i][$key]=$value;
            }
            $i++;
          }

          for ($x=0; $x < count($gerentes) ; $x++) { 
            $in ="INSERT INTO cmshistorialgventas
              (`id`,
              `co_ven`,
              `empresa`,
              `nombre`,
              `apellido`,
              `desde`,
              `hasta`,
              `fech_emis`,
              `creador`,
              `fech_mod`, 
              `modificador`) VALUES 
              (null,
              '',
              'Pro-Home',
              '".$gerentes[$x]['nombre']."',
              '".$gerentes[$x]['apellido']."',
              '".$primerDiaMes."',
              '".$ultimoDiaMes."',
              CURRENT_TIME(),
              '".$usuario."',
              CURRENT_TIME(),
              '".$usuario."')";

               $rs = mysqli_query($conn,$in) or die(mysqli_error($conn));
        }
          $msn = array(
            "error"=>"no",
            "desde"=>$primerDiaMes ,
            "hasta"=>$ultimoDiaMes ,
            "cantidad"=>count($gerentes) ,
            "mensaje"=>"Gerentes asignados a este periodo"
          );
          $this->setMensajes('success','gerentes asignados a este periodo');
    }else{
          $msn = array(
            "error"=>"si",
            "mensaje"=>"Ya existe gerentes para este periodo"
          );
          $this->setMensajes('warning','ya existe gerentes para este periodo');
    }


    return $msn;
  }
  /* REGISTRAR GERENTES REGIONALES EN RANGO DE FECHA ESPECIFICA */
  public function registrarGerentesRegionales($mes){
    
    $usuario=$_SESSION['usuario'];
    if (empty($mes)) {
      $mes = date("m");
    }

    $conn = $this->getConMYSQL() ;
    /* BUSCAMOS SI EXISTEN LOS GERENTES DE VENTAS EN ESTE MES  */
    $bu ="
        SELECT * FROM `cmshistorialgregional`
         WHERE MONTH(`desde`)= ".$mes."";
        $rs = mysqli_query($conn,$bu) or die(mysqli_error($conn));
        $cant = mysqli_num_rows($rs);
    $msn = array(
        "error"=>"si"
      );

      if ($cant ==0) { 
        $ultimoDia = $this->getUltimoDiaMes(date("Y"),$mes);
        $ultimoDiaMes = date("Y")."-".$mes."-".$ultimoDia;
        $primerDiaMes = date("Y")."-".$mes."-01";

        /* HUBICAMOS GERENTES DE LA FECHA */
         $sel = "select *,gr.id as idinterno from cmsgerenteregional as gr
                   inner join cmsregion as r on gr.cmsRegion_id = r.id
                   where gr.estado='Activo'";
          
          $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
          
          $gerentes = array();

          $i=0;
          while($row=mysqli_fetch_array($rs)){
            foreach($row as $key=>$value){
              $gerentes[$i][$key]=$value;
            }
            $i++;
          }

          for ($x=0; $x < count($gerentes) ; $x++) { 
            $in ="INSERT INTO `cmshistorialgregional`
            (`id`, `cmsRegion_id`, `cmsgerenteregional_id`,`co_ven`,
             `desde`, `hasta`, `fech_emis`,
              `creador`, `fech_mod`, `modificador`)  
              VALUES 
              (null,".$gerentes[$x]['id'].",'".$gerentes[$x]['idinterno']."','".$gerentes[$x]['co_ven']."',
             '".$primerDiaMes."','".$ultimoDiaMes."', CURRENT_TIME(),
              '".$usuario."', CURRENT_TIME(),'".$usuario."')";

               $rs = mysqli_query($conn,$in) or die(mysqli_error($conn));
        }
          $msn = array(
            "error"=>"no",
            "desde"=>$primerDiaMes ,
            "hasta"=>$ultimoDiaMes ,
            "cantidad"=>count($gerentes) ,
            "mensaje"=>"Gerentes asignados a este periodo"
          );
          $this->setMensajes('success','gerentes asignados a este periodo');
    }else{
          $msn = array(
            "error"=>"si",
            "mensaje"=>"Ya existe gerentes para este periodo"
          );
          $this->setMensajes('warning','ya existe gerentes para este periodo');
    }


    return $msn;
  }
  /* REGISTRAR METAS DE VENDEDORES EN RANGO DE FECHA ESPECIFICA */
  public function registrarVededoresMetas($mes){

    $usuario=$_SESSION['usuario'];
    if (empty($mes)) {
      $mes = date("m");
    }

    $conn = $this->getConMYSQL() ;
  
    /* BUSCAMOS GERENTES REGIONALES PARA LA FECHA  */
    $bu ="SELECT * FROM `cmshistorialgregional` 
         WHERE MONTH(`desde`)= ".$mes."";
        $rs = mysqli_query($conn,$bu) or die(mysqli_error($conn));
         $gerentes = array();

      $i=0;
      while($row=mysqli_fetch_array($rs)){
        foreach($row as $key=>$value){
          $gerentes[$i][$key]=$value;
        }
        $i++;
      }
      $msn = array(
          "error"=>"si"
        );
    
      /* SI HAY HISTORIAL */

      if (count($gerentes)>0) {
        $ultimoDia = $this->getUltimoDiaMes(date("Y"),$mes);
        
        $desde = date("Y")."-".$mes."-01";
        $hasta = date("Y")."-".$mes."-".$ultimoDia;
        

       /* NO GUARDAR VENDEDORES CLAVES NI OFICINA */
         /* VENDEDORES QUE NO PRODUCEN COMISIONES */
           $gerentesregionales = $this->getGerentesRegional(null);
           $vendedores_ex = array('','010');
           
           for ($g=0; $g < count($gerentesregionales['datos']) ; $g++) { 
             if(!empty($gerentesregionales['datos'][$g]['co_ven'])){ 
               $vendedores_ex[] = $gerentesregionales['datos'][$g]['co_ven'];
             }
           }

            $cuentasClaves = $this->getCuentasClaves('01',null);

          for($c=0;$c < count($cuentasClaves); $c++){
               $vendedores_ex[]= $cuentasClaves[$c]['co_ven'];
            }
        for ($y=0; $y < count($gerentes) ; $y++) {         
        
           $co_gerenteHistorial = $gerentes[$y]['id'];  
           $co_region = $gerentes[$y]['cmsRegion_id'];       
           $co_gerenteIn = $gerentes[$y]['cmsgerenteregional_id'];         
           $co_venProf = $gerentes[$y]['co_ven'];
           $presupuesto_reg = 666;
           /* BUSCAMOS LOS VENDEDORES CORRESPONDIENTE A LAS ZONAS DE LA REGION*/
           $zn = "SELECT zona FROM `cmszonagerencia` WHERE `cmsRegion_id` = '$co_region'";
           $rsz = mysqli_query($conn,$zn) or die(mysqli_error($conn));
           $zonas = array();

           $i=0;
           while($row=mysqli_fetch_array($rsz)){
            
               $zonas[]=$row[0];
             
             $i++;
           }

            $vendedores = $this->getvededoresZona($zonas);
            for ($x=0; $x < count($vendedores); $x++) { 

               $metaVend = $this->getMetasVendedores($vendedores[$x]['co_ven'],null,$desde,$hasta);
               $totales = $this->facturaVendedorFecha($vendedores[$x]['co_ven'],$desde,$hasta);
  
               $idvend = array_search(trim($vendedores[$x]['co_ven']),$vendedores_ex); 
               if ($idvend==FALSE) {       
               
                  $in = "
                  INSERT INTO `cmshistorialdos`
                  (`id`, `co_gerente`, `co_grofit`,
                  `co_ven`, `co_des`, `zona`,
                  `presupuesto`, `ventas`, `estatus`,
                  `desde`, `hasta`,
                  `fech_reg`, `creador`, `fech_mod`,
                  `modificador`) VALUES 
                  (null,'".$co_gerenteHistorial."','".$co_venProf."',
                  '".$vendedores[$x]['co_ven']."','".$vendedores[$x]['ven_des']."','".$vendedores[$x]['zon_des']."',
                  '".$metaVend[0]['presupuesto']."','".$totales['monto_base']."','Guardado', 
                  '".$desde."','".$hasta."',
                  CURRENT_TIME(),'".$usuario."',CURRENT_TIME(),
                  '".$usuario."')";
                   $rin = mysqli_query($conn,$in) or die(mysqli_error($conn));
                }
            }

        }
      
    }else{
          $msn = array(
            "error"=>"si",
            "mensaje"=>"No hay gerentes regionales en el historial para esta fecha"
          );
          $this->setMensajes('warning','No hay gerentes regionales en el historial para esta fecha');
        }

    return $in;
  }
  public function getActividadVendedorGerente($region,$co_ven,$desde){
            $sel ="SELECT * FROM `cmsvendedoresactividad`
                     WHERE `region` = '".$region."' 
                     and month(desde) =  month('".$desde."')
                     and year(desde) =  year('".$desde."')
                     and co_ven ='".$co_ven."'";
       $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
       
        $actividad['existe']="no";
  
        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $actividad[$i][$key]=$value;
            $actividad['existe']='si';
          }
          $i++;
        }

        return $actividad;

  }
  public function getActividadVendedorActual($co_ven){
            $sel ="SELECT * FROM `cmsvendedoresactividad` 
where co_ven = '".$co_ven."'
 ORDER BY fech_mod DESC LIMIT 1 ";
       
        

        $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
       
        $actividad = array(
          array('existe'=>'no')
        );

        $i=0;
        while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $actividad[$i][$key]=$value;
            $actividad[$i]['existe']='si';
          }
          $i++;
        }

        return $actividad;

  }
  public function facturaVendedorFecha($co_ven,$desde,$hasta){

  $fechas = $this->getActividadVendedorActual($co_ven);

    if(isset($fechas[0]['existe'] ) and $fechas[0]['existe'] == 'si') {

        $fecha_des_act = new DateTime($fechas[0]['desde']);
        $fecha_des = new DateTime($desde);

        if($fecha_des_act > $fecha_des){
          $f_desde = $fechas[0]['desde'];
        }else{
           $f_desde = $desde;
        }
    }

    $sel="
        SELECT
            1 AS Filtro_anulado, 'FACT' AS tipo_rep, CLI.tip_cli, CLI.cli_des, CLI.co_zon,
           FV.doc_num, FV.descrip, FV.co_cli, FV.co_tran, FV.co_mone, FV.co_ven, FV.co_cond,
            FV.fec_emis, FV.fec_venc, FV.fec_reg, FV.anulado, FV.status, FV.n_control, FV.ven_ter, FV.tasa,
            FV.porc_desc_glob, FV.monto_desc_glob, FV.porc_reca, FV.monto_reca, FV.total_bruto, 
      FV.monto_imp / ( CASE WHEN 1 IS NULL THEN 1
                                   ELSE FV.tasa
                              END ) AS monto_imp,
            FV.monto_imp2, FV.monto_imp3, FV.otros1, FV.otros2, FV.otros3,
            FV.total_neto / ( CASE WHEN 1 IS NULL THEN 1
                                   ELSE FV.tasa
                              END ) AS total_neto, FV.saldo / ( CASE WHEN 1 IS NULL THEN 1
                                                                     ELSE FV.tasa
                                                                END ) AS saldo, FV.dir_ent, FV.comentario, FV.dis_cen,
            FV.feccom, FV.numcom, FV.contrib, FV.impresa, FV.seriales_s, FV.salestax, FV.impfis, FV.impfisfac, FV.campo1,
            FV.campo2, FV.campo3, FV.campo4, FV.campo5, FV.campo6, FV.campo7, FV.campo8, FV.co_us_in, FV.co_sucu_in,
            FV.fe_us_in, FV.co_us_mo, FV.co_sucu_mo, FV.fe_us_mo, FV.revisado, FV.trasnfe, FV.validador, FV.rowguid,
      (FV.total_bruto - (FV.monto_desc_glob + FV.monto_reca)) / ( CASE WHEN 1 IS NULL THEN 1
            ELSE FV.tasa
            END ) AS monto_base
        FROM
            saFacturaVenta AS FV
            INNER JOIN saCliente AS CLI ON CLI.co_cli = FV.co_cli
        WHERE
             dbo.FechaSimple(FV.fec_emis) >= '".$desde."'
            AND  dbo.FechaSimple(FV.fec_emis) <= '".$hasta."'
            AND   FV.co_ven >= '".$co_ven."' AND FV.co_ven <= '".$co_ven."' 
            AND FV.anulado = 0
       ORDER BY
            FV.doc_num";

      $datos = array();
      $i=0;
      $conn = conectarSQlSERVER();
      $result=sqlsrv_query($conn,$sel);

      while($row=sqlsrv_fetch_array($result)){
          foreach($row as $key=>$value){
            $datos[$i][$key]=$value;
          }
          $i++;
        }
      sqlsrv_free_stmt($result);
     
      $montos =  array(
        'monto_base' => 0,
        'total_neto' => 0,
        'saldo' => 0,
        'monto_imp' => 0,
        'baseFactura' => 0
      );
      $nBase = 0;
      $nIva = 0;

      $nSaldo = 0;
      $nNeto = 0;

     for ($i=0; $i < count($datos) ; $i++) {   

            $nBase+= $datos[$i]['monto_base'];
            $nIva+= $datos[$i]['monto_imp'];

            $nSaldo+= $datos[$i]['saldo'];
            $nNeto+= $datos[$i]['total_neto'];
        }
        $baseFactura =  $nSaldo - $nIva;
         $montos =  array(
          'monto_base' => $nBase,
          'total_neto' => $nNeto,
          'saldo' => $nSaldo,
          'monto_imp' => $nIva,
          'baseFactura' => $baseFactura

          );
        return $montos;
    }

  public function facturaRegionFecha($co_vens,$desde,$hasta){

    $sel="
        SELECT
            1 AS Filtro_anulado, 'FACT' AS tipo_rep, CLI.tip_cli, CLI.cli_des, CLI.co_zon,
           FV.doc_num, FV.descrip, FV.co_cli, FV.co_tran, FV.co_mone, FV.co_ven, FV.co_cond,
            FV.fec_emis, FV.fec_venc, FV.fec_reg, FV.anulado, FV.status, FV.n_control, FV.ven_ter, FV.tasa,
            FV.porc_desc_glob, FV.monto_desc_glob, FV.porc_reca, FV.monto_reca, FV.total_bruto, 
      FV.monto_imp / ( CASE WHEN 1 IS NULL THEN 1
                                   ELSE FV.tasa
                              END ) AS monto_imp,
            FV.monto_imp2, FV.monto_imp3, FV.otros1, FV.otros2, FV.otros3,
            FV.total_neto / ( CASE WHEN 1 IS NULL THEN 1
                                   ELSE FV.tasa
                              END ) AS total_neto, FV.saldo / ( CASE WHEN 1 IS NULL THEN 1
                                                                     ELSE FV.tasa
                                                                END ) AS saldo, FV.dir_ent, FV.comentario, FV.dis_cen,
            FV.feccom, FV.numcom, FV.contrib, FV.impresa, FV.seriales_s, FV.salestax, FV.impfis, FV.impfisfac, FV.campo1,
            FV.campo2, FV.campo3, FV.campo4, FV.campo5, FV.campo6, FV.campo7, FV.campo8, FV.co_us_in, FV.co_sucu_in,
            FV.fe_us_in, FV.co_us_mo, FV.co_sucu_mo, FV.fe_us_mo, FV.revisado, FV.trasnfe, FV.validador, FV.rowguid,
      (FV.total_bruto - (FV.monto_desc_glob + FV.monto_reca)) / ( CASE WHEN 1 IS NULL THEN 1
            ELSE FV.tasa
            END ) AS monto_base
        FROM
            saFacturaVenta AS FV
            INNER JOIN saCliente AS CLI ON CLI.co_cli = FV.co_cli
        WHERE
             dbo.FechaSimple(FV.fec_emis) >= '".$desde."'
            AND  dbo.FechaSimple(FV.fec_emis) <= '".$hasta."'
            AND   FV.co_ven  in(".$co_vens.") 
            AND FV.anulado = 0
       ORDER BY
            FV.doc_num";

      $datos = array();
      $i=0;
      $conn = conectarSQlSERVER();
      $result=sqlsrv_query($conn,$sel);

      while($row=sqlsrv_fetch_array($result)){
          foreach($row as $key=>$value){
            $datos[$i][$key]=$value;
          }
          $i++;
        }
      sqlsrv_free_stmt($result);
     
      $montos =  array(
        'monto_base' => 0,
        'total_neto' => 0,
        'saldo' => 0,
        'monto_imp' => 0,
        'baseFactura' => 0

      );
      $nBase = 0;
      $nIva = 0;

      $nSaldo = 0;
      $nNeto = 0;

     for ($i=0; $i < count($datos) ; $i++) {   

            $nBase+= $datos[$i]['monto_base'];
            $nIva+= $datos[$i]['monto_imp'];

            $nSaldo+= $datos[$i]['saldo'];
            $nNeto+= $datos[$i]['total_neto'];
        }
        $baseFactura =  $nSaldo - $nIva;
         $montos =  array(
          'monto_base' => $nBase,
          'total_neto' => $nNeto,
          'saldo' => $nSaldo,
          'monto_imp' => $nIva,
          'baseFactura' => $baseFactura

          );
        return $montos;
    }

   public function getPresupuestoVentas_Historico($desde, $hasta){
      

      $conn = $this->getConMYSQL() ;
      $sel = "
      SELECT r.nombre,gr.co_ven, sum(hd.presupuesto) as presupuesto, sum(hd.ventas) as ventas,r.id as region
       FROM `cmshistorialdos` as hd inner join cmshistorialgregional as gr on gr.co_ven= hd.co_grofit 
       inner join cmsregion as r on r.id= gr.cmsRegion_id 
       where hd.desde = '".$desde."' and hd.hasta = '".$hasta."'
        group by r.nombre,gr.co_ven ";

       $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
          
      $gerentes = array();
      $parametros = array();

        $lista_parametros = array();
        $lista_parametros = $this->getParametros($desde,$hasta);

        $mes_doc =  date("m", strtotime($desde));
        $mes_doc = (int)$mes_doc;
        $parametros = $lista_parametros[$mes_doc];


     // $parametros = $this->getParametros($desde,$hasta);

      $i=0;

       while($row=mysqli_fetch_array($rs)){
         
         $porcentajeRealizado = ($row['ventas'] * 100) / $row['presupuesto'];

         $zonas = $this->getZonasGerernte($row['region']);
         $totalBase = $this->total_facturasSaldoCero_zona($desde,$hasta,$zonas);

         $vendedor = $this->getVendedor($row['co_ven']);
          $vendedorNombre = "Sin Asignar";

         if (isset($vendedor[0]['ven_des'])) {
            $vendedorNombre = $vendedor[0]['ven_des'];
         }

         $datos =  array(
            'total' =>  $totalBase['suma'],
            'porcentaje' => $porcentajeRealizado
         );

         $com = $this->calculoComisionRegional($datos, $parametros);

         foreach($row as $key=>$value){
           $gerentes[$i][$key]=$value;
           $gerentes[$i]['comision']=$com['comision'];
           $gerentes[$i]['realizacion']=$porcentajeRealizado;
           $gerentes[$i]['obtenido']=$com['porcentaje'];
           $gerentes[$i]['ventasfacturadas']=$row[3];
           $gerentes[$i]['cobrados']=  $totalBase['suma'];
           $gerentes[$i]['ven_des']= $vendedorNombre;
         }

         $i++;
       }

       return $gerentes;
   }

   public function getPresupuestoVentas_Historico_region($desde, $hasta,$region){
      $sel =" SELECT r.nombre,gr.co_ven, sum(hd.presupuesto) as presupuesto, sum(hd.ventas) as ventas,r.id as region
       FROM `cmshistorialdos` as hd inner join cmshistorialgregional as gr on gr.co_ven= hd.co_grofit 
       inner join cmsregion as r on r.id= gr.cmsRegion_id 
       where hd.desde = '".$desde."' and hd.hasta = '".$hasta."' and r.id=".$region."
        group by r.nombre,gr.co_ven ";
   }

   /* CALCULOS DE COMISIONES SEGUN VETAS TOTALES DE LAS REGIONES Y SUS GERENTES */
   public function calculoComisionRegional($datos, $parametros){


      $comision = array(
            "comision"=> 0,
            "porcentaje"=> 0,
            "calculado"=> 0,
        );

      /* EL INDICE DE LOS PARAMETROS TIENE QUE SER INDICADO DE LA TABLA */
        
        /* 1 % */

      $regional_1 = $parametros[17];
      if($comision['calculado'] == 0
         and $datos['porcentaje'] >= $regional_1['limite1']  and $datos['porcentaje'] <= $regional_1['limite2'])
      {
         $comision['comision'] = ($datos['total'] * $regional_1['porcentaje']) / 100;
         $comision['porcentaje'] = $regional_1['porcentaje'];
         $comision['calculado'] = 1;

        }        

      /* 1.25 % */
      $regional_2 = $parametros[18];
      if($comision['calculado'] == 0
         and $datos['porcentaje'] >= $regional_2['limite1']  and $datos['porcentaje'] <= $regional_2['limite2'])
      {
         $comision['comision'] = ($datos['total'] * $regional_2['porcentaje']) / 100;
         $comision['porcentaje'] = $regional_2['porcentaje'];
         $comision['calculado'] = 1;

        }  

      /* 1.50 % */
      $regional_3 = $parametros[19]; 
      if($comision['calculado'] == 0
         and $datos['porcentaje'] >= $regional_3['limite1'] and $datos['porcentaje'] <= $regional_3['limite2'])
      {
         $comision['comision'] = ($datos['total'] * $regional_3['porcentaje']) / 100;
         $comision['porcentaje'] = $regional_3['porcentaje'];
         $comision['calculado'] = 1;

        }

      /* 2.0 % */
      $regional_4 = $parametros[20]; 
      if($comision['calculado'] == 0 and $datos['porcentaje'] >= $regional_4['limite1'])
      {
         $comision['comision'] = ($datos['total'] * $regional_4['porcentaje']) / 100;
         $comision['porcentaje'] = $regional_4['porcentaje'];
         $comision['calculado'] = 1;

        }

        return $comision;

   }
   public function total_facturasSaldoCero_zona($desde,$hasta,$zonas){
     
      $resultados = array(
         'suma'=>0,
         'facturas'=>0
      );
    if(count($zonas)>0){
        $cod_zonas = "";
        for($x=0;$x < count($zonas); $x++){
          $cod_zonas.="'".$zonas[$x]."',";
        }
        $cod_zonas = substr($cod_zonas, 0, -1);
      }
      $sql =" SELECT
            DC.nro_doc, DC.co_tipo_doc,
         DC.co_ven, DC.co_cli,
         dbo.fechasimple(DC.fec_emis) as fec_emis,
         dbo.fechasimple(DC.fec_venc) as fec_venc,
         DC.anulado, DC.otros1, DC.otros2,
            DC.otros3, DC.total_neto / ( CASE WHEN '' IS NULL THEN 1
                                              ELSE DC.tasa
                                         END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                                                        ELSE 1
                                                   END ) AS total_neto,
            DC.saldo / ( CASE WHEN '' IS NULL THEN 1
                              ELSE DC.tasa
                         END ) * ( CASE WHEN DC.anulado = 1 THEN 0
                                        ELSE 1
                                   END ) AS saldo,
                                    DC.tasa, DC.total_bruto, DC.monto_imp, P.cli_des, TP.descrip,
            TP.tipo_mov,
            z.zon_des

        FROM
            saDocumentoVenta AS DC
            INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
            LEFT JOIN saTipoDocumento AS TP ON TP.co_tipo_doc = DC.co_tipo_doc
            INNER JOIN saVendedor AS ven ON ven.co_ven = DC.co_ven
            INNER JOIN saZona AS z ON z.co_zon = ven.co_zon
        WHERE dbo.fechasimple(DC.fec_emis) >= '".$desde."'             
          AND  dbo.fechasimple(DC.fec_emis) <= '".$hasta."'   
          AND  DC.co_tipo_doc = 'FACT'    
          AND   z.zon_des IN (".$cod_zonas.")
          AND saldo = 0 
          and DC.anulado = 0
          ORDER BY  DC.co_tipo_doc";

         $datos = array();

         $i=0;

         $conn = conectarSQlSERVER();
         $result=sqlsrv_query($conn,$sql);

         while($row=sqlsrv_fetch_array($result)){
             foreach($row as $key=>$value){
               $datos[$i][$key]=$value;
             }
             $i++;
           }
         sqlsrv_free_stmt($result);

         $total_bruto = 0;
        for ($x=0; $x < count($datos); $x++) { 
             $total_bruto+=$datos[$x]['total_bruto'];
        }
         $resultados = array(
            'suma'=>$total_bruto,
            'facturas'=>$datos
         );
        return $resultados;

   }
   public function getHistoricoTotal_Region($desde,$hasta,$region){     

      $conn = $this->getConMYSQL() ;
      $sel = "
      SELECT r.nombre,gr.co_ven, sum(hd.presupuesto) as presupuesto, sum(hd.ventas) as ventas,r.id as region
       FROM `cmshistorialdos` as hd inner join cmshistorialgregional as gr on gr.co_ven= hd.co_grofit 
       inner join cmsregion as r on r.id= gr.cmsRegion_id 
       where hd.desde = '".$desde."' and hd.hasta = '".$hasta."'
       and r.id='".$region."'
        group by r.nombre,gr.co_ven ";

        $datos_region = array();
      $i=0;
       $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn)); 
       while($row=mysqli_fetch_array($rs)){
          foreach($row as $key=>$value){
            $datos[$i][$key]=$value;
          }
          $i++;
        }  
        //echo $sel;
      $zonas = $this->getZonasGerernte($region);        
      $datos_region = array(
         'total' =>$datos,
         'zonas' => $zonas

      );
         return $datos_region;
   }
   public function fechaCobrofactura($cliente,$factura,$desde,$hasta){
      
      $sel="
            SELECT
                A.*, B.*, 'Cliente' AS tipo_rep
            FROM
                ( SELECT   DISTINCT
                    DC.co_tipo_doc AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc,
                    DC.total_neto, 0.00 AS MONTO, DC.saldo, '' AS nro_fact, DC.nro_orig,
                    CASE WHEN TD.tipo_mov = 'DE' THEN DC.total_neto
                         ELSE 0.00
                    END AS tot_debe, ( CASE WHEN TD.tipo_mov = 'CR' THEN DC.total_neto
                                            ELSE 0.00
                                       END ) AS tot_haber, CASE WHEN DC.co_cli = B.co_cli THEN B.co_cli
                                                                ELSE DC.co_cli
                                                           END AS co_prov, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                    '' AS ORIG, DC.observa, '' AS n_pago
                  FROM
                    saDocumentoVenta AS dc
                    INNER JOIN ( SELECT DISTINCT
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli,
                                    ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                      OR E.anulado IS NULL THEN 0
                                                                 ELSE 1
                                                            END), 0.00) AS mont_cob,
                                    ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                      ELSE R.mont_cob
                                                 END ) * CASE WHEN E.anulado = 1
                                                                   OR E.anulado IS NULL THEN 0
                                                              ELSE 1
                                                         END), 0) AS mont_cob_sal
                                 FROM
                                    saDocumentoVenta DC
                                    LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                    AND DC.nro_doc = R.nro_doc
                                                                    AND dc.anulado = 0
                                                                  )
                                    LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                             AND E.anulado = 0
                                                           )
                                 WHERE
                                     dc.co_cli = '$cliente'
                                    
                                    OR  E.co_cli = '$cliente'
                                      
                                 GROUP BY
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                               ) AS b ON ( dc.nro_doc = b.nro_doc
                                           AND b.co_tipo_doc = DC.co_tipo_doc
                                         )
                    INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                    INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
                  WHERE
                    dbo.fechaSimple(dc.fec_emis) >= '$desde'
                      
                      AND  dbo.fechaSimple(dc.fec_emis) <= '$hasta'
                          
                  
                    AND  dc.co_cli = '$cliente'
                    OR  B.co_cli = '$cliente'
               
                    AND DC.anulado = 0
                    AND DC.co_tipo_doc <> 'ADEL'
                  UNION ALL
                  SELECT DISTINCT
                    'PAGO' AS descrip, P.cob_num, DC.nro_doc, P.fecha AS fec_emis, DC.fec_venc, DC.co_tipo_doc,
                    DC.total_neto, P.monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                    CASE WHEN ( TP.tipo_mov = 'CR'
                                AND DC.co_tipo_doc <> 'ADEL'
                              ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                            ELSE ISNULL(PR.mont_cob, 0)
                                       END )
                    END AS tot_debe, ( CASE WHEN ( TP.tipo_mov = 'DE'
                                                   OR DC.co_tipo_doc = 'ADEL'
                                                 ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                                               ELSE ISNULL(PR.mont_cob, 0)
                                                          END )
                                       END ) * CASE WHEN DC.co_tipo_doc = 'ADEL' THEN -1
                                                    ELSE 1
                                               END AS tot_haber, CASE WHEN DC.co_cli = P.co_cli THEN DC.co_cli
                                                                      ELSE P.co_cli
                                                                 END AS co_prov, PV.cli_des AS prov_des, DC.co_mone,
                    DC.anulado,DC.nro_doc AS ORIG, DC.observa,
                    CASE WHEN P.fecha > '$hasta' THEN 'SI'
                    END AS n_pago
                  FROM
                    saDocumentoVenta AS DC
                    INNER JOIN saCobroDocReng AS PR ON ( PR.nro_doc = DC.nro_doc
                                                         AND PR.co_tipo_doc = DC.co_tipo_doc
                                                         AND dc.anulado = 0
                                                       )
                    INNER JOIN saCobro AS P ON ( P.cob_num = PR.cob_num
                                                 AND P.anulado = 0
                                               )
                    INNER JOIN saTipoDocumento AS TP ON DC.co_tipo_doc = TP.co_tipo_doc
                    INNER JOIN saCliente AS PV ON DC.co_cli = PV.co_cli
                  WHERE
                    DC.anulado = 0
                    AND  p.fecha >= '$desde'
                    AND p.fecha <= '$hasta'                   
                    AND  p.co_cli = '$cliente'
                   
                  UNION ALL
                  SELECT   DISTINCT
                    CASE WHEN td.descrip = 'ADELANTO' THEN 'ADEL'
                    END AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc, DC.total_neto,
                    0.00 AS monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                    CASE WHEN Td.tipo_mov = 'DE' THEN DC.total_neto
                         ELSE 0.00
                    END AS tot_debe, ( CASE WHEN Td.tipo_mov = 'CR' THEN DC.total_neto
                                            ELSE 0.00
                                       END ) AS tot_haber, DC.co_cli, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                    '' AS ORIG, DC.observa, '' AS n_pago
                  FROM
                    saDocumentoVenta AS dc
                    INNER JOIN ( SELECT DISTINCT
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli AS co_prov,
                                    ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                      OR E.anulado IS NULL THEN 0
                                                                 ELSE 1
                                                            END), 0.00) AS mont_cob,
                                    ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                      ELSE R.mont_cob
                                                 END ) * CASE WHEN E.anulado = 1
                                                                   OR E.anulado IS NULL THEN 0
                                                              ELSE 1
                                                         END), 0) AS mont_cob_sal
                                 FROM
                                    saDocumentoVenta DC
                                    LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                    AND DC.nro_doc = R.nro_doc
                                                                    AND dc.anulado = 0
                                                                  )
                                    LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                             AND E.anulado = 0
                                                           )
                                 WHERE
                                     dc.co_cli = '$cliente'
                                  
                                    OR  E.co_cli = '$cliente'
                                     
                                 GROUP BY
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                               ) AS b ON ( dc.nro_doc = b.nro_doc
                                           AND b.co_tipo_doc = DC.co_tipo_doc
                                         )
                    INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                    INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
                  WHERE
                    DC.anulado = 0
                    AND DC.co_tipo_doc = 'ADEL'
                    AND  dbo.fechaSimple(dc.fec_emis) >= '$desde'
                          
                          AND dbo.fechaSimple(dc.fec_emis) <= '$hasta'
                              
                        
                    AND dc.co_cli = '$cliente'
                    
                          OR  B.co_prov = '$cliente'                
                    
                ) A
                INNER JOIN ( SELECT
                                DC.co_cli AS PROV, ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, dbo.fechaSimple('$desde') - 1, '') ) AS SaldoInic,
                                ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, '$hasta', '') ) AS SaldoFinal
                             FROM
                                saDocumentoVenta DC
                             GROUP BY
                                DC.co_cli
                           ) B ON B.prov = A.co_prov
               where  ORIG = '$factura'
            ORDER BY
                A.fec_emis DESC ";
             $fecha = "";

         $i=0;

         $conn = conectarSQlSERVER();
         $result=sqlsrv_query($conn,$sel);
         $pagos = array();
         $npagos = array();


         if(count($result)){
          $i=0;
         while($row=sqlsrv_fetch_array($result)){
            $id_cobro = trim($row[1]);
            $sql_tipo = "select forma_pag from saCobroTPReng where cob_num='".$id_cobro."'";
             $rs =sqlsrv_query($conn,$sql_tipo);
             $lin =sqlsrv_fetch_array($rs);
            foreach($row as $key=>$value){
              $pagos[$i][$key]=$value;
              $pagos[$i]['tipo']=$lin['0'];
            }
            $i++;
           }
        }
         sqlsrv_free_stmt($result);
          
          $pago_encontrdo = 0;
         for ($y=0; $y < count($pagos); $y++) {

            if(trim($pagos[$y]['tipo'])=="CH" or $pagos[$y]['tipo']=="TP"){
                $fecha = $pagos[$y]['fec_emis']->format('Y-m-d');
                $pago_encontrdo = 1;    
            }
      
            if (trim($pagos[$y]['tipo']) == "EF" and $pago_encontrdo == 0 ){

                $mesactul = date('Y-m-d'); 
                $desde = date('Y-m-d', strtotime('-10 month')) ; // resta 1 mes

                $sel2="
                            SELECT
                                A.*, B.*, 'Cliente' AS tipo_rep 
                            FROM
                                ( SELECT   DISTINCT
                                    DC.co_tipo_doc AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc,
                                    DC.total_neto, 0.00 AS MONTO, DC.saldo, '' AS nro_fact, DC.nro_orig,
                                    CASE WHEN TD.tipo_mov = 'DE' THEN DC.total_neto
                                         ELSE 0.00
                                    END AS tot_debe, ( CASE WHEN TD.tipo_mov = 'CR' THEN DC.total_neto
                                                            ELSE 0.00
                                                       END ) AS tot_haber, CASE WHEN DC.co_cli = B.co_cli THEN B.co_cli
                                                                                ELSE DC.co_cli
                                                                           END AS co_prov, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                                    '' AS ORIG, DC.observa, '' AS n_pago
                                  FROM
                                    saDocumentoVenta AS dc
                                    INNER JOIN ( SELECT DISTINCT
                                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli,
                                                    ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                                      OR E.anulado IS NULL THEN 0
                                                                                 ELSE 1
                                                                            END), 0.00) AS mont_cob,
                                                    ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                                      ELSE R.mont_cob
                                                                 END ) * CASE WHEN E.anulado = 1
                                                                                   OR E.anulado IS NULL THEN 0
                                                                              ELSE 1
                                                                         END), 0) AS mont_cob_sal
                                                 FROM
                                                    saDocumentoVenta DC
                                                    LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                                    AND DC.nro_doc = R.nro_doc
                                                                                    AND dc.anulado = 0
                                                                                  )
                                                    LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                                             AND E.anulado = 0
                                                                           )
                                                   
                                                 WHERE
                                                     dc.co_cli = '$cliente'
                                                    
                                                    OR  E.co_cli = '$cliente'
                                                      
                                                 GROUP BY
                                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                                               ) AS b ON ( dc.nro_doc = b.nro_doc
                                                           AND b.co_tipo_doc = DC.co_tipo_doc
                                                         )
                                    INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                                    INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
                                  WHERE
                                    dbo.fechaSimple(dc.fec_emis) >= '$desde'
                                      
                                      AND  dbo.fechaSimple(dc.fec_emis) <= '$hasta'
                                          
                                  
                                    AND  dc.co_cli = '$cliente'
                                    OR  B.co_cli = '$cliente'
                               
                                    AND DC.anulado = 0
                                    AND DC.co_tipo_doc <> 'ADEL'
                                  UNION ALL
                                  SELECT DISTINCT
                                    'PAGO' AS descrip, P.cob_num, DC.nro_doc, P.fecha AS fec_emis, DC.fec_venc, DC.co_tipo_doc,
                                    DC.total_neto, P.monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                                    CASE WHEN ( TP.tipo_mov = 'CR'
                                                AND DC.co_tipo_doc <> 'ADEL'
                                              ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                                            ELSE ISNULL(PR.mont_cob, 0)
                                                       END )
                                    END AS tot_debe, ( CASE WHEN ( TP.tipo_mov = 'DE'
                                                                   OR DC.co_tipo_doc = 'ADEL'
                                                                 ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                                                               ELSE ISNULL(PR.mont_cob, 0)
                                                                          END )
                                                       END ) * CASE WHEN DC.co_tipo_doc = 'ADEL' THEN -1
                                                                    ELSE 1
                                                               END AS tot_haber, CASE WHEN DC.co_cli = P.co_cli THEN DC.co_cli
                                                                                      ELSE P.co_cli
                                                                                 END AS co_prov, PV.cli_des AS prov_des, DC.co_mone,
                                    DC.anulado,DC.nro_doc AS ORIG, DC.observa,
                                    CASE WHEN P.fecha > '$hasta' THEN 'SI'
                                    END AS n_pago
                                  FROM
                                    saDocumentoVenta AS DC
                                    INNER JOIN saCobroDocReng AS PR ON ( PR.nro_doc = DC.nro_doc
                                                                         AND PR.co_tipo_doc = DC.co_tipo_doc
                                                                         AND dc.anulado = 0
                                                                       )
                                    INNER JOIN saCobro AS P ON ( P.cob_num = PR.cob_num
                                                                 AND P.anulado = 0
                                                               )
                                    INNER JOIN saTipoDocumento AS TP ON DC.co_tipo_doc = TP.co_tipo_doc
                                    INNER JOIN saCliente AS PV ON DC.co_cli = PV.co_cli
                                   
                                  WHERE
                                    DC.anulado = 0
                                    AND  p.fecha >= '$desde'
                                    AND p.fecha <= '$hasta'                   
                                    AND  p.co_cli = '$cliente'
                                   
                                  UNION ALL
                                  SELECT   DISTINCT
                                    CASE WHEN td.descrip = 'ADELANTO' THEN 'ADEL'
                                    END AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc, DC.total_neto,
                                    0.00 AS monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                                    CASE WHEN Td.tipo_mov = 'DE' THEN DC.total_neto
                                         ELSE 0.00
                                    END AS tot_debe, ( CASE WHEN Td.tipo_mov = 'CR' THEN DC.total_neto
                                                            ELSE 0.00
                                                       END ) AS tot_haber, DC.co_cli, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                                    '' AS ORIG, DC.observa, '' AS n_pago
                                  FROM
                                    saDocumentoVenta AS dc
                                    INNER JOIN ( SELECT DISTINCT
                                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli AS co_prov,
                                                    ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                                      OR E.anulado IS NULL THEN 0
                                                                                 ELSE 1
                                                                            END), 0.00) AS mont_cob,
                                                    ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                                      ELSE R.mont_cob
                                                                 END ) * CASE WHEN E.anulado = 1
                                                                                   OR E.anulado IS NULL THEN 0
                                                                              ELSE 1
                                                                         END), 0) AS mont_cob_sal
                                                 FROM
                                                    saDocumentoVenta DC
                                                    LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                                    AND DC.nro_doc = R.nro_doc
                                                                                    AND dc.anulado = 0
                                                                                  )
                                                    LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                                             AND E.anulado = 0
                                                                           )
                                                 WHERE
                                                     dc.co_cli = '$cliente'                                  
                                                    OR  E.co_cli = '$cliente'                                     
                                                 GROUP BY
                                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                                               ) AS b ON ( dc.nro_doc = b.nro_doc
                                                           AND b.co_tipo_doc = DC.co_tipo_doc
                                                         )
                                    INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                                    INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
                                  WHERE
                                    DC.anulado = 0
                                    AND DC.co_tipo_doc = 'ADEL'
                                    AND  dbo.fechaSimple(dc.fec_emis) >= '$desde'
                                    AND dbo.fechaSimple(dc.fec_emis) <= '$hasta'
                                    AND dc.co_cli = '$cliente'
                                    OR  B.co_prov = '$cliente'                    
                                ) A
                                INNER JOIN ( SELECT
                                                DC.co_cli AS PROV, ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, dbo.fechaSimple('$desde') - 1, '') ) AS SaldoInic,
                                                ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, '$hasta', '') ) AS SaldoFinal
                                             FROM
                                                saDocumentoVenta DC
                                             GROUP BY
                                                DC.co_cli
                                           ) B ON B.prov = A.co_prov
                               where ORIG = '$factura'
                            ORDER BY
                                A.fec_emis DESC ";            
                    

                    $r=0;
                    $resulta=sqlsrv_query($conn,$sel2);

                    while($nrow=sqlsrv_fetch_array($resulta)){
                        $id_cobro = trim($nrow[1]);
                        $sql_tipo = "select forma_pag from saCobroTPReng where cob_num='".$id_cobro."'";
                        $rs3 =sqlsrv_query($conn,$sql_tipo);
                        $lin3 =sqlsrv_fetch_array($rs3);
                        foreach($nrow as $key=>$value){
                          $npagos[$r][$key]=$value;
                          $npagos[$r]['tipo']=$lin3['0'];
                        }
                        $r++;
                    }

                    for ($y=0; $y < count($npagos); $y++) { 
                        if($npagos[$y]['tipo']=="CH" or $npagos[$y]['tipo']=="TP"){
                            $fecha = $npagos[$y]['fec_emis']->format('Y-m-d');
                            $pago_encontrdo = 1;   
                            
                        }
                    }
            }

         }      
         return $fecha;

   }
   public function fechaCobrofactura_lista($cliente,$factura,$desde,$hasta){
      
      $sel="
            SELECT
                A.*, B.*, 'Cliente' AS tipo_rep
            FROM
                ( SELECT   DISTINCT
                    DC.co_tipo_doc AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc,
                    DC.total_neto, 0.00 AS MONTO, DC.saldo, '' AS nro_fact, DC.nro_orig,
                    CASE WHEN TD.tipo_mov = 'DE' THEN DC.total_neto
                         ELSE 0.00
                    END AS tot_debe, ( CASE WHEN TD.tipo_mov = 'CR' THEN DC.total_neto
                                            ELSE 0.00
                                       END ) AS tot_haber, CASE WHEN DC.co_cli = B.co_cli THEN B.co_cli
                                                                ELSE DC.co_cli
                                                           END AS co_prov, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                    '' AS ORIG, DC.observa, '' AS n_pago
                  FROM
                    saDocumentoVenta AS dc
                    INNER JOIN ( SELECT DISTINCT
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli,
                                    ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                      OR E.anulado IS NULL THEN 0
                                                                 ELSE 1
                                                            END), 0.00) AS mont_cob,
                                    ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                      ELSE R.mont_cob
                                                 END ) * CASE WHEN E.anulado = 1
                                                                   OR E.anulado IS NULL THEN 0
                                                              ELSE 1
                                                         END), 0) AS mont_cob_sal
                                 FROM
                                    saDocumentoVenta DC
                                    LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                    AND DC.nro_doc = R.nro_doc
                                                                    AND dc.anulado = 0
                                                                  )
                                    LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                             AND E.anulado = 0
                                                           )
                                 WHERE
                                     dc.co_cli = '$cliente'
                                    
                                    OR  E.co_cli = '$cliente'
                                      
                                 GROUP BY
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                               ) AS b ON ( dc.nro_doc = b.nro_doc
                                           AND b.co_tipo_doc = DC.co_tipo_doc
                                         )
                    INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                    INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
                  WHERE
                    dbo.fechaSimple(dc.fec_emis) >= '$desde'
                      
                      AND  dbo.fechaSimple(dc.fec_emis) <= '$hasta'
                          
                  
                    AND  dc.co_cli = '$cliente'
                    OR  B.co_cli = '$cliente'
               
                    AND DC.anulado = 0
                    AND DC.co_tipo_doc <> 'ADEL'
                  UNION ALL
                  SELECT DISTINCT
                    'PAGO' AS descrip, P.cob_num, DC.nro_doc, P.fecha AS fec_emis, DC.fec_venc, DC.co_tipo_doc,
                    DC.total_neto, P.monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                    CASE WHEN ( TP.tipo_mov = 'CR'
                                AND DC.co_tipo_doc <> 'ADEL'
                              ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                            ELSE ISNULL(PR.mont_cob, 0)
                                       END )
                    END AS tot_debe, ( CASE WHEN ( TP.tipo_mov = 'DE'
                                                   OR DC.co_tipo_doc = 'ADEL'
                                                 ) THEN ( CASE WHEN P.fecha > '$hasta' THEN 0
                                                               ELSE ISNULL(PR.mont_cob, 0)
                                                          END )
                                       END ) * CASE WHEN DC.co_tipo_doc = 'ADEL' THEN -1
                                                    ELSE 1
                                               END AS tot_haber, CASE WHEN DC.co_cli = P.co_cli THEN DC.co_cli
                                                                      ELSE P.co_cli
                                                                 END AS co_prov, PV.cli_des AS prov_des, DC.co_mone,
                    DC.anulado,DC.nro_doc AS ORIG, DC.observa,
                    CASE WHEN P.fecha > '$hasta' THEN 'SI'
                    END AS n_pago
                  FROM
                    saDocumentoVenta AS DC
                    INNER JOIN saCobroDocReng AS PR ON ( PR.nro_doc = DC.nro_doc
                                                         AND PR.co_tipo_doc = DC.co_tipo_doc
                                                         AND dc.anulado = 0
                                                       )
                    INNER JOIN saCobro AS P ON ( P.cob_num = PR.cob_num
                                                 AND P.anulado = 0
                                               )
                    INNER JOIN saTipoDocumento AS TP ON DC.co_tipo_doc = TP.co_tipo_doc
                    INNER JOIN saCliente AS PV ON DC.co_cli = PV.co_cli
                  WHERE
                    DC.anulado = 0
                    AND  p.fecha >= '$desde'
                    AND p.fecha <= '$hasta'
                   
                    AND  p.co_cli = '$cliente'
                   
                  UNION ALL
                  SELECT   DISTINCT
                    CASE WHEN td.descrip = 'ADELANTO' THEN 'ADEL'
                    END AS descrip, '' cob_num, DC.nro_doc, DC.fec_emis, DC.fec_venc, DC.co_tipo_doc, DC.total_neto,
                    0.00 AS monto, DC.saldo, '' AS nro_fact, DC.nro_orig,
                    CASE WHEN Td.tipo_mov = 'DE' THEN DC.total_neto
                         ELSE 0.00
                    END AS tot_debe, ( CASE WHEN Td.tipo_mov = 'CR' THEN DC.total_neto
                                            ELSE 0.00
                                       END ) AS tot_haber, DC.co_cli, P.cli_des AS prov_des, DC.co_mone, DC.anulado,
                    '' AS ORIG, DC.observa, '' AS n_pago
                  FROM
                    saDocumentoVenta AS dc
                    INNER JOIN ( SELECT DISTINCT
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli AS co_prov,
                                    ISNULL(SUM(R.mont_cob * CASE WHEN E.anulado = 1
                                                                      OR E.anulado IS NULL THEN 0
                                                                 ELSE 1
                                                            END), 0.00) AS mont_cob,
                                    ISNULL(SUM(( CASE WHEN E.fecha > '$hasta' THEN 0
                                                      ELSE R.mont_cob
                                                 END ) * CASE WHEN E.anulado = 1
                                                                   OR E.anulado IS NULL THEN 0
                                                              ELSE 1
                                                         END), 0) AS mont_cob_sal
                                 FROM
                                    saDocumentoVenta DC
                                    LEFT JOIN saCobroDocReng R ON ( DC.co_tipo_doc = R.co_tipo_doc
                                                                    AND DC.nro_doc = R.nro_doc
                                                                    AND dc.anulado = 0
                                                                  )
                                    LEFT JOIN saCobro E ON ( E.cob_num = R.cob_num
                                                             AND E.anulado = 0
                                                           )
                                 WHERE
                                     dc.co_cli = '$cliente'
                                  
                                    OR  E.co_cli = '$cliente'
                                     
                                 GROUP BY
                                    DC.co_tipo_doc, DC.nro_doc, E.co_cli, DC.co_cli
                               ) AS b ON ( dc.nro_doc = b.nro_doc
                                           AND b.co_tipo_doc = DC.co_tipo_doc
                                         )
                    INNER JOIN saCliente AS P ON P.co_cli = DC.co_cli
                    INNER JOIN saTipoDocumento AS TD ON TD.co_tipo_doc = DC.co_tipo_doc
                  WHERE
                    DC.anulado = 0
                    AND DC.co_tipo_doc = 'ADEL'
                    AND  dbo.fechaSimple(dc.fec_emis) >= '$desde'
                          
                          AND dbo.fechaSimple(dc.fec_emis) <= '$hasta'
                              
                        
                    AND dc.co_cli = '$cliente'
                    
                          OR  B.co_prov = '$cliente'
                 
                    
                ) A
                INNER JOIN ( SELECT
                                DC.co_cli AS PROV, ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, dbo.fechaSimple('$desde') - 1, '') ) AS SaldoInic,
                                ( dbo.SaldoClienteAUnaFechaxMoneda(DC.co_cli, '$hasta', '') ) AS SaldoFinal
                             FROM
                                saDocumentoVenta DC
                             GROUP BY
                                DC.co_cli
                           ) B ON B.prov = A.co_prov
               where ORIG = '$factura'
            ORDER BY
                A.fec_emis, A.co_tipo_doc ";
             $fecha = "";

         $i=0;

         $conn = conectarSQlSERVER();
         $result=sqlsrv_query($conn,$sel);

         if(count($result)){
         while($row=sqlsrv_fetch_array($result)){
            $fecha = $row[3]->format('Y-m-d');             
            $i++;
         }
            }
         //sqlsrv_free_stmt($result);

         return $fecha;

   }
   public function agregarPeriodo($datos){

      $conn = $this->getConMYSQL() ;      

      /* BUSCAR SI TIENE UN PERIODO */
      $usuario=$_SESSION['usuario']; 

     $in ="INSERT INTO `cmsvendedoresactividad`
      (`id`, `co_ven`, `desde`, `hasta`, `tipo`, `estatus`, `creado`, `fech_emi`, `modificado`, `fech_mod`, `region`) VALUES 
      (null,'".$datos['co_ven']."','".$datos['desde']."','".$datos['hasta']."',
      '".$datos['tipo']."','".$datos['estatus']."','".$usuario."',CURRENT_TIME(),
      '".$usuario."',CURRENT_TIME(),'".$datos['region']."')";
    $msn = array(
       'error'=>'si'
     );
      $rs = mysqli_query($conn,$in) or die(mysqli_error($conn));
      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error en escritua de periodo".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);
      }else{
         $mensa = "Periodo agregado ";
        $this->setMensajes('success',$mensa);
       $msn = array(
         'error'=>'no'
       );
      }

      return $msn;
   }
   public function getGerentesActivos($region,$desde,$hasta){

        $actual = date("Y-m-d");
        $sel="SELECT * FROM `cmsvendedoresactividad` 
        WHERE `desde` <= '".$desde."' 
        and `hasta` >= '".$hasta."' 
        and `region`  = '".$region."' ORDER BY `id` DESC ";

        $conn = $this->getConMYSQL() ;    
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));

        $periodos = array();

        $i=0;
          while($row=mysqli_fetch_array($rs)){
            foreach($row as $key=>$value){
              $periodos[$i][$key]=$value;
            }
            $i++;
          }
        return $periodos;
   }
   public function editarPeriodo($datos){

      $conn = $this->getConMYSQL() ;      

      /* BUSCAR SI TIENE UN PERIODO */
      $usuario=$_SESSION['usuario'];  
        $region = $datos['region'];
      if($datos['tipo'] != 'Gerente'){
        $region = 0;

      }
     $in ="UPDATE `cmsvendedoresactividad` SET 
     `co_ven`='".$datos['co_ven']."',
     `desde`='".$datos['desde']."',
     `hasta`='".$datos['hasta']."',
     `tipo`='".$datos['tipo']."',
     `estatus`='".$datos['estatus']."',
     `modificado`='". $usuario."',
     `fech_mod`=CURRENT_TIME(),
     `region`='".$region."'
      WHERE id='".$datos['id']."'";
    $msn = array(
       'error'=>'si'
     );
      $rs = mysqli_query($conn,$in) or die(mysqli_error($conn));
      if (mysqli_errno($conn)) {
        $mensa = "Ocurrio un error en modificacion de periodo".mysqli_errno($conn).": ". mysqli_error($conn);
        $this->setMensajes('danger',$mensa);
      }else{
         $mensa = "Periodo modificado ";
        $this->setMensajes('success',$mensa);
       $msn = array(
         'error'=>'no'
       );
      }

      return $msn;
   }
   public function getPeriodos($id){
        $sel ="
      SELECT * FROM `cmsvendedoresactividad` ";

      if (!empty($id)) {
        $sel.= " where id='".$id."' ";
      }          

      $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $periodos = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)){
           $ven_des = "VACANTE";
          if ($row[1]!="VACANTE") {
            $ven_des = $this->getvendedores($row[1]);
            $ven_des = $ven_des[0]['ven_des'];
          }        

          foreach($row as $key=>$value){
            $periodos[$i][$key]=$value;
            $periodos[$i]["ven_des"]= $ven_des;
          }
          $i++;
        }
        return $periodos;
   }
   public function getGerenteHasta($region,$desde,$hasta){
        $sel ="
        SELECT  * FROM `cmsvendedoresactividad` WHERE `region`='".$region."'
         and MONTH(desde) >= MONTH('".$desde."') and YEAR(desde) >= YEAR('".$desde."')
         UNION DISTINCT
         SELECT * FROM `cmsvendedoresactividad` WHERE `region`='".$region."'
         and MONTH(hasta) >= MONTH('".$hasta."') and YEAR(hasta) >= YEAR('".$hasta."')
        ";
       
        $sel ="SELECT * FROM `cmsvendedoresactividad` 
          where month(desde) = month('".$desde."') 
          and month(hasta) = month('".$hasta."')
          and tipo='Gerente'
          and region='".$region."' ";      

        $conn = $this->getConMYSQL() ;
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $gerente = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)){
           $ven_des = "VACANTE";
          if ($row[1]!="VACANTE") {
            $ven_des = $this->getvendedores($row[1]);
            $ven_des = $ven_des[0]['ven_des'];
          }       

          foreach($row as $key=>$value){
            $gerente[$i][$key]=$value;
            $gerente[$i]["ven_des"]= $ven_des;
          }
          $i++;
        }

        return $gerente;
   }
   public function getFacturasComision($region,$desde,$hasta,$co_ven){
       
	 $conn = $this->getConMYSQL() ; 
		$zonas = $this->getZonasGerernte($region);



    /* BUSCAR FECHA DE ACTIVIDAD DEL GERENTE */
    $fechas = $this->getActividadVendedorGerente($region,$co_ven,$desde);

    if ($fechas['existe']=="si") {
      $ac_desde = $fechas[0]['desde'];
      $ac_hasta = $fechas[0]['hasta'];
    }


		$totales_region = $this->getPresupuestoRegionalyVentas($zonas,$ac_desde,$ac_hasta);
		$d_region = $this->getRegiones($region);
   
    $porcentajeRealizado = 0;

    if($totales_region['total_presupuesto'] > 0){
		  $porcentajeRealizado = ($totales_region['total_ventas'] * 100) / $totales_region['total_presupuesto'];
    }

		
    $porcentajeRealizado = round($porcentajeRealizado);
		$parametros = array();

		$lista_parametros = array();
		$lista_parametros = $this->getParametros($desde,$hasta);

		$mes_doc =  date("m", strtotime($desde));
		$mes_doc = (int)$mes_doc;

    $cann = $lista_parametros[$mes_doc]['cortes'];
    if ($cann == 1) {
        $parametros = $lista_parametros[$mes_doc]['datos'];
        $entra = 1;
    }else{
        
        for ($l=0; $l <   $cann  ; $l++) {    
          /* comparamos fecha */
            $fecha_desde = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['desde']);
            $fecha_hasta = new DateTime($lista_parametros[$mes_doc]['datos'][$l]['hasta']);
            $fecha_emision = new DateTime($desde);

            if($fecha_emision >= $fecha_desde and $fecha_emision <= $fecha_hasta){
                 $parametros = $lista_parametros[$mes_doc]['datos'][$l];
                 $entra = 1;
            }
        }
         
    }

      if(count($parametros) == 0){
           $parametros = $parametros_desfasados;
      }

                /* ELIMINAMOS LOS PARAMETROS DE DESDE Y HASTA YA QUE NO SE USARAN */
                unset($parametros['datos'][0]['desde'],$parametros['datos'][0]['hasta']);

		 $datos =  array(
			  'total' =>  $totales_region['total_ventas'],
			  'porcentaje' => $porcentajeRealizado
		   );
		   
		$com = $this->calculoComisionRegional($datos, $parametros);
	      $vendes = $this->getvededoresZona($zonas);

        $co_vens = "";
        for($x=0;$x < count($vendes); $x++){
           $co_vens.="'".$vendes[$x]['co_ven']."',";
        }
        $co_vens = substr($co_vens, 0, -1);

        $sel ="SELECT * FROM `cmshistorialuno`  
        WHERE month(`periodo`)=month('".$desde."') and  YEAR(`periodo`)=YEAR('".$desde."') 
		and co_vende in(".$co_vens.")
ORDER BY `cmshistorialuno`.`co_vende` ASC
        ";      
       $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $facturas = array();

        $i=0;

        while($row=mysqli_fetch_array($rs)){
        
            $ven_des = $this->getvendedores($row[3]);
            $ven_des = $ven_des[0]['ven_des'];  
            
           $porc = 0; 
           if($com['porcentaje'] > 0 and $porcentajeRealizado > 0){
           		$porc = ($row[9] * $com['porcentaje']) / 100; 
           }
			
          foreach($row as $key=>$value){
            $facturas['facturas'][$i][$key]=$value;
            $facturas['facturas'][$i]["ven_des"]= $ven_des;
            $facturas['facturas'][$i]["ncomision"]= $porc;
          }
          $i++;
        }

    
		$facturas['zonas'] = $zonas;
		$facturas['nombre_region'] = $d_region[0]['nombre'];
		$facturas['total_ventas'] = $totales_region['total_ventas'];
		$facturas['total_presupuesto'] = $totales_region['total_presupuesto'];
		
        return $facturas;
   }
   public function getFacturasComisionClaves($desde,$hasta){
       
	   $conn = $this->getConMYSQL() ; 
	   
	   $parametros = array();

        $lista_parametros = array();
        $lista_parametros = $this->getParametros($desde,$hasta);

        $mes_doc =  date("m", strtotime($desde));
        $mes_doc = (int)$mes_doc;
        $parametros = $lista_parametros[$mes_doc]['datos'];
        $cann = $lista_parametros[$mes_doc]['cortes'];

        if ($cann == 1) {
          $parametros = $lista_parametros[$mes_doc]['datos'];
          $entra = 1;
		}else{
          
          for ($l=0; $l <  $cann  ; $l++) {                     

               $parametros = $lista_parametros[$mes_doc]['datos'][$l];
               
          }           
      }	

	$cod_clave ="";
	$cuentasClaves = $this->getCuentasClaves('01',null);

	for($x=0;$x < count($cuentasClaves); $x++){
		$cod_clave.="'".$cuentasClaves[$x]['co_ven']."',";
	}
	$cod_clave = substr($cod_clave, 0, -1);

	$sqCla = "SELECT sum(presupuesto) as total_presupuesto FROM `cmspresupuestoclave` 
	WHERE `co_ven` in(".$cod_clave.") 
	and month(desde)=month('".$desde."') and year(desde)=year('".$desde."')";
        

        $rs_cla=mysqli_query($conn,$sqCla);
        $lnn=mysqli_fetch_array($rs_cla);
		$t_ventas_claves = $this->facturaRegionFecha($cod_clave,$desde,$hasta);

		$cobros = $this->getCobrosVendedor($cuentasClaves,$desde,$hasta);
		
		$calculado = 0;
    $elPresupuesto = 0;
		$realizacion = 0;

		 if ($lnn[0] > 0) {
			 $elPresupuesto = $lnn[0];
			$realizacion =  ($t_ventas_claves['monto_base'] * 100 ) / $elPresupuesto;
			$realizacion = round($realizacion);
		}   
    
    if( $calculado == 0 and $realizacion >= $parametros[20]['limite1'] and $realizacion > 0){
			$porcentaje = $parametros[20]['porcentaje'];
			$calculado = 1;

		}
		if( $calculado == 0 and $realizacion >= $parametros[19]['limite1'] and $realizacion <= $parametros[19]['limite2'] and $realizacion > 0){
		 $porcentaje = $parametros[19]['porcentaje'];
		  $calculado = 1;

		}
		if( $calculado == 0 and $realizacion >= $parametros[18]['limite1'] and $realizacion <= $parametros[18]['limite2'] and $realizacion > 0){
		 $porcentaje = $parametros[18]['porcentaje'];
		  $calculado = 1;             

		}

		if( $calculado == 0 and $realizacion >= $parametros[17]['limite1'] and $realizacion <= $parametros[17]['limite2'] and $realizacion > 0){
			$porcentaje = $parametros[17]['porcentaje'];
			 $calculado = 1;
		}

    if ($porcentaje > 0) {

    		$ncomision = ($cobros * $porcentaje) / 100;
    }
	      
        $sel ="SELECT * FROM `cmshistorialuno` 
        WHERE month(`periodo`)=month('".$desde."')  and  YEAR(`periodo`)=YEAR('".$desde."')
		and co_vende in(".$cod_clave.")
ORDER BY `cmshistorialuno`.`co_vende` ASC
        ";
     
	   
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $facturas = array();
		
        $i=0;
        while($row=mysqli_fetch_array($rs)){
        
            $ven_des = $this->getvendedores($row[3]);
            $ven_des = $ven_des[0]['ven_des'];              
           $porc = 0; 
          if ($porcentaje > 0) {
          	 $porc = ($row[9] * $porcentaje) / 100; 
          }
          foreach($row as $key=>$value){
            $facturas['facturas'][$i][$key]=$value;
            $facturas['facturas'][$i]["ven_des"]= $ven_des;
            $facturas['facturas'][$i]["ncomision"]= $porc;
          }
          $i++;
        }
		$facturas['total_presupuesto'] = $elPresupuesto;
		$facturas['total_ventas'] = $t_ventas_claves['monto_base'];
        return $facturas;
   }

   public function getFacturasComisionVendedor($co_ven,$desde,$hasta){
       
        $sel ="SELECT * FROM `cmshistorialuno` 
        WHERE month(`periodo`)=month('".$desde."') and co_vende='".$co_ven."'";
       
        $conn = $this->getConMYSQL() ; 
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $facturas = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)){
        
            $ven_des = $this->getvendedores($row[3]);
            $ven_des = $ven_des[0]['ven_des'];      
            $cli_des = $this->getCliente($row[4]);
            $cli_des = trim($cli_des[0]['cli_des']);              

          foreach($row as $key=>$value){
            $facturas[$i][$key]=$value;
            $facturas[$i]["ven_des"]= $ven_des;
            $facturas[$i]["cli_des"]= $cli_des;
          }
          $i++;
        }

        return $facturas;
   }
   public function getFacturasGerenteVentas($co_ven,$desde,$hasta){
       
        $sel1 ="SELECT * FROM `parametros` WHERE
         cuenta='Ventas' and tipo='Comision'
          and MONTH(`desde`)=MONTH('".$desde."') and YEAR(`desde`)=YEAR('".$desde."')";
      $conn = $this->getConMYSQL(); 
      $rs = mysqli_query($conn,$sel1) or die(mysqli_error($conn));
      $para = mysqli_fetch_array($rs);
      $porcentaje = $para[7];
        $sel ="SELECT * FROM `cmshistorialuno` 
        WHERE MONTH(`periodo`)=MONTH('".$desde."') and YEAR(`periodo`)=YEAR('".$desde."')";
  
        $rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $facturas = array();

        $i=0;
        while($row=mysqli_fetch_array($rs)){
        
            $ven_des = $this->getvendedores($row[3]);
            $ven_des = $ven_des[0]['ven_des'];      
            $cli_des = $this->getCliente($row[4]);
            $cli_des = trim($cli_des[0]['cli_des']);              
            $monto = $row[9];              
          $comision = ($monto * $porcentaje) / 100; 
          foreach($row as $key=>$value){
            $facturas[$i][$key]=$value;
            $facturas[$i]["ven_des"]= $ven_des;
            $facturas[$i]["cli_des"]= $cli_des;
            $facturas[$i]["n_comision"]= $comision;
          }
          $i++;
        }
        return $facturas;
   }

   public function getComisiones2total($desde,$hasta) {

        $ger ="SELECT  * FROM `cmsvendedoresactividad` as va
        inner join cmsregion as r on r.id=va.region
        where va.tipo='Gerente' and desde>='".$desde."' and hasta<='".$hasta."'        
        order by r.nombre";
        $conn = $this->getConMYSQL() ; 
        $rs = mysqli_query($conn,$ger) or die(mysqli_error($conn));
        $gerente = array();

        $i=0;
        
        $parametros = array();

        $lista_parametros = array();
        $lista_parametros = $this->getParametros($desde,$hasta);

        $mes_doc =  date("m", strtotime($desde));
        $mes_doc = (int)$mes_doc;
        $parametros = $lista_parametros[$mes_doc]['datos'];
        $cann = $lista_parametros[$mes_doc]['cortes'];

        if ($cann == 1) {
          $parametros = $lista_parametros[$mes_doc]['datos'];
          $entra = 1;
       }else{
          
          for ($l=0; $l <  $cann  ; $l++) {                     

               $parametros = $lista_parametros[$mes_doc]['datos'][$l];
               
          }           
      }
  
      while($row=mysqli_fetch_array($rs)){     
    
            /* BUSCAMOS PRESUPUESTOS */
            $region = $row['region'];
            $nombreregion = $row['nombre'];
            $ven_des = "VACANTE";
            $totalp = 0;
             $total_presupuesto = 0;

            $t_ventas = 0;
            $total_vacante = 0;

            $zonas = $this->getZonasGerernte($region);
            $vendes = $this->getvededoresZona($zonas);

            if($row[1] != "VACANTE") {

                $ven_des = $this->getvendedores($row[1]);
                $ven_des = $ven_des[0]['ven_des'];     
                $cod_ven = "";

                for($x=0;$x < count($vendes); $x++){
                    $cod_ven.="'".$vendes[$x]['co_ven']."',";
                }

                $cod_ven = substr($cod_ven, 0, -1);

                $pre_S ="
                SELECT pv.*,sum(pv.presupuesto) as total FROM `cmspresupuestovendedor` as pv where month(pv.desde)=month('".$desde."') and year(pv.desde)=year('".$desde."')
                 and pv.co_ven in(".$cod_ven.")";
                $rs1 = mysqli_query($conn,$pre_S) or die(mysqli_error($conn));             
                 $linea = mysqli_fetch_array($rs1);

                $total_presupuesto = $linea['total'];

                $gerente_desde = $row[2];
                $gerente_hasta = $row[3];


                $gerente_desdeN = new DateTime($gerente_desde);
                $gerente_hastaN = new DateTime($gerente_hasta);

                if($gerente_desdeN > $desde){
                    $gerente_desde = $gerente_desde;
                }else{
                     $gerente_desde = $desde;
                }

                if($gerente_hastaN > $hasta){
                    $gerente_hasta = $gerente_hasta;
                }else{
                    $gerente_hasta = $hasta;
                }

                $t_ventas = $this->facturaRegionFecha($cod_ven,$gerente_desde,$gerente_hasta);
             }
              
            /*  COBROS DE ZONAS POR REGION */
            $cobros = $this->getCobrosZonas($zonas,$gerente_desde,$gerente_hasta);
             if($row[1] == "VACANTE") {
                $cobros = 0;
             }
            $co_zonas = "";
            for($x=0;$x < count($zonas); $x++){
             $co_zonas.="'".$zonas[$x]."',";
            }

            $co_zonas = substr($co_zonas, 0, -1);

            $pre_S2 =" SELECT pv.*,sum(pv.presupuesto) as total FROM `cmspresupuestovendedor` as pv where MONTH(pv.desde)=MONTH('".$desde."') and YEAR(pv.desde)=YEAR('".$desde."')
            and pv.zona in(".$co_zonas.")";
            $rs2 = mysqli_query($conn,$pre_S2) or die(mysqli_error($conn));             
            $linea = mysqli_fetch_array($rs2);

            $total_vacante = $linea['total'];
            $totalp =  $total_presupuesto + $total_vacante;
            
            $realizacion = 0;

            if ($totalp > 0) {
                $realizacion =  ($t_ventas['monto_base'] * 100 ) / $totalp;
                $realizacion = round($realizacion);
            }            
           
            $porcentaje = 0;
            $calculado = 0;

            if( $calculado == 0 and $realizacion >= $parametros[20]['limite1'] and $realizacion > 0){
                $porcentaje = $parametros[20]['porcentaje'];
                $calculado = 1;
            }

            if( $calculado == 0 and $realizacion >= $parametros[19]['limite1'] and $realizacion <= $parametros[19]['limite2'] and $realizacion > 0){
             $porcentaje = $parametros[19]['porcentaje'];
              $calculado = 1;

            }
            if( $calculado == 0 and $realizacion >= $parametros[18]['limite1'] and $realizacion <= $parametros[18]['limite2'] and $realizacion > 0){
             $porcentaje = $parametros[18]['porcentaje'];
              $calculado = 1;             

            }

            if( $calculado == 0 and $realizacion >= $parametros[17]['limite1'] and $realizacion <= $parametros[17]['limite2'] and $realizacion > 0){
                $porcentaje = $parametros[17]['porcentaje'];
                 $calculado = 1;
            }
            $comision = 0;
            if($porcentaje>0){
              $comision = ($cobros * $porcentaje) / 100;

            }
          

            foreach($row as $key=>$value){
                $gerente[$i][$key]=$value;
                $gerente[$i]["ven_des"]= $ven_des;
                $gerente[$i]["presupuesto"]= $totalp;
                $gerente[$i]["region"]= $region;
                $gerente[$i]["nombreregion"]= $nombreregion ;
                $gerente[$i]["ventas"]= $t_ventas['monto_base'];
                $gerente[$i]["realizacion"]= $realizacion;
                $gerente[$i]["porcentaje"]= $porcentaje;
                $gerente[$i]["cobros"]= $cobros;
                $gerente[$i]["comision"]= $comision;
              }
              $i++;
              $porcentaje = 0;
      }

    /* BUSCAR PRESUPUESTO CLAVES VENTAS REALIZACION COBROS */

          $cod_clave ="";
          $cuentasClaves = $this->getCuentasClaves('01',null);

          for($x=0;$x < count($cuentasClaves); $x++){
              $cod_clave.="'".$cuentasClaves[$x]['co_ven']."',";
            }
            $cod_clave = substr($cod_clave, 0, -1);

            $sqCla = "SELECT sum(presupuesto) as total_presupuesto FROM `cmspresupuestoclave` 
          WHERE `co_ven` in(".$cod_clave.") 
          and month(desde)=month('".$desde."') and year(desde)=year('".$desde."')";
        $rs_cla=mysqli_query($conn,$sqCla);
        $lnn=mysqli_fetch_array($rs_cla);
		$t_ventas_claves = $this->facturaRegionFecha($cod_clave,$desde,$hasta);
		
		$cobros = $this->getCobrosVendedor($cuentasClaves,$desde,$hasta);
		
		$calculado = 0;
    $porcentaje = 0;
    $realizacion = 0;

		 if($lnn[0] > 0) {
			$realizacion =  ($t_ventas_claves['monto_base'] * 100 ) / $lnn[0];
			$realizacion = round($realizacion);
		}   
    if($calculado == 0 and $realizacion >= $parametros[20]['limite1']  and $realizacion > 0){
			$porcentaje = $parametros[20]['porcentaje'];
			$calculado = 1;

		}
		if( $calculado == 0 and $realizacion >= $parametros[19]['limite1'] and $realizacion <= $parametros[19]['limite2'] and $realizacion > 0){
		 $porcentaje = $parametros[19]['porcentaje'];
		  $calculado = 1;

		}
		if( $calculado == 0 and $realizacion >= $parametros[18]['limite1'] and $realizacion <= $parametros[18]['limite2'] and $realizacion > 0){
		 $porcentaje = $parametros[18]['porcentaje'];
		  $calculado = 1;             

		}

		if( $calculado == 0 and $realizacion >= $parametros[17]['limite1'] and $realizacion <= $parametros[17]['limite2'] and $realizacion > 0){
			$porcentaje = $parametros[17]['porcentaje'];
			 $calculado = 1;
		}
    $comision=0;
     if($porcentaje > 0) {
		  $comision = ($cobros * $porcentaje) / 100;
		}
		
		$i = count($gerente) ;
        $gerente[$i]["ven_des"]= "CLAVES";
        $gerente[$i]["presupuesto"]= $lnn[0];
        $gerente[$i]["region"]= "CLAVES";
        $gerente[$i]["nombreregion"]= "ergergergerg";
        $gerente[$i]["ventas"]= $t_ventas_claves['monto_base'];
        $gerente[$i]["realizacion"]= $realizacion;
        $gerente[$i]["porcentaje"]= $porcentaje;
        $gerente[$i]["cobros"]= $cobros;
        $gerente[$i]["comision"]= $comision;

        $gerente[$i]["id"]= "47006";
        $gerente[$i]["ven_des"]= "";
        $gerente[$i]["co_ven"]= "";
        $gerente[$i]["desde"]= "2017-06-01";
        $gerente[$i]["hasta"]= "2017-06-01";
        $gerente[$i]["tipo"]= "47006";
        $gerente[$i]["estatus"]= "47006";
        $gerente[$i]["creado"]= "2017-06-01";
        $gerente[$i]["fech_emi"]= "2017-06-01";
        $gerente[$i]["modificado"]= "2017-06-01";
        $gerente[$i]["fech_mod"]= "47006";
        $gerente[$i]["nombre"]= "CLAVES";
        $gerente[$i]["registro"]= "47006";
        $gerente[$i]["modificacion"]= "2017-06-01";
        $gerente[$i]["hechopor"]= "47006";
        $gerente[$i]["modificadopor"]= "47006";
  return $gerente;

   }
   public function buscarFacturaNCR($fact,$tipo, $array) {

        $resultado = array('resultado'=>'no');
         foreach ($array as $key => $val) {
             if (trim($val['nro_orig']) === $fact and trim($val['co_tipo_doc']) === $tipo) {
                 $resultado = array(
                  'resultado'=>'si',
                  'lugar'=> $key
                 );      
             }
         }
           return $resultado;
      }
  }
?>