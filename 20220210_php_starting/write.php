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
        if($boinfo['publish'] > $_SESSION['userlv']){
            alert("글을 작성할 권한이 없습니다.");
            location("index.php");
            exit;
        }
    }
}

?>
 
<div class="container">
    <h2>Write post</h2>
    <form id="writeForm" action="write_insert.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="boname" id="boname" value="<?=$boname;?>" />
        <label class="d-block my-3">
            Title
            <input type="text" name="title" id="title" class="form-control" />
        </label>
        <?
        if($_SESSION['userlv'] <= 0){
        ?>
        <label class="d-block my-3">
            Writer
            <input type="text" name="writer" id="writer" class="form-control" />
        </label>
        <label class="d-block my-3">
            Password
            <input type="password" name="password" id="password" class="form-control" />
        </label>
        <?
        }
        ?>
        
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="sec" name="sec" />
            <label class="form-check-label" for="sec">Secret post</label>
        </div>
        
        <?
        if($_SESSION['userlv'] >= 9){
        ?>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="fix" name="fix" />
            <label class="form-check-label" for="fix">Top fixed post</label>
        </div>
        <?
        }
        ?>
        
        <label class="d-block my-3">
            Contents
            <textarea class="form-control" name="cont" id="cont" style="min-height: 200px;"></textarea>
        </label>
        
        <label class="d-block my-3">
            <input type="file" name="attach" class="form-control" />
        </label>
        
        <div class="text-center py-4">
            <a class="btn btn-secondary" href="list.php?boname=<?=$boname;?>">List</a>
            <button class="btn btn-primary" type="button" id="writeSubmit">Write</button>
        </div>
    </form>
    <script>
        $("#writeSubmit").click(function(){
            if(<?=$_SESSION['userlv'];?> > 0){
                var boname = $("#boname").val().length;
                var title = $("#title").val().length;
                var cont = $("#cont").val().length;
                if(boname*title*cont == 0){
                    alert("제목과 내용은 필수 입력요소 입니다.");
                }else{
                    $("#writeForm").submit();
                }
            }else{
                var boname = $("#boname").val().length;
                var title = $("#title").val().length;
                var cont = $("#cont").val().length;
                var writer = $("#writer").val().length;
                var password = $("#password").val().length;
                if(boname*title*cont*writer*password == 0){
                    alert("제목과 내용, 글쓴이, 비밀번호는 필수 입력요소 입니다.");
                }else{
                    $("#writeForm").submit();
                }
            }
        });
        
    </script>
</div>
 
<?
include "footer.php";
?>