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

			if ($shonusign == $signature) {
				$data = [
					'isShowAppDownloadUp' => true,
					'isShowAppDownloadDown' => true,
					'isShowLotteryDragon' => true,
					'isSplitLocalEWallet' => true,
					'jackportMaxReswadAmount' => 500.00,
					'projectName' => 'Tashanwin',
					'projectLogo' => 'https://ossimg.tashanedc.com/Tashanwin/other/h5setting_202504041407319gth.png',
					'languages' => 'en|hd',
					'webIco' => 'https://ossimg.tashanedc.com/Tashanwin/other/h5setting_20250404140738dp6p.png',
					'headLogo' => 'https://ossimg.tashanedc.com/Tashanwin/other/h5setting_202504041407355o7l.png',
					'dollarSign' => '₹',
					'upperOrLower' => '0',
					'defaultCurrentLanguage' => 'en',
					'registerMobile' => '1',
					'registerEmail' => '0',
					'areaPhoneLenList' => [
						[
							'area' => '+91',
							'len' => '9-12'
						]
					],
					'registerSms' => '0',
					'isOpenLoginChangeLanguage' => '1',
					'rewardValidityTime' => 30,
					'electronicWinRateExternalLink' => '',
					'electronicWinRateImgUrl' => 'https://ossimg.tashanedc.com/Tashanwin',
					'isShowElectronicWinRateExternalLink' => false,
					'isShowAppHandCodeWashingSwitch' => true,
					'isShowHotGameWinOdds' => true,
					'ossUrl' => 'https://ossimg.tashanedc.com',
					'bigTurntableLink' => null,
					'telegramExternalLink' => 'https://t.me/tashanwinbot',
					'isOpenActivityAward' => true,
					'isOpenTurntable' => true,
					'isPartnerReward' => false,
					'isSelfCustomerService' => true,
					'webSiteUrl' => 'http://www.tashanwin.ink',
					'isOpenFacebookEvent' => false,
					'firstDepositRewardCodeAmount' => '1',
					'isOpenRegisterPhoneFirstZeroSwitch' => false,
					'eventRegionConfigList' => null,
					'isOpenAdjustEvent' => false
				];

				$res['data'] = $data;
				$res['code'] = 0;
				$res['msg'] = 'Succeed';
				$res['msgCode'] = 0;
				http_response_code(200);
			} else {
				$res['code'] = 5;
				$res['msg'] = 'Wrong signature';
				$res['msgCode'] = 3;
				http_response_code(200);
			}
		} else {
			$res['code'] = 7;
			$res['msg'] = 'Param is Invalid';
			$res['msgCode'] = 6;
			http_response_code(200);
		}
	} else {
		http_response_code(405);
	}
	echo json_encode($res);
?>
