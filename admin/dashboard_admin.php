<?php
date_default_timezone_set('Asia/Bangkok');

include ("ConfigName.php");
	require_once("session.php");
	require_once("class.user.php");
	$auth_user = new USER();


	$user_id = $_SESSION['user_session'];
	$user_status=$_SESSION['user_status'];
	if($user_status != "3")
	{
		header("location:index");
		exit();
	}
	$stmt = $auth_user->runQuery("SELECT user_name,user_prefix,user_firstname,user_lastname FROM user_member_group WHERE user_id=:user_id ");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	////////////////
	function DateThai($strDate)
	{
	  $strYear = date("Y",strtotime($strDate))+543;
	  $strMonth= date("n",strtotime($strDate));
	  $strDay= date("j",strtotime($strDate));
	  $strHour= date("H",strtotime($strDate));
	  $strMinute= date("i",strtotime($strDate));
	  $strSeconds= date("s",strtotime($strDate));
	  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	  $strMonthThai=$strMonthCut[$strMonth];
	  return "$strDay $strMonthThai $strYear";
	}

require_once('ConfigDB.php');

$theme_color="#3F2C73";

   ////////random ///////////
   function random_password($max_length = 10){
	$text = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$text_length = mb_strlen($text, 'UTF-8');
	$pass = '';
	for($i=0;$i<$max_length;$i++){
	$pass .= @$text[rand(0, $text_length)];
	}
	return $pass;
	}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=$title?></title>
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<!-- <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet"> -->
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

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">

<div class="wrapper">


  <header class="main-header">

    <nav class="navbar navbar-static-top" style="background-color:<?=$theme_color?>;">
      <div class="container">
        <div class="navbar-header">
          <a href="dashboard_admin" class="navbar-brand"><b><?=$name_school?> </b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">

            <?php include ("dashboard_admin_menu.php"); ?>

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
							<script language="JavaScript" type="text/javascript">

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

				</script>



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
      <!-- <div class="container"> -->
			<div class="">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        <?=$name_program?>
          <small><?=$name_school?></small>
        </h1>
        <ol class="breadcrumb">
   			 <i class="glyphicon glyphicon-home"></i> <li class="active">
					<a href="dashboard_admin" title="หน้าหลัก">หน้าหลัก</a></li>

   		 </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <?php
			 $examstart='50';  //จำนวนข้อสอบที่ต้องทำ
     if(!isset($_GET["option"])){
     include ("dashboard_admin_page_1_home.php");
     }else{
     switch($_GET['option']) {
     case "school-data" : include ("dashboard_admin_page_2_school.php");
     break;
		 case "school-edit" : include ("dashboard_admin_page_3_school_edit.php");
		 break;
		 case "course" : include ("dashboard_admin_page_4_course_data.php");
		 break;
		 case "exam-co-edit" : include ("dashboard_admin_page_5_course_edit.php");
		 break;
		 case "exam-data" : include ("dashboard_admin_page_6_exam_data.php");
		 break;
		 case "exam-data-edit" : include ("dashboard_admin_page_7_exam_data_edit.php");
		 break;
		 case "student-data" : include ("dashboard_admin_page_8_student_data.php");
		 break;
		 case "authorities-data" : include ("dashboard_admin_page_9_authorities_data.php");
		 break;
		 case "authorities-edit" : include ("dashboard_admin_page_10_authorities_edit.php");
		 break;
		 case "exam_language" : include ("dashboard_admin_page_12_exam_language.php");
		 break;
		 case "exam-language-edit" : include ("dashboard_admin_page_12_exam_language_edit.php");
		 break;
		 case "setting_language_systems" : include ("dashboard_admin_page_13_setting_language_systems.php");
		 break;
		 case "setting_language_systems_edit" : include ("dashboard_admin_page_13_setting_language_systems_edit.php");
		 break;
		 case "titlename" : include ("dashboard_admin_page_14_titlename.php");
		 break;
		 case "titlename-edit" : include ("dashboard_admin_page_14_titlename_edit.php");
		 break;
		 default : include ("dashboard_admin_page_1_home.php");
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
         $('#example6').DataTable({
				"paging": false,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": false,
				"autoWidth": false
				 });  
$("[data-mask]").inputmask();
 });


     </script>

</body>
</html>
