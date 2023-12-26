<?php
  @session_start();
  include_once("./common.php");

  $db_conn = mysql_conn();
  $copywriter = $_GET["copywriter"];

  $query = "insert into copywirter(copywriter) values('{$copywriter}')";
  $result = $db_conn->query($query);

  
  echo "<script>location.href='follow.php'</script>";
?>