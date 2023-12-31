<?php
@session_start();
include ('./common.php');
$db_conn = mysql_conn();

session_start();
// KAKAO LOGIN
define('KAKAO_CLIENT_ID', '89386f572e521e53290b241600c5b88b');
define('KAKAO_CALLBACK_URL', 'http://144.24.77.217/Dolphin/kakaocallback.php');

// 로그 출력
error_log("Session state: " . $_SESSION['kakao_state']);
error_log("GET state: " . $_GET['state']);

if (isset($_GET['state']) && ($_SESSION['kakao_state'] == $_GET['state'])) {
    if (isset($_GET["code"])) {
        //사용자 토큰 받기
        $code = $_GET["code"];
        $params = sprintf('grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', KAKAO_CLIENT_ID, KAKAO_CALLBACK_URL, $code);

        $TOKEN_API_URL = "https://kauth.kakao.com/oauth/token";
        $opts = array(
            CURLOPT_URL => $TOKEN_API_URL,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION => 1, // TLS
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        );

        $curlSession = curl_init();
        curl_setopt_array($curlSession, $opts);
        $accessTokenJson = curl_exec($curlSession);
        curl_close($curlSession);

        $responseArr = json_decode($accessTokenJson, true);
        $_SESSION['kakao_access_token'] = $responseArr['access_token'];
        $_SESSION['kakao_refresh_token'] = $responseArr['refresh_token'];
        $_SESSION['kakao_refresh_token_expires_in'] = $responseArr['refresh_token_expires_in'];

        //사용자 정보 가저오기
        $USER_API_URL = "https://kapi.kakao.com/v2/user/me";
        $opts = array(
            CURLOPT_URL => $USER_API_URL,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION => 1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $responseArr['access_token']
            )
        );

        $curlSession = curl_init();
        curl_setopt_array($curlSession, $opts);
        $accessUserJson = curl_exec($curlSession);
        curl_close($curlSession);

        $me_responseArr = json_decode($accessUserJson, true);

        if (isset($me_responseArr['id'])) {
            $mb_uid = 'kakao_' . $me_responseArr['id'];

            // 회원이 이미 존재하는지 확인하는 쿼리
            $query = "SELECT * FROM members WHERE id = '$mb_uid'";
            $result = $db_conn->query($query);
            $num = $result->num_rows;

            // 회원이 이미 존재하는 경우
            if ($num > 0) {
                // 로그인 처리를 수행합니다.
                $_SESSION["id"] = $mb_uid;
                $_SESSION["name"] = $me_responseArr['properties']['nickname'];
                header('Location: index.php');
                exit;
            }
            // 회원정보가 없다면 회원가입
            else {

                // 카카오톡에서 받아온 사용자 정보
                $mb_uid = 'kakao_' . $me_responseArr['id'];
                $mb_nickname = $me_responseArr['properties']['nickname'];

                // 이메일 주소 생성
                $mb_email = $mb_uid . '@kakao.com';

                // 비밀번호 설정 (여기서는 id를 그대로 사용했습니다)
                $password = md5($mb_uid); // 비밀번호를 해시 처리합니다.

                // 회사 이름 설정 (여기서는 닉네임을 그대로 사용했습니다)
                $company = 'KaKao';

                // 회원가입 쿼리

                $query = "INSERT INTO members (id, password, name, email, company) 
          VALUES ('$mb_uid', '$password', '$mb_nickname', '$mb_email', '$company')";


                // 쿼리 실행
                $db_conn->query($query);

                // 회원가입 후 바로 로그인 처리
                $_SESSION["id"] = $mb_uid;
                $_SESSION["name"] = $mb_nickname;

                header('Location: index.php');
                exit;
            }

        } else {
            echo "<script>alert('사용자 정보를 가져오는 데 실패했습니다.'); location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('인증 코드가 없습니다.'); location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('잘못된 경로로 접근하셨습니다.'); location.href='index.php';</script>";
}

