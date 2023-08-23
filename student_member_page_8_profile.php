<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$sql_process->mf("DX28Q2P5X4QNAURA1PR",$language_id)?> </h3>
  </div>
  <div class="box-body">


    <table class="table table-condensed">
<tr>
<td width="150">Username</td>
<td>:
  <?php echo $userRow["user_name"]; ?>

</td>

</tr>
<tr>
<td width="150"><?=$sql_process->mf("RJV9FWIFNTT3MJ1VJASY",$language_id)?></td>
<td>:
  <?php
echo $userRow["user_prefix"];
echo $userRow["user_firstname"];
echo"&nbsp;&nbsp;&nbsp;";
echo $userRow["user_lastname"];?>
</td>

</tr>
<tr>
<td width="150"><?=$sql_process->mf("7LI6P12UN6S28B8SF76X",$language_id)?></td>
<td>: <?php echo $userRow["user_id_card"]; ?>
</td>

</tr>

<tr>
<td width="150"><?=$sql_process->mf("90E6UM80ODZGGCF6NY2",$language_id)?></td>
<td>: <?php echo $userRow["user_tel"]; ?>
</td>

</tr>
<tr>
<td width="150"><?=$sql_process->mf("X5XQUNFLBBH050X6ORPH",$language_id)?></td>
<td>: <?php echo $userRow["user_email"]; ?>
</td>

</tr>

<tr>
<td width="150"><?=$sql_process->mf("YGMTYITQPEMB668IXAQ",$language_id)?></td>
<td>: <?php echo DatetoDMY($userRow['user_testing_date']); ?>
</td>

</tr>

<tr>
<td width="150"><?=$sql_process->mf("CAMS06GZB67SNWV2HT64",$language_id)?></td>
<td>: <?php echo $userRow["user_date"]; ?> วัน
</td>
</tr>
<tr>
<td width="150"><?=$sql_process->mf("74KX0V8BRGUURCPLD24",$language_id)?></td>
<td>: <?php  $strDate = $userRow['user_date_start']; echo DatetoDMY($strDate); ?>
</td>
</tr>
<tr>
<td width="150"><?=$sql_process->mf("X7OKS1EDICGG0E5TNQ88",$language_id)?></td>
<td>: <?php  $strDate = $userRow['user_date_end']; echo DatetoDMY($strDate); ?>
</td>
</tr>
<tr>
<td width="150"><?=$sql_process->mf("V9DQAJ8UZSC0YP8GDUZ",$language_id)?></td>
<td>:
<?php

$everyday=date("Y-m-d");
$day_base=$userRow['user_date_end'];
echo $sql_process->mf("4AUTJ2RKA9A8SM9EQV1P",$language_id)."&nbsp;".DateDiff("$everyday","$day_base")."&nbsp;";
echo $sql_process->mf("J0Y1I8DDD0C28JP3K95",$language_id);
 ?>
</td>
</tr>
</table>


  </div>
  <!-- /.box-body -->
</div>
