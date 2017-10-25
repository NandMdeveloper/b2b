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
//$tmuserssuccess="0";
//$tmcustomerssuccess=0;
$tmitemsssuccessu=0;

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

        //----------------------------------------------------------------------
        //UPDATE DATA TO SEND
            //if ($tsls!="0"){
            
            if ($tsls!="0101010"){                
                 $OP= new TSBdQueryProcedure(); 
                 $tslsR=$OP->TSBdQueryProcedureALastSinc("tmitemu",$tsls,$UserCode);//REN VAR = TABLE UPDATE HERE IN THIS CASE MYSQL
                 //echo "<br>tslsR:".$tslsR."<br>";
            }
            
//           $table2="tmitemu Inner Join meta_art_vende ON tmitemu.ItemuCode = meta_art_vende.co_art ";
//            $select2="tmitemu.ItemuCode, tmitemu.UnitCode, tmitemu.Relationship, tmitemu.Equivalence, tmitemu.UseVenta, tmitemu.MainUnit, 
//                      tmitemu.PrimaryUse, tmitemu.SecundaryUnit, tmitemu.SecundaryUse, tmitemu.ItemUStatus, tmitemu.tssit, tmitemu.TSSincStatus  ";
//            $where2="(meta_art_vende.co_ven = '".$tsr."') AND(tmitemu.TSSincStatus = 1 OR tmitemu.TSSincStatus = 2)";

//$table2="tmitemu Inner Join meta_art_vende ON tmitemu.ItemuCode = meta_art_vende.co_art 
//AND meta_art_vende.co_ven = '".$tsr."' AND meta_art_vende.status = 0 LEFT JOIN ttsincitemunituser ON 
//tmitemu.ItemuCode = ttsincitemunituser.ItemuCode AND tmitemu.UnitCode = ttsincitemunituser.UnitCode AND 
//tmitemu.tssit = ttsincitemunituser.tssit AND meta_art_vende.co_art= ttsincitemunituser.ItemuCode AND
//meta_art_vende.co_ven = ttsincitemunituser.UserCode ";

//$select2="rtrim(ltrim(tmitemu.ItemuCode)) AS ItemuCode, rtrim(ltrim(tmitemu.UnitCode))AS UnitCode , tmitemu.Relationship, tmitemu.Equivalence, tmitemu.UseVenta, 
//tmitemu.MainUnit, tmitemu.PrimaryUse, tmitemu.SecundaryUnit, tmitemu.SecundaryUse, tmitemu.ItemUStatus, 
//tmitemu.tssit, tmitemu.TSSincStatus ";

//$where2="(ttsincitemunituser.ItemuCode IS NULL ) ";
//$order2=" tmitemu.ItemuCode";

            $query = "SELECT rtrim(ltrim(tmitemu.ItemuCode)) AS ItemuCode, rtrim(ltrim(tmitemu.UnitCode))AS UnitCode , tmitemu.Relationship, tmitemu.Equivalence, tmitemu.UseVenta, tmitemu.MainUnit, tmitemu.PrimaryUse, tmitemu.SecundaryUnit, tmitemu.SecundaryUse, tmitemu.ItemUStatus, 
                tmitemu.tssit, tmitemu.TSSincStatus from tmitemu inner join art on tmitemu.ItemuCode = art.co_art LEFT JOIN ttsincitemunituser ON tmitemu.ItemuCode = ttsincitemunituser.ItemuCode AND tmitemu.UnitCode = ttsincitemunituser.UnitCode AND tmitemu.tssit = ttsincitemunituser.tssit AND art.co_art= ttsincitemunituser.ItemuCode   WHERE (ttsincitemunituser.ItemuCode IS NULL )  ORDER BY  tmitemu.ItemuCode;"; 
            $r1=$ObjBdQ->Select_Query($query);
            if (mysql_num_rows($r1) > 0) {
                $response["tmitemsu"] = array();//tag 
                while ($row = mysql_fetch_array($r1)) {
                    // temp user array
                    $tsline = array();
                    $tsline["ItemuCode"] = $row["ItemuCode"];
                    $tsline["UnitCode"] = utf8_encode($row["UnitCode"]);                    
                    $tsline["Relationship"] = $row["Relationship"];
                    $tsline["Equivalence"] = $row["Equivalence"];                    
                    $tsline["UseVenta"] = $row["UseVenta"];                    
                    //$tsline["UsePurchase"] = $row["UsePurchase"];                    
                    $tsline["MainUnit"] = $row["MainUnit"];                    
                    $tsline["PrimaryUse"] = $row["PrimaryUse"];                    
                    $tsline["SecundaryUnit"] = $row["SecundaryUnit"];                    
                    $tsline["ItemUStatus"] = $row["ItemUStatus"];                    
                    $tsline["tssit"] = $row["tssit"];                    
                    $tsline["TSSincStatus"] = $row["TSSincStatus"];                    
                    
                    // push single product into final response array
                    array_push($response["tmitemsu"], $tsline);
                    }
                    $response["tmitemsssuccessu"] = 1; //tag table item JSON
                    $tmitemsssuccessu=1;
                    
                    $response["success"] = 1;
                    $response["message"] = "with data item U";
                    $response["ue"] = 1;//user enable
                    $response["tslsR"] = $tslsR;//LastSinc
                    
//                    $tssnothing=TRUE;
//            }else { $tmcustomerssuccess=0;    } 
//        }else{$tssnothing=FALSE;}
    $tssnothing=TRUE;
            }else { $tmitemsssuccessu=0;  $tssnothing=TRUE; $response["ue"] = 1;  $response["tslsR"] = $tslsR; } //user enable} 
        }else{$tssnothing=FALSE;}                     
        
 //--------------------------------------------------------------------------            
    }else {    $tmitemsssuccessu=0;    }

 }
if ($tmitemsssuccessu==0)      
    { 
        $response["tmitemsssuccessu"]=0;
        $response["success"] = 0;
        $response["message"] = "No found item";
      }
//ALWAYS PRINT JSON
echo json_encode($response);      
      
function tsfungetuser($tab){
        $tab="tabla=0";
		return $tab;
	}

?>
