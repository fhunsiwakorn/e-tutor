<?php
$ust = $connSystem->prepare("SELECT user_id, user_name,user_password_2,user_prefix,user_firstname,user_lastname,user_id_card,user_tel,user_email,user_code FROM user_member_group  WHERE user_id = :user_id_param");
$ust->execute(array(':user_id_param' => $_GET['us']));
$rowUedit = $ust->fetch(PDO::FETCH_ASSOC);
// $user_code=$rowUedit["user_code"];
$user_code = !empty($rowUedit['user_code']) ? $rowUedit['user_code'] : random_password(10);
if (isset($_POST['btn_primary'])) {
  try {
    //  $d=date("Y-m-d");
    //  $cout_day=$_POST['user_date'];
    //  $strNewDate = date ("Y-m-d", strtotime("+$cout_day day", strtotime($d)));


    $new_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

    $q = "UPDATE user_member_group SET
     user_password=:user_password,
     user_password_2=:user_password_2,
     user_prefix=:user_prefix,
     user_firstname=:user_firstname,
     user_lastname=:user_lastname,
     user_id_card=:user_id_card,
     user_tel=:user_tel,
     user_email=:user_email,
     user_code=:user_code1
     WHERE user_id=:user_id";
    $sth = $connSystem->prepare($q);
    $sth->execute(
      array(
        ':user_id' => $_POST['usid'],
        ':user_password' => $new_password,
        ':user_password_2' => $_POST['user_password'],
        ':user_prefix' => $_POST['user_prefix'],
        ':user_firstname' => $_POST['user_firstname'],
        ':user_lastname' => $_POST['user_lastname'],
        ':user_id_card' => $_POST['user_id_card'],
        ':user_tel' => $_POST['user_tel'],
        ':user_email' => $_POST['user_email'],
        ':user_code1' => $_POST['user_code1']
      )
    );

    if (isset($_POST['Selecttype_id'])) {
      $qd = "DELETE FROM exam_permission  WHERE user_code=:user_code1";
      $sth = $connSystem->prepare($qd);
      $sth->execute(
        array(
          ':user_code1' => $_POST['user_code1']
        )
      );


      $count = count($_POST['Selecttype_id']);
      for ($i = 0; $i < $count; $i++) {
        $qrc = 'INSERT INTO exam_permission(type_id,user_code,school_id)
    VALUES (:type_id,:user_code,:school_id)';
        $sthc = $connSystem->prepare($qrc);
        $sthc->execute(
          array(
            ':type_id' => $_POST['Selecttype_id'][$i],
            ':user_code' => $_POST['user_code1'],
            ':school_id' => $school_id
          )
        );
        // echo "<center>";
        //   echo $_POST['Selecttype_id'][$i];
        //   echo "</center>";
      }
    }

    $uid = $_POST['usid'];
    echo "<script>";
    echo "location.href = 'dashboard?option=student-edit&us=$uid&success'";
    echo "</script>";
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

<?php

$t1 = $sql_process->mf("5GCGQQ4HNV0R1QTBGKIL", $language_id);
$t2 = $sql_process->mf("M5LG2XXTSR4ZZSW5GD0", $language_id);
?>

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?= $t1 ?> <?= $t2 ?> <u><?php echo  sprintf("%06d", $rowUedit["user_id"]); ?></u></h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

      <div class="row">
        <div class="col-xs-6">
          <label>User Name</label>
          <input type="hidden" class="form-control" name="usid" value="<?php echo $rowUedit['user_id']; ?>">
          <input type="hidden" class="form-control" name="user_code1" value="<?php echo $user_code; ?>">
          <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btn-danger" onClick="disabled(7)">Generate</button>
            </div>
            <input type="text" class="form-control" name="user_name" value="<?php echo $rowUedit['user_name']; ?>" disabled required>
            <span id="mySpan"></span>
          </div>
        </div>
        <div class="col-xs-6">
          <label>Password</label>

          <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btn-danger" onClick="populateform2(7)">Generate</button>
            </div>
            <input type="text" class="form-control" name="user_password" value="<?php echo $rowUedit['user_password_2']; ?>" autocomplete="off" required>
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
              <option value="<?= $rowType['title_name'] ?>" <?php if ($rowType['title_name'] == $rowUedit['user_prefix']) {
                                                            echo "SELECTED";
                                                          } ?>><?= $rowType['title_name'] ?></option>
            <?php } ?>


          </select>
        </div>
        <div class="col-xs-6">
          <label><?= $sql_process->mf("WWJR9XIDFDY2EXSBRVK", $language_id); ?></label>


          <input type="text" class="form-control" name="user_firstname" value="<?php echo $rowUedit['user_firstname']; ?>" required>
        </div>
        <div class="col-xs-6">
          <label><?= $sql_process->mf("O69T91GRZGN979CK7GN", $language_id); ?></label>
          <input type="text" name="user_lastname" class="form-control" value="<?php echo $rowUedit['user_lastname']; ?>" required>
        </div>
        <div class="col-xs-6">
          <label><?= $sql_process->mf("7LI6P12UN6S28B8SF76X", $language_id); ?></label>
          <input type="text" name="user_id_card" class="form-control" required maxlength="13" value="<?php echo $rowUedit['user_id_card']; ?>">
        </div>

        <div class="col-xs-6">
          <label><?= $sql_process->mf("90E6UM80ODZGGCF6NY2", $language_id); ?></label>
          <input type="tel" name="user_tel" class="form-control" value="<?php echo $rowUedit['user_tel']; ?>" required autocomplete="off" data-inputmask='"mask": "9999999999"' data-mask>
          <!-- <input type="tel"  name="user_tel" class="form-control"  data-inputmask='"mask": "(999) 999-9999"' data-mask> -->
        </div>
        <div class="col-xs-6">

          <label><?= $sql_process->mf("X5XQUNFLBBH050X6ORPH", $language_id); ?></label>
          <input type="email" class="form-control" name="user_email" value="<?php echo $rowUedit['user_email']; ?>" autocomplete="off">
        </div>

        <div class="col-xs-12">
          <br>
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

                  $stetab = $connSystem->prepare("SELECT type_id,user_code FROM exam_permission  WHERE user_code = :user_code AND type_id = :type_id AND school_id=:school_id");
                  $stetab->execute(array(':user_code' => $user_code, ':type_id' => $rowType['type_id'], ':school_id' => $school_id));
                  $rowSper = $stetab->fetch(PDO::FETCH_ASSOC);
                ?>
                  <tr>
                    <td align="center">
                      <div class="checkbox">
                        <label style="font-size: 1em">
                          <input type="checkbox" name="Selecttype_id[]" id="typeNUM" value="<?php echo $rowType["type_id"] ?>" <?php if ($rowType['type_id'] == $rowSper["type_id"]) {
                                                                                                                                  echo "checked";
                                                                                                                                } ?>>
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
        </div>

      </div>
      <br>
      <hr>
      <div class="form-group">
        <center>
          <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?= $theme_color ?>;"><?= $ta2 ?></button>
        </center>
      </div>

    </form>
  </div>




</div>