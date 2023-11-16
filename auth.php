<?
	include_once("./common.php");

	$db_conn = mysql_conn();

	$mode = $_REQUEST["mode"];
	$idx = $_REQUEST["idx"];

	if($mode == "view") {
		$page = "index.php?page=view";
	} else if($mode == "delete") {
		$page = "action.php";
	}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>::CREHACKTIVE INSECURE WEB-SITE ::</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
		<h1 class="display-4">Auth Page</h1>
    	<hr>
    </div>
    
    <div class="container">
		<form action="<?=$page?>" method="POST">
			<div class="form-group ">
				<label>Password</label>
				<input type="password" class="form-control " name="password" placeholder="Password Input">
			</div>
			<div class="text-center">
				<input type="hidden" name="idx" value="<?=$idx?>">
				<input type="hidden" name="mode" value="<?=$mode?>">
				<button type="submit" class="btn btn-outline-info">Auth</button>
				<button type="button" class="btn btn-outline-danger" onclick="history.back(-1);">Back</button>
			</div>
		</form>
    </div>
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="./js/jquery-slim.min.js"><\/script>')</script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>
<?
	$db_conn->close();
?>
