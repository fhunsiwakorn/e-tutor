<?php
$ust = $connSystem->prepare("SELECT user_id, user_name,user_password_2,user_prefix,user_firstname,user_lastname,user_tel,user_email,user_date FROM user_member_group  WHERE user_id = :user_id_param");
$ust->execute(array(':user_id_param'=>$_GET['us']));
$rowUedit = $ust->fetch(PDO::FETCH_ASSOC);


 if(isset($_POST['btn_primary'])){
 try {
   $d=date("Y-m-d");
   $cout_day=$_POST['user_date'];
   $strNewDate = date ("Y-m-d", strtotime("+$cout_day day", strtotime($d)));

 $q = "UPDATE user_member_group SET
     user_date=:user_date,
     user_date_end=:user_date_end,
     user_date_status=:user_date_status
     WHERE user_id=:user_id";
 $sth = $connSystem->prepare($q);
 $sth->execute(
       Array(
              ':user_id' => $_POST['usid'],
              ':user_date' => $_POST['user_date'],
              ':user_date_end' => $strNewDate,
              ':user_date_status' => 1,
       )
 );
 $uid=$_POST['usid'];
  echo "<script>";
  echo "location.href = 'dashboard?option=student-renew&us=$uid&success'";
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
    <h3 class="box-title"><?=$sql_process->mf("F266TMVBC8MS8U0PVY7P",$language_id)?> <u><?php echo $rowUedit['user_firstname'];?> <?php echo $rowUedit['user_lastname'];?></u>  <?=$sql_process->mf("5GCGQQ4HNV0R1QTBGKIL",$language_id)?> : <u><?php echo  sprintf("%06d", $rowUedit["user_id"]); ?></u> </h3>
  </div>
  <div class="box-body">


    <form id="frmMain" name="frmMain" method="post">

           <div class="row">
<input type="hidden" class="form-control" name="usid" value="<?php echo $rowUedit['user_id'];?>" >
                   <div class="col-xs-6">
                   <?php $day=$sql_process->mf("J0Y1I8DDD0C28JP3K95",$language_id); ?>
                      <label><?=$sql_process->mf("CAMS06GZB67SNWV2HT64",$language_id)?></label>
                      <select name="user_date" id="user_date"  class="form-control">
                      <option value="<?php echo $rowUedit['user_date'];?>"><?php echo $rowUedit['user_date'];?> <?=$day?></option>
                      <option value="7">7 <?=$day?></option>
                      <option value="30">30 <?=$day?></option>

                    </select>

                   </div>

                   <div class="col-xs-12">
                     <hr>
                 <font color="red"> <?=$sql_process->mf("HHZNX53FQRGL14H1H3IY",$language_id)?> : <?=$sql_process->mf("94LX9UDHR7O6NP5WKZ7Y",$language_id)?>
                 </font>
                   </div>
               </div>

               <br><hr>
               <div class="form-group">
                 <center>
               <button type="submit" class="btn btn-primary" name="btn_primary"><?=$sql_process->mf("M5LG2XXTSR4ZZSW5GD0",$language_id)?></button>
             </center>
                  </div>

                </form>
         </div>




  </div>
