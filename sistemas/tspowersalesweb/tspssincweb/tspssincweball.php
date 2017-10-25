<?php 
//WORKING WELL
session_start(); 
session_unset(); 
session_destroy(); 
//echo "ts hello ren :)"; ?>
<?php include("../lib/core.lib.php"); ?>
<?php //include("/lib/Core.lib.php"); ?>
<?php //include("../lib/Core.lib.php"); ?>
<?php //include("../../lib/Core.lib.php"); ?>

<?php 
$tsbo01=tsbo01;
$tstime=strftime( "%Y-%m-%d %H:%M:%S", time() );
//echo "<br>".$tstime."<br>";
$tssit=strftime( "%Y%m%d%H%M%S", time() );
$randx=  rand(0,100);
$tssit="t".$randx.$tssit;

if (isset($_REQUEST['tspar'])) $TSPar = $_REQUEST['tspar']; 
else $TSPar=10;

if (isset($_REQUEST['tsr'])) $tsr = $_REQUEST['tsr'];//REQUEST USER
else $tsr="0";

if (isset($_REQUEST['tse'])) $tse = $_REQUEST['tse'];//DATA email
else $tse=0;

if (isset($_REQUEST['tsls'])) $tsls = $_REQUEST['tsls'];//REQUEST USER
else $tsls="0101010";//ONLY FOR IITIALIZATION
$tslsR="";

if (isset($_REQUEST['tss'])) $tss = $_REQUEST['tss'];//REQUEST USER
else $tss="0";

$tssnothing=FALSE;
//$tmuserssuccess="0";
$tmcustomerssuccess=0;

