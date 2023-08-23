<?php
////ตรวจสอบนักเรียนที่หมดอายุการใช้งานแล้ว
$everyday = date("Y-m-d");   //วันปัจจุบัน
$timestamp1 = strtotime($everyday);
$sttset = $connSystem->prepare("SELECT user_id,user_date_end FROM user_member_group WHERE user_status='2' AND 
user_date_status='1' AND DATE(user_date_end)<='$everyday'  ");
$sttset->execute();
while ($rowSet = $sttset->fetch(PDO::FETCH_ASSOC)) {
      // $timestamp2 = strtotime($rowSet['user_date_end']);
      // if ($timestamp1 > $timestamp2) {
      try {

            $qs = "UPDATE user_member_group SET
      user_date_status=:user_date_status
      WHERE user_id=:user_id";
            $sthset = $connSystem->prepare($qs);
            $sthset->execute(
                  array(
                        ':user_id' => $rowSet['user_id'],
                        ':user_date_status' => 0
                  )
            );
            ////ลบแคช
            $qdc = "DELETE FROM exam_cach  WHERE user_id =:user_id_param";
            $qdc = $connSystem->prepare($qdc);
            $qdc->execute(
                  array(
                        ':user_id_param' => $rowSet['user_id']
                  )
            );
            ////ลบเวลาที่ set ไว้
            $qdc2 = "DELETE FROM exam_time  WHERE user_id =:user_id_param";
            $qdc2 = $connSystem->prepare($qdc2);
            $qdc2->execute(
                  array(
                        ':user_id_param' => $rowSet['user_id']
                  )
            );
      } catch (PDOException $es) {
            echo $es->getMessage();
      }
      // }  //ปิด if
}
