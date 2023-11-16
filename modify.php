<?
	include_once("./common.php");

	$db_conn = mysql_conn();
	$idx = $_GET["idx"];

	$query = "select * from {$tb_name} where idx={$idx}";
  
	$result = $db_conn->query($query);
	$num = $result->num_rows;
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Modify Page</h1>
      <hr>
    </div>
	<?
	if($num != 0) {
	  $row = $result->fetch_assoc();
	?>
    <div class="container">
		<form action="action.php" method="POST" enctype="multipart/form-data">
		  <div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" name="title" placeholder="Title Input" value="<?=$row["title"]?>">
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password" class="form-control" name="password" placeholder="Password Input">
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Contents</label>
			<textarea class="form-control" name="content" rows="5" placeholder="Contents Input"><?=$row["content"]?></textarea>
      </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">File</label>
      <? if(!empty($row["file"])) { ?>
      <p class="font-italic">[Attach]&nbsp;<?=$row["file"]?></p>
      <? } ?>
      <input type="hidden" class="form-control" name="oldfile" value="<?=$row["file"]?>">
			<input type="file" class="form-control" name="userfile">
		  </div>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="customCheck1" name="secret" <? if($row["secret"]=="y") echo "checked"; ?>>
        <label class="custom-control-label" for="customCheck1">Secret Post</label>
      </div>
		<div class="text-right">
			<input type="hidden" name="idx" value="<?=$row["idx"]?>">
			<input type="hidden" name="mode" value="modify">
			<button type="submit" class="btn btn-outline-secondary">Modify</button>
			<button type="button" class="btn btn-outline-danger" onclick="history.back(-1);">Back</button>
		</div>
		</form>
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
