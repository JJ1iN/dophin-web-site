<?php
	@session_start();
	header("Content-Type: text/html; charset=UTF-8");
	include ('./common.php');

	$mode = $_REQUEST["mode"];
	$db_conn = mysql_conn();
	
	if($mode == "write") {
		$title = xss_html_entity($_POST["title"]);
		$id = $_SESSION["id"];
		$writer = xss_html_entity($_SESSION["name"]);
		$password = $_POST["password"];
		$content = xss_protect($_POST["content"]);
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
		
		// $query = "insert into {$tb_name}(title, id, writer, password, content, file, secret, regdate) values('{$title}', '{$id}', '{$writer}', '{$password}', '{$content}', '{$uploadFile}', '{$secret}', now())";
		// $db_conn->query($query);

		# Prepared Statement
		$stmt = $db_conn->prepare("INSERT INTO {$tb_name} (title, id, writer, password, content, file, secret, regdate) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
		$stmt->bind_param("sssssss", $title, $id, $writer, $password, $content, $uploadFile, $secret);
		$stmt->execute();
	} else if($mode == "modify") {
		$idx = $_POST["idx"];
		$title = xss_html_entity($_POST["title"]);
		$password = $_POST["password"];
		$content = xss_protect($_POST["content"]);
		$secret = $_POST["secret"];
		$uploadFile = $_POST["oldfile"];

		if(empty($idx) || empty($title) || empty($password) || empty($content)) {
			echo "<script>alert('빈칸이 존재합니다.');history.back(-1);</script>";
			exit();
		}

		# Password Check Logic

		// $query = "select * from {$tb_name} where idx={$idx} and password='{$password}'";
		// $result = $db_conn->query($query);

		# Prepared Statement
		$stmt = $db_conn->prepare("SELECT * FROM {$tb_name} WHERE idx=? AND password=?");
		$stmt->bind_param("is", $idx, $password);
		$stmt->execute();

		$result = $stmt->get_result();
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
		
		// $query = "update {$tb_name} set title='{$title}', content='{$content}', file='{$uploadFile}', secret='{$secret}', regdate=now() where idx={$idx}";
		// $db_conn->query($query);
		
		# Prepared Statement
		$stmt = $db_conn->prepare("UPDATE {$tb_name} SET title=?, content=?, file=?, secret=?, regdate=NOW() WHERE idx=?");
		$stmt->bind_param("ssssi", $title, $content, $uploadFile, $secret, $idx);
		$stmt->execute();
	} else if($mode == "delete") {
		$idx = $_POST["idx"];
		$password = $_POST["password"];
		
		# Password Check Logic

		// $query = "select * from {$tb_name} where idx={$idx} and password='{$password}'";
		// $result = $db_conn->query($query);
		// $num = $result->num_rows;

		# Prepared Statement
		$stmt = $db_conn->prepare("SELECT * FROM {$tb_name} WHERE idx=? AND password=?");
		$stmt->bind_param("is", $idx, $password);
		$stmt->execute();
		
		$result = $stmt->get_result();
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

	function xss_html_entity($value) {
		$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		return $value;
	}

	function xss_protect($value) {
		// 웹사이트에서 다운받아 적당한 곳에 압축 푸세요.
		require_once('./htmlpurifier/library/HTMLPurifier.auto.php');

		// 기본 설정을 불러온 후 적당히 커스터마이징을 해줍니다.
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Attr.EnableID', false);
		$config->set('Attr.DefaultImageAlt', '');

		// 인터넷 주소를 자동으로 링크로 바꿔주는 기능
		$config->set('AutoFormat.Linkify', true);

		// 이미지 크기 제한 해제 (한국에서 많이 쓰는 웹툰이나 짤방과 호환성 유지를 위해)
		$config->set('HTML.MaxImgLength', null);
		$config->set('CSS.MaxImgLength', null);

		// 다른 인코딩 지원 여부는 확인하지 않았습니다. EUC-KR인 경우 iconv로 UTF-8 변환후 사용하시는 게 좋습니다.
		$config->set('Core.Encoding', 'UTF-8');

		// 필요에 따라 DOCTYPE 바꿔쓰세요.
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');

		// 플래시 삽입 허용
		$config->set('HTML.FlashAllowFullScreen', true);
		$config->set('HTML.SafeEmbed', true);
		$config->set('HTML.SafeIframe', true);
		$config->set('HTML.SafeObject', true);
		$config->set('Output.FlashCompat', true);

		// 최근 많이 사용하는 iframe 동영상 삽입 허용
		$config->set('URI.SafeIframeRegexp', '#^(?:https?:)?//(?:'.implode('|', array(
			'www\\.youtube(?:-nocookie)?\\.com/',
			'maps\\.google\\.com/',
			'player\\.vimeo\\.com/video/',
			'www\\.microsoft\\.com/showcase/video\\.aspx',
			'(?:serviceapi\\.nmv|player\\.music)\\.naver\\.com/',
			'(?:api\\.v|flvs|tvpot|videofarm)\\.daum\\.net/',
			'v\\.nate\\.com/',
			'play\\.mgoon\\.com/',
			'channel\\.pandora\\.tv/',
			'www\\.tagstory\\.com/',
			'play\\.pullbbang\\.com/',
			'tv\\.seoul\\.go\\.kr/',
			'ucc\\.tlatlago\\.com/',
			'vodmall\\.imbc\\.com/',
			'www\\.musicshake\\.com/',
			'www\\.afreeca\\.com/player/Player\\.swf',
			'static\\.plaync\\.co\\.kr/',
			'video\\.interest\\.me/',
			'player\\.mnet\\.com/',
			'sbsplayer\\.sbs\\.co\\.kr/',
			'img\\.lifestyler\\.co\\.kr/',
			'c\\.brightcove\\.com/',
			'www\\.slideshare\\.net/',
		)).')#');

		// 설정을 저장하고 필터링 라이브러리 초기화
		$purifier = new HTMLPurifier($config);

		// HTML 필터링 실행
		$html = $purifier->purify($value);

		return $html;
	}
?>