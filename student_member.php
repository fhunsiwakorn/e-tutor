<?php
date_default_timezone_set('Asia/Bangkok');

	require_once('ConfigDB.php');
	include ("ConfigName.php");
	require_once("session.php");
	require_once("class.user.php");
	$auth_user = new USER();
  require_once('function.php');
  $sql_process = new msystem();

	$user_id = $_SESSION['user_session'];
  $user_status=$_SESSION['user_status'];
  $school_id= $_SESSION['school_id'];
	if($user_status != "2")
	{
		header("location:index");
		exit();
	}
	$stmt = $auth_user->runQuery("SELECT user_name,user_prefix,user_firstname,user_lastname,user_tel,user_email,user_date,user_date_start,user_date_end,user_id_card,user_testing_date,user_code FROM user_member_group WHERE user_id=:user_id AND school_id=:school_id");
	$stmt->execute(array(":user_id"=>$user_id,":school_id"=>$school_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  $user_code=$userRow["user_code"];


  
///โรงเรียน
$sct = $connSystem->prepare(
  "SELECT tbl_school.school_name,
  tbl_school.school_path_url,
  tbl_school.number_student,
  tbl_school.v_program,
  tbl_school.comment_update,
  tbl_school.day_update,
  tbl_school.compair_course ,
  tbl_school.school_fanpage,
  tbl_school.school_fanpage_text,
  tbl_school.language_id ,
  tbl_exam_language.language_img ,
  tbl_exam_language.language_name 
  FROM 
  tbl_school ,
  tbl_exam_language
   
   WHERE
   tbl_school.language_id = tbl_exam_language.language_id AND
   tbl_school.school_id = :school_id");
  $sct->execute(array(':school_id'=>$school_id));
  $rowSch = $sct->fetch(PDO::FETCH_ASSOC);
  $name_school=$rowSch["school_name"];
  $URL=$rowSch["school_path_url"];
  $number_student=$rowSch["number_student"];
  $v_program=$rowSch["v_program"];
  $day_update=$rowSch["day_update"];
  $compair_course=$rowSch["compair_course"];
  $language_id=$rowSch["language_id"];
  $language_name=$rowSch["language_name"];
  $language_img=$rowSch["language_img"];
  $school_fanpage=$rowSch["school_fanpage"];
  $school_fanpage_text=$rowSch["school_fanpage_text"];

/////ตัดเวลา
  if(!isset($_GET['cte'])) { 
    unset($_SESSION['timeend']);
// session_destroy(); 
} 

$theme_color="#3F2C73";

    require_once('chek_student.php'); //ตรวจสอบหมดอายุการใช้งาน
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=$name_program?> :: <?=$name_school?></title>
	<link rel="shortcut icon"   type="image/png"  href="<?=$LOGO?>" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="AdminLTE-2.3.6/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
       <link rel="stylesheet" href="AdminLTE-2.3.6/dist/css/skins/skin-green.min.css">
       <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/datatables/dataTables.bootstrap.css">
       <link rel="stylesheet" href="AdminLTE-2.3.6/plugins/select2/select2.min.css">
<link rel="stylesheet" href="AdminLTE-2.3.6/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="AdminLTE-2.3.6/plugins/iCheck/square/blue.css">
  <!-- daterange picker -->
<link rel="stylesheet" href="AdminLTE-2.3.6/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="AdminLTE-2.3.6/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="AdminLTE-2.3.6/dist/css/skins/skin-green.min.css">
<script src="AdminLTE-2.3.6/plugins/select2/select2.full.min.js"></script>
<script src="sweetalert_master/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="sweetalert_master/sweetalert.css">
<link href="chkbox/checkboxes.css" rel="stylesheet">

<link href="font/stylesheet.css" rel="stylesheet">
			<style>
            body {
                font-family: 'js_saowaparknormal', sans-serif;
                font-size: 20px;
            }
						h1 {
                font-family: 'js_saowaparknormal', sans-serif;
            }
						h2 {
                font-family: 'js_saowaparknormal', sans-serif;
            }
						h3 {
                font-family: 'js_saowaparknormal', sans-serif;
            }
						h4 {
                font-family: 'js_saowaparknormal', sans-serif;
            }
            h5 {
                font-family: 'js_saowaparknormal', sans-serif;
            }
        </style>

        <meta http-equiv="refresh" content="600">
     


</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">




<!-- <div class="wrapper" > -->
<div class="" >

  <header class="main-header">

    <nav class="navbar navbar-static-top" style="background-color:<?=$theme_color?>;">
      <div class="container">
        <div class="navbar-header">
          <a href="sdc" class="navbar-brand"><b><?=$name_school?></b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">

            <?php include ("student_member_menu.php"); ?>

          </ul>
          <!-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form> -->
        </div>


        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
					<?php include("accout_profile.php"); ?>
					</li>
					</ul>
				</div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
							<!-- <script language="JavaScript" type="text/javascript">

				function sivamtime() {
				 now=new Date();
				 d=now.getDate();
				 m=now.getMonth() + 1;
				 y=now.getFullYear() + 543;
				 hour=now.getHours();
				 min=now.getMinutes();
				 sec=now.getSeconds();

				if (min<=9) { min="0"+min; }
				if (sec<=9) { sec="0"+sec; }
				if (hour<=9) { hour="0"+hour; }

				time = d + "/" + m + "/" + y + "  " + hour + ":" + min + ":" + sec ;

				if (document.getElementById) { theTime.innerHTML = time; }
				else if (document.layers) {
				document.layers.theTime.document.write(time);
				document.layers.theTime.document.close(); }

				setTimeout("sivamtime()", 1000);
				}
				window.onload = sivamtime;

				// -->

				<!-- </script>  -->



			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span id="theTime"></span>
		</a>
          </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
 
    <div class="">
      <!-- Content Header (Page header) -->
      <!-- <section class="content-header">
        <h1>
        <?=$name_program?>
          <small><?=$name_school?></small>
        </h1>
        <ol class="breadcrumb">
   			 <i class="glyphicon glyphicon-flag"></i> <li class="active">
		<?php $exRowsusertest = $connSystem->query("SELECT count(*) from exam_status_score WHERE user_id='$user_id'")->fetchColumn(); ?>
					<a href="#" >คุณทำข้อสอบไปแล้วทั้งหมด <?=$exRowsusertest?>  ครั้ง</a></li>

   		 </ol>
      </section> -->

      <!-- Main content -->
      <section class="content">

        <?php
		 $examstart='50';  //จำนวนข้อสอบที่ต้องทำ
     if(!isset($_GET["option"])){
     include ("student_member_page_1_home.php");
     }else{
     switch($_GET['option']) {
     case "exam-main" : include ("student_member_page_2_exam_main.php");
     break;
		 case "history" : include ("student_member_page_6_history.php");
		 break;
		 case "chart-history" : include ("student_member_page_7_chart_report.php");
		 break;
		 case "profile" : include ("student_member_page_8_profile.php");
		break;
		 default : include ("student_member_page_1_home.php");
     	}
     }

     ?>

        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  
  
</div>
<!-- ./wrapper -->
<?php
// close connection
$connSystem = null;
?>
<!-- jQuery 2.2.3 -->

<script src="AdminLTE-2.3.6/plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="AdminLTE-2.3.6/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE-2.3.6/dist/js/app.min.js"></script>
<script src="AdminLTE-2.3.6/plugins/select2/select2.full.min.js"></script>
<script src="AdminLTE-2.3.6/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="AdminLTE-2.3.6/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- iCheck -->
<script src="AdminLTE-2.3.6/plugins/iCheck/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>


<script src="AdminLTE-2.3.6/plugins/input-mask/jquery.inputmask.js"></script>
<script src="AdminLTE-2.3.6/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="AdminLTE-2.3.6/plugins/input-mask/jquery.inputmask.extensions.js"></script>


     <!-- page script -->
     
     <script>
      $(document).ready(function(){
      $("#popfanpage").modal('show');
     }
     )

     $(document).ready(function(){
      $("#Show_Score").modal('show');
     }
     )

     $(document).ready(function(){
      // $("#recommend").modal('show');
      $("#recommend").modal({backdrop: "static"});
     }
     )

     $(document).ready(function(){
      // $("#recommend").modal('show');
      $("#navigate").modal({backdrop: "static"});
     }
     )

       $(function () {
    
      $(".select2").select2();
      $("#example1").DataTable();
     	$("#example2").DataTable();
     	$("#example3").DataTable();
      $("#example4").DataTable();
			$('#example5').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": false,
				"info": true,
				"autoWidth": false
				 });
$("[data-mask]").inputmask();
 });


     </script>




</body>
</html>
