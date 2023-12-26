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

<head>
	<link rel="stylesheet" href="./css/comment.css">
</head>
<body>
  <?php
    $db_conn = mysql_conn();
    $idx = isset($_REQUEST["idx"]) && is_numeric($_REQUEST["idx"]) ? $_REQUEST["idx"] : null;

    if($idx !== null) {
      $password = isset($_POST["password"]) ? $_POST["password"] : "";

      if(empty($password)) {
        $query = "select * from {$tb_name} where idx={$idx} and secret='n'";
      } else {
        $query = "select * from {$tb_name} where idx={$idx} and password='{$password}'";
      }

      $result_post = $db_conn->query($query);
      $num_post = $result_post->num_rows;
    }
  ?>

	<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-4">Follow</h1>
		<hr>
	</div>

	<div class="container">
    <?php
    if($num_post != 0) {
      $row = $result_post->fetch_assoc();
    ?>
      <table class="table table-bordered">
        <tbody>
        <tr>
          <th scope="row" width="20%" class="text-center">Follows</th>
          <td><?=$row["copywriter"]?></td>
        </tr>
        <?php ?>
        </tbody>
      </table>
  <?php	} ?>
 

  <?php
    $db_conn->close();
  ?>
</body>