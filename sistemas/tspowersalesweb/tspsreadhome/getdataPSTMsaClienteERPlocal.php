<?php
 echo "<br>getdataerplocalPSTMsaClienteERP<br>";
 //IN THIS FILE DO CICLE FOR, FOR AMOUNT REGISTRES 

$withup="";
//$server = "192.168.0.121";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$server = "192.168.0.10";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
//for ciclo
//echo "Conectado a Sql Server 2014 ok <br>";
//sqlsrv_close($conn);	
//$LASTco_cli='0901001';
$sql = " SELECT count(co_cli) AS co_cli FROM [ACCE].dbo.saCliente ";
//$sql.= "WHERE co_cli > '".$LASTco_cli."'";
// echo '<br>sql:  '.$sql .'<br><br>';
 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {    die( print_r( sqlsrv_errors(), true) );}  



$withup=''; $i=0;   $comma='';
$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
echo "<br>".$row['co_cli']."<br><hr>";
$cyclefor=$row['co_cli'];
$cyclefor=  $cyclefor/1000;
//$cyclefor=  intval($cyclefor)+1;
$cyclefor=  intval($cyclefor);
$cyclefor++;
//echo "<br>ciclofor:".$cyclefor."<br>";
//while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {}

$deleteone=0;  //JUST ONE 
$LASTco_cli='';
//$cyclefor=1; 
//$LASTco_cli='4941001';
//WHERE co_cli >= '5341019'  

//other connction
    $serverTWO = "192.168.0.11";//RED PRO-HOME
    $optionsTWO = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "B2BDB");
    $connTWO = sqlsrv_connect($serverTWO, $optionsTWO);
    if ($connTWO === false) die("<pre>".print_r(sqlsrv_errors(), true));
    
