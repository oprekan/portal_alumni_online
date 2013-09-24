<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Admin Panel | Portal Alumni</title>
	<base href="<?php echo base_url(); ?>">
	<base src="<?php echo base_url(); ?>">
	<link rel="stylesheet" href="portal_assets/admin/css/layout.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="portal_assets/admin/js/flexigrid/css/flexigrid.pack.css" />
	<link rel="stylesheet" href="portal_assets/admin/js/flexigrid/css/icon.css" />
	<link rel="stylesheet" href="portal_assets/admin/js/jquery-ui-1.8.22/development-bundle/themes/base/jquery.ui.all.css">
	
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="portal_assets/admin/js/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="portal_assets/admin/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="portal_assets/admin/js/hideshow.js" type="text/javascript"></script>
	<script src="portal_assets/admin/js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="portal_assets/admin/js/jquery.equalHeight.js"></script>
	<script type="text/javascript" src="portal_assets/admin/js/flexigrid/js/flexigrid.pack.js"></script>
	<script type="text/javascript">
	var baseHref = '<?php echo base_url(); ?>';
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>

</head>


<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.html">IA Politel</a></h1>
			<h2 class="section_title">{title}</h2><div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div>
			}
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<?php $this->load->view('portal_admin/template/breadcumbs',$breadcumbs=null); ?>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<?php $this->load->view('portal_admin/template/sidebar'); ?>
	</aside><!-- end of sidebar -->
	
	<section id="main" class="column">
		<h4 class="<?php if(isset($alert)){echo $alert;}else{echo "alert_info";}?>">{information_message}</h4>
		<?php $this->load->view('portal_admin/'.$page); ?>
	</section>


</body>

</html>