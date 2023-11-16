<?
    include_once("./common.php");
    header("Content-Type: text/html; charset=UTF-8");

    $file = $_GET["file"];
    
    if(empty($file)) {
        echo "<script>alert('값이 입력되지 않았습니다.');history.back(-1);</script>";
        exit();
    }


    if(empty($file)) {
        echo "<script>alert('파일 다운로드에 실패하였습니다.');history.back(-1);</script>";
        exit();
    }

    $filepath = "{$upload_path}/{$file}";

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename={$file}");

    @readfile($filepath);
?>