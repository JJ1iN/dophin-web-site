<?php
	header("Content-Type: text/html; charset=UTF-8;");

	$tb_name = "insecure_board";
	$upload_path = "upload";

	function mysql_conn() {
		$host = "localhost";
		$id = "jin";
		$pw = "0110";
		$db = "pentest";
	
		$db_conn = new mysqli($host, $id, $pw, $db);

		return $db_conn;
	}

?>