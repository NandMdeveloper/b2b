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

if (isset($_REQUEST['tsw'])) $tsw = $_REQUEST['tsw'];//DATA USER
else $tsw=0;

if (isset($_REQUEST['tse'])) $tse = $_REQUEST['tse'];//DATA email
else $tse=0;

if (isset($_REQUEST['tss'])) $tss = $_REQUEST['tss'];//DATA email
else $tss="";



$tssnothing=FALSE;
$tmuserssuccess="0";

//$TSPar=1;$ts100=100;
//$TSPar=0;$ts100=100;

if ($TSPar==1){//REQUESTING DATA
    $response = array();
    $ObjBdQ= new BdQuery(); 
    //TSUSER--------------------------------------------------------------------
    if ($tsr!="0"){

      if ($tssit!="0"){//REQUESTING DATA USER CHECK STATUS
            $table2="ttsincdatainlog";    
            $select2="sincdataload,ttsincdataloaddate,sincdatajson"; 
            $tse=$tse.":tshere:".$tsr;
            //$valores="'".$tse."','".$tstime."','".$json."tsas".$tsas."'"."tss".$tssit."'"; 
            $valores="'".$tse."','".$tstime."','tss-".$tss."|".":tssit".$tssit."'"; 
            //$where2="UserStatus = '1' AND UserCode = '".$tsr."'";
            //$where2="";//TEMPO
            $r0=$ObjBdQ->Query_Insert($table2,$select2,$valores);//into bd
        }
        

//REQUESTING DATA USER
        $table2="tmuser";
        $select2="UserId, UserCode, UserPassword, UserName, UserStatus"; 
        $where2="UserStatus = '1' AND UserCode = '".$tsr."' AND UserPassword = '".$tsw."'";
        //$where2="";//TEMPO
        
        $order2=" UserCode";
        $result=$ObjBdQ->Query_Select_while2($table2, $select2, $where2, $order2);
        if (mysql_num_rows($result) > 0) {
            $response["tmusers"] = array();//Ren Run the original code list
            while ($row = mysql_fetch_array($result)) {
                // temp user array
                $tsline = array();
                $tsline["UserId"] = $row["UserId"];//Ren Run the original code list
                $tsline["UserCode"] = $row["UserCode"];//Ren Run the original code list
                $tsline["UserPassword"] = $row["UserPassword"];//Ren Run the original code list
                $tsline["UserName"] = $row["UserName"];//Ren Run the original code list
                $tsline["UserStatus"] = $row["UserStatus"];//Ren Run the original code list
                // push single product into final response array
                array_push($response["tmusers"], $tsline);//Ren Run the original code list
                }
                $response["tmuserssuccess"] = "1";
                $response["success"] = 1;
                $tssnothing=TRUE;
             }else {    $tmuserssuccess="4";    } 

//            }
 //--------------------------------------------------------------------------            
    }else {    $tmuserssuccess="3";    }

}
 else {    $tmuserssuccess="2";    }

if ($tssnothing!=TRUE)      
    { 
        $response["tmuserssuccess"]=$tmuserssuccess;
        $response["success"] = 0;
        $response["message"] = "No found";
      }
//ALWAYS PRINT JSON
echo json_encode($response);      
      


function tsfungetuser($tab){
        $tab="tabla=0";
		return $tab;
	}

?>