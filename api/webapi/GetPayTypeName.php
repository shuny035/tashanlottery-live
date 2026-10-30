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
		'code' => 0,
		'msg' => 'Succeed',
		'msgCode' => 0,
		'serviceNowTime' => $shnunc,
		'data' => [
			'typelist' => [
				[
					'payID' => 1,
					'payTypeID' => 0,
					'payName' => 'QR Pay',
					'paySysName' => 'QR Pay',
					'payNameUrl' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon_20250409210555mter.jpg',
					'payNameUrl2' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon2_20250409210555p8y3.jpg',
					'minPrice' => 100,
					'maxPrice' => 50000,
					'scope' => '100|200|500|1000|5000|10000|50000',
					'typeName' => 'QR Pay',
					'typeNameCode' => 0,
					'maxRechargeRifts' => 0,
					'sort' => 30
				],
				[
					'payID' => 2,
					'payTypeID' => 0,
					'payName' => 'Online Pay',
					'paySysName' => 'Online Pay',
					'payNameUrl' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon_202504092106459cv6.jpg',
					'payNameUrl2' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon2_20250409210645nitk.jpg',
					'minPrice' => 100,
					'maxPrice' => 50000,
					'scope' => '100|200|500|1000|5000|10000|50000',
					'typeName' => 'Online Pay',
					'typeNameCode' => 0,
					'maxRechargeRifts' => 0,
					'sort' => 28
				],
				[
					'payID' => 27,
					'payTypeID' => 0,
					'payName' => 'Now UPI',
					'paySysName' => 'Now UPI',
					'payNameUrl' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon_202504111358165xj7.jpg',
					'payNameUrl2' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon2_20250411135816yq65.jpg',
					'minPrice' => 100,
					'maxPrice' => 50000,
					'scope' => '100|200|500|1000|5000|10000|50000',
					'typeName' => 'Now UPI',
					'typeNameCode' => 0,
					'maxRechargeRifts' => 0,
					'sort' => 27
				],
				[
					'payID' => 11,
					'payTypeID' => 0,
					'payName' => 'USDT',
					'paySysName' => 'USDT',
					'payNameUrl' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon_202504111358463w2c.jpg',
					'payNameUrl2' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon2_202504111358465sjf.jpg',
					'minPrice' => 100,
					'maxPrice' => 50000,
					'scope' => '100|200|500|1000|5000|10000|50000',
					'typeName' => 'USDT',
					'typeNameCode' => 9205,
					'maxRechargeRifts' => 0,
					'sort' => 24
				],
				[
					'payID' => 16,
					'payTypeID' => 0,
					'payName' => 'TRX',
					'paySysName' => 'TRX',
					'payNameUrl' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon_20250409210935key1.jpg',
					'payNameUrl2' => 'https://ossimg.tashanedc.com/Tashanwin/payNameIcon/payNameIcon2_202504092109352qup.jpg',
					'minPrice' => 100,
					'maxPrice' => 50000,
					'scope' => '100|200|500|1000|5000|10000|50000',
					'typeName' => 'TRX',
					'typeNameCode' => 9213,
					'maxRechargeRifts' => 0,
					'sort' => 20
				]
			]
		]
	];

	http_response_code(200);
	echo json_encode($res);
?>
