<?php
$ste = $connSystem->prepare("SELECT * FROM tbl_exam_language  WHERE language_id = :language_id");
$ste->execute(array(':language_id'=>$_GET['editlanguage']));
$rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);


 if(isset($_POST['btn_primary'])){
 try {
$dateC=date("Y-m-d");

 $q = "UPDATE tbl_exam_language SET
     language_name=:language_name,
     language_code=:language_code,
     language_img=:language_img
     WHERE language_id=:language_id";
 $sth = $connSystem->prepare($q);
 $sth->execute(
       Array(
             ':language_name' => strip_tags($_POST['language_name']),
              ':language_code' => strip_tags($_POST['language_code']),
              ':language_img' => strip_tags($_POST['language_img']),
              ':language_id' => strip_tags($_POST['language_id'])
       )
 );
 $exce=strip_tags($_POST['language_id']);
  echo "<script>";
  echo "location.href = 'dashboard_admin?option=exam_language&success'";
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
    <h3 class="box-title">แก้ไขภาษา</h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

           <div class="row">
<input type="hidden" class="form-control" name="language_id" value="<?php echo $rowCeedit['language_id'];?>" >


<div class="col-xs-6">
                  <label>ภาษา</label>
                  <input type="text" name="language_name" class="form-control" required value="<?php echo $rowCeedit['language_name'];?>">
                </div>
                <div class="col-xs-6">
                  <label>โค้ด</label>
                  <input type="text" name="language_code" class="form-control" value="<?php echo $rowCeedit['language_code'];?>">
                </div>

                
                <div class="col-xs-12">
                  <label>รูป</label>
                  <input type="text" name="language_img" class="form-control" value="<?php echo $rowCeedit['language_img'];?>">
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
