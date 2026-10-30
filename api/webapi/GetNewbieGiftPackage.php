<?php 
	date_default_timezone_set("Asia/Kolkata");
	$shnunc = date("Y-m-d H:i:s");

	$response = [
		"data" => [
			"id" => 0,
			"title" => "Newbie Gift Pack",
			"description" => "Newbie Gift Pack",
			"amount" => 50,
			"status" => 0,
			"receivedNumber" => 0,
			"totalNumber" => 5
		],
		"code" => 0,
		"msg" => "Succeed",
		"msgCode" => 0,
		"serviceNowTime" => $shnunc
	];

	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($response);
?>
