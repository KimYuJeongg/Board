<?
include "common.php";
include "header.php";
?>

<div class="container">
    <h2>Create Account</h2>
    <form id="joinForm" action="join_insert.php" method="post">
        <label class="d-block mb-3">
            Account Id <small id="useridInfo"></small>
            <input type="text" id="userid" class="form-control" name="userid" />
        </label>
        <label class="d-block mb-3">
            Account Password
            <input type="password" id="userpw" class="form-control" name="userpw" />
        </label>
        <label class="d-block mb-3">
            Password Check <small id="userpwInfo"></small>
            <input type="password" id="userpwchk" class="form-control" disabled />
        </label>
        <label class="d-block mb-3">
            User Name
            <input type="text" id="username" class="form-control" name="username" />
        </label>
        <label class="d-block mb-3">
            e-Mail
            <input type="text" id="usermail" class="form-control" name="usermail" />
        </label>
        <div class="text-center mt-3">
            <button type="button" class="btn btn-secondary">
                Reset
            </button>
            <button type="button" id="joinSubmit" class="btn btn-primary">
                Create account
            </button>
    </form> 
</div>

<script>
    var idchk = false;
    var pwchk = false;
    $("#userid").keyup(function(){
        var text = $(this).val();
        var len = text.length;
        if(len < 5) {
            $("#useridInfo").removeClass().addClass("text-danger").text("아이디는 5글자 이상으로 입력해주세요.");
        } else {
            $.ajax({
                url: "idchk.php", 
                data: {userid:text},
                type: "get",
                success: function(data) {
                    if(data == 1) {
                        $("#useridInfo").removeClass().addClass("text-success").text("중복안됨");
                        idchk = true;
                    } else {
                        $("#useridInfo").removeClass().addClass("text-danger").text("중복됨");
                        idchk = false;
                    }
                } 
            });
        }
    });

    $("#userpw").keyup(function(){
        var len = $(this).val().length;
        if(len == 0) {
            $("#userpwchk").attr("disabled", "disabled");
        } else {
            $("#userpwchk").removeAttr("disabled");
        }
    });

    $("#userpwchk").keyup(function(){
        var userpw = $("#userpw").val();
        var userpwchk = $(this).val();
        if(userpw == userpwchk && userpw != "") {
            $("#userpwInfo").removeClass().addClass("text-success").text("비밀번호가 일치합니다.");
            pwchk = true;
        } else {
            $("#userpwInfo").removeClass().addClass("text-danger").text("비밀번호가 일치하지 않습니다.");
            pwchk = false;
        }

    })

    $("#joinSubmit").click(function(){
        if(!idchk) {
            alert("아이디를 확인해주세요.");
            $("#userid").focus();
        } else if(!pwchk) {
            alert("비밀번호를 확인해주세요.");
            $("#userpw").focus();
        } else if($("#username").val().length == 0) {
            alert("성명을 입력해주세요.");
            $("#username").focus();
        } else {
            $("#joinForm").submit();
        }
    }); 
</script>
<?
include "footer.php";
?>