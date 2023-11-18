<?
  @session_start();
  include_once("./common.php");
  $page = $_GET["page"];

  if(empty($page)) {
    $page = "list.php";
  } else if ($page == "mypage") {
    $page = "mypage.php";
  } else if ($page == "login") {
    $page = "login.php";
  } else if ($page == "join") {
    $page = "join.php";
  } else if ($page == "pingcheck") {
    $page = "pingcheck.php";
  } else if ($page == "xmlparser") {
    $page = "xmlparser.php";
  } else if ($page == "write") {
    $page = "write.php";
  } else if ($page == "view") {
    $page = "view.php";
  } else if ($page == "modify") {
    $page = "modify.php";
  } else if ($page == "auth") {
    $page = "auth.php";
  } else if ($page == "error") {
    $page = "error.php";
  } else {
    echo "<script>location.href='index.php?page=error&value={$page}';</script>";
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>::WHS-Dolphin ::</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/pricing.css" rel="stylesheet">
    <style>
      .table thead.thead-dark th {
        background-color: #32F1FF;
        border-color: #32F1FF;
      }
      .dolphin-icon {
        background-image: url('/WHS_Dolphin/htmlpurifier/art/dolphin.svg');
        display: inline-block;
        height: 24px; /* Adjust as needed */
        width: 24px; /* Adjust as needed */
      
}

     </style> 
    
  </head>

<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <span class="dolphin-icon"></span>&nbsp;&nbsp;
      <h5 class="my-0 mr-md-auto font-weight-normal">WHS-Dolphin</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="index.php">Home</a>
        <? if(empty($_SESSION["id"])) { ?>
        <a class="p-2 text-dark" href="index.php?page=login">Login</a>
        <a class="p-2 text-dark" href="index.php?page=join">Join</a>
        <? } else { ?>
        <a class="p-2 text-dark" href="index.php?page=mypage&id=<?=$_SESSION["id"]?>">MyPage</a>
        <? if($_SESSION["id"] == "admin") { ?>
        <a class="p-2 text-dark" href="index.php?page=pingcheck">Ping Check</a>
        <a class="p-2 text-dark" href="index.php?page=xmlparser">XML Parser</a>
        <? } ?>
        <a class="p-2 text-dark" href="logout.php">Logout</a>
        <? } ?>
      </nav>
    </div>

    <div class="container">
    <? include $page; ?>
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
