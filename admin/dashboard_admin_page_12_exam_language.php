<?php
if(isset($_POST['btn_primary'])){
  try {
$dateC=date("Y-m-d");
  $qsc = 'INSERT INTO tbl_exam_language(language_name,language_code,language_img,school_id)
  VALUES (:language_name,:language_code,:language_img,:school_id)';
  $extc = $connSystem->prepare($qsc);
  $extc->execute(
        Array(
               ':language_name' => strip_tags($_POST['language_name']),
               ':language_code' =>strip_tags($_POST['language_code']),
               ':language_img' => strip_tags($_POST['language_img']),
               ':school_id' => 0

        ) 
  );
      }catch(PDOException $e) {
          echo $e->getMessage();
      }
      echo "<script>";
      echo "location.href = 'dashboard_admin?option=exam_language&success'";
      echo "</script>";
    }
      ?>

      <?php
      // DELETE
      if(isset($_GET['excd'])){
        try {
        $qd = "DELETE FROM tbl_exam_language  WHERE language_id=:language_id";
        $sth = $connSystem->prepare($qd);
        $sth->execute(
              Array(
                     ':language_id' => $_GET['excd']
              )
        );
  

            }catch(PDOException $e) {
                echo $e->getMessage();
            }
            echo "<script>";
            echo "location.href = 'dashboard_admin?option=exam_language&success'";
            echo "</script>";

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
    <h3 class="box-title">ภาษาที่ใช้ในการสอบและในระบบ</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
      <button  type="button" style="background-color:<?=$theme_color?>;" class="btn btn-success" data-toggle="modal" data-target="#AddCourse">
      เพิ่มภาษา
      </button>

      </div>
    </div>
  </div>
  <div class="box-body">

    <div class="box-body table-responsive no-padding">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ลำดับ</th>
          <th>รูปภาพ</th>
          <th>ภาษา</th>
          <th>โค้ด</th>
          <th>จัดการ</th>
        </tr>
        </thead>
        <tbody>
<?php
$i=0;
$stype = $connSystem->prepare("SELECT * FROM tbl_exam_language  ORDER BY language_id  ASC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
  if(!empty($rowType['language_img'])){
    $cimg=$rowType['language_img'];
    }else {
    $cimg="image_system/noimage.gif";
    }
    
  $examRows = $connSystem->query("SELECT count(*) from exam_type WHERE language_id='".$rowType['language_id']."'")->fetchColumn();
  $examRows1 = $connSystem->query("SELECT count(*) from tbl_system_language WHERE language_id='".$rowType['language_id']."'")->fetchColumn();
  $i++;
?>
        <tr>
          <td align="center"><?php echo   $i; ?></td>
          <td  align="center"><img id="myImg"  src="<?=$cimg?>" alt="<?php echo $rowType['language_code']; ?>" width="45" height="30"></td>
          <td><?=$rowType['language_name'];?></td>
          <td><?=$rowType['language_code'];?></td>
         
          <td  align="center">

             <div class="btn-group-vertical">
            <button type="button" onclick="window.location.href='dashboard_admin?option=exam-language-edit&editlanguage=<?php echo $rowType['language_id']; ?>'"  class="btn btn-success" style="background-color:<?=$theme_color?>;">แก้ไข</button>
            <?php if($examRows<='0' && $examRows1<='0'  ){?>
            <a   href="dashboard_admin?option=exam_language&excd=<?php echo $rowType['language_id']; ?>"  onclick="return confirm('ยืนยันการลบข้อมูล')"   class="btn btn-success" style="background-color:<?=$theme_color?>;">ลบ</a>
            <?php } ?>
            </div>

                    

          </td>

        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
        <th>ลำดับ</th>
          <th>รูปภาพ</th>
          <th>ภาษา</th>
          <th>โค้ด</th>
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
        <h4 class="modal-title" id="myModalLabel">ภาษาที่ใช้ในการสอบและในระบบ</h4>
      </div>
      <div class="modal-body">
        <div class="row">

            
                <div class="col-xs-6">
                  <label>ภาษา</label>
                  <input type="text" name="language_name" class="form-control" required>
                </div>
                <div class="col-xs-6">
                  <label>โค้ด</label>
                  <input type="text" name="language_code" class="form-control">
                </div>

                <div class="col-xs-12">
                  <label>รูป</label>
                  <input type="text" name="language_img" class="form-control">
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
