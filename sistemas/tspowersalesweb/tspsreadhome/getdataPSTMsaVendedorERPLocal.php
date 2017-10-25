<?php
 echo "<br>getdataerplocalPSTMsaVendedorERP<br>";
 //IN THIS FILE DO CICLE FOR, FOR AMOUNT REGISTRES 

$withup="";
$server = "192.168.0.10";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "Conectado a Sql Server 2014 ok <br>";
//sqlsrv_close($conn);	
$sql = "SELECT RTRIM(LTRIM(tsa.co_ven))AS co_ven, tsa.tipo, tsa.ven_des, tsa.numcom, CONVERT (NVARCHAR(100), 
    tsa.feccom) AS feccom, tsa.dis_cen, tsa.cedula,
    tsa.direc1, tsa.direc2, tsa.telefonos, CONVERT (NVARCHAR(100), tsa.fecha_reg) AS fecha_reg, tsa.inactivo, tsa.comision, tsa.comentario, tsa.fun_cob, 
    tsa.fun_ven, tsa.comisionv,  tsa.login, 'x' AS password, tsa.email, tsa.PSW_M, tsa.campo1, tsa.campo2, tsa.campo3, 
		tsa.campo4, tsa.campo5, tsa.campo6, tsa.campo7, tsa.campo8, 1 AS PSStatusSinc
		FROM [ACCE].dbo.[saVendedor] tsa";
// echo '<br>sql:  '.$sql .'<br><br>';
 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {    die( print_r( sqlsrv_errors(), true) );}  
$withup=''; $i=0;   $comma='';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    if ($i==1) $comma = ",";
  $withup.=   $comma."('".$row['co_ven']."',"
                    ."'".$row['tipo']."',"
                    ."'".utf8_encode($row['ven_des'])."',"    
                    ."'".$row['numcom']."',"	                
                    ."'".$row['feccom']."',"	 
                    ."'".$row['dis_cen']."',"
                    ."'".$row['cedula']."',"					
                    ."'".$row['direc1']."',"
                    ."'".$row['direc2']."',"					
                    ."'".$row['telefonos']."',"
                    ."'".$row['fecha_reg']."',"					
                    ."'".$row['inactivo']."',"
                    ."'".$row['comision']."',"
                    ."'".$row['comentario']."',"
                    ."'".$row['fun_cob']."',"
                    ."'".$row['fun_ven']."',"
                    ."'".$row['comisionv']."',"
                    ."'".$row['login']."',"
                    ."'".$row['password']."',"
                    ."'".$row['email']."',"
                    ."'".$row['PSW_M']."',"
                    ."'".$row['campo1']."',"	                       ."'".$row['campo2']."',"
                    ."'".$row['campo3']."',"		                    ."'".$row['campo4']."',"
                    ."'".$row['campo5']."',"		                    ."'".$row['campo6']."',"
                    ."'".$row['campo7']."',"		                    ."'".$row['campo8']."',"
                    ."'".$row['PSStatusSinc']."')";					
    $i++;
    }
//$withup='0000';
if ($withup!='0000') {
    //INI MY
    $tsid=strftime( "%Y%m%d%H%M%S", time() );
    $randx=  rand(0,100);
    $tsid="t".$randx.$tsid;

  $serverTWO = "192.168.0.11";   //PRO-HOME
    $optionsTWO = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "B2BDB");


$connTWO = sqlsrv_connect($serverTWO, $optionsTWO);
if ($connTWO === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "<br><br> Conectado a Sql Server 2014 ok PSControlDB <br>";
//CLEAN
        $sqlTWOCLEAN = " DELETE FROM [dbo].[ERPPSTMsaVendedor]";
//        echo '<br>sqlTWO:  '.$sqlTWOCLEAN .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWOCLEAN );
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
} 
//INSERT
        $sqlTWO = " INSERT INTO  [dbo].[ERPPSTMsaVendedor] 
(co_ven, tipo, ven_des, numcom, feccom, dis_cen, cedula, direc1, direc2, telefonos, fecha_reg, inactivo, comision, 
comentario, fun_cob, fun_ven, comisionv, login, password, email, PSW_M, campo1, campo2, campo3, campo4, campo5, 
campo6, campo7, campo8, PSStatusSinc) ";
        $sqlTWO.=' VALUES '.$withup;
//        echo '<br>sqlTWO:  '.$sqlTWO .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWO );
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
}  
}
else echo "<br>WITHOUT DATA REN :".$withup;
sqlsrv_close($connTWO);
sqlsrv_close($conn);
//------------------------------------------------------------------------------   
echo "<br>END";
?>