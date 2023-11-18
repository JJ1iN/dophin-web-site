<<<<<<< HEAD
<?
    @session_start();
    include_once("./common.php");

    unset($_SESSION["id"]);
    session_destroy();
    
    $db_conn = mysql_conn();
    $id = $_GET["id"];

    $query = "delete from members where id='{$id}'";
	$result = $db_conn->query($query);

    echo "<script>location.href='index.php'</script>";
=======
<?
    @session_start();
    include_once("./common.php");

    unset($_SESSION["id"]);
    session_destroy();
    
    $db_conn = mysql_conn();
    $id = $_GET["id"];

    $query = "delete from members where id='{$id}'";
	$result = $db_conn->query($query);

    echo "<script>location.href='index.php'</script>";
>>>>>>> efc8c5c905e257cb8ac9b7a436e9896f5bf85393
?>