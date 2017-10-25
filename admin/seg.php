<?php
//Reanudamos la sesion 
session_start(); 
//Validamos si existe realmente una sesion activa o no 
if($_SESSION['autentica'] != "SIP")
{ 
  //Si no hay sesion activa, lo direccionamos al index.php (inicio de sesion) 
  header("Location: login.html"); 
  exit();
  
} 
?>