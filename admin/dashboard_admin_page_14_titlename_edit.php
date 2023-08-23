<?php
$ste = $connSystem->prepare("SELECT * FROM tbl_master_titlename  WHERE title_id = :title_id");
$ste->execute(array(':title_id'=>$_GET['editTitle']));
$rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);


 if(isset($_POST['btn_primary'])){
 try {
$dateC=date("Y-m-d");

 $q = "UPDATE tbl_master_titlename SET
     title_name=:title_name,
     language_id=:language_id,
     title_status=:title_status
     WHERE title_id=:title_id";
 $sth = $connSystem->prepare($q);
 $sth->execute(
       Array(
             ':title_id' => strip_tags($_POST['title_id']),
              ':title_name' => strip_tags($_POST['title_name']),
              ':language_id' => strip_tags($_POST['language_id']),
              ':title_status' => strip_tags($_POST['title_status'])
       )
 );

  echo "<script>";
  echo "location.href = 'dashboard_admin?option=titlename&success'";
  echo "</script>";
  }   catch(PDOException $e) {
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
    <h3 class="box-title">แก้ไขคำนำหน้า</h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

           <div class="row">
<input type="hidden" class="form-control" name="title_id" value="<?php echo $rowCeedit['title_id'];?>" >


<div class="col-xs-6">
                  <label>คำนำหน้าชื่อ</label>
                  <input type="text" name="title_name" class="form-control" required value="<?php echo $rowCeedit['title_name'];?>" >
                </div>
                <div class="col-xs-6">
                  <label>สำหรับภาษา</label>

  <select name="language_id" id="language_id"  class="form-control">

<?php
$stype = $connSystem->prepare("SELECT language_id,language_name FROM tbl_exam_language ORDER BY language_id  ASC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

?>
  <option value="<?=$rowType['language_id']?>"  <?php if($rowCeedit['language_id'] ==$rowType['language_id']) { echo "SELECTED";} ?>><?=$rowType['language_name']?></option>
<?php } ?>

</select>

                </div>

                <div class="col-xs-6">
                  <label>สถานะ</label>
                    <select class="form-control" name="title_status" >
                    <option value="1" <?php if($rowCeedit['title_status'] ==1) { echo "SELECTED";} ?>>เปิด</option>
                    <option value="2" <?php if($rowCeedit['title_status'] ==2) { echo "SELECTED";} ?>>ปิด</option>
                    </select>

                </div>



                </div>
               <br><hr>
               <div class="form-group">
                 <center>
               <button type="submit" class="btn btn-primary" style="background-color:<?=$theme_color?>;" name="btn_primary">บันทึกข้อมูล</button>
             </center>
                  </div>

                </form>
         </div>




  </div>
