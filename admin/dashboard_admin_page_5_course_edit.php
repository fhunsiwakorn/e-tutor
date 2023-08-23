<?php
$ste = $connSystem->prepare("SELECT * FROM exam_type  WHERE type_id = :type_id_ed");
$ste->execute(array(':type_id_ed'=>$_GET['exce']));
$rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);


 if(isset($_POST['btn_primary'])){
 try {
$dateC=date("Y-m-d");

 $q = "UPDATE exam_type SET
     type_name=:type_name_edit,
     type_detail=:type_detail_edit,
     type_pic=:type_pic_edit,
     type_date=:type_date_edit,
     type_status=:type_status_edit,
     language_id=:language_id_edit,
     type_group_id=:type_group_id_edit
     WHERE type_id=:type_id_edit";
 $sth = $connSystem->prepare($q);
 $sth->execute(
       Array(
              ':type_id_edit' => $_POST['type_id'],
              ':type_name_edit' => $_POST['type_name'],
              ':type_detail_edit' => $_POST['type_detail'],
              ':type_pic_edit' => $_POST['type_pic'],
              ':type_date_edit' => $dateC,
              ':type_status_edit' => $_POST['type_status'],
              ':language_id_edit' => $_POST['language_id'],
              ':type_group_id_edit' => $_POST['type_group_id']
       )
 );
 $exce=$_POST['type_id'];
  echo "<script>";
  echo "location.href = 'dashboard_admin?option=exam-co-edit&exce=$exce&success'";
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
    <h3 class="box-title">แก้ไขหลักสูตร <u><?php echo $rowCeedit['type_name'];?> </u> </h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

           <div class="row">
<input type="hidden" class="form-control" name="type_id" value="<?php echo $rowCeedit['type_id'];?>" >
<div class="col-xs-6">
 <label>รูปภาพหลักสูตร (Path URL)</label>

 <input type="text" class="form-control" name="type_pic" value="<?php echo $rowCeedit['type_pic'];?>">
</div>
<div class="col-xs-6">
 <label>ชื่อหลักสูตร</label>
 <input type="text" name="type_name" class="form-control" value="<?php echo $rowCeedit['type_name'];?>" required>
</div>
</div>
                <div class="col-xs-6">
                  <label>ภาษา</label>
                  <select class="form-control" name="language_id">
                     <?php
                        echo "<option value=''>--เลือกภาษา่--</option>" ;
                     $rcp = $connSystem->prepare("SELECT language_id, language_name FROM tbl_exam_language  ORDER By language_id DESC");
                     $rcp->execute();
                     while($rowRCP = $rcp->fetch(PDO::FETCH_ASSOC)) {
                     $language_id=  $rowRCP['language_id'];
                     $language_name=$rowRCP['language_name'];

                    //  echo "<option value='$language_id'>$language_name</option>" ;

                     
                  echo"<option value='$language_id'";
                  if ($rowCeedit['language_id'] == $language_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$language_name</option>\n";

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
                     $type_group_id= $rowRCP1['type_group_id'];
                     $type_group_name=$rowRCP1['type_group_name'];

                    //  echo "<option value='$type_group_id'>$type_name</option>" ;
                     echo"<option value='$type_group_id'";
                     if ($rowCeedit['type_group_id'] == $type_group_id)
                     {
                       echo "SELECTED";
                     }
                     echo ">$type_group_name</option>\n";

                   }
                   ?>
                    </select>
                </div>

<div class="col-xs-6">
 <label>รายละเอียด</label>
 <input type="text" name="type_detail" value="<?php echo $rowCeedit['type_detail'];?>" class="form-control">
</div>
<div class="col-xs-6">
 <label>สถานะ</label>
   <select class="form-control" name="type_status" >
    <option value="<?php echo $rowCeedit['type_status'];?>">
  <?php
  if($rowCeedit['type_status']=='1'){
    echo "เปิดหลักสูตร";
  }elseif($rowCeedit['type_status']=='2') {
    echo "ปิดหลักสูตร";
  }
  ?>
</option>
   <option value="1">เปิดหลักสูตร</option>
   <option value="2">ปิดหลักสูตร</option>
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
