<?
include "common.php";
include "header.php";
?>

<style>
    header, footer {display: none;}
    #loginForm {
        transform: translate(-50%, -50%);
        width: calc(100% -30px);
        max-width: 400px;
    }
</style>
<div class="position-fixed bg-dark w-100 h-100 top-0"></div>
<form id="loginForm" action="login_insert.php" method="post"
class="position-absolute bg-white py-3 px-2 rounded start-50 top-50">
    <h2>User Account Sign in</h2>
    <label class="d-block mb-3">
        User Account ID
        <input type="text" name="userid" id="userid" class="form-control" />
    </label>
    <label class="d-block mb-3">
        Account Password
        <input type="password" name="userpw" id="userpw" class="form-control" />
    </label>
    <div class="d-grid mt-4">
        <button type="button" id="loginSubmit" class="btn btn-primary d-block">
            Sign in
        </button>
    </div>
    <a href="join.php" class="d-block">Create Account</a>
    <a href="findpw.php" class="d-block">Forgot your password?</a>
    <div class="text-end mt-3">
        <a href="#" onclick="history.back();"><i class="far fa-arrow-alt-circle-left"></i></a>
    </div>
</form>

<script>
    $("#loginSubmit").click(function(){
        if($("#userid").val().length == 0) {
            alert("아이디를 입력해주세요."); 
            $("#userid").focus();
        } else if($("#userpw").val().length == 0) {
            alert("비밀번호를 입력해주세요.");
            $("#userpw").focus();
        } else {
            $("#loginForm").submit();
        }
    });

    $("#userpw").keyup(function(e){
        if(e.keyCode == 13) {
            $("#loginSubmit").trigger("click");
        }
    });
</script>
<?
include "footer.php";
?>