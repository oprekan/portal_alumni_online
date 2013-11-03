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
				,url : 'quesioners/saveYt'
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
						quesionerDiv.innerHTML = "<center><h4>Feedback anda telah kami terima, terima kasih untuk partispasinya</h4><input class='btn btn-large btn-primary' id=next name=next type=button class=button value='Lanjutkan Voting' /></center>";
						$('#next').click(function(){
							window.location = 'online_voting';
						});
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
			sendAnswers();
		});

		$('#next').click(function(){
			window.location = 'online_voting';
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
					echo "<center><h4>Feedback anda telah kami terima, terima kasih untuk partisipasinya</h4><input class='btn btn-large btn-primary' id=next name=next type=button class=button value='Lanjutkan Voting' /></center>";
				} else {
			?>
			<div class="alert alert-info">Silahkan isi pra-kuesioner ini sebelum melanjutkan voting, Terima Kasih</div>
			<form id='quesionerForm' method="post">
				<input type="hidden" id="nim" name="nim" value="<?php echo $nim;?>">
			<?php
				foreach ($question as $row1) {
					echo "<h4>".$row1['variable']." Quesioner</h4>";
					echo "<table class='table table-bordered table-striped'>
						<tr>
							<td style='text-align:center;'><b>Pertanyaan</b></td>
							<td style='text-align:center;'><b>Ya</b></td>
							<td style='text-align:center;'><b>Tidak</b></td>
						</tr>";
					foreach ($row1['question'] as $row2) {
						if ($row2['tipe_id'] == "YT") {
							echo "<tr>
							  <td colspan='1' rowspan='2' style='width:30%'>".$row2['question']."</td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='y' checked/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='t'/></td>
							 </tr>
							<tr>
							  <td colspan='5' rowspan='1'>Alasan (Jika memilih 'Tidak') :<textarea id='".$row2['tipe_id']."-".$row2['question_id']."-komen"."' name='jawab[".$row2['tipe_id']."-".$row2['question_id']."-komen"."]' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>
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