<?php
$ste = $connSystem->prepare("SELECT stlg_code FROM tbl_system_language  WHERE stlg_code = :stlg_code");
$ste->execute(array(':stlg_code'=>$_GET['edcstlg']));
$rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);


 if(isset($_POST['btn_primary'])){


    $stlg_code = strip_tags($_POST['stlg_code']);

    // ตรวจสอบว่าเคยมีในฐานข้อมูลหรือไม่

    try {
      $count=count($_POST['language_id']);
      for($i=0;$i<$count;$i++){
      $language_id=$_POST['language_id'][$i];
      $stlg_text=$_POST['stlg_text'][$i];
      $chkRow = $connSystem->query("SELECT count(*) from tbl_system_language WHERE language_id='$language_id' AND stlg_code='$stlg_code'")->fetchColumn();
      if(!empty($language_id) && !empty($stlg_text)){
      
      if($chkRow<=0){
            $qsc = 'INSERT INTO tbl_system_language(stlg_text,stlg_code,language_id)
            VALUES (:stlg_text,:stlg_code,:language_id)';
            $extc = $connSystem->prepare($qsc);
            $extc->execute(
                  Array(
                         ':stlg_text' => strip_tags($stlg_text),
                         ':stlg_code' => strip_tags($stlg_code),
                         ':language_id' => strip_tags($language_id)
          
                  )
            );
        }else{


            $q = "UPDATE tbl_system_language SET
            stlg_text=:stlg_text
            WHERE 
            language_id=:language_id AND
            stlg_code=:stlg_code";
        $sth = $connSystem->prepare($q);
        $sth->execute(
            Array(
                ':stlg_text' => strip_tags($stlg_text),
                ':stlg_code' => strip_tags($stlg_code),
                ':language_id' => strip_tags($language_id)
 
         )
        );

        }

    }

  
      }
          }catch(PDOException $e) {
              echo $e->getMessage();
          }
  
          echo "<script>";
          echo "location.href = 'dashboard_admin?option=setting_language_systems&success'";
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
    <h3 class="box-title">แก้ไขภาษา</h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

           <div class="row">
<input type="hidden" class="form-control" name="stlg_code" value="<?php echo $rowCeedit['stlg_code'];?>" >

<?php
$stml = $connSystem->prepare("SELECT 
tbl_exam_language.language_id,
tbl_exam_language.language_name 
FROM 
tbl_exam_language 

ORDER BY language_id  ASC");
 $stml->execute(array(':stlg_code'=>$rowCeedit['stlg_code']));
while($rowlan= $stml->fetch(PDO::FETCH_ASSOC)) {

$ste2 = $connSystem->prepare("SELECT stlg_text FROM tbl_system_language  WHERE stlg_code = :stlg_code AND language_id=:language_id");
$ste2->execute(array(':stlg_code'=>$_GET['edcstlg'],':language_id'=>$rowlan["language_id"]));
$rowCeedit2 = $ste2->fetch(PDO::FETCH_ASSOC);
            ?>
             <input type="hidden" name="language_id[]" value="<?=$rowlan["language_id"]?>">
                <div class="col-xs-6">
                  <label>ภาษา : <?=$rowlan["language_name"]?></label>
                  <input type="text" name="stlg_text[]" class="form-control" <?php if($rowlan["language_id"] ==1) { echo "readonly";} ?> value="<?=$rowCeedit2["stlg_text"]?>">
                </div>
         <?php } ?>     


                
                
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
