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
        $ccabvalues="";
        $ccabvaluesT="";
        $comma="";
        $comma2="";
      
        $cdetdvalues="";
        $cdetdvaluesT="";
        
        $cdetpvalues="";
        $cdetpvaluesT="";
    
        $ocabi= 0;
        foreach ($obj as $indice => $valor) {
            //echo "indice:".$indice."<hr>";
            foreach ($valor as $indice2 => $valor2) {
                //echo "indice2:".$indice2."<hr>";
                foreach ($valor2 as $indice3 => $valor3) {
                    //echo "indice3:".$indice3."<hr>";
                    //--------------------------------------------------------------
                    $comma2="";
                    if ($indice3=="ccab") {
                        foreach ($valor3 as $indice4 => $valor4) {
                            //echo "indice4:".$indice4."<hr>";
                            $comma="";
                            foreach ($valor4 as $indice5 => $valor5) {
                                //echo "indice5:".$indice5." aca valor5:".$valor5."<hr>";
                                $ccabvalues =$ccabvalues.$comma."'".$valor5."'";
                               $comma=",";//prirt 2 timetime
                                }                    
                            $ccabvaluesT =$ccabvaluesT.$comma2."(".$ccabvalues.",1,'".$tsid."','".$tsas."')";
                            //array_push($ocab["ocab"], $tsline);
                            $comma2=",";//prirt 2 timetime
                            $ccabvalues="";                        
                        }
                    } 
                    else if ($indice3=="cdetd") {
                        foreach ($valor3 as $indice4 => $valor4) {
                            //echo "indice odet 4:".$indice4."<hr>";
                            $comma="";
                                foreach ($valor4 as $indice5 => $valor5) {
                                    //echo "indice odet 5:".$indice5." aca odet valor5:".$valor5."<hr>";
                                    $cdetdvalues =$cdetdvalues.$comma."'".$valor5."'";
                                    $comma=",";//prirt 2 timetime
                                    }                    
                                    $cdetdvaluesT =$cdetdvaluesT.$comma2."(".$cdetdvalues.",1,'".$tsid."','".$tsas."')";
                                $comma2=",";//prirt 2 timetime
                                $cdetdvalues="";                        
                            }
                        }   
                    else if ($indice3=="cdetp") {
                        foreach ($valor3 as $indice4 => $valor4) {
                            //echo "indice odet 4:".$indice4."<hr>";
                            $comma="";
                                foreach ($valor4 as $indice5 => $valor5) {
                                    //echo "indice odet 5:".$indice5." aca odet valor5:".$valor5."<hr>";
                                    $cdetpvalues =$cdetpvalues.$comma."'".$valor5."'";
                                    $comma=",";//prirt 2 timetime
                                    }                    
                                    $cdetpvaluesT =$cdetpvaluesT.$comma2."(".$cdetpvalues.",1,'".$tsid."',1,'".$tsas."')";
                                $comma2=",";//prirt 2 timetime
                                $cdetpvalues="";                        
                            }
                        }   
                        
                    }//-------------------------------------------------------------        
                }        
            }     
        //--------------------------------------------------------------------
        $table2="ttcollection";    
        $select2="CollectionIdA, UserCode, CustCode, CollectionDate, CollectionTotalDoc, CollectionTotalPayment, CollectionStatus, CollectionNote, TSSincStatus, tssit, TSSITas "; 
        $valores=$ccabvaluesT; 
//        echo $ccabvaluesT;
        $r1=$ObjBdQ->Query_InsertMV($table2,$select2,$valores);//into bd
        
//----------------------------------------------------------------------
        $table2="ttcollectiondoc";    
        $select2="CollectionIdA, UserCode, CustCode, DocNumber, DocControl, DocType, DocOrig, DocOrigNumber, DocAmount, "
                ."DocDiscount, DocRetention, DocAmountTotal, DocStatus, DocNote, TSSincStatus, tssit, TSSITas"; 
        $valores=$cdetdvaluesT; 
//        echo $cdetdvaluesT;
        $r1=$ObjBdQ->Query_InsertMV($table2,$select2,$valores);//into bd
//----------------------------------------------------------------------
        $table2="ttcollectionpayment";    
        $select2="CollectionIdA, UserCode, CustCode, BankCode, TypeTransCode, TransNumber, TransDate,"
                . " TransAmount, TransNote, TransStatus, tssit, TSSincStatus, TSSITas"; 
        $valores=$cdetpvaluesT; 
        $r2=$ObjBdQ->Query_InsertMV($table2,$select2,$valores);//into bd        
        
//----------------------------------------------------------------------

$tabla2="TTCollectionDoc, TTCollection ";
$values2="TTCollectionDoc.CollectionIdW= TTCollection.CollectionIdW ";
$where2=" TTCollection.TSSITas='".$tsas."' AND TTCollection.TSSITas = TTCollectionDoc.TSSITas AND
		  TTCollection.CollectionIdA = TTCollectionDoc.CollectionIdA AND TTCollection.UserCode = TTCollectionDoc.UserCode AND 
		  TTCollection.CustCode = TTCollectionDoc.CustCode AND TTCollection.tssit = TTCollectionDoc.tssit ";
$r2=$ObjBdQ->Query_Update($tabla2,$values2,$where2);

//----------------------------------------------------------------------
$tabla2="ttcollectionpayment, TTCollection ";
$values2="ttcollectionpayment.CollectionIdW= TTCollection.CollectionIdW ";
$where2=" TTCollection.TSSITas='".$tsas."' AND TTCollection.TSSITas = ttcollectionpayment.TSSITas AND
		  TTCollection.CollectionIdA = ttcollectionpayment.CollectionIdA AND TTCollection.UserCode = ttcollectionpayment.UserCode AND 
		  TTCollection.CustCode = ttcollectionpayment.CustCode AND TTCollection.tssit = ttcollectionpayment.tssit ";
$r2=$ObjBdQ->Query_Update($tabla2,$values2,$where2);

//----------------------------------------------------------------------
        
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
