<?php
    
$nom2=0;

$exl= $connSystem->prepare(
"SELECT
exam_question.question_id
FROM
exam_question
WHERE
exam_question.type_id = :type_id_param
ORDER BY RAND()
LIMIT 0,$examstart
");
$exl->execute(array(':type_id_param'=>$cte));
while($rowExl = $exl->fetch(PDO::FETCH_ASSOC)) {
    $nom2++;


   $q = 'INSERT INTO exam_cach(number_exam,question_id,choice_id,score,user_id,type_id,school_id)
    VALUES (:number_exam, :question_id,:choice_id,:score,:user_id,:type_id,:school_id)';
    $q = $connSystem->prepare($q);
    $q->execute(
          Array(
                 ':number_exam' => $nom2,
                 ':question_id' => $rowExl['question_id'],
                 ':choice_id' =>0,
                 ':score' =>0,
                 ':user_id' => $user_id,
                 ':type_id' => $cte,
                 ':school_id' => $school_id
          )
    );

    // echo $rowExl['question_id'];
    }
    // echo "<script>";
    // echo "location.href = 'sdc?option=exam-main&cte=$cte'";
    // echo "</script>";


