<?php
date_default_timezone_set('Asia/Bangkok');

require_once('ConfigDB.php');
include ("ConfigName.php");
require_once('ConfigDB_2.php');
require_once('function.php');
$sql_process = new msystem();




    ///โรงเรียน
    $school_code=isset($_GET['school_code']) ? $_GET['school_code'] : NULL;
    $type_id_search = isset($_GET['type_id']) ? $_GET['type_id'] : NULL;

    $q = isset($_GET['q']) ? $_GET['q'] : NULL;


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


  if($q != NULL){
    $statement="(exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND  user_member_group.user_firstname LIKE '%$q%') OR 
  (exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND  user_member_group.user_lastname LIKE '%$q%')";
  
  $statement1="(exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id='$type_id_search' AND exam_status_score.school_id ='$school_id' AND  user_member_group.user_firstname LIKE '%$q%') OR 
  (exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id='$type_id_search' AND exam_status_score.school_id ='$school_id' AND  user_member_group.user_lastname LIKE '%$q%')";
  }else{
    $statement="exam_status_score.user_id = user_member_group.user_id AND
    exam_status_score.type_id=:type_id_param AND
    exam_status_score.school_id=:school_id";
    $statement1="exam_status_score.user_id = user_member_group.user_id AND
    exam_status_score.type_id='$type_id_search' AND
    exam_status_score.school_id='$school_id'";
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

        <script>
function showResult2(str) {
  if (str.length==0) { 
    document.getElementById("livesearch2").innerHTML="";
    document.getElementById("livesearch2").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch2").innerHTML=this.responseText;
      document.getElementById("livesearch2").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","report_public1.php?school_id=<?=$school_id?>&type_id=<?=$type_id_search?>&q="+str,true);
  xmlhttp.send();
}

</script>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<!-- <body class="hold-transition skin-green layout-top-nav"> -->
<body>

<div class="row">
<form method="get" name="Search_type" autocomplete="off">
<input type="hidden" name="school_code"  value="<?=$school_code?>">
<div class="col-xs-4">

<label>หลักสูตร</label>

<select name="type_id" id="type_id"  class="form-control" onchange="submit();">
<option value="">--เลือกหลักสูตร--</option>
<?php
$stype = $connSystem->prepare("SELECT
exam_type.type_id,
exam_type.type_name
 FROM 
tbl_permission_course ,
exam_type ,
tbl_school 
WHERE
exam_type.type_id = tbl_permission_course.type_id AND
tbl_permission_course.compair_course = '$compair_course' AND
tbl_school.compair_course = '$compair_course'
 ORDER BY type_id  DESC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
$type_id=$rowType['type_id'];
$type_name=$rowType['type_name'];
// echo "<option value='$type_id'>$type_name</option>";
echo"<option value='$type_id'";
                  if ($type_id_search == $type_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$type_name</option>\n";


}
?>

</select>

</div>

<div class="col-xs-4">
<label>ชื่อนักเรียน</label>
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหานักเรียน..."  value="<?=$q?>"  > 
          <!-- onkeyup="showResult2(this.value);" -->
          <span class="input-group-btn">
          <button type="sumbit" name="search" id="search-btn" onclick="window.location.href='report_public.php?school_code=<?=$school_code?>'" class="btn btn-flat">
          <!-- <i class="glyphicon glyphicon-refresh"></i> -->
          ค้นหา
                </button>
              </span>
        </div>
      
        </div>
        </form>

<div class="col-xs-12">
    <br>
    <div id="livesearch2">
      <table id="example6" class="table table-bordered table-striped">
        <thead>
        <tr>
          <!-- <th>ลำดับ</th> -->
          <th>ชื่อ - นามสกุล</th>
          <th>จำนวนการทำข้อสอบ</th>
          <th>ประวัติการสอบ - กราฟ</th>
          <th>ออกรายงาน</th>
        </tr>
        </thead>
        <tbody>
<?php
$list_stu='0';
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$total_data = $connSystem->query("SELECT 
 exam_status_score.user_id
 FROM 
exam_status_score,
user_member_group 
WHERE 
$statement1
-- exam_status_score.user_id = user_member_group.user_id  AND 
-- exam_status_score.type_id='$type_id_search' AND
-- exam_status_score.school_id='$school_id'

GROUP BY
exam_status_score.user_id

")->fetchColumn();
$rows='30';
if($page<=0)$page=1;
$total_page=ceil($total_data/$rows);
if($page>=$total_page)$page=$total_page;
$start=($page-1)*$rows;

$strli= $connSystem->prepare("SELECT
exam_status_score.score_id,
exam_status_score.score_total,
exam_status_score.user_id,
exam_status_score.score_date,
exam_status_score.type_id,
exam_status_score.school_id,
user_member_group.user_prefix,
user_member_group.user_firstname,
user_member_group.user_lastname
FROM
exam_status_score ,
user_member_group
WHERE

-- exam_status_score.user_id = user_member_group.user_id AND
-- exam_status_score.type_id=:type_id_param AND
-- exam_status_score.school_id=:school_id 
$statement
GROUP BY
exam_status_score.user_id
ORDER BY
exam_status_score.score_id DESC
LIMIT $start, $rows
");
$strli->execute(array(':type_id_param'=>$type_id_search,':school_id'=>$school_id));
while($rowList = $strli->fetch(PDO::FETCH_ASSOC)) {
$list_stu++;
?>
        <tr>
          <!-- <td align="center"><?=$list_stu?></td> -->
          <td><?php echo $rowList['user_prefix'];?><?php echo $rowList['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowList['user_lastname'];?></td>
          <td  align="center">
            <?php
          $numexRows = $connSystem->query("SELECT count(*) from exam_status_score WHERE user_id='".$rowList['user_id']."'and type_id='$type_id_search'")->fetchColumn();
          echo "$numexRows ";
            ?>
          </td>
          <td  align="center">
            <button type="button"  class="btn btn-default" onclick="window.location.href='report_public2.php?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id_search;?>&school_code=<?=$school_code?>'" data-toggle="tooltip" title="ประวัติการสอบและกราฟ <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/diagram_32-512.png"  width="25" height="25" >
            </button>
          </td>
          <td  align="center">
            <div class="btn-group">
            <button type="button"  class="btn btn-default" onclick="window.location.href='report-excel?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id_search;?>'" data-toggle="tooltip" title="รายงาน <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/Microsoft-Excel-2013-Logo.png"  width="25" height="25" >
            </button>
            <button type="button"  class="btn btn-default" onclick="window.location.href='report-word?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id_search;?>'" data-toggle="tooltip" title="รายงาน <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/logo_word.png"  width="25" height="25" >
            </button>
            <button type="button"  class="btn btn-default" onclick="window.open('report-print?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id_search;?>', '_blank');" />
       <img id="myImg"  src="image_system/Printer-icon.png"  width="25" height="25" >
         </button>
       </div>
          </td>

        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
          <!-- <th>ลำดับ</th> -->
          <th>ชื่อ - นามสกุล</th>
          <th>จำนวนการทำข้อสอบ</th>
          <th>ประวัติการสอบ - กราฟ</th>
          <th>ออกรายงาน</th>
        </tr>
        </tfoot>
      </table>
      </div>

      <form method="get" name="supage1">
                <nav aria-label="...">
               
                <input type="hidden" name="school_code"  value="<?=$school_code?>">
                <input type="hidden" name="type_id"  value="<?=$type_id_search?>">
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="report_public.php?type_id=<?=$type_id_search?>&school_code=<?=$school_code?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number"  name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                    <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$total_page?> : <?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="report_public.php?type_id=<?=$type_id_search?>&school_code=<?=$school_code?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
                </ul>
                </nav>
              </form>  

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
