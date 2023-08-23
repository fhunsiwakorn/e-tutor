<?php
if (isset($_POST['btn_primary'])) {
  try {
    $everyday = date("Y-m-d");

    $compair_course = random_password(10);
    $qsc = 'INSERT INTO tbl_school(school_name,school_path_url,number_student,v_program,comment_update,day_create,day_update,compair_course,school_code,school_fanpage,school_fanpage_text,language_id)
  VALUES (:school_name,:school_path_url,:number_student,:v_program,:comment_update,:day_create,:day_update,:compair_course,:school_code,:school_fanpage,:school_fanpage_text,:language_id)';
    $extc = $connSystem->prepare($qsc);
    $extc->execute(
      array(
        ':school_name' => $_POST['school_name'],
        ':school_path_url' => $_POST['school_path_url'],
        ':number_student' => $_POST['number_student'],
        ':v_program' => $_POST['v_program'],
        ':comment_update' => $_POST['comment_update'],
        ':day_create' => $everyday,
        ':day_update' => $everyday,
        ':compair_course' => $compair_course,
        ':school_code' => $_POST['school_code'],
        ':school_fanpage' => $_POST['school_fanpage'],
        ':school_fanpage_text' => $_POST['school_fanpage_text'],
        ':language_id' => $_POST['language_id']
      )
    );

    ///เพิ่มหลักสูตร 

    if (isset($_POST['Selecttype_id'])) {
      $count = count($_POST['Selecttype_id']);
      for ($i = 0; $i < $count; $i++) {
        $qrc = 'INSERT INTO tbl_permission_course(type_id,compair_course)
    VALUES (:type_id,:compair_course)';
        $sthc = $connSystem->prepare($qrc);
        $sthc->execute(
          array(
            ':type_id' => $_POST['Selecttype_id'][$i],
            ':compair_course' => $compair_course
          )
        );
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  $a = $_POST['school_code'];
  echo "<script>";
  echo "location.href = 'dashboard_admin?option=school-data&success'";
  echo "</script>";
}
//Deleate
if (isset($_GET['sc'])) {
  try {
    $qd = "DELETE FROM tbl_school  WHERE school_id=:school_id";
    $sth = $connSystem->prepare($qd);
    $sth->execute(
      array(
        ':school_id' => $_GET['sc']
      )
    );
    //  echo "<script>";
    //  echo "location.href = 'dashboard?option=student-data&success-d'";
    //  echo "</script>";

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
    <h3 class="box-title">ทะเบียนโรงเรียน</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#Addschool">
          <img id="myImg" src="image_system/school_add.png" width="40" height="40">
        </button>
      </div>
    </div>
  </div>
  <br>
  <div class="box-body">

    <div class="box-body table-responsive no-padding">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>รหัสโรงเรียน</th>
            <th>ชื่อโรงเรียน</th>
            <th>ผู้ดูแลระบบ (เจ้าหน้าที่) / คน</th>
            <th>นักเรียน / คน</th>
            <th>โควต้ารับนักเรียน / คน</th>
            <th>จำนวนหลักสูตร</th>
            <th>วันที่สร้าง</th>
            <th>วันที่ปรับปรุง</th>
            <th>จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $stsc = $connSystem->prepare("SELECT * FROM tbl_school    ORDER BY school_id  ASC");
          $stsc->execute();
          $resultArray = array();
          while ($rowSch = $stsc->fetch(PDO::FETCH_ASSOC)) {
            array_push($resultArray, $rowSch);
            $school_id = $rowSch["school_id"];
          ?>
            <tr>
              <td align="center"><?php echo  sprintf("%04d", $rowSch["school_id"]); ?></td>
              <td> <a target="_blank" href="<?php echo $rowSch['school_path_url']; ?>"><?php echo $rowSch['school_name']; ?></a></td>
              <td align="center"> <?php
                                  $auRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='1' AND school_id = '$school_id'")->fetchColumn();
                                  echo "$auRows ";
                                  ?></td>

              <td align="center">
                <?php
                $school_id = $rowSch['school_id'];
                $stuRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND school_id = '$school_id'")->fetchColumn();
                echo "$stuRows ";
                ?>
              </td>
              <td align="center">
                <?php echo $rowSch['number_student']; ?>
              </td>
              <td align="center">
                <?php
                $compair_course = $rowSch['compair_course'];
                $courseRows = $connSystem->query("SELECT count(*) from tbl_permission_course WHERE  compair_course = '$compair_course'")->fetchColumn();
                echo "$courseRows ";
                ?>

              </td>
              <td><?php echo DateThai($rowSch['day_create']); ?></td>
              <td><?php echo DateThai($rowSch['day_update']); ?></td>
              <td align="center">

                <div class="btn-group-vertical">
                  <button type="button" onclick="window.location.href='dashboard_admin?option=school-edit&sc=<?php echo $rowSch['school_id']; ?>'" style="background-color:<?= $theme_color ?>;" class="btn btn-warning">แก้ไข</button>

                  <?php if ($stuRows == '0' && $auRows == '0' && $courseRows == '0') { ?>
                    <button type="button" id='move' Onclick="return move();" class="btn btn-warning" style="background-color:<?= $theme_color ?>;">ลบ</button>
                  <?php } ?>
                </div>

                <script>
                  function move() {
                    swal({
                        title: "ต้องการลบข้อมูล?",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "ใช่!",
                        cancelButtonText: "ไม่ใช่!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          swal("ลบข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                          location.href = 'dashboard_admin?option=school-data&sc=<?php echo $rowSch['school_id']; ?>';
                        } else {
                          swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                        }
                      });
                  }
                </script>

              </td>
            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
          <tr>
            <th>รหัสโรงเรียน</th>
            <th>ชื่อโรงเรียน</th>
            <th>ผู้ดูแลระบบ (เจ้าหน้าที่) / คน</th>
            <th>นักเรียน / คน</th>
            <th>โควต้ารับนักเรียน / คน</th>
            <th>จำนวนหลักสูตร</th>
            <th>วันที่สร้าง</th>
            <th>วันที่ปรับปรุง</th>
            <th>จัดการ</th>
          </tr>
        </tfoot>
      </table>
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


<!-- Modal ADD user school -->
<div class="modal fade" id="Addschool" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <form id="frmMain" name="frmMain" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">เพิ่มโรงเรียน</h4>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-xs-6">
              <label>ชื่อโรงเรียน</label>

              <input type="text" class="form-control" name="school_name" required>
            </div>
            <div class="col-xs-6">
              <label>URL</label>
              <input type="text" name="school_path_url" class="form-control" required>
            </div>
            <div class="col-xs-6">
              <label>โควต้านักเรียน</label>
              <input type="number" name="number_student" class="form-control" required>
            </div>
            <div class="col-xs-6">
              <label>Version โปรแกรม</label>
              <input type="text" name="v_program" class="form-control" required>
            </div>
            <div class="col-xs-6">
              <label>รหัสโรงเรียน (school_code)</label>
              <input type="text" name="school_code" class="form-control" required>
            </div>
            <div class="col-xs-6">
              <label>Facebook Fanpage</label>
              <input type="text" name="school_fanpage" class="form-control" required>
            </div>
            <div class="col-xs-6">
              <label>ข้อความเชิญชวนกด like</label>
              <input type="text" name="school_fanpage_text" class="form-control" required>
            </div>
            <div class="col-xs-12">
              <label>รายละเอียดอัพเดทโปรแกรม</label>
              <textarea name="comment_update" style="width:100%;height:75px"></textarea>
            </div>

            <div class="col-xs-6">
              <label>ภาษา</label>
              <select name="language_id" id="language_id" class="form-control">
                <?php
                $stype = $connSystem->prepare("SELECT language_id, language_name FROM tbl_exam_language   ORDER BY language_id  ASC");
                $stype->execute();
                while ($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

                ?>
                  <option value="<?= $rowType['language_id'] ?>"><?= $rowType['language_name'] ?></option>
                <?php } ?>

              </select>

            </div>

            <div class="col-xs-12">
              <label>กำหนดหลักสูตร</label>
              <table class="table table-bordered table-striped">
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
                  $stype = $connSystem->prepare("SELECT * FROM exam_type WHERE  type_status='1' ORDER BY type_id  ASC");
                  $stype->execute();
                  while ($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
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
                            <input type="checkbox" name="Selecttype_id[]" id="typeNUM" value="<?php echo $rowType["type_id"] ?>">
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
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
          <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?= $theme_color ?>;">บันทึกข้อมูล</button>
        </div>
      </div>
    </form>
  </div>
</div>