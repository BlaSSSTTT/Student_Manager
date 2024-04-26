<?php
$arrGroup = [
    1 => "PZ-21",
    2 => "PZ-22",
    3 => "PZ-23",
    4 => "PZ-24",
    5 => "PZ-25"
];
$arrGender = [
    1 => "M",
    2 => "F"
];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdata";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection error");
}



//5 еміти і лісенери, чи для одного чи для всіх
//6 прив'язка за іменем