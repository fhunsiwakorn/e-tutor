<?php
if (isset($_POST['choice_id']) && !empty($_POST['choice_id'])) {

  try {
    $answer_chk = $sql_process->lookupfild("answer", "exam_question", "question_id", $_POST['question_id']);
    if ($_POST["choice_order"] ==  $answer_chk) { ///ตรวจคำตอบและกรอกคะแนน
      $score = '1';
    } else {
      $score = '0';
    }
    $cte = filter_input(INPUT_POST, 'type_id');
    // $exRows = $connSystem->query("SELECT count(*) from exam_cach WHERE user_id='$user_id' AND type_id='$cte' AND school_id='$school_id'")->fetchColumn();
    // $exSnum=$exRows+1;
    //   $qc = 'INSERT INTO exam_cach(number_exam,question_id,choice_id,score,user_id,type_id,school_id)
    //   VALUES (:number_exam,:question_id,:choice_id,:score,:user_id,:type_id,:school_id)';
    //   $extc = $connSystem->prepare($qc);
    $extc = "UPDATE exam_cach SET
choice_id=:choice_id,
score=:score,
success_ex=:success_ex
WHERE user_id=:user_id AND question_id=:question_id AND  school_id=:school_id AND type_id=:type_id";
    $extc = $connSystem->prepare($extc);
    $extc->execute(
      array(

        ':question_id' => $_POST['question_id'],
        ':choice_id' => $_POST['choice_id'],
        ':score' => $score,
        ':user_id' => $user_id,
        ':type_id' => $_POST['type_id'],
        ':school_id' => $school_id,
        ':success_ex' => 1
      )
    );
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  ///// ///คำนวนคะแนนและบันทึก
  try {

    $exRows2 = $connSystem->query("SELECT count(*) from exam_cach WHERE user_id='$user_id' AND type_id='$cte' AND school_id='$school_id' AND success_ex ='1'")->fetchColumn();
    if ($exRows2 >= $examstart) { //ถ้าทำข้อสอบครบ 50ข้อ
      $date_score = date("Y-m-d H:i:s");

      $sumex = $connSystem->prepare("SELECT SUM(score) AS score  FROM exam_cach WHERE type_id = :type_id_param AND user_id=:user_id_param AND school_id=:school_id");
      $sumex->execute(array(':type_id_param' => $_POST['type_id'], ':user_id_param' => $user_id, ':school_id' => $school_id));
      $rowSum = $sumex->fetch(PDO::FETCH_ASSOC);
      $sumtotal = $rowSum['score'];

      $qsum = 'INSERT INTO exam_status_score(score_total,user_id,score_date,type_id,school_id)
    VALUES (:score_total,:user_id,:score_date,:type_id,:school_id)';
      $exsum = $connSystem->prepare($qsum);
      $exsum->execute(
        array(
          ':score_total' => $sumtotal,
          ':user_id' => $user_id,
          ':score_date' => $date_score,
          ':type_id' => $_POST['type_id'],
          ':school_id' => $school_id
        )
      );

      ///ส่งคะแนนไปยังระบบ em
      $st_idcard = $auth_user->single_fild("user_id_card", "user_member_group", "user_id", $user_id); //รหัสนักเรียน
      $auth_user->sendScoreToDMS($st_idcard, $sumtotal, $date_score);
    }
  } catch (PDOException $f) {
    echo $f->getMessage();
  }

  $type = $_POST['type_id'];

  echo "<script>";
  echo "location.href = 'sdc?option=exam-main&cte=$type'";
  echo "</script>";
}




///// ///คำนวนคะแนนและบันทึก2


//   $exRows2 = $connSystem->query("SELECT count(*) from exam_cach WHERE user_id='$user_id' AND type_id='$cte' AND school_id='$school_id' AND success_ex='1'")->fetchColumn();
//   if($exRows2 >= $examstart){ //ถ้าทำข้อสอบครบ 50ข้อ
if (isset($_GET['SendChk']) && isset($_GET['cte']) || $time <= "00:00:00") {

  try {
    $date_score = date("Y-m-d H:i:s");

    $sumex = $connSystem->prepare("SELECT SUM(score) AS score  FROM exam_cach WHERE type_id = :type_id_param AND user_id=:user_id_param AND school_id=:school_id");
    $sumex->execute(array(':type_id_param' => $_GET['cte'], ':user_id_param' => $user_id, ':school_id' => $school_id));
    $rowSum = $sumex->fetch(PDO::FETCH_ASSOC);
    $sumtotal = $rowSum['score'];

    ////ปรับให้ success_ex=1 => 1 =ทำข้อสอบแล้ว 0 คือยังไม่ทำ
    $sumex2 = $connSystem->prepare("UPDATE exam_cach  SET success_ex='1' WHERE type_id = :type_id_param AND user_id=:user_id_param AND school_id=:school_id");
    $sumex2->execute(array(':type_id_param' => $_GET['cte'], ':user_id_param' => $user_id, ':school_id' => $school_id));

    $qsum = 'INSERT INTO exam_status_score(score_total,user_id,score_date,type_id,school_id)
  VALUES (:score_total,:user_id,:score_date,:type_id,:school_id)';
    $exsum = $connSystem->prepare($qsum);
    $exsum->execute(
      array(
        ':score_total' => $sumtotal,
        ':user_id' => $user_id,
        ':score_date' => $date_score,
        ':type_id' => $_GET['cte'],
        ':school_id' => $school_id
      )
    );

    ///ส่งคะแนนไปยังระบบ em
    $st_idcard = $auth_user->single_fild("user_id_card", "user_member_group", "user_id", $user_id); //รหัสนักเรียน
    $school_path_url = $auth_user->single_fild("school_path_url", "tbl_school", "school_id ", $school_id); //รหัส url โรงเรียน
    // echo $auth_user->sendScoreToDMS($st_idcard, $sumtotal, $date_score);
    $auth_user->sendScoreToDMS($st_idcard, $sumtotal, $date_score, $school_path_url);
    // exit;

    $type = $_GET['cte'];
    echo "<script>";
    echo "location.href = 'sdc?option=exam-main&cte=$type'";
    echo "</script>";
  } catch (PDOException $f) {
    echo $f->getMessage();
  }
}
