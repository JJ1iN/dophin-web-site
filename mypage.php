<?
	include_once("./common.php");

	$db_conn = mysql_conn();
	$id = $_GET["id"];
	$gubun = $_POST["gubun"];

	if($gubun == "action") {
		$name = $db_conn->real_escape_string($_POST["name"]);
		$email = $db_conn->real_escape_string($_POST["email"]);
		$company = $db_conn->real_escape_string($_POST["company"]);
		$password = $_POST["password"];
		if(!empty($password)) {
			$password = md5($password);
			$query = "update members set name='{$name}', email='{$email}', company='{$company}', password='{$password}' where id='{$id}'";
			$result = $db_conn->query($query);
		} else {
			$query = "update members set name='{$name}', email='{$email}', company='{$company}' where id='{$id}'";
			$result = $db_conn->query($query);
		}
		echo "<script>alert('회원정보 수정완료');</script>";
	}

	$query = "select * from members where id='{$id}'";

	$result = $db_conn->query($query);
	$num = $result->num_rows;
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">My Page</h1>
      <hr>
    </div>
	<?
	if($num != 0) {
	  $row = $result->fetch_assoc();
	?>
	<form action="index.php?page=mypage&id=<?=$id?>" method="POST">
	<input type="hidden" name="gubun" value="action">
    <div class="form-group">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="name" placeholder="Name Input" value="<?=$row["name"]?>">
		</div>
		<div class="form-group">
			<label>Password</label>
			<input type="password" class="form-control" name="password" placeholder="Password Input" value="">
			<small id="emailHelp" class="form-text text-muted">※ 패스워드 변경 시 패스워드 입력</small>
		</div>
		<div class="form-group">
			<label>E-mail</label>
			<input type="email" id="email" class="form-control" name="email" placeholder="E-mail Input" value="<?=$row["email"]?>">
		</div>
		<div class="form-group">
			<label>Company</label>
			<input type="text" class="form-control" name="company" placeholder="Company Input" value="<?=$row["company"]?>">
		</div>
		<div class="text-center">
			<input type="submit" class="btn btn-info" value="수정하기">
			<button type="button" class="btn btn-danger" onclick="if(confirm('탈퇴 하시겠습니까?')) location.href='withdrawal.php?id=<?=$_SESSION["id"]?>'">회원탈퇴하기</button>
		</div>
	</div>
	</form>
	<? } else { ?>
		<script>alert("존재하지 않는 사용자 입니다.");history.back(-1);</script>
	<? } ?>
<?
	$db_conn->close();
?>
