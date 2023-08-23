
<?php
 header("content-type: text/html; charset=utf-8");
 header ("Expires: Wed, 21 Aug 2013 13:13:13 GMT");
 header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 header ("Cache-Control: no-cache, must-revalidate");
 header ("Pragma: no-cache");


    
 

 require_once('../ConfigDB.php');
 $user_prefix = strip_tags($_GET['p']);
 $user_firstname = strip_tags($_GET['f']); ///ชื่อริง
 $user_lastname = strip_tags($_GET['l']); ///นาสกุล
 $user_tel = strip_tags($_GET['t']); //เบอร์โทร
 $user_email = strip_tags($_GET['m']); //อีเมล
 $school_code = strip_tags($_GET['sc']);  ///school_code
 $token = strip_tags($_GET['token']);
 $verify_get=sha1(md5($school_code));
if($verify_get==$token){

$ste = $connSystem->prepare("SELECT school_id FROM tbl_school  WHERE school_code = :school_code");
$ste->execute(array(':school_code'=>$school_code));
$rowScedit = $ste->fetch(PDO::FETCH_ASSOC);

try {
  $d=date("Y-m-d");  //วันปัจจุบัน
  $cout_day=30;  ///จำนวนวันการใช้งาน
  $strNewDate = date ("Y-m-d", strtotime("+$cout_day day", strtotime($d)));

  $stRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_name='$user_tel'")->fetchColumn();
  if($stRows=='0'){
$new_password = password_hash($user_tel, PASSWORD_DEFAULT);
$q = 'INSERT INTO user_member_group(user_name,user_password,user_password_2,user_prefix,user_firstname,user_lastname,user_tel,user_email,user_date,user_date_start,user_date_end,user_date_status,school_id,user_status)
VALUES (:user_name, :user_password,:user_password_2,:user_prefix,:user_firstname,:user_lastname,:user_tel,:user_email,:user_date,:user_date_start,:user_date_end,:user_date_status,:school_id,:user_status)';
$sth = $connSystem->prepare($q);
$sth->execute(
      Array(
             ':user_name' => $user_tel,
             ':user_password' => $new_password,
             ':user_password_2' => $user_tel,
             ':user_prefix' => $user_prefix,
             ':user_firstname' => $user_firstname,
             ':user_lastname' => $user_lastname,
             ':user_tel' => $user_tel,
             ':user_email' => $user_email,
             ':user_date' => $cout_day,
             ':user_date_start' => $d,
             ':user_date_end' => $strNewDate,
             ':user_date_status' => 1,
             ':school_id' => $rowScedit['school_id'],
             ':user_status' => 2
      )
);

        }
    }

     catch(PDOException $e) {
        echo $e->getMessage();
    }
}
//echo "$user_firstname";