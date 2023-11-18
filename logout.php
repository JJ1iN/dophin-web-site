<<<<<<< HEAD
<?
    @session_start();
    unset($_SESSION["id"]);
    session_destroy();

    echo "<script>location.href='index.php'</script>";
=======
<?
    @session_start();
    unset($_SESSION["id"]);
    session_destroy();

    echo "<script>location.href='index.php'</script>";
>>>>>>> efc8c5c905e257cb8ac9b7a436e9896f5bf85393
?>