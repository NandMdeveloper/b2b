<?php
/*$withup="";
$server = "192.168.0.138";//PRO-HOME C.A.
//$server = "192.168.1.54";//TEODORA SOFTWARE C.A.
//
 */


$withup="";
$server = "192.168.0.10";//PRO-HOME C.A.
//$server = "192.168.1.11";//TEODORA SOFTWARE C.A.

$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "PSControlDB"); //PRO-HOME C.A.
//$options = array(  "UID" => "sa",  "PWD" => "Admin2050",  "Database" => "PSControlDB"); //TEODORA SOFTWARE C.A.

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "Conectado a Sql Server 2012 ok <br>";
//sqlsrv_close($conn);	
	
	 $sql = "SELECT  TOP 1 StatusC from TSVTTControl ";//return data to sinc
	
	
	
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}  
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//    echo "<br>".$row['StatusC']."<br>";
    $withup=    $row['StatusC'];
    }

//$withup THIS CONTROL IF CHANGE
$withup='1000';//tempo

if ($withup!='0000') {
    //INI MY
    $tsid=strftime( "%Y%m%d%H%M%S", time() );
    $randx=  rand(0,100);
    $tsid="t".$randx.$tsid;

    echo "<br>WITH DATA:".$withup;
    $TSObjProdure = new TSFProcedurex();   
    $TSObjProdure->tsFTSPSENLISTPayment($conn,1,$tsid);//$sCod_Id = 1 PREPARE DATE

    include("../lib/core.lib.php");
    $ObjBdQ= new BdQuery(); 
    $act=FALSE;

    if ($withup[0]=='1'){
    //$sql = "read PSTMsaArticulo ";--------------------------------------------
        $sql = "SELECT RTRIM(LTRIM(co_ven)) AS co_ven, RTRIM(LTRIM(co_cli)) AS co_cli, RTRIM(LTRIM(nro_doc)) AS nro_doc, RTRIM(LTRIM(n_control)) AS n_control 
		        ,RTRIM(LTRIM(co_tipo_doc)) AS co_tipo_doc, CONVERT(varchar(20), fec_emis, 120) AS fec_emis,
                CONVERT(varchar(20),fec_venc , 120) AS fec_venc,total_bruto,monto_imp,total_neto,saldo,observa
                ,RTRIM(LTRIM(doc_orig)) AS doc_orig, RTRIM(LTRIM(nro_orig)) AS nro_orig                
                FROM PSTTsaDocumentoVenta WHERE PSStatusSinc = 1";
    
        $stmt3 = sqlsrv_query( $conn, $sql );
        if( $stmt3 === false) {
            die( print_r( sqlsrv_errors(), true) );
            }
        $valuesDocControl="";
        $valuesDocControlb="";
        $comma="";
           $msit = "";
                //$msit = "";
            $msit=str_replace(" ","",$msit);
            $msit=str_replace(":","",$msit);
            $msit = $tsid.$msit.$randx;
            
        while( $row = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
            //$msit = $row['tssit'];
            //$msit = $row['TSType'];
           
            //$msit = "";
            //$msit=str_replace(" ","",$msit);
            //$msit=str_replace(":","",$msit);
            //$msit = $tsid.$msit.$randx;
            
            $valuesDocControl="('".$row['co_ven']."','".$row['co_cli']."','".utf8_encode($row['nro_doc'])."','".$row['n_control']
                    ."','".$row['co_tipo_doc']."','".$row['fec_emis']."','".$row['fec_venc']."','".$row['total_bruto']
                    ."','".$row['monto_imp']."','".$row['total_neto']."','".$row['saldo']
                    ."','".utf8_encode($row['observa'])."','".$row['doc_orig']."','".$row['nro_orig']."', 1, '".$msit."')";
            
            $valuesDocControlb=$valuesDocControlb.$comma.$valuesDocControl; 
            $comma=",";
            }
        //echo "<hr>f".$valuesArtControlb."<hr>";
        //CLAEAN TABLE BEFORE INSERT  
        $table2="ttdoc"; 
        $where2='1=1';//DELETE ALL
        $MAXId=$ObjBdQ->Query_Delete($table2, $where2);
        
        //INSERT INTO 
        $table2="ttdoc";    
        $select2="UserCode, CustCode,DocNumber, DocControl, DocType, DocDate, DocDueDate, DocTotalSub, DocTotalTax, DocTotal, "
                . "DocBalance, DocNote, DocOrig,DocOrigNumber, TSSincStatus, tssit   "  ; 
        $values2=$valuesDocControlb; 
        $r2=$ObjBdQ->Query_InsertMV($table2,$select2,$values2);//into bd
        $act=TRUE;
        }//END INSERT PSTMsaArticulo--------------------------------------------

         //Does no apply $OP= new TSBdQueryProcedure(); 
         //
         //
//         //INSERT-UPDATE HERE ONLY MYSQL TABLE  art
//         if ($withup[0]=='1'){
//             $r3=$OP->TSBdQueryProcedureMain("art");//REN VAR = TABLE UPDATE HERE IN THIS CASE MYSQL
//            }   
        //INSERT-UPDATE HERE ONLY MYSQL TABLE  clientes            

}
else echo "<br>WITHOUT DATA REN:".$withup;
sqlsrv_close($conn);

class TSFProcedurex{
	function tsFTSPSENLISTPayment($conn,$TSParId,$sCod_Id){//SQLSERVER
            // specify params - MUST be a variable that can be passed by reference!
            $myparams['TSParId'] = $TSParId;//$sCod_Id = 1 PREPARE DATE, $sCod_Id = 1 PREPARE DATE, $sCod_Id = 2 READ DATE 
            $myparams['TSL_Id'] = $sCod_Id;
            $myparams['sCod_Id'] = $sCod_Id;
            
            // Set up the proc params array - be sure to pass the param by reference
            $procedure_params = array(
                array(&$myparams['TSParId'], SQLSRV_PARAM_IN),
                array(&$myparams['TSL_Id'], SQLSRV_PARAM_IN),
                array(&$myparams['sCod_Id'], SQLSRV_PARAM_OUT)
                );
            $sql = "EXEC TSPSENDLIST02 @TSParId = ?, @TSL_Id = ?, @sCod_Id = ?";
            $stmt2 = sqlsrv_prepare($conn, $sql, $procedure_params);
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            //work---------------------------
            if(sqlsrv_execute($stmt2)){
            $row = sqlsrv_fetch_array($stmt2);
            //echo "<br>row:".$row;
//                while($res = sqlsrv_next_result($stmt2)){
//                    echo "<br>respuesta:".$res;  // erncheck it
//                    echo "<br>myparams:".$myparams['sCod_Id'];
//                    }
                }
            }
//	function tsFUpDataMySql($conn,$TSParId,$sCod_Id){//SQLSERVER

        }
//------------------------------------------------------------------------------        
?>