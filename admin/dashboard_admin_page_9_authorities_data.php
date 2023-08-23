<?php
require_once('chek_student.php'); //ตรวจสอบหมดอายุการใช้งาน

if(isset($_POST['btn_primary'])){
try {

  $stRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_name='".$_POST['user_name']."'")->fetchColumn();
  if($stRows=='0'){
$new_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
$q = 'INSERT INTO user_member_group(user_name,user_password,user_password_2,user_prefix,user_firstname,user_lastname,user_date_status,school_id,user_status)
VALUES (:user_name, :user_password,:user_password_2,:user_prefix,:user_firstname,:user_lastname,:user_date_status,:school_id,:user_status)';
$sth = $connSystem->prepare($q);
$sth->execute(
      Array(
             ':user_name' => $_POST['user_name'],
             ':user_password' => $new_password,
             ':user_password_2' => $_POST['user_password'],
             ':user_prefix' => $_POST['user_prefix'],
             ':user_firstname' => $_POST['user_firstname'],
             ':user_lastname' => $_POST['user_lastname'],
             ':user_date_status' => 1,
             ':school_id' => $_POST['school_id'],
             ':user_status' => 1
      )
);
 //require_once('class.sms.php');
 echo "<script>";
 echo "location.href = dashboard_admin?option=authorities-data&success'";
 echo "</script>";
        }else {
          echo "<script>";
          echo "swal('Username ซ้ำกัน !', 'ปิดหน้าต่างนี้ เพื่อทำรายการใหม่ !', 'error');";
          echo "</script>";
        }
    }

     catch(PDOException $e) {
        echo $e->getMessage();
    }
}

