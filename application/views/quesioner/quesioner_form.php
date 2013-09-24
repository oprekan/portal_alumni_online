<script type="text/javascript">
	$(document).ready(function(){
		var strArr = "<?php
		foreach ($question as $row1) {
			foreach ($row1['question'] as $row2) {
				echo $row2['tipe_id']."-".$row2['question_id'].",";
			}
		}?>";
		var strArr = strArr.split(",");
		var len = strArr.length;
		strArr.splice(len-1,1);
		// console.log(strArr);
		
		function errorAlert (msg) {
			return '<div class="alert alert-error"><strong>Error</strong> '+msg+'</div>';
		}
		function successAlert (msg) {
			return '<div class="alert alert-success"><strong>Success</strong> '+msg+'</div>';
		}
		
		function sendAnswers () {
			var fieldInput = $('#quesionerForm :input');
			var fieldName2 = '';
			var buttonSend = $('#send');
			var loadingStatus = $('#loading')[0];
			var infoAlert = $('#info-alert')[0];
			var quesionerDiv = $('#quesionerDiv')[0];
			buttonSend[0].disabled = true;
			infoAlert.innerHTML = '<img src="portal_assets/img/loading_faddingline.gif" width="25" /> Please wait, while sending your answers...';
			$.ajax({
				type : 'POST'
				,url : 'quesioners/save'
				,data : $('#quesionerForm').serializeArray()
				,success : function (resp) {
					resp = $.parseJSON(resp);
					fields = resp.field;
					msg = resp.msg;
					status = resp.status;
					
					if (resp.status == 'false') {
						buttonSend[0].disabled = false;
						infoAlert.innerHTML = errorAlert(resp.msg);
					} else {
						buttonSend[0].disabled = false;
						infoAlert.innerHTML = successAlert(resp.msg);
						quesionerDiv.innerHTML = "<center><h4>Feedback anda telah kami terima, terima kasih untuk partispasinya</h4></center>";
					}
					
					
					return false;
					// if (resp == "success") {
						// var info = $(".alert_info");
						// var error = $(".alert_error");
						// if (info.length != 0) {
							// $(".alert_info").replaceWith("<h4 class='alert_success'>Data has been saved</h4>");
						// } 
						// else if (error.length != 0){
							// $(".alert_error").replaceWith("<h4 class='alert_success'>Data has been saved</h4>");
						// }
						// window.location = 'index.php/portal_admin/menu';
						
					// } else {
						// $(".alert_info").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						// return false;
					// }
					
				}
			});
		}
		
		$('#send').click(function(){
			sendAnswers ()
		});
	});
</script>

<!-- CONTENT -->
		<section id="forms">
			<h4>Welcome <?php echo $nama;?></h4>
			<div class="well">
				<table class="table table-bordered table-striped" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<td width="10%"><img src="portal_assets/img/no-photo.jpg" height="150" width="100"/></td>
							<td>
								<b>Detail Alumni </b><br/>
								Nama : <?php echo $nama;?><br/>
								NIM : <?php echo $nim;?><br/>
								Jurusan : <?php echo $prodi;?><br/>
								Divisi : <?php echo $divisi;?><br/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<hr>
		<div id="quesionerDiv">
			<?php
				if ($exist == 'yes') {
					echo "<center><h4>Feedback anda telah kami terima, terima kasih untuk partisipasinya</h4></center>";
				} else {
			?>
			<h4>Quesioner Form</h4>
			<div align="left">
			<table class='table table-bordered table-striped' style='width:50%;'>
			  <tbody>
				<tr>
					<td colspan="3" rowspan="1"><b>Legend Information</b></td>
				</tr>
				<tr>
				  <td style='width:30%'>STS : Sangat Tidak Setuju</td>
				  <td style='width:30%'>SS : Sangat Setuju</td>
				  <td style='width:30%'>CS : Cukup Setuju</td>
				</tr>
				<tr>
				  <td>TS : Tidak Setuju</td>
				  <td>S : Setuju</td>
				  <td></td>
				</tr>
			</tbody>
			</table>
			</div>
			<!---<form id='quesionerForm' action="index.php/quesioners/save" method="post">-->
			<form id='quesionerForm' method="post">
				<input type="hidden" id="nim" name="nim" value="<?php echo $nim;?>">
			<?php
				foreach ($question as $row1) {
					echo "<h4>".$row1['variable']."</h4>";
					echo "<table class='table table-bordered table-striped'>
						<tr>
							<td style='text-align:center;'><b>Pertanyaan</b></td>
							<td style='text-align:center;'><b>STS</b></td>
							<td style='text-align:center;'><b>TS</b></td>
							<td style='text-align:center;'><b>CS</b></td>
							<td style='text-align:center;'><b>S</b></td>
							<td style='text-align:center;'><b>SS</b></td>
						</tr>";
					foreach ($row1['question'] as $row2) {
						if ($row2['tipe_id'] == "R") {
							echo "<tr>";
							echo "<td style='width:50%;'><label class='control-label' for='inputError'>".$row2['question']."</label></td>";
							echo "<td id='".$row2['tipe_id']."-".$row2['question_id']."' style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' class='regular-radio' type='radio' value='sts' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ts' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='cs' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='s' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ss' /></td>";
							echo "</tr>";
						} else if ($row2['tipe_id'] == "K") {
							echo "<tr>";
							echo "<td style='width:50%'>".$row2['question']."</td>";
							echo "<td colspan='5' rowspan='1'><textarea name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' class='input-xlarge' id='comment' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>";
							echo "</tr>";
						} else if ($row2['tipe_id'] == "RK") {
							echo "<tr>
							  <td colspan='1' rowspan='2' style='width:50%'>".$row2['question']."</td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='sts'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ts'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='cs'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='s'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ss'/></td>
							</tr>
							<tr>
							  <td colspan='5' rowspan='1'>Kendala / Saran :<textarea id='".$row2['tipe_id']."-".$row2['question_id']."-komen"."' name='jawab[".$row2['tipe_id']."-".$row2['question_id']."-komen"."]' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>
							</tr>";

							// echo "<tr>";
							// echo "<td style='width:50%'>".$row2['question']."</td>";
							// echo "<td colspan='4' rowspan='1'><textarea class='input-xlarge' id='comment' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>";
							// echo "</tr>";
						}
						
					}
					echo "</table>";
				}
			?>
			<section id="buttons">
				<div id="info-alert">
					
				</div>
				<input class="btn btn-large btn-primary" id="send" name="send" type="button" class="button" value="Send" /> <span id="loading"></span>
			</section>
			</form>
			<?php
				}
			?>
		</div>
	</section>