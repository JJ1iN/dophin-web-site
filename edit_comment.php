<?php
@session_start();
header("Content-Type: text/html; charset=UTF-8");
include ('./common.php');

$db_conn = mysql_conn();

$comment_idx = $_POST['comment_idx'];
$post_idx = $_POST['post_idx'];
$new_content = $_POST['new_content'];

date_default_timezone_set('Asia/Seoul');
$currentTime = date('Y-m-d H:i:s');

$query = "UPDATE comments SET content = '{$new_content}', regdate = '{$currentTime}' WHERE idx = {$comment_idx}";
$db_conn->query($query);

echo "<script>location.href='index.php?page=view&idx={$post_idx}';</script>";
$db_conn->close();
?>