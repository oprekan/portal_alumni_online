<script type="text/javascript">
	$(document).ready(function(){
		
		
		
		function errorAlert (msg) {
			return '<div class="alert alert-error"><strong>Error</strong> '+msg+'</div>';
		}
		function successAlert (msg) {
			return '<div class="alert alert-success"><strong>Success</strong> '+msg+'</div>';
		}
		$("#dialog-message").dialog({
			autoOpen: false,
			modal: true,
			height: 380,
			width: 430,
			buttons: {
				Close: function() {
					$(this).dialog("close");
				}
			}
		});
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
		
		$('#vote').click(function () {
			$("#dialog").dialog({
			  buttons : {
				"Confirm" : function() {
				  window.location.href = targetUrl;
				},
				"Cancel" : function() {
				  $(this).dialog("close");
				}
			  }
			});

			$("#dialog").dialog("open");
		});
		
		$('.thumbnail').click(function(btn) {
			var winW = $(window).width() - 400;
			var winH = $(window).height() - 300;
			$("#dialog-message").dialog({
				height: winH,
				width: winW,
				modal: true
			});
			$("#dialog-message").dialog("open");
			console.log($('.detail_kandidat'));
			$('.table-detail')[0].innerHTML = "<div align='center' style='padding-top:10px;'><img src='portal_assets/img/loading_faddingline.gif' width='25' /><br/>Please wait, generating quesioner result...</img></div>";
			
			$.ajax({
				type : 'POST'
				,url : 'index.php/online_voting/getKandidatByNim'
				,data : 'nim='+$(this).attr("name")
				,success : function (resp) {
					var resp = $.parseJSON(resp);
					var data = resp.data[0];
					console.log(data.foto_kandidat_ketua);
					
					var table = '<table class="table table-bordered table-striped" style="margin-bottom:0px;">'+
								'<tbody>'+
									'<tr>'+
										'<td width="130" rowspan="4">'+
											'<img style="height:200px;" src="portal_assets/img/candidates/'+data.foto_kandidat_ketua+'">'+
										'</td>'+
									'</tr>'+
									'<tr>'+
										'<td>'+
											'<b>Nama : '+data.nama+' </b>'+
										'</td>'+
									'</tr>'+
									'<tr>'+
										'<td>'+
											'<b>Visi : '+data.visi+' </b>'+
										'</td>'+
									'</tr>'+
									'<tr>'+
										'<td>'+
											'<b>Misi : '+data.misi+' </b>'+
										'</td>'+
									'</tr>'+
									'<tr>'+
										'<td>'+
											'<b></b>'+
										'</td>'+
										'<td>'+
											'<b><input class="btn btn-mini btn-primary" id="vote" type="button" class="button" value="Vote Now" /> </b>'+
											
										'</td>'+
									'</tr>'+
									
								'</tbody>'+
							'</table>';
					$('.table-detail')[0].innerHTML = table;
				}
			});
			console.log($(this).attr("name"));
		});
	});
</script>

<div id="dialog-message" title="Kandidat Ketua">
	<div class="table-detail">
	</div>
</div>
<!-- CONTENT -->
		<section id="forms">
			<h4>Selamat Datang di Online Voting KETUA IAP 2013-2018.</h4>
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
			<h4>Kandidat Ketua</h4>
			<div class="row">
				<?php
					foreach ($all_kandidat as $row) {
						echo "<div class='col-lg-3 col-md-2 col-xs-6 thumb'>
							  <a class='thumbnail' style='text-decoration:none;' name='$row[nim]' href='javascript:void(0)'><img class='img-responsive' style='width:90px; height:120px' src='portal_assets/img/candidates/$row[foto_kandidat_ketua]'><div align='center'>$row[nama]</div></a>
							</div>";
						//echo "<td width='10%' height='10%'><div align='center'><img style='width:90px; height:120px' src='portal_assets/img/candidates/$row[foto_kandidat_ketua]'><div align='center' style='font-size:10px;'>$row[nama]</div></div></td>";
					}
				?>
			</div>
			</form>
			<?php
				}
			?>
		</div>
	</section>