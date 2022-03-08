<?
include "common.php";

$idx = $_POST['idx'];
$password = $_POST['password'];

$data = mysqli_query($conn, "SELECT password FROM board WHERE idx=$idx;");
$data = mysqli_fetch_assoc($data);
$data = $data['password'];

if(password_verify($password, $data)) {
    echo "<form id='pwchkForm' action='view.php?idx=$idx' method='post'>";
    echo "<input type='hidden' name='success' value='checked' />";
    echo "</form>";
    echo "<script>document.getElementById('pwchkForm').submit();</script>";
} else {
    alert("비밀번호가 일치하지 않습니다.");
    location("pwchk.php?idx=$idx");
    exit;
}
?>