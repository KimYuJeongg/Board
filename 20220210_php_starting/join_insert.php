<?
include "common.php";

$userid = $_POST['userid'];
$userpw = $_POST['userpw'];
$userpw = password_hash($userpw, PASSWORD_DEFAULT);
$username = $_POST['username'];
$usermail = $_POST['usermail'];
$joindate = date("Y-m-d");

mysqli_query($conn, "INSERT INTO member (userid, userpw, username, usermail, userlv, joindate, ban)
VALUES ('$userid', '$userpw', '$username', '$usermail', 1, '$joindate', 0);") or die(mysqli_error($conn));

alert("회원가입이 완료되었습니다.");
location("index.php");
?>