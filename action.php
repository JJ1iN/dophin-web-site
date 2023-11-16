<?
	@session_start();
	header("Content-Type: text/html; charset=UTF-8");
	include ( './common.php' );

	$mode = $_REQUEST["mode"];
	$db_conn = mysql_conn();
	
	if($mode == "write") {
		$title = $_POST["title"];
		$id = $_SESSION["id"];
		$writer = $_SESSION["name"];
		$password = $_POST["password"];
		$content = $_POST["content"];
		$secret = $_POST["secret"];
		$uploadFile = "";

		if(empty($title) || empty($password) || empty($content)) {
			echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
			exit();
		}

		if(!empty($_FILES["userfile"]["name"])) {
			$uploadFile = $_FILES["userfile"]["name"];
			$uploadPath = "{$upload_path}/{$uploadFile}";
			
			if(!(@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadPath))) {
				echo("<script>alert('파일 업로드를 실패 하셨습니다.');history.back(-1);</script>");
				exit;
			}
		}   
		
		if($secret == "on") {
			$secret = "y";
		} else {
			$secret = "n";
		}

		$content = str_replace("\r\n", "<br>", $content);
		
		$query = "insert into {$tb_name}(title, id, writer, password, content, file, secret, regdate) values('{$title}', '{$id}', '{$writer}', '{$password}', '{$content}', '{$uploadFile}', '{$secret}', now())";
		$db_conn->query($query);
	} else if($mode == "modify") {
		$idx = $_POST["idx"];
		$title = $_POST["title"];
		$password = $_POST["password"];
		$content = $_POST["content"];
		$secret = $_POST["secret"];
		$uploadFile = $_POST["oldfile"];

		if(empty($idx) || empty($title) || empty($password) || empty($content)) {
			echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
			exit();
		}

		# Password Check Logic
		$query = "select * from {$tb_name} where idx={$idx} and password='{$password}'";
		$result = $db_conn->query($query);
		$num = $result->num_rows;

		if($num == 0) {
			echo "<script>alert('패스워드가 일치하지 않습니다.');history.back(-1);</script>";
			exit();
		}

		if(!empty($_FILES["userfile"]["name"])) {
			$uploadFile = $_FILES["userfile"]["name"];
			$uploadPath = "{$upload_path}/{$uploadFile}";
			
			if(!(@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadPath))) {
				echo("<script>alert('파일 업로드를 실패 하셨습니다.');history.back(-1);</script>");
				exit;
			}
		}
		
		if($secret == "on") {
			$secret = "y";
		} else {
			$secret = "n";
		}
		
		$content = str_replace("\r\n", "<br>", $content);
		
		$query = "update {$tb_name} set title='{$title}', content='{$content}', file='{$uploadFile}', secret='{$secret}', regdate=now() where idx={$idx}";
		$db_conn->query($query);
	} else if($mode == "delete") {
		$idx = $_POST["idx"];
		$password = $_POST["password"];
		
		# Password Check Logic
		$query = "select * from {$tb_name} where idx={$idx} and password='{$password}'";
		$result = $db_conn->query($query);
		$num = $result->num_rows;

		if($num == 0) {
			echo "<script>alert('패스워드가 일치하지 않습니다.');history.back(-1);</script>";
			exit();
		}
		
		$query = "delete from {$tb_name} where idx={$idx}";
		$db_conn->query($query);
	}

	echo "<script>location.href='index.php';</script>";
	$db_conn->close();
?>