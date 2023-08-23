<?php  

//get the q parameter from URL

   header("Content-type:text/html; charset=UTF-8");        
   header("Cache-Control: no-store, no-cache, must-revalidate");       
   header("Cache-Control: post-check=0, pre-check=0", false);      
    mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	ob_start('mb_output_handler');
    setlocale(LC_ALL, 'th_TH');
  
    require_once('ConfigDB.php');
    require_once('ConfigDB_2.php');
require_once('function.php');
$sql_process = new msystem();
    $q = urldecode($_GET["q"]);
    $school_id = $_GET["school_id"];
	////////////////


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

?> 
<?php
$col1=$sql_process->mf("5GCGQQ4HNV0R1QTBGKIL",$language_id);
$col2=$sql_process->mf("RJV9FWIFNTT3MJ1VJASY",$language_id);
$col3=$sql_process->mf("7LI6P12UN6S28B8SF76X",$language_id);

$col6=$sql_process->mf("VRZRFIX59HVWULXGKX6",$language_id);
$col7=$sql_process->mf("74KX0V8BRGUURCPLD24",$language_id);
$col8=$sql_process->mf("G6TFJ2AZIYYHIIIOFB5",$language_id);
$col9=$sql_process->mf("V9DQAJ8UZSC0YP8GDUZ",$language_id);
$col10=$sql_process->mf("5TGWFYL8Z0BWJTNMU0B1",$language_id);

$t1=$sql_process->mf("BBXP2MEZ3KSI6WTH1RZQ",$language_id);
$t2=$sql_process->mf("19HP5AC3WRHN5WZWUXM1",$language_id);
$t3=$sql_process->mf("ULFB3WNBE12U3BZCZ9T",$language_id);
$t4=$sql_process->mf("N962TK7R2EAPP9V5XNB5",$language_id);
$t5=$sql_process->mf("17IEGFB60MGWO9Q4ZEDH",$language_id);
$t6=$sql_process->mf("OSGXR5PQN8A7DLKF9W07",$language_id);
$t7=$sql_process->mf("0BTCSF5SFQ8OHZRR3IF",$language_id);
$t8=$sql_process->mf("G1B5M6OL0MR1GA2VJ8U",$language_id);
$t9=$sql_process->mf("F8SUHFWY9SNQCPWKIR4O",$language_id);
$t10=$sql_process->mf("MO9FN0OMPWA4P89W2FQS",$language_id);
$t11=$sql_process->mf("XDO1JV9FXLAHK4BBG4XQ",$language_id);
?>
  <form id="form1"  name="form1" method="post"  runat="server">
      <table id="example5" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>
            <div class="checkbox">
            <label style="font-size: 1em">
            <INPUT type="checkbox" onchange="checkAll_d1(this.form.userNUM)" name="chk_all_user" />
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            </label>
            </div>
          </th>
          <th><?=$col1?></th>
          <th><?=$col2?></th>
          <th><?=$col3?></th>
          <th>Username</th>
          <th>Password</th>
          <th><?=$col6?></th>
          <th><?=$col7?></th>
          <th><?=$col8?></th>
          <th><?=$col9?></th>
          <th><?=$col10?></th>
        </tr>
        </thead>
        <tbody>
          <!-- ORDER BY CONVERT (user_firstname USING tis620) -->
