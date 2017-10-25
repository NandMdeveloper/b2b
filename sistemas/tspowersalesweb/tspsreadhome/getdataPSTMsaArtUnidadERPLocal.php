<?php
echo "<br>getdataerplocalPSTMsaArtUnidadERP<br>";
$withup="";
//$server = "192.168.0.121";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$server = "192.168.0.10";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
echo "Conectado a Sql Server 2014 ok <br>";
//sqlsrv_close($conn);	

$sql = " SELECT RTRIM(LTRIM(tsa.co_art)) AS co_art , tsa.co_uni, tsa.relacion, tsa.equivalencia, tsa.uso_venta, 
    tsa.uni_principal, tsa.uso_principal, tsa.uni_secundaria, tsa.uso_secundaria, 1 AS PSStatusSinc 
		FROM [ACCE].dbo.saArtUnidad AS tsa  ";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}  
$withup='';
$i=0;
$comma='';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    if ($i==1) $comma = ",";
    $withup.=   $comma."('".$row['co_art']."',"
                ."'".$row['co_uni']."',"
                ."'".$row['relacion']."',"    
                ."'".$row['equivalencia']."',"
                ."'".$row['uso_venta']."',"            
                ."'".$row['uni_principal']."',"
                ."'".$row['uso_principal']."',"
                ."'".$row['uni_secundaria']."',"
		."'".$row['uso_secundaria']."',"
                ."'".$row['PSStatusSinc']."')";
    $i++;
    }
//$withup='0000';
if ($withup!='0000') {
    //INI MY
    $tsid=strftime( "%Y%m%d%H%M%S", time() );
    $randx=  rand(0,100);
    $tsid="t".$randx.$tsid;
//    echo "<br>WITH DATA:".$withup;
    $serverTWO = "192.168.0.11";   //PRO-HOME
    $optionsTWO = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "B2BDB");

$connTWO = sqlsrv_connect($serverTWO, $optionsTWO);
if ($connTWO === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "<br><br> Conectado a Sql Server 2014 ok PSControlDB <br>";
//CLEAN
        $sqlTWOCLEAN = " DELETE FROM [dbo].[ERPPSTMsaArtUnidad]";
//        echo '<br>sqlTWO:  '.$sqlTWOCLEAN .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWOCLEAN );
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
} 
//INSERT
        $sqlTWO = " INSERT INTO  [dbo].[ERPPSTMsaArtUnidad] 
		(co_art, co_uni, relacion, equivalencia, uso_venta, uni_principal, uso_principal, uni_secundaria, 
		uso_secundaria, PSStatusSinc) ";
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