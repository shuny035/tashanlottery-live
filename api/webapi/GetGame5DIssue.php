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
			$typeId = htmlspecialchars(mysqli_real_escape_string($conn, $shonupost['typeId']));
			$shonustr = '{"language":'.$language.',"random":"'.$random.'","typeId":'.$typeId.'}';
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
						function getOrCreateActive5D($conn, $table, $interval, $prefix) {
							date_default_timezone_set("Asia/Kolkata");
							$now = time();
							$currentDate = date('Ymd');
							$secOfDay = $now % 86400;
							$seq = intval($secOfDay / $interval) + 1;
							$currentPeriodId = $currentDate . $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
							$periodStartSec = $now - ($now % $interval);
							$startTime = date('Y-m-d H:i:s', $periodStartSec);
							$endTime = date('Y-m-d H:i:s', $periodStartSec + $interval);
							$serviceTime = date('Y-m-d H:i:s', $now);
							$q = $conn->query("SELECT atadaaidi FROM `$table` ORDER BY kramasankhye DESC LIMIT 1");
							$row = $q ? mysqli_fetch_array($q) : null;
							if (!$row || $row['atadaaidi'] != $currentPeriodId) {
								$conn->query("INSERT INTO `$table` (`atadaaidi`, `dinankavannuracisi`) VALUES ('$currentPeriodId', '$startTime')");
							}
							return ['issueNumber'=>$currentPeriodId,'startTime'=>$startTime,'endTime'=>$endTime,'serviceTime'=>$serviceTime,'intervalM'=>($interval==30)?0.50:($interval/60)];
						}
						if($typeId == 5){
							$data = getOrCreateActive5D($conn,'gelluonduhogu_aidudi',60,'20001');
						}
						else if($typeId == 6){
							$data = getOrCreateActive5D($conn,'gelluonduhogu_aidudi_drei',180,'20002');
						}
						else if($typeId == 7){
							$data = getOrCreateActive5D($conn,'gelluonduhogu_aidudi_funf',300,'20003');
						}
						else if($typeId == 8){
							$data = getOrCreateActive5D($conn,'gelluonduhogu_aidudi_zehn',30,'20005');
						}
						
						$res['data'] = $data;
						$res['code'] = 0;
						$res['msg'] = 'Succeed';
						$res['msgCode'] = 0;
						http_response_code(200);
						echo json_encode($res);					
					}
					else{
						$res['code'] = 4;
						$res['msg'] = 'No operation permission';
						$res['msgCode'] = 2;
						http_response_code(401);
						echo json_encode($res);
					}					
				}
				else{					
					$res['code'] = 4;
					$res['msg'] = 'No operation permission';
					$res['msgCode'] = 2;
					http_response_code(401);
					echo json_encode($res);					
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