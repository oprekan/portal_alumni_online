<base href="<?php echo base_url(); ?>">
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-structure.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-style.css" type="text/css" media="screen" />

<script type="text/javascript">
	$(document).ready(function(){
		$('#username').focus();
		
		// -- Func. Ajax saving
		function ajaxSave (username,nama,email,password,level,blokir,hiddenId) {
			//$("#validation").html('<img src="./images/webadmin/icon/load.gif"/> Saving..');
			//$(".alert_error").replaceWith("<h4 class='alert_info'>Saving</h4>");
			alertInfo = $(".alert_info");
			if (alertInfo.length == 0) {
				$(".alert_error").replaceWith("<h4 class='alert_info'>Please Wait, Saving data...</h4>");
			} else {
				$(".alert_info").html("Please Wait, Saving data...");
			}
			
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/admin/save_process'
				,data : 'username='+username+'&nama='+nama+'&email='+email+'&password='+password+'&level='+level+'&blokir='+blokir+'&hidden_id='+hiddenId
				,success : function (resp) {
					if (resp == "success") {
						var info = $(".alert_info");
						var error = $(".alert_error");
						if (info.length != 0) {
							$(".alert_info").replaceWith("<h4 class='alert_success'>Data has been saved</h4>");
						} 
						else if (error.length != 0){
							$(".alert_error").replaceWith("<h4 class='alert_success'>Data has been saved</h4>");
						}
						window.location = 'index.php/portal_admin/admin/manage_admin';
						
					} else {
						$(".alert_info").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						return false;
					}
					
				}
			});
		}
		
		// -- Func. Check email
		function checkEmail() {
			var email = document.getElementById('email');
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return filter.test(email.value);
			
			// if (!filter.test(email.value)) {
				// alert('Please provide a valid email address');
				// email.focus;
				// return false;
			// }
		}
		
		function checkAlertInfo (alertInfoLen,msg) {
			console.log(alertInfoLen);
			if (alertInfoLen == 0) {
				$(".alert_error").replaceWith("<h4 class='alert_error'>"+msg+"</h4>");
			} else {
				$(".alert_info").replaceWith("<h4 class='alert_error'>"+msg+"</h4>");
			}
		}
		
		$('#submit').click(function(){
			var username = $('#username').val();
			var nama = $('#nama').val();
			var email = $('#email').val();
			var password = $('#password').val();
			var level = $('#level').val();
			var blokir = $('#blokir').val();
			var hiddenId = $('#hidden_id').val();
			emailValidate = checkEmail();
			alertInfo = $(".alert_info");
			
			if (username == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#username").addClass("formee-error");
				$('#username').focus();
			} else if (nama == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#nama").addClass("formee-error");
				$('#nama').focus();
			} else if (email == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#email").addClass("formee-error");
				$('#email').focus();
			} else if (!emailValidate) {
				checkAlertInfo(alertInfo.length, "Email address is not valid");
				$("#email").addClass("formee-error");
				$('#email').focus();
			} 
			// else if (password == "") {
				// checkAlertInfo(alertInfo.length, "Please fill required field");
				// $('#password').focus();
			// } 
			else if (level == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#level").addClass("formee-error");
				$('#level').focus();
			} else if (blokir == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#blokir").addClass("formee-error");
				$('#blokir').focus();
			} else {
				$("#username").removeClass("formee-error");
				$("#nama").removeClass("formee-error");
				$("#email").removeClass("formee-error");
				$("#level").removeClass("formee-error");
				$("#blokir").removeClass("formee-error");
				
				ajaxSave(username,nama,email,password,level,blokir,hiddenId);
			}
		});
	});
</script>
<article class="module width_full">
<?php
	$id = "";
	$username = "";
	$nama_lengkap = "";
	$level = "";
	$blokir = "";
	$email = "";
	if(isset($data)){
		foreach ($data as $row) {
			$id = $row['id'];
			$username = $row['username'];
			$nama_lengkap = $row['nama_lengkap'];
			$level = $row['level_id'];
			$blokir = $row['blokir'];
			$email = $row['email'];
		}
	}
	
	$cmb_data = array();
	if(isset($combo_level)){
		foreach ($combo_level as $cmb) {
			$cmb_data[$cmb['id_level']] = $cmb['level'];
		}
	}
	
	$cmb_blokir = array(
		'N' => 'No',
		'Y' => 'Yes'
	);
?>

</article>

<article class="module width_full">
	<header><h3>Administrator Management</h3></header>
	<div class="module_content">
	<div class="formee">
        <div class="grid-12-12">
               <label>Username <em class="formee-req">*</em></label>
				<input type='text' name='username' id="username" style="width:92%;" value="<?php echo $username;?>"> <input type='hidden' name='hidden_id' id='hidden_id' value="<?php echo $id;?>">
        </div>
        <div class="grid-12-12">
               <label>Nama <em class="formee-req">*</em></label>
				<input type='text' name='nama' id="nama" style="width:92%;"  value="<?php echo $nama_lengkap;?>">
        </div>
        <div class="grid-12-12">
                <label>Email <em class="formee-req">*</em></label>
				<input type='text' name='email' id="email" style="width:92%;" value="<?php echo $email;?>">
        </div>
        <div class="grid-12-12">
                <label>Password <em class="formee-req">*</em></label>
				<input type='text' name='password' id="password" style="width:92%;" >
        </div>
        <div class="grid-12-12">
                 <label>Level <em class="formee-req">*</em></label>
				<?php echo form_dropdown('level', $cmb_data, $level,'id="level"  style="width:92%;"'); ?>
        </div>
        <div class="grid-12-12">
                <label>Blokir <em class="formee-req">*</em></label>
				<?php echo form_dropdown('blokir', $cmb_blokir, $blokir,'id="blokir" style="width:92%;"'); ?>
        </div>
        <div class="grid-12-12">
               <input class="left" id="submit" type="submit" title="send" value="Send" />
               <input class="left" type="button" title="cancel" value="Cancel" onclick='self.history.back()' />
        </div>
   </div>
   </div>
</article><!-- end of post new article -->
