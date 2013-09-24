<script type="text/javascript">
	$(document).ready(function(){
		$('#btnUpdate').click(function(){
			var infoAlert = $('#info-alert')[0];
			infoAlert.innerHTML = '<div class="alert alert-success"><strong>Info : </strong> Sorry, this feature is still disabled</div>';
		});
	});
</script>
<h3>Profile Detail</h3>
<table class="table table-bordered" style="width:50%;">
	<tr>
		<td style="width:30%;">Nama</td>
		<td><?php echo $nama;?></td>
	</tr>
	<tr>
		<td>NIM</td>
		<td><?php echo $nim;?></td>
	</tr>
	<tr>
		<td>Program Studi</td>
		<td><?php echo $prodi;?></td>
	</tr>
	<tr>
		<td>Divisi</td>
		<td><?php echo $divisi;?></td>
	</tr>
	<tr>
		<td>Tempat, Tanggal Lahir</td>
		<td><?php echo $tempatLahir.", ".$tanggalLahir;?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td><?php echo $alamat;?></td>
	</tr>
	<tr>
		<td>No. Telp 1</td>
		<td><?php echo $noTelp1;?></td>
	</tr>
	<tr>
		<td>No. Telp 2</td>
		<td><?php echo $noTelp2;?></td>
	</tr>
	<tr>
		<td>Email 1</td>
		<td><?php echo $email1;?></td>
	</tr>
	<tr>
		<td>Email 2</td>
		<td><?php echo $email2;?></td>
	</tr>
	<tr>
		<td>Yahoo Messanger</td>
		<td><?php echo $ym;?></td>
	</tr>
	<tr>
		<td>Facebook</td>
		<td><?php echo $fb;?></td>
	</tr>
	<tr>
		<td>Twitter</td>
		<td><?php echo $twitter;?></td>
	</tr>
</table>
<div id="info-alert">
					
</div>
<a id="btnUpdate" class="btn btn-primary"><i class="icon-pencil icon-white"></i>&nbsp;Update Profile</a>