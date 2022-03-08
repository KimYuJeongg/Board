<?
include "common.php";
include "header.php";
$idx = $_GET['idx'];
if($idx == "") {
    alert("잘못된 접근입니다.");
    location("index.php");
    exit;
}
$boname = mysqli_query($conn, "SELECT boname FROM board WHERE idx=$idx");
$boname = mysqli_fetch_assoc($boname);
$boname = $boname['boname'];

$num = mysqli_query($conn, "SELECT idx FROM board WHERE boname='$bonae' AND idx>$idx;");
$num = mysqli_num_rows($num);
$page = ceil(($num + 1) / $postperpage);
?>

<style>
    header, footer {display: none;}
    #pwchkForm {
        transform: translate(-50%, -50%);
        width: calc(100% -30px);
        max-width: 400px;
    }
</style>
<div class="position-fixed bg-dark w-100 h-100 top-0"></div>
<form id="pwchkForm" action="pwchk_insert.php" method="post"
class="position-absolute bg-white py-3 px-2 rounded start-50 top-50">
    <input name="idx" value="<?=$idx;?>" type="hidden" />
    <label class="d-block mb-3">
        Password
        <input type="password" name="password" id="password" class="form-control" />
    </label>
    <div class="d-grid mt-4">
        <button type="button" id="pwchkSubmit" class="btn btn-primary d-block">
            Input
        </button>
    </div>
    <a href="list.php?boname=<?=$boname;?>">Return</a>
    <div class="text-end mt-3">
        <a href="list.php?boname=<?=$boname;?>&page=<?$page;?>" onclick="history.back();"><i class="far fa-arrow-alt-circle-left"></i></a>
    </div>
</form>

<script>
    $("#password").focus();
    $("#pwchkSubmit").click(function(){
        if($("#password").val().length == 0) {
            alert("비밀번호를 입력해주세요.");
            $("#password").focus();
        } else {
            $("#pwchkForm").submit();
        }
    });

    $("#password").keyup(function(e){
        if(e.keyCode == 13) {
            $("#pwchkSubmit").trigger("click");
        }
    });
</script>
<?
include "footer.php";
?>