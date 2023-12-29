<?php
  @session_start();
  include_once("./common.php");

  unset($_SESSION["id"]);
  session_destroy();

  $db_conn = mysql_conn();
  $id = $_GET["id"];

  // $query = "delete from members where id='{$id}'";
  // $result = $db_conn->query($query);

  # Prepared Statement
  $stmt = $db_conn->prepare("DELETE FROM members WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  echo "<script>location.href='index.php'</script>";
?>