<?php
if(isset($_POST['btn_primary'])){
  try {
$dateC=date("Y-m-d");
  $qsc = 'INSERT INTO exam_type(type_name,type_detail,type_pic,type_date,type_status,language_id,type_group_id)
  VALUES (:type_name,:type_detail,:type_pic,:type_date,:type_status,:language_id,:type_group_id)';
  $extc = $connSystem->prepare($qsc);
  $extc->execute(
        Array(
               ':type_name' => $_POST['type_name'],
               ':type_detail' => $_POST['type_detail'],
               ':type_pic' => $_POST['type_pic'],
               ':type_date' => $dateC,
               ':type_status' => $_POST['type_status'],
               ':language_id' => $_POST['language_id'],
               ':type_group_id' => $_POST['type_group_id']

        )
  );
      }catch(PDOException $e) {
          echo $e->getMessage();
      }
      echo "<script>";
      echo "location.href = 'dashboard_admin?option=course&success'";
      echo "</script>";
    }
      ?>
      <?php
      //Deleate
      if(isset($_GET['excd'])){
        try {
        $qd = "DELETE FROM exam_type  WHERE type_id=:type_id_d";
        $sth = $connSystem->prepare($qd);
        $sth->execute(
              Array(
                     ':type_id_d' => $_GET['excd']
              )
        );
        //  echo "<script>";
        //  echo "location.href = 'dashboard?option=student-data&success-d'";
        //  echo "</script>";

            }catch(PDOException $e) {
                echo $e->getMessage();
            }


      }
      ?>
      <?php
      if(isset($_GET['success'])){
       ?>
       <script>
      	swal("บันทึกข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
       </script>
      <?php } ?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">ทะเบียนข้อสอบ</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
      <button  type="button" style="background-color:<?=$theme_color?>;" class="btn btn-success" data-toggle="modal" data-target="#AddCourse">
      เพิ่มหลักสูตร
      </button>

      </div>
    </div>
  </div>
  <div class="box-body">

    <div class="box-body table-responsive no-padding">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>รหัสหลักสูตร</th>
          <th>รูปภาพหลักสูตร</th>
          <th>ชื่อหลักสูตร</th>
          <th>ภาษา</th>
          <th>ประเภทรถ</th>
          <th>รายละเอียด</th>
          <th>จำนวนข้อสอบ</th>
          <th>ปรับปรุงล่าสุด</th>
          <th>สถานะ</th>
          <th>จัดการ</th>
        </tr>
        </thead>
        <tbody>
<?php
$stype = $connSystem->prepare("SELECT * FROM exam_type  ORDER BY type_id  DESC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
$type_id=$rowType['type_id'];
if(!empty($rowType['type_pic'])){
$cimg=$rowType['type_pic'];
}else {
$cimg="image_system/noimage.gif";
}

$ste = $connSystem->prepare("SELECT language_name FROM tbl_exam_language  WHERE language_id ='".$rowType['language_id']."'");
$ste->execute();
$rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);
$language_name=$rowCeedit["language_name"];

$ste1 = $connSystem->prepare("SELECT type_group_id,type_group_name FROM tbl_vehicle_type  WHERE type_group_id ='".$rowType['type_group_id']."'");
$ste1->execute();
$rowCeedit1 = $ste1->fetch(PDO::FETCH_ASSOC);
$type_group_name=$rowCeedit1["type_group_name"];
?>
        <tr>
          <td align="center"><?php echo  sprintf("%04d", $rowType["type_id"]); ?></td>
          <td  align="center"><img id="myImg"  src="<?=$cimg?>" alt="<?php echo $rowType['type_name']; ?>" width="45" height="45" style="border-radius:100px"></td>
          <td><?php echo $rowType['type_name'];?></td>
          <td><?=$language_name?></td>
          <td><?=$type_group_name?></td>
          <td><?php echo $rowType['type_detail'];?></td>
          <td  align="center">
            <?php

          $examRows = $connSystem->query("SELECT count(*) from exam_question WHERE  type_id='$type_id'")->fetchColumn();
          echo "$examRows ";
            ?>
          </td>
          <td  align="center">
<?php  $strDate = $rowType['type_date']; echo DateThai($strDate); ?>
          </td>
          <td  align="center">
            <?php
            if($rowType['type_status']=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิดหลักสูตร"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowType['type_status']=='2') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิดหลักสูตร"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>
          </td>
          <td  align="center">

             <div class="btn-group-vertical">
            <button type="button" onclick="window.location.href='dashboard_admin?option=exam-co-edit&exce=<?php echo $rowType['type_id']; ?>'"  class="btn btn-success" style="background-color:<?=$theme_color?>;">แก้ไข</button>
            <button type="button" onclick="window.location.href='dashboard_admin?option=exam-data&exce=<?php echo $rowType['type_id']; ?>'"  class="btn btn-success" style="background-color:<?=$theme_color?>;">เพิ่มข้อสอบ</button>

            <button type="button" id='move2'  onclick="window.location.href='dashboard_admin?option=course&excd=<?php echo $rowType['type_id']; ?>'"   <?php if($examRows>='1'){echo "disabled"; }?>  class="btn btn-success" style="background-color:<?=$theme_color?>;">ลบ</button>

            </div>
<!--
                        <script>
                        function move2() {
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
                          function(isConfirm){
                            if (isConfirm) {
                              swal("ลบข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                            location.href = 'dashboard_admin?option=course&excd=<?php echo $rowType['type_id']; ?>';
                            } else {
                              swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                            }
                          });
                        }
                        </script> -->

          </td>

        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
        <th>รหัสหลักสูตร</th>
          <th>รูปภาพหลักสูตร</th>
          <th>ชื่อหลักสูตร</th>
          <th>ภาษา</th>
          <th>ประเภทรถ</th>
          <th>รายละเอียด</th>
          <th>จำนวนข้อสอบ</th>
          <th>ปรับปรุงล่าสุด</th>
          <th>สถานะ</th>
          <th>จัดการ</th>
        </tr>
        </tfoot>
      </table>
  </div>


  </div>
  <!-- /.box-body -->
</div>

<!-- Modal ADD user student -->
<div class="modal fade" id="AddCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
 <form id="frmMain" name="frmMain" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มหลักสูตร</h4>
      </div>
      <div class="modal-body">
        <div class="row">

                 <div class="col-xs-6">
                  <label>รูปภาพหลักสูตร (Path URL)</label>

                  <input type="text" class="form-control" name="type_pic">
                </div>
                <div class="col-xs-6">
                  <label>ชื่อหลักสูตร</label>
                  <input type="text" name="type_name" class="form-control" required>
                </div>
                <div class="col-xs-6">
                  <label>รายละเอียด</label>
                  <input type="text" name="type_detail" class="form-control">
                </div>
                <div class="col-xs-6">
                  <label>ภาษา</label>
                  <select class="form-control" name="language_id">
                     <?php
                        echo "<option value=''>--เลือกภาษา--</option>" ;
                     $rcp = $connSystem->prepare("SELECT language_id, language_name FROM tbl_exam_language  ORDER By language_id DESC");
                     $rcp->execute();
                     while($rowRCP = $rcp->fetch(PDO::FETCH_ASSOC)) {
                     $language_id=  $rowRCP['language_id'];
                     $language_name=$rowRCP['language_name'];

                     echo "<option value='$language_id'>$language_name</option>" ;
                   }
                   ?>
                    </select>
                </div>

                <div class="col-xs-6">
                  <label>ประเภทรถ</label>
                  <select class="form-control" name="type_group_id">
                  <?php
                        echo "<option value=''>--เลือกประเภทรถ--</option>" ;
                     $rcp1 = $connSystem->prepare("SELECT type_group_id, type_group_name FROM tbl_vehicle_type  ORDER By vt_id DESC");
                     $rcp1->execute();
                     while($rowRCP1 = $rcp1->fetch(PDO::FETCH_ASSOC)) {
                     $type_group_id=  $rowRCP1['type_group_id'];
                     $type_group_name=$rowRCP1['type_group_name'];

                     echo "<option value='$type_group_id'>$type_group_name</option>" ;
                   }
                   ?>
                    </select>
                </div> 

                <div class="col-xs-6">
                  <label>สถานะ</label>
                    <select class="form-control" name="type_status" >
                    <option value="1">เปิดหลักสูตร</option>
                    <option value="2">ปิดหลักสูตร</option>
                    </select>

                </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
        <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?=$theme_color?>;">บันทึกข้อมูล</button>
      </div>
    </div>
  </form>
  </div>
</div>
