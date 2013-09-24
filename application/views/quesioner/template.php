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
	<link rel="shortcut icon" href="portal_assets/frontend/img/favicon.ico">
	 <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="portal_assets/admin/js/jquery-1.7.2.min.js"></script>
    <script src="portal_assets/bootstrap/js/bootstrap.min.js"></script>
	
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
       <a class="brand" href="../">IAP - Online Quesioner (Beta)</a>
       <div class="nav-collapse" id="main-menu">
			<ul class="nav">
				<li class="active"><a href="quesioners">Home</a></li>
			</ul>
			<ul class="nav pull-right">
				<li class="divider-vertical"></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nama;?> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="profiles/">Update Profile</a></li>
					<li class="divider"></li>
					<li><a href="login/logout">Log Out</a></li>
				  </ul>
				</li>
			</ul>
       </div>
     </div>
   </div>
 </div>
	
	
	<div class="container">
		<?php $this->load->view($page); ?>
	<br><br><br><br>

     <!-- Footer
      ================================================== -->
      <footer class="footer">
        <div align="center">Supported by Divisi TIK IA Politel</div>
      </footer>

    </div><!-- /container -->
</body>
</html>
