<?
include "common.php";
include "header.php";

$boname = $_GET['boname'];
if($boname == ""){
    alert("존재하지 않는 게시판입니다.");
    location("index.php");
    exit;
}else{
    $data = mysqli_query($conn, "SELECT * FROM boinfo WHERE boname='$boname';");
    $len = mysqli_num_rows($data);
    if($len == 0){
        alert("존재하지 않는 게시판입니다.");
        location("index.php");
        exit; 
    }else{
        $boinfo = mysqli_fetch_assoc($data);
        if($boinfo['list'] > $_SESSION['userlv']){
            alert("리스트를 열람 권한이 없습니다.");
            location("index.php");
            exit; 
        }
    }
}

$page = $_GET['page'];
if($page == ""){
    $page = 1;
}
$totalpost = mysqli_query($conn, "SELECT idx FROM board;");
$totalpost = mysqli_num_rows($totalpost);
$totalpage = ceil($totalpost / $postperpage);
$startpost = ($page - 1) * $postperpage;
$totalblock = ceil($totalpage / $pageperblock);
$block = ceil($page/$pageperblock);
$startpage = ($block - 1) * $pageperblock + 1;
//0.한페이지당 게시물수 정하기
//0.한 블록당 페이지수 정하기
//1.전체게시물수
//2.전체 페이지수 = 올림ceil(전체게시물수 / 한페이지당 게시물수)
//3.현재 페이지 번호
//4.현재 페이지에서 첫번째 게시물 번째수
            // = (페이지번호-1) * 한페이지당 보여줄 게시물수
//SELECT * FROM board ORDER BY idx DESC
            // LIMIT 현재 페이지에서 첫번째 게시물 번째수, 한페이지당 게시물수
//5.전체 블록수 = 올림(전체페이지수/한블록당페이지수)
//6.현재 속한 블록번호 = 올림(페이지번호/ 한블록 당 페이지수)
//7.현재속한블록의 첫번째 페이지번째수
    // = (블록번호-1)*한블록당 페이지수 + 1
?>

<div class="container">
    <h3>Board list</h3>
    
    <div class="row">
        <div class="col-6">
            <?

            echo "<small>Total <b>$totalpost</b> posts | <b>$page</b>/$totalpage page</small>";
            ?>
        </div>
        <div class="col-6">
            <!-- 검색창 들어갈 곳 -->
        </div>
    </div>
    
    <ul class="list-group board-list">
        <li class="list-group-item active">
            <div class="board-no">No</div>
            <div class="board-title">Title</div>
            <div class="board-writer">Writer</div>
            <div class="board-date">Date</div>
            <div class="board-count">Views</div>
        </li>
        <?

        $fixdata = mysqli_query($conn, "SELECT * FROM board WHERE boname='$boname' AND fix=1 ORDER BY idx DESC LIMIT 5;");
        $fixnum = mysqli_num_rows($fixdata);
        if( $fixnum != 0) {
            while($fixrow = mysqli_fetch_assoc($fixdata)) {
                if($fixrow['attach'] == "") {
                    $clip = "";
                } else {
                    $clip = "<i class='fas fa-paperclip text-secondary ms-2'></i>";
                }
                if($fixrow['sec'] == 0) {
                    $lock = "";
                } else {
                    $lock = "<i class='fas fa-lock text-secondary me-2'></i>";
                }
                echo "<li class='list-group-item'>";
                    echo "<a href='view.php?idx={$fixrow['idx']}' class='text-dark'>";
                        echo "<div class='board-no'><i class='fas fa-thumbtack text-secondary'></i></div>";
                        echo "<div class='board-title'>$lock{$fixrow['title']}$clip</div>";
                        echo "<div class='board-writer'>{$fixrow['writer']}</div>";
                        echo "<div class='board-date'>{$fixrow['date']}</div>";
                        echo "<div class='board-count'>{$fixrow['count']}</div>";
                    echo "</a>";
                echo "</li>";
            }
            echo "<li id='fixLine' class='bg-secondary'></li>";
        }   
        $data = mysqli_query($conn, "SELECT * FROM board WHERE boname ='$boname' ORDER BY idx DESC LIMIT $startpost, $postperpage;");
        while($row = mysqli_fetch_assoc($data)){
            echo "<li class='list-group-item'>";
                echo "<a class='text-dark'href='view.php?idx={$row['idx']}' title='{$row['title']}'>";
                    echo "<div class='board-no'>{$row['idx']}</div>";
                    if($row['attach'] == "") {
                        $clip = "";
                    } else {
                        $clip = "<i class='fas fa-paperclip text-secondary ms-2'></i>";
                    }
                    if($row['sec'] == 0) {
                        $lock = "";
                    } else {
                        $lock = "<i class='fas fa-lock text-secondary me-1'></i>";
                    }
                    echo "<div class='board-title'>$lock&nbsp;{$row['title']}$clip</div>";
                    echo "<div class='board-writer'>{$row['writer']}</div>";
                    echo "<div class='board-date'>{$row['date']}</div>";
                    echo "<div class='board-count'>{$row['count']}</div>";
                echo "</a>";
            echo "</li>";
        }
        ?>
    </ul>
    
    <div class="text-center my-4">
        <ul class="pagination justify-content-center">
        <?
        if($block > 1){
            $prevpage = $startpage - 1;
            echo "<li class='page-item'>";
            echo "<a class='page-link' href='list.php?boname=$boname&page=1'><i class='fas fa-angle-left'></i></a>";
            echo "</li>";
            echo "<li class='page-item'>";
            echo "<a class='page-link' href='list.php?boname=$boname&page=$prevpage'><i class='fas fa-angle-double-left'></i></a>";
            echo "</li>";
        }  
            
        for($i=0; $i<$pageperblock; $i++){
            $pageno = $startpage + $i;
            if($pageno <= $totalpage){
                if($pageno == $page){
                    echo "<li class='page-item active'>";
                    echo "<a class='page-link'>$pageno</a>";
                    echo "</li>";
                }else{
                    echo "<li class='page-item'>";
                    echo "<a class='page-link' href='list.php?boname=$boname&page=$pageno'>$pageno</a>";
                    echo "</li>";
                }
            }
        }
        
        if($block < $totalblock){
            $nextpage = $startpage + 5;
            echo "<li class='page-item'>";
            echo "<a class='page-link' href='list.php?boname=$boname&page=$nextpage'><i class='fas fa-angle-right'></i></a>";
            echo "</li>";
            echo "<li class='page-item'>";
            echo "<a class='page-link' href='list.php?boname=$boname&page=$totalpage'><i class='fas fa-angle-double-right'></i></a>";
            echo "</li>";
        }
        ?>
        </ul>
    </div>

    <?
    if($_SESSION['userlv'] >= $boinfo['publish']) {
        echo "<div class='text-end'>";
        echo "<a class='btn btn-primary' href='write.php?boname=$boname'>Write</a>";
        echo "</div>";
    }
    ?>
</div>

<?
include "footer.php";
?> 