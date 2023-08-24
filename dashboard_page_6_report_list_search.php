<?php


//get the q parameter from URL

header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');
setlocale(LC_ALL, 'th_TH');

require_once('ConfigDB.php');
require_once('ConfigDB_2.php');
require_once('function.php');
$sql_process = new msystem();

$q = urldecode($_GET["q"]);
$school_id = $_GET["school_id"];
$type_id = $_GET["type_id"];


///โรงเรียน
$sct = $connSystem->prepare(
  "SELECT tbl_school.school_name,
  tbl_school.school_path_url,
  tbl_school.number_student,
  tbl_school.v_program,
  tbl_school.comment_update,
  tbl_school.day_update,
  tbl_school.compair_course ,
  tbl_school.language_id ,
  tbl_exam_language.language_img ,
  tbl_exam_language.language_name 
  FROM 
  tbl_school ,
  tbl_exam_language
   
   WHERE
   tbl_school.language_id = tbl_exam_language.language_id AND
   tbl_school.school_id = :school_id"
);
$sct->execute(array(':school_id' => $school_id));
$rowSch = $sct->fetch(PDO::FETCH_ASSOC);
$name_school = $rowSch["school_name"];
$URL = $rowSch["school_path_url"];
$number_student = $rowSch["number_student"];
$v_program = $rowSch["v_program"];
$day_update = $rowSch["day_update"];
$compair_course = $rowSch["compair_course"];
$language_id = $rowSch["language_id"];
$language_name = $rowSch["language_name"];
$language_img = $rowSch["language_img"];


$col1 = $sql_process->mf("RJV9FWIFNTT3MJ1VJASY", $language_id);
$col2 = $sql_process->mf("CAMS06GZB67SNWV2HT64", $language_id);
$col3 = $sql_process->mf("T0DZ3N2DFBB3K6FG61D", $language_id);
$col4 = $sql_process->mf("TUV3X50URHAT5GNAWKRE", $language_id);

$t1 = $sql_process->mf("17IEGFB60MGWO9Q4ZEDH", $language_id);
?>

<table id="example6" class="table table-bordered table-striped">
  <thead>
    <tr>
      <!-- <th>ลำดับ</th> -->
      <th><?= $col1 ?></th>
      <th><?= $col2 ?></th>
      <th><?= $col3 ?></th>
      <th><?= $col4 ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $list_stu = '0';


    $strli = $connSystem->prepare("SELECT
exam_status_score.score_id,
exam_status_score.score_total,
exam_status_score.user_id,
exam_status_score.score_date,
exam_status_score.type_id,
exam_status_score.school_id,
user_member_group.user_prefix,
user_member_group.user_firstname,
user_member_group.user_lastname
FROM
exam_status_score ,
user_member_group
WHERE
(exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND LOCATE('$q', user_member_group.user_firstname) > 0) OR
(exam_status_score.user_id = user_member_group.user_id AND  exam_status_score.type_id=:type_id_param AND exam_status_score.school_id =:school_id AND LOCATE('$q', user_member_group.user_lastname) > 0)
GROUP BY
exam_status_score.user_id
ORDER BY
exam_status_score.score_id DESC

");
    $strli->execute(array(':type_id_param' => $type_id, ':school_id' => $school_id));
    while ($rowList = $strli->fetch(PDO::FETCH_ASSOC)) {
      $list_stu++;
    ?>
      <tr>
        <!-- <td align="center"><?= $list_stu ?></td> -->
        <td><?php echo $rowList['user_prefix']; ?><?php echo $rowList['user_firstname']; ?>&nbsp;&nbsp;<?php echo $rowList['user_lastname']; ?></td>
        <td align="center">
          <?php
          $numexRows = $connSystem->query("SELECT count(user_id) from exam_status_score WHERE user_id='" . $rowList['user_id'] . "'and type_id='" . $rowList['type_id'] . "'")->fetchColumn();
          echo "$numexRows ";
          ?>
        </td>
        <td align="center">
          <button type="button" class="btn btn-default" onclick="window.location.href='dashboard?option=report-chart&us=<?php echo $rowList['user_id']; ?>&C=<?php echo $rowList['type_id']; ?>'" data-toggle="tooltip" title="<?= $col3 ?> <?php echo $rowList['user_firstname']; ?> <?php echo $rowList['user_lastname']; ?>">
            <img id="myImg" src="image_system/diagram_32-512.png" width="25" height="25">
          </button>
        </td>
        <td align="center">
          <div class="btn-group">
            <button type="button" class="btn btn-default" onclick="window.location.href='dashboard_page_8_report_excel.php?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $rowList['type_id']; ?>'" data-toggle="tooltip" title="<?= $col4 ?> <?php echo $rowList['user_firstname']; ?> <?php echo $rowList['user_lastname']; ?>">
              <img id="myImg" src="image_system/Microsoft-Excel-2013-Logo.png" width="25" height="25">
            </button>
            <button type="button" class="btn btn-default" onclick="window.location.href='dashboard_page_9_report_word.php?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $rowList['type_id']; ?>'" data-toggle="tooltip" title="<?= $col4 ?> <?php echo $rowList['user_firstname']; ?> <?php echo $rowList['user_lastname']; ?>">
              <img id="myImg" src="image_system/logo_word.png" width="25" height="25">
            </button>
            <button type="button" class="btn btn-default" onclick="window.open('dashboard_page_10_report_print.php?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $rowList['type_id']; ?>', '_blank');" />
            <img id="myImg" src="image_system/Printer-icon.png" width="25" height="25">
            </button>
          </div>
        </td>

      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <!-- <th>ลำดับ</th> -->
      <th><?= $col1 ?></th>
      <th><?= $col2 ?></th>
      <th><?= $col3 ?></th>
      <th><?= $col4 ?></th>
    </tr>
  </tfoot>
</table>