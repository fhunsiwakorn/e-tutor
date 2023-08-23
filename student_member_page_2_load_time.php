<?php
$ex_time2="00:59:00";
$q2 = 'INSERT INTO exam_time(ex_time,user_id,type_id,school_id)
VALUES (:ex_time,:user_id,:type_id,:school_id)';
$q2 = $connSystem->prepare($q2);
$q2->execute(
      Array(
             ':ex_time' => $ex_time2,
             ':user_id' => $user_id,
             ':type_id' => $cte,
             ':school_id' => $school_id
      )
);