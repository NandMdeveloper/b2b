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
$tsid=strftime( "%Y%m%d%H%M%S", time() );
$randx=  rand(0,100);
$tsid="t".$randx.$tsid;

if (isset($_REQUEST['tspar'])) $TSPar = $_REQUEST['tspar']; 
else $TSPar=10;

if (isset($_REQUEST['tsr'])) $tsr = $_REQUEST['tsr'];//REQUEST USER
else $tsr="0";

if (isset($_REQUEST['tss'])) $tss = $_REQUEST['tss'];//REQUEST USER
else $tss="0";

if (isset($_REQUEST['tsls'])) $tsls = $_REQUEST['tsls'];//REQUEST USER
else $tsls="0101010";

$tssnothing=FALSE;

$tmbanksssuccess=0;

$tslsR="";

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

$table2="tmbank";
$select2="UserCode, BankCode, BankDescrip, BankStatus, BankNote, tssit, TSSincStatus   "  ; 
$where2=" (TSSincStatus = 1 OR TSSincStatus = 2) ";
$order2=" BankCode";
            $r1=$ObjBdQ->Query_Select_while2($table2,$select2,$where2,$order2);
            if (mysql_num_rows($r1) > 0) {
                $response["tmbank"] = array();//tag 
                while ($row = mysql_fetch_array($r1)) {
                    // temp user array
                    $tsline = array();
                    $tsline["UserCode"] = $row["UserCode"];
                    $tsline["BankCode"] = $row["BankCode"];
                    $tsline["BankDescrip"] = utf8_encode($row["BankDescrip"]);                    
                    $tsline["BankStatus"] = $row["BankStatus"];
                    $tsline["tssit"] = $row["tssit"];                    
                    $tsline["TSSincStatus"] = $row["TSSincStatus"];                    
                    
                    // push single product into final response array
                    array_push($response["tmbank"], $tsline);
                    }
                    $response["tmbanksssuccess"] = 1; //tag table item JSON
                    $tmbanksssuccess=1;
                    
                    $response["success"] = 1;
                    $response["message"] = "with data tmbank";
                    $response["ue"] = 1;//user enable
                    $response["tslsR"] = $tslsR;//LastSinc
                    
                    
    $tssnothing=TRUE;
            }else { $tmbanksssuccess=0;  $tssnothing=TRUE; $response["ue"] = 1;  $response["tslsR"] = $tslsR; } //user enable} 
        }else{$tssnothing=FALSE;}                     
        
 //--------------------------------------------------------------------------            
    }else {    $tmbanksssuccess=0;    }

 }
if ($tmbanksssuccess==0)      
    { 
        $response["tmbanksssuccess"]=0;
        $response["success"] = 0;
        $response["message"] = "No found bank";
      }
//ALWAYS PRINT JSON
echo json_encode($response);      
      
function tsfungetuser($tab){
        $tab="tabla=0";
		return $tab;
	}

?>
