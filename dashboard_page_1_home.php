<?php  $year = date("Y");  ?>

<!-- BAR CHART -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><?=$sql_process->mf("YJU8CTYQLDLYLTWVRNZ",$language_id);?></h3>

            <div class="box-tools pull-right">

              <?php
              if(isset($_POST['sty'])){
                $rows_year=$_POST['sty'];
              }else {
                $rows_year=$year;
              }

               ?>
              <form method="post" name="search_year">
              <div class="form-group">
                    <select class="form-control" name="sty" onchange="submit();">

                      <?php
                      echo '<option value="'.$rows_year.'">'.$rows_year.'</option>';
                      for($i=2017;$i<=2050;$i++){
                      $i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
                      echo '<option value="'.$i2.'">'.$i2.'</option>';
                        }
                        ?>
                    </select>
                  </div>
            </form>
            </div>
          </div>
          <div class="box-body">

            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>

            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



          </div>
          <!-- /.box-body -->
        </div>
<script>
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<?=$sql_process->mf("FGDTOB9VBMDZRER4ZS5",$language_id);?>'
    },
    subtitle: {
        text: '<?=$sql_process->mf("CW0YQL665VW0AK8HRP6C",$language_id);?> <?php echo"$rows_year";  ?>'
    },
    xAxis: {
        categories: [
            '<?=$sql_process->mf("ICLVL52IUIK588VT0OA",$language_id);?>',
            '<?=$sql_process->mf("LOGPW48YTF1PJFWRQ",$language_id);?>',
            '<?=$sql_process->mf("VM8MP0UQRX2VBMB361OD",$language_id);?>',
            '<?=$sql_process->mf("9629M8ZEQ5J3QCPECXL",$language_id);?>',
            '<?=$sql_process->mf("M7ZE4T6LH1S9T9JX9HE3",$language_id);?>',
            '<?=$sql_process->mf("O70DTAZCIBDCYCBGDWLQ",$language_id);?>',
            '<?=$sql_process->mf("WTAK8BO4MIRHVHCGC8AF",$language_id);?>',
            '<?=$sql_process->mf("VV1MP1ITV5STHAUO1ZNI",$language_id);?>',
            '<?=$sql_process->mf("IQ7BBVE176ICI2ZBSQ8O",$language_id);?>',
            '<?=$sql_process->mf("HO7SJPZXE2LQOIP1KZ9A",$language_id);?>',
            '<?=$sql_process->mf("A9Y0ASQA10E4YXQ4OVD",$language_id);?>',
            '<?=$sql_process->mf("WVTJ6YHNQNR48RCXAEG",$language_id);?>'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: '<?=$sql_process->mf("9EON3J5J7MR3JW9BFKE",$language_id);?>'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} ครั้ง</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
      <?php  //เชื่อมต่อฐานข้อมูลข้อสอบกลาง
  $stype = $connSystem->prepare("SELECT exam_type.type_id,exam_type.type_name FROM exam_status_score,exam_type WHERE exam_status_score.type_id=exam_type.type_id AND exam_type.type_status='1' AND exam_status_score.school_id=:school_id_param GROUP BY exam_status_score.type_id ORDER BY exam_status_score.type_id  DESC");
  $stype->execute(array(':school_id_param'=>$school_id));
  while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
    // $namet2 = $connSystem->prepare("SELECT type_id,type_name FROM exam_type  WHERE type_id = :type_id_pram2 ");
    // $namet2->execute(array(':type_id_pram2'=>$rowType['type_id']));
    // $rowNr2 = $namet2->fetch(PDO::FETCH_ASSOC);
  $type_id = $rowType["type_id"];
  $type_name = $rowType["type_name"];
///จำนวนการทำ้สอบในแต่ละเดือน
$JanuaryRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE  MONTH(score_date) = '1' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'  ")->fetchColumn();
$FebruaryRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '2' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$MarchRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '3' AND YEAR(score_date) = '$rows_year' AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$AprilRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '4' AND YEAR(score_date) = '$rows_year' AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$MayRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '5' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$JuneRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '6' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$JulyRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '7' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$AugustRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '8' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$SeptemberRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '9' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$OctoberRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '10' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$NovemberRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '11' AND YEAR(score_date) = '$rows_year'  AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();
$DecemberRows = $connSystem->query("SELECT count(type_id) from exam_status_score WHERE MONTH(score_date) = '12' AND YEAR(score_date) = '$rows_year' AND type_id='$type_id' AND school_id='$school_id'")->fetchColumn();

  ?>
    {
        name: '<?=$type_name?>',
        data: [<?=$JanuaryRows?>,<?=$FebruaryRows?>, <?=$MarchRows?>, <?=$AprilRows?>, <?=$MayRows?>, <?=$JuneRows?>,<?=$JulyRows?>, <?=$AugustRows?>, <?=$SeptemberRows?>, <?=$OctoberRows?>, <?=$NovemberRows?>, <?=$DecemberRows?>]
    },
    <?php } ?>

  ]
});

</script>
