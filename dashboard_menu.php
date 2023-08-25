<li ><a href="dashboard?option=exam-course"  dropzone="link"><i class="glyphicon glyphicon-book"></i> <span><?=$sql_process->mf("JFTYFTNZBPROM39N9K2A",$language_id);?></span></a></li>
<li ><a href="dashboard?option=student-data"  dropzone="link"><i class="glyphicon glyphicon-user"></i> <span><?=$sql_process->mf("BBXP2MEZ3KSI6WTH1RZQ",$language_id);?></span></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-paperclip"></i> <?=$sql_process->mf("TUV3X50URHAT5GNAWKRE",$language_id);?> <span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
  <?php
  $rcp = $connSystem->prepare("SELECT
  tbl_permission_course.type_id,
  exam_type.type_name
  FROM
  tbl_permission_course ,
  exam_type
  WHERE
  tbl_permission_course.type_id = exam_type.type_id AND
  tbl_permission_course.compair_course ='$compair_course'
  ORDER BY
  exam_type.type_id DESC
  ");
  $rcp->execute();
  while($rowRCP = $rcp->fetch(PDO::FETCH_ASSOC)) {

  ?>
<li ><a href="dashboard?option=report&C=<?php echo $rowRCP['type_id']; ?>"  dropzone="link"> <span  style="font-size:20px;"><?=$sql_process->mf("NATDPVWXSL0SFA1EVPZD",$language_id);?> : <?php echo $rowRCP['type_name']; ?></span></a></li>
<?php } ?>
</ul>
</li>

<!-- <li ><a href="dashboard?option=board"  dropzone="link"><i class="glyphicon glyphicon-comment"></i> <span>กระดานสนทนา</span></a></li> -->
