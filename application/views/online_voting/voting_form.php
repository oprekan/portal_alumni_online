<script type="text/javascript">
	$(document).ready(function(){
		var statesdemo = {
			state0: {
				title : 'Detail Kandidat',
				html:'',
				buttons: { Close: 0, "Vote": true },
				focus: 1,
				submit:function(e,v,m,f){
					if(v != 0){
						e.preventDefault();
						$.prompt.goToState('state1',true);
						return false;
					}
					$.prompt.close();
					
				}
			},
			state1: {
				html:'Voting hanya dapat dilakukan 1 kali. <br/>Lanjutkan ?',
				buttons: { No: -1, Yes: 0 },
				focus: 1,
				submit:function(e,v,m,f){
					var objState0 = $.prompt.getState("state0")[0];
					var nim_kandidat = objState0.getElementsByClassName('jqidefaultbutton')[0].value;
					var nim_pemilih = "<?php echo $nim;?>";
					console.log("NIM : "+nim_kandidat);
					console.log("NIM Pemilih : "+nim_pemilih);
					e.preventDefault();
					if(v==0) {
						sendVoting(nim_pemilih, nim_kandidat);
						$.prompt.goToState('state2');
						return false;
					}
					else if(v==-1){
						$.prompt.goToState('state0');
					}
				}
			},
			state2: {
				html:'<div align="center"><img src="portal_assets/img/loading_faddingline.gif" width="25" /> <br/>Sending your voting ...</div>',
				focus: 1,
				submit:function(e,v,m,f){
					e.preventDefault();
					if(v==0) {
						//$.prompt.goToState('state2');
					}
					else if(v==-1){
						$.prompt.goToState('state0');
					}
				}
			}
		};

		
		
		function errorAlert (msg) {
			$("#message")[0].innerHTML = '<div class="alert alert-error"><strong>Error</strong> ' +msg+'</div>';
		}
		function successAlert (msg) {
			$("#message")[0].innerHTML = '<div class="alert alert-success"><strong>Success</strong> ' +msg+'</div>';
		}
		
		function sendVoting (nim_pemilih,nim_kandidat) {
			$.ajax({
				type : 'POST'
				,url : 'online_voting/sendVoting'
				,data : {
					"nim_pemilih" : nim_pemilih,
					"nim_kandidat" : nim_kandidat,
					"token" : "<?php echo $token;?>"
				}
				,success : function (resp) {
					resp = $.parseJSON(resp);
					fields = resp.field;
					msg = resp.msg;
					status = resp.status;
					console.log(resp);
					
					if (resp.status == false) {
						$.prompt.close();
						errorAlert(resp.msg);
					} else {
						$.prompt.close();
						successAlert(resp.msg);
						quesionerDiv.innerHTML = "<center><h4>Vote Anda sebelumnya telah Kami terima, terima kasih untuk partisipasinya. Hasil Voting akan Kami informasikan pada tanggal xx November 2013 </h4></center>";
					}
				}
			});
		}
		
	
		$('.thumbnail').click(function(btn) {
			var winW = $(window).width() - 400;
			var winH = $(window).height() - 300;
			
			statesdemo.state0.html = "<div align='center' style='padding-top:10px;'><img src='portal_assets/img/loading_faddingline.gif' width='25' /><br/>Please wait, generating data...</img></div>";
			statesdemo.state0.buttons.Vote = $(this).attr("name");
			
			$.prompt(statesdemo);
			$(".jqiclose ").remove();
			$(".jqibuttons ")[2].remove();
			
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
								'</tbody>'+
							'</table>';
					$('.jqimessage')[0].innerHTML = table;
				}
			});
			console.log($(this).attr("name"));
		});
	});
</script>

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
			<div id="message">
			</div>
		<hr>
		<div id="quesionerDiv">
			<?php
				if ($exist == 'yes') {
					echo "<center><h4>Voting anda telah kami terima, terima kasih untuk partisipasinya</h4></center>";
				} else {
			?>
			<h4>Kandidat Ketua</h4>
			<div class="row" align="center">
				<ul class="thumbnails" style="margin-left: 0px;">
				<?php
					foreach ($all_kandidat as $row) {
						echo "<li class='span2'>
								<a class='thumbnail' style='text-decoration:none;' name='$row[nim]' href='javascript:void(0)'><img style='width:90px; height:120px;' src='portal_assets/img/candidates/$row[foto_kandidat_ketua]' alt=''><div align='center'>$row[nama]</div></a>
							  </li>";
						//echo "<td width='10%' height='10%'><div align='center'><img style='width:90px; height:120px' src='portal_assets/img/candidates/$row[foto_kandidat_ketua]'><div align='center' style='font-size:10px;'>$row[nama]</div></div></td>";
					}
				?>
				</ul>
			</div>
			</form>
			<?php
				}
			?>
		</div>
	</section>