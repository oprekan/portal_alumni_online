<base href="<?php echo base_url(); ?>">
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-structure.css" type="text/css" media="screen" />
<link rel="stylesheet" href="portal_assets/admin/css/css_form/formee-style.css" type="text/css" media="screen" />

<script type="text/javascript">
	$(document).ready(function(){
		$('#kategori').focus();
		
		// -- Func. Ajax saving
		function ajaxSave (kategori,hiddenId) {
			//$("#validation").html('<img src="./images/webadmin/icon/load.gif"/> Saving..');
			//$(".alert_error").replaceWith("<h4 class='alert_info'>Saving</h4>");
			alertInfo = $(".alert_info");
			console.log(kategori);
			if (alertInfo.length == 0) {
				$(".alert_error").replaceWith("<h4 class='alert_info'>Please Wait, Saving data...</h4>");
			} else {
				$(".alert_info").html("Please Wait, Saving data...");
			}
			
			$.ajax({
				type : 'POST'
				,url : 'index.php/portal_admin/kategori_organisasi/save_process'
				,data : 'kategori='+kategori+'&hidden_id='+hiddenId
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
						window.location = 'index.php/portal_admin/kategori_organisasi';
						
					} else {
						$(".alert_info").replaceWith("<h4 class='alert_error'>"+resp+"</h4>");
						return false;
					}
					
				}
			});
		}
		
		function checkAlertInfo (alertInfoLen,msg) {
			if (alertInfoLen == 0) {
				$(".alert_error").replaceWith("<h4 class='alert_error'>"+msg+"</h4>");
			} else {
				$(".alert_info").replaceWith("<h4 class='alert_error'>"+msg+"</h4>");
			}
		}
		
		$('#submit').click(function(){
			var kategori = $('#kategori').val();
			var hiddenId = $('#hidden_id').val();
			var alertInfo = $(".alert_info");
			if (kategori == "") {
				checkAlertInfo(alertInfo.length, "Please fill required field");
				$("#kategori").addClass("formee-error");
				$('#kategori').focus();
			} else {
				$("#kategori").removeClass("formee-error");
				ajaxSave(kategori,hiddenId);
			}
		});
	});
</script>
<article class="module width_full">
<?php
	$id = "";
	$kategori = "";
	
	if(isset($data)){
		foreach ($data as $row) {
			$id = $row['id'];
			$kategori = $row['kategori'];
		}
	}
?>

</article>

<article class="module width_full">
	<header><h3>Kategori Organisasi Management</h3></header>
	<div class="module_content">
	<div class="formee">
        <div class="grid-12-12">
               <label>Kategori <em class="formee-req">*</em></label>
				<input type='text' name='kategori' id="kategori" style="width:92%;" value="<?php echo $kategori;?>"> <input type='hidden' name='hidden_id' id='hidden_id' value="<?php echo $id;?>">
        </div>
        <div class="grid-12-12">
               <input class="left" id="submit" type="submit" title="send" value="Send" />
               <input class="left" type="button" title="cancel" value="Cancel" onclick='self.history.back()' />
        </div>
   </div>
   </div>
</article><!-- end of post new article -->
