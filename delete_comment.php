<?php
@session_start();
header("Content-Type: text/html; charset=UTF-8");
include ( './common.php' );

$db_conn = mysql_conn();

$comment_idx = $_POST['comment_idx'];
$post_idx = $_POST['post_idx'];

$query = "DELETE FROM comments WHERE idx = {$comment_idx}";
$db_conn->query($query);

echo "<script>location.href='index.php?page=view&idx={$post_idx}';</script>";
$db_conn->close();
?>