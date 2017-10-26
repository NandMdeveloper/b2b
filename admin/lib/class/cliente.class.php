  <?php class cliente {   

    public $co_ven = null;
    public  $servidor = 1; // 1 conecta servidor 134 0 servidor local 

    public function  getConMYSQL(){
      $conn = conectarServ($this->servidor) ;    
      return $conn;
    }
      function getUltimoDiaMes($elAnio,$elMes) {
    return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
  }
  function getDatosCliente($co_cli) {
   $sel =  "select cli.co_cli,cli.cli_des,cli.telefonos,cli.email from ACCE.dbo.saCliente as cli where co_cli = '".$co_cli."'";

        $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);
         if($result){
        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
                $datos[$i][$key]=$value;
            }
            $i++;
        }
        sqlsrv_free_stmt($result);
        }
    // echo $sel;
        return $datos ;
  }
    public function getClientescartera($zona,$desde,$hasta) {
        
      /* BUSCAMOS ULTIMO DIA DEL MES ANTERIOR */
      $fMeshasta = explode("-", $hasta);
      $nuevafecha = strtotime ( '-1 month' , strtotime ($hasta)) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

      $annio = $fMeshasta[0];
      $mesAn = $fMeshasta[1] - 1;
      if($mesAn<=0){
        $mesAn = 12 - $mesAn;
         $annio--;
      }
      $mesAn = str_pad($mesAn,  2, "0", STR_PAD_LEFT); 

      $ultimoDia  = $this->getUltimoDiaMes($fMeshasta[0],$mesAn);
      $ultDia =  $annio."-".$mesAn."-".$ultimoDia;
       
       $datos = array();


        $sel = "    
          select *, CAST(CASE WHEN clientes = 0 THEN 0 ELSE (carteraActiv * 100 / clientes) END as float )  as porc from(
              select ven.co_ven,  ven.ven_des,  ven.co_zon,  zn.zon_des,
                  clientes =cast(( select count(*) from (
                      select DISTINCT cli.co_cli as ccant from saCliente as cli
                      inner join safacturaventa as fv on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven)
                       where cli.co_ven=ven.co_ven 
                       and cli.fecha_reg <='".$ultDia."') as a 
                      ) as float),
                  clientemes =cast((select count(*) from (
                      select DISTINCT cli.co_cli as ccant from saCliente as cli
                      inner join safacturaventa as fv on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven)
                       where cli.co_ven=ven.co_ven 
                      and MONTH(cli.fecha_reg) = MONTH('".$hasta."')
                        and YEAR(cli.fecha_reg) = YEAR('".$hasta."')) as a
                      ) as float),
                   carteraActiv = cast((select count(co_cli) from (
                      select DISTINCT fv.co_cli from safacturaventa as fv
                      inner join saCliente as cli on   (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven)
                       where fv.co_ven = ven.co_ven 
                        and cli.fecha_reg <= '".$ultDia."'
                       and MONTH(cli.fecha_reg) <= MONTH('".$hasta."')
                       and YEAR(cli.fecha_reg) <= YEAR('".$hasta."')
                       and MONTH(fv.fec_emis)= MONTH('".$hasta."')
                         and YEAR(fv.fec_emis) = YEAR('".$hasta."') 
                         and fv.anulado=0
                       ) as a) as float)
                   from saVendedor  as ven
                  inner join saZona as zn on ven.co_zon = zn.co_zon
                  where inactivo = 0
              ) as b order 
              by CAST(CASE WHEN clientes = 0 THEN 0 ELSE (carteraActiv * 100 / clientes) END as float )";
        if (!empty($zona)) {
            $sel .= " and ven.co_zon in(".$zona.") order by ven.ven_des";         
        }
        echo  $sel;
        $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);
         if($result){
        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
                $datos[$i][$key]=$value;
            }
            $i++;
        }
        sqlsrv_free_stmt($result);
        }
    // echo $sel;
        return $datos ;

    }
    public function getClientescarteraTotales($zona,$desde,$hasta) {
        
      /* BUSCAMOS ULTIMO DIA DEL MES ANTERIOR */
      $fMeshasta = explode("-", $hasta);
      $nuevafecha = strtotime ( '-1 month' , strtotime ($hasta)) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

      $annio = $fMeshasta[0];
      $mesAn = $fMeshasta[1] - 1;
      if($mesAn<=0){
        $mesAn = 12 - $mesAn;
         $annio--;
      }
      $mesAn = str_pad($mesAn,  2, "0", STR_PAD_LEFT); 

      $ultimoDia  = $this->getUltimoDiaMes($fMeshasta[0],$mesAn);
      $ultDia =  $annio."-".$mesAn."-".$ultimoDia;
       
      $datos = array();


      $sel = "select co_zon,zon_des , sum(clientes),sum(clientemes),sum(carteraActiv)
          from( select ven.co_zon, zn.zon_des, 
            clientes =cast(( select count(*) from ( select DISTINCT cli.co_cli as ccant 
            from saCliente as cli inner join safacturaventa as fv on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven) 
            where cli.co_ven=ven.co_ven and cli.fecha_reg <='".$ultDia."') as a ) as float), 
            clientemes =cast((select count(*) from ( select DISTINCT cli.co_cli as ccant from saCliente as cli 
            inner join safacturaventa as fv on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven) 
            where cli.co_ven=ven.co_ven and MONTH(cli.fecha_reg) = MONTH('".$hasta."') 
            and YEAR(cli.fecha_reg) = YEAR('".$hasta."')) as a ) as float), 
            carteraActiv = cast((select count(co_cli) 
              from ( select DISTINCT fv.co_cli from safacturaventa as fv inner join saCliente as 
            cli on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven) where fv.co_ven = ven.co_ven and 
            cli.fecha_reg <= '".$ultDia."' and MONTH(cli.fecha_reg) <= MONTH('".$hasta."') 
            and YEAR(cli.fecha_reg) <= YEAR('".$hasta."') 
            and MONTH(fv.fec_emis)= MONTH('".$hasta."') 
            and YEAR(fv.fec_emis) = YEAR('".$hasta."') and fv.anulado=0 ) as a) as float) 
            from saVendedor as ven inner join saZona as zn on ven.co_zon = zn.co_zon where inactivo = 0 
          ) as b GROUP BY zon_des,co_zon order by zon_des ";
        if (!empty($zona)) {
            $sel .= " and ven.co_zon in(".$zona.") order by ven.ven_des";         
        }
       // echo  $sel;
        $i=0;
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);
         if($result){
        while($row=sqlsrv_fetch_array($result)){
            foreach($row as $key=>$value){
                $datos[$i][$key]=$value;
            }
            $i++;
        }
        sqlsrv_free_stmt($result);
        }
    // echo $sel;
        return $datos ;

    }
    public function getvededoresZona($zona) {

        $datos = array();

        $sel = "select ven.co_ven,  ven.ven_des,  ven.co_zon,  zn.zon_des
         from saVendedor  as ven
        inner join saZona as zn on ven.co_zon = zn.co_zon
        where inactivo = 0 ";
        if (!empty($zona)) {
            $sel .= " and ven.co_zon in(".$zona.") order by ven.ven_des";         
        }
 
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
     
        return $datos ;
    }
    public function getClientesNuevos($zona,$desde,$hasta,$vendedor) {
      /* BUSCAMOS ULTIMO DIA DEL MES ANTERIOR */
  
       
        $datos = array();

        $sel = "select DISTINCT cli.cli_des,cli.telefonos,cli.email,cli.rif from saCliente as cli 
                    inner join safacturaventa as fv on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven) 
                      where cli.co_ven='".$vendedor."' and MONTH(cli.fecha_reg) = MONTH('".$hasta."') 
                      and YEAR(cli.fecha_reg) = YEAR('".$hasta."')";
        if (!empty($zona)) {
            $sel .= " and ven.co_zon in(".$zona.") order by ven.ven_des";         
        }
 
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
     
        return $datos ;
    }
    public function getClientesRegulares($zona,$desde,$hasta,$vendedor) {
      /* BUSCAMOS ULTIMO DIA DEL MES ANTERIOR */
      $fMeshasta = explode("-", $hasta);
      $nuevafecha = strtotime ( '-1 month' , strtotime ($hasta)) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

      $annio = $fMeshasta[0];
      $mesAn = $fMeshasta[1] - 1;
      if($mesAn<=0){
        $mesAn = 12 - $mesAn;
         $annio--;
      }
      $mesAn = str_pad($mesAn,  2, "0", STR_PAD_LEFT); 

      $ultimoDia  = $this->getUltimoDiaMes($fMeshasta[0],$mesAn);
      $ultDia =  $annio."-".$mesAn."-".$ultimoDia;
       
        $datos = array();

        $sel = "select DISTINCT cli.cli_des,cli.telefonos,cli.email,cli.rif from safacturaventa as fv inner join saCliente as cli on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven) where fv.co_ven = '".$vendedor."' and 
            cli.fecha_reg <= '".$ultDia."' and MONTH(cli.fecha_reg) <= MONTH('".$hasta."') 
            and YEAR(cli.fecha_reg) <= YEAR('".$hasta."') 
          and MONTH(fv.fec_emis)= MONTH('".$hasta."') 
          and YEAR(fv.fec_emis) = YEAR('".$hasta."') and fv.anulado=0";
        if (!empty($zona)) {
            $sel .= " and ven.co_zon in(".$zona.") order by ven.ven_des";         
        }
 
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
     
        return $datos ;
    }
    public function getClientesActuales($zona,$desde,$hasta,$vendedor) {
      /* BUSCAMOS ULTIMO DIA DEL MES ANTERIOR */
      $fMeshasta = explode("-", $hasta);
      $nuevafecha = strtotime ( '-1 month' , strtotime ($hasta)) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

      $annio = $fMeshasta[0];
      $mesAn = $fMeshasta[1] - 1;
      if($mesAn<=0){
        $mesAn = 12 - $mesAn;
         $annio--;
      }
      $mesAn = str_pad($mesAn,  2, "0", STR_PAD_LEFT); 

      $ultimoDia  = $this->getUltimoDiaMes($fMeshasta[0],$mesAn);
      $ultDia =  $annio."-".$mesAn."-".$ultimoDia;
       
        $datos = array();

        $sel = "select DISTINCT cli.cli_des,cli.telefonos,cli.email,cli.rif
                  from saCliente as cli inner join safacturaventa as fv on (fv.co_cli=cli.co_cli and fv.co_ven=cli.co_ven) 
                  where cli.co_ven='$vendedor' and cli.fecha_reg <='".$ultDia."'";
        if (!empty($zona)) {
            $sel .= " and ven.co_zon in(".$zona.") order by ven.ven_des";         
        }
 
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
     
        return $datos ;
    }
    public function getClientesdeUnVendedor($co_ven,$zona,$desde,$hasta){
        
        $sel ="select *  from saCliente where inactivo=0 ";

                    if (!empty($desde)) {
                       $sel.=" and fecha_reg >='".$desde."' ";
                    }

                    if (!empty($hasta)) {
                       $sel.=" and fecha_reg <='".$hasta."' ";
                    }

                    if (!empty($co_ven)) {
                       $sel.=" and co_ven='".$co_ven."' ";
                    }
                 
                    $sel.=" order by fecha_reg";
             
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        $clientes = array();
        if($result){
          $i = 0;
          while($row=sqlsrv_fetch_array($result)){                         
              foreach($row as $key=>$value){
                  $clientes[$i][$key]=$value;                  
              }
              $i++;
          }  
           sqlsrv_free_stmt($result);
        }
         return $clientes;
        
    }
    public function getClientes($co_ven,$zona,$desde,$hasta){
        
        $sel ="select ven.co_ven,ven.ven_des,cli.co_cli,cli.cli_des,z.zon_des,cli.fecha_reg  from saCliente as cli 
                    inner join saVendedor as ven on cli.co_ven=ven.co_ven
                    inner join saZona as z on cli.co_zon=z.co_zon
                    where cli.fecha_reg >= '".$desde."' and cli.fecha_reg <= '".$hasta."'";

                    if (!empty($co_ven)) {
                       $sel.=" and cli.co_ven='".$co_ven."' ";
                    }

                    if (!empty($zona)) {
                       $sel.=" and z.co_zon='".$zona."' ";
                    }
                    $sel.=" order by cli.fecha_reg";
                 
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        $clientes = array();
        if($result){
        $i = 0;
        while($row=sqlsrv_fetch_array($result)){
                       
            foreach($row as $key=>$value){
                $clientes[$i][$key]=$value;
                
            }
            $i++;
        }  
         sqlsrv_free_stmt($result);
        }
         return $clientes;
        
    }
    public function getClientesMes($co_ven,$zona,$mes){
        
        $sel ="select ven.co_ven,ven.ven_des,cli.co_cli,cli.cli_des,z.zon_des,cli.fecha_reg  from saCliente as cli 
                    inner join saVendedor as ven on cli.co_ven=ven.co_ven
                    inner join saZona as z on cli.co_zon=z.co_zon
                    where MONTH(cli.fecha_reg) = MONTH('".$mes."') and YEAR(cli.fecha_reg) = YEAR('".$mes."')";

                    if (!empty($co_ven)) {
                       $sel.=" and cli.co_ven='".$co_ven."' ";
                    }

                    if (!empty($zona)) {
                       $sel.=" and z.co_zon='".$zona."' ";
                    }
                    $sel.=" order by cli.fecha_reg";
                 
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        $clientes = array();
        if($result){
        $i = 0;
        while($row=sqlsrv_fetch_array($result)){
                       
            foreach($row as $key=>$value){
                $clientes[$i][$key]=$value;
                
            }
            $i++;
        }  
         sqlsrv_free_stmt($result);
        }
         return $clientes;
        
    }
    public function getFacturaClientes($co_cli,$desde,$hasta){
        
        $sel ="select count(doc_num) as cantidad from safacturaventa where co_cli = '".$co_cli."' 
        and MONTH(fec_emis)= MONTH('".$hasta."')  and YEAR(fec_emis) = YEAR('".$hasta."') and anulado=0";
          
        $conn = conectarSQlSERVER();
        $cantidad = 0  ; 
        $result=sqlsrv_query($conn,$sel);
        if($result){
          $row=sqlsrv_fetch_array($result);
          $cantidad =  $row[0] ; 
          sqlsrv_free_stmt($result);
        }
      
         return $cantidad;
        
    }
    public function getCXCCliente($co_cli,$desde,$hasta){
        $conn = conectarSQlSERVER(); 

       $myparams['sCo_Cli_d'] = $co_cli;
      $myparams['sCo_Cli_h'] = $co_cli;
      $myparams['dFecha_Emis_d'] = $desde;

       $procedure_params = array(
      array(&$myparams['sCo_Cli_d'], SQLSRV_PARAM_IN),
      array(&$myparams['sCo_Cli_h'], SQLSRV_PARAM_IN),
      array(&$myparams['dFecha_Emis_d'], SQLSRV_PARAM_IN)
      );

       $sel = "EXEC  acce.dbo.RepDocumentoCXCxCliente @sCo_Cli_d = ?, @sCo_Cli_h = ?, @dFecha_Emis_d = ?";
         
         $stmt = sqlsrv_prepare($conn, $sel, $procedure_params);
         if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
        }
                 $doc = array();
                      $x = 0;
                 if(sqlsrv_execute($stmt)){
                      //$result=sqlsrv_query($conn,$sel);
                      while($row=sqlsrv_fetch_array($stmt)) {          
                          foreach($row as $key=>$value) {
                            $doc[$x][$key]=$value;
                          }

                          $x++;           
                      }
                  }
         
      return $doc;
    }
    public function getClientesVentas($co_ven,$zona,$desde,$hasta){
        
        $sel ="select   ven.co_ven, ven.ven_des,cli.co_cli, cli.cli_des,z.zon_des,
              suma = (select sum(total_bruto) as ss from saDocumentoVenta where co_cli=cli.co_cli and anulado=0 and
               fec_emis >='".$desde."' and fec_emis <='".$hasta."')
               from saCliente as cli  
              inner join saZona as z on cli.co_zon=z.co_zon
              inner join saVendedor as ven on ven.co_ven=cli.co_ven
              where cli.inactivo=0 ";

                    if (!empty($co_ven)) {
                       $sel.=" and cli.co_ven='".$co_ven."' ";
                    }

                    if (!empty($zona)) {
                       $sel.=" and z.co_zon='".$zona."' ";
                    }
                 
        $conn = conectarSQlSERVER();
        $result=sqlsrv_query($conn,$sel);

        $clientes = array();
        if($result){
        $i = 0;
        while($row=sqlsrv_fetch_array($result)){
                       
            foreach($row as $key=>$value){
                $clientes[$i][$key]=$value;                
            }
            $i++;
        }  
         sqlsrv_free_stmt($result);
        }
         return $clientes;
        
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