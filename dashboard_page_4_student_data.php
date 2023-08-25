<?php
// require_once('chek_student.php'); //ตรวจสอบหมดอายุการใช้งาน
$user_code = random_password(10);
if (isset($_POST['btn_primary'])) {
  try {
    $d = date("Y-m-d");  //วันปัจจุบัน
    $cout_day = $_POST['user_date'];  ///จำนวนวันการใช้งาน
    $strNewDate = date("Y-m-d", strtotime("+$cout_day day", strtotime($d)));

    $stRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_name='" . $_POST['user_name'] . "'")->fetchColumn();
    if ($stRows == '0') {
      $new_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
      $q = 'INSERT INTO user_member_group(user_name,user_password,user_password_2,user_prefix,user_firstname,user_lastname,user_id_card,user_tel,user_email,user_date,user_date_start,user_date_end,user_date_status,school_id,user_status,user_code)
VALUES (:user_name, :user_password,:user_password_2,:user_prefix,:user_firstname,:user_lastname,:user_id_card,:user_tel,:user_email,:user_date,:user_date_start,:user_date_end,:user_date_status,:school_id,:user_status,:user_code)';
      $sth = $connSystem->prepare($q);
      $sth->execute(
        array(
          ':user_name' => $_POST['user_name'],
          ':user_password' => $new_password,
          ':user_password_2' => $_POST['user_password'],
          ':user_prefix' => $_POST['user_prefix'],
          ':user_firstname' => $_POST['user_firstname'],
          ':user_lastname' => $_POST['user_lastname'],
          ':user_id_card' => $_POST['user_id_card'],
          ':user_tel' => $_POST['user_tel'],
          ':user_email' => $_POST['user_email'],
          ':user_date' => $_POST['user_date'],
          ':user_date_start' => $d,
          ':user_date_end' => $strNewDate,
          ':user_date_status' => 1,
          ':school_id' => $school_id,
          ':user_status' => 2,
          ':user_code' => $user_code
        )
      );

      if (isset($_POST['Selecttype_id'])) {
        $count = count($_POST['Selecttype_id']);
        for ($i = 0; $i < $count; $i++) {
          $qrc = 'INSERT INTO exam_permission(type_id,user_code,school_id)
    VALUES (:type_id,:user_code,:school_id)';
          $sthc = $connSystem->prepare($qrc);
          $sthc->execute(
            array(
              ':type_id' => $_POST['Selecttype_id'][$i],
              ':user_code' => $user_code,
              ':school_id' => $school_id
            )
          );
          // echo "<center>";
          //   echo $_POST['Selecttype_id'][$i];
          //   echo "</center>";
        }
      }


      //  require_once('class.sms.php');
      echo "<script>";
      echo "location.href = 'dashboard?option=student-data&success'";
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
if (isset($_POST['DELuser_id'])) {
  try {


    $count = count($_POST['DELuser_id']);
    for ($i = 0; $i < $count; $i++) {
      // $qd = "DELETE FROM user_member_group  WHERE user_id=:user_id";
      $qd = "UPDATE user_member_group SET user_date_status=:user_date_status  WHERE user_id=:user_id";
      $sth = $connSystem->prepare($qd);
      $sth->execute(
        array(
          ':user_id' => $_POST['DELuser_id'][$i],
          ':user_date_status' => 2
        )
      );
      echo "<script>";
      echo "location.href = 'dashboard?option=student-data&success-d'";
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
<script>
  function myFunction() {
    document.getElementById("form_del").submit();
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
    xmlhttp.open("GET", "dashboard_page_4_student_data_search.php?school_id=<?= $school_id ?>&q=" + str, true);
    xmlhttp.send();
  }
</script>

<?php
$col1 = $sql_process->mf("5GCGQQ4HNV0R1QTBGKIL", $language_id);
$col2 = $sql_process->mf("RJV9FWIFNTT3MJ1VJASY", $language_id);
$col3 = $sql_process->mf("7LI6P12UN6S28B8SF76X", $language_id);

$col6 = $sql_process->mf("VRZRFIX59HVWULXGKX6", $language_id);
$col7 = $sql_process->mf("74KX0V8BRGUURCPLD24", $language_id);
$col8 = $sql_process->mf("G6TFJ2AZIYYHIIIOFB5", $language_id);
$col9 = $sql_process->mf("V9DQAJ8UZSC0YP8GDUZ", $language_id);
$col10 = $sql_process->mf("5TGWFYL8Z0BWJTNMU0B1", $language_id);

$t1 = $sql_process->mf("BBXP2MEZ3KSI6WTH1RZQ", $language_id);
$t2 = $sql_process->mf("19HP5AC3WRHN5WZWUXM1", $language_id);
$t3 = $sql_process->mf("ULFB3WNBE12U3BZCZ9T", $language_id);
$t4 = $sql_process->mf("N962TK7R2EAPP9V5XNB5", $language_id);
$t5 = $sql_process->mf("17IEGFB60MGWO9Q4ZEDH", $language_id);
$t6 = $sql_process->mf("OSGXR5PQN8A7DLKF9W07", $language_id);
$t7 = $sql_process->mf("0BTCSF5SFQ8OHZRR3IF", $language_id);
$t8 = $sql_process->mf("G1B5M6OL0MR1GA2VJ8U", $language_id);
$t9 = $sql_process->mf("F8SUHFWY9SNQCPWKIR4O", $language_id);
$t10 = $sql_process->mf("MO9FN0OMPWA4P89W2FQS", $language_id);
$t11 = $sql_process->mf("XDO1JV9FXLAHK4BBG4XQ", $language_id);
?>

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">
      <?php
      $total_student = $connSystem->query("SELECT count(*) FROM user_member_group WHERE user_status='2' AND user_date_status!='2' AND school_id='$school_id'")->fetchColumn();
      ?>
      <?= $t1 ?></h3>
    <h5>
      [<?= $t2 ?> <?= $total_student ?> / <?= $number_student ?>]

    </h5>
    <div class="box-tools pull-right">
      <div class="btn-group">
        <button <?php if ($total_student >= $number_student) {
                  echo "disabled";
                } ?> type="button" class="btn btn-default" data-toggle="modal" data-target="#Addstudent">
          <img id="myImg" src="image_system/add_user.png" width="30" height="30">
        </button>
        <button type="button" class="btn btn-default" onclick="window.location.href='dashboard?option=student-report-chart'" data-toggle="tooltip" title="<?= $t3 ?>">
          <img id="myImg" src="image_system/bar-graph.ico" width="30" height="30">
        </button>
        <button type="button" class="btn btn-default" onclick="myFunction()" data-toggle="tooltip" title="<?= $t4 ?>">
          <img id="myImg" src="image_system/Bin.png" width="30" height="30">
        </button>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="col-xs-4">
      <form action="#" method="get" name="form1" autocomplete="off">
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="<?= $t5 ?>..." onkeyup="showResult2(this.value);">
          <span class="input-group-btn">
            <button type="button" name="search" id="search-btn" onclick="window.location.href='dashboard?option=student-data'" class="btn btn-flat"><i class="glyphicon glyphicon-refresh"></i>
            </button>
          </span>
        </div>
      </form>
    </div>


    <div class="col-xs-12">
      <br>
      <div id="livesearch2">
        <form id="form_del" name="form_del" method="post" runat="server">
          <div class="box-body table-responsive no-padding">
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
                  <th><?= $col1 ?></th>
                  <th><?= $col2 ?></th>
                  <th><?= $col3 ?></th>
                  <th>Username</th>
                  <th>Password</th>
                  <th><?= $col6 ?></th>
                  <th><?= $col7 ?></th>
                  <th><?= $col8 ?></th>
                  <th><?= $col9 ?></th>
                  <th><?= $col10 ?></th>
                </tr>
              </thead>
              <tbody>
                <!-- ORDER BY CONVERT (user_firstname USING tis620) -->
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $total_data = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND user_member_group.user_date_status !='2' AND user_member_group.school_id ='$school_id'")->fetchColumn();
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
user_member_group.user_id_card,
user_member_group.user_tel,
user_member_group.user_email,
user_member_group.user_img,
user_member_group.user_date,
user_member_group.user_date_start,
user_member_group.user_date_end,
user_member_group.user_date_status,
tbl_school.school_name,
tbl_school.school_path_url,
user_member_group.school_id
FROM
user_member_group ,
tbl_school
WHERE
user_member_group.user_status = '2' AND
user_member_group.user_date_status !='2' AND
user_member_group.school_id = tbl_school.school_id  AND
tbl_school.school_id =:school_id
ORDER BY
user_member_group.user_id DESC
LIMIT $start, $rows
");
                $sttu->execute(array(':school_id' => $school_id));
                while ($rowStu = $sttu->fetch(PDO::FETCH_ASSOC)) {

                ?>
                  <tr>
                    <td align="center">
                      <div class="checkbox">
                        <label style="font-size: 1em">
                          <input type="checkbox" name="DELuser_id[]" id="userNUM" value="<?php echo $rowStu["user_id"] ?>">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        </label>
                      </div>
                    </td>
                    <td align="center"><?php echo  sprintf("%06d", $rowStu["user_id"]); ?></td>
                    <td><?php echo $rowStu['user_prefix']; ?><?php echo $rowStu['user_firstname']; ?>&nbsp;&nbsp;<?php echo $rowStu['user_lastname']; ?></td>
                    <td align="center"><?php echo $rowStu['user_id_card']; ?></td>
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
                      echo $rowStu['user_tel'];
                      echo "<br>";
                      echo $rowStu['user_email'];  //emiail
                      ?>
                    </td>
                    <td align="center" width="100"><?php $strDate = $rowStu['user_date_start'];
                                                    echo DatetoDMY($strDate); ?> </td>
                    <td align="center" width="100"> <?php $strDate = $rowStu['user_date_end'];
                                                    echo DatetoDMY($strDate); ?> </td>
                    <td align="center">
                      <?php
                      if ($rowStu['user_date_status'] == '1') {
                        // echo '<small class="label label-success"  data-toggle="tooltip" title="สถานะพร้อมใช้งาน"><i class="fa fa-clock-o"></i> พร้อม</small>';

                        echo '<small class="label label-success" data-toggle="tooltip"';
                        echo "title=" . "'$t8'";
                        echo "><i class='fa fa-clock-o'></i>";
                        echo $t9;
                        echo "</small>";
                      } elseif ($rowStu['user_date_status'] == '0') {


                        echo '<small class="label label-danger" data-toggle="tooltip"';
                        echo "title=" . "'$t7'";
                        echo "><i class='fa fa-clock-o'></i>";
                        echo $t6;
                        echo "</small>";
                      }
                      ?>


                    </td>
                    <td align="center">
                      <div class="btn-group-vertical">
                        <button type="button" onclick="window.location.href='dashboard?option=student-edit&us=<?php echo $rowStu['user_id']; ?>'" data-toggle="tooltip" title="<?= $t10 ?> <?php echo  sprintf("%06d", $rowStu["user_id"]); ?>" class="btn btn-default"><img id="myImg" src="image_system/Edit.png" width="25" height="25"></button>
                        <button type="button" onclick="window.location.href='dashboard?option=student-renew&us=<?php echo $rowStu['user_id']; ?>'" data-toggle="tooltip" title="<?= $t11 ?> <?php echo  sprintf("%06d", $rowStu["user_id"]); ?>" class="btn btn-default"> <img id="myImg" src="image_system/calendar_icon2.png" width="25" height="25"></button>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th><?= $col1 ?></th>
                  <th><?= $col2 ?></th>
                  <th><?= $col3 ?></th>
                  <th>Username</th>
                  <th>Password</th>
                  <th><?= $col6 ?></th>
                  <th><?= $col7 ?></th>
                  <th><?= $col8 ?></th>
                  <th><?= $col9 ?></th>
                  <th><?= $col10 ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
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


<!-- Modal ADD user student -->
<div class="modal fade" id="Addstudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <script>
    //Random password generator- by javascriptkit.com
    //Visit JavaScript Kit (http://javascriptkit.com) for script
    //Credit must stay intact for use

    var keylist = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789" // ตัวอักษรที่จะให้มีอยู่ใน Password
    var temp = ''

    function generatepass(plength) {
      temp = ''
      for (i = 0; i < plength; i++)
        temp += keylist.charAt(Math.floor(Math.random() * keylist.length))
      return temp
    }

    function populateform(enterlength) {
      document.frmMain.user_name.value = generatepass(enterlength)
    }

    function populateform2(enterlength) {
      document.frmMain.user_password.value = generatepass(enterlength)
    }
  </script>
  <div class="modal-dialog" role="document">

    <form id="frmMain" name="frmMain" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?= $sql_process->mf("62JD9WX9CHF3HBCJ0K4D", $language_id); ?></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-6">
              <label>User Name</label>

              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" onClick="populateform(7)">Generate</button>
                </div>
                <input type="text" class="form-control" name="user_name" autocomplete="off" required>
                <span id="mySpan"></span>
              </div>
            </div>
            <div class="col-xs-6">
              <label>Password</label>

              <div class="input-group">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" onClick="populateform2(7)">Generate</button>
                </div>
                <input type="text" class="form-control" autocomplete="off" name="user_password" required>
              </div>
            </div>
            <div class="col-xs-6">
              <label><?= $sql_process->mf("4IM3X6XCDS9CXAB08GU", $language_id); ?></label>
              <select name="user_prefix" id="user_prefix" class="form-control">
                <?php
                $stype = $connSystem->prepare("SELECT title_name FROM tbl_master_titlename WHERE language_id='$language_id' ORDER BY title_id  ASC");
                $stype->execute();
                while ($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

                ?>
                  <option value="<?= $rowType['title_name'] ?>"><?= $rowType['title_name'] ?></option>
                <?php } ?>

              </select>

            </div>
            <div class="col-xs-6">
              <label><?= $sql_process->mf("WWJR9XIDFDY2EXSBRVK", $language_id); ?></label>

              <input type="text" class="form-control" name="user_firstname" required>
            </div>
            <div class="col-xs-6">
              <label><?= $sql_process->mf("O69T91GRZGN979CK7GN", $language_id); ?></label>
              <input type="text" name="user_lastname" class="form-control" required>
            </div>
            <div class="col-xs-6">
              <label><?= $sql_process->mf("7LI6P12UN6S28B8SF76X", $language_id); ?></label>
              <input type="text" name="user_id_card" class="form-control" required maxlength="13">
            </div>

            <div class="col-xs-6">
              <label><?= $sql_process->mf("90E6UM80ODZGGCF6NY2", $language_id); ?></label>
              <input type="tel" name="user_tel" autocomplete="off" class="form-control" required data-inputmask='"mask": "9999999999"' data-mask>
              <!-- <input type="tel"  name="user_tel" class="form-control"  data-inputmask='"mask": "(999) 999-9999"' data-mask> -->
            </div>
            <div class="col-xs-6">

              <label><?= $sql_process->mf("X5XQUNFLBBH050X6ORPH", $language_id); ?></label>
              <input type="email" autocomplete="off" class="form-control" name="user_email">
            </div>

            <div class="col-xs-6">
              <?php $day = $sql_process->mf("J0Y1I8DDD0C28JP3K95", $language_id); ?>
              <label><?= $sql_process->mf("CAMS06GZB67SNWV2HT64", $language_id); ?></label>
              <select name="user_date" id="user_date" class="form-control">
                <option value="7">7 <?= $day ?></option>
                <option value="30">30 <?= $day ?></option>

              </select>

            </div>

            <div class="col-xs-12">
              <hr>
              <?php
              $cola1 = $sql_process->mf("0S7T6K01MQJKECAVUIO8", $language_id);
              $cola2 = $sql_process->mf("OOQH1J2R04RTTA0H3N", $language_id);
              $cola3 = $sql_process->mf("MD3ORJ9W014YY8UR5642", $language_id);
              $cola4 = $sql_process->mf("Z62PFHTQFSOIHCNS90H5", $language_id);
              $cola5 = $sql_process->mf("OAIQHY41T24Z06WRYIJJ", $language_id);

              $ta1 = $sql_process->mf("ZKJTB5GB4VB3O4H69Z", $language_id);
              $ta2 = $sql_process->mf("M5LG2XXTSR4ZZSW5GD0", $language_id);
              ?>
              <div class="box-body table-responsive no-padding">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>

                        <div class="checkbox">
                          <label style="font-size: 1em">
                            <INPUT type="checkbox" onchange="checkAll_d1(this.form.typeNUM)" name="chk_all_user" />
                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          </label>
                        </div>


                      </th>
                      <th><?= $cola1 ?></th>
                      <th><?= $cola2 ?></th>
                      <th><?= $cola3 ?></th>
                      <th><?= $cola4 ?></th>
                      <th><?= $cola5 ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $stype = $connSystem->prepare(
                      "SELECT
exam_type.type_id,
exam_type.type_name,
exam_type.type_detail,
exam_type.type_pic,
exam_type.type_date,
exam_type.language_id,
exam_type.type_group_id
FROM
tbl_permission_course ,
exam_type ,
tbl_school
WHERE
exam_type.type_id = tbl_permission_course.type_id AND
tbl_permission_course.compair_course = '$compair_course' AND
tbl_school.compair_course = '$compair_course' AND
exam_type.type_status='1'
ORDER BY exam_type.type_id  DESC"
                    );
                    $stype->execute();
                    while ($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
                      if (!empty($rowType['type_pic'])) {
                        $cimg = $rowType['type_pic'];
                      } else {
                        $cimg = "image_system/noimage.gif";
                      }
                      $ste = $connSystem->prepare("SELECT language_name FROM tbl_exam_language  WHERE language_id ='" . $rowType['language_id'] . "'");
                      $ste->execute();
                      $rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);
                      $language_name = $rowCeedit["language_name"];

                      $ste1 = $connSystem->prepare("SELECT type_group_name FROM tbl_vehicle_type  WHERE type_group_id ='" . $rowType['type_group_id'] . "'");
                      $ste1->execute();
                      $rowCeedit1 = $ste1->fetch(PDO::FETCH_ASSOC);
                      $type_group_name = $rowCeedit1["type_group_name"];
                    ?>
                      <tr>
                        <td align="center">
                          <div class="checkbox">
                            <label style="font-size: 1em">
                              <input type="checkbox" name="Selecttype_id[]" id="typeNUM" value="<?php echo $rowType["type_id"] ?>">
                              <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                            </label>
                          </div>

                        </td>
                        <td align="center"><?php echo  sprintf("%04d", $rowType["type_id"]); ?></td>
                        <td align="center"><img id="myImg" src="<?= $cimg ?>" alt="<?php echo $rowType['type_name']; ?>" width="45" height="45" style="border-radius:100px"></td>
                        <td><?php echo $rowType['type_name']; ?></td>
                        <td><?= $language_name ?></td>
                        <td><?= $type_group_name ?></td>

                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th><?= $cola1 ?></th>
                      <th><?= $cola2 ?></th>
                      <th><?= $cola3 ?></th>
                      <th><?= $cola4 ?></th>
                      <th><?= $cola5 ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <!-- <font color="red"> คำชี้แจง : <br>
            1.วันหมดอายุการใช้งานจะเริ่มทำงานทันทีหลังจากเพิ่มนักเรียน  <br>
            2.ระบบจะส่ง SMS การใช้งานโดยแนบ URL  พร้อม Username Password ให้หลังจากเพิ่มนักเรียนนั้นๆ
           </font> -->
            </div>
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal"><?= $ta1 ?></button>
          <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?= $theme_color ?>;"><?= $ta2 ?></button>
        </div>
      </div>
    </form>
  </div>
</div>