<?
include "common.php";
include "header.php";

$idx = $_GET['idx'];
if( $idx == "" ){
    alert("해당 게시물이 존재하지 않습니다.");
    location("index.php");
    exit;
}else{
    $row = mysqli_query($conn, "SELECT * FROM board WHERE idx=$idx;");
    $len = mysqli_num_rows($row);
    if($len == 0){
        alert("해당 게시물이 존재하지 않습니다.");
        location("index.php");
        exit;
    }
}
$row = mysqli_fetch_assoc($row);
$boname = $row['boname'];
$boinfo = mysqli_query($conn, "SELECT * FROM boinfo WHERE boname='$boname';");
$boinfo = mysqli_fetch_assoc($boinfo);

$num = mysqli_query($conn, "SELECT idx FROM board WHERE boname='$bonaem' AND idx>$idx;");
$num = mysqli_num_rows($num);
$page = ceil(($num + 1) / $postperpage);

if( $_SESSION['userlv'] < $boinfo['view'] ){
    alert("해당 게시물을 볼 수 있는 권한이 없습니다.");
    location("list.php?boname=$boname&page$page");
    exit;
}

// 비밀글인 경우
    // 열람자가 관리자가 아닌 경우
        // 회원비밀글인 경우
            // 현재열람자의 아이디와 글에 저장된 글쓴이의 아이디가 상이한 경우
                // 경고창 : 글을볼수있는 권한이 없습니다.
                // 리스트로 되돌려보내기
        // 아닌경우(비회원비밀글인 경우)
            // $_POST['success'] 가 "checked"가 아닌가?
                // 그렇다면(비번 체크를 한적이 없었다)
                    // pwchk.php?idx=31 로 보내버리기. 
                    // 프로그램 종료.
if( $row['sec'] == 1 ){
    if( $_SESSION['userlv'] < 9 ){
        if( $row['password'] == "" ){
            if( $_SESSION['userid'] != $row['writer'] ){
                alert("해당 게시물을 볼 수 있는 권한이 없습니다.");
                location("list.php?boname=$boname");
                exit;
            }
        }else{
            if( $_POST['success'] != "checked" ){
                location("pwchk.php?idx=$idx");
                exit;
            }
        }
    }
}
if(!isset($_SESSION[$boname.$idx])) {
    mysqli_query($conn, "UPDATE board SET count=count + 1 WHERE idx=$idx;");
    $_SESSION[$boname.$idx] = false;
}

?>

<div class="container">
    <ul class="list-group">
        <li class="list-group-item active">
            <h5 class="mb-0"><?=$row['idx'].". ".$row['title'];?></h5>
        </li>
        <li class="list-group-item overflow-auto">
            <div class="float-start">
                <i class="fas fa-user text-secondary"></i> <?=$row['writer'];?>
            </div>
            <div class="float-end">
                <i class="fas fa-calendar text-secondary"></i> <?=$row['writer'];?>
                <i class="fas fa-eye ms-3 text-secondary"></i> <?=$row['count'];?>
            </div>
        </li>
        <li class="list-group-item py-4">
            <?
            $cont = $row['cont'];
            $cont = nl2br($cont);

            if($row['attach'] != "") {
                $ext = explode(".", $row['attach']);
                $ext = end($ext);
                $ext = strtolower($ext);
                if($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext =="gif") {
                    echo "<img src='{$row['attach']}' alt='{$row['title']}'  class='d-block p-2 mb-4 img-fluid'/>";
                }
            }
            echo $cont;
            ?>
        </li>
        <?
        if($row['attach'] != "") {
            $file = $row['attach'];
            $file = explode("/", $file);
            $file = end($file);
            echo "<li class='list-group-item'>"; 
                echo "<i class='fas fa-paperclip text-secondary'></i>";
                echo "<a href='{$row['attach']}' download class='ms-2'>$file</a>";
            echo "</li>";
        }
        ?>
        <li class="list-group-item">
            <div class="row">
                <?
                $prev = mysqli_query($conn, "SELECT idx, title FROM board WHERE boname='$boname' AND idx<$idx ORDER BY idx DESC LIMIT 0, 1;");
                $prevlen = mysqli_num_rows($prev);
                if($prevlen == 0) {
                    echo "<a class='col-sm d-block border-end text-dark text-decoration-none'>PREVIOUS<br />이전글이 존재하지 않습니다.</a>";
                } else {
                    $prev = mysqli_fetch_assoc($prev);
                    echo "<a class='col-sm d-block border-end text-dark text-decoration-none' href='view.php?idx={$prev['idx']}'>PREVIOUS  &nbsp;{$prev['title']}<br /></a>";
                }
                $next = mysqli_query($conn, "SELECT idx, title FROM board WHERE boname='$boname' AND idx>$idx ORDER BY idx ASC LIMIT 0, 1;");
                $nextlen = mysqli_num_rows($next);
                if($nextlen == 0) {
                    echo "<a class='col-sm d-block text-dark text-end text-decoration-none'>NEXT<br />다음글이 존재하지 않습니다.</a>";
                } else {
                    $next = mysqli_fetch_assoc($next);
                    echo "<a class='col-sm d-block text-dark text-end text-decoration-none' href='view.php?idx={$next['idx']}'>{$next['title']}&nbsp; NEXT<br /></a>";
                }
                ?>
            </div>
        </li>
    </ul>
    <div class="text-end mt-4">
    <?
    if($_SESSION['userlv'] >= 9 || $_SESSION['userid'] == $row['writer'] || $row['password'] != "") {
        echo "<a href='delete.php?idx=$idx' class='btn btn-danger'>Delete</a>";
        echo "<a href='modify.php?idx=$idx' class='btn ms-2 btn-success'>Modify</a>";
    }
    ?>
        <a href="list.php?boname=<?=$boname;?>&page=<?=$page;?>" class="btn ms-4 btn-primary">List</a>
    </div>
</div>

<?
include "footer.php";
?>