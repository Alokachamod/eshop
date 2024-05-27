<?php

session_start();
require "connection.php";

$msgTxt = $_POST["t"];
$receiver = $_POST["r"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");


$sender;

if (isset($_SESSION["u"])) {

    $sender = $_SESSION["u"]["email"];
    
}elseif (isset($_SESSION["au"])) {
    
    $sender = $_SESSION["au"]["email"];
    
}

if (empty($reciever)) {

    Database::iud("INSERT INTO `chat` (`content`,`date_time`,`status`,`from`,`to`) VALUES ('".$msgTxt."','".$date."','0','".$sender."','".$receiver."')");
    echo("Success1");

} else {
    
    Database::iud("INSERT INTO `chat` (`content`,`date_time`,`status`,`from`,`to`) VALUES ('".$msgTxt."','".$date."','0','".$sender."','nothariqx@gmail.com')");
    echo("Success2");
    
}


?>