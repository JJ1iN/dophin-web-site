<?
  include_once("./common.php");
  $ip = $_POST["ip"];
  $page = $_SERVER['REQUEST_URI'];

  if(!empty($ip)) {
	$result = shell_exec("ping {$ip}");
	$result = iconv("EUC-KR", "UTF-8", $result);
	$result = str_replace("\n", "<br>", $result);
  }
?>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Ping Check</h1>
      <hr>
    </div>
    <div class="container">
		<form action="<?=$page?>" method="POST">
		  <div class="form-group">
			<label>Ping</label>
			<input type="text" class="form-control" name="ip" placeholder="IP(ex: 192.168.0.100) Input">
		  </div>
			<div class="text-center">
				<button type="submit" class="btn btn-outline-secondary">Check</button>
			</div>
		</form>
	</div>
	<? if(!empty($result)) { ?>
	<hr>
	<?=$result?>
	<? } ?>