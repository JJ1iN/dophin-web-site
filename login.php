<?
  $db_conn = mysql_conn();
  
  if(!empty($_SESSION["id"])) {
    echo "<script>location.href='index.php';</script>";
    exit();
  }

  $id = $_POST["id"];
  $password = $_POST["password"];
  
  if(!empty($id) && !empty($password)) {
    $password = md5($password);
    $query = "select * from members where id='{$id}' and password='{$password}'";
    $result = $db_conn->query($query);
    $num = $result->num_rows;

    if($num != 0) {
      $row = $result->fetch_assoc();
      $_SESSION["id"] = $row["id"];
      $_SESSION["name"] = $row["name"];
      echo "<script>location.href='index.php';</script>";
    } else {
      echo "<script>alert('아이디 혹은 패스워드가 틀렸습니다.');location.href='index.php?page=login';</script>";
      exit();
    }
  }
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-4">Login Page</h1>
    	<hr>
    </div>

      <div class="row">
        <div class="col-md">
          <form class="needs-validation" action="index.php?page=login" method="POST" novalidate>
            <div class="mb-3">
              <label for="username">ID</label>
              <div class="input-group">
                <input type="text" class="form-control" name="id" id="username" placeholder="Username" required>
              </div>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <div class="invalid-feedback">
                (필수) 패스워드를 입력하세요.
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-info btn-sm btn-block" type="submit">LOGIN</button>
          </form>
        </div>
      </div>
    </div>
