<?
include "common.php";

// 1. login.php에서 보내온 두가지 데이터($userid,$userpw)를 받기
// 2. 유효성 검사
// 3. db에서 userid가 입력한 $userid와 일치하는 데이터가 있는가?
    // 3.1 일치하는 데이터가 있다면
        // 그런 아이디를 가진 사람이 있다
        // userid가 $userid인 계정의 암호화된 비밀번호와
        // 지금입력한 $userpw가 서로 일치하는 데이터인지 확인.
            // 일치하면?
                // "로그인에 성공하였습니다."표시,
                // 이 계정의 userlv을 알아내서 userlv세션을 수정.
                // index.php로 되돌려보내기
            // 일치하지 않으면?
                // "아이디와 비밀번호를 확인해주세요"표시, login.php되돌려보내기
    // 3.2 일치하는 데이터가 없다면
        // 그런 아이디를 가진 사람이 없다
        // "아이디와 비밀번호를 확인해주세요"표시, login.php되돌려보내기
 
$userid = $_POST['userid'];
$userpw = $_POST['userpw'];
if(strlen($userid) * strlen($userpw) == 0){
    alert("잘못된 접근입니다.");
    location("index.php");
    exit;
}

$data = mysqli_query($conn, "SELECT userid,userpw,username,userlv FROM member WHERE userid='$userid';"); 
$len = mysqli_num_rows($data); 
if($len == 0){
    alert("아이디와 비밀번호를 확인해주세요");
    location("login.php");
}else{
    $row = mysqli_fetch_assoc($data);
    if( password_verify($userpw, $row['userpw']) ){
        alert("로그인에 성공하였습니다.");
        $_SESSION['userlv'] = $row['userlv'];
        $_SESSION['userid'] = $userid;
        $_SESSION['username'] = $row['username'];
        location("index.php");
    }else{
        alert("아이디와 비밀번호를 확인해주세요");
        location("login.php");
    }
}


?>