<?php

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




	public function doLogin($username, $password)
	{
		try {

			$stmt = $this->conn->prepare("SELECT
tbl_user.user_id,
tbl_user.user_password,
tbl_user.user_status
FROM 
tbl_user
WHERE
tbl_user.user_name=:user_name_login AND tbl_user.cancelled='1'");
			$stmt->execute(array(':user_name_login' => $username));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (password_verify($password, $row['user_password']) && $stmt->rowCount() == 1) {
				// $_SESSION['userSession'] = $row['user_id'];
				// $_SESSION['user_status'] = $row['user_status'];
				setcookie("user_id", $row["user_id"], time() + 86400 * 7); // 604800 = 1 week
				setcookie("user_status", $row["user_status"], time() + 86400 * 7); // 604800 = 1 week
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function is_loggedin()
	{
		if (!empty($_COOKIE['user_id'])) {
			return true;
		}
	}

	public function redirect($url)
	{
		header("Location: $url");
	}

	public function doLogout()
	{
		// 	if(isset($_COOKIE['user_id'])):
		// session_start();
		setcookie("user_id", 0, time() - 7000000);
		setcookie("user_status", 0, time() - 7000000);
		// endif;

		// Finally, destroy the session.
		//  session_destroy();

		// return true;
	}
}
