<?php

$server = "209.59.139.37" ;
$db = "equipop4_dashboard";
$user = "equipop4";
$password = "Proyectounid.2019"; 
$mysqli = new mysqli($server, $user, $password, $db);
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}






 ?>