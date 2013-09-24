<!DOCTYPE HTML>
<html>
<head>
<title>Administrator Login</title>
<base href="<?php echo base_url(); ?>">
<base src="<?php echo base_url(); ?>">
<meta charset="UTF-8" />
<meta name="Designer" content="PremiumPixels.com">
<meta name="Author" content="$hekh@r d-Ziner, CSSJUNTION.com">
<base href="<?php echo base_url(); ?>">
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
<link rel="stylesheet" href="portal_assets/admin/css/login_style.css">

<script src="portal_assets/admin/js/jquery-1.7.2.min.js" type="text/javascript"></script>
</head>
<script type="text/javascript">
	$(document).ready(function(){
		$('#username').focus();
		// Ajax for Login
		function ajaxLogin () {
			var username = $('#username').val();
			var password = $('#password').val();
			alertInfo = $(".information-box");
			if (alertInfo.length == 0) {
				$('#status').removeClass("error-box");
				$('#status').removeClass("round");
				$("#status").addClass("information-box");
				$("#status").html("Authentication Checking...");
			} else {
				$("#status").addClass("information-box");
				$("#status").css('display','block');
				$("#status").html("Authentication Checking...");
			}
			
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/admin/login'
				,data : 'username='+username+'&password='+password
				,success : function (resp) {
					if (resp == "success") {
						window.location = 'portal_admin/admin/';
					} else {
						$('#status').removeClass("information-box");
						$('#status').addClass("error-box round");
						$('#status').html(resp).show().fadeOut(3000);
					}
					
				}
			});
		}
	
		$('#submit').click(function(){
			ajaxLogin();
		});
		
		$('#password').bind('keypress', function(e){
			if (e.keyCode == 13) {
				ajaxLogin();
			}
			
		});
	});
</script>

<body>
<!-- TOP BAR -->
<div id="top-bar">
	
	<div class="page-full-width">
	
		<a href="#" class="round button dark ic-left-arrow image-left ">Return to website</a>

	</div> <!-- end full-width -->	

</div> <!-- end top-bar -->
<!-- HEADER -->
<div id="header">
	<div class="page-full-width cf">
		<!-- Change this image to your own company's logo -->
		<!-- The logo will automatically be resized to 39px height. -->
		<a href="#" id="company-branding" class="fr"><img src="portal_assets/admin/images/IAP.png" alt="Blue Hosting" /></a>
		<div id="login-intro" class="fl">
			<h1>Login to CMS</h1>
			<h5>Enter your credentials below</h5>
		</div> <!-- login-intro -->
	</div> <!-- end full-width -->	
</div> <!-- end header -->



<!-- MAIN CONTENT -->
<div id="content">

	<form action="#" method="POST" id="login-form">
	
		<fieldset>

			<p>
				<label for="login-username">username</label>
				<input type="text" id="username" name="username" class="round full-width-input" autofocus />
			</p>

			<p>
				<label for="login-password">password</label>
				<input type="password" id="password" name="password" class="round full-width-input" />
			</p>
			
			<p>I've <a href="#">forgotten my password</a>.</p>
			
			<div id="submit" class="button round blue image-right ic-right-arrow" style="cursor:pointer;">LOG IN</div>

		</fieldset>

		<br/><div id="status"></div>

	</form>
	
</div> <!-- end content -->



<!-- FOOTER -->
<div id="footer">

	<p>&copy; Copyright 2012 <a href="#">IA Politel</a>. All rights reserved.</p>
	<p>Theme by <a href="http://www.adipurdila.com">Adi Purdila</a></p>
</div> <!-- end footer -->
</body>
</html>
