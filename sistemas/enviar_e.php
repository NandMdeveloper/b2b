<?php
$con = mysql_connect('localhost', 'root', 'localhost');
mysql_select_db('b2bfc', $con);
mysql_set_charset('utf8');

$sq="SELECT * FROM correos WHERE sinc='0'";
$rst= @mysql_query($sq);
while ($row = mysql_fetch_array($rst)){
  $headers = "From: ".$row["de"]."\r\n"; //Quien envia?
  $headers .= "X-Mailer: PHP5\n";
  $headers .= 'MIME-Version: 1.0' . "\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
  if(mail($row["para"],$row["asunto"],$row["mensaje"],$headers)){
    @mysql_query("UPDATE correos SET sinc='1' WHERE id=".$row['id']);
  }else{
    echo 'Ocurrio un error';
  }
}

?>