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
		<h1 class="display-4">View Page</h1>
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
        <?php if(!empty($row["file"])) { ?>
        <tr>
          <th scope="row" width="20%" class="text-center">File</th>
          <td><a href="download.php?file=<?=$row["file"]?>"><?=$row["file"]?></a></td>
        </tr>
        <?php } ?>
        </tbody>
      </table>
      <div class="text-right">
        <?php 
        $session_id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
        $row_id = isset($row["id"]) ? $row["id"] : "";

        if($session_id == $row_id) { ?>
        <button type="button" class="btn btn-outline-secondary" onclick="location.href='index.php?page=modify&idx=<?=$row["idx"]?>'">Modify</button>
        <button type="button" class="btn btn-outline-danger" onclick="location.href='index.php?page=auth&mode=delete&idx=<?=$row["idx"]?>'">Delete</button>
        <?php } ?>
        <button type="button" class="btn btn-outline-success" onclick="location.href='follow.php'">Follow</button>
        <button type="button" class="btn btn-outline-warning" onclick="location.href='index.php'">List</button>
      </div>
		  <br>

      <?php
      $query = "SELECT * FROM comments WHERE post_idx={$idx}";
      $result_comment = $db_conn->query($query);

      $num_comment = $result_comment->num_rows;

      if($num_comment != 0) {
        for ( $i=0; $i<$num_comment; $i++ ) {
          $row_comment = $result_comment->fetch_assoc();
          $comment_idx = $row_comment['idx'];?>
          <div class="comment-sect">
            <div class="comment-header">
              <span><?=$row_comment["writer"]?></span>
              <span><?=$row_comment["regdate"]?></span>
            </div>  
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div id="commentContent<?=$comment_idx?>" class="comment-content">
                <?=$row_comment["content"]?>
              </div>
              <div style="text-align: right;">
                <?php if($session_id == $row_comment['writer']) { # If session id is same with comment writer id ?>
                  <div style="display: flex;">
                    <!-- Edit form -->
                    <button id="editButton<?=$comment_idx?>" class="btn btn-outline-primary" style="margin-right: 10px;" onclick='editComment(<?=$comment_idx?>)'>Edit</button>
                    <form id="editForm<?=$comment_idx?>" style="display:none" action="edit_comment.php" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="comment_idx" value="<?=$comment_idx?>">
                      <input type="hidden" name="post_idx" value="<?=$idx?>">
                      <div class="input-group" style="width: 345%">
                        <textarea class="form-control" name="new_content"><?=$row_comment["content"]?></textarea>
                        <div class="input-group-append">
                          <button class="btn btn-outline-success" type="submit">Save</button>
                        </div>
                      </div>
                    </form>
                    <!-- Delete form -->
                    <form action="delete_comment.php" method="post">
                      <input type="hidden" name="comment_idx" value="<?=$comment_idx?>">
                      <input type="hidden" name="post_idx" value="<?=$idx?>">
                      <div class="input-group-append">
                        <button id="deleteButton<?=$comment_idx?>" class="btn btn-outline-danger" type="submit">Delete</button>
                      </div>
                    </form>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>	
        <?php }
      } ?>

      <div class="comment-section">
        <form action="comment_process.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="idx" value="<?=$row["idx"]?>">
          <div class="input-group mb-3">
            <textarea class="form-control" name="content" placeholder="Comment.."></textarea>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
	  </div>
  <?php	} else { ?>
    <script>alert("Not existing post.");history.back(-1);</script>
  <?php	} ?>

  <?php
    $db_conn->close();
  ?>

  <script>
    function editComment(comment_idx) {
      // Hide the original comment, Edit button, and Delete button
      document.getElementById('commentContent' + comment_idx).style.display = 'none';
      document.getElementById('editButton' + comment_idx).style.display = 'none';
      document.getElementById('deleteButton' + comment_idx).style.display = 'none';

      // Show the edit form
      document.getElementById('editForm' + comment_idx).style.display = 'block';
    }
  </script>
</body>