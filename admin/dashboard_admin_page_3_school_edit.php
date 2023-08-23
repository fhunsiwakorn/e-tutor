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
$ste = $connSystem->prepare("SELECT * FROM tbl_school  WHERE school_id = :school_id");
$ste->execute(array(':school_id' => $_GET['sc']));
$rowScedit = $ste->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['btn_primary'])) {
  $school_id = $_POST['school_id'];
  $total_student = $connSystem->query("SELECT count(school_id) FROM user_member_group WHERE user_status='2' AND user_date_status!='2' AND school_id='$school_id'")->fetchColumn();
  $number_student = $total_student + $_POST['number_student'];
  try {
    $everyday = date("Y-m-d");
    $q = "UPDATE tbl_school SET
     school_name=:school_name,
     school_path_url=:school_path_url,
     number_student=:number_student,
     v_program=:v_program,
     comment_update=:comment_update,
     day_update=:day_update,
     school_code=:school_code,
     school_fanpage=:school_fanpage,
     school_fanpage_text=:school_fanpage_text,
     language_id=:language_id
     WHERE school_id=:school_id_param";
    $sth = $connSystem->prepare($q);
    $sth->execute(
      array(
        ':school_id_param' => $_POST['school_id'],
        ':school_name' => $_POST['school_name'],
        ':school_path_url' => $_POST['school_path_url'],
        ':number_student' => $number_student,
        ':v_program' => $_POST['v_program'],
        ':comment_update' => $_POST['comment_update'],
        ':day_update' => $everyday,
        ':school_code' => $_POST['school_code'],
        ':school_fanpage' => $_POST['school_fanpage'],
        ':school_fanpage_text' => $_POST['school_fanpage_text'],
        ':language_id' => $_POST['language_id']

      )
    );
    ///เพิ่มหลักสูตร
    if (!empty($_POST['Selecttype_id'])) {
      $qd = "DELETE FROM tbl_permission_course  WHERE compair_course=:compair_course";
      $sth = $connSystem->prepare($qd);
      $sth->execute(
        array(
          ':compair_course' => $_POST['compair_course']
        )
      );

      $count = count($_POST['Selecttype_id']);
      for ($i = 0; $i < $count; $i++) {


        $qrc = 'INSERT INTO tbl_permission_course(type_id,compair_course)
     VALUES (:type_id,:compair_course)';
        $sthc = $connSystem->prepare($qrc);
        $sthc->execute(
          array(
            ':type_id' => $_POST['Selecttype_id'][$i],
            ':compair_course' => $_POST['compair_course']
          )
        );
      }
    }

    $sc = $_POST['school_id'];
    echo "<script>";
    echo "location.href = 'dashboard_admin?option=school-edit&sc=$sc&success'";
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

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">แก้ไข <u><?php echo $rowScedit['school_name']; ?> </u> </h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

      <div class="row">
        <input type="hidden" class="form-control" name="school_id" value="<?php echo $rowScedit['school_id']; ?>">
        <input type="hidden" class="form-control" name="compair_course" value="<?php echo $rowScedit['compair_course']; ?>">
        <div class="col-xs-6">

          <label>ชื่อโรงเรียน</label>
          <input type="text" class="form-control" name="school_name" value="<?php echo $rowScedit['school_name']; ?>" required>

        </div>
        <div class="col-xs-6">

          <label>URL</label>
          <input type="text" class="form-control" name="school_path_url" value="<?php echo $rowScedit['school_path_url']; ?>" required>

        </div>
        <div class="col-xs-6">
          <label>โควต้านักเรียน</label>
          <input type="number" name="number_student" class="form-control" value="<?php echo $rowScedit['number_student']; ?>" required>
        </div>
        <div class="col-xs-6">
          <label>Version โปรแกรม</label>
          <input type="text" name="v_program" class="form-control" value="<?php echo $rowScedit['v_program']; ?>" required>
        </div>
        <div class="col-xs-6">
          <label>รหัสโรงเรียน (school_code)</label>
          <input type="text" name="school_code" class="form-control" value="<?php echo $rowScedit['school_code']; ?>" required>
        </div>

        <div class="col-xs-6">
          <label>Facebook Fanpage</label>
          <input type="text" name="school_fanpage" class="form-control" value="<?php echo $rowScedit['school_fanpage']; ?>" required>
        </div>
        <div class="col-xs-6">
          <label>ข้อความเชิญชวนกด like</label>
          <input type="text" name="school_fanpage_text" class="form-control" required value="<?php echo $rowScedit['school_fanpage_text']; ?>">
        </div>

        <div class="col-xs-6">
          <label>วันที่สร้าง</label>
          <input type="text" class="form-control" value="<?php echo DateThai($rowScedit['day_create']); ?>" readonly>
        </div>

        <div class="col-xs-12">
          <label>รายละเอียดอัพเดทโปรแกรม</label>
          <textarea name="comment_update" style="width:100%;height:75px"><?php echo $rowScedit['comment_update']; ?></textarea>
        </div>

        <div class="col-xs-6">
          <label>ภาษา</label>
          <select name="language_id" id="language_id" class="form-control">
            <?php
            $stype = $connSystem->prepare("SELECT language_id, language_name FROM tbl_exam_language   ORDER BY language_id  ASC");
            $stype->execute();
            while ($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

            ?>
              <option value="<?= $rowType['language_id'] ?>" <?php if ($rowType['language_id'] == $rowScedit['language_id']) {
                                                              echo "SELECTED";
                                                            } ?>><?= $rowType['language_name'] ?></option>
            <?php } ?>

          </select>

        </div>

        <div class="col-xs-12">
          <label>กำหนดหลักสูตร</label>
          <table id="" class="table table-bordered table-striped">
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
                <th>รหัสหลักสูตร</th>
                <th>รูปภาพหลักสูตร</th>
                <th>ชื่อหลักสูตร</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stype = $connSystem->prepare(
                "SELECT
exam_type.type_id,
exam_type.type_pic,
exam_type.type_name
FROM
exam_type
WHERE  type_status='1'"
              );
              $stype->execute();
              while ($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
                $stetab = $connSystem->prepare("SELECT type_id,compair_course FROM tbl_permission_course  WHERE type_id = :type_id AND compair_course = :compair_course");
                $stetab->execute(array(':type_id' => $rowType['type_id'], ':compair_course' => $rowScedit['compair_course']));
                $rowSper = $stetab->fetch(PDO::FETCH_ASSOC);
                $type_id = $rowType['type_id'];
                if (!empty($rowType['type_pic'])) {
                  $cimg = $rowType['type_pic'];
                } else {
                  $cimg = "image_system/noimage.gif";
                }
              ?>
                <tr>
                  <td align="center">
                    <div class="checkbox">
                      <label style="font-size: 1em">
                        <input type="checkbox" name="Selecttype_id[]" id="typeNUM" value="<?php echo $rowType["type_id"] ?>" <?php if ($rowScedit['compair_course'] == $rowSper["compair_course"]) {
                                                                                                                                echo "checked";
                                                                                                                              } ?>>
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                      </label>
                    </div>

                  </td>
                  <td align="center"><?php echo  sprintf("%04d", $rowType["type_id"]); ?></td>
                  <td align="center"><img id="myImg" src="<?= $cimg ?>" alt="<?php echo $rowType['type_name']; ?>" width="45" height="45" style="border-radius:100px"></td>
                  <td><?php echo $rowType['type_name']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>รหัสหลักสูตร</th>
                <th>รูปภาพหลักสูตร</th>
                <th>ชื่อหลักสูตร</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <br>
      <hr>
      <div class="col-xs-12">
        <center>
          <div class="checkbox">
            <label style="font-size: 1em"> ยืนยันการแก้ไขข้อมูล
              <INPUT type="checkbox" name="confirm" required />
              <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            </label>
          </div>
        </center>
      </div>
      <div class="col-xs-12">
        <center>
          <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?= $theme_color ?>;">บันทึกข้อมูล</button>
        </center>
      </div>

    </form>
  </div>




</div>