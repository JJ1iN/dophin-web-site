<?php
	@session_start();
	header("Content-Type: text/html; charset=UTF-8");
	include ( './common.php' );

	$db_conn = mysql_conn();

	$post_idx = $_POST['idx'];
    $id = $_SESSION["id"];
    $content = $_POST['content'];
	$writer = $_SESSION["name"];

	date_default_timezone_set('Asia/Seoul');
	$currentTime = date('Y-m-d H:i:s');

    $query = "insert into comments (post_idx, content, id, writer, regdate) values('{$post_idx}', '{$content}', '{$id}', '{$writer}', '{$currentTime}')";
	$db_conn->query($query);

    echo "<script>location.href='index.php?page=view&idx={$post_idx}';</script>";
	$db_conn->close();
?>