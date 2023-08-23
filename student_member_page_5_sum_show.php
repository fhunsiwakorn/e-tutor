<?php
unset($_SESSION['timeend']);

//หลักสูตร
$stype = $connSystem->prepare("SELECT type_id, type_name,type_date FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param' => $_GET['cte']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);
//คะแนนที่ได้
$com = $connSystem->prepare("SELECT score_total, score_date FROM exam_status_score  WHERE user_id=:user_id_param AND type_id = :type_id_param AND school_id=:school_id ORDER BY score_id  DESC");
$com->execute(array(':user_id_param' => $user_id, ':type_id_param' => $_GET['cte'], ':school_id' => $school_id));
$rowCom = $com->fetch(PDO::FETCH_ASSOC);
?>


<div class="box box-default color-palette-box">
	<div class="box-header with-border">
		<h2 class="box-title"><i class="glyphicon glyphicon-bookmark"></i>
			<?= $sql_process->mf("LVAHN4FNGHS8FV7FGDY", $language_id) ?> : <?php echo $rowEXType['type_name']; ?>
		</h2>
		<h3><u> <?= $sql_process->mf("KMLI07GMRIILUQFKU3NI", $language_id) ?></u></h3>
		<h3><?= $sql_process->mf("0S7T6K01MQJKECAVUIO8", $language_id) ?> : <?php echo  sprintf("%04d", $rowEXType["type_id"]); ?></h3>
		<h3><?= $sql_process->mf("JNO0XHKYDI4GIE8VKMFR", $language_id) ?> : <?php
																			$type_id = $rowEXType['type_id'];
																			$examRows = $connSystem->query("SELECT count(*) from exam_question WHERE  type_id='$type_id'")->fetchColumn();
																			echo "$examRows " . $sql_process->mf("QX1WUQKSLNM5PT38VYME", $language_id) . "&nbsp;";
																			echo $sql_process->mf("BLESSBN5KVZW5A0FX6L", $language_id);
																			?></h3>
		<h3><?= $sql_process->mf("SLUTQVTDOQJC57M4040I", $language_id) ?> : <?php $strDate = $rowEXType['type_date'];
																			echo DatetoDMY($strDate); ?></h3>
		<hr>
		<h3>
			<font color="blue"><?= $sql_process->mf("V6VFHBUB6JTY8J55580A", $language_id) ?> : <?php $strDate = $rowCom['score_date'];
																								echo DatetoDMYTime($strDate); ?></font>
		</h3>
	</div>
	<div class="box-header with-border">
		<h3 class="box-title">
			<font style="font-size:56px"><?= $sql_process->mf("PDFHNBELIBQ275NMZSSA", $language_id) ?> <?php echo $rowCom['score_total']; ?> / <?= $examstart ?></font>
		</h3>
		<div class="box-tools pull-right">

			<button type="button" onclick="window.location.href='sdc?option=exam-main&cte=<?php echo $_GET['cte']; ?>&clear'" data-toggle="tooltip" class="btn bg-olive btn-flat margin"><?= $sql_process->mf("4ODPCJY3TGRRXT1TAPT", $language_id) ?></button>

		</div>
	</div>
	<div class="box-body">
		<?php
		$number = '0';
		$sqch = $connSystem->prepare("SELECT number_exam,question_id,choice_id, score FROM exam_cach WHERE user_id =:user_id_param AND type_id = :type_id_param ORDER BY number_exam  ASC");
		$sqch->execute(array(':user_id_param' => $user_id, ':type_id_param' => $_GET['cte']));
		while ($rowcach = $sqch->fetch(PDO::FETCH_ASSOC)) {
			$number++;
		?>


			<table class="table table-striped">
				<tbody>
					<tr>
						<td align="center" width="20"><span style="font-size:22px"><?php echo $number . "." . ")" . "&nbsp;"; ?></span></td>
						<td>
							<h1>
								<?php
								////คำถาม
								$quest = $connSystem->prepare("SELECT question_name, answer,reference,type_choice FROM exam_question  WHERE question_id=:quid_param AND type_id = :type_id_param");
								$quest->execute(array(':quid_param' => $rowcach['question_id'], ':type_id_param' => $_GET['cte']));
								$rowQue = $quest->fetch(PDO::FETCH_ASSOC);
								///คำตอบที่เลือก
								$choi = $connSystem->prepare("SELECT choice_order, choice_name FROM exam_choice  WHERE choice_id=:choice_id_param AND type_id = :type_id_param");
								$choi->execute(array(':choice_id_param' => $rowcach['choice_id'], ':type_id_param' => $_GET['cte']));
								$rowCho = $choi->fetch(PDO::FETCH_ASSOC);

								echo $rowQue['question_name'];
								//echo strip_tags($rowQue['question_name']);
								?>

							</h1>
						</td>
						<td rowspan="2" align="right">
							<?php
							if ($rowQue['answer'] == $rowCho['choice_order']) {
								echo "<img src='image_system/18-128.png' style='width:75px; height:75px' class='img-responsive'>";
							} elseif ($rowQue['answer'] != $rowCho['choice_order']) {
								echo "<img src='image_system/x_red.png' style='width:75px; height:75px' class='img-responsive'>";
							}
							?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<table class="table table-condensed">
								<tbody>
									<?php
									$sqchoi = $connSystem->prepare("SELECT choice_order,choice_name FROM exam_choice WHERE reference =:refer_param AND type_id = :type_id_param ORDER BY choice_order  ASC");
									$sqchoi->execute(array(':refer_param' => $rowQue['reference'], ':type_id_param' => $_GET['cte']));
									while ($rowcachoi = $sqchoi->fetch(PDO::FETCH_ASSOC)) {
									?>
										<tr>
											<!-- <td width="20"> &#x2718;</td> -->
											<td width="50" align="center">

												<?php

												if ($rowcachoi['choice_order'] == '1') {
													if ($rowQue['answer'] == $rowcachoi['choice_order']) {  //เฉลย
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-green'>ก.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-green'>A</span>";
														}
													} elseif ($rowcachoi['choice_order'] == $rowCho['choice_order']) { //คำตอบที่เลือก
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-red'>ก.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-red'>A</span>";
														}
													} else {
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px'>ก.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px'>A</span>";
														}
													}
												} elseif ($rowcachoi['choice_order'] == '2') {
													if ($rowQue['answer'] == $rowcachoi['choice_order']) {  //เฉลย
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-green'>ข.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-green'>B</span>";
														}
													} elseif ($rowcachoi['choice_order'] == $rowCho['choice_order']) { //คำตอบที่เลือก
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-red'>ข.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-red'>B</span>";
														}
													} else {
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px'>ข.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px'>B</span>";
														}
													}
												} elseif ($rowcachoi['choice_order'] == '3') {
													if ($rowQue['answer'] == $rowcachoi['choice_order']) {  //เฉลย
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-green'>ค.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-green'>C</span>";
														}
													} elseif ($rowcachoi['choice_order'] == $rowCho['choice_order']) { //คำตอบที่เลือก
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-red'>ค.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-red'>C</span>";
														}
													} else {
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px'>ค.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px'>C</span>";
														}
													}
												} elseif ($rowcachoi['choice_order'] == '4') {
													if ($rowQue['answer'] == $rowcachoi['choice_order']) {  //เฉลย
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-green'>ง.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-green'>D</span>";
														}
													} elseif ($rowcachoi['choice_order'] == $rowCho['choice_order']) { //คำตอบที่เลือก
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px' class='badge bg-red'>ง.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px' class='badge bg-red'>D</span>";
														}
													} else {
														if ($rowQue['type_choice'] == '1') {
															echo "<span style='font-size:22px'>ง.</span>";
														} elseif ($rowQue['type_choice'] == '2') {
															echo "<span style='font-size:22px'>D</span>";
														}
													}
												}

												?></td>
											<td>
												<h2>
													<?php

													if ($rowQue['answer'] == $rowcachoi['choice_order']) {
														echo "<font color='green'>";
														echo $rowcachoi['choice_name'];
														echo "</font>";
													} elseif ($rowcachoi['choice_order'] == $rowCho['choice_order']) {
														echo "<font color='red'>";
														echo $rowcachoi['choice_name'];
														echo "</font>";
													} else {
														echo $rowcachoi['choice_name'];
														//echo	strip_tags($rowcachoi['choice_name']);
													}
													?>
												</h2>
											</td>
										</tr>
									<?php } ?>

								</tbody>
							</table>

						</td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
	</div>

	<div class="modal fade" id="Show_Score" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><?= $sql_process->mf("U8VMCNLGPVLT3LGQXPSW", $language_id) ?> <font color="red"><?= $sql_process->mf("PDFHNBELIBQ275NMZSSA", $language_id) ?> <?php echo $rowCom['score_total']; ?> / <?= $examstart ?> </font>
					</h4>
				</div>
				<div class="modal-body">
					<div class="row">

						<font color="blue">
							<?php
							// echo $rowCom['score_total'];
							// $examstart
							if ($rowCom['score_total'] < 40) {
								echo "<center>";
								echo "<img src='image_system/C.gif' class='img-responsive' />";

								// echo "พึ่งฝึกทำ...ไม่เป็นไรลองใหม่";
								echo $sql_process->mf("33XY1EPJQAYNRM9BQB8", $language_id);
								echo "</center>";
							} elseif ($rowCom['score_total'] >= 40 && $rowCom['score_total'] <= 44) {
								echo "<center>";
								echo "<img src='image_system/B.gif' class='img-responsive' />";

								// echo "พยายามอีกหน่อยนะ";
								echo $sql_process->mf("1TN6JDD8IPNB3FY25FJQ", $language_id);
								echo "</center>";
							} elseif ($rowCom['score_total'] >= 45 && $rowCom['score_total'] <= 50) {
								echo "<center>";
								echo "<img src='image_system/A.gif' class='img-responsive' />";

								// echo "เยี่ยมมากค่ะ";
								echo $sql_process->mf("0OVLPY2QR50YRX9HSWBC", $language_id);
								echo "</center>";
							}


							?>
						</font>

						<table class="table table-bordered">

							<tr>
								<td><?= $sql_process->mf("9R2ZT4IT93SKL7R48HP", $language_id) ?>
									<font color="red"> <?php echo $total_test = $connSystem->query("SELECT count(user_id) from exam_status_score WHERE  type_id= '" . $_GET['cte'] . "'  AND user_id='$user_id' ")->fetchColumn(); ?> </font>
									<?= $sql_process->mf("LT99XD34CUFL306PHDUU", $language_id) ?>
								</td>
								<td>
									<?= $sql_process->mf("4OIQ8M8KTOTO6MN5RW", $language_id) ?>
									<font color="red">
										<?php
										$stype2 = $connSystem->prepare("SELECT SUM(score_total) AS score_total FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param ");
										$stype2->execute(array(':type_id_param' => $_GET['cte'], ':user_id_param' => $user_id));
										$rowEXType2 = $stype2->fetch(PDO::FETCH_ASSOC);
										$average_test = $rowEXType2['score_total'] / $total_test;
										echo number_format($average_test, 2);
										?>
									</font>
									<?= $sql_process->mf("4N1BGXDIXXP0M8OP4L", $language_id) ?>
								</td>
							</tr>
							<tr>
								<td><?= $sql_process->mf("4AUTJ2RKA9A8SM9EQV1P", $language_id) ?>
									<font color="red">
										<?php
										$user_testing_date = $userRow['user_testing_date'];
										$present_date = date("Y-m-d");
										$CoutDate = DateDiff($present_date, $user_testing_date);
										if ($CoutDate <= 0) {
											echo "0";
										} else {
											echo  $CoutDate;
										}

										?>
									</font>
									<?= $sql_process->mf("BEGG38K58K9QPLEC67VP", $language_id) ?>

								</td>

								<td>
									<?= $sql_process->mf("HPK95XSR63EMY74ZR2G", $language_id) ?>
									<font color="red">
										<?php
										if ($user_testing_date == "0000-00-00" || $user_testing_date == NULL) {
											echo "-";
										} else {
											echo DatetoDMY($user_testing_date);
										}


										?></font>
								</td>


							</tr>



						</table>


					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> <?= $sql_process->mf("ZKJTB5GB4VB3O4H69Z", $language_id) ?></button>
					<!-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button> -->
					<!-- <button type="submit" class="btn btn-primary" name="btn_primary">บันทึกข้อมูล</button> -->
				</div>
			</div>

		</div>

	</div>


</div>

<?php
$std_id = $userRow['user_id_card'];
$verify_get = sha1(md5($std_id));
$score_total = $rowCom['score_total'];
$score_date = $rowCom['score_date'];
// echo $std_id;
echo "<iframe id='iframe_target' name='iframe_target'  style='width:100%; height:50px ;  border:thin; background-color:#fff' src='$URL/register/tuter_reportChk.php?score_total=$score_total&score_date=$score_date&std_id=$std_id&token=$verify_get'></iframe>";

?>

<script>
	document.querySelector('ul.examples li.warning.cancel button').onclick = function() {
		swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: "No, cancel plx!",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					swal("Deleted!", "Your imaginary file has been deleted!", "success");
				} else {
					swal("Cancelled", "Your imaginary file is safe :)", "error");
				}
			});
	};
</script>