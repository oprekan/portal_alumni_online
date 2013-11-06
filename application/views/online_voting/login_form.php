<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Online Voting - Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<base href="<?php echo base_url(); ?>">
		<base src="<?php echo base_url(); ?>">
		<link href="portal_assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="portal_assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="portal_assets/css/login_style.css" rel="stylesheet">
		
		<script src="portal_assets/admin/js/jquery-1.7.2.min.js"></script>
		<script src="portal_assets/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				function ajaxLogin () {
					var username = $('#username').val();
					var pass = $('#password').val();
					var infoAlert = $('#info-alert')[0];
					infoAlert.innerHTML = 'Processing...';
					$.ajax({
						type : 'POST'
						,url : 'login_voting/cek_login'
						,data : 'username='+username+'&password='+pass
						,success : function (resp) {
							var resp = $.parseJSON(resp);
							if (resp.status == false) {
								infoAlert.innerHTML = '<div class="alert alert-error">'+resp.msg+'</div>';
							} else {
								//window.location = 'online_voting/';
								window.location = 'pre_voting/';
							}
						}
					});
				}
				
				$('#password').bind('keypress', function(e){
					if (e.keyCode == 13) {
						ajaxLogin();
					}
					
				});
		
				$('#btnLogin').click(function(){
					var username = $('#username').val();
					var pass = $('#password').val();
					var infoAlert = $('#info-alert')[0];
					
					if (username == "" || pass == "") {
						infoAlert.innerHTML = '<div class="alert alert-error">Please fill mandatory field</div>';
						$('#username').focus();
					} else if (pass == "") {
						infoAlert.innerHTML = '<div class="alert alert-error">Please fill mandatory field</div>';
						$('#password').focus();
					} else {
						ajaxLogin();
					}
				});
			});
		</script>
		<link rel="shortcut icon" href="portal_assets/frontend/img/favicon.ico">
		<style>
			input.span5, textarea.span5, .uneditable-input.span5 {
				width: 390px;
			}
		</style>
	</head>
	<body>
<div id="login">
<div id="logo">
<br/>
</a></div>
<div class="block center login small">
<div class="block_head">
<div class="bheadl"></div>
<div class="bheadr"></div>
<h2>
Quesioner - Login
</h2>

</div>
<div class="block_content">
	<div style="clear:both"></div>
   <!-- BEGIN LOGIN -->
	<div id="login_wrap">   
			<fieldset id="body">
					<fieldset>
						<label for="email">Username</label>
							<div class="control">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-user"></i></span><input class="span5" placeholder="Username" type="text" name="username" id="username">
								</div>
							</div>
					</fieldset>
					<fieldset>
						<label for="password">Password</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-lock"></i></span><input class="span5" placeholder="Password" type="password" name="password" id="password">
								</div>
							</div>
					</fieldset>
			</fieldset>
			<br/>
			<div align="right">
				<div id="info-alert">
					
				</div>
				<input class="btn btn-primary" name="btnLogin" type="button" id="btnLogin" value="Log in">
			</div>
			<br/>
			</div>
			
			</div>
		</div>
  </div>
		<!-- END LOGIN -->
</div>
<div class="bendl"></div>
<div class="bendr"></div>

</div>

</div>
<p class="ac">
<small>
Supported by Divisi TIK IA Politel
<br>
</small>
</p>
</li></ul></div>
		
	</body>
</html>