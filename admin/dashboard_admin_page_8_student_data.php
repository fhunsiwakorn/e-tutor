<?php
require_once('chek_student.php'); //ตรวจสอบหมดอายุการใช้งาน

if (isset($_POST['btn_primary'])) {
  try {
    $d = date("Y-m-d");  //วันปัจจุบัน
    $cout_day = $_POST['user_date'];  ///จำนวนวันการใช้งาน
    $strNewDate = date("Y-m-d", strtotime("+$cout_day day", strtotime($d)));

    $stRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_name='" . $_POST['user_name'] . "'")->fetchColumn();
    if ($stRows == '0') {
      $new_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
      $q = 'INSERT INTO user_member_group(user_name,user_password,user_password_2,user_prefix,user_firstname,user_lastname,user_tel,user_email,user_date,user_date_start,user_date_end,user_date_status,school_id,user_status)
VALUES (:user_name, :user_password,:user_password_2,:user_prefix,:user_firstname,:user_lastname,:user_tel,:user_email,:user_date,:user_date_start,:user_date_end,:user_date_status,:school_id,:user_status)';
      $sth = $connSystem->prepare($q);
      $sth->execute(
        array(
          ':user_name' => $_POST['user_name'],
          ':user_password' => $new_password,
          ':user_password_2' => $_POST['user_password'],
          ':user_prefix' => $_POST['user_prefix'],
          ':user_firstname' => $_POST['user_firstname'],
          ':user_lastname' => $_POST['user_lastname'],
          ':user_tel' => $_POST['user_tel'],
          ':user_email' => $_POST['user_email'],
          ':user_date' => $_POST['user_date'],
          ':user_date_start' => $d,
          ':user_date_end' => $strNewDate,
          ':user_date_status' => 1,
          ':school_id' => $_POST['school_id'],
          ':user_status' => 2
        )
      );
      //require_once('class.sms.php');
      echo "<script>";
      echo "location.href = 'dashboard_admin.php?option=student-data&success'";
      echo "</script>";
    } else {
      echo "<script>";
      echo "swal('Username ซ้ำกัน !', 'ปิดหน้าต่างนี้ เพื่อทำรายการใหม่ !', 'error');";
      echo "</script>";
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

///Deleate
if (isset($_GET['del']) && isset($_GET['Selectuser_id'])) {
  try {
    $count = count($_POST['Selectuser_id']);
    for ($i = 0; $i < $count; $i++) {
      // $qd = "UPDATE user_member_group SET user_date_status=:user_date_status  WHERE user_id=:user_id";
      $qd = "DELETE FROM user_member_group  WHERE user_id=:user_id";
      $sth = $connSystem->prepare($qd);
      $sth->execute(
        array(
          ':user_id' => $_POST['Selectuser_id'][$i]
        )
      );
      echo "<script>";
      echo "location.href = 'dashboard_admin.php?option=student-data&success-d'";
      echo "</script>";
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

///Status
if (isset($_GET['update']) && isset($_GET['Selectuser_id'])) {
  try {
    $count = count($_POST['Selectuser_id']);
    for ($i = 0; $i < $count; $i++) {
      $qd = "UPDATE user_member_group SET user_date_status=:user_date_status  WHERE user_id=:user_id";
      $sth = $connSystem->prepare($qd);
      $sth->execute(
        array(
          ':user_id' => $_POST['Selectuser_id'][$i],
          ':user_date_status' => 1
        )
      );
      echo "<script>";
      echo "location.href = 'dashboard_admin.php?option=student-data&success-u'";
      echo "</script>";
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>

<?php
if (isset($_GET['success'])) {
?>
  <script>
    swal("บันทึกข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
  </script>
<?php } ?>

<?php
if (isset($_GET['success-d'])) {
?>
  <script>
    swal("ลบข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
  </script>
<?php } ?>
<?php
if (isset($_GET['success-u'])) {
?>
  <script>
    swal("อับเดทข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
  </script>
<?php } ?>

<script language="JavaScript">
  var checkflag_d1 = "false";

  function checkAll_d1(field) {
    if (checkflag_d1 == "false") {
      for (i = 0; i < field.length; i++) {
        field[i].checked = true;
      }
      checkflag_d1 = "true";
    } else {
      for (i = 0; i < field.length; i++) {
        field[i].checked = false;
      }
      checkflag_d1 = "false";
    }
  }
</script>

<!-- Sumit Form  -->
<script language="javascript">
  function fncSubmit(strPage) {
    if (strPage == "page1") {
      document.form1.action = "dashboard_admin.php?option=student-data&del";
    }

    if (strPage == "page2") {
      document.form1.action = "dashboard_admin.php?option=student-data&update";
    }

    document.form1.submit();
  }
</script>
<script>
  function showResult2(str) {
    if (str.length == 0) {
      document.getElementById("livesearch2").innerHTML = "";
      document.getElementById("livesearch2").style.border = "0px";
      return;
    }
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("livesearch2").innerHTML = this.responseText;
        document.getElementById("livesearch2").style.border = "1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET", "dashboard_admin_page_8_student_data_seacrh.php?q=" + str, true);
    xmlhttp.send();
  }
</script>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">ทะเบียนนักเรียน</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
        <button type="button" class="btn btn-default" name="Deleate_BTN" onClick="JavaScript:fncSubmit('page1')" data-toggle="tooltip" title="ลบนักเรียน">
          <img id="myImg" src="image_system/Bin.png" width="30" height="30">
        </button>
        <button type="button" class="btn btn-default" name="Status_BTN" onClick="JavaScript:fncSubmit('page2')" data-toggle="tooltip" title="กู้ข้อมูลนักเรียน">
          <img id="myImg" src="image_system/user_status-512.png" width="30" height="30">
        </button>
      </div>
    </div>
  </div>
  <div class="box-body">
    <!-- <div class="box-body table-responsive no-padding"> -->

    <div class="col-xs-4">
      <form action="#" method="get" name="form1" autocomplete="off">
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหานักเรียน..." onkeyup="showResult2(this.value);">
          <span class="input-group-btn">
            <button type="button" name="search" id="search-btn" onclick="window.location.href='dashboard_admin.php?option=student-data'" class="btn btn-flat"><i class="glyphicon glyphicon-refresh"></i>
            </button>
          </span>
        </div>
      </form>
    </div>

    <div class="col-xs-12">
      <br>
      <div id="livesearch2">
        <form id="form1" name="form1" method="post" runat="server">
          <table id="example6" class="table table-bordered table-striped">
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
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $total_data = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2'")->fetchColumn();
              $rows = '30';
              if ($page <= 0) $page = 1;
              $total_page = ceil($total_data / $rows);
              if ($page >= $total_page) $page = $total_page;
              $start = ($page - 1) * $rows;
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
user_member_group.user_status = '2' AND
user_member_group.school_id = tbl_school.school_id
ORDER BY
user_member_group.user_id DESC
LIMIT $start, $rows
");
              $sttu->execute();
              while ($rowStu = $sttu->fetch(PDO::FETCH_ASSOC)) {
              ?>
                <tr>
                  <td align="center">
                    <div class="checkbox">
                      <label style="font-size: 1em">
                        <input type="checkbox" name="Selectuser_id[]" id="userNUM" value="<?php echo $rowStu["user_id"] ?>">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                      </label>
                    </div>
                  </td>
                  <td align="center"><?php echo  sprintf("%06d", $rowStu["user_id"]); ?></td>
                  <td><?php echo $rowStu['user_prefix']; ?><?php echo $rowStu['user_firstname']; ?>&nbsp;&nbsp;<?php echo $rowStu['user_lastname']; ?></td>
                  <td align="center"><?php echo $rowStu['user_name']; ?></td>
                  <td><?php echo $rowStu['user_password_2']; ?></td>
                  <td align="center">
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
                    echo  $rowStu['user_tel'];
                    echo "<br>";
                    echo $rowStu['user_email'];  //emiail
                    ?>
                  </td>
                  <td><a target="_blank" href="<?php echo $rowStu["school_path_url"]; ?>"><?php echo $rowStu["school_name"]; ?></a></td>
                  <td align="center" width="120"><?php $strDate = $rowStu['user_date_start'];
                                                  echo DateThai($strDate); ?> </td>
                  <td align="center" width="100"> <?php $strDate = $rowStu['user_date_end'];
                                                  echo DateThai($strDate); ?> </td>
                  <td align="center">
                    <?php
                    if ($rowStu['user_date_status'] == '1') {
                      echo '<small class="label label-success"  data-toggle="tooltip" title="สถานะพร้อมใช้งาน"><i class="fa fa-clock-o"></i> พร้อม</small>';
                    } elseif ($rowStu['user_date_status'] == '0') {
                      echo '<small class="label label-warning" data-toggle="tooltip" title="หมดอายุปิดการใช้งาน"><i class="fa fa-clock-o"></i> ปิด</small>';
                    } elseif ($rowStu['user_date_status'] == '2') {
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
      </div>

      <form method="get" name="supage1">
        <nav aria-label="...">
          <input type="hidden" name="option" value="student-data">
          <ul class="pager">
            <li <?php if ($page == 1) {
                  echo "class='disabled'";
                } ?>><a href="?option=student-data&page=<?= $page - 1 ?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
            <li><input type="number" name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?= $page ?>" onchange="submit();"></li>
            <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?= $total_page ?> : <?= $total_data ?>" disabled></li>
            <li <?php if ($page == $total_page) {
                  echo "class='disabled'";
                } ?>><a href="?option=student-data&page=<?= $page + 1 ?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
          </ul>
        </nav>
      </form>


    </div>

  </div>
  <!-- /.box-body -->
</div>