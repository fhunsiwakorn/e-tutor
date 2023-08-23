<?php
function secondsTime($examTime) { //แปลง x:x:x
	$time = explode(":", $examTime);
	$h = $time[0]*3600;
	$m = $time[1]*60;
	$s = $time[2]*1;
	$seconds = $h+$m+$s;
	return $seconds;
//แปลงค่าเป็นวินาที
}


//clear ข้อสอบทำใหม่ ตัวแปรมาจาก student_member_page_5_sum_show.php
if(isset($_GET['clear'])){
  try {
  $qdc = "DELETE FROM exam_cach  WHERE user_id =:user_id_param AND type_id = :type_id_param  ";
  $qdc= $connSystem->prepare($qdc);
  $qdc->execute(
        Array(
               ':user_id_param' => $user_id,
               ':type_id_param' => $_GET['cte']
        )
  );

  $qdc2 = "DELETE FROM exam_time  WHERE user_id =:user_id_param AND type_id = :type_id_param  ";
  $qdc2= $connSystem->prepare($qdc2);
  $qdc2->execute(
        Array(
               ':user_id_param' => $user_id,
               ':type_id_param' => $_GET['cte']
        )
  );


  $type_id=$_GET['cte'];

//    echo "<script>";
//    echo "swal('ข้อสอบพร้อม สำหรับการสอบครั้งต่อไป !', 'ปิดหน้าต่างนี้ เพื่อทำการสอบอีกครั้ง่ !', 'success');";
//    echo "</script>";
echo "<script>";
echo "location.href = 'sdc?option=exam-main&cte=$type_id'";
echo "</script>";
      }catch(PDOException $e) {
          echo $e->getMessage();
      }
}

$cte = filter_input(INPUT_GET, 'cte');
$exRowsChk = $connSystem->query("SELECT count(question_id) from exam_cach WHERE user_id='$user_id' AND type_id='$cte' AND school_id='$school_id' AND success_ex ='1'")->fetchColumn();
$exRowsChk2 = $connSystem->query("SELECT count(question_id) from exam_cach WHERE user_id='$user_id' AND type_id='$cte' AND school_id='$school_id'")->fetchColumn();
$exRowsChk3 = $connSystem->query("SELECT count(user_id) from exam_time WHERE user_id='$user_id' AND type_id='$cte' AND school_id='$school_id'")->fetchColumn();



 

if($exRowsChk3 <=0){

      include ("student_member_page_2_load_time.php");   

}
// else{
//       include ("student_member_page_2_Update_time.php");    
// }


if($exRowsChk2 <=  $examstart && $exRowsChk2==0){
      include ("student_member_page_2_load_exam.php");   
}

if($exRowsChk >= $examstart){
include ("student_member_page_5_sum_show.php");  ///หน้าสำหรับตรวจคำตอบ

}elseif ($exRowsChk < $examstart || $exRowsChk=='0') {
   
 include ("student_member_page_3_run_exam.php"); ///หน้าสำหรับทำข้อสอบ

}