if ($TSPar==1){//REQUESTING DATA
    $response = array();
    $ObjBdQ= new BdQuery(); 
    //TSUSER--------------------------------------------------------------------
    if ($tsr!="0"){//REQUESTING DATA USER CHECK STATUS
        $table2="tmuser";    
        $select2="UserId, UserCode, UserName, UserStatus"; 
        $where2="UserStatus = '1' AND UserCode = '".$tsr."'";
        //$where2="";//TEMPO
        $order2=" UserCode";
        $r0=$ObjBdQ->Query_Select_col($select2,$table2,$where2,$order2);
        if($r0){ //ACTIVE USER
            $UserId = $r0["UserId"];   
            $UserCode = $r0["UserCode"];   
            $UserName = $r0["UserName"];   
            $UserStatus = $r0["UserStatus"];   

            $table2="ttsincdataloadAll";    
            $select2="sincdataload,ttsincdataloaddate,sincdatajson"; 
            $tse=$tse.$tsr.":aca";
            //$valores="'".$tse."','".$tstime."','".$json."tsas".$tsas."'"."tss".$tssit."'"; 
            $valores="'".$tse."','".$tstime."','tsls:".$tsls."|tss".$tssit."'"; 
            //$where2="UserStatus = '1' AND UserCode = '".$tsr."'";
            //$where2="";//TEMPO
            $r0=$ObjBdQ->Query_Insert($table2,$select2,$valores);//into bd
        //----------------------------------------------------------------------
        //
            //UPDATE DATA TO SEND
            if ($tsls!="0101010"){
                 $OP= new TSBdQueryProcedure(); 
                 $tslsR=$OP->TSBdQueryProcedureALastSinc("tmcustomer",$tsls,$UserCode);//REN VAR = TABLE UPDATE HERE IN THIS CASE MYSQL
                 //echo "<br>tslsR:".$tslsR;
            }
            
            //HERE RUN PROCEDURE GENERATOR DATA TO SEND
            //PROCEDURE();
            
            //SEARCH CUSTOMER SELLER
            //CHECK TABLES, SICN IN THIS CASE CUSTOMER
            $table2="tmcustomer";
            $select2="CustId, rtrim(ltrim(CustCode)) AS CustCode, CustDesc, CustDirF, CustRIF, CustTele, CustTeleFax, CustEmail, CustStatus, "
                    . "CustZone, CustCountry, CustState, CustCity, CustBranch, CustPagineW, CustDayCredit, CustBalance, "
                    . "CustClassif, CustUserCrea, CustDateCrea, CustUserModi, CustDateModi, CustSIT, rtrim(ltrim(SellCode)) AS SellCode, CustType, "
                    . "CustTaxPayer, CustRespons, CustNote, CustSincStatus "; 
            
            //$where2="CustSincStatus = 1";
            $where2=" (SellCode = '".$tsr."') AND (CustSincStatus = 1 OR CustSincStatus = 2) ";
            //$where2="";//TEMPO
            $order2=" CustCode";
            $r1=$ObjBdQ->Query_Select_while2($table2,$select2,$where2,$order2);
            if (mysql_num_rows($r1) > 0) {
                $response["tmcustomers"] = array();//Ren Run the original code list
                $sf="";
                while ($row = mysql_fetch_array($r1)) {
                    // temp user array
                    $tsline = array();
$tsline["CustCode"] = utf8_encode(ltrim(rtrim($row["CustCode"])));      
$tsline["CustDesc"] = utf8_encode($row["CustDesc"]);    
$tsline["CustDirF"] = utf8_encode($row["CustDirF"]);    
$tsline["CustRIF"] = utf8_encode($row["CustRIF"]);    
$tsline["CustTele"] = utf8_encode($row["CustTele"]);    
$tsline["CustTeleFax"] = utf8_encode($row["CustTeleFax"]);  
$tsline["CustEmail"] = utf8_encode($row["CustEmail"]);   
$tsline["CustStatus"] = utf8_encode($row["CustStatus"]); 
$tsline["CustZone"] = utf8_encode($row["CustZone"]);    
$tsline["CustCountry"] = $row["CustCountry"];    
$tsline["CustState"] = $row["CustState"];    
$tsline["CustCity"] = $row["CustCity"];   
$tsline["CustBranch"] = $row["CustBranch"]; 
$tsline["CustPagineW"] = utf8_encode($row["CustPagineW"]);
$tsline["CustDayCredit"] = $row["CustDayCredit"];
$tsline["CustBalance"] = $row["CustBalance"]; 
$tsline["CustClassif"] = $row["CustClassif"];   
$tsline["SellCode"] = utf8_encode(ltrim(rtrim($row["SellCode"])));  
$tsline["CustType"] = utf8_encode($row["CustType"]);  
$tsline["CustSincStatus"] = utf8_encode($row["CustSincStatus"]); 
$tsline["CustSIT"] = utf8_encode($row["CustSIT"]); 
$tsline["CustDateCrea"] = utf8_encode($row["CustDateCrea"]);  
$tsline["CustType"] = utf8_encode($row["CustType"]);   
$tsline["CustTaxPayer"] = utf8_encode($row["CustTaxPayer"]);    
$tsline["CustRespons"] = utf8_encode($row["CustRespons"]);   
$tsline["CustNote"] = utf8_encode($row["CustNote"]);   
                    
                    // push single product into final response array
                    array_push($response["tmcustomers"], $tsline);
                    }
                    $response["tmcustomerssuccess"] = 1; //tag table customer JSON
                    $tmcustomerssuccess=1;
                    
                    $response["success"] = 1;
                    $response["message"] = "with data cutomer";
                    $response["ue"] = 1;//user enable
                    $response["tslsR"] = $tslsR;//LastSinc
                    
                    $tssnothing=TRUE;
            }else { $tmcustomerssuccess=0;  $tssnothing=TRUE; $response["ue"] = 1;  $response["tslsR"] = $tslsR; } //user enable} 
        }else{$tssnothing=FALSE;}
        
 //--------------------------------------------------------------------------            
    }else {    $tmuserssuccess=0;    }

 }
if ($tmcustomerssuccess==0)      
    { 
        $response["tmcustomerssuccess"]=0;
        $response["success"] = 0;
        $response["message"] = "No found";
        if (!$tssnothing){
           $response["ue"] = 0;//user denable
        }
        $response["tslsR"] = $tslsR;//LastSinc
      }
//ALWAYS PRINT JSON
echo json_encode($response);      
      
function tsfungetuser($tab){
        $tab="tabla=0";
		return $tab;
	}

?>
