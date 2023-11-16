<?
  $db_conn = mysql_conn();

  $id = $_POST["id"];
  $password1 = $_POST["password1"];
  $password2 = $_POST["password2"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $company = $_POST["company"];

  if(!empty($id) && !empty($password1) && !empty($password2) && !empty($name) && !empty($email)) {
    if($password1 != $password2) {
			echo "<script>alert('패스워드가 일치하지 않습니다.');history.back(-1);</script>";
			exit();
    }

    $password = md5($password1);

    $query = "insert into members(id, password, name, email, company) values('{$id}', '{$password}', '{$name}', '{$email}', '{$company}')";
    $result = $db_conn->query($query);

    echo "<script>alert('회원가입이 완료되었습니다.');location.href='index.php?page=login';</script>";
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
 