<?
	$db_conn = mysql_conn();
	$idx = $_REQUEST["idx"];
	$password = $_POST["password"];

	if(empty($password)) {
		$query = "select * from {$tb_name} where idx={$idx} and secret='n'";
	} else {
		$query = "select * from {$tb_name} where idx={$idx} and password='{$password}'";
	}
	
	$result = $db_conn->query($query);
	$num = $result->num_rows;
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-4">View Page</h1>
    	<hr>
    </div>
    
    <div class="container">
	<?
	if($num != 0) {
		$row = $result->fetch_assoc();
	?>
		<table class="table table-bordered">
		  <tbody>
			<tr>
			  <th scope="row" width="20%" class="text-center">Title</th>
			  <td><?=$row["title"]?></td>
			</tr>
			<tr>
			  <th scope="row" width="20%" class="text-center">Writer</th>
			  <td><?=$row["writer"]?></td>
			</tr>
			<tr>
			  <th scope="row" width="20%" class="text-center">Date</th>
			  <td><?=$row["regdate"]?></td>
			</tr>
			<tr>
			  <th scope="row" width="20%" class="text-center">Contents</th>
			  <td><?=$row["content"]?></td>
			</tr>
			<? if(!empty($row["file"])) { ?>
			<tr>
			  <th scope="row" width="20%" class="text-center">File</th>
			  <td><a href="download.php?file=<?=$row["file"]?>"><?=$row["file"]?></a></td>
			</tr>
			<? } ?>
		  </tbody>
		</table>
		<div class="text-right">
			<? if($_SESSION["id"] == $row["id"]) { ?>
			<button type="button" class="btn btn-outline-secondary" onclick="location.href='index.php?page=modify&idx=<?=$row["idx"]?>'">Modify</button>
			<button type="button" class="btn btn-outline-danger" onclick="location.href='index.php?page=auth&mode=delete&idx=<?=$row["idx"]?>'">Delete</button>
			<? } ?>
			<button type="button" class="btn btn-outline-warning" onclick="location.href='index.php'">List</button>
		</div>
    </div>
	<?
	} else {
	?>
		<script>alert("존재하지 않는 게시글 입니다.");history.back(-1);</script>
	<?
	}
	?>

<?
	$db_conn->close();
?>
