<?php
date_default_timezone_set('Asia/Bangkok');

	require_once('ConfigDB.php');




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
//// คำนวนหาระยะห่างวัน
function DateDiff($strDate1,$strDate2)
{
     return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}
function TimeDiff($strTime1,$strTime2)
{
     return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1,$strDateTime2)
{
     return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
    ///โรงเรียน
    $school_code=isset($_GET['school_code']) ? $_GET['school_code'] : NULL;
    $type_id_search = isset($_GET['type_id']) ? $_GET['type_id'] : NULL;
	$sct = $connSystem->prepare(
	"SELECT
     tbl_school.school_id, 
    tbl_school.school_name,
    tbl_school.school_name,
	tbl_school.school_path_url,
	tbl_school.number_student,
	tbl_school.v_program,
	tbl_school.comment_update,
	tbl_school.day_update,
	tbl_school.compair_course FROM tbl_school  WHERE school_code = :school_code");
	$sct->execute(array(':school_code'=>$school_code));
    $rowSch = $sct->fetch(PDO::FETCH_ASSOC);
    $school_id=$rowSch["school_id"];
	$name_school=$rowSch["school_name"];
	$URL=$rowSch["school_path_url"];
	$number_student=$rowSch["number_student"];
	$v_program=$rowSch["v_program"];
	$day_update=$rowSch["day_update"];
  $compair_course=$rowSch["compair_course"];
  
  $examstart=50;
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
            h5 {
                font-family: 'Kanit', sans-serif;
            }
        </style>

        <meta http-equiv="refresh" content="600">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<!-- <body class="hold-transition skin-green layout-top-nav"> -->
<body>

<div class="row">


<div class="col-xs-12">
<?php
$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['C']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);

$stu = $connSystem->prepare("SELECT user_firstname,user_lastname,user_id_card,user_testing_date FROM user_member_group  WHERE user_id = :user_id_param AND school_id=:school_id");
$stu->execute(array(':user_id_param'=>$_GET['us'],':school_id'=>$school_id));
$rowStu = $stu->fetch(PDO::FETCH_ASSOC);

function DateThai_2($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
	}
 ?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">รายงานประวัติและกราฟการสอบหลักสูตร : <?php echo $rowEXType['type_name'];?> | ผู้สอบ : <?php echo $rowStu['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowStu['user_lastname'];?></h3>
  
    <div class="box-tools pull-right">
      <div class="btn-group">
   
      <button type="button"  class="btn btn-default" onclick="window.location.href='report_public.php?type_id=<?=$_GET['C']?>&school_code=<?=$school_code?>'" data-toggle="tooltip" title="กราฟแสดงรายงานจำนวนนักเรียนต่อเดือน">
     กลับไปยังหน้าก่อน
      </button>
     
      </div>
    </div>


  </div>


  <div class="box-body">
<!-- Chart -->
    <div class="box-body chart-responsive">
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="chart_div" ></div>
    </div>

<!-- ประวัติการสอบ -->
<table id="example5" class="table table-bordered table-striped">
  <thead>
  <tr >
		<th>ครั้งที่</th>
		<th>วันที่ทำข้อสอบ</th>
		<th>แถบวัดคะแนน (100%)</th>
		<th>เฉลี่ย (100%)</th>
		<th>คะแนนที่ได้ (50)</th>
  </tr>
  </thead>
  <tbody>
     <?php

     $hist = $connSystem->prepare("SELECT score_total,score_date FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param  ORDER BY score_id DESC");
     $hist->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
     $rec = $connSystem->query("SELECT count(*) from exam_status_score WHERE user_id = '".$_GET['us']."' AND type_id= '".$_GET['C']."'")->fetchColumn();
     $a='0';
     $number=$rec+1;
     while($rowHis = $hist->fetch(PDO::FETCH_ASSOC))
    {
$a++;

$percen=($rowHis['score_total']/$examstart)*100;
?>
  <tr>
    <td><center><?php echo  $number-$a;	?></center></td>
    <td><?php $strDate = $rowHis['score_date']; echo DateThai_2($strDate);?></td>
		<td>
			<div class="progress progress-xs progress-striped active">
			<div class="progress-bar progress-bar-success" style="width: <?=$percen?>%"></div>
			</div>

		</td>
		<td align="center"><?=$percen?> %</td>
	  <td  align="center">
  <?php echo $rowHis['score_total']; ?>
    </td>

  </tr>
<?php } ?>
  </tbody>
  <tfoot>
  <tr>
		<th>ครั้งที่</th>
		<th>วันที่ทำข้อสอบ</th>
		<th>แถบวัดคะแนน (100%)</th>
		<th>เฉลี่ย (100%)</th>
		<th>คะแนนที่ได้ (50)</th>
  </tr>
  </tfoot>
</table>


  </div>
  <!-- /.box-body -->
</div>



<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">สรุปผลการสอบ</h3>
  </div>
  <div class="box-body">


<table class="table table-bordered">

  <tr >
	<td>รวมทดสอบ
 <font color="red"> <?php echo $total_test = $connSystem->query("SELECT count(user_id) from exam_status_score WHERE  type_id= '".$_GET['C']."'  AND user_id='".$_GET['us']."' ")->fetchColumn(); ?> </font>
 ครั้ง
   </td>
  <td>
  คะแนนเฉลี่ย 
  <font color="red">
  <?php
$stype2 = $connSystem->prepare("SELECT SUM(score_total) AS score_total FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param ");
$stype2->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
$rowEXType2 = $stype2->fetch(PDO::FETCH_ASSOC);
$average_test=$rowEXType2['score_total']/$total_test;
echo number_format($average_test,2);
  ?>
   </font>
   คะแนน
  </td>
  </tr>

  <tr>
    <td>เหลือเวลา
    <font color="red">
    <?php
    $user_testing_date=$rowStu['user_testing_date'];
    $present_date=date("Y-m-d");
     $CoutDate = DateDiff($present_date,$user_testing_date);
     echo  $CoutDate;
      ?> 
         </font>
         วัน ถึงวันสอบใบอนุญาตขับขี่
  
    </td>

    <td>
    วันที่สอบใบอนุญาตขับขี่ วันที่
    <font color="red"> <?php echo DateThai($user_testing_date);?></font></td>
	

  </tr>


  
</table>


  </div>
  <!-- /.box-body -->
</div>







<script type="text/javascript">
  google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'คะแนน');

      data.addRows([
        <?php
$charts_num='0';
$chart = $connSystem->prepare("SELECT score_total FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param  ORDER BY score_id  ASC");
$chart->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
while($rowCha = $chart->fetch(PDO::FETCH_ASSOC)) {
$charts_num++;
?>
        [<?php echo round($charts_num) ?>,<?php echo $rowCha['score_total']; ?>],
<?php } ?>

      ]);

      var options = {
        hAxis: {
          title: 'ครั้งที่'
        },
        vAxis: {
          title: 'หลักสูตร <?php echo $rowEXType['type_name'];?>'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }


  </script>


  </div>
  


</div>

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
      $("#Show_Score").modal('show');
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
