<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>IAP - Online Quesioner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<base href="<?php echo base_url(); ?>">
	<base src="<?php echo base_url(); ?>">
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="portal_assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="portal_assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="portal_assets/bootstrap/css/docs.css" rel="stylesheet">
	
	 <script type="text/javascript">
		function activateText(radio,textareaId) {
			var textarea = document.getElementById(textareaId);
			if (radio.value == 'sts' || radio.value == 'ts') {
				textarea.disabled = false;
			} else {
				textarea.disabled = true;
				textarea.value = null;
			}
		}
/*
	   var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-23019901-1']);
		  _gaq.push(['_setDomainName', "bootswatch.com"]);
  		  _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);

	   (function() {
	     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	   })();
*/
	 </script>

  </head>
	
  <body class="preview" data-spy="scroll" data-target=".subnav" data-offset="50">

  <!-- Navbar
    ================================================== -->
 <div class="navbar navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="../">IAP - Online Quesioner (Alpha)</a>
       <div class="nav-collapse" id="main-menu">
			<ul class="nav">
				<li class="active"><a href="#">Home</a></li>
			</ul>
			<ul class="nav pull-right">
				<li class="divider-vertical"></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nama;?> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="#">Update Profile</a></li>
					<li class="divider"></li>
					<li><a href="index.php/login/logout">Log Out</a></li>
				  </ul>
				</li>
			</ul>
       </div>
     </div>
   </div>
 </div>
	
	<section id="forms">
		<div class="container">
			<h4>Welcome <?php echo $nama;?></h4>
			<div class="well">
				<table class="table table-bordered table-striped" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<td width="10%"><img src="portal_assets/frontend/img/yagi.jpg" height="150" width="100"/></td>
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
			<h4>Quesioner Form</h4>
			<div align="left">
			<table class='table table-bordered table-striped' style='width:40%;'>
			  <tbody>
				<tr>
					<td colspan="2" rowspan="1"><b>Legend Information</b></td>
				</tr>
				<tr>
				  <td style='width:35%'>STS : Sangat Tidak Setuju</td>
				  <td style='width:35%'>S : Setuju</td>
				</tr>
				<tr>
				  <td>TS : Tidak Setuju</td>
				  <td>SS : Sangat Setuju</td>
				</tr>
			  </tbody>
			</table>
			</div>
			<!---<form id='quesionerForm' action="index.php/quesioners/save" method="post">-->
			<form id='quesionerForm' method="post">
			<?php
				foreach ($question as $row1) {
					//echo "<h3>".$row1['variable']."</h3>";
					echo "<table class='table table-bordered table-striped'>
						<tr>
							<td style='text-align:center;'><b>Pertanyaan</b></td>
							<td style='text-align:center;'><b>STS</b></td>
							<td style='text-align:center;'><b>TS</b></td>
							<td style='text-align:center;'><b>S</b></td>
							<td style='text-align:center;'><b>SS</b></td>
						</tr>";
					foreach ($row1['question'] as $row2) {
						if ($row2['tipe_id'] == "R") {
							echo "<tr>";
							echo "<td style='width:60%;'><label class='control-label' for='inputError'>".$row2['question']."</label></td>";
							echo "<td id='".$row2['tipe_id']."-".$row2['question_id']."' style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' class='regular-radio' type='radio' value='sts' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ts' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='s' /></td>";
							echo "<td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ss' /></td>";
							echo "</tr>";
						} else if ($row2['tipe_id'] == "K") {
							echo "<tr>";
							echo "<td style='width:50%'>".$row2['question']."</td>";
							echo "<td colspan='4' rowspan='1'><textarea name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' class='input-xlarge' id='comment' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>";
							echo "</tr>";
						} else if ($row2['tipe_id'] == "RK") {
							echo "<tr>
							  <td colspan='1' rowspan='2' style='width:50%'>".$row2['question']."</td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='sts'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ts'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='s'/></td>
							  <td style='width:10%;text-align:center;'><input name='jawab[".$row2['tipe_id']."-".$row2['question_id']."]' type='radio' value='ss'/></td>
							</tr>
							<tr>
							  <td colspan='4' rowspan='1'>Kendala / Saran :<textarea id='".$row2['tipe_id']."-".$row2['question_id']."-komen"."' name='jawab[".$row2['tipe_id']."-".$row2['question_id']."-komen"."]' rows='3' style='width:97%;margin-bottom:0;'></textarea></td>
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
		</div>
	</section>

<br><br><br><br>

     <!-- Footer
      ================================================== -->
      <footer class="footer">
        <div align="center">Supported by Divisi TIK IA Politel</div>
      </footer>

    </div><!-- /container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="portal_assets/admin/js/jquery-1.7.2.min.js"></script>
    <script src="portal_assets/bootstrap/js/bootstrap.min.js"></script>
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
				infoAlert.innerHTML = '<img src="portal_assets/icons/loading_faddingline.gif" width="25" /> Please wait, while sending your answers...';
				$.ajax({
					type : 'POST'
					,url : 'index.php/quesioners/save'
					,data : $('#quesionerForm').serializeArray()
					,success : function (resp) {
						resp = $.parseJSON(resp);
						fields = resp.field;
						msg = resp.msg;
						status = resp.status;
						
						console.log(resp.status);
						if (resp.status == 'false') {
							buttonSend[0].disabled = false;
							infoAlert.innerHTML = errorAlert(resp.msg);
						} else {
							buttonSend[0].disabled = false;
							infoAlert.innerHTML = successAlert(resp.msg);
							quesionerDiv.innerHTML = "<center><h4>Feedback anda telah kami terima, terima kasih untuk partispasinya</h4></center>"
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
</body>
</html>
