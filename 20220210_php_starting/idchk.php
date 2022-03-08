<?
include "common.php";

$userid = $_GET['userid'];
$data = mysqli_query($conn, "SELECT idx FROM member WHERE userid='$userid';");
$len = mysqli_num_rows($data);

if($len == 0) {
    echo 1;
} else {
    echo 0;
}
?>