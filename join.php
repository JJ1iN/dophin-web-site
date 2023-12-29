<?php
  $db_conn = mysql_conn();

  $id = isset($_POST["id"]) ? $_POST["id"] : "";
  $password1 = isset($_POST["password1"]) ? $_POST["password1"] : "";
  $password2 = isset($_POST["password2"]) ? $_POST["password2"] : "";
  $name = isset($_POST["name"]) ? $_POST["name"] : "";
  $email = isset($_POST["email"]) ? $_POST["email"] : "";
  $company = isset($_POST["company"]) ? $_POST["company"] : "";

  if(!empty($id) && !empty($password1) && !empty($password2) && !empty($name) && !empty($email)) {
    if($password1 != $password2) {
			echo "<script>alert('패스워드가 일치하지 않습니다.');history.back(-1);</script>";
			exit();
    }

    $password = md5($password1);

    // $query = "insert into members(id, password, name, email, company) values('{$id}', '{$password}', '{$name}', '{$email}', '{$company}')";
    // $result = $db_conn->query($query);

    # Prepared Statement
    $stmt = $db_conn->prepare("INSERT INTO members (id, password, name, email, company) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $password, $name, $email, $company);
    $stmt->execute();

    echo "<script>alert('Welcome!');location.href='index.php?page=login';</script>";
    exit();
  }
?>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">Join Page</h1>
  <hr>
</div>

<div class="container">
  <form action="index.php?page=join" method="POST">
    <div class="form-group">
    <label>ID</label>
    <input type="text" class="form-control" name="id" placeholder="ID Input">
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password1" placeholder="Password Input">
    <small class="form-text text-muted">※ Your password should be <b>at least 8 characters</b>, contain a mix of <b>uppercase or lowercase letters, a number, and a special character.</b></small>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword2">Password Check</label>
    <input type="password" class="form-control" name="password2" placeholder="Password Check Input">
    </div>
    <div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" name="name" placeholder="Name Input">
    </div>
    <div class="form-group">
    <label>E-mail</label>
    <input type="email" id="email" class="form-control" name="email" placeholder="E-mail Input">
    </div>
    <div class="form-group">
    <label>Company</label>
    <input type="text" class="form-control" name="company" placeholder="Company Input">
    </div>
    <div class="text-center">
    <button type="submit" class="btn btn-outline-danger">JOIN</button>
    </div>
  </form>
</div>

<!-- Password Strength Check -->
<script src="checkPasswordComplexity.js"></script>
<script>
window.onload = function() {
  var passwordInput = document.querySelector('input[name="password1"]');
  passwordInput.addEventListener('blur', function() {
    var password = passwordInput.value;
    var passwordStrength = checkPasswordComplexity(password);
    if (passwordStrength == 'Weak') {
      alert("Your password is too weak.");
      passwordInput.value = '';
    }
  });
};
</script>