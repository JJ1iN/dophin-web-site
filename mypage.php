<?php
	@session_start();
	include_once("./common.php");

	$db_conn = mysql_conn();

	$id = isset($_GET["id"]) ? $_GET["id"] : "";
  $gubun = isset($_POST["gubun"]) ? $_POST["gubun"] : "";

	if(!isset($_SESSION["id"]) || $_SESSION["id"] != $id) {
		echo "<script>alert('로그인이 필요한 서비스입니다.');location.href='index.php?page=login';</script>";
		exit();
	}

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
		echo "<script>alert('Complete!');</script>";
	}

	$query = "select * from members where id='{$id}'";

	$result = $db_conn->query($query);
	$num = $result->num_rows;
?>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">My Page</h1>
  <hr>
</div>

<?php
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
        <input type="submit" class="btn btn-info" value="Modify">
        <button type="button" class="btn btn-danger" 
          onclick='if(confirm("탈퇴 하시겠습니까?")) location.href="withdrawal.php?id=<?=$_SESSION['id']?>"'>
          Delete
        </button>
      </div>
    </div>
	</form>
<?php } else { ?>
  <script>alert("Not existing user.");history.back(-1);</script>
<?php } ?>

<?php
	$db_conn->close();
?>
