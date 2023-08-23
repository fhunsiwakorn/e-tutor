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
       
    $q = urldecode($_GET["q"]);
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
          <th>รหัสนักเรียน</th>
          <th>ชื่อ - นามสกุล</th>
          <th>Username</th>
          <th>Password</th>
          <th>E-mail / เบอร์โทร</th>
          <th>โรงเรียน</th>
          <th>วันที่ลงทะเบียน</th>
          <th>วันหมดอายุ</th>
          <th>สถานะ</th>
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
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND LOCATE('$q', user_member_group.user_firstname) > 0) OR
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND LOCATE('$q', user_member_group.user_lastname) > 0) OR
(user_member_group.user_status = '2' AND user_member_group.user_status = '2' AND user_member_group.school_id = tbl_school.school_id AND LOCATE('$q', tbl_school.school_name) > 0) 
ORDER BY
user_member_group.user_id DESC
LIMIT 0, 120
");
$sttu->execute();
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
          <td align="center"><?php echo $rowStu['user_name'];?></td>
          <td><?php echo $rowStu['user_password_2'];?></td>
          <td  align="center">
            <?php
            // จัดให้อยู่ในรูปแบบนี้ ### - #### - ###
            // สมมติเบอร์นี้
            $mobile = $rowStu['user_tel'];
            // กำหนดเครื่องหมาย
            $minus_sign = "-" ;
            // เริ่มจากซ้ายตัวที่ 1 ( 0 ) ตัดทิ้งขวาทิ้ง 7 ตัวอักษร ได้ 085
            $part1 = substr ( $mobile , 0 , -7 ) ;
            // เริ่มจากซ้าย ตัวที่ 4 (9) ตัดทิ้งขวาทิ้ง 3 ตัวอักษร ได้ 9490
            $part2 = substr( $mobile , 3 , -3 ) ;
            // เริ่มจากซ้าย ตัวที่ 8 (8) ไม่ตัดขวาทิ้ง ได้ 862
            $part3 = substr( $mobile , 7 ) ;
            echo $part1. $minus_sign . $part2 . $minus_sign . $part3 ;
            echo "<br>";
            echo $rowStu['user_email'];  //emiail
            ?>
          </td>
          <td><a target="_blank" href="<?php echo $rowStu["school_path_url"]; ?>"><?php echo $rowStu["school_name"]; ?></a></td>
          <td  align="center" width="120"><?php  $strDate = $rowStu['user_date_start']; echo DateThai($strDate); ?>  </td>
          <td  align="center"  width="100"> <?php  $strDate = $rowStu['user_date_end']; echo DateThai($strDate); ?> </td>
          <td align="center" >
            <?php
            if($rowStu['user_date_status']=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="สถานะพร้อมใช้งาน"><i class="fa fa-clock-o"></i> พร้อม</small>';
            }elseif ($rowStu['user_date_status']=='0') {
            echo '<small class="label label-warning" data-toggle="tooltip" title="หมดอายุปิดการใช้งาน"><i class="fa fa-clock-o"></i> ปิด</small>';
          }elseif ($rowStu['user_date_status']=='2') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ถูกลบออกจากระบบ"><i class="fa fa-clock-o"></i> ถูกลบ</small>';
            }
             ?>

          </td>
        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
          <th>#</th>
          <th>รหัสนักเรียน</th>
          <th>ชื่อ - นามสกุล</th>
          <th>Username</th>
          <th>Password</th>
          <th>โรงเรียน</th>
          <th>E-mail / เบอร์โทร</th>
          <th>วันที่ลงทะเบียน</th>
          <th>วันหมดอายุ</th>
          <th>สถานะ</th>
        </tr>
        </tfoot>
      </table>
    </form>