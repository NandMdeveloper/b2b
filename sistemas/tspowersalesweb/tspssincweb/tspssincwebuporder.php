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

//if (isset($_REQUEST['tsw'])) $tsw = $_REQUEST['tsw'];//DATA USER 
//else $tsw=0;
if (isset($_REQUEST['tse'])) $tse = $_REQUEST['tse'];//DATA email
else $tse=0;
$json="";
if (isset($_REQUEST['json'])) $json = $_REQUEST['json'];//DATA email
else $json="";

if (isset($_REQUEST['tsas'])) $tsas = $_REQUEST['tsas'];//DATA email
else $tsas="";

if (isset($_REQUEST['tss'])) $tssit = $_REQUEST['tss'];//DATA email
else $tssit="";

if (isset($_REQUEST['tsls'])) $tsls = $_REQUEST['tsls'];//REQUEST USER
else $tsls="";

$tssnothing=FALSE;
$tmitemsssuccess=0;

$oc="";
$od="";
//$TSPar=1;$ts100=100;//$TSPar=0;$ts100=100;

if ($TSPar==1){//REQUESTING DATA
    $response = array();
    $ObjBdQ= new BdQuery(); 
    //TSUSER--------------------------------------------------------------------
    if ($tsr!="0"){//REQUESTING DATA USER CHECK STATUS
        if ($tssit!="0"){//REQUESTING DATA USER CHECK STATUS
        $table2="ttsincdataload";    
        $select2="sincdataload,ttsincdataloaddate,sincdatajson"; 
        $tse=$tse.$tsr.":aca";
        //$valores="'".$tse."','".$tstime."','".$json."tsas".$tsas."'"."tss".$tssit."'"; 
        $valores="'".$tse."','".$tstime."','".$json."tsas".$tsas."|"."tss".$tssit."'"; 
        //$where2="UserStatus = '1' AND UserCode = '".$tsr."'";
        //$where2="";//TEMPO
        $r0=$ObjBdQ->Query_Insert($table2,$select2,$valores);//into bd
        //----------------------------------------------------------------------
        //        echo $json."<HR>";
        $json = str_replace(array("\n","\r"),"",$json); 
        $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json); 
        $obj = json_decode($json,TRUE);
         //$obj = json_decode($json,TRUE);
//        foreach ($obj as $indice => $valor) {
//            echo $indice;
//            var_dump($valor);
//        }
        //     echo "<HR>";
        //$ocabrow ="";
        $ocabvalues="";
        $ocabvaluesT="";
        $comma="";
        $comma2="";
      
        $odetvalues="";
        $odetvaluesT="";
        
        $custvalues="";
        $custvaluesT="";
        
    
        $ocabi= 0;
        foreach ($obj as $indice => $valor) {
            //echo "indice:".$indice."<hr>";
            foreach ($valor as $indice2 => $valor2) {
                //echo "indice2:".$indice2."<hr>";
                foreach ($valor2 as $indice3 => $valor3) {
                    //echo "indice3:".$indice3."<hr>";
                    //--------------------------------------------------------------
                    $comma2="";
                    if ($indice3=="ocab") {
                        foreach ($valor3 as $indice4 => $valor4) {
                            //echo "indice4:".$indice4."<hr>";
                            $comma="";
                            foreach ($valor4 as $indice5 => $valor5) {
                                //echo "indice5:".$indice5." aca valor5:".$valor5."<hr>";
                                $ocabvalues =$ocabvalues.$comma."'".$valor5."'";
                               $comma=",";//prirt 2 timetime
                                }                    
                            $ocabvaluesT =$ocabvaluesT.$comma2."(".$ocabvalues.",1,1,'".$tsid."','".$tsas."')";
                            //array_push($ocab["ocab"], $tsline);
                            $comma2=",";//prirt 2 timetime
                            $ocabvalues="";                        
                        }
                    } 
                    else if ($indice3=="odet") {
                        foreach ($valor3 as $indice4 => $valor4) {
                            //echo "indice odet 4:".$indice4."<hr>";
                            $comma="";
                                foreach ($valor4 as $indice5 => $valor5) {
                                    //echo "indice odet 5:".$indice5." aca odet valor5:".$valor5."<hr>";
                                    $odetvalues =$odetvalues.$comma."'".$valor5."'";
                                    $comma=",";//prirt 2 timetime
                                    }                    
                                    $odetvaluesT =$odetvaluesT.$comma2."(".$odetvalues.",1,'".$tsid."','".$tsas."')";
                                $comma2=",";//prirt 2 timetime
                                $odetvalues="";                        
                            }
                        }   
                    else if ($indice3=="cnew") {
                        foreach ($valor3 as $indice4 => $valor4) {
                            //echo "indice odet 4:".$indice4."<hr>";
                            $comma="";
                                foreach ($valor4 as $indice5 => $valor5) {
                                    //echo "indice odet 5:".$indice5." aca odet valor5:".$valor5."<hr>";
                                    $custvalues =$custvalues.$comma."'".$valor5."'";
                                    $comma=",";//prirt 2 timetime
                                    }                    
                                    $custvaluesT =$custvaluesT.$comma2."(".$custvalues.",1)";
                                $comma2=",";//prirt 2 timetime
                                $custvalues="";                        
                            }
                        }   
                        
                    }//-------------------------------------------------------------        
                }        
            }     
        //--------------------------------------------------------------------
        $table2="wttorder";    
        $select2="OrderIdA,OrderDesc,CustCode, CustRIF, OrderDateDocu,OrderTotalSub,OrderTotal,OrderTotalTax,UserCode, OrderStatus,OrderSincStatus,OrderTSSIT,OrderTSSITas"; 
        $valores=$ocabvaluesT; 
        $r1=$ObjBdQ->Query_InsertMV($table2,$select2,$valores);//into bd
        
        //$new_pet_id =$ObjBdQ->mysql_insert_id($r1);
        
        //----------------------------------------------------------------------
        $table2="wttorderd";    
        $select2="OrderIdA, UserCode, CustCode, ItemCode,OrderItemDesc, OrderItemQuantity, OrderItemPrec1, OrderItemSub, OrderItemTotal, OrderItemTax,OrderItemSincStatus,OrderItemTSSIT,OrderItemTSSITas"; 
        $valores=$odetvaluesT; 
        $r2=$ObjBdQ->Query_InsertMV($table2,$select2,$valores);//into bd
        
        //----------------------------------------------------------------------
        $tabla2="wttorderd, wttorder ";
        $values2="wttorderd.OrderIdW= wttorder.OrderIdW ";
        $where2=" wttorder.OrderTSSITas='".$tsas."' AND wttorder.OrderTSSITas = wttorderd.OrderItemTSSITas AND wttorder.OrderIdA = wttorderd.OrderIdA AND wttorder.UserCode = wttorderd.UserCode AND 
                 wttorder.CustCode = wttorderd.CustCode AND wttorder.OrderTSSIT = wttorderd.OrderItemTSSIT ";
                
        $r2=$ObjBdQ->Query_Update($tabla2,$values2,$where2);
        
        //----------------------------------------------------------------------
                
        //echo "<hr>cliente:".$custvaluesT."<hr>";
        $table2="tmcustomernew";    
        $select2="CustCode, CustDesc, CustDirF, CustRIF, CustTele, CustEmail, CustRespons, CustZone, CustBalance, SellCode, custSIT, CustSincStatus"; 
        $valores=$custvaluesT; 
        $r2=$ObjBdQ->Query_InsertMV($table2,$select2,$valores);//into bd        
      
        
        
        //----------------------------------------------------------------------
        
        //echo " ocabvaluesT:".$ocabvaluesT."<br>";
        //echo " odetvaluesT:".$odetvaluesT."<br>";
        
        $tmitemsssuccess=1;
         $response["tmitemsssuccess"]=1;
        $response["success"] = 1;
        $response["message"] = "Insert dataorder";
        $response["tsissw"] = "".$tsas."1";
        
        //--------------------------------------------------------------------------            
    }else {    $tmitemsssuccess=0;    }
    }else {    $tmitemsssuccess=0;    }
 
 }
if ($tmitemsssuccess==0)      
    { 
        $response["tmitemsssuccess"]=0;
        $response["success"] = 0;
        $response["message"] = "No found item";
        $response["tsissw"] = $tsid."0";
        
      }
//ALWAYS PRINT JSON
echo json_encode($response);      
      
function tsfungetuser($tab){
        $tab="tabla=0";
		return $tab;
	}

?>
