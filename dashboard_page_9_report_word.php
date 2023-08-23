<?php
////word
header("Content-Type: application/msword");
header('Content-Disposition: attachment; filename="Report-1-'.date("d-m-Y_H-i-s").'.doc"');
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

require_once('ConfigDB.php');
include ("ConfigName.php");
require_once('ConfigDB_2.php');
require_once('function.php');
$sql_process = new msystem();

$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['C']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);

$stu = $connSystem->prepare("SELECT 
user_member_group.user_prefix,
user_member_group.user_firstname,
user_member_group.user_lastname,
user_member_group.school_id ,
tbl_school.language_id 
FROM 
user_member_group,
tbl_school
  WHERE
  user_member_group.school_id = tbl_school.school_id AND
  user_member_group.user_id = :user_id_param");
$stu->execute(array(':user_id_param'=>$_GET['us']));
$rowStu = $stu->fetch(PDO::FETCH_ASSOC);
$language_id=$rowStu['language_id'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
 <title><?=$name_program?></title>
</head>
<body>
 
<h3> <?=$sql_process->mf("1B0PV9NEBEGVTWTRJ2SD",$language_id);?>  <u><?php echo $rowStu['user_prefix']; echo $rowStu['user_firstname']; echo "&nbsp;"; echo $rowStu['user_lastname']; ?></u></h3>
<h3>  <?=$sql_process->mf("CJGNTE4UPKLODTWJ6DGZ",$language_id);?> : <?php echo $rowEXType["type_name"]; ?></h3>
<table width="100%" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
			<td align="center"><b> <?=$sql_process->mf("HOFIMB0NL6RTAGEDB",$language_id);?> </b></td>
      <td align="center"><b> <?=$sql_process->mf("ZN9L6W1HNT6F4TUOR",$language_id);?></b></td>
      <td align="center"><b> <?=$sql_process->mf("4N1BGXDIXXP0M8OP4L",$language_id);?></b></td>

    </tr>
    <?php

    $hist = $connSystem->prepare("SELECT * FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param  ORDER BY score_id  ASC");
    $hist->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
    $a='0';
    while($rowHis = $hist->fetch(PDO::FETCH_ASSOC))
   {
     $a++;


?>
    <tr>
			<td align="center"><?=$a?></td>
      <td align="center">
      <?php 
      echo DatetoDMYTime($rowHis['score_date']);
?>
      </td>

      <td  align="center">

    <?php echo $rowHis['score_total']; ?>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>


</body>
</html>
