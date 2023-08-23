<?php


///Insert


if(isset($_POST['btn_primary'])){
  $stlg_code = random_password(20);
  try {
    $count=count($_POST['language_id']);
    for($i=0;$i<$count;$i++){
    // $qd = "UPDATE user_member_group SET user_date_status=:user_date_status  WHERE user_id=:user_id";
    $language_id=$_POST['language_id'][$i];
    $stlg_text=$_POST['stlg_text'][$i];

    if(!empty($language_id) && !empty($stlg_text)){
    $qsc = 'INSERT INTO tbl_system_language(stlg_text,stlg_code,language_id)
    VALUES (:stlg_text,:stlg_code,:language_id)';
    $extc = $connSystem->prepare($qsc);
    $extc->execute(
          Array(
                 ':stlg_text' => strip_tags($stlg_text),
                 ':stlg_code' => $stlg_code,
                 ':language_id' => strip_tags($language_id)
  
          )
    );
  }

  

    }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }

        echo "<script>";
        echo "location.href = 'dashboard_admin?option=setting_language_systems&success'";
        echo "</script>";


    }
     




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
    <h3 class="box-title">รายละเอียดภาษาที่แสดงในระบบ</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
      <!-- <button  type="button" style="background-color:<?=$theme_color?>;" class="btn btn-success" data-toggle="modal" data-target="#AddCourse">
      เพิ่มเมนูการใช้งานระบบในแต่ละภาษา
      </button> -->

      </div>
    </div>
  </div>
  <div class="box-body">

    <div class="box-body table-responsive no-padding">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ลำดับ</th>
          <th>คำหรือเมนูที่ใช้ในระบบ</th>
          <th>โค้ด</th>
          <th>จัดการ</th>
        </tr>
        </thead>
        <tbody>
<?php
$i=0;
$stype = $connSystem->prepare("SELECT stlg_code FROM tbl_system_language GROUP BY stlg_code  ORDER BY stlg_id  ASC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

  $ste = $connSystem->prepare("SELECT  tbl_system_language.stlg_text, tbl_exam_language.language_name FROM tbl_system_language,tbl_exam_language  WHERE tbl_system_language.language_id=tbl_exam_language.language_id AND tbl_system_language.stlg_code=:stlg_code");
  $ste->execute(array(':stlg_code'=>$rowType['stlg_code']));
  // $rowCe = $ste->fetch(PDO::FETCH_ASSOC);
  $data_toppic = $ste->fetchAll();
  // $examRows = $connSystem->query("SELECT count(*) from exam_type WHERE language_id='".$rowType['language_id']."'")->fetchColumn();
  $i++;
?>
        <tr>
          <td align="center"><?php echo   $i; ?></td>
  
          <td>
           
          <?php
          foreach ($data_toppic as $value) {
            echo $value["language_name"]."&nbsp;"." : ". $value["stlg_text"]."<br>";
        }
      
        ?> 
        </td>
          <td><?=$rowType['stlg_code'];?></td>
         
          <td  align="center">

             <div class="btn-group-vertical">
            <button type="button" onclick="window.location.href='dashboard_admin?option=setting_language_systems_edit&edcstlg=<?php echo $rowType['stlg_code']; ?>'"  class="btn btn-success" style="background-color:<?=$theme_color?>;">แก้ไข</button>
           
         
            </div>

                    

          </td>

        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
        <th>ลำดับ</th>
          <th>คำหรือเมนูที่ใช้ในระบบ</th>
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
        <h4 class="modal-title" id="myModalLabel">เพิ่มเมนูการใช้งานระบบในแต่ละภาษา</h4>
      </div>
      <div class="modal-body">
        <div class="row">

        <?php
$stml = $connSystem->prepare("SELECT language_id,language_name FROM tbl_exam_language  ORDER BY language_id  ASC");
$stml->execute();
while($rowlan= $stml->fetch(PDO::FETCH_ASSOC)) {
            ?>
             <input type="hidden" name="language_id[]" value="<?=$rowlan["language_id"]?>">
                <div class="col-xs-6">
                  <label>ภาษา : <?=$rowlan["language_name"]?></label>
                  <input type="text" name="stlg_text[]" class="form-control">
                </div>
         <?php } ?>     
         
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
        <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?=$theme_color?>;">บันทึกข้อมูล</button>
      </div>
    </div>
  </form>
  </div>
</div>
