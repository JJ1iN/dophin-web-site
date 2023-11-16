<?
    @session_start();
    unset($_SESSION["id"]);
    session_destroy();

    echo "<script>location.href='index.php'</script>";
?>