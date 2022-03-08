<?php
header("Content-type:text/html; charset=utf-8;");

$conn = mysqli_connect("localhost", "dbwjd201166", "dbwjd2636!");
mysqli_select_db($conn, "dbwjd201166");

mysqli_query($conn, "SET SESSION CHARACTER_SET_CONNECTION='utf8;");
mysqli_query($conn, "SET SESSION CHARACTER_SET_RESULTS='utf8;");
mysqli_query($conn, "SET SESSION CHARACTER_SET_CLIENT='utf8;");

session_start();

include "func.php";
include "config.php";

if( !isset( $_SESSION['userlv'] ) ){
    $_SESSION['userlv'] = 0;
} 

?>