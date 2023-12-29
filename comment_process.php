<?php
	@session_start();
	header("Content-Type: text/html; charset=UTF-8");
	include ('./common.php');

	$db_conn = mysql_conn();

	$post_idx = $_POST['idx'];
    $id = $_SESSION["id"];
    $content = $_POST['content'];
	$writer = $_SESSION["name"];

	date_default_timezone_set('Asia/Seoul');
	$currentTime = date('Y-m-d H:i:s');

	if(empty($id)) { // No login
		echo "<script>alert('Login First.');location.href='index.php?page=login';</script>";
		exit;
	}
	if(empty($content)) { // No comment
		echo "<script>alert('Please input your comments.'); history.back();</script>";
		exit;
	}
	
    // $query = "insert into comments (post_idx, content, id, writer, regdate) values('{$post_idx}', '{$content}', '{$id}', '{$writer}', '{$currentTime}')";
	// $db_conn->query($query);

	# Prepared Statement
	$stmt = $db_conn->prepare("INSERT INTO comments (post_idx, content, id, writer, regdate) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("issss", $post_idx, $content, $id, $writer, $currentTime);
	$stmt->execute();

    echo "<script>location.href='index.php?page=view&idx={$post_idx}';</script>";
	$db_conn->close();
?>