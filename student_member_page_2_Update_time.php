<?php


     
    //   $chat_date=date("Y-m-d H:i:s", strtotime('-1 second'));

$q2 = 'UPDATE exam_time SET ex_time=:ex_time WHERE user_id=:user_id AND type_id=:type_id AND  school_id=:school_id';
$q2 = $connSystem->prepare($q2);
$q2->execute(
      Array(
             ':ex_time' => $time ,
             ':user_id' => $user_id,
             ':type_id' => $_GET['cte'],
             ':school_id' => $school_id
      )
);
//  echo time();
 //echo $time; //แปลงวินาทีเป็น xx:xx:xx
//  echo $Settime ;