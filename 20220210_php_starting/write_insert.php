<?
include "common.php";

$boname = $_POST['boname'];
$title = $_POST['title'];
$title = addslashes($title);
$title = strip_tags($title);
$writer = $_POST['writer'];
$writer = addslashes($writer);
$writer = strip_tags($writer);
$password = $_POST['password'];

if($writer == "") {
    $writer = $_SESSION['userid'];
}

if($password != "") {
    $password = password_hash($password, PASSWORD_DEFAULT);
}
$sec = $_POST['sec'];
if($sec == "on") {
    $sec = 1;
} else {
    $sec = 0;
}

$fix = $_POST['fix'];
if($fix == "on") {
    $fix = 1;
} else {
    $fix = 0;
}

$cont = $_POST['cont'];
$cont = addslashes($cont);
$date = date("Y-m-d");

$attach_size = $_FILES['attach']['size'];
$attach_name = $_FILES['attach']['name'];
$attach_tmp = $_FILES['attach']['tmp_name'];

if($attach_name != "") {
    if($attach_size > 5242880) {
        alert("5MB 이하의 파일만 업로드할 수 있습니다.");
        back();
        exit; 
    }
    
    $allow = ["jpg", "jpeg", "png", "gif", "bmp", "pdf", "hwp", "doc", "xls", "xlsx", "mp3", "mp4"];
    $ext = explode(".", $attach_name);
    $ext = end($ext);
    $ext = strtolower($ext);
    if( !in_array($ext, $allow) ) {
        alert("업로드할 수 없는 확장자입니다.");
        back();
        exit;
    }

    $nansu = time().rand(1000, 9999);
    mkdir("upload/".$nansu);
    move_uploaded_file($attach_tmp, "upload/".$nansu."/".$attach_name);
    $attach = "upload/".$nansu."/".$attach_name;
} else {
    $attach = "";
}

$parent = null;
$count = 0;

mysqli_query($conn, "INSERT INTO board 
(title, cont, date, writer, password, sec, fix, attach, parent, count, boname) VALUE 
('$title', '$cont', '$date', '$writer', '$password', $sec, $fix, '$attach', null, $count, '$boname')") or die(mysqli_error($conn));

alert("게시물이 등록되었습니다.");

location("list.php?boname=$boname");

?>