<?php
$sttu = $connSystem->prepare("SELECT
user_member_group.user_id,
user_member_group.user_name,
user_member_group.user_password_2,
user_member_group.user_prefix,
user_member_group.user_firstname,
user_member_group.user_lastname,
user_member_group.user_id_card,
user_member_group.user_tel,
user_member_group.user_email,
user_member_group.user_img,
user_member_group.user_date,
user_member_group.user_date_start,
user_member_group.user_date_end,
user_member_group.user_date_status,
tbl_school.school_name,
tbl_school.school_path_url
FROM
user_member_group ,
tbl_school
WHERE
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND user_member_group.school_id =:school_id AND LOCATE('$q', user_member_group.user_firstname) > 0) OR
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND user_member_group.school_id =:school_id AND LOCATE('$q', user_member_group.user_lastname) > 0) OR
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND user_member_group.school_id =:school_id AND LOCATE('$q', tbl_school.school_name) > 0) OR
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND user_member_group.school_id =:school_id AND user_member_group.user_id_card ='$q') 
ORDER BY
user_member_group.user_id DESC
LIMIT 0, 120
");
$sttu->execute(array(':school_id'=>$school_id));
while($rowStu = $sttu->fetch(PDO::FETCH_ASSOC)) {
?>
        <tr>
          <td  align="center">
            <div class="checkbox">
           <label style="font-size: 1em">
           <input type="checkbox"  name="Selectuser_id[]" id="userNUM"  value="<?php echo $rowStu["user_id"] ?>">
           <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
          </label>
          </div>
          </td>
          <td align="center"><?php echo  sprintf("%06d", $rowStu["user_id"]); ?></td>
          <td><?php echo $rowStu['user_prefix'];?><?php echo $rowStu['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowStu['user_lastname'];?></td>
          <td align="center"><?php echo $rowStu['user_id_card'];?></td>
          <td align="center"><?php echo $rowStu['user_name'];?></td>
          <td><?php echo $rowStu['user_password_2'];?></td>
          <td  align="center">
          <?php
            // จัดให้อยู่ในรูปแบบนี้ ### - #### - ###
            // สมมติเบอร์นี้
            // $mobile = $rowStu['user_tel'];
            // // กำหนดเครื่องหมาย
            // $minus_sign = "-" ;
            // // เริ่มจากซ้ายตัวที่ 1 ( 0 ) ตัดทิ้งขวาทิ้ง 7 ตัวอักษร ได้ 085
            // $part1 = substr ( $mobile , 0 , -7 ) ;
            // // เริ่มจากซ้าย ตัวที่ 4 (9) ตัดทิ้งขวาทิ้ง 3 ตัวอักษร ได้ 9490
            // $part2 = substr( $mobile , 3 , -3 ) ;
            // // เริ่มจากซ้าย ตัวที่ 8 (8) ไม่ตัดขวาทิ้ง ได้ 862
            // $part3 = substr( $mobile , 7 ) ;
            // echo $part1. $minus_sign . $part2 . $minus_sign . $part3 ;
            echo $rowStu['user_tel'];
            echo "<br>";
            echo $rowStu['user_email'];  //emiail
            ?>
          </td>
          <td  align="center" width="120"><?php  $strDate = $rowStu['user_date_start']; echo DatetoDMY($strDate); ?>  </td>
          <td  align="center"  width="100"> <?php  $strDate = $rowStu['user_date_end']; echo DatetoDMY($strDate); ?> </td>
          <td align="center" >
          <?php
            if($rowStu['user_date_status']=='1'){
              // echo '<small class="label label-success"  data-toggle="tooltip" title="สถานะพร้อมใช้งาน"><i class="fa fa-clock-o"></i> พร้อม</small>';

              echo '<small class="label label-success" data-toggle="tooltip"'; 
              echo "title="."'$t8'";
              echo "><i class='fa fa-clock-o'></i>";
              echo $t9;
              echo "</small>";

            }elseif ($rowStu['user_date_status']=='0') {
      

            echo '<small class="label label-danger" data-toggle="tooltip"'; 
            echo "title="."'$t7'";
            echo "><i class='fa fa-clock-o'></i>";
            echo $t6;
            echo "</small>";
            }
             ?>

          </td>
          <td  align="center"  >
            <div class="btn-group-vertical">
                     <button type="button" onclick="window.location.href='dashboard?option=student-edit&us=<?php echo $rowStu['user_id']; ?>'" data-toggle="tooltip" title="<?=$t10?> <?php echo  sprintf("%06d", $rowStu["user_id"]); ?>" class="btn btn-default"><img id="myImg"  src="image_system/Edit.png"  width="25" height="25" ></button>
                     <button type="button" onclick="window.location.href='dashboard?option=student-renew&us=<?php echo $rowStu['user_id']; ?>'" data-toggle="tooltip" title="<?=$t11?> <?php echo  sprintf("%06d", $rowStu["user_id"]); ?>"   class="btn btn-default">  <img id="myImg"  src="image_system/calendar_icon2.png"  width="25" height="25" ></button>
                   </div>
          </td>
        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
          <th>#</th>
          <th><?=$col1?></th>
          <th><?=$col2?></th>
          <th><?=$col3?></th>
          <th>Username</th>
          <th>Password</th>
          <th><?=$col6?></th>
          <th><?=$col7?></th>
          <th><?=$col8?></th>
          <th><?=$col9?></th>
          <th><?=$col10?></th>
        </tr>
        </tfoot>
      </table>
    </form>