///Deleate
if(isset($_POST['DELuser_id'])){
  try {


  $count=count($_POST['DELuser_id']);
  for($i=0;$i<$count;$i++){
   $qd = "DELETE FROM user_member_group  WHERE user_id=:user_id";
  //$qd = "UPDATE user_member_group SET user_date_status=:user_date_status  WHERE user_id=:user_id";
  $sth = $connSystem->prepare($qd);
  $sth->execute(
        Array(
               ':user_id' => $_POST['DELuser_id'][$i]
        )
  );
   echo "<script>";
   echo "location.href = dashboard_admin?option=authorities-data&success-d'";
   echo "</script>";
  }
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

<?php
if(isset($_GET['success-d'])){
 ?>
 <script>
	swal("ลบข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
 </script>
<?php } ?>

<script language="JavaScript">

var checkflag_d1 = "false";
function checkAll_d1(field)
{
    if (checkflag_d1 == "false") {
        for (i = 0; i < field.length; i++)
       {
             field[i].checked = true;
        }
             checkflag_d1 = "true";
   }
   else
   {
        for (i = 0; i < field.length; i++)
        {
             field[i].checked = false;
        }
             checkflag_d1 = "false";
   }
}
</script>

<!-- Sumit Form  -->
<script>
function myFunction() {
    document.getElementById("form_del").submit();
}
</script>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">ทะเบียนเจ้าหน้าที่โรงเรียน</h3>
    <div class="box-tools pull-right">
      <div class="btn-group">
        <button  type="button"  class="btn btn-default" data-toggle="modal" data-target="#Addstudent">
        <img id="myImg"  src="image_system/add_user.png"  width="30" height="30" >
        </button>
      <button type="button"  class="btn btn-default" onclick="myFunction()" data-toggle="tooltip" title="ลบนักเรียน">
      <img id="myImg"  src="image_system/Bin.png"  width="30" height="30" >
      </button>
      </div>
    </div>
  </div>
  <div class="box-body">
    <!-- <div class="box-body table-responsive no-padding"> -->
    <div >
        <form id="form_del"  name="form_del" method="post"  runat="server">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>
            <div class="checkbox">
            <label style="font-size: 1em">
            <INPUT type="checkbox" onchange="checkAll_d1(this.form.userNUM)" name="chk_all_user" />
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            </label>
            </div>
          </th>
          <th>รหัสเจ้าหน้าที่</th>
          <th>ชื่อ - นามสกุล</th>
          <th>Username</th>
          <th>Password</th>
          <th>โรงเรียน</th>
          <th>จัดการ</th>
        </tr>
        </thead>
        <tbody>
          <!-- ORDER BY CONVERT (user_firstname USING tis620) -->
<?php
$sttu = $connSystem->prepare("SELECT user_id, user_name,user_password_2,user_prefix,user_firstname,user_lastname,school_id FROM user_member_group WHERE user_status=:user_status   ORDER BY user_id DESC");
$sttu->execute(array(':user_status'=>1));
while($rowStu = $sttu->fetch(PDO::FETCH_ASSOC)) {

  $sct = $connSystem->prepare("SELECT school_name,school_path_url FROM tbl_school  WHERE school_id = :school_id_param");
  $sct->execute(array(':school_id_param'=>$rowStu['school_id']));
  $rowsc = $sct->fetch(PDO::FETCH_ASSOC);

?>
        <tr>
          <td  align="center">
            <div class="checkbox">
           <label style="font-size: 1em">
           <input type="checkbox"  name="DELuser_id[]" id="userNUM"  value="<?php echo $rowStu["user_id"] ?>">
           <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
          </label>
          </div>
          </td>
          <td align="center"><?php echo  sprintf("%06d", $rowStu["user_id"]); ?></td>
          <td><?php echo $rowStu['user_prefix'];?><?php echo $rowStu['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowStu['user_lastname'];?></td>
          <td align="center"><?php echo $rowStu['user_name'];?></td>
          <td><?php echo $rowStu['user_password_2'];?></td>
          <td ><a target="_blank" href="<?php echo $rowsc["school_path_url"]; ?>"><?php echo $rowsc["school_name"]; ?></a></td>
          <td  align="center"  >
            <div class="btn-group-vertical">
<button type="button" onclick="window.location.href='dashboard_admin?option=authorities-edit&us=<?php echo $rowStu['user_id']; ?>'" data-toggle="tooltip" title="แก้ไข รหัส <?php echo  sprintf("%06d", $rowStu["user_id"]); ?>" class="btn btn-default"><img id="myImg"  src="image_system/Edit.png"  width="25" height="25" ></button>
                   </div>
          </td>
        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
          <th>#</th>
          <th>รหัสเจ้าหน้าที่</th>
          <th>ชื่อ - นามสกุล</th>
          <th>Username</th>
          <th>Password</th>
          <th>โรงเรียน</th>
          <th>จัดการ</th>
        </tr>
        </tfoot>
      </table>
    </form>
  </div>


  </div>
  <!-- /.box-body -->
</div>


<!-- Modal ADD user student -->
<div class="modal fade" id="Addstudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
  <div class="modal-dialog" role="document">
 <form id="frmMain" name="frmMain" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มนักเรียน</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-xs-6">
                  <label>User Name</label>

                  <div class="input-group">
                   <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" onClick="populateform(7)">Generate</button>
                </div>
                  <input type="text" class="form-control" name="user_name" autocomplete="off"  required>
                  <span id="mySpan"></span>
                </div>
                </div>
               <div class="col-xs-6">
                  <label>Password</label>

                  <div class="input-group">
                   <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" onClick="populateform2(7)">Generate</button>
                </div>
                  <input type="text" class="form-control" autocomplete="off" name="user_password" required>
                </div>
                </div>
             <div class="col-xs-6">
                  <label>คำนำหน้า</label>
  <select name="user_prefix" id="user_prefix"  class="form-control">
  <option value="">ไม่มี</option>
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

                  <input type="text" class="form-control" name="user_firstname" required>
                </div>
                <div class="col-xs-6">
                  <label>นามสกุล</label>
                  <input type="text" name="user_lastname" class="form-control" required>
                </div>
                <div class="col-xs-6">

                   <label>สังกัดโรงเรียน</label>
                   <select class="form-control select2"  name="school_id"  style="width:100%" required>
                     <?php
                        echo "<option value=''>--สังกัดโรงเรียน--</option>" ;
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
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
        <button type="submit" class="btn btn-primary" name="btn_primary" style="background-color:<?=$theme_color?>;">บันทึกข้อมูล</button>
      </div>
    </div>
  </form>
  </div>
</div>
