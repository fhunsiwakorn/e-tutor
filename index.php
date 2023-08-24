<?php
session_start();
include("ConfigName.php");
require_once("class.user.php");
$login = new USER();
if (isset($_POST['btn-login'])) {
	$uname = strip_tags($_POST['txt_uname_email']);
	$umail = strip_tags($_POST['txt_uname_email']);
	$upass = strip_tags($_POST['txt_password']);

	if ($login->doLogin($uname, $umail, $upass)) {
		if ($_SESSION['user_status'] == '1') {   ///ถ้าสำหรับเจ้าหน้าที่
			$login->redirect('dashboard.php');
		} elseif ($_SESSION['user_status'] == '2') {  ///ถ้าสำหรับนักเรียน
			$login->redirect('student_member.php?pop');
		}
	} else {
		$error = "Wrong Details !";
	}
}

require_once('ConfigDB.php');
require_once('chek_student.php'); //ตรวจสอบหมดอายุการใช้งาน
// ///โรงเรียน
// $sct = $connSystem->prepare("SELECT school_name,school_path_url FROM tbl_school  WHERE school_id = :school_id");
// $sct->execute(array(':school_id' => $school_id));
// $rowSch = $sct->fetch(PDO::FETCH_ASSOC);
// $name_school = @$rowSch["school_name"];
// $URL = @$rowSch["school_path_url"];


?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="E-Tutor  ระบบติวสอนขับรถ ระบบติวสอนขับรถออนไลน์">
	<meta name="keywords" content="E-Tutor  ,ระบบติวสอนขับรถ,ระบบติวสอนขับรถออนไลน์,ผู้พัฒนา ศิวกร บรรลือทรัพย์" />

	<!-- CSS -->

	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/form-elements.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<title>E-Tutor </title>
	<link rel="shortcut icon" type="image/png" href="<?= $LOGO ?>" />
	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<style>
		body {
			font-family: 'Kanit', sans-serif;
		}

		h1 {
			font-family: 'Kanit', sans-serif;
		}

		h2 {
			font-family: 'Kanit', sans-serif;
		}

		h3 {
			font-family: 'Kanit', sans-serif;
		}

		h4 {
			font-family: 'Kanit', sans-serif;
		}

		div {
			font-family: 'Kanit', sans-serif;
		}

		label {
			font-family: 'Kanit', sans-serif;
		}
	</style>
	<script src="sweetalert_master/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="sweetalert_master/sweetalert.css">
</head>

<body>

	<!-- Top content -->
	<div class="top-content">

		<div class="inner-bg">
			<div class="container">

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 form-box">
						<div class="form-top">
							<div class="form-top-left">
								<h3>Sign in</h3>
								<p><?= $name_program ?></p>
							</div>
							<div class="form-top-right">
								<i class="fa fa-lock"></i>
							</div>
						</div>
						<div class="form-bottom">
							<div id="error">
								<?php
								if (isset($error)) {
								?>
									<script>
										swal("Username และ Password  ไม่ถูกต้อง !", "ปิดหน้าต่างนี้ !", "error");
									</script>
									<!-- <div class="alert alert-danger">
																				 <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
																			</div> -->
								<?php } ?>
							</div>

							<form class="form-signin" method="post" id="login-form">
								<div class="form-group">
									<label class="sr-only" for="form-username">Username</label>
									<input type="text" name="txt_uname_email" placeholder="Username..." class="form-username form-control" id="form-username" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label class="sr-only" for="form-password">Password</label>
									<input type="password" name="txt_password" placeholder="Password..." class="form-password form-control" id="form-password" autocomplete="off" required>
								</div>
								<button type="submit" name="btn-login" class="btn">Sign in!</button>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
	<?php
	// close connection
	$connSystem = null;
	?>

	<!-- Javascript -->
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.backstretch.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

</body>

</html>