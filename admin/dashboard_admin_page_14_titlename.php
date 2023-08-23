<?php
if(isset($_POST['btn_primary'])){
  try {
$dateC=date("Y-m-d");
  $qsc = 'INSERT INTO tbl_master_titlename(title_name,language_id,title_status)
  VALUES (:title_name,:language_id,:title_status)';
  $extc = $connSystem->prepare($qsc);
  $extc->execute(
        Array(
               ':title_name' => strip_tags($_POST['title_name']),
               ':language_id' =>strip_tags($_POST['language_id']),
               ':title_status' => strip_tags($_POST['title_status'])

        ) 
  );
      }catch(PDOException $e) {
          echo $e->getMessage();
      }
      echo "<script>";
      echo "location.href = 'dashboard_admin?option=titlename&success'";
      echo "</script>";
    }
      ?>

      <?php
      // DELETE
      if(isset($_GET['delTitle'])){
        try {
        $qd = "DELETE FROM tbl_master_titlename  WHERE title_id=:title_id";
        $sth = $connSystem->prepare($qd);
        $sth->execute(
              Array(
                     ':title_id' => strip_tags($_GET['delTitle'])
              )
        );
  

            }catch(PDOException $e) {
                echo $e->getMessage();
            }
            echo "<script>";
            echo "location.href = 'dashboard_admin?option=titlename&success'";
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
    <h3 class="box-title">คำนำหน้าชื่อ</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
      <button  type="button" style="background-color:<?=$theme_color?>;" class="btn btn-success" data-toggle="modal" data-target="#AddCourse">
      เพิ่มคำนำหน้าชื่อ
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
          <th>คำนำหน้าชื่อ</th>
        <th>สำหรับภาษา</th>
          <th>จัดการ</th>
        </tr>
        </thead>
        <tbody>
<?php
$i=0;
$stype = $connSystem->prepare("SELECT
 tbl_master_titlename.title_id,
 tbl_master_titlename.title_name,
 tbl_master_titlename.language_id,
 tbl_master_titlename.title_status,
 tbl_exam_language.language_name
 FROM 
 tbl_master_titlename,
 tbl_exam_language
 WHERE 
 tbl_master_titlename.language_id =  tbl_exam_language.language_id 
  ORDER BY 
 tbl_master_titlename.language_id ASC,
  tbl_master_titlename.title_id ASC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
//   if(!empty($rowType['language_img'])){
//     $cimg=$rowType['language_img'];
//     }else {
//     $cimg="image_system/noimage.gif";
//     }

  $i++;
?>
        <tr>
          <td align="center"><?php echo   $i; ?></td>
          <td><?=$rowType['title_name'];?></td>
          <td><?=$rowType['language_name'];?></td>
         
          <td  align="center">

             <div class="btn-group-vertical">
            <button type="button" onclick="window.location.href='dashboard_admin?option=titlename-edit&editTitle=<?php echo $rowType['title_id']; ?>'"  class="btn btn-success" style="background-color:<?=$theme_color?>;">แก้ไข</button>
          
            <a   href="dashboard_admin?option=titlename&delTitle=<?php echo $rowType['title_id']; ?>"  onclick="return confirm('ยืนยันการลบข้อมูล')"   class="btn btn-success" style="background-color:<?=$theme_color?>;">ลบ</a>
         
            </div>

                    

          </td>

        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
        <th>ลำดับ</th>
          <th>คำนำหน้าชื่อ</th>
        <th>สำหรับภาษา</th>
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
        <h4 class="modal-title" id="myModalLabel">คำนำหน้าชื่อ</h4>
      </div>
      <div class="modal-body">
        <div class="row">

            
                <div class="col-xs-6">
                  <label>คำนำหน้าชื่อ</label>
                  <input type="text" name="title_name" class="form-control" required>
                </div>
                <div class="col-xs-6">
                  <label>สำหรับภาษา</label>

  <select name="language_id" id="language_id"  class="form-control">

<?php
$stype = $connSystem->prepare("SELECT language_id,language_name FROM tbl_exam_language ORDER BY language_id  ASC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

?>
  <option value="<?=$rowType['language_id']?>"><?=$rowType['language_name']?></option>
<?php } ?>

</select>

                </div>

                <div class="col-xs-6">
                  <label>สถานะ</label>
                    <select class="form-control" name="title_status" >
                    <option value="1">เปิด</option>
                    <option value="2">ปิด</option>
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
