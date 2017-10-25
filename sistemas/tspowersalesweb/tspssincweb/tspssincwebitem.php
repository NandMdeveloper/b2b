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
else $tsls="0101010";//ONLY FOR IITIALIZATION
$tslsR="";


//if (isset($_REQUEST['tsw'])) $tsw = $_REQUEST['tsw'];//DATA USER 
//else $tsw=0;
//if (isset($_REQUEST['tse'])) $tse = $_REQUEST['tse'];//DATA email
//else $tse=0;

$tssnothing=FALSE;
//$tmuserssuccess="0";
//$tmcustomerssuccess=0;
$tmitemsssuccess=0;

//$TSPar=1;$ts100=100;//$TSPar=0;$ts100=100;

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
                 $tslsR=$OP->TSBdQueryProcedureALastSinc("tmitem",$tsls,$UserCode);//REN VAR = TABLE UPDATE HERE IN THIS CASE MYSQL
                 //echo "<br>tslsR:".$tslsR;
            }
            
            //HERE RUN PROCEDURE GENERATOR DATA TO SEND
            //PROCEDURE();
            
            //SEARCH ITEM - USER - SELLER
            //CHECK TABLES, SICN IN THIS CASE CUSTOMER

////HERE CHANGE TABLE meta_art_vende TO meta_itme_seller
//            //            $table2="tmitem";
//            $select2="ItemCode, ItemDesc, ItemUnit, ItemRefe, ItemStatus, ItemPrec1, TaxCode, LineCode, 
//                ModeCode, CateCode, SublCode, ColoCode, TypeCode, ItemDesc2, ItemNote, ItemStockAct, ItemSincStatus ";
//            $where2="(ItemSincStatus = 1 OR ItemSincStatus = 2)";
            
//            $table2="tmitem Inner Join meta_art_vende ON tmitem.ItemCode = meta_art_vende.co_art ";
//            $select2="tmitem.ItemCode, tmitem.ItemDesc, tmitem.ItemUnit, tmitem.ItemRefe, tmitem.ItemStatus, 
//                meta_art_vende.monto AS ItemPrec1, tmitem.TaxCode, tmitem.TaxRate, tmitem.LineCode, 
//                tmitem.ModeCode, tmitem.CateCode, tmitem.SublCode, tmitem.ColoCode, tmitem.TypeCode, tmitem.ItemDesc2, 
//                tmitem.ItemNote, 
//                meta_art_vende.asignada AS ItemStockAct, 
//                2 AS ItemSincStatus,tmitem.ItemSIT ";
//            $where2="(meta_art_vende.co_ven = '".$tsr."') AND (meta_art_vende.status = 0) AND (ItemSincStatus = 1 OR ItemSincStatus = 2)";
$table2="tmitem Inner Join meta_art_vende ON 
    tmitem.ItemCode = meta_art_vende.co_art AND 
    meta_art_vende.co_ven = '".$tsr."' AND 
    meta_art_vende.status = 0  
LEFT JOIN ttsincitemuser ON 
    tmitem.ItemCode = ttsincitemuser.ItemCode AND  tmitem.ItemSIT = ttsincitemuser.ItemSIT AND 
    meta_art_vende.co_art= ttsincitemuser.ItemCode AND   meta_art_vende.co_ven = ttsincitemuser.UserCode  ";
            
            $select2="rtrim(ltrim(tmitem.ItemCode)) as ItemCode, tmitem.ItemDesc, tmitem.ItemUnit, tmitem.ItemRefe, tmitem.ItemStatus, 
                meta_art_vende.monto AS ItemPrec1, tmitem.TaxCode, tmitem.TaxRate, tmitem.LineCode, 
                tmitem.ModeCode, tmitem.CateCode, tmitem.SublCode, tmitem.ColoCode, tmitem.TypeCode, tmitem.ItemDesc2, 
                tmitem.ItemNote, 
                tmitem.ItemStockAct, 
                2 AS ItemSincStatus,tmitem.ItemSIT ";             
