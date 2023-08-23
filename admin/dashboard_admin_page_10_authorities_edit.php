<?php
$ust = $connSystem->prepare("SELECT user_id, user_name,user_password_2,user_prefix,user_firstname,user_lastname,school_id FROM user_member_group  WHERE user_id = :user_id_param");
$ust->execute(array(':user_id_param'=>$_GET['us']));
$rowUedit = $ust->fetch(PDO::FETCH_ASSOC);


 if(isset($_POST['btn_primary'])){
 try {


 $new_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

 $q = "UPDATE user_member_group SET
     user_password=:user_password,
     user_password_2=:user_password_2,
     user_prefix=:user_prefix,
     user_firstname=:user_firstname,
     user_lastname=:user_lastname,
     school_id=:school_id
     WHERE user_id=:user_id";
 $sth = $connSystem->prepare($q);
 $sth->execute(
       Array(
              ':user_id' => $_POST['usid'],
              ':user_password' => $new_password,
              ':user_password_2' => $_POST['user_password'],
              ':user_prefix' => $_POST['user_prefix'],
              ':user_firstname' => $_POST['user_firstname'],
              ':user_lastname' => $_POST['user_lastname'],
              ':school_id' => $_POST['school_id']
       )
 );
 $uid=$_POST['usid'];
  echo "<script>";
  echo "location.href = 'dashboard_admin?option=authorities-edit&us=$uid&success'";
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

<script>

   //Random password generator- by javascriptkit.com
   //Visit JavaScript Kit (http://javascriptkit.com) for script
   //Credit must stay intact for use

   var keylist="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789" // ตัวอักษรที่จะให้มีอยู่ใน Password
   var temp=''

   function generatepass(plength){
   temp=''
   for (i=0;i<plength;i++)
   temp+=keylist.charAt(Math.floor(Math.random()*keylist.length))
   return temp
   }

   function populateform(enterlength){
   document.frmMain.user_name.value=generatepass(enterlength)
   }
   function populateform2(enterlength){
   document.frmMain.user_password.value=generatepass(enterlength)
   }
   </script>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">แก้ไขข้อมูล รหัสนักเรียน <u><?php echo  sprintf("%06d", $rowUedit["user_id"]); ?></u></h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

           <div class="row">
           <div class="col-xs-6">
                     <label>User Name</label>
<input type="hidden" class="form-control" name="usid" value="<?php echo $rowUedit['user_id'];?>" >

                     <div class="input-group">
                      <div class="input-group-btn">
                     <button type="button" class="btn btn-danger" onClick="disabled(7)">Generate</button>
                   </div>
                     <input type="text" class="form-control" name="user_name" value="<?php echo $rowUedit['user_name'];?>" disabled required>
                     <span id="mySpan"></span>
                   </div>
                   </div>
                  <div class="col-xs-6">
                     <label>Password</label>

                     <div class="input-group">
                      <div class="input-group-btn">
                     <button type="button" class="btn btn-danger" onClick="populateform2(7)">Generate</button>
                   </div>
                     <input type="text" class="form-control" name="user_password" value="<?php echo $rowUedit['user_password_2'];?>" autocomplete="off" required>
                   </div>
                   </div>
                <div class="col-xs-6">
                     <label>คำนำหน้า</label>
     <select name="user_prefix" id="user_prefix"  class="form-control">
     <option value="<?php echo $rowUedit['user_prefix'];?>"><?php echo $rowUedit['user_prefix'];?></option>
     <option value="นาย">นาย</option>
     <option value="นาง">นาง</option>
     <option value="นางสาว">นางสาว</option>
     <option value="Mr.">MR</option>
     <option value="Mrs. ">MRS</option>
     <option value="Ms. ">MS</option>
     <option value="Miss">MISS</option>

    </select>
                   </div>
                    <div class="col-xs-6">
                     <label>ชื่อจริง</label>

                     <input type="text" class="form-control" name="user_firstname" value="<?php echo $rowUedit['user_firstname'];?>" required>
                   </div>
                   <div class="col-xs-6">
                     <label>นามสกุล</label>
                     <input type="text" name="user_lastname" class="form-control" value="<?php echo $rowUedit['user_lastname'];?>" required>
                   </div>
                    <div class="col-xs-6">
                      <label>สังกัดโรงเรียน</label>

                      <select class="form-control select2"  name="school_id"  style="width:100%">
                        <?php

                        $rcp_get = $connSystem->prepare("SELECT school_id, school_name FROM tbl_school  WHERE school_id = :school_id");
                        $rcp_get->execute(array(':school_id'=>$rowUedit['school_id']));
                        $rowGet = $rcp_get->fetch(PDO::FETCH_ASSOC);
                        $school_id_get=  $rowGet['school_id'];
                        $school_name_get=$rowGet['school_name'];
                        echo "<option value='$school_id_get'  selected='selected'>$school_name_get</option>" ;
                           echo "<option value=''  '>--สังกัดโรงเรียน--</option>" ;
                        $rcp = $connSystem->prepare("SELECT school_id, school_name FROM tbl_school  ORDER By school_id DESC");
                        $rcp->execute();
                        while($rowRCP = $rcp->fetch(PDO::FETCH_ASSOC)) {
                        $school_id_search=  $rowRCP['school_id'];
                        $school_name=$rowRCP['school_name'];

                        echo "<option value='$school_id_search'>$school_name</option>" ;
                      }
                      ?>
                      </select>


                   </div>


               </div>
               <br><hr>
               <div class="form-group">
                 <center>
               <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?=$theme_color?>;">บันทึกข้อมูล</button>
             </center>
                  </div>

                </form>
         </div>
  </div>
