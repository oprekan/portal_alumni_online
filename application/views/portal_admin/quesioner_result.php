<head>
	<base href="<?php echo base_url(); ?>">
	<base src="<?php echo base_url(); ?>">
	<meta charset="utf-8">
	<title>jQuery UI Dialog - Modal message</title>
	<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
	<!--<script src="../../jquery-1.7.2.js"></script>-->
	<!---<script src="../../external/jquery.bgiframe-2.1.2.js"></script>-->
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.mouse.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.button.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.draggable.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.position.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.resizable.js"></script>
	<script src="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/ui/jquery.ui.dialog.js"></script>
	
	<style>
		table
		{
		border-collapse:collapse;
		}
		table, td, th
		{
		border:1px solid grey;
		}
	</style>

	<script>
	$(document).ready(function(){
		$("#dialog-message").dialog({
			autoOpen: false,
			modal: true,
			height: 400,
			width: 800,
			buttons: {
				Ok: function() {
					$(this).dialog("close");
				}
			}
		});
		$('.showDialog').click(function(){
			var idHref = this.id;
			idHref = idHref.split('_');
			var tipe_id = idHref[1];
			var question_id = idHref[2];
			$('.table')[0].innerHTML = "<div align='center' style='padding-top:10px;'><img src='portal_assets/img/loading_faddingline.gif' width='25' /><br/>Please wait, generating quesioner result...</img></div>";
			$("#dialog-message").dialog("open");

			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/quesioners/get_comment'
				,data : 'tipe_id='+tipe_id+'&question_id='+question_id
				,success : function (resp) {
					var resp = $.parseJSON(resp);
					var data = resp.data;
					var len = resp.data.length;
					var table = '<table style="width:100%"><tr><td align="center" sytle="width:80%;"><b>Komentar</b></td></tr></tr>'
					
					for(i=0; i<len; i++){
						table += '<tr>';
						table +='<td>'+data[i].komentar+'</td>';
						table += '</tr>';
					}
					table += '</table>';
					$('.table')[0].innerHTML = table;
					// $("#dialog-message").dialog("open");
				}
			});
			
			
		});
	});
	
	</script>
</head>
<div id="dialog-message" title="Comment List">
	<div class="table">
	</div>
</div>
	<?php
		foreach ($question as $row1) {
			echo "<article class='module width_full'>";
			echo "<header><h3>".$row1['variable']."</h3></header>";
			echo "<table style='width:100%;border-collapse:collapse;'>
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
					echo "<td style='width:10%;text-align:center;'>".$row2['sts']."</td>";
					echo "<td style='width:10%;text-align:center;'>".$row2['ts']."</td>";
					echo "<td style='width:10%;text-align:center;'>".$row2['cs']."</td>";
					echo "<td style='width:10%;text-align:center;'>".$row2['s']."</td>";
					echo "<td style='width:10%;text-align:center;'>".$row2['ss']."</td>";
					echo "</tr>";
				} else if ($row2['tipe_id'] == "K") {
					echo "<tr>";
					echo "<td style='width:50%'>".$row2['question']."</td>";
					echo "<td colspan='4' rowspan='1'>Total Komentar -> ".$row2['total_komentar']." <a id='link_".$row2['tipe_id']."_".$row2['question_id']."' class='showDialog' href='javascript:void(0);'>Lihat Komentar</a></td>";
					echo "</tr>";
				} else if ($row2['tipe_id'] == "RK") {
					echo "<tr>
					  <td colspan='1' rowspan='2' style='width:50%'>".$row2['question']."</td>
					  <td style='width:10%;text-align:center;'>".$row2['sts']."</td>
					  <td style='width:10%;text-align:center;'>".$row2['ts']."</td>
					  <td style='width:10%;text-align:center;'>".$row2['cs']."</td>
					  <td style='width:10%;text-align:center;'>".$row2['s']."</td>
					  <td style='width:10%;text-align:center;'>".$row2['ss']."</td>
					</tr>
					<tr>
					  <td colspan='4' rowspan='1'>Kendala / Saran : <br> Total Komentar -> ".$row2['total_komentar']." <a id='link_".$row2['tipe_id']."_".$row2['question_id']."' class='showDialog' href='javascript:void(0);'>Lihat Komentar</a></td>
					</tr>";

					// echo "<tr>";
					// echo "<td style='width:50%'>".$row2['question']."</td>";
					// echo "<td colspan='4' rowspan='1'><textarea class='input-xlarge' id='comment' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>";
					// echo "</tr>";
				}
				
			}
			echo "</table>";
			echo "</article>";
		}
	?>
