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
		if (isset($shonupost['language']) && isset($shonupost['pageNo']) && isset($shonupost['pageSize']) && isset($shonupost['random']) && isset($shonupost['signature']) && isset($shonupost['timestamp'])) {
			$language = (int) $shonupost['language'];
			$pageNo = (int) $shonupost['pageNo'];
			$pageSize = (int) $shonupost['pageSize'];
			$random = $conn->real_escape_string($shonupost['random']);
			$signature = $conn->real_escape_string($shonupost['signature']);

			$shonustr = '{"language":'.$language.',"pageNo":'.$pageNo.',"pageSize":'.$pageSize.',"random":"'.$random.'"}';
			$shonusign = strtoupper(md5($shonustr));

			if($shonusign == $signature){
				$bearer = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
				$author = $bearer[1] ?? '';				
				$is_jwt_valid = is_jwt_valid($author);
				$data_auth = json_decode($is_jwt_valid, 1);
				if($data_auth['status'] === 'Success') {
					$sesquery = "SELECT akshinak FROM shonu_subjects WHERE akshinak = '$author'";
					$sesresult = $conn->query($sesquery);
					if($sesresult && $sesresult->num_rows == 1){
						
						$data["list"] = [
							[
								"bannerTitle" => "Inviter maximum reward ₹777777",
								"bannerID" => 3,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_202504111409166ool.png",
								"jumpType" => 2,
								"contents" => "http://127.0.0.1:8080/#/main/InvitationBonus"
							],
							[
								"bannerTitle" => "Download theTASHANWIN app to share 100000000RS red envelope",
								"bannerID" => 55,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250417171000vues.png",
								"jumpType" => 1,
								"contents" => ""
							],
							[
								"bannerTitle" => "Daily recharge task maximum reward is 13%",
								"bannerID" => 1,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_2025041020104474ya.png",
								"jumpType" => 2,
								"contents" => "http://127.0.0.1:8080/#/activity/DailyTasks"
							],
							[
								"bannerTitle" => "WELCOME TO TASHANWIN GAMES",
								"bannerID" => 36,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250411141013fsd6.png",
								"jumpType" => 3,
								"contents" => ""
							],
							[
								"bannerTitle" => "Daily sign-in recharge reward",
								"bannerID" => 44,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250411141202mscc.png",
								"jumpType" => 3,
								"contents" => ""
							],
							[
								"bannerTitle" => "15-day cumulative recharge reward",
								"bannerID" => 42,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_2025041114113062h8.png",
								"jumpType" => 3,
								"contents" => ""
							],
							[
								"bannerTitle" => "Lucky roulette Highest reward iPhone16",
								"bannerID" => 47,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250413131345fmj2.png",
								"jumpType" => 2,
								"contents" => "http://127.0.0.1:8080/#/activity/Turntable"
							],
							[
								"bannerTitle" => "Wingo winning streak reward",
								"bannerID" => 48,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250413133757y7on.png",
								"jumpType" => 3,
								"contents" => ""
							],
							[
								"bannerTitle" => "Pilot special challenge",
								"bannerID" => 49,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_202504131338354j4n.png",
								"jumpType" => 3,
								"contents" => ""
							],
							[
								"bannerTitle" => "CREATIVE VIDEO BONUS",
								"bannerID" => 50,
								"bannerUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250413134610gas4.png",
								"jumpType" => 3,
								"contents" => ""
							]
						];

						$data['pageNo'] = $pageNo;
						$data['totalPage'] = 1;
						$data['totalCount'] = 20;

						$res['data'] = $data;
						$res['code'] = 0;
						$res['msg'] = 'Succeed';
						$res['msgCode'] = 0;
						$res['serviceNowTime'] = $shnunc;
						http_response_code(200);
						echo json_encode($res);
						exit;
					}
				}
			} else {
				$res['code'] = 5;
				$res['msg'] = 'Wrong signature';
				$res['msgCode'] = 3;
			}
		} else {
			$res['code'] = 7;
			$res['msg'] = 'Param is Invalid';
			$res['msgCode'] = 6;
		}
		http_response_code(200);
		echo json_encode($res);
	} else {
		http_response_code(405);
		echo json_encode([
			'code' => 11,
			'msg' => 'Url is not exist',
			'msgCode' => 5,
			'serviceNowTime' => $shnunc
		]);
	}
?>
