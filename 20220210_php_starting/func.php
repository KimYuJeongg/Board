<?

function alert($massage){
    echo "<script>alert('$massage');</script>";
}

function location($dest) {
    echo "<script>location.href='$dest';</script>";
}

function back() {
    echo "<script>history.back();</script>";
}

?>