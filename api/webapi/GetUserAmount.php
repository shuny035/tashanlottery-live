<?php
include "../../conn.php";
include "../../functions2.php";

header('Content-Type: application/json; charset=utf-8');
header('Strict-Transport-Security: max-age=31536000');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin: ' . $origin);
header('vary: Origin');

date_default_timezone_set("Asia/Kolkata");
$shnunc = date("Y-m-d H:i:s");
$res = [
    'code' => 11,
    'msg' => 'Method not allowed',
    'msgCode' => 12,
    'serviceNowTime' => $shnunc,
];
$shonubody = file_get_contents("php://input");
$shonupost = json_decode($shonubody, true);

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    if (isset($shonupost['language']) && isset($shonupost['random']) && isset($shonupost['signature']) && isset($shonupost['timestamp'])) {
        $language = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['language']));
        $random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
        $signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));
        $shonustr = '{"language":' . $language . ',"random":"' . $random . '"}';
        $shonusign = strtoupper(md5($shonustr));
        if ($shonusign == $signature) {
            $bearer = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
            $author = $bearer[1];
            $is_jwt_valid = is_jwt_valid($author);
            $data_auth = json_decode($is_jwt_valid, 1);
            if ($data_auth['status'] === 'Success') {
                $sesquery = "SELECT akshinak
					  FROM shonu_subjects
					  WHERE akshinak = '$author'";
                $sesresult = $conn->query($sesquery);
                $sesnum = mysqli_num_rows($sesresult);
                if ($sesnum == 1) {
                    // Fetch user details from the database using the token
                    $userQuery = "SELECT id FROM shonu_subjects WHERE akshinak = '$author'";
                    $userResult = $conn->query($userQuery);

                    // Encrypt payload using AES256 (ECB mode)
                    function encryptAES256ECB($data, $key)
                    {
                        // Ensure the key length is 32 bytes (AES-256 requires 256-bit keys, i.e., 32 bytes)
                        $key = str_pad($key, 32, "\0"); // Pad key if it is less than 32 bytes

                        $encryptedData = openssl_encrypt($data, 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
                        return base64_encode($encryptedData); // Return base64-encoded encrypted data
                    }

                    if ($userResult && $userResult->num_rows > 0) {
                        $userRow = $userResult->fetch_assoc();
                        $userName = $userRow['id']; // 'id' corresponds to 'userName'

                        // Fetch user balance from shonu_kaichila using the userName
                        $balanceQuery = "SELECT motta FROM shonu_kaichila WHERE balakedara = '$userName'";
                        $balanceResult = $conn->query($balanceQuery);

                        if ($balanceResult && $balanceResult->num_rows > 0) {
                              $balanceRow = $balanceResult->fetch_assoc();
                            $userBalance = $balanceRow['motta']; 
                            $res=[
    "data" => [
        "amount" => $userBalance,
        "uRate" => 93,
        "uGold" => 0.25
    ],
    "code" => 0,
    "msg" => "Recovery of the balance is begin",
    "msgCode" => 0,
    "serviceNowTime" => "2025-04-18 02:20:52"
];
                            http_response_code(200);
                            echo json_encode($res);
                        } else {
                            // Handle failure to fetch balance data
                            $res['code'] = 8;
                            $res['msg'] = 'Balance not found for user';
                            http_response_code(400);
                            echo json_encode($res);
                        }
                    } else {
                        // If session validation failed
                        $res['code'] = 4;
                        $res['msg'] = 'No operation permission';
                        http_response_code(401);
                        echo json_encode($res);
                    }
                }
            } else {
                $res['code'] = 4;
                $res['msg'] = 'No operation permission';
                $res['msgCode'] = 2;
                http_response_code(401);
                echo json_encode($res);
            }
        } else {
            $res['code'] = 5;
            $res['msg'] = 'Wrong signature';
            $res['msgCode'] = 3;
            http_response_code(200);
            echo json_encode($res);
        }
    } else {
        $res['code'] = 7;
        $res['msg'] = 'Param is Invalid';
        $res['msgCode'] = 6;
        http_response_code(200);
        echo json_encode($res);
    }
} else {
    http_response_code(405);
    echo json_encode($res);
}
