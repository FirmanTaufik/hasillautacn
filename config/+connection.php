<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  
$host ="localhost";
$user = "maus6546_roothasillautacn";
$pass = "qRJ#p8!q{tkP";
$database ="maus6546_hasillautacn"; 

$conn = mysqli_connect($host, $user, $pass, $database);

if(!$conn) {
    echo "tidak connect";
}

?>