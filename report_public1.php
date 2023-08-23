<?php  


//get the q parameter from URL

   header("Content-type:text/html; charset=UTF-8");        
   header("Cache-Control: no-store, no-cache, must-revalidate");       
   header("Cache-Control: post-check=0, pre-check=0", false);      
    // mb_internal_encoding('UTF-8');
	// mb_http_output('UTF-8');
	// mb_http_input('UTF-8');
	// mb_language('uni');
	// mb_regex_encoding('UTF-8');
	// ob_start('mb_output_handler');
    // setlocale(LC_ALL, 'th_TH');
  
    require_once('ConfigDB.php');
    
    // $q = urldecode($_GET["q"]);
    $q = $_GET["q"];
    $school_id = $_GET["school_id"];
    $type_id = $_GET["type_id"];
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
?> 

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
(exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND LOCATE('$q', user_member_group.user_firstname) > 0) OR
(exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND LOCATE('$q', user_member_group.user_lastname) > 0)
--  OR
-- (exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND  user_member_group.user_firstname LIKE '%$q%') OR 
-- (exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND  user_member_group.user_lastname LIKE '%$q%')
GROUP BY
exam_status_score.user_id
ORDER BY
exam_status_score.score_id DESC

");
$strli->execute(array(':type_id_param'=>$type_id,':school_id'=>$school_id));
while($rowList = $strli->fetch(PDO::FETCH_ASSOC)) {
$list_stu++;
?>
        <tr>
          <!-- <td align="center"><?=$list_stu?></td> -->
          <td><?php echo $rowList['user_prefix'];?><?php echo $rowList['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowList['user_lastname'];?></td>
          <td  align="center">
            <?php
          $numexRows = $connSystem->query("SELECT count(*) from exam_status_score WHERE user_id='".$rowList['user_id']."'and type_id='$type_id'")->fetchColumn();
          echo "$numexRows ";
            ?>
          </td>
          <td  align="center">
            <button type="button"  class="btn btn-default" onclick="window.location.href='report_public2.php?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id;?>'" data-toggle="tooltip" title="ประวัติการสอบและกราฟ <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/diagram_32-512.png"  width="25" height="25" >
            </button>
          </td>
          <td  align="center">
            <div class="btn-group">
            <button type="button"  class="btn btn-default" onclick="window.location.href='report-excel?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id;?>'" data-toggle="tooltip" title="รายงาน <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/Microsoft-Excel-2013-Logo.png"  width="25" height="25" >
            </button>
            <button type="button"  class="btn btn-default" onclick="window.location.href='report-word?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id;?>'" data-toggle="tooltip" title="รายงาน <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/logo_word.png"  width="25" height="25" >
            </button>
            <button type="button"  class="btn btn-default" onclick="window.open('report-print?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $type_id;?>', '_blank');" />
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
