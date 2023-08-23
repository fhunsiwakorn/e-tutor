<?php
date_default_timezone_set('Asia/Bangkok');
$option = isset($_GET['option']) ? $_GET['option'] : NULL; 

	include ("ConfigName.php");
	require_once("session.php");
	require_once("class.user.php");
	$auth_user = new USER();

 $school_id= $_SESSION['school_id'];
	$user_id = $_SESSION['user_session'];
	$user_status=$_SESSION['user_status'];
	if($user_status != "1")
	{
		header("location:index");
		exit();
	}
	$stmt = $auth_user->runQuery("SELECT user_name,user_prefix,user_firstname,user_lastname,user_tel,user_email,user_date,user_date_start,user_date_end FROM user_member_group WHERE user_id=:user_id AND school_id=:school_id");
	$stmt->execute(array(":user_id"=>$user_id,":school_id"=>$school_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

require_once('ConfigDB.php');
require_once('function.php');
$sql_process = new msystem();

///โรงเรียน
$sct = $connSystem->prepare(
"SELECT tbl_school.school_name,
tbl_school.school_path_url,
tbl_school.number_student,
tbl_school.v_program,
tbl_school.comment_update,
tbl_school.day_update,
tbl_school.compair_course ,
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
$theme_color="#3F2C73";

 
require_once('chek_student.php'); //ตรวจสอบหมดอายุการใช้งาน
///เปลี่ยนภาษา
if(isset($_GET['setlanguage']) && !empty($_GET['setlanguage'])){
	$language_id=strip_tags($_GET['setlanguage']);
	$sql_process->fastQuery("UPDATE tbl_school SET language_id='$language_id'   WHERE school_id='$school_id'");
	// echo "<script>";
	// echo "location.href = 'dashboard?option=$option&success'";
	// echo "</script>";
	header('Location: '.$_SERVER['HTTP_REFERER']);
}





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

<link href="subpage_css/subpage.css" rel="stylesheet">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">

<div class="wrapper">

  <header class="main-header">

    <nav class="navbar navbar-static-top" style="background-color:<?=$theme_color?>;">
      <div class="container">
        <div class="navbar-header">
          <a href="dashboard" class="navbar-brand"><b><?=$name_school?></b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">

            <?php include ("dashboard_menu.php"); ?>

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
			<!-- <span id="theTime"></span> -->
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
        <?=$name_program?> <?=$name_school?>
          <!-- <small><?=$name_school?></small> -->
        </h1>
        <ol class="breadcrumb">
				<i class="glyphicon glyphicon-home"></i> 
				<li class="active"> <a href="dashboard" ><?=$sql_process->mf("YJU8CTYQLDLYLTWVRNZ",$language_id);?></a></li>
				<li>
				<div class="btn-group">
                  <button type="button" class="btn btn-default">
				  <img id="myImg"  src="<?=$language_img?>" alt="<?=$language_name?>" width="20" height="15">	  <?=$language_name?></button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
				  <?php
  
$sttu = $connSystem->prepare("SELECT
tbl_exam_language.language_name,
tbl_exam_language.language_img,
tbl_exam_language.language_id
FROM
tbl_exam_language ,
tbl_system_language
WHERE
tbl_exam_language.language_id = tbl_system_language.language_id 
GROUP BY
tbl_system_language.language_id
ORDER BY
tbl_exam_language.language_id ASC
");
$sttu->execute();
while($rowStu = $sttu->fetch(PDO::FETCH_ASSOC)) {

?>
					<li><a href="dashboard?option=<?=$option?>&setlanguage=<?=$rowStu['language_id']?>">
					<img id="myImg"  src="<?=$rowStu['language_img']?>" alt="<?=$rowStu['language_name']?>" width="20" height="15">
					<?=$rowStu['language_name']?>
				</a>
			</li>
<?php } ?>          
                  </ul>
				</div>
		
				</li>

   		 </ol>
      </section>
	  <br>
      <!-- Main content -->
      <section class="content">
        <?php
			 $examstart='50';  //จำนวนข้อสอบที่ต้องทำ
     if(!isset($_GET["option"])){
     include ("dashboard_page_1_home.php");
     }else{
     switch($_GET['option']) {
     case "exam-course" : include ("dashboard_page_2_exam.php");
     break;
		 case "exam-data" : include ("dashboard_page_3_exam_data.php");
		 break;
		 case "student-data" : include ("dashboard_page_4_student_data.php");
		 break;
		 case "student-edit" : include ("dashboard_page_5_student_edit.php");
		 break;
		 case "report" : include ("dashboard_page_6_report_list.php");
		 break;
		 case "report-chart" : include ("dashboard_page_7_report_chart.php");
		 break;
		 case "student-report-chart" : include ("dashboard_page_11_student_list_report.php");
		 break;
		 case "student-renew" : include ("dashboard_page_12_student_renew.php");
		 break;
		 default : include ("dashboard_page_1_home.php");
     	}
     }

     ?>
		 <!-- <?php
$estam=strtotime(date("Y-m-d"));
$dschool=strtotime($day_update);
if($dschool<=$estam){
		  ?>
		 <div class="alert alert-success alert-dismissible">
 								 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 								 <h4><i class="icon fa fa-check"></i> รายงานการอัพเดทซอฟต์แวร์</h4>
 								<?php echo $rowSch["comment_update"];?>
 		</div>
	<?php } ?> -->
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
 <?php // include("footer.php");?>

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