$where2="(ttsincitemuser.ItemCode IS NULL )";            
            

            $query = "SELECT rtrim(ltrim(tmitem.ItemCode)) as ItemCode, tmitem.ItemDesc, tmitem.ItemUnit, tmitem.ItemRefe, tmitem.ItemStatus, 
                art.monto AS ItemPrec1, tmitem.TaxCode, tmitem.TaxRate, tmitem.LineCode, 
                tmitem.ModeCode, tmitem.CateCode, tmitem.SublCode, tmitem.ColoCode, tmitem.TypeCode, tmitem.ItemDesc2, 
                tmitem.ItemNote, 
                tmitem.ItemStockAct,
                2 AS ItemSincStatus,tmitem.ItemSIT  FROM tmitem Inner Join art ON 
                tmitem.ItemCode = art.co_art and 
                art.co_precio = 'P1' group by art.co_art";

            
            //$where2="ItemSincStatus = 1 AND SellCode = '".$tsr."'";
            //$where2="";//TEMPO
            $order2=" ItemId";
            $r1=$ObjBdQ->Select_Query($query);
            if (mysql_num_rows($r1) > 0) {
                $response["tmitems"] = array();//tag 
                while ($row = mysql_fetch_array($r1)) {
                    // temp user array
                    $tsline = array();
                    $tsline["ItemCode"] = $row["ItemCode"];
                    $tsline["ItemDesc"] = utf8_encode($row["ItemDesc"]);                    
                    $tsline["ItemUnit"] = $row["ItemUnit"];
                    $tsline["ItemRefe"] = $row["ItemRefe"];                    
                    $tsline["ItemStatus"] = $row["ItemStatus"];                    
                    $tsline["ItemPrec1"] = $row["ItemPrec1"];                    
                    //$tsline["ItemActCost"] = $row["ItemActCost"];                    
                    $tsline["TaxCode"] = $row["TaxCode"];                    
                    $tsline["TaxRate"] = $row["TaxRate"];                    
                    $tsline["LineCode"] = $row["LineCode"];                    
                    $tsline["ModeCode"] = $row["ModeCode"];                    
                    $tsline["CateCode"] = $row["CateCode"];                    
                    $tsline["SublCode"] = $row["SublCode"];                    
                    $tsline["ColoCode"] = $row["ColoCode"];                    
                    $tsline["TypeCode"] = $row["TypeCode"];                    
                    $tsline["ItemDesc2"] = utf8_encode($row["ItemDesc2"]);                    					
                    $tsline["ItemNote"] = $row["ItemNote"];                    
                    $tsline["ItemStockAct"] = $row["ItemStockAct"];                    
                    $tsline["ItemSincStatus"] = $row["ItemSincStatus"];   
                    $tsline["ItemSIT"] = $row["ItemSIT"];   

                    // push single product into final response array
                    array_push($response["tmitems"], $tsline);
                    }
                    $response["tmitemsssuccess"] = 1; //tag table item JSON
                    $tmitemsssuccess=1;
                    
                    $response["success"] = 1;
                     $response["message"] = "with data cutomer";
                     $response["tslsR"] = $tslsR;//LastSinc
                    
                    $tssnothing=TRUE;
            }else { $tmitemsssuccess=0; $response["tslsR"] = $tslsR;   } 
        }else{$tssnothing=FALSE;}
        
 //--------------------------------------------------------------------------            
    }else {    $tmitemsssuccess=0;    }

 }
if ($tmitemsssuccess==0)      
    { 
        $response["tmitemsssuccess"]=0;
        $response["success"] = 0;
        $response["message"] = "No found item";
        $response["tslsR"] = $tslsR;//LastSinc
      }
//ALWAYS PRINT JSON
echo json_encode($response);      
      
function tsfungetuser($tab){
        $tab="tabla=0";
		return $tab;
	}

?>
