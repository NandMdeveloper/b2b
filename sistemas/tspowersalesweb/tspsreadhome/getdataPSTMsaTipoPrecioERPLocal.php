<?php
 echo "<br>getdataerplocalPSTMsaTipoPrecioERP<br>";
 //IN THIS FILE DO CICLE FOR, FOR AMOUNT REGISTRES 

$withup="";
$server = "192.168.0.10";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "Conectado a Sql Server 2014 ok <br>";
//sqlsrv_close($conn);	
$sql = "SELECT RTRIM(LTRIM(tsa.co_precio)) AS co_precio, tsa.des_precio, tsa.incluye_imp, tsa.campo1, tsa.campo2, 
    tsa.campo3, tsa.campo4, tsa.campo5, tsa.campo6, tsa.campo7, tsa.campo8, 
		1 AS PSStatusSinc FROM [ACCE].dbo.saTipoPrecio tsa ";
// echo '<br>sql:  '.$sql .'<br><br>';
 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {    die( print_r( sqlsrv_errors(), true) );}  
$withup=''; $i=0;   $comma='';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    if ($i==1) $comma = ",";
    $withup.=   $comma."('".$row['co_precio']."',"
                    ."'".$row['des_precio']."',"
                    ."'".$row['incluye_imp']."',"    
                    ."'".$row['campo1']."',"	                
                    ."'".$row['campo2']."',"
                    ."'".$row['campo3']."',"					
                    ."'".$row['campo4']."',"
                    ."'".$row['campo5']."',"					
                    ."'".$row['campo6']."',"
                    ."'".$row['campo7']."',"					
                    ."'".$row['campo8']."',"
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
        $sqlTWOCLEAN = " DELETE FROM [dbo].[ERPPSTMsaTipoPrecio]";
//        echo '<br>sqlTWO:  '.$sqlTWOCLEAN .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWOCLEAN );
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
} 
//INSERT
        $sqlTWO = " INSERT INTO  [dbo].[ERPPSTMsaTipoPrecio] 
(co_precio, des_precio, incluye_imp, campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, PSStatusSinc) ";
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
echo "<br>END<br>";
?>