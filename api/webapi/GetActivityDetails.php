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
		if (isset($shonupost['bannerId']) && isset($shonupost['language']) && isset($shonupost['random']) && isset($shonupost['signature']) && isset($shonupost['timestamp'])) {
			$bannerId = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['bannerId']));
			$language = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['language']));
			$random = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['random']));
			$signature = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['signature']));
			$shonustr = '{"bannerId":'.$bannerId.',"language":'.$language.',"random":"'.$random.'"}';
			$shonusign = strtoupper(md5($shonustr));
			if($shonusign == $signature){
				$bearer = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
				$author = $bearer[1];				
				$is_jwt_valid = is_jwt_valid($author);
				$data_auth = json_decode($is_jwt_valid, 1);
				if($data_auth['status'] === 'Success') {
					$sesquery = "SELECT akshinak
					  FROM shonu_subjects
					  WHERE akshinak = '$author'";
					$sesresult=$conn->query($sesquery);
					$sesnum = mysqli_num_rows($sesresult);
					if($sesnum == 1){
						if($bannerId == 71){
							$data['title'] = 'Member Recharge Benefits';
							$data['img'] = '[{"Id":"17225024498060d979egil58","Url":"https://pub-628304d7b25d454abf303bfafba6a2e0.r2.dev/ALADDINN/banner/rechargebenifet.png"}]';
							$data['coverUrl'] = 'https://pub-628304d7b25d454abf303bfafba6a2e0.r2.dev/ALADDINN/banner/rechargebenifetposter.png';
							$data['jumpType'] = 3;
						}
						else if($bannerId == 53){
							$data['title'] = "Win Streak\t";
							$data['img'] = '<h3 style="text-align: center; color: #000000;"><strong>Bonus Rules</strong></h3><div style="text-align: center;"><img src="https://pub-628304d7b25d454abf303bfafba6a2e0.r2.dev/ALADDINN/banner/win545.jpg" alt="Bonus Image" style="width: 100%; max-width: 1080px; border-radius: 8px;"></div><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong>1. Minimum Bet Amount:</strong> ₹10</h4><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong>2. Win Streak:</strong> The win streak should continue without any period skipped.</h4><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong>3. Applicable Game:</strong> This bonus is only available on <strong>WINGO</strong>!</h4><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong>4. Contact Your Tutor:</strong> To claim the bonus, please reach out to your Tutor.</h4>';
                          $data['coverUrl'] = 'https://pub-628304d7b25d454abf303bfafba6a2e0.r2.dev/ALADDINN/banner/Banner_2024051416542strake.jpg';
						  $data['jumpType'] = 1;
						}
                      	else if($bannerId == 69){
							$data['title'] = "Join Telegram\t";
							$data['img'] = '<h3 style="text-align: center; color: #000000;"></h3><div style="text-align: center;"></div><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong> Bonus is waiting for you, join our telegram channel and get the bonus. </strong></h4><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong> To join our official Telegram channel, click on the link given below.</strong> </h4><h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 14px; color: #ffcc00;"><strong> <a style="color:#5a5af1;" href="https://t.me/Sikkim3 Game">
								
								https://t.me/Sikkim3 Game
								</a>
								</strong> </h4>';
                          $data['coverUrl'] = 'http://127.0.0.1:8080/edited/Banner_20240514165423daily.jpg';
						  $data['jumpType'] = 1;
						}
						else if($bannerId == 55){
							$data['title'] = 'Download theTASHANWIN app to share 100000000RS red envelope';
							$data['img'] = '<p><font style=""><font color="#ff9c00" style="font-weight: bold;">🎉🎉🎉</font><b style=""><font color="#ff9c00">Join the official channel now and share a </font><font color="#ff0000">100,000,000rs</font><font color="#ff9c00"> rupee bonus🧧🧧🧧</font></b><br></font></p><p><font style=""><b style=""><br></b><b><font color="#ff9c00">🧧🧧🧧</font></b><b style=""><font color="#ff9c00">👉👉</font><a href="https://t.me/TaShanGAMEWIN" target="_blank" style=""><font color="#0000ff">https://t.me/TaShanGAMEWIN</font></a><font color="#ff9c00">👈👈</font></b></font><b style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;"><font color="#ff9c00">🧧🧧🧧</font></b></p><p><font style=""><b style=""><font color="#ff9c00" style=""><br></font></b></font><img src="https://ossimg.tashanedc.com/Tashanwin/editor/editor_20250417170955c3lq.png" style="width: 810px;"><br></p>';
							$data['coverUrl'] = 'https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250417171000vues.png';
							$data['jumpType'] = 1;
						}
						else if($bannerId == 36){
							$data['title'] = "WELCOME TO TASHANWIN GAMES";
							$data['img'] = '[{"Id":"1744269124839k3cior8elcf","Url":"https://ossimg.tashanedc.com/Tashanwin/banner/Active_20250411141013mg9m.png"}]';
                            $data['coverUrl'] = 'https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250411141013fsd6.png';
							$data['jumpType'] = 3;
						}
						else if($bannerId == 44){
							$data['title'] = "Daily sign-in recharge reward";
                            $data['img'] = '[{"Id":"1744360913477z1wje5nerub","Url":"https://ossimg.tashanedc.com/Tashanwin/banner/Active_20250411141202ee3y.png"}]';
                          
							$data['coverUrl'] = 'https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250411141202mscc.png';
							$data['jumpType'] = 3;
						}
						else if($bannerId == 42){
						$data = [
    "title" => "15-day cumulative recharge reward\t\t",
    "img" => '[{"Id":"1744269450925nmw0elvpsac","Url":"https://ossimg.tashanedc.com/Tashanwin/banner/Active_20250411141130f1g7.png"}]',
    "coverUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_2025041114113062h8.png",
    "jumpType" => 3
];
						}else if($bannerId == 48){
						$data = [
    "title" => "Wingo winning streak reward",
    "img" => '[{"Id":"17445316677327h34j09ugd","Url":"https://ossimg.tashanedc.com/Tashanwin/banner/Active_20250413133757hla4.png"}]',
    "coverUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250413133757y7on.png",
    "jumpType" => 3
];

						}else if($bannerId == 49){
						$data = [
    "title" => "Pilot special challenge",
    "img" => '[{"Id":"174453170159389znps5uq95","Url":"https://ossimg.tashanedc.com/Tashanwin/banner/Active_20250413133835f7we.png"}]',
    "coverUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_202504131338354j4n.png",
    "jumpType" => 3
];

						}else if($bannerId == 50){
						$data = [
    "title" => "CREATIVE VIDEO BONUS",
    "img" => '[{"Id":"1744532150747scjv11zwc7d","Url":"https://ossimg.tashanedc.com/Tashanwin/banner/Active_20250413134610fpsb.png"}]',
    "coverUrl" => "https://ossimg.tashanedc.com/Tashanwin/banner/Banner_20250413134610gas4.png",
    "jumpType" => 3
];
}
						$res['data'] = $data;
						$res['code'] = 0;
						$res['msg'] = 'Succeed';
						$res['msgCode'] = 0;
						http_response_code(200);
						echo json_encode($res);			
					}
				}
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