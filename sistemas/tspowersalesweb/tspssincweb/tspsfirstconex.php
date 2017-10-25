<?php 

if (isset($_REQUEST['tspar'])) $TSPar = $_REQUEST['tspar']; 
else $TSPar=10;

if ($TSPar==10101010){//REQUESTING DATA
    $response["sconex"]="Hello :)";
    $response["conexsuccess"] = 1;
    $response["message"] = "found";
}else{
    $response["sconex"]="";
    $response["conexsuccess"] = 0;
    $response["message"] = "No found";
}

//ALWAYS PRINT JSON
echo json_encode($response);      
      
?>
