<?php
  $db_conn = mysql_conn();
  
  # Check if user is already logged in
  if(!empty($_SESSION["id"])) {
    echo "<script>location.href='index.php';</script>";
    exit();
  }

  $id = isset($_POST["id"]) ? $_POST["id"] : "";
  $password = isset($_POST["password"]) ? $_POST["password"] : "";

  if(!empty($id) && !empty($password)) {
    $password = md5($password);

    $query = "SELECT * FROM members WHERE id='{$id}' AND password='{$password}'";
    $result = $db_conn->query($query);
    $num = $result->num_rows;

    if($num != 0) { # If login success
      $row = $result->fetch_assoc();
      $_SESSION["id"] = $row["id"];
      $_SESSION["name"] = $row["name"];
      echo "<script>location.href='index.php';</script>";
    } else { # If login fail
      echo "<script>alert('Wrong Username or Password!');location.href='index.php?page=login';</script>";
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
        <!-- <div class="invalid-feedback">
          (필수) 패스워드를 입력하세요.
        </div> -->
      </div>
      <hr class="mb-4">
      <button class="btn btn-info btn-sm btn-block" type="submit">LOGIN</button>
    </form>
  </div>
</div>