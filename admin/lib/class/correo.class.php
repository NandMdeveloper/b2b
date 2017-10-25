<?php 
	class correo {
		private $host =  'tls://mail.grupopro.com.ve:587';
		private $SMTPAuth =  true;
		private $correo =  0;
		private $From =  'facturas@grupopro.com.ve';
		private $FromName =  'Pro Ventas';

		private $inicioEnvios =  '2017-10-17';
		private $usuario =  'facturas@grupopro.com.ve';
		private $clave =  'prohome2017';
  		public  $servidor = 1; // 1 conecta servidor 134 0 servidor local 
		function __construct() {

       		$this->correo = new PHPMailer(true);
			try{
				//Luego tenemos que iniciar la validación por SMTP:
				$this->correo->IsSMTP();
				$this->correo->SMTPAuth = $this->SMTPAuth;
				//$this->correo->Host = 'tls://smtp.gmail.com:587';
				$this->correo->Host = $this->host;
				//$this->correo->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
				//$this->correo->Host = "smtp.gmail.com";
				//$this->correo->Host = "mail.grupopro.com.ve"; // SMTP a utilizar. Por ej. smtp.elserver.com
				$this->correo->Username = $this->usuario; // Correo completo a utilizar
				$this->correo->Password = $this->clave; // Contraseña
				//$this->correo->Port = 465; // Puerto a utilizar 
				
			} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
			}
   		}
	    public function  getConMYSQL() {
	      $conn = conectarServ($this->servidor) ;    
	      return $conn;
	    }
   		public function enviar($datos) {
   			
   			try{
   				//  UPDATE `correomasivo` SET `enviado` = '0'
   				// SELECT `destino`, COUNT(destino) as cantidad FROM `correomasivo` GROUP by destino
				$this->correo->AddAddress($datos['destino']); // Esta es la dirección a donde enviamos
				$this->correo->IsHTML(true); // El correo se envía como HTML
				$this->correo->Subject = $datos['Subject']; // Este es el titulo del email.
				$this->correo->Body = $datos['body']; // Mensaje a enviar
				$this->correo->From = $datos['de']; // Desde donde enviamos (Para mostrar)
				$this->correo->FromName = $this->FromName;

				$exito = $this->correo->Send(); // Envía el correo.

		        $this->correo->ClearAddresses();
				if ($exito==1) {
     
		            return $exito;
		        } else {
		            return $exito;
		        }
				
			} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
			}

   		}
   		public function RepFormatoFacturaVenta($doc_num){
  
		        $conn = conectarSQlSERVER(); 

		       $myparams['cCo_Numero_d'] = $doc_num;  
		      $myparams['cCo_Numero_h'] = $doc_num;

		       $procedure_params = array(
		      array(&$myparams['cCo_Numero_d'], SQLSRV_PARAM_IN),
		      array(&$myparams['cCo_Numero_h'], SQLSRV_PARAM_IN),
		      );

		       $sel = "EXEC acce.dbo.RepFormatoFacturaVentaCCE2785 @cCo_Numero_d = ?, @cCo_Numero_h = ?";
		         
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
   		public function detalleFactura($doc_num){
   			  $conn = conectarSQlSERVER();
   			  // Cabezera de la factura
   			  $sel = "SELECT  fv.doc_num,fv.co_cli,cli.cli_des,fv.fec_emis,fv.co_ven,ven.ven_des,
							ven.ven_des, ven.telefonos, ven.email, cli.telefonos AS tel_cliente, cli.email,cli.email_alterno,
							fv.total_neto,cli.rif as clirif,CP.cond_des,fv.co_cond from ACCE.dbo.saFacturaVenta as fv
						inner join ACCE.dbo.saCliente as cli on cli.co_cli = fv.co_cli
						inner join ACCE.dbo.saVendedor as ven on ven.co_ven = fv.co_ven
						  LEFT JOIN saCondicionPago AS CP ON CP.co_cond = FV.co_cond
						where fv.doc_num='$doc_num'";


		      	$result=sqlsrv_query($conn,$sel);
		      	$factura = array(
		      		'cabezera' => 0,
		      		'cuerpo' => 0
		      	);
		      	$cabezera = array();
		      	$i=0;
		        while($row=sqlsrv_fetch_array($result)) {
		            foreach($row as $key=>$value) {
		              $cabezera[$i][$key]=$value;

		            }
		            $i++;
		        }
		      sqlsrv_free_stmt($result);
		      $factura['cabezera'] = $cabezera;
   			  // Cuerpo del pedido 
   			  $sel = "SELECT art.co_art,art.art_des,fvr.co_uni,fvr.total_art,fvr.reng_neto from ACCE.dbo.saFacturaVentaReng as fvr 
						inner join acce.dbo.saArticulo as art on art.co_art = fvr.co_art
						where fvr.doc_num='$doc_num'";

		      	$result=sqlsrv_query($conn,$sel);

		      	$cuerpo = array();
		      	$i=0;
		        while($row=sqlsrv_fetch_array($result)) {
		            foreach($row as $key=>$value) {
		              $cuerpo[$i][$key]=$value;
		            }
		            $i++;
		        }
		      sqlsrv_free_stmt($result);
			
			$factura['cuerpo'] = $cuerpo;

			return $factura;


   		}
   		public function getContactoVendedor($vendedor) {
   			
   			  $conn = conectarSQlSERVER();
   			 
   			  $sel = "select co_ven,telefonos,campo1 as correo, campo3 as telefono2  
   			  from  saVendedor";

   			  if ($vendedor) {
   			  	$sel .= " where co_ven = '$vendedor' ";
   			  }
		      	$rs=sqlsrv_query($conn,$sel);
		      	$datos = array(
		      		'telefonos' => 0,
		      		'telefono2' => 0,
		      		'correo' => 0
		      	);
		      
		      	$i=0;

		        while($row=sqlsrv_fetch_array($rs)) {
		            foreach($row as $key=>$value) {
		              $datos[$i][$key]=$value;
		            }
		            $i++;
		        }
		      sqlsrv_free_stmt($rs);
			return $datos;

   		}

   		public function getfacturasParaEmail() {
   			  $conn = conectarSQlSERVER();   			 
   			  $sel = "SELECT fv.doc_num, fv.co_ven,ven.ven_des,
							 ven.telefonos,ven.campo1 as correo, ven.campo3 as telefono2  
   			   from saFacturaVenta as fv 
						INNER JOIN  saVendedor as ven ON ven.co_ven = fv.co_ven
						where fv.impresa = 1 and fv.anulado = 0 and ven.campo1 is not null
						and fv.fec_emis >= '".$this->inicioEnvios."'";
		      	$rs = sqlsrv_query($conn,$sel);
		      
		      	$i=0;
 				$datos = array();
		        while($row=sqlsrv_fetch_array($rs)) {
		            foreach($row as $key=>$value) {
		              $datos[$i][$key]=$value;
		            }
		            $i++;
		        }
		      sqlsrv_free_stmt($rs);
			return $datos;

   		}
	  	public function setEmailDetalles($datos) {
    		 $conn = $this->getConMYSQL();
    		 $doc = trim($datos['doc_num']);
    		 $bus = "SELECT * FROM `correomasivo` WHERE `documento` = '$doc'";

	        $msn = array(
	          'error'=>'no',
	          'mensa'=>''
	        );
    		 $rsb = mysqli_query($conn,$bus);
    		 if (mysqli_num_rows($rsb) == 0) {
    		  	
		        $sel="INSERT INTO `correomasivo`(`id`, `de`, `destino`, `titulo`, `cuerpo`, `nombre`, `tipo`, `enviado`, `fecha`, `fenviado`,documento,co_ven) VALUES 
		        (null,'".$datos['From']."','".$datos['destino']."','".$datos['Subject']."','".$datos['body']."','".$datos['FromName']."','".$datos['tipo']."','".$datos['Subject']."',CURRENT_TIME(),'".$datos['Subject']."','".$datos['doc_num']."','".$datos['co_ven']."')";
	 
		        $rs = mysqli_query($conn,$sel);


		        if (mysqli_errno($conn)) {

		          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
		         // $this->setMensajes('danger',$mensa);
		           $msn = array(
		          'error'=>'si',
		          'mensa'=>$mensa
		        );

	        }
    		}



	        return  $msn;
		}
	  	public function getMasivos() {
    		 $conn = $this->getConMYSQL() ;
	        $sel="SELECT * FROM `correomasivo` where enviado=0";
 
	        $rs = mysqli_query($conn,$sel);

	        $msn = array(
	          'error'=>'no',
	          'mensa'=>''
	        );

	        if (mysqli_errno($conn)) {

	          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
	         // $this->setMensajes('danger',$mensa);
	           $msn = array(
	          'error'=>'si',
	          'mensa'=>$mensa
	        );

	        }else{
		       $datos = array();
		          $i=0;
		          while($row=mysqli_fetch_array($rs)) {
		            foreach($row as $key=>$value) {
		              $datos[$i][$key]=$value;
		            }
		            $i++;
		          }
			      $msn = array(
			          'error'=>'no',
			          'datos'=>$datos
			        );

	        }

	        return $msn;
		}
	  	public function setEstadoMasivo($enviado,$documento) {
    		 $conn = $this->getConMYSQL() ;
	        $sel="UPDATE `correomasivo` SET `enviado` = '$enviado',fenviado=CURRENT_TIME() WHERE `correomasivo`.`documento` = $documento;";
 
	        $rs = mysqli_query($conn,$sel);

	        $msn = array(
	          'error'=>'no',
	          'mensa'=>''
	        );

	        if (mysqli_errno($conn)) {
		          $mensa = "Ocurrio un error ".mysqli_errno($conn).": ". mysqli_error($conn);
		         // $this->setMensajes('danger',$mensa);
		           	$msn = array(
		         	 'error'=>'si',
		          	'mensa'=>$mensa
		       		);

	        }

	        return $msn;
		}

	}

 ?>