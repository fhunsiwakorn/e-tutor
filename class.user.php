<?php

require_once('ConfigDB_2.php');

class USER
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function register($user_name, $user_password, $user_prefix, $user_firstname, $user_lastname, $user_id_card, $user_tel, $user_email, $user_date, $user_date_start, $user_date_end, $user_testing_date, $user_date_status, $school_id, $compair_course)
	{
		try {

			$passHash = password_hash($user_password, PASSWORD_DEFAULT);
			$qcout = $this->conn->prepare("SELECT user_id,user_code  FROM user_member_group WHERE user_name=:user_name");
			$qcout->execute(array(":user_name" => $user_name));
			$data = $qcout->fetch(PDO::FETCH_ASSOC);
			$user_code = !empty($data["user_code"]) ? $data["user_code"] :  time() . mt_rand();
			$total_data = $qcout->rowCount();
			$user_status = 2;

			// $compair_course = $userMethod->single_fild("compair_course", "tbl_school", "school_code", $data->school_code); ///รหัสชุดข้อสอบภายในโรงเรียน

			///เพิ่มนักเรียน	
			if ($total_data <= 0) {
				$stmt = $this->conn->prepare("INSERT INTO user_member_group(user_name,user_password,user_password_2,user_prefix,user_firstname,user_lastname,user_id_card,user_tel,user_email,user_date,user_date_start,user_date_end,user_testing_date,user_date_status,school_id,user_status,user_code)
			VALUES (:user_name, :user_password,:user_password_2,:user_prefix,:user_firstname,:user_lastname,:user_id_card,:user_tel,:user_email,:user_date,:user_date_start,:user_date_end,:user_testing_date,:user_date_status,:school_id,:user_status,:user_code)");
			} else {
				$stmt = $this->conn->prepare("UPDATE user_member_group SET
				user_password=:user_password,
				user_password_2=:user_password_2,
				user_prefix=:user_prefix,
				user_firstname=:user_firstname,
				user_lastname=:user_lastname,
				user_id_card=:user_id_card,
				user_tel=:user_tel,
				user_email=:user_email,
				user_date=:user_date,
				user_date_start=:user_date_start,
				user_date_end=:user_date_end,
				user_testing_date=:user_testing_date,
				user_date_status=:user_date_status,
				school_id=:school_id,
				user_status=:user_status,
				user_code=:user_code
				WHERE user_name=:user_name");
			}

			$stmt->bindparam(":user_name", $user_name);
			$stmt->bindparam(":user_password", $passHash);
			$stmt->bindparam(":user_password_2", $user_password);
			$stmt->bindparam(":user_prefix", $user_prefix);
			$stmt->bindparam(":user_firstname", $user_firstname);
			$stmt->bindparam(":user_lastname", $user_lastname);
			$stmt->bindparam(":user_id_card", $user_id_card);
			$stmt->bindparam(":user_tel", $user_tel);
			$stmt->bindparam(":user_email", $user_email);
			$stmt->bindparam(":user_date", $user_date);
			$stmt->bindparam(":user_date_start", $user_date_start);
			$stmt->bindparam(":user_date_end", $user_date_end);
			$stmt->bindparam(":user_testing_date", $user_testing_date);
			$stmt->bindparam(":user_date_status", $user_date_status);
			$stmt->bindparam(":school_id", $school_id);
			$stmt->bindparam(":user_status", $user_status);
			$stmt->bindparam(":user_code", $user_code);
			$stmt->execute();

			/////กำหนดสิทธิ์สอบ

			$sth = $this->conn->prepare("DELETE FROM exam_permission  WHERE user_code=:user_code");
			$sth->execute(array(':user_code' => $user_code));

			$stmt2 = $this->conn->prepare(
				"SELECT exam_type.type_id
			FROM
			tbl_permission_course ,
			exam_type ,
			tbl_exam_language
			WHERE
			exam_type.type_id = tbl_permission_course.type_id AND
			exam_type.language_id =tbl_exam_language.language_id AND
			tbl_permission_course.compair_course =:compair_course AND
			(exam_type.type_group_id = '100'  OR exam_type.type_group_id = '200' ) AND
			tbl_exam_language.language_code ='TH' AND
			exam_type.type_status='1' LIMIT 0,3"
			);
			$stmt2->execute(array("compair_course" => $compair_course));
			while ($dataType = $stmt2->fetch(PDO::FETCH_ASSOC)) {

				$query = 'INSERT INTO exam_permission(type_id,user_code,school_id)
						VALUES (:type_id,:user_code,:school_id)';
				$sthc = $this->conn->prepare($query);
				$sthc->execute(
					array(
						':type_id' => $dataType['type_id'],
						':user_code' => $user_code,
						':school_id' => $school_id
					)
				);
			}

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function sendScoreToDMS($st_idcard, $score, $score_date, $url)
	{

		$ipaddress = $_SERVER['REMOTE_ADDR']; //Get user IP 
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$dataset = array(
			"st_idcard" => $st_idcard,
			"score" => $score,
			"ip_address" => $ipaddress,
			"user_agent" => $user_agent,
			"tr_crt_date" => $score_date,
		);
		$jsonData = json_encode($dataset);
		$curl = curl_init();
		$linkDMS = $url . "interface/?Command=saveScoreFromEtuter";
		curl_setopt_array($curl, array(
			CURLOPT_URL => $linkDMS,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $jsonData,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'apikey: 6AuC5VMQMBn4jfU5D6nzXLYCfQ2D2y',
				'Cookie: PHPSESSID=nua14rbv8gdokqn7sd26e7g0vb'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// echo $response;

		return $response;
	}

	public function doLogin($uname, $umail, $upass)
	{
		try {
			///include ('ConfigName.php');
			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_password,user_date_status,school_id,user_status FROM user_member_group WHERE user_name=:uname AND user_date_status=:user_date_status ");
			$stmt->execute(array(':uname' => $uname, ':user_date_status' => 1));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() == 1) {
				if (password_verify($upass, $userRow['user_password'])) {

					$_SESSION['user_session'] = $userRow['user_id'];
					$_SESSION['user_status'] = $userRow['user_status'];
					$_SESSION['school_id'] = $userRow['school_id'];
					$_SESSION['user_date_status'] = $userRow['user_date_status'];
					return true;
				} else {
					return false;
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function is_loggedin()
	{
		if (isset($_SESSION['user_session'])) {
			return true;
		}
	}

	public function redirect($url)
	{
		// header("Location: $url");
		die('<script type="text/javascript">window.location=\'' . $url . '\';</script‌​>');
	}

	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}

	//แสดงรายการที่ต้องการโดยมีเงื่อนไขเดียว
	public function single_fild($Field, $table, $Where, $Value)
	{
		$stmt = $this->conn->prepare("SELECT $Field FROM $table WHERE $Where=:val");
		// $stmt->execute();
		$stmt->execute(array(":val" => $Value));
		$dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$dataRow) {
			return false;
		} else {
			return $dataRow[$Field];
		}
	}
}
