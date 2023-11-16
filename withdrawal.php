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
?>