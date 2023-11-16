<?
  @include_once("./common.php");
  
  $db_conn = mysql_conn();
  $page = $_SERVER['REQUEST_URI'];

  # Search Logic
  $search_type = $_POST["search_type"];
  $keyword = $_POST["keyword"];

  if(empty($search_type) && empty($keyword)) {
    $query = "select * from {$tb_name}";
  } else {
    if($search_type == "all") {
      $query = "select * from {$tb_name} where title like '%{$keyword}%' or writer like '%{$keyword}%' or content like '%{$keyword}%'";
    } else {
      $query = "select * from {$tb_name} where {$search_type} like '%{$keyword}%'";
    }
  }

  # Sort Logic
  $sort = $_GET["sort"];
  $sort_column = $_GET["sort_column"];

  if(empty($sort_column) && empty($sort)) {
    $query .= " order by idx desc";
  } else {
    $query .= " order by {$sort_column} {$sort}";
  }

  $result = $db_conn->query($query);
  $num = $result->num_rows;
?>
    <div class="container">
    <? if(!empty($_SESSION["id"])) { ?>
		<div class="text-right">
			<p><button type="button" class="btn btn-outline-secondary" onclick="location.href='index.php?page=write'">Write</button><p>
    </div>
    <? } else { ?>
      <p>&nbsp;</p>
    <? } ?>
		<table class="table">
		  <thead class="thead-dark">
			<tr>
			  <th width="10%" scope="col" class="text-center"><a href="index.php?sort_column=idx&sort=desc" class="stretched-link text-white">No</a></th>
			  <th width="50%" scope="col" class="text-center"><a href="index.php?sort_column=title&sort=desc" class="stretched-link text-white">Title</a></th>
			  <th width="20%" scope="col" class="text-center"><a href="index.php?sort_column=writer&sort=desc" class="stretched-link text-white">Write</a></th>
			  <th width="20%" scope="col" class="text-center"><a href="index.php?sort_column=regdate&sort=desc" class="stretched-link text-white">Date</a></th>
			</tr>
		  </thead>
		  <tbody>
			<?
			if($num != 0) {
				for ( $i=0; $i<$num; $i++ ) {
				  $row = $result->fetch_assoc();
			?>
			<tr>
			  <th scope="row" class="text-center"><?=$row["idx"]?></th>
        <? if($row["secret"]=="y") { ?>
        <td><span style="display:inline-block; height:15px; width:15px;" data-feather="lock"></span>&nbsp;<a href="index.php?page=auth&idx=<?=$row["idx"]?>&mode=view"><?=$row["title"]?></a></td>
        <? } else { ?>
          <td><a href="index.php?page=view&idx=<?=$row["idx"]?>"><?=$row["title"]?></a></td>
        <? } ?>
			  
			  <td class="text-center"><?=$row["writer"]?></td>
			  <td class="text-center"><?=$row["regdate"]?></td>
			</tr>
			<?
				}
			} else {
			?>
            <tr>
              <td colspan="4" class="text-center">Posts does not exist.</td>
            </tr>
			<?
			}
			?>
		  </tbody>
		</table>
		<form action="<?=$page?>" method="POST">
			<div class="input-group mb-3">
        <div class="col-auto my-1">
          <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">search</label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="search_type">
            <option value="all" selected>All</option>
            <option value="title">title</option>
            <option value="writer">writer</option>
            <option value="content">content</option>
          </select>
        </div>
				<input type="text" class="form-control" placeholder="Keyword Input" name="keyword">
				<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="submit">Search</button>
				</div>
			</div>
		</form>
    </div>
<?
	$db_conn->close();
?>