for ($j=0; $j<$cyclefor; $j++){
//    echo "<br>for j:".$j." cyclefor:".$cyclefor."<br>";

//sqlsrv_close($conn);	
//$sql = " SELECT TOP 826  ISNULL(REPLACE(REPLACE(CONVERT (NVARCHAR(95), tsa.cli_des), '\"', ''), '''', ''),'') AS cli_des,  95 BECAUSE ERROR IN 100
$sql = " SELECT TOP 1000    
    ISNULL(RTRIM(LTRIM(tsa.co_cli)),'') AS co_cli , tsa.tip_cli,
    ISNULL(REPLACE(REPLACE(CONVERT (NVARCHAR(95), tsa.cli_des), '\"', ''), '''', ''),'') AS cli_des,   
REPLACE(REPLACE(CONVERT (NVARCHAR(100), tsa.direc1), '\"', ''), '''', '') AS direc1,
CONVERT (NVARCHAR(100), tsa.dir_ent2) AS dir_ent2,
CONVERT (NVARCHAR(100), tsa.direc2) AS direc2, 
    tsa.telefonos, tsa.fax, tsa.inactivo, tsa.comentario, tsa.respons, 
    CONVERT (NVARCHAR(100), tsa.fecha_reg) AS fecha_reg,
    tsa.cond_pag, tsa.co_zon, tsa.co_seg, 
    tsa.co_ven, tsa.rif, tsa.contrib, tsa.dis_cen, tsa.email, tsa.ciudad, tsa.co_pais, tsa.salestax, tsa.estado,
    tsa.campo1, tsa.campo2, tsa.campo3, tsa.campo4, tsa.campo5, tsa.campo6, tsa.campo7, tsa.campo8, tsa.revisado, 
    tsa.trasnfe, 1 AS PSStatusSinc FROM [HOME].dbo.saCliente tsa 
    WHERE tsa.co_cli > '$LASTco_cli'
    ORDER BY tsa.co_cli";
// echo '<Hr><br>sql:  '.$j.': '.$sql .'<br><br>';
 
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {    die( print_r( sqlsrv_errors() , true) );}  
$withup=''; $i=0;   $comma='';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    if ($i==1) $comma = ",";
    $cli_des=str_replace("'","",$row['cli_des']);
    $direc1=str_replace("'","",$row['direc1']);
    $dir_ent2=str_replace("'","",$row['dir_ent2']);
    $direc2=str_replace("'","",$row['direc2']);
    $withup.=   $comma."('".$row['co_cli']."',"
             ."'".$row['tip_cli']."',"
                ."'".utf8_encode($cli_des)."',"    
                ."'".utf8_encode($direc1)."',"
                ."'".utf8_encode($dir_ent2)."'," 
                ."'".utf8_encode($direc2)."',"            
                ."'".utf8_encode($row['telefonos'])."',"
                ."'".utf8_encode($row['fax'])."',"
                ."'".utf8_encode($row['inactivo'])."',"
                ."'".utf8_encode($row['comentario'])."',"
                ."'".utf8_encode($row['respons'])."',"				
                ."'".utf8_encode($row['fecha_reg'])."',"				
                ."'".utf8_encode($row['cond_pag'])."',"
                ."'".utf8_encode($row['co_zon'])."',"
                ."'".utf8_encode($row['co_seg'])."',"
                ."'".utf8_encode($row['co_ven'])."',"
                ."'".utf8_encode($row['rif'])."',"
                ."'".utf8_encode($row['contrib'])."',"
                ."'".utf8_encode($row['dis_cen'])."',"
                ."'".utf8_encode($row['email'])."',"
                ."'".utf8_encode($row['ciudad'])."',"
                ."'".utf8_encode($row['co_pais'])."',"
                ."'".utf8_encode($row['salestax'])."',"
                ."'".utf8_encode($row['estado'])."',"
                ."'".utf8_encode($row['campo1'])."',"	                
		."'".utf8_encode($row['campo2'])."',"
                ."'".utf8_encode($row['campo3'])."',"					
                ."'".utf8_encode($row['campo4'])."',"
                ."'".utf8_encode($row['campo5'])."',"					
		."'".utf8_encode($row['campo6'])."',"
		."'".utf8_encode($row['campo7'])."',"					
		."'".utf8_encode($row['campo8'])."',"
		."'".utf8_encode($row['revisado'])."',"					
		."'".utf8_encode($row['trasnfe'])."',"
                ."'".utf8_encode($row['PSStatusSinc'])."')";
    $LASTco_cli=$row['co_cli'];
    $i++;
    }
//$withup='0000';
if ($withup!='0000') {
    //INI MY
    $tsid=strftime( "%Y%m%d%H%M%S", time() );
    $randx=  rand(0,100);
    $tsid="t".$randx.$tsid;

//CLEAN
    
if ($deleteone==0){//JUST ONE 
        $sqlTWOCLEAN = " DELETE FROM [dbo].[ERPPSTMsaCliente]";
//        echo '<br>sqlTWO:  '.$sqlTWOCLEAN .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWOCLEAN );
        $deleteone++;
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
} 
}else $deleteone++;


//INSERT
        $sqlTWO = " INSERT INTO [dbo].[ERPPSTMsaCliente] (co_cli, tip_cli, cli_des, direc1, dir_ent2, direc2, telefonos, "
                . "fax, inactivo, comentario, respons, fecha_reg, cond_pag, co_zon, co_seg, co_ven, rif, contrib, "
                . "dis_cen, email, ciudad, co_pais, salestax, estado, campo1, campo2, campo3, campo4, campo5, campo6, "
                . "campo7, campo8, revisado, trasnfe, PSStatusSinc) ";
        $sqlTWO.=' VALUES '.$withup;
//        echo $j.'<br>sqlTWO:  '.$sqlTWO .'<br><br><hr>';
        
$stmtTWO = sqlsrv_query( $connTWO, $sqlTWO );
if( $stmtTWO == false) {    die( print_r( sqlsrv_errors(), true) );}

}
else echo "<hr><hr><hr><br>WITHOUT DATA REN :".$withup.'<hr>';


}//end for

sqlsrv_close($connTWO);
sqlsrv_close($conn);
//------------------------------------------------------------------------------        
 echo "<br>END<br>";
?>