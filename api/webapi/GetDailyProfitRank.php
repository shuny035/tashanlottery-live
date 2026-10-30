<?php 
	include "../../conn.php";

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
			$shonustr = '{"language":'.$language.',"random":"'.$random.'"}';
			$shonusign = strtoupper(md5($shonustr));
			if($shonusign == $signature){
				http_response_code(200);
				echo '{
				    "data": {
        "dataList": [
            {
                "type": "1",
                "typeName": "WinGo_1min",
                "userPhoto": "2",
                "nickName": "MemberCRLYACYC",
                "betAmount": 50000.00,
                "amount": 98000.00,
                "winTime": "2025-04-17 09:30:57",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "18",
                "nickName": "MemberKNKRPBTU",
                "betAmount": 30.00,
                "amount": 40.80,
                "winTime": "2025-04-15 00:06:54",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "19",
                "nickName": "MemberJJRBJFQD",
                "betAmount": 30.00,
                "amount": 46.80,
                "winTime": "2025-04-15 00:06:11",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "9",
                "nickName": "MemberZOEOMRIM",
                "betAmount": 30.00,
                "amount": 59.70,
                "winTime": "2025-04-14 21:51:16",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "9",
                "nickName": "MemberFQDYDPGW",
                "betAmount": 30.00,
                "amount": 54.90,
                "winTime": "2025-04-14 21:50:27",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "4",
                "nickName": "MemberXACJFQKJ",
                "betAmount": 30.00,
                "amount": 58.80,
                "winTime": "2025-04-14 21:49:08",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "19",
                "nickName": "MemberMVTPNEBJ",
                "betAmount": 30.00,
                "amount": 52.50,
                "winTime": "2025-04-14 20:49:26",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "1",
                "nickName": "MemberFZLEJMDD",
                "betAmount": 30.00,
                "amount": 44.10,
                "winTime": "2025-04-14 20:48:40",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "1",
                "nickName": "MemberNCTKQFNJ",
                "betAmount": 30.00,
                "amount": 44.40,
                "winTime": "2025-04-14 20:47:28",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "17",
                "nickName": "MemberIUFGSPXZ",
                "betAmount": 30.00,
                "amount": 44.10,
                "winTime": "2025-04-14 20:46:11",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "TB_Chess",
                "typeName": "TB_Chess",
                "userPhoto": "5",
                "nickName": "MemberYAPMVMNT",
                "betAmount": 10.00,
                "amount": 15.30,
                "winTime": "2025-04-14 20:45:33",
                "showType": 6,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_202503291815558vj2.png"
            },
            {
                "type": "9",
                "typeName": "K3_1min",
                "userPhoto": "15",
                "nickName": "MemberSINMXKVT",
                "betAmount": 9.80,
                "amount": 19.40,
                "winTime": "2025-04-14 20:39:57",
                "showType": 9,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_2025041212074073ug.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "13",
                "nickName": "MemberTFKEOIAY",
                "betAmount": 10.00,
                "amount": 19.60,
                "winTime": "2025-04-14 20:38:57",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "19",
                "nickName": "MemberCQSKURHR",
                "betAmount": 10.00,
                "amount": 19.60,
                "winTime": "2025-04-14 20:38:27",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "2",
                "nickName": "MemberFDGLBZJU",
                "betAmount": 100.00,
                "amount": 196.00,
                "winTime": "2025-04-11 19:47:57",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "11",
                "nickName": "MemberEOGDXGDX",
                "betAmount": 100.00,
                "amount": 196.00,
                "winTime": "2025-04-11 19:13:57",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "7",
                "nickName": "MemberKAFQGNUA",
                "betAmount": 900.00,
                "amount": 1764.00,
                "winTime": "2025-04-11 19:13:27",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "9",
                "nickName": "MemberYEBQABZM",
                "betAmount": 300.00,
                "amount": 588.00,
                "winTime": "2025-04-11 19:06:27",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "6",
                "nickName": "MemberHFCOGQNE",
                "betAmount": 100.00,
                "amount": 196.00,
                "winTime": "2025-04-11 19:05:27",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "30",
                "typeName": "WinGo_30Sec",
                "userPhoto": "8",
                "nickName": "MemberHSTOMSWG",
                "betAmount": 100.00,
                "amount": 196.00,
                "winTime": "2025-04-11 19:04:57",
                "showType": 11,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/lotterycategory/lotterycategory_20250412120719dqfv.png"
            },
            {
                "type": "IM",
                "typeName": "IM",
                "userPhoto": "15",
                "nickName": "MemberNCGRNJZB",
                "betAmount": 0.0,
                "amount": 50.00,
                "winTime": "2025-04-07 09:07:25",
                "showType": 2,
                "imgUrl": "https://ossimg.tashanedc.com/Tashanwin/vendorlogo/vendorlogo_20250329173714ixbo.png"
            }
        ],
        "penarikanList": [
            {
                "userID": 101998,
                "userPhoto": "1",
                "nickName": "MemberNNGQQDLQ",
                "price": 98000.00,
                "time": "2025-04-17",
                "typeName": "Penarikan",
                "winTime": "2025-04-17"
            }
        ]
    },
				  "code": 0,
				  "msg": "Succeed",
				  "msgCode": 0,
				  "serviceNowTime": "$shnunc"
				}';
			}
			else{
				$res['code'] = 5;
				$res['msg'] = 'Wrong signature';
				$res['msgCode'] = 3;
				http_response_code(200);
				echo json_encode($res);
			}
		}
		else{
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
